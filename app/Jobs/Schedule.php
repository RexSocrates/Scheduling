<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// 演算法用的model
use App\User;
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;

// 導入排班資料的客製化物件
use App\CustomClass\OnReservation;
use App\CustomClass\OffReservation;
use App\CustomClass\Doctor;
use App\CustomClass\Month;

// 導入演算法的客製化物件
use App\CustomClass\ClassTable;

class Schedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 排班資料
    private $onRes;
    private $offRes;
    private $doctors;
    private $monthInfo;
    
    // 有預設值
    public $year = 0; // 年份
    public $month = 0; // 月份
    public $days = 0; // 一個月天數
    public $first_day_of_month = 0; // 第一天為星期幾
    public $schedule = []; // 放整個物件班表的List
    public $x = 0; // 迴圈起始值
    public $generation = 0; // 想要跑的代數
    public $doctor_list = []; // 放所有醫生的list
    public $order_list = []; // 放排班順序的list(淡水夜班->台北夜班->淡水假日->台北假日->淡水白班->台北白班)
    public $all_parent_list = []; // 用來放所有染色體的母代
    public $all_parent_fitness_list = []; // 用來存放all_parent_list的fitness
    public $all_child_list = []; // 用來放所有交配後的子代
    public $all_child_fitness_list = []; // 用來存放all_child_list的fitness
    public $mutation_list = []; // 用來放突變後的母代
    public $mutation_fitness_list = []; // 用來存放mutation的fitness
    public $chromosome_amount = 0; // 看使用者要多少張chromosome
    public $count = 0; // 計找了幾次醫生次用
    public $copy_parent_list = []; // 用來放複製的母代
    public $off_class_list = []; // 用來存預OFF班的List
    public $on_class_list = []; // 用來存預ON班的List
    public $run_again = False; // 用來判斷表格是否有空格
    public $switch = 1; // 讓while一定要跑一次(取代do-while)的方法
    public $cross_over_rate = 0.8; // 交配率
    public $mutation_rate = 0.06; // 突變率
    public $cross_over_amount = 0; // cross_over後應該產生子代的數量
    public $mutation_amount = 0; // mutation後應該產生的數量
    public $all_fitness_list = []; // 用來存放菁英法時全部的fitness
    public $best_chromosome_list = []; // 用來存放當代的所有精英chromosome
    public $the_best_chromosome = []; // 用來存放最好的染色體
    public $the_best_chromosome_fitness = 0; // 用來存放最好的染色體的fitness值
    public $holiday_order_list = []; // 用來存放holiday的排班順序
    public $copy_pre_schedule = []; // 用來存放放置的完成預班的班表
    public $copy_pre_doctor_list = []; // 用來存放放置的完成預班的醫生列表
    public $each_generation_fit_avg = []; // 用來存放每一代fitness的平均值
    public $each_best_generation_fit = []; // 用來存放每一代最好的fitness
    public $each_best_generation_chromosome = []; // 用來存放每一代最好的chomosome
    public $elite_rate = 0.5; // 菁英法保留%數
    public $last_chromosome_list = []; // 用來存剩下的chromosome
    
    
    // 在方法中出現的全域變數
    public $class_id = 0;
    public $holiday = 0;
    public $section = '';
    public $class_sort = '';
    public $hospital_area = '';
    public $reservation = false;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 準備演算法需要的資料
        $this->onRes = $this->getOnReservation();
        $this->offRes = $this->getOffReservation();
        $this->doctors = $this->getDoctorsInfo();
        $this->monthInfo = $this->getWeeksOfMonth();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 輸入一些參數
        $this->userInput($this->monthInfo);
        
        // 依據需要的chromosome_amount建立表
        for($i = 0; $i < chromosome_amount; $i++) {
            $switch = 1;
            while($run_again == true or $switch == 1) {
                // 是否重跑的開關
                $run_again = false;
                
                // 建立班表
                build_all_class_table();
                
                // 建立醫生
                creat_doctor();
                
                // 建立預off 班表
                creat_off_class_list();
                pre_off_class();
                
                // 建立預ON班表
                creat_on_class_list();
                pre_on_class();
            }
        }
    }
    
    // ==================  排班用  ==================
    
    // 輸入一些參數
    public function userInput($monthInfo) {
        
        // 設定月份參數
        $year = $monthInfo->year;
        $month = $monthInfo->month;
        $days = $monthInfo->days;
        $first_day_of_month = $monthInfo->firstDay;
        
        // 設定基因演算法參數
        $chromosome_amount = 50;
        $generation = 100;
        
        cross_over_amount = intval(intval(chromosome_amount) * cross_over_rate) * 2;
        mutation_amount = intval(intval(chromosome_amount)*mutation_rate);
    }
    
    //  建立班表
    public function build_all_class_table() {
        // 初始化 schedule
        $schedule = [];
        
        // 計算班表中該天為該月的第幾個星期
        $week_num = 1;
        
        // 建立班表list，填入正確的year 與 month
        for($x = 0; $x < $days * 19; $x++) {
            // 判別為幾號 (date)
            $date = intval($x / 19) + 1;
            
            // 判別為星期幾 (day)
            $day =  (intval((x % (19*7)) / 19) + intval(first_day_of_month)) % 7;
            
            // 判別class_id  10 = 白斑種數
            if($x % 19 < 10) {
                $class_id = intval($x / 19) * 2 - 1 + 2;
            }else {
                $class_id = intval($x / 19) * 2 + 2;
            }
            
            // 判別是否為假日(holiday) 1=假日
            if($day == 6 or $day == 0) {
                $holiday = 1;
            }else {
                $holiday = 0;
            }
            
            // 判別為何種科別,內科 = medical , 外科 = surgical
            if((x % 19) == 4 or (x % 19) == 5 or (x % 19) == 8 or (x % 19) == 9 or (x % 19) == 14 or (x % 19) == 15 or (x % 19) == 18) {
                $section = 'sur';
            }else {
                $section = 'med';
            }
            
            // 判別班別，白班 = day , 晚班 = night
            if($x % 19 < 10) {
                $class_sort = 'd';
            }else {
                $class_sort = 'n';
            }
            
            // 判別院區，台北院區 = T , 淡水院區 = D
            if(($x % 19 < 6) or ((9 < $x % 19) and ($x % 19) < 16)) {
                $hospital_area = 'T';
            }else {
                $hospital_area = 'D';
            }
            
            // 判別該天為該月第幾個星期
            if($x != 0 and $day == 1 and ($x+1) % 19 == 1) {
                $week_num = $week_num + 1;
            }
            
            // 是否為預班，預設False
            $reservation = false;
            
            array_push($schedule, new ClassTable($year, $month, $date, $day, $class_id, $holiday, $section, $class_sort, $hospital_area, $week_num, $reservation));
        }
    }
    
    // 建立醫生
    public function creat_doctor() {
        $doctor_list = $this->doctors;
    }
    
    // 建立預off 班物件
    public function creat_off_class_list() {
        $off_class_list = $this->offRes;
    }
    
    // 預OFF班(將schedule中的offc屬性加入醫生)
    public function pre_off_class() {
        for($i = 0; $i < count($off_class_list); $i++) {
            for($j = 0; $j < count($schedule); $j++) {
                if($off_class_list[$i]->day == $schedule[$j]->date) {
                    // 如果兩邊的日期影match 則將預off 班的醫生加入
                    $schedule[$j]->offc = $off_class_list[$i]->doctorsID;
                }
            }
        }
    }
    
    // 建立預on班表
    public function creat_on_class_list() {
        // 初始化預on班表
        $on_class_list = [];
        
        $on_class_list = $this->onRes;
    }
    
    // 將預ON班的醫師排入
    public function pre_on_class() {
        for($i = 0; $i < count($on_class_list); $i++) {
            // 台北白班
            if($on_class_list[$i]->location == 'T' and $on_class_list[$i]->dayOrNight == 'd') {
                // 內外科需求為4人:2人，x為內科需求，y為外科需求，X為預班醫師的內科人數，Y為預班醫師的外科人數
                $x = 4;
                $y = 2;
                $X = 0;
                $Y = 0;
                
                // 計算預班的醫師有幾個內科幾個外科,用List去接醫生的專職科別後再去計算
                $doctor_ex_list = [];
                $med_list = [];
                $sur_list = [];
                $all_list = [];
                
                for($j = 0; $j < count($doctor_list); $j++) {
                    for($k = 0; $k < count($on_class_list[i]->doctorsID); $k++) {
                        // 取出單一預班的單一醫師編號
                        if($doctor_list[$j]->doctorID == $on_class_list[i]->doctorsID[$k]) {
                            array_push($doctor_ex_list, $doctor_list[$j]->major);
                            
                            // 將不同專職的的醫師id複製到各別的list中
                            if($doctor_list[$j]->major == 'med') {
                                array_push($med_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'sur') {
                                array_push($sur_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'all'){
                                array_push($all_list, $doctor_list[$j]->doctorID);
                            }
                            
                            break;
                        }
                    }
                }
                
                // 計算X、Y
                for($j = 0; $j < count($doctor_ex_list); $j++) {
                    if($doctor_ex_list[$j] == 'all') {
                        $X = $X + 1;
                        $Y = $Y + 1;
                    }else if($doctor_ex_list[$j] == 'med') {
                        $X = $X + 1;
                    }else if($doctor_ex_list[$j] == 'all') {
                        $Y = $Y + 1;
                    }
                }
                
                if($X > $Y) {
                    array_merge($sur_list, $all_list);
                    
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    // 放入外科醫生
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                                
                                // 找出class_table_index
                                $class_table_index = (($on_class_list[$i]->day -1) * 19) + 4 + $j;
                                
                                // 放入醫生
                                pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]); // 501
                            }
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入外科，則要讓他繼續有機會選上外科
                    if(count($sur_list) > $y) {
                        for($j = $y; $j < count($sur_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($sur_list[$j] == $all_list[$k]) {
                                    array_merge($med_list, $all_list[$k]);
                                }
                            }
                        }
                    }
                    
                    // 如果med_list長度少於x，則補上空的物件
                    while(count($med_list) < $x) {
                        $a = '';
                        array_push($med_list, $a);
                    }
                    
                    // 塞入內科醫師
                    for($j = 0; $j < $x; $j++) {
                        // 抓出該醫生在doctor_list中的index和class_table在schedule中的index
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當med_list中抓到的不是空白醫生
                        if($med_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($med_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day - 1) * 19) + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                            
                            // 如果能上綜合的醫生沒有被選入內科，則要讓他繼續有機會選上外科
                            if(count($med_list) > $x) {
                                for($j = $x; $j < count($med_list); $j++) {
                                    for($k = 0; $k < count($all_list); $k++) {
                                        if($med_list[$j] == $all_list[$k]) {
                                            array_merge($sur_list, $all_list[$k]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else if($X <= $Y) {
                    array_merge($med_list, $all_list);
                    
                    while(count($med_list) < $x) {
                        $a = '';
                        array_push($med_list, $a);
                    }
                    
                    // 塞入內科醫師
                    shuffle($med_list);
                    for($j = 0; $j < $x; $j++) {
                        // 抓出該醫生在doctor_list中的index和class_table在schedule中的index
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當med_list中抓到的不是空白醫生
                        if($med_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($med_list[$j] == $doctor_list[$l]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = ($on_class_list[$i]->day - 1) * 19 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list($doctor_index));
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入內科，則要讓他繼續有機會選上外科
                    if(count($med_list) > $x) {
                        for($j = $x; $j < count($med_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($med_list[$j] == $all_list[$k]) {
                                    array_merge($sur_list, $all_list[$k]);
                                }
                            }
                        }
                    }
                    
                    // 放入外科醫生
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $ < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = ($on_class_list[$i]->day - 1) * 19 + 4 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list($doctor_index));
                        }
                    }
                }
                // 當醫生有預班沒被排到，則doctor中的pre_c屬性+1
            }else if($on_class_list[$i]->location == 'T' and $on_class_list[$i]->dayOrNight) {
                // 台北夜班
                
                // 內外科需求為4人:2人，x為內科需求，y為外科需求，X為預班醫師的內科人數，Y為預班醫師的外科人數
                $x = 4;
                $y = 2;
                $X = 0;
                $Y = 0;
                
                // 計算預班的醫師有幾個內科幾個外科,用List去接醫生的專職科別後再去計算
                $doctor_ex_list = [];
                $med_list = [];
                $sur_list = [];
                $all_list = [];
                
                for($j = 0; $j < count($doctor_list); $j++) {
                    for($k = 0; $k < count($on_class_list[$i]->doctorsID); $k++) {
                        if($doctor_list[$j]->doctorID == $on_class_list[$j]->doctorsID[$k]) {
                            array_push($doctor_ex_list, $doctor_list[$j]->major);
                            
                            // 將不同專職的的醫師id複製到各別的list中
                            if($doctor_list[$j]->major == 'med') {
                                array_push($med_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'sur') {
                                array_push($sur_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'all') {
                                array_push($all_list, $doctor_list[$j]->doctorID);
                            }
                            break;
                        }
                    }
                }
                
                for($j = 0; $j < count($doctor_ex_list); $j++) {
                    if($doctor_ex_list[$j] == 'all') {
                        $X = $X + 1;
                        $Y = $Y + 1;
                    }else if($doctor_ex_list[$j] == 'med') {
                        $X = $X + 1;
                    }else if($doctor_ex_list[$j] == 'sur') {
                        $Y = $Y + 1;
                    }
                }
                
                if($X > $Y) {
                    array_merge($sur_list, $all_list);
                    
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    // 放入外科醫生
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day - 1) * 19) + 14 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index],$doctor_list[$doctor_index]);
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入外科，則要讓他繼續有機會選上外科
                    if(count($sur_list) > $y) {
                        for($j = $y; $j < count($sur_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($sur_list[$j] == $all_list[$k]) {
                                    array_merge($med_list, $all_list);
                                }
                            }
                        }
                    }
                    
                    // 如果med_list長度少於x，則補上空的物件
                    while(count($med_list) < $x) {
                        $a = '';
                        array_push($med_list, $a);
                    }
                    
                    // 塞入內科醫師
                    for($j = 0; $j < $x; $j++) {
                        // 抓出該醫生在doctor_list中的index和class_table在schedule中的index
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當med_list中抓到的不是空白醫生
                        if($med_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($med_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[i]->day -1) * 19) + 10 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index],$doctor_list[$doctor_index]);
                        }
                    }
                    
                    //  如果能上綜合的醫生沒有被選入內科，則要讓他繼續有機會選上外科
                    if(count($med_list) > $x) {
                        for($j = $x; $j < count($med_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($med_list[$j] == $all_list[$k]) {
                                    array_merge($sur_list, $all_list[$k]);
                                }
                            }
                        }
                    }
                }else if($X <= $Y) {
                    array_merge($med_list, $all_list);
                    
                    while(count($med_list) < $x) {
                        $a = '';
                        array_push($med_list, $a);
                    }
                    
                    // 塞入內科醫師
                    shuffle($med_list);
                    
                    for($j = 0; $j < $x; $j++) {
                        // 抓出該醫生在doctor_list中的index和class_table在schedule中的index
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當med_list中抓到的不是空白醫生
                        if($med_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($med_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 10 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入內科，則要讓他繼續有機會選上外科
                    if(count($med_list) > $x) {
                        for($j = $x; $j < count($med_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($med_list[$j] == $all_list[$k]) {
                                    array_merge($sur_list, $all_list[$k]);
                                }
                            }
                        }
                    }
                    
                    // 放入外科醫生
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 14 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                }
            }else if($on_class_list[$i]->location == 'D' and $on_class_list[$i]->dayOrNight == 'd') {
                // 淡水白班
                
                // 內外科需求為2人:2人，x為內科需求，y為外科需求，X為預班醫師的內科人數，Y為預班醫師的外科人數
                $x = 2;
                $y = 2;
                $X = 0;
                $Y = 0;
                
                // 計算預班的醫師有幾個內科幾個外科,用List去接醫生的專職科別後再去計算
                $doctor_ex_list = [];
                $med_list = [];
                $sur_list = [];
                $all_list = [];
                
                for($j = 0; $j < count($doctor_list); $j++) {
                    for($k = 0; $k < count($on_class_list[$i]->doctorsID); $k++) {
                        if($doctor_list[$j]->doctorID == $on_class_list[$i]->doctorsID[k]) {
                            array_push($doctor_ex_list, $doctor_list[$j]->major);
                            
                            // 將不同專職的的醫師id複製到各別的list中
                            if($doctor_list[$j]->major == 'med') {
                                array_push($med_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'sur') {
                                array_push($sur_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'all') {
                                array_push($all_list, $doctor_list[$j]->doctorID);
                            }
                            break;
                        }
                    }
                }
                
                for($j = 0; $j < count($doctor_ex_list); $j++) {
                    if($doctor_ex_list[$j] == 'all') {
                        $X = $X + 1;
                        $Y + $Y + 1;
                    }else if($doctor_ex_list[$j] == 'med') {
                        $X = $X + 1;
                    }else if($doctor_ex_list[$j] == 'sur') {
                        $Y + $Y + 1;
                    }
                }
                
                if($X > $Y) {
                    array_merge($sur_list, $all_list);
                    
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    // 放入外科醫生
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 8 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                }
            }else {
                // 淡水夜班
                
                // 內外科需求為2人:1人，x為內科需求，y為外科需求，X為預班醫師的內科人數，Y為預班醫師的外科人數
                $x = 2;
                $y = 1;
                $X = 0;
                $Y = 0;
                
                // 計算預班的醫師有幾個內科幾個外科,用List去接醫生的專職科別後再去計算
                $doctor_ex_list = [];
                $med_list = [];
                $sur_list = [];
                $all_list = [];
                
                for($j = 0; $j < count($doctor_list); $j++) {
                    for($k = 0; $k < count($on_class_list[$i]->doctorsID); $k++) {
                        if($doctor_list[$j]->doctorID == $on_class_list[$i]->doctorsID[$k]) {
                            array_push($doctor_ex_list, $doctor_list[$j]->major);
                            
                            // 將不同專職的的醫師id複製到各別的list中
                            if($doctor_list[$j]->major == 'med') {
                                array_push($med_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'sur') {
                                array_push($sur_list, $doctor_list[$j]->doctorID);
                            }else if($doctor_list[$j]->major == 'all') {
                                array_push($all_list, $doctor_list[$j]->doctorID);
                            }
                            break;
                        }
                    }
                }
                
                for($j = 0; $j < count($doctor_ex_list); $j++) {
                    if($doctor_ex_list[$j] == 'all') {
                        $X = $X + 1;
                        $Y = $Y + 1;
                    }else if($doctor_ex_list[$j] == 'all') {
                        $X = $X + 1;
                    }else if($doctor_ex_list[$j] == 'all') {
                        $Y = $Y + 1;
                    }
                }
                
                if($X > $Y) {
                    array_merge($sur_list, $all_list);
                    
                    while(count($sur_list) < $y) {
                        $a = '';
                        array_push($sur_list, $a);
                    }
                    
                    // 放入外科醫生
                    shuffle($sur_list);
                    
                    for($j = 0; $j < $y; $j++) {
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當sur_list中抓到的不是空白醫生
                        if($sur_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($sur_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 18 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入外科，則要讓他繼續有機會選上外科
                    if(count($sur_list) > $y) {
                        for($j = $y; $j , count($sur_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($sur_list[$j] == $all_list[$k]) {
                                    array_merge($med_list, $all_list[$k]);
                                }
                            }
                        }
                    }
                    
                    // 如果med_list長度少於x，則補上空的物件
                    while(count($med_list) < $x) {
                        $a = '';
                        array_push($med_list, $a);
                    }
                    
                    // 塞入內科醫師
                    for($j = 0; $j < $x; $j++) {
                        // 抓出該醫生在doctor_list中的index和class_table在schedule中的index
                        $class_table_index = 0;
                        $doctor_index = 0;
                        
                        // 當med_list中抓到的不是空白醫生
                        if($med_list[$j] != '') {
                            // 找出doctor_index
                            for($k = 0; $k < count($doctor_list); $k++) {
                                if($med_list[$j] == $doctor_list[$k]->doctorID) {
                                    $doctor_index = $k;
                                }
                            }
                            
                            // 找出class_table_index
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 16 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                    
                    // 如果能上綜合的醫生沒有被選入內科，則要讓他繼續有機會選上外科
                    if(count($med_list) > $x) {
                        for($j = $x; $j < count($med_list); $j++) {
                            for($k = 0; $k < count($all_list); $k++) {
                                if($med_list[$j] == $all_list[$k]) {
                                    array_merge($sur_list, $all_list[$k]); // 992
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function pre_put_doc_in($class_table, $doctor) {
        // 在該班表格中放入該醫師
        $class_table->doctor_id = $doctor->doctorID;
        
        $class_table_property_list = [];
        array_push($class_table_property_list, $class_table->section);
        array_push($class_table_property_list, $class_table->class_sort);
        array_push($class_table_property_list, $class_table->hospital_area);
        
        // 醫生假日班數 -1
        $doctor->weekendShift -= $class_table->holiday;
        
        // 醫師總班數-1
        $doctor->totalShifts = $doctor->totalShifts - 1;
        
        // 預班填入的班表時該格屬性reservation變成True
        $class_table->reservation = true;
        
        // 當醫師不是在職登院區上班時，將該週在非職登院區上班數+1
        if($class_table->hospital_area != $doctor->location) {
            $doctor->otherLocationShifts[$class_table->week_num - 1] += 1;
        }
        
        // 根據表格屬性，將醫生其值扣除
        for($i = 0; $i < count($class_table_property_list); $i++) {
            if($class_table_property_list[$i] == 'med') {
                $doctor->medicalShifts = $doctor->medicalShifts - 1;
            }else if($class_table_property_list[$i] == 'med') {
                $doctor->surgicalShifts = $doctor->surgicalShifts - 1;
            }else if($class_table_property_list[$i] == 'd') {
                $doctor->dayShifts = $doctor->dayShifts - 1;
            }else if($class_table_property_list[$i] == 'n') {
                $doctor->nightShifts = $doctor->nightShifts - 1;
            }else if($class_table_property_list[$i] == 'T') {
                $doctor->taipeiShiftsLimit = $doctor->taipeiShiftsLimit - 1;
            }else if($class_table_property_list[$i] == 'D') {
                $doctor->tamsuiShiftsLimit = $doctor->tamsuiShiftsLimit - 1;
            }
        }
    }
    
    //  ==================  準備資料用  =========================
    
    // 取得演算法使用的on班資訊
    private function getOnReservation() {
        $resObj = new Reservation();
        $docAndResObj = new DoctorAndReservation();
        $shiftCateObj = new ShiftCategory();
        
        $onResList = [];
        
        $reservations = $resObj->getNextMonthOnReservation();
        
        foreach($reservations as $res) {
            // 取得當月的第幾天
            $date = $res->date;
            $day = (int)explode('-', $date)[2];
            
            // 取得院區
            $location = '';
            if($res->location == 'Taipei') {
                $location = 'T';
            }else {
                $location = 'D';
            }
            
            // 取得白天或晚上
            $dayOrNight = '';
            $cateInfo = $shiftCateObj->getCategoryInfo($res->categorySerial);
            if($cateInfo['dayOrNight'] == 'day') {
                $dayOrNight = 'd';
            }else {
                $dayOrNight = 'n';
            }
            
            // 有預約此預班的醫生代號
            $doctorsID = $docAndResObj->getDoctorsByResSerial($res->resSerial);
            $doctorArr = [];
            foreach($doctorsID as $doctorObj) {
                array_push($doctorArr, $doctorObj->doctorID);
            }
            
            array_push($onResList, new OnReservation($day, $location, $dayOrNight, $doctorArr));
        }
        
        return $onResList;
    }
    
    // 取得演算法用的off班資訊
    private function getOffReservation() {
        $resObj = new Reservation();
        $docAndResObj = new DoctorAndReservation();
        
        $offResList = [];
        
        $reservations = $resObj->getNextMonthOffReservation();
        
        foreach($reservations as $res) {
            // 取得當月的第幾天
            $date = $res->date;
            $day = (int)explode('-', $date)[2];
            
            // 有預約此預班的醫生代號
            $doctorsID = $docAndResObj->getDoctorsByResSerial($res->resSerial);
            $doctorArr = [];
            foreach($doctorsID as $doctorObj) {
                array_push($doctorArr, $doctorObj->doctorID);
            }
            
            array_push($offResList, new OffReservation($day, $doctorArr));
        }
        
        return $offResList;
    }
    
    // 取得演算法用的醫生資訊
    private function getDoctorsInfo() {
        $userObj = new User();
        
        $doctors = $userObj->getAtWorkDoctors();
        
        // 演算法用的陣列
        $doctorsList = [];
        $numberOfWeeks = $this->getWeeksOfMonth();
        
        foreach($doctors as $doctor) {
            $doctorDic = [
                'doctorID' => $doctor->doctorID,
                'major' => '',
                'totalShifts' => $doctor->mustOnDutyTotalShifts,
                'dayShifts' => $doctor->mustOnDutyDayShifts,
                'nightShifts' => $doctor->mustOnDutyNightShifts,
                'weekendShifts' => $doctor->weekendShifts,
                'location' => '',
                'taipeiShiftsLimit' => 0,
                'tamsuiShiftsLimit' => 0,
                'surgicalShifts' => $doctor->mustOnDutySurgicalShifts,
                'medicalShifts' => $doctor->mustOnDutyMedicalShifts,
                'numberOfWeeks' => $numberOfWeeks
            ];
            
            // 專職科別
            if($doctor->major == 'All') {
                $doctorDic['major'] = 'all';
            }else if($doctor->major == 'Medical') {
                $doctorDic['major'] = 'med';
            }else {
                $doctorDic['major'] = 'sur';
            }
            
            // 職登院區與各院區上班班數上限
            if($doctor->location == '台北') {
                $doctorDic['location'] = 'T';
                $doctorDic['taipeiShiftsLimit'] = $doctor->mustOnDutyTotalShifts;
                $doctorDic['tamsuiShiftsLimit'] = (int)($doctor->mustOnDutyTotalShifts * 0.5);
            }else {
                $doctorDic['location'] = 'D';
                $doctorDic['tamsuiShiftsLimit'] = $doctor->mustOnDutyTotalShifts;
                $doctorDic['taipeiShiftsLimit'] = (int)($doctor->mustOnDutyTotalShifts * 0.5);
            }
            
            // 扣除自己的測試醫生帳號
            if($doctor->doctorID != 1) {
                array_push($doctorsList, new Doctor($doctorDic));
            }
        }
        
        return $doctorsList;
    }
    // 取得排班月資訊
    private function getMonthInfo() {
        
        $currentDateStr = date('Y-m-d');
        $dateArr = explode('-', $currentDateStr);
        
        // 將年與月轉換為數字
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        // 調整至排班的月份
        $month = ($month + 1) % 12;
        if($month == 1) {
            $year += 1;
        }
        
        // 計算當月有幾天，取得排班次月第一日後往前推一天
        $theMonthAfter = ($month + 1) % 12;
        $nextMonthFirstDay = '';
        if($theMonthAfter == 1) {
            $nextMonthFirstDay = ($year + 1).'-'.$theMonthAfter.'-01';
        }else {
            $nextMonthFirstDay = $year.'-'.$theMonthAfter.'-01';
        }
        
        $lastDayOfMonth = date('Y-m-d', strtotime($nextMonthFirstDay.'-1 day'));
        
        $daysOfMonth = (int)(explode('-', $lastDayOfMonth)[2]);
        
        // 取得1號是星期幾
        $firstDay = date('N', strtotime($year.'-'.$month.'-01'));
        
        return new Month($year, $month, $daysOfMonth, $firstDay);
    }
    
    // 計算排班當月有幾週
    private function getWeeksOfMonth() {
        $currentDateStr = date('Y-m-d');
        $dateArr = explode('-', $currentDateStr);
        
        // 將年與月轉換為數字
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        // 調整至排班的月份
        $month = ($month + 1) % 12;
        if($month == 1) {
            $year += 1;
        }
        
        // 計算當月有幾天，取得排班次月第一日後往前推一天
        $theMonthAfter = ($month + 1) % 12;
        $nextMonthFirstDay = '';
        if($theMonthAfter == 1) {
            $nextMonthFirstDay = ($year + 1).'-'.$theMonthAfter.'-01';
        }else {
            $nextMonthFirstDay = $year.'-'.$theMonthAfter.'-01';
        }
        
        $lastDayOfMonth = date('Y-m-d', strtotime($nextMonthFirstDay.'-1 day'));
        $daysOfMonth = (int)(explode('-', $lastDayOfMonth)[2]);
        
        
        $numberOfWeeks = 0;
        $weekStart = true;
        for($i = 1; $i <= $daysOfMonth; $i++) {
            $dateStr = '';
            if($i < 10) {
                $dateStr = $year.'-'.$month.'-0'.$i;
            }else {
                $dateStr = $year.'-'.$month.'-'.$i;
            }
            // monday is 1, sunday is 7
            $weekDay = (int)date('N', strtotime($dateStr));
            
            if($weekDay == 7) {
                // 星期天，一週的結束
                $numberOfWeeks++;
                $weekStart = false;
            }
            if($weekDay == 1) {
                // 星期一，一週的開始
                $weekStart = true;
            }
        }
        if($weekStart == true) {
            // 雖然不是完整的一星期，但已涵蓋此一星期
            $numberOfWeeks++;
        }
        
        return $numberOfWeeks;
    }
}
