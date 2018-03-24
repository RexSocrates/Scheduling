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
    public $onRes;
    public $offRes;
    public $doctors;
    public $monthInfo;
    
    // 有預設值
    public $year = 0; // 年份
    public $month = 0; // 月份
    public $days = 0; // 一個月天數
    public $first_day_of_month = 0; // 第一天為星期幾
    public $schedule = []; // 放整個物件班表的List  使用 ClassTable
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
    public $on_class_list = []; // 用來存預ON班的List  onRes
    public $run_again = false; // 用來判斷表格是否有空格
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
        $this->monthInfo = $this->getMonthInfo();
        
        echo 'Prepare data<br>';
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
        echo 'loop start <br>';
        for($i = 0; $i < $this->chromosome_amount; $i++) {
            echo 'Chromosome : '.$i.'<br>';
            
            $switch = 1;
            while($this->run_again == true or $switch == 1) {
                // 是否重跑的開關
                $this->run_again = false;
                
                // 建立班表
                $this->build_all_class_table();
                
                // 建立醫生
                $this->creat_doctor();
                
                // 建立預off 班表
                $this->creat_off_class_list();
                $this->pre_off_class();
                
                // 建立預ON班表
                $this->creat_on_class_list();
                $this->pre_on_class(); // 2483
                
                // 建立填班表順序
                $this->input_order_list($this->schedule);
                
                // 建立假日班填班順序
                $this->input_holiday_order_list($this->schedule); // 2488
                
                // 先將預班完的班表和醫生列表複製起來
                // 取代 deep copy
                $this->copy_pre_schedule = [];
                foreach($this->schedule as $sch) {
                    array_push($this->copy_pre_schedule, $sch);
                }
                
                $this->copy_pre_doctor_list = [];
                foreach($this->doctor_list as $doctor) {
                    array_push($this->copy_pre_doctor_list, $doctor);
                }
                
                // 先將假日班填完
                $switch_switch = 1;
                $run_run_again = false;
                $doctor_holiday_amount = 0;
                $class_holiday_amount = 0;
                
                // 計算所有醫生的假日班數
                for($j = 0; $j < count($this->doctor_list); $j++) {
                    $doctor_holiday_amount = $doctor_holiday_amount + $this->doctor_list[$j]->weekendShifts;
                }
                
                // 計算表格中的假日班數
                for($j = 0; $j < count($this->schedule); $j++) {
                    if($this->schedule[$j]->holiday == 1 and $this->schedule[$j]->doctor_id) {
                        $class_holiday_amount = $class_holiday_amount + 1; 
                    }
                }
                
                while($run_run_again == true or $switch_switch == 1) {
//                    echo 'run run again : '.$switch_switch.'<br>';
                    $switch_switch = $switch_switch + 1;
                    $run_run_again = false;
                    
                    for($j = 0; $j < count($this->holiday_order_list); $j++) {
                        $this->holiday_rotary_method_doctor($this->schedule, $this->schedule[$this->holiday_order_list[$j]], $this->doctor_list);
                    }
                    
                    if($doctor_holiday_amount < $class_holiday_amount) {
                        $after_hc = 0;
                        for($i = 0; $i < count($this->doctor_list); $i++) {
                            $after_hc = $after_hc + $this->doctor_list[$i]->weekendShifts;
                            if($after_hc != 0) {
                                $run_run_again = true;
                                
                                // 取代 python deep copy
                                $schedule = [];
                                foreach($copy_pre_schedule as $sch) {
                                    array_push($schedule, $sch);
                                }
                                
                                // 取代 python deep copy
                                $doctor_list = [];
                                foreach($copy_pre_doctor_list as $doctor) {
                                    array_push($doctor_list, $doctor);
                                }
                                
                                break;
                            }
                        }
                    }else if($doctor_holiday_amount >= $class_holiday_amount) {
                        for($k = 0; $k < count($this->holiday_order_list); $k++) {
                            if($this->schedule[$this->holiday_order_list[$k]]->doctor_id == '') {
                                $run_run_again = true;
                                
                                // 取代 python deep copy
                                $this->schedule = [];
                                foreach($this->copy_pre_schedule as $sch) {
                                    array_push($this->schedule, $sch);
                                }
                                
                                // 取代 python deep copy
                                $this->doctor_list = [];
                                foreach($this->copy_pre_doctor_list as $doctor) {
                                    array_push($this->doctor_list, $doctor);
                                }
                                
                                break;
                            }
                        }
                    }
                    
                    // 無窮迴圈很麻煩，方便測試用
//                    if($switch_switch > 100) {
//                        break;
//                    }
                }
                
                // 完成班表(分兩次:第一次較嚴謹、第二次有違反些軟限制)
                $this->finish_schedule($this->schedule, $this->order_list, $this->doctor_list); // 2537
                
                
                for($i = 0; $i < count($this->schedule); $i++) {
                    if($this->schedule[$i]->doctor_id == '') {
                        $this->run_again = true;
                    }
                }
                
                $switch = $switch + 1;
                
                // 產出來的表放入all_parent_list中
                if($this->run_again == false) {
//                    echo 'run again is false<br>';
//                    echo print_r($this->schedule);
                    // 取代deep copy
                    $items = [];
                    foreach($this->schedule as $sch) {
                        array_push($items, $sch);
                    }
                    array_push($this->all_parent_list, $items);
                    break;
                }
                echo 'End of while loop <br>';
            }
        }
        
        for($i = 1; $i < ($this->generation + 1); $i++) {
            echo '====================================<br>';
            echo 'The '.$i.' generation <br>';
            
            // 計算all_parent_list的fitness，使用前必須先重製醫師屬性表
            $all_parent_fitness_list = [];
            for($j = 0; $j < count($this->all_parent_list); $j++) {
                $this->creat_doctor();
                
                // 先計算doctor的pre_c
                $this->count_pre_c($this->all_parent_list[$j], $this->doctor_list);
                array_push($this->all_parent_fitness_list, $this->count_fit($this->all_parent_list[$j], $this->doctor_list)); //python 2568
            }
            
            echo "all parent fitness : ";
            echo print_r($this->all_parent_fitness_list).'<br>';
            
            // 計算平均值並存入each_generation_fit_avg中
            array_push($this->each_generation_fit_avg, round(array_sum($this->all_parent_fitness_list) / count($this->all_parent_fitness_list), 1));
            
            // 交配運算子
            $this->all_child_list = [];
            for($j = 0; $j < intval($this->cross_over_amount / 2); $j++) {
                // python 2578
                $this->cross_over($this->all_parent_list);
            }
            
            echo 'I am here';
            
            // 突變運算子
            $this->mutation_list = [];
            for($j = 0; $j < $mutation_amount; $j++) {
                mutation($all_parent_list, $doctor_list);
            }
            
            // 修正交配後的班表
            for($j = 0; $j < count($all_child_list); $j++) {
                $this->creat_doctor();
                $mutation_list[$j] = revise($mutation_list[$j], $doctor_list); // python 2593
            }
            
            // 計算all_child_list的fitness，使用前必須先重製醫師屬性表
            $this->all_child_fitness_list = [];
            for($j = 0; $j < count($all_child_list); $j++) {
                $this->creat_doctor();
                
                // 先計算doctor的pre_c
                count_pre_c($all_child_list[$j], $doctor_list);
                
                // 取代deep copy 對integer用deep copy到底有什麼用啦！！
                array_push($all_child_fitness_list, count_fit($all_child_list[$j], $doctor_list));
            }
            
            echo "all child fitness : ";
            echo print_r($all_child_fitness_list);
            
            // 計算mutation_list的fitness，使用前必須先重製醫師屬性表
            $this->mutation_fitness_list = [];
            for($j = 0; $j < count($mutation_list); $j++) {
                $this->creat_doctor();
                
                // 先計算doctor的pre_c
                count_pre_c($mutation_list[$j], $doctor_list);
                
                // 取代deep copy 對integer用deep copy到底有什麼用啦！！
                array_push($mutation_fitness_list, count_fit($mutation_list[$j], $doctor_list));
            }
            
            echo 'mutation fitness : ';
            echo print_r($mutation_fitness_list);
            
            // 將all_parent_fitness_list、all_child_fitness_list、mutation_fitness_list合併到all_fitness_list
            $this->all_fitness_list = [];
            array_merge($all_fitness_list, $all_parent_fitness_list);
            array_merge($all_fitness_list, $all_child_fitness_list);
            array_merge($all_fitness_list, $mutation_fitness_list);
            
            // 將all_fitness_list中的fitness由小到大排序
            // 取代quicksort
            sort($all_fitness_list); // python 2622
            echo 'all fitness and sort : ';
            echo print_r($all_fitness_list);
            
            // 將最好的染色體fitness值先取出來
            // 取代deep copy，什麼東西都用deep copy 就好了啊，對一個本來就是call by value的東西用deep copy到底有個屁用啦!!
            $the_best_chromosome_fitness = $all_fitness_list[0];
            
            
            // 將排序過的all_fitness_list中，第chromosome_amount個fitness記錄下來
            $best_fitness_index = 0;
            $best_fitness_index = intval($elite_rate * $chromosome_amount);
            $best_fitness_index = $all_fitness_list[$best_fitness_index - 1];
            echo '第10個的fit:';
            echo $best_fitness_index;
            
            // 從all_parent_fitness_list、all_child_fitness_list、mutation_fitness_list中找出菁英並放入best_chromosome_list中
            $best_chromosome_list = [];
            
            // 從all_parent_list中挑選fitness比best_fitness_index小的菁英
            $a = [];
            for($j = 0; $j < count($all_parent_fitness_list); $j++) {
                if($all_parent_fitness_list[$j] <= $best_fitness_index) {
                    // 取代deep copy
                    array_push($best_chromosome_list, $all_parent_list[$j]);
                }else {
                    // 取代deep copy
                    array_push($a, $all_parent_list[$j]);
                }
            }
            
            // 取代deep copy
            $all_parent_list = [];
            foreach($a as $item) {
                array_push($all_parent_list, $item);
            }
            
            // 從all_child_list中挑選fitness比best_fitness_index小的菁英
            $a = [];
            for($j = 0; $j , count($all_child_fitness_list); $j++) {
                if($all_child_fitness_list[$j] <= $best_fitness_index) {
                    // 取代deep copy
                    array_push($best_chromosome_list, $all_child_list[$j]);
                }else {
                    // 取代deep copy
                    array_push($a, $all_child_list[$j]);
                }
            }
            
            // 取代deep copy
            $all_child_list = [];
            foreach($a as $item) {
                array_push($all_child_list, $item);
            }
            
            // 從mutation_list中挑選fitness比best_fitness_index小的菁英 python 2657
            $a = [];
            for($j = 0; $j < count($mutation_fitness_list); $j++) {
                if($mutation_fitness_list[$j] <= $best_fitness_index) {
                    // 取代deep copy
                    array_push($best_chromosome_list, $mutation_list[$j]);
                }else {
                    // 取代deep copy
                    array_push($a, $mutation_list[$j]);
                }
            }
            
            // 取代deep copy
            $mutation_list = [];
            foreach($a as $item) {
                array_push($mutation_list, $item);
            }
            
            // 計算best_chromosome_list中的fitness
            $best_chromosome_fitness_list = [];
            for($j = 0; $j < count($best_chromosome_list); $j++) {
                $this->creat_doctor();
                // 先計算doctor的pre_c
                count_pre_c($best_chromosome_list[$j], $doctor_list);
                
                // 取代deep copy，這邊還是對integer 用deep copy
                array_push($best_chromosome_fitness_list, count_fit($best_chromosome_list[$j], $doctor_list));
            }
            
            echo '選完前50%的fitness:';
            echo print_r($best_chromosome_fitness_list);
            
            // 將最好的chromosome複製給the_best_chromosome
            $the_best_chromosome = [];
            for($j = 0; $j < count($best_chromosome_fitness_list); $j++) {
                if($best_chromosome_fitness_list[$j] == $the_best_chromosome_fitness) {
                    // 取代deep copy
                    array_push($the_best_chromosome, $best_chromosome_list[$j]);
                    
                    // 取代deep copy
                    array_push($each_best_generation_chromosome, $best_chromosome_list[$j]);
                    break;
                }
            }
            
            // 當best_chromosome_list數量超過chromosome_amount必須扣除
            for($k = 0; $k < count($best_chromosome_list) - intval($chromosome_amount * $elite_rate); $k++) {
                for($j = 0; $j < count($best_chromosome_fitness_list); $j++) {
                    if($best_chromosome_fitness_list[$j] == $best_fitness_index) {
                        // del 使用 unset() 取代
                        unset($best_chromosome_fitness_list[$j]);
                        unset($best_chromosome_list[$j]);
                        break;
                    }
                }
            }
            
            // 把剩下的chromosome放入last_chromosome_list中
            $last_chromosome_list = [];
            for($j = 0; $j < count($all_parent_list); $j++) {
                // 取代deep copy
                array_push(last_chromosome_list, $all_parent_list[$j]); // python 2695
            }
            
            for($j = 0; $j < count($all_child_list); $j++) {
                // 取代deep copy
                array_push($last_chromosome_list, $all_child_list[$j]);
            }
            
            for($j = 0; $j < count($mutation_list); $j++) {
                // 取代deep copy
                array_push($last_chromosome_list, $mutation_list[$j]);
            }
            
            // 從剩下的chromosome_list中隨機挑出需要的個數
            $index = [];
            
            // index 要用的list
            $list = [];
            for($listIndex = 0; $listIndex < count($last_chromosome_list); $listIndex++) {
                array_push($list, $listIndex);
            }
            // list 可能會有問題
            $index = array_rand($list, $chromosome_amount - count($best_chromosome_list));
            // 為什麼這邊不直接用index的長度??
            for($j = 0; $j < $chromosome_amount - count($best_chromosome_list); $j++) {
                // 取代deep copy
                array_push($best_chromosome_list, $last_chromosome_list[$index[$j]]);
            }
            
            // 計算best_chromosome_list中的fitness
            $best_chromosome_fitness_list = [];
            for($j = 0; $j < count($best_chromosome_list); $j++) {
                $this->creat_doctor();
                // 先計算doctor的pre_c
                count_pre_c($best_chromosome_list[$j], $doctor_list);
                // 取代deep copy
                array_push($best_chromosome_fitness_list, count_fit($best_chromosome_list[$j], $doctor_list));
            }
            
            echo 'all best chromosome fitness : ';
            echo print_r($best_chromosome_fitness_list).'<br>';
            
//            echo 'chrosome list <br>';
//            echo print_r($best_chromosome_list);
            
            
            // 取代deep copy
            $all_parent_list = [];
            foreach($best_chromosome_list as $chromosome) {
//                echo 'chromosome : '.$chromosome.'<br>';
                array_push($this->all_parent_list, $cthis->hromosome);
            }
            
            echo 'The best schedule:';
            print_schedule($this->the_best_chromosome[0]); // python 2724
            $this->creat_doctor();
            
            // 先計算doctor的pre_c
            count_pre_c($this->the_best_chromosome[0], $this->doctor_list);
            $this->the_best_chromosome = count_fit($this->the_best_chromosome[0], $this->doctor_list);
            echo 'The best schedule fitness:';
            echo print_r($this->the_best_chromosome);
            echo '====================================';
        }
        
        // 印出每一代平均
//        echo 'average:';
//        echo print_r($each_generation_fit_avg);
        
        // 印出第一代最好的班表
        echo 'the first generation schedule================================<br>';
//        $this->print_schedule($this->each_best_generation_chromosome[0]);
        echo print_r($this->each_best_generation_chromosome).'<br>';
        echo 'the first generation schedule================================<br>';
        
        // 印出每一代最好的fitness
        echo 'each_best_generation_chromosome: ';
        for($x = 0; $x < count($this->each_best_generation_chromosome); $x++) {
            $this->creat_doctor();
            // 先計算doctor的pre_c
            count_pre_c($this->each_best_generation_chromosome[$x], $this->doctor_list);
            array_push($this->each_best_generation_fit, count_fit($this->each_best_generation_chromosome[$x], $this->doctor_list));
        }
        echo print_r($this->each_best_generation_fit).'<br>';
    }
    
    // ==================  排班用  ==================
    
    // 輸入一些參數
    public function userInput($monthInfo) {
        echo 'user input<br>';
        
        // 設定月份參數
        $this->year = $monthInfo->year;
        $this->month = $monthInfo->month;
        $this->days = $monthInfo->daysOfMonth;
        $this->first_day_of_month = $monthInfo->firstDay;
        
        // 設定基因演算法參數
        $this->chromosome_amount = 10;
        $this->generation = 1;
        
        $this->cross_over_amount = intval(intval($this->chromosome_amount) * $this->cross_over_rate) * 2;
        $this->mutation_amount = intval(intval($this->chromosome_amount) * $this->mutation_rate);
    }
    
    //  建立班表
    public function build_all_class_table() {
        // 初始化 schedule
        $this->schedule = [];
        
        // 計算班表中該天為該月的第幾個星期
        $week_num = 1;
        
        // 建立班表list，填入正確的year 與 month
        for($x = 0; $x < $this->days * 19; $x++) {
            // 判別為幾號 (date)
            $date = intval($x / 19) + 1;
            
            // 判別為星期幾 (day)
            $day =  (intval(($x % (19*7)) / 19) + intval($this->first_day_of_month)) % 7;
            
            // 判別class_id  10 = 白斑種數
            if($x % 19 < 10) {
                $this->class_id = intval($x / 19) * 2 - 1 + 2;
            }else {
                $this->class_id = intval($x / 19) * 2 + 2;
            }
            
            // 判別是否為假日(holiday) 1=假日
            if($day == 6 or $day == 0) {
                $this->holiday = 1;
            }else {
                $this->holiday = 0;
            }
            
            // 判別為何種科別,內科 = medical , 外科 = surgical
            if(($x % 19) == 4 or ($x % 19) == 5 or ($x % 19) == 8 or ($x % 19) == 9 or ($x % 19) == 14 or ($x % 19) == 15 or ($x % 19) == 18) {
                $this->section = 'sur';
            }else {
                $this->section = 'med';
            }
            
            // 判別班別，白班 = day , 晚班 = night
            if($x % 19 < 10) {
                $this->class_sort = 'd';
            }else {
                $this->class_sort = 'n';
            }
            
            // 判別院區，台北院區 = T , 淡水院區 = D
            if(($x % 19 < 6) or ((9 < $x % 19) and ($x % 19) < 16)) {
                $this->hospital_area = 'T';
            }else {
                $this->hospital_area = 'D';
            }
            
            // 判別該天為該月第幾個星期
            if($x != 0 and $day == 1 and ($x+1) % 19 == 1) {
                $week_num = $week_num + 1;
            }
            
            // 是否為預班，預設False
            $this->reservation = false;
            
            array_push($this->schedule, new ClassTable($this->year, $this->month, $date, $day, $this->class_id, $this->holiday, $this->section, $this->class_sort, '', $this->hospital_area, [], $week_num, $this->reservation));
        }
    }
    
    // 建立醫生
    public function creat_doctor() {
        $this->doctor_list = $this->doctors;
    }
    
    // 建立預off 班物件
    public function creat_off_class_list() {
        $off_class_list = $this->offRes;
    }
    
    // 預OFF班(將schedule中的offc屬性加入醫生)
    public function pre_off_class() {
        for($i = 0; $i < count($this->off_class_list); $i++) {
            for($j = 0; $j < count($this->schedule); $j++) {
                if($this->off_class_list[$i]->day == $this->schedule[$j]->date) {
                    // 如果兩邊的日期影match 則將預off 班的醫生加入
                    $this->schedule[$j]->offc = $this->off_class_list[$i]->doctorsID;
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
        for($i = 0; $i < count($this->on_class_list); $i++) {
            // 台北白班
            if($this->on_class_list[$i]->location == 'T' and $this->on_class_list[$i]->dayOrNight == 'd') {
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
                
                for($j = 0; $j < count($this->doctor_list); $j++) {
                    for($k = 0; $k < count($othis->n_class_list[i]->doctorsID); $k++) {
                        // 取出單一預班的單一醫師編號
                        if($this->doctor_list[$j]->doctorID == $this->on_class_list[i]->doctorsID[$k]) {
                            array_push($doctor_ex_list, $this->doctor_list[$j]->major);
                            
                            // 將不同專職的的醫師id複製到各別的list中
                            if($this->doctor_list[$j]->major == 'med') {
                                array_push($med_list, $this->doctor_list[$j]->doctorID);
                            }else if($this->doctor_list[$j]->major == 'sur') {
                                array_push($sur_list, $this->doctor_list[$j]->doctorID);
                            }else if($this->doctor_list[$j]->major == 'all'){
                                array_push($all_list, $this->doctor_list[$j]->doctorID);
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
                            for($k = 0; $k < count($doctor_list); $k++) {
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
                            $class_table_index = (($on_class_list[$i]->day -1) * 19) + 18 + $j;
                            
                            // 放入醫生
                            pre_put_doc_in($schedule[$class_table_index], $doctor_list[$doctor_index]);
                        }
                    }
                }
            }
        }
    }
    
    // 當醫生預班成功將醫師放入班表
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
    
    // 建立排班順序的index
    public function input_order_list($schedule) {
        // 淡水夜班先排
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->hospital_area == 'D' and $schedule[$i]->class_sort == 'n') {
                array_push($this->order_list, $i);
            }
        }
        
        // 再排台北夜班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->hospital_area == 'T' and $schedule[$i]->class_sort == 'n') {
                array_push($this->order_list, $i);
            }
        }
        
        // 再排淡水假日班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->holiday == 1 and $schedule[$i]->hospital_area == 'D' and $schedule[$i]->class_sort == 'd') {
                array_push($this->order_list, $i);
            }
        }
        
        // 再排台北假日班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->holiday == 1 and $schedule[$i]->hospital_area == 'T' and $schedule[$i]->class_sort == 'd') {
                array_push($this->order_list, $i);
            }
        }
        
        // 再排淡水白班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->holiday == 0 and $schedule[$i]->hospital_area == 'D' and $schedule[$i]->class_sort == 'd') {
                array_push($this->order_list, $i);
            }
        }
        
        // 再排台北白班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->holiday == 0 and $schedule[$i]->hospital_area == 'T' and $schedule[$i]->class_sort == 'd') {
                array_push($this->order_list, $i);
            }
        }
    }
    
    // 建立假日班的排班順序
    public function input_holiday_order_list($schedule) {
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->holiday == 1) {
                // 這是假日班
                array_push($this->holiday_order_list, $i);
            }
        }
    }
    
    // 輪盤法填假日班表
    public function holiday_rotary_method_doctor($schedule, $class_table, $doctor_list) {
        // 選醫生時存放他們暫時fit
        
        $fit_list = [];
        $check = 0;
        $check2 = 0;
        $this->count = 0;
        
//        echo 'class table<br>';
//        echo print_r($class_table).'<br>';
        
        while($check == 0) {
//            echo 'Check : '.$check.'<br>';
            
            if($class_table->doctor_id != '') {
                break;
            }
            
            if($class_table->doctor_id == '' and $this->count < 300) {
                // 班表屬性為以下
                if($class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule, $class_table, $doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $this->count += 1;
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule, $class_table, $doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table, $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $this->count += 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }
            }else {
                break;
            }
        }
    }
    
    // 輪盤法選醫師填入班表
    public function rotary_method($fit_list) {
        $rand_num = rand(1, array_sum($fit_list));
        $sum1 = 0;
        
        for($i = 0; $i < count($fit_list); $i++) {
            $sum1 = $sum1 + $fit_list[$i];
            if($sum1 >= $rand_num) {
                return $i;
            }
        }
    }
    
    // 檢查硬限制H3、H4、H5
    public function check_doc($class_table, $doctor) {
        // boolean值 true為可填入班表，false則不可填入
        $result = true;
        
//        echo 'week num <br>';
//        echo print_r($class_table);
        
        // 當班表的科別與醫生的專職科別不合，則該醫師不能填入
        if($doctor->major != 'all' and $class_table->section != $doctor->major) {
            $result = false;
        }
        
        // 檢查醫生是否還有白班或夜班可上
        if($result == true and ($class_table->class_sort == 'n' and $doctor->dayShifts == 0)) {
            $result = false;
        }else if($result == true and ($class_table->class_sort == 'n' and $doctor->nightShifts == 0)) {
            $result = false;
        }
        
        // 檢查醫生是否還有內科斑或外科班可上
        if($result == true and ($class_table->section == 'med' and $doctor->medicalShifts == 0)) {
            $result = false;
        }else if($result == true and ($class_table->section == 'sur' and $doctor->surgicalShifts == 0)) {
            $result = false;
        }
        
        // 如果當天預OFF班則不填入
        if($result == true) {
            for($i = 0; $i < count($class_table->offc); $i++) {
                if($doctor->doctorID == $class_table->offc[$i]) {
                    $result = false;
                    break;
                }
            }
        }
        
        // 檢查醫師總班數是否小於0
        if($result == true and $doctor->totalShifts <= 0) {
            $result = false;
        }
        
        // 檢查是否為假日班，是的話檢查醫生是否還有假日班可上
        if($result == true and $class_table->holiday == 1) {
            if($doctor->weekendShifts == 0) {
                $result == false;
            }
        }
        
        // 當班表院區與醫師職登院區不同時，需先檢查醫師是否還有非職登院區的班可上，再檢查同一周是否有支援超過兩班
        if($result == true and $class_table->hospital_area != $doctor->location) {
            if($class_table->hospital_area == 'T' and $doctor->taipeiShiftsLimit == 0) {
                $result = false;
            }else if($class_table->hospital_area == 'D' and $doctor->taipeiShiftsLimit == 0) {
                $result = false;
            }
            
            if($result == true and $doctor->otherLocationShifts[$class_table->week_num - 1] == 2) {
                $result = false;
            }
        }
        
        // 如果醫生在當天預OFF班就不填入
        for($i = 0; $i < count($class_table->offc); $i++) {
            if($result = true and $doctor->doctorID == $class_table->offc[$i]) {
                $result = false;
            }
        }
        
        return $result;
    }
    
    // 檢查同時間是否有相同醫生、檢查上一班、下一班是否有相同醫生(H1、H2)
    public function check_doc_class($schedule, $class_table, $doctor) {
        $result = true;
        
        if($class_table->class_id == 1) {
            for($i = 0; $i < 19; $i++) {
                if($schedule[$i]->doctor_id == $doctor->doctorID) {
                    $result = false;
                }
            }
        }else if($class_table->class_id == $schedule[count($schedule) - 1]->class_id) {
            for($i = (intval($schedule[count($schedule) - 1]->class_id / 2) - 1) * 19; $i < 19 * intval(($schedule[count($schedule) - 1]->class_id) / 2); $i++) {
                if($schedule[$i]->doctor_id == $doctor->doctorID) {
                    $result = false;
                }
            }
        }else if($class_table->class_id % 2 == 1 and $class_table->class_id != 1) {
            for($i = intval($class_table->class_id / 2) * 19 - 9; $i < (intval($class_table->class_id / 2) + 1) * 19; $i++) {
                if($schedule[$i]->doctor_id == $doctor->doctorID) {
                    $result = false;
                }
            }
        }else if($class_table->class_id % 2 == 0 and $class_table->class_id != $schedule[count($schedule) - 1]->class_id) {
            for($i = (intval($class_table->class_id / 2) - 1) * 19; $i < (intval($class_table->class_id / 2) * 19) + 11; $i++) {
                if($schedule[$i]->doctor_id == $doctor->doctorID) {
                    $result = false;
                }
            }
        }
        
        return $result;
    }
    
    // 當醫生成功填入班表時所作的處理
    public function put_doc_in($class_table , $doctor) {
        // 在該班表格中放入該醫師
        $class_table->doctor_id = $doctor->doctorID;
        
        $class_table_property_list = [];
        array_push($class_table_property_list, $class_table->section);
        array_push($class_table_property_list, $class_table->class_sort);
        array_push($class_table_property_list, $class_table->hospital_area);
        
        // 醫生假日班數-1
        $doctor->weekendShifts -= $class_table->holiday;
        // 醫師總班數-1
        $doctor->totalShifts = $doctor->totalShifts - 1;
        
        // 當醫師不是在職登院區上班時，將該週在非職登院區上班數+1
        if($class_table->hospital_area != $doctor->location) {
            $doctor->otherLocationShifts[$class_table->week_num - 1] += 1;
        }
        
        // 根據表格屬性，將醫生其值扣除
        for($i = 0; $i < count($class_table_property_list); $i++) {
            if($class_table_property_list[$i] == 'med') {
                $doctor->medicalShifts = $doctor->medicalShifts - 1;
            }else if($class_table_property_list[$i] == 'sur') {
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
    
    // 完成這張表
    public function finish_schedule($schedule, $order_list, $doctor_list) {
        for($i = 0; $i < count($schedule); $i++) {
            $this->rotary_method_doctor($schedule, $schedule[$order_list[$i]], $doctor_list);
        }
        
        for($i = 0; $i < count($schedule); $i++) {
            $this->re_rotary_method_doctor($schedule, $schedule[$order_list[$i]], $doctor_list);
        }
    }
    
    // 輪盤法選醫師填入班表
    public function rotary_method_doctor($schedule, $class_table, $doctor_list) {
        // 選醫生時存放他們暫時fit
        $fit_list = [];
        $check = 0;
        $check2 = 0;
        $count = 0;
        
        while($check == 0) {
            if($class_table->doctor_id != '') {
                break;
            }
            if($class_table->doctor_id == '' and $count < 300) {
                // 班表屬性為以下
                if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        // print('01');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('02');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('03');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('04');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('05');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('06');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('07');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('08');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('09');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('10');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('11');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('12');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('13');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('14');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
//                        echo 'check 2 is 0<br>';
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
//                    echo '$doc_index : '.$doc_index.'<br>';
//                    echo 'fit list : <br>';
//                    echo print_r($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('15');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else {
                    $count = $count + 1;
                    if($check2 == 0) {
                        echo 'else<br>';
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table , $doctor_list[$doc_index]) == true) {
                        // print('16');
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }
            }else {
                break;
            }
        }
    }
    
    // 輪盤法選醫師填入班表
    public function re_rotary_method_doctor($schedule, $class_table, $doctor_list) {
        // 選醫生時存放他們暫時fit
        $fit_list = [];
        $check = 0;
        $check2 = 0;
        $count = 0;
        
        while($check == 0) {
            if($class_table->doctor_id != '') {
                break;
            }
            
            if($class_table->doctor_id == '' and $count < 300) {
                // 班表屬性為以下
                if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    // 依此班表屬性去算醫師的適性值，存入fit_list中
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    // 檢查此醫師是否有違反規定
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // 若都無違反則將醫師填入
                        // print('01');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('02');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('03');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('04');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('05');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('06');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('07');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 1 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->weekendShifts + $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('08');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('09');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('10');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('11');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'T') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('12');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'd' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('13');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'sur' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('14');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else if($class_table->holiday == 0 and $class_table->section == 'med' and $class_table->class_sort == 'n' and $class_table->hospital_area == 'D') {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->medicalShifts + $doctor_list[$i]->nightShifts + $doctor_list[$i]->tamsuiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('15');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }else {
                    $count = $count + 1;
                    
                    if($check2 == 0) {
                        for($i = 0; $i < count($doctor_list); $i++) {
                            array_push($fit_list, $doctor_list[$i]->surgicalShifts + $doctor_list[$i]->dayShifts + $doctor_list[$i]->taipeiShiftsLimit);
                        }
                    }
                    
                    $doc_index = $this->rotary_method($fit_list);
                    if($this->re_check_doc($class_table, $doctor_list[$doc_index]) == true and $this->check_doc_class($schedule ,$class_table ,$doctor_list[$doc_index]) == true) {
                        // print('16');
                        
                        $this->put_doc_in($class_table , $doctor_list[$doc_index]);
                        $check = 1;
                    }else {
                        $check2 = 1;
                    }
                }
            }
        }
    }
    
    // 填第二次時要檢查的限制
    public function re_check_doc($class_table, $doctor) {
        // boolean值 true為可填入班表，false則不可填入
        $result = true;
        
        // 檢查醫師總班數是否小於0
        if($result == true and $doctor->totalShifts <= 0) {
            $result = false;
        }
        
        // 當班表和醫師專職科別不同，就不能填
        if($doctor->major != 'all' and $class_table->section != $doctor->major) {
            $result = false;
        }
        
        // 當班表院區與醫師職登院區不同時，需先檢查醫師是否還有非職登院區的班可上，再檢查同一周是否有支援超過兩班
        if($result == true and $class_table->hospital_area != $doctor->location) {
            if($class_table->hospital_area =='T' and $doctor->taipeiShiftsLimit == 0) {
                $result = false;
            }else if($class_table->hospital_area =='D' and $doctor->tamsuiShiftsLimit == 0) {
                $result = false;
            }
            
            if($result == true and $doctor->otherLocationShifts[$class_table->week_num - 1] == 2) {
                $result = false;
            }
        }
        
        return $result;
    }
    
    // 計算預ON醫生是否有上到班
    public function count_pre_c($schedule, $doctor_list) {
        $same = false;
        
        // 有預ON班，卻沒排到的醫生，該醫生pre_c加1
        for($i = 0; $i < count($this->on_class_list); $i++) {
            // 台北白斑時
            if($on_class_list[$i]->location == 'T' and $on_class_list[$i]->dayOrNight = 'd') {
                // 找schedule的index
                $loop_first_index = ($on_class_list[$i]->day - 1) * 19;
                $loop_last_index  = ($on_class_list[$i]->day - 1) * 19 + 6;
                
                // 拿對應schedule上的醫生去和預ON班的醫生去比較，如果預ON班沒上到則pre_c +1(php : lostShfits)
                for($j = 0; $j < count($on_class_list[$i]->doctorsID); $j++) {
                    // 開關，如果沒有想同，該醫生pre_c+1
                    $same = false;
                    for($k = $loop_first_index; $k < $loop_last_index; $k++) {
                        if($schedule[$k]->doctor_id == $on_class_list[$i]->doctorsID[$j]) {
                            $same = true;
                            break;
                        }
                    }
                    
                    if($same == false) {
                        for($l = 0; $l < count($doctor_list); $l++) {
                            if($on_class_list[$i]->doctorsID[$j] == $doctor_list[$l].doctorID) {
                                $doctor_list[$l]->lostShfits = $doctor_list[$l]->lostShfits + 1;
                            }
                        }
                    }
                }
            }else if($on_class_list[$i]->location == 'T' and $on_class_list[$i]->dayOrNight = 'n') {
                // 台北夜班
                $loop_first_index = ($on_class_list[$i]->day - 1) * 19 + 10;
                $loop_last_index  = ($on_class_list[$i]->day - 1) * 19 + 16;
                
                // 拿對應schedule上的醫生去和預ON班的醫生去比較，如果預ON班沒上到則pre_c +1(php : lostShfits)
                for($j = 0; $j < count($on_class_list[$i]->doctorsID); $j++) {
                    // 開關，如果沒有想同，該醫生pre_c+1
                    $same = false;
                    for($k = $loop_first_index; $k < $loop_last_index; $k++) {
                        if($schedule[$k]->doctor_id == $on_class_list[$i]->doctorsID[$j]) {
                            $same = true;
                            break;
                        }
                    }
                    
                    if($same == false) {
                        for($l = 0; $l < count($doctor_list); $l++) {
                            if($on_class_list[$i]->doctorsID[$j] == $doctor_list[$l].doctorID) {
                                $doctor_list[$l]->lostShfits = $doctor_list[$l]->lostShfits + 1;
                            }
                        }
                    }
                }
            }else if($on_class_list[$i]->location == 'D' and $on_class_list[$i]->dayOrNight = 'd') {
                // 淡水白班
                $loop_first_index = ($on_class_list[$i]->day - 1) * 19 + 6;
                $loop_last_index  = ($on_class_list[$i]->day - 1) * 19 + 10;
                
                // 拿對應schedule上的醫生去和預ON班的醫生去比較，如果預ON班沒上到則pre_c +1
                for($j = 0; $j < count($on_class_list[$i]->doctorsID); $j++) {
                    // 開關，如果沒有想同，該醫生pre_c+1
                    $same = false;
                    for($k = $loop_first_index; $k < $loop_last_index; $k++) {
                        if($schedule[$k]->doctor_id == $on_class_list[$i]->doctorsID[$j]) {
                            $same = true;
                            break;
                        }
                    }
                    
                    if($same == false) {
                        for($l = 0; $l < count($doctor_list); $l++) {
                            if($on_class_list[$i]->doctorsID[$j] == $doctor_list[$l].doctorID) {
                                $doctor_list[$l]->lostShfits = $doctor_list[$l]->lostShfits + 1;
                            }
                        }
                    }
                }
            }else {
                // 淡水夜班
                $loop_first_index = ($on_class_list[$i]->day - 1) * 19 + 16;
                $loop_last_index  = ($on_class_list[$i]->day - 1) * 19 + 19;
                
                // 拿對應schedule上的醫生去和預ON班的醫生去比較，如果預ON班沒上到則pre_c +1
                for($j = 0; $j < count($on_class_list[$i]->doctorsID); $j++) {
                    // 開關，如果沒有想同，該醫生pre_c+1
                    $same = false;
                    for($k = $loop_first_index; $k < $loop_last_index; $k++) {
                        if($schedule[$k]->doctor_id == $on_class_list[$i]->doctorsID[$j]) {
                            $same = true;
                            break;
                        }
                    }
                    
                    if($same == false) {
                        for($l = 0; $l < count($doctor_list); $l++) {
                            if($on_class_list[$i]->doctorsID[$j] == $doctor_list[$l].doctorID) {
                                $doctor_list[$l]->lostShfits = $doctor_list[$l]->lostShfits + 1;
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function count_fit($schedule, $doctor_list) {
        // 根據一張完整的排班表，去計算醫生剩下的屬性值
        for($i = 0; $i < count($schedule); $i++) {
            $this->fin_count_doctor_attribute($schedule, $schedule[$i], $doctor_list); // python 2402
        }
        
        // 計算fitness值
        $fitness = 0;
        // 1.先把每位pallc未上的班先加上去
        for($i = 0; $i < count($doctor_list); $i++) {
            $fitness = $fitness + $doctor_list[$i]->totalShifts;
        }
        
        // 2.醫師有預班卻沒排上的加上去(醫師物件中有"pre_c"就是拿來記錄醫師預班卻沒上的次數)
        for($i = 0; $i < count($doctor_list); $i++) {
            $fitness = $fitness + $doctor_list[$i]->lostShfits;
        }
        
        // 3.醫師預當天OFF班，卻排到去上班
        for($i = 0; $i < count($schedule); $i++) {
            for($j = 0; $j < count($schedule[$i]->offc); $j++) {
                if($schedule[$i]->doctor_id == $$schedule[$i]->offc[$j]) {
                    $fitness = $fitness + 1;
                    break;
                }
            }
        }
        
        // 4.若還有剩餘的白夜班也加上去
        for($i = 0; $i < count($doctor_list); $i++) {
            $fitness = $fitness + abs($doctor_list[$i]->dayShifts) + abs($doctor_list[$i]->nightShifts);
        }
        
        // 5.若還有剩餘的內外班也加上去
        for($i = 0; $i < count($doctor_list); $i++) {
            $fitness = $fitness + abs($doctor_list[$i]->medicalShifts) + abs($doctor_list[$i]->surgicalShifts);
        }
        
        return $fitness;
    }
    
    // 進來的表一定要是填完的表
    public function fin_count_doctor_attribute($schedule, $class_table, $doctor_list) {
        // 先抓出醫生index
        $doctor_index = 0;
        if($class_table->doctor_id != '') {
            for($i = 0; $i < count($doctor_list); $i++) {
                if($class_table->doctor_id == $doctor_list[$i]->doctorID) {
                    $doctor_index = $i;
                }
            }
            
            $class_table_property_list = [];
            array_push($class_table_property_list, $class_table->section);
            array_push($class_table_property_list, $class_table->class_sort);
            array_push($class_table_property_list, $class_table->hospital_area);
            
            // 當天為假日班時，醫生假日班數-1
            $doctor_list[$doctor_index]->weekendShifts -= $class_table->holiday;
            
            // 醫生總班數-1
            $doctor_list[$doctor_index]->totalShifts = $doctor_list[$doctor_index]->totalShifts - 1;
            
            // 根據表格屬性，將醫生其值扣除
            for($i = 0; $i < count($class_table_property_list); $i++) {
                if($class_table_property_list[$i] == 'med') {
                    $doctor_list[$doctor_index]->medicalShifts = $doctor_list[$doctor_index]->medicalShifts - 1;
                }else if($class_table_property_list[$i] == 'sur') {
                    $doctor_list[$doctor_index]->surgicalShifts = $doctor_list[$doctor_index]->surgicalShifts - 1;
                }else if($class_table_property_list[$i] == 'd') {
                    $doctor_list[$doctor_index]->dayShifts = $doctor_list[$doctor_index]->dayShifts - 1;
                }else if($class_table_property_list[$i] == 'n') {
                    $doctor_list[$doctor_index]->nightShifts = $doctor_list[$doctor_index]->nightShifts - 1;
                }else if($class_table_property_list[$i] == 'T') {
                    $doctor_list[$doctor_index]->taipeiShiftsLimit = $doctor_list[$doctor_index]->taipeiShiftsLimit - 1;
                }else if($class_table_property_list[$i] == 'D') {
                    $doctor_list[$doctor_index]->tamsuiShiftsLimit = $doctor_list[$doctor_index]->tamsuiShiftsLimit - 1;
                }
            }
            
            // 當在非職登院區上班時，再當週非職登院區班數+1
            if($class_table->hospital_area != $doctor_list[$doctor_index]->location) {
                $doctor_list[$doctor_index]->otherLocationShifts[$class_table->week_num - 1] += 1;
            }
            
        }
    }
    
    // 交配運算子
    public function cross_over($all_parent_list) {
        echo '$all_parent_list<br>';
        echo 'Length : '.count($all_parent_list).'<br>';
        echo print_r($all_parent_list).'<br>';
        
        $crossover_sort = 0;
//        $crossover_sort = rand(0, 2);
        
        // 單日雙點交配
        if($crossover_sort == 0) {
//            echo '單日雙點交配';
            
            // 隨機選兩張表
            $random_parent_index1 = 0;
            $random_parent_index2 = 0;
            $random_day = 0;
            
            // 兩張表不能是同一張且假日要跟假日換，平日要跟平日換
            while($random_parent_index1 == $random_parent_index2) {
                $random_parent_index1 = rand(0, count($all_parent_list) - 1);
                $random_parent_index2 = rand(0, count($all_parent_list) - 1);
                $random_day = rand(0, intval($this->days) - 1);
            }
            
            // 取代 deep copy
            $this->copy_parent_list = [];
            foreach($all_parent_list as $parent) {
                array_push($this->copy_parent_list, $parent);
            }
            
            // =================================下面這一段問題很多=================================
            for($i = $random_day * 19; $i < $random_day * 19 + 19; $i++) {
                // 找到預班的或是假日班則不換則不換 python 2076
                if($this->copy_parent_list[$random_parent_index1][$i]->reservation == false and $this->copy_parent_list[$random_parent_index2][$i]->reservation == false and $this->copy_parent_list[$random_parent_index1][$i]->holiday == 0 and 
                   $this->copy_parent_list[$random_parent_index2][$i]->holiday == 0) {
                    // 取代deep copy
                    $c = [];
                    foreach($this->copy_parent_list[$random_parent_index1][$i] as $parent) {
                        array_push($c, $parent);
                    }
                    
                    // 取代deep copy
                    $this->copy_parent_list[$random_parent_index1][$i] = [];
                    foreach($this->copy_parent_list[$random_parent_index2][$i] as $item) {
                        array_push($this->copy_parent_list[$random_parent_index1][$i], $item);
                    }
                    
                    // 取代deep copy
                    $this->copy_parent_list[$random_parent_index2][$i] = [];
                    foreach($c as $item) {
                        array_push($this->copy_parent_list[$random_parent_index2][$i], $item);
                    }
                }
            }
            
            // 把交配完的子代放入all_child_list
            // 取代deep copy
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index1] as $item) {
                array_push($items, $item);
            }
            array_push($this->all_child_list, $items);
            
            // 取代deep copy
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index2] as $item) {
                array_push($items, $item);
            }
            array_push($this->all_child_list, $items);
            
        }else if($crossover_sort == 1) {
            // 多日雙點
            
            // 隨機選擇兩張表
            $random_parent_index1 = 0;
            $random_parent_index2 = 0;
            
            // 隨機選擇要交配的RANGE範圍
            $random_day1 = 0;
            $random_day2 = 0;
            $a = 0;
            
            while($random_parent_index1 == $random_parent_index2 or $random_day1 == $random_day2) {
                $random_parent_index1 = rand(0, count($all_parent_list) - 1);
                $random_parent_index2 = rand(0, count($all_parent_list) - 1);
                $random_day1 = rand(0, intval($this->days) - 1);
                $random_day2 = rand(0, intval($this->days) - 1);
                
                // 當random_day1比random_day2大時，互相交換
                if($random_day1 > $random_day2) {
                    $a = $random_day1;
                    $random_day1 = $random_day2;
                    $random_day2 = $a;
                }
            }
            
            // 取代deep copy
            foreach($all_parent_list as $parent) {
                array_push($this->copy_parent_list, $parent);
            }
            
            for($i = $random_day1 * 19; $i < $random_day2 * 19 + 19; $i++) {
                if($this->copy_parent_list[$random_parent_index1][$i]->reservation == false and $this->copy_parent_list[$random_parent_index2][$i]->reservation == false and $this->copy_parent_list[$random_parent_index1][$i]->holiday == 0 and 
                   $this->copy_parent_list[$random_parent_index2][$i]->holiday == 0) {
                    $c = [];
                    foreach($this->copy_parent_list[$random_parent_index1][$i] as $parent) {
                        array_push($c, $parent);
                    }
                    
                    // 取代deep copy
                    $this->copy_parent_list[$random_parent_index1][$i] = [];
                    foreach($this->copy_parent_list[$random_parent_index2][$i] as $item) {
                        array_push($this->copy_parent_list[$random_parent_index1][$i], $item);
                    }
                    
                    // 取代deep copy
                    $this->copy_parent_list[$random_parent_index2][$i] = [];
                    foreach($c as $item) {
                        array_push($this->copy_parent_list[$random_parent_index2][$i], $item);
                    }
                }
            }
            
            // 把交配完的子代放入all_child_list
            // 取代deep copy
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index1] as $item) {
                array_push($items, $item);
            }
            array_push($all_child_list, $items);
            
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index2] as $item) {
                array_push($items, $item);
            }
            array_push($all_child_list, $items);
            
        }else {
            // 建立mask，裡面是0和1，0不交換，1則交換
            $mask = [];
            for($i = 0; $i < intval($this->days); $i++) {
                $random_num = rand(0, 1);
                array_push($mask, $random_num);
            }
            
            $random_parent_index1 = 0;
            $random_parent_index2 = 0;
            
            // 兩張表不能是同一張且假日要跟假日換，平日要跟平日換
            while($random_parent_index1 == $random_parent_index2) {
                $random_parent_index1 = rand(0, count($all_parent_list) - 1);
                $random_parent_index2 = rand(0, count($all_parent_list) - 1);
            }
            
            // 取代deep copy
            $this->copy_parent_list = [];
            foreach($all_parent_list as $parent) {
                array_push($this->copy_parent_list, $parent);
            }
            
            for($i = 0; $i < count($mask); $i++) {
                for($j = $i * 19; $j < $i * 19 + 19; $j++) {
                    if($this->copy_parent_list[$random_parent_index1][$j]->reservation == false and $this->copy_parent_list[$random_parent_index2][$j]->reservation == false and $mask[$i] == 1 and $this->copy_parent_list[$random_parent_index1][$j]->holiday == 0 and $this->copy_parent_list[$random_parent_index2][$j]->holiday == 0) {
                        // 取代deep copy
                        $c = [];
                        foreach($this->copy_parent_list[$random_parent_index1][$j] as $item) {
                            array_push($c, $item);
                        }
                        
                        // 取代deep copy
                        $this->copy_parent_list[$random_parent_index1][$j] = [];
                        foreach($this->copy_parent_list[$random_parent_index2][$j] as $item) {
                            array_push($this->copy_parent_list[$random_parent_index1][$j], $item);
                        }
                        
                        // 取代deep copy
                        $this->copy_parent_list[$random_parent_index2][$j] = [];
                        foreach($c as $item) {
                            array_push($this->copy_parent_list[$random_parent_index2][$j], $item);
                        }
                    }
                }
            }
            
            // 把交配完的子代放入all_child_list
            // 取代deep copy
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index1] as $item) {
                array_push($items, $item);
            }
            array_push($all_child_list, $items);
            
            // 取代deep copy
            $items = [];
            foreach($this->copy_parent_list[$random_parent_index2] as $item) {
                array_push($items, $item);
            }
            array_push($all_child_list, $items);
        }
    }
    
    // 突變運算子
    public function mutation($all_parent_list, $doctor_list) {
        $mutation_list = [];
        // 看有沒有抓到不是預班的醫生，如果抓到預班的醫生要重抓
        $rerun = 1;
        $parent_list_index = 0;
        $random_class_table_index = 0;
        
        while($rerun == 1) {
            // 從all_parent_list中，挑選出一個要突變的子代
            $parent_list_index = rand(0, count($all_parent_list) - 1);
            
            // 存放random出來要突變哪一格的值
            $random_class_table_index = rand(0, intval(days) * 19 - 1);
            
            // 檢查該格是否為預班、或者是否為假日班，如果不是將該格醫師取出
            if($all_parent_list[$parent_list_index][$random_class_table_index]->reservation != true and $all_parent_list[$parent_list_index][$random_class_table_index]->holiday != 1) {
                // 將要突變的子代複製一個到mutation_list中
                $items = [];
                foreach($all_parent_list[$parent_list_index] as $item) {
                    array_push($items, $item);
                }
                array_push($mutation_list, $items);
                
                // 把該醫生取出
                $mutation_list_index = count($mutation_list) - 1;
                $mutation_list[$mutation_list_index][$random_class_table_index]->doctor_id = '';
                // 放入一個隨機取出的醫生
                $random_doctor_index = 0;
                $random_doctor_index = rand(0, count($doctor_list) - 1);
                
                $mutation_list[$mutation_list_index][$random_class_table_index]->doctor_id = $doctor_list[$random_doctor_index]->doctorID;
                
                $rerun += 1;
            }else {
                $rerun = 1;
            }
        }
    }
    
    // 修正班表
    public function revise($schedule, $doctor_list) {
        $order_list = [];
        
        // 確認該格醫生不是預班醫生,且不是假日班
        for($i = 0; $i < count($schedule); $i++) {
            if($schedule[$i]->reservation == false and $schedule[$i]->holiday == 0) {
                // 先找出該格對應的doctor_list中的doctor物件index
                $doc_index = 0;
                for($j = 0; $j , count($doctor_list); $j++) {
                    if($schedule[$i]->doctor_id == $doctor_list[$j]->doctorID) {
                        $doc_index = $j;
                    }
                }
                
                // 若該班表之該表格中的醫師違反H1、H2或H7時，就把該醫師取出，並取出醫師對應的屬性
                if(check_doc_class($schedule , $schedule[$i] , $doctor_list[$doc_index]) == false or check_H7($schedule[i] , $doctor_list[$doc_index]) == false) {
                    $schedule[$i]->doctor_id = '';
                }
            }
        }
        
        // 重新計算醫師屬性的值
        for($i = 0; $i < count($schedule); $i++) {
            calcu_doc_attribute($schedule[$i], $doctor_list);
        }
        
        // 取代deep copy
        $copy_doctor_list = [];
        foreach($doctor_list as $doctor) {
            array_push($copy_doctor_list, $doctor);
        }
        
        // 先把不合理的醫生拿出的表另存起來
        // 取代deep copy
        $copy_schedule = [];
        foreach($schedule as $sch) {
            array_push($copy_schedule, $sch);
        }
        
        // 將剩下空格繼續填滿,如果沒填滿必須重填，填到滿為止
        $rerun_rerun = false;
        $switch_switch = 1;
        
        while($rerun_rerun == true or $switch_switch == 1) {
            $rerun_rerun = false;
            finish_schedule($schedule, $order_list, $doctor_list);
            
            for($k = 0; $k , count($schedule); $k++) {
                if($schedule[$k]->doctor_id == '') {
                    $rerun_rerun = true;
                    
                    // 取代deep copy
                    $schedule = [];
                    foreach($copy_schedule as $sch) {
                        array_push($schedule, $sch);
                    }
                    
                    // 取代deep copy
                    $doctor_list = [];
                    foreach($copy_doctor_list as $doc) {
                        array_push($doctor_list, $doc);
                    }
                    
                    break;
                }
            }
            
            $switch_switch = $switch_switch + 1;
        }
        
        return $schedule;
    }
    
    public function check_H7($class_table , $doctor) {
        // boolean值 true為可填入班表，false則不可填入
        $result = true;
        
        // 當班表的科別與醫生的專職科別不合，則該醫師不能填入
        if($doctor->major != 'all' and $class_table->section != $doctor->major) {
            $result = false;
        }
        
        return $result;
    }
    
    // 逐一扣除在表格中醫師的屬性，再扣除前要先檢查:
    // 1.該醫師目前為止是否已經上超過4天假日班，若超過則取出該醫師
    // 2.該醫師目前為止是否已經上超過他自己非職登院區的班數，若超過則取出該醫師
    // 3.該醫師目前為止白夜班是否已經超過他的白夜班班數，若超過則取出該醫師
    // 4.該醫師當週已超過支援上限兩班，也取出該醫師
    public function calcu_doc_attribute($class_table , $doctor_list) {
        $result = true;
        
        // 先抓出醫生index
        $doctor_index = 0;
        if($class_table->doctor_id != '') {
            for($i = 0; $i < count($doctor_list); $i++) {
                if($class_table->doctor_id == $doctor_list[$i]->doctorID) {
                    $doctor_index = $i;
                    break;
                }
            }
            
            // 1
            if($class_table->holiday == 1) {
                if($doctor_list[$doctor_index]->weekendShifts == 0) {
                    $result = false;
                }
            }
            
            // 2
            if($doctor_list[$doctor_index]->location == 'T' and $class_table->hospital_area == 'D' and $doctor_list[$doctor_index]->tamsuiShiftsLimit == 0) {
                $result = false;
            }else if($doctor_list[$doctor_index]->location == 'D' and $class_table->hospital_area == 'T' and $doctor_list[$doctor_index]->taipeiShiftsLimit == 0) {
                $result = false;
            }
            
            // 3
            if($class_table->class_sort == 'd' and $this->doctor_list[$doctor_index]->dayShifts == 0) {
                $result = false;
            }else if($class_table->class_sort == 'n' and $this->doctor_list[$doctor_index]->nightShifts == 0) {
                $result = false;
            }
            
            // 4
            if($this->doctor_list[$doctor_index]->location == 'T' and $class_table->hospital_area == 'D' and $this->doctor_list[$doctor_index]->tamsuiShiftsLimit > 0 and $this->doctor_list[$doctor_index]->otherLocationShifts[$class_table->week_num - 1] == 2) {
                $result = false;
            }else if($this->doctor_list[$doctor_index]->location == 'D' and $class_table->hospital_area == 'T' and $this->doctor_list[$doctor_index]->taipeiShiftsLimit > 0 and $this->doctor_list[$doctor_index]->otherLocationShifts[$class_table->week_num - 1] == 2) {
                $result = false;
            }
            
            if($result == true and $class_table->doctor_id != '') {
                $class_table_property_list = [];
                array_push($class_table_property_list, $class_table->section);
                array_push($class_table_property_list, $class_table->class_sort);
                array_push($class_table_property_list, $class_table->hospital_area);
                
                // 當天為假日班時，醫生假日班數-1
                $this->doctor_list[$doctor_index]->weekendShifts = $this->doctor_list[$doctor_index]->weekendShifts - $class_table->holiday;
                
                // 醫生總班數-1
                $this->doctor_list[$doctor_index]->totalShifts = $this->doctor_list[$doctor_index]->totalShifts - 1;
                
                // 根據表格屬性，將醫生其值扣除
                for($i = 0; $i < count($class_table_property_list); $i++) {
                    if($class_table_property_list[$i] == 'med') {
                        $doctor_list[$doctor_index]->medicalShifts -= 1;
                    }else if($class_table_property_list[$i] == 'sur') {
                        $doctor_list[$doctor_index]->surgicalShifts -= 1;
                    }else if($class_table_property_list[$i] == 'd') {
                        $doctor_list[$doctor_index]->dayShifts -= 1;
                    }else if($class_table_property_list[$i] == 'n') {
                        $doctor_list[$doctor_index]->nightShifts -= 1;
                    }else if($class_table_property_list[$i] == 'T') {
                        $doctor_list[$doctor_index]->taipeiShiftsLimit -= 1;
                    }else if($class_table_property_list[$i] == 'D') {
                        $doctor_list[$doctor_index]->tamsuiShiftsLimit -= 1;
                    }
                }
                
                // 當在非職登院區上班時，再當週非職登院區班數+1
                if($class_table->hospital_area != $doctor_list[$doctor_index]->location) {
                    $this->doctor_list[$doctor_index]->otherLocationShifts[$class_table->week_num - 1] += 1;
                }
            }else {
                $class_table->doctor_id = '';
            }
        }
    }
    
    public function print_schedule($schedule) {
        echo 'print_schedule=================================';
        for($i = 0; $i < 19; $i++) {
            for($j = 0; $j < intval($this->days); $j++) {
                echo $schedule[$i + $j * 19]->doctor_id.' ';
            }
            echo '<br.';
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
