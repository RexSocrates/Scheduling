<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;

// 演算法用的model
use App\User;
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;
use App\Schedule;

// 客製化物件
use App\CustomClass\OnReservation;
use App\CustomClass\OffReservation;
use App\CustomClass\Doctor;
use App\CustomClass\Month;
use App\CustomClass\ClassTable2;


class Schedule2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 此演算法'不'考慮的限制有
    // 1. 醫生須在職登院區上超過一半的班數
    // 2. 每週醫生不能再非職登院區上超過2班
    // 3. 醫生上班的總數
    // 4. 醫生是否有前一天晚上夜班，隔一天又上白班的情形
    // 5. 大概會有不少醫生超時工作吧
    
    // 收集排班資料
    public $onRes;
    public $offRes;
    public $doctors;
    public $monthInfo;
    
    // 用來儲存正在排班當日已經有上班的醫生
    public $schedDoctors = [];
    // 用來儲存一個月所有的班表
    public $schedule = [];
    // 儲存沒有預約但是有空的醫生
    public $freeDoctorIDs = [];
    
    // 特定時間預約on班的醫生
    public $onSchDoctorIDs = [];
    
    // 上班地區在台北的 schedule category : 0 ~ 18
    public $taipeiSchCateSerial = [3, 4, 5, 6, 7, 8, 13, 14, 15, 16, 17, 18];
    
    // 存放排班月份的假日日期
    public $weekendDate = [];
    

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
        
        echo print_r($this->monthInfo).'<br>';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 先宣告要使用的model
        $userObj = new User();
        
        // 從要排班的月份的1號開始安排
        for($day = 1; $day <= $this->monthInfo->daysOfMonth; $day++) {
            echo '<br>當天日期 : '.$day.'<br>';
            
            // 要產生當日班表前先初始化當日已排班的醫生陣列，從 0 開始填入 19 個 -1
            $this->schedDoctors = array_fill(0, 19, -1);
            
            // 宣告一個變數用來記錄目前班表填到哪
            $shiftIndex = 0;
            
            // 先找出北白的預約醫師，台北白班需求6人，下面這一段需要填滿當日班表 $shiftIndex = 0~5
//            $taipeiDayShiftDoctorIDs = $this->checkOnScheduleDoctors($day, 'T', 'd');
            $this->checkOnScheduleDoctors($day, 'T', 'd');
            $taipeiDayShiftDoctorIDs = $this->onSchDoctorIDs;
            
            
            // 計算北白預約的各科人力
            $resourceDic = $this->countMajorResources($taipeiDayShiftDoctorIDs);
            $allDocCount = $resourceDic['all'];
            $medDocCount = $resourceDic['med'];
            $surDocCount = $resourceDic['sur'];
            
            // 北白急救人力需求1，$shiftIndex = 0
            if($allDocCount >= 1) {
                // 急救不知道是什麼科別，所以最好由綜合的醫師上班
                foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        // 綜合人力減1
                        $allDocCount -= 1;
                        
                        // 已經上班的醫生需要移除此預約列表
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                        break;
                    }
                }
            }else {
                if(count($taipeiDayShiftDoctorIDs) > 0) {
                    // 今日有人預約的話
                    
                    // 沒有綜合的醫師預約，隨機選一位去上班
                    $doctorIndex = rand(0, count($taipeiDayShiftDoctorIDs) - 1);
                    $doctorID = $taipeiDayShiftDoctorIDs[$doctorIndex];
                    
                    $this->schedDoctors[$shiftIndex++] = $doctorID;
                    // 被選上的醫師所屬之科別的人力減1
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                        $allDocCount -= 1;
                    }else if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                        $medDocCount -= 1;
                    }else {
                        $surDocCount -= 1;
                    }
                    
                    // 已經上班的醫生需要移除此預約列表
                    array_splice($taipeiDayShiftDoctorIDs, $doctorIndex, 1);
                }else {
                    // 沒有人預約的話，將有空的人排入
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'all');
                    
                    $doctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                    $doctorID = $this->freeDoctorIDs[$doctorIDIndex];
                    $this->schedDoctors[$shiftIndex++] = $doctorID;
                    
                    // 移除被填入的人
                    array_splice($this->freeDoctorIDs, $doctorIDIndex, 1);
                }
                
                
            }
            
            echo '北白急救排完了1 : '.$shiftIndex.'<br>';
            echo 'Doctor ID : '.$this->schedDoctors[0].'<br>';
            
            // 北白發燒 + 北白內科人力需求3，$shiftIndex = 1~3
            if($medDocCount + $allDocCount >= 3) {
                // 此時人力充足
                
                // 儲存被排到北白內科的內科醫師編號
                $taipeiDayMedDoctorIDs = [];
                
                // 先將專職科別為內科之醫師填入，保留綜合的醫師
                foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        // 內科人力減1
                        $medDocCount -= 1;
                        
                        // 選上的醫師加入列表
                        array_push($taipeiDayMedDoctorIDs, $doctorID);
                    }
                    
                    // 假如北白工作點都已經排完了或是預約on班的專職科別為內科的人力降為0就跳出迴圈
                    if($shiftIndex >= 3 or $medDocCount == 0) {
                        break;
                    }
                }
                
                // 先從陣列移除已經被排入北白內的內科醫師
                foreach($taipeiDayMedDoctorIDs as $ID) {
                    array_splice($taipeiDayShiftDoctorIDs, array_search($ID, $taipeiDayShiftDoctorIDs), 1);
                }
                
                // 如果剩餘的綜合科醫師足夠填完缺少的北白內科則直接填入
                if($allDocCount > 0 and $shiftIndex < 3 and $allDocCount >= (3 - $shiftIndex)) {
                    // 先取出陣列中的綜合科醫師，並填入當日班表
                    $docListAll = [];
                    
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            array_push($docListAll, $doctorID);
                        }
                        
                        if($shiftIndex >= 3) {
                            // 填完北白內就結束迴圈
                            break;
                        }
                    }
                    
                    // 移除被填入的綜合科醫師
                    foreach($docListAll as $docID) {
                        array_splice($taipeiDayShiftDoctorIDs, array_search($docID, $taipeiDayShiftDoctorIDs), 1);
                    }
                }else {
                    // 如果剩餘的綜合科醫師不夠的話（陣列中可能只剩下外科醫師）
                    
                    // 先取出陣列中的綜合科醫師
                    $docListAll = [];
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            array_push($docListAll, $doctorID);
                        }
                    }
                    
                    // 將剩餘綜合科醫師填入北白內並移除醫生ID(都加入之後北白內還是有缺)
                    foreach($docListAll as $doctorID) {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        // 綜合醫師人力減1
                        $allDocCount -= 1;
                        
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                    }
                    
                    // 剩餘的空缺靠其他有空且可以看內科的醫師處理，名單使用全域變數去接
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'med');
                    
                    // 宣告一個陣列儲存被填入的醫師
                    $filledDoctorIDs = [];
                    
                    // 靠這些醫師填入，直到沒有空缺
                    foreach($this->freeDoctorIDs as $doctorID) {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        array_push($filledDoctorIDs, $doctorID);
                        
                        if($shiftIndex >= 3) {
                            break;
                        }
                    }
                    
                    // 從有空的醫師名單中移除這些被填入的醫師編號
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($this->freeDoctorIDs, array_search($doctorID, $this->freeDoctorIDs), 1);
                    }
                }
            }else {
                // 此時北白內科人力短缺，有可能剩下的都是外科醫師
                
                // 如果有內科醫師預約這個班就填入
                if($medDocCount > 0) {
                    // 宣告陣列儲存被填入的內科醫師
                    $filledMedDoctorIDs = [];
                    
                    // 內科醫師先填入
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $medDocCount -= 1;
                            
                            array_push($filledMedDoctorIDs, $doctorID);
                        }
                        
                        // 內科人力降為0或已填滿北白內科則跳出迴圈
                        if($medDocCount <= 0 or $shiftIndex >= 3) {
                            break;
                        }
                    }
                    
                    // 從列表中移除被填入的內科醫師
                    foreach($filledMedDoctorIDs as $doctorID) {
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                    }
                }
                
                // 班表沒被填滿則開始填入綜合科醫師
                if($allDocCount > 0 and $shiftIndex < 3) {
                    // 宣告陣列儲存被填入的綜合科醫師編號
                    $filledMAllDoctorIDs = [];
                    
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            
                            array_push($filledMAllDoctorIDs, $doctorID);
                        }
                        
                        // 綜合人力降為0或已填滿則跳出迴圈
                        if($allDocCount <= 0 or $shiftIndex >= 3) {
                            break;
                        }
                    }
                    
                    // 從列表中移除被填入的綜合科醫師
                    foreach($filledMAllDoctorIDs as $doctorID) {
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                    }
                }
                
                // 如果有預約的內科醫師以及綜合科醫師都填入但是還沒填滿則找有空且可以看內科的醫師加入
                if($shiftIndex < 3) {
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'med');
                    
                    // 宣告一個陣列儲存被填入的醫師
                    $filledDoctorIDs = [];
                    
                    // 靠這些醫師填入，直到沒有空缺
                    while($shiftIndex <= 3) {
                        $doctorIDIndex = -1;
                        $doctorID = 0;
                        do {
                            $doctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                            $doctorID = $this->freeDoctorIDs[$doctorIDIndex];
                        }while(array_key_exists($doctorID, $filledDoctorIDs) == true);
                        
                        array_push($filledDoctorIDs, $doctorID);
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                    }
                    
                    // 從有空的醫師名單中移除這些被填入的醫師編號
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($this->freeDoctorIDs, array_search($doctorID, $this->freeDoctorIDs), 1);
                    }
                }
            }
            
            echo '北白內科排完了4 : '.$shiftIndex.'<br>';
            
            // 北白外科人力需求2 $shiftIndex = 4~5
            if($surDocCount + $allDocCount >= 2) {
                // 北白內科人力充足
                
                // 宣告陣列儲存被填入的外科醫師
                $filledDoctorIDs = [];
                
                // 外科醫師先填入
                foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $surDocCount -= 1;
                        array_push($filledDoctorIDs, $doctorID);
                    }
                    
                    // 如果外科醫師沒了或是已經填滿了則跳出迴圈
                    if($surDocCount <= 0 or $shiftIndex >= 5) {
                        break;
                    }
                }
                
                // 移除外科醫師
                foreach($filledDoctorIDs as $doctorID) {
                    array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                }
                
                // 如果北白外沒有被填滿則讓綜合科醫師加入
                if($allDocCount > 0 and $shiftIndex < 5) {
                    
                    // 宣告陣列儲存被填入的綜合科醫師
                    $filledDoctorIDs = [];
                    
                    // 加入綜合科醫師
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            array_push($filledDoctorIDs, $doctorID);
                            $allDocCount -= 1;
                        }
                        
                        // 如果綜合科醫師沒了或是已經填滿了則跳出迴圈
                        if($allDocCount <= 0 or $shiftIndex >= 5) {
                            break;
                        }
                    }
                    
                    // 移除被加入的綜合科醫師
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                    }
                }
                
            }else {
                // 此時北白外科人力短缺，預約列表中可能沒有剩下醫師
                
                // 宣告陣列儲存被填入的外科醫師
                $filledDoctorIDs = [];
                
                // 外科醫師先填入
                foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $surDocCount -= 1;
                        array_push($filledDoctorIDs, $doctorID);
                    }
                    
                    // 如果外科醫師沒了或是已經填滿了則跳出迴圈
                    if($surDocCount <= 0 or $shiftIndex >= 5) {
                        break;
                    }
                }
                
                // 移除外科醫師
                foreach($filledDoctorIDs as $doctorID) {
                    array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                }
                
                // 如果北白外沒有被填滿則讓綜合科醫師加入
                if($allDocCount > 0 and $shiftIndex < 5) {
                    
                    // 宣告陣列儲存被填入的綜合科醫師
                    $filledDoctorIDs = [];
                    
                    // 加入綜合科醫師
                    foreach($taipeiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            array_push($filledDoctorIDs, $doctorID);
                            $allDocCount -= 1;
                        }
                        
                        // 如果綜合科醫師沒了或是已經填滿了則跳出迴圈
                        if($allDocCount <= 0 or $shiftIndex >= 5) {
                            break;
                        }
                    }
                    
                    // 移除被加入的綜合科醫師
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($taipeiDayShiftDoctorIDs, array_search($doctorID, $taipeiDayShiftDoctorIDs), 1);
                    }
                }
                
                //  如果北白外用光了所有剩餘的醫生還沒有填滿則找有空且可以看外科的醫生加入
                if($shiftIndex < 5) {
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'sur');
                    
                    // 宣告一個陣列儲存被填入的醫師
                    $filledDoctorIDs = [];
                    
                    // 靠這些醫師填入，直到沒有空缺
                    while($shiftIndex <= 5) {
                        $doctorIDIndex = -1;
                        $doctorID = 0;
                        do {
                            $doctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                            $doctorID = $this->freeDoctorIDs[$doctorIDIndex];
                        }while(array_key_exists($doctorID, $filledDoctorIDs) == true);
                        
                        array_push($filledDoctorIDs, $doctorID);
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                    }
                    
                    // 從有空的醫師名單中移除這些被填入的醫師編號
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($this->freeDoctorIDs, array_search($doctorID, $this->freeDoctorIDs), 1);
                    }
                }
            }
            
            echo '北白外科排完了6 : '.$shiftIndex.'<br>';
            
            // 先找出淡白的預約醫師，淡水白班需求4人，下面這一段需要填滿當日班表 $shiftIndex = 6~9
//            $damsuiDayShiftDoctorIDs = $this->checkOnScheduleDoctors($day, 'D', 'd');
            $this->checkOnScheduleDoctors($day, 'D', 'd');
            $damsuiDayShiftDoctorIDs = $this->onSchDoctorIDs;
            
            // 計算淡白預約的各科人力
            $resourceDic = $this->countMajorResources($damsuiDayShiftDoctorIDs);
            $allDocCount = $resourceDic['all'];
            $medDocCount = $resourceDic['med'];
            $surDocCount = $resourceDic['sur'];
            
            // 淡白內人力需求2，$shiftIndex = 6~7
            if($medDocCount + $allDocCount >= 2) {
                // 淡白內科人力資源充足
                
                // 宣告一個陣列儲存被填入的醫生編號
                $filledDoctorIDs = [];
                
                // 先填入內科醫師
                foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $medDocCount -= 1;
                        array_push($filledDoctorIDs, $doctorID);
                    }
                    
                    if($medDocCount <= 0 or $shiftIndex >= 7) {
                        break;
                    }
                }
                
                // 移除剛才被填入的人
                foreach($filledDoctorIDs as $doctorID) {
                    array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                }
                
                // 如果內科醫師填完，但是還有工作點的空缺，請綜合科的醫師加入
                if($shiftIndex < 7) {
                    // 宣告一個陣列儲存被填入的醫生編號
                    $filledDoctorIDs = [];
                    
                    foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            array_push($filledDoctorIDs, $doctorID);
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex >= 7) {
                            break;
                        }
                    }
                    
                    // 移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                    }
                }
                
            }else {
                // 淡白內科人力資源不足
                
                // 宣告一個陣列儲存被填入的醫生編號
                $filledDoctorIDs = [];
                
                // 先填入內科醫師
                foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $medDocCount -= 1;
                        array_push($filledDoctorIDs, $doctorID);
                    }
                    
                    if($medDocCount <= 0 or $shiftIndex >= 7) {
                        break;
                    }
                }
                
                // 移除剛才被填入的人
                foreach($filledDoctorIDs as $doctorID) {
                    array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                }
                
                // 如果內科醫師填完，但是還有工作點的空缺，請綜合科的醫師加入
                if($shiftIndex < 7) {
                    // 宣告一個陣列儲存被填入的醫生編號
                    $filledDoctorIDs = [];
                    
                    foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            array_push($filledDoctorIDs, $doctorID);
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex >= 7) {
                            break;
                        }
                    }
                    
                    // 移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                    }
                }
                
                // 如果可以上這個班的醫師都填完還是有空缺，將有空且可以看內科的醫師加入
                if($shiftIndex < 7) {
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'med');
                    
                    // 宣告一個陣列儲存被填入的醫師
                    $filledDoctorIDs = [];
                    
                    while($shiftIndex <= 7) {
                        $doctorIDIndex = -1;
                        $doctorID = 0;
                        do {
                            $doctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                            $doctorID = $this->freeDoctorIDs[$doctorIDIndex];
                        }while(array_key_exists($doctorID, $filledDoctorIDs) == true);
                        
                        array_push($filledDoctorIDs, $doctorID);
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                    }
                    
                    // 從有空的清單中移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($this->freeDoctorIDs, array_search($doctorID, $this->freeDoctorIDs), 1);
                    }
                }
            }
            
            echo '淡白內科排完了8 : '.$shiftIndex.'<br>';
            
            // 淡白外人力需求2，$shiftIndex = 8~9
            if($surDocCount + $allDocCount >= 2) {
                // 淡白外人力充足
                
                // 宣告陣列儲存被填入的外科醫師
                $filledDoctors = [];
                
                // 外科醫師先填入
                foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $surDocCount -= 1;
                        array_push($filledDoctors, $doctorID);
                    }
                    
                    // 如果外科醫生沒了或是已經填滿則跳出迴圈
                    if($surDocCount <= 0 or $shiftIndex >= 9) {
                        break;
                    }
                }
                
                
                // 移除剛才被填入的醫師編號
                foreach($filledDoctors as $doctorID) {
                    array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                }
                
                // 如果外科醫師填完，但是還有工作點的空缺，請綜合科的醫師加入
                if($shiftIndex < 9) {
                    // 宣告一個陣列儲存被填入的醫生編號
                    $filledDoctorIDs = [];
                    
                    foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            array_push($filledDoctorIDs, $doctorID);
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex >= 9) {
                            break;
                        }
                    }
                    
                    // 移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                    }
                }
            }else {
                // 淡白外人力有缺
                
                // 宣告陣列儲存被填入的外科醫師
                $filledDoctors = [];
                
                // 外科醫師先填入
                foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        $surDocCount -= 1;
                        array_push($filledDoctors, $doctorID);
                    }
                    
                    // 如果外科醫生沒了或是已經填滿則跳出迴圈
                    if($surDocCount <= 0 or $shiftIndex >= 9) {
                        break;
                    }
                }
                
                
                // 移除剛才被填入的醫師編號
                foreach($filledDoctors as $doctorID) {
                    array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                }
                
                // 如果外科醫師填完，但是還有工作點的空缺，請綜合科的醫師加入
                if($shiftIndex < 9) {
                    // 宣告一個陣列儲存被填入的醫生編號
                    $filledDoctorIDs = [];
                    
                    foreach($damsuiDayShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            $allDocCount -= 1;
                            array_push($filledDoctorIDs, $doctorID);
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex >= 9) {
                            break;
                        }
                    }
                    
                    // 移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($damsuiDayShiftDoctorIDs, array_search($doctorID, $damsuiDayShiftDoctorIDs), 1);
                    }
                }
                
                // 如果外科與綜合科的醫師填入後，還是有缺則將有空且可看外科之醫生加入
                if($shiftIndex < 9) {
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'sur');
                    
                    // 宣告一個陣列儲存被填入的醫師
                    $filledDoctorIDs = [];
                    
                    while($shiftIndex <= 9) {
                        $doctorIDIndex = -1;
                        $doctorID = 0;
                        do {
                            $doctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                            $doctorID = $this->freeDoctorIDs[$doctorIDIndex];
                        }while(array_key_exists($doctorID, $filledDoctorIDs) == true);
                        
                        array_push($filledDoctorIDs, $doctorID);
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                    }
                    
                    // 從有空的清單中移除剛才被填入的人
                    foreach($filledDoctorIDs as $doctorID) {
                        array_splice($this->freeDoctorIDs, array_search($doctorID, $this->freeDoctorIDs), 1);
                    }
                }
            }
            
            echo '淡白外科排完了10 : '.$shiftIndex.'<br>';
            
            
            
            
            
            
            // 先找出北夜的預約醫師，台北夜班需求6人，下面這一段需要填滿當日班表 $shiftIndex = 10~15
            $this->checkOnScheduleDoctors($day, 'T', 'n');
            $taipeiNightShiftDoctorIDs = $this->onSchDoctorIDs;
            
            // 計算台北夜班各科人力
            $resourceDic = $this->countMajorResources($taipeiNightShiftDoctorIDs);
            $allDocCount = $resourceDic['all'];
            $medDocCount = $resourceDic['med'];
            $surDocCount = $resourceDic['sur'];
            
            // 北夜急救先讓綜合科醫師先上 $shiftIndex = 10
            if($allDocCount > 0) {
                // 北夜急救人力可排
                foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        
                        // 綜合科人力減1
                        $allDocCount -= 1;
                        // 從陣列中移除醫生ID
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                        break;
                    }
                }
            }else {
                // 沒有綜合科醫師預約此時段，先隨機選取一位醫師上班
                if(count($taipeiNightShiftDoctorIDs) > 0) {
                    // 有人預約此時段
                    $randDoctorIndex = rand(0, count($taipeiNightShiftDoctorIDs) - 1);
                    $randDoctorID = $taipeiNightShiftDoctorIDs[$randDoctorIndex];
                    $this->schedDoctors[$shiftIndex++] = $randDoctorID;
                    
                    array_splice($taipeiNightShiftDoctorIDs, $randDoctorIndex, 1);
                    
                    // 該科人力減1
                    if($userObj->getDoctorInfoByID($randDoctorID)->major == 'All') {
                        $allDocCount -= 1;
                    }else if($userObj->getDoctorInfoByID($randDoctorID)->major == 'Medical') {
                        $medDocCount -= 1;
                    }else {
                        $surDocCount -= 1;
                    }
                }else {
                    // 此時段沒有人預約
                    
                    // 先找可以上綜合科的醫生來排急救班
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'all');
                    
                    // 隨機選取一位有空的醫生上班
                    $randDoctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                    $randDoctorID = $this->freeDoctorIDs[$randDoctorIDIndex];
                    
                    // 將選出的醫師排入當日班表
                    $this->schedDoctors[$shiftIndex++] = $randDoctorID;
                    
                    // 從醫生名單中移除醫師
                    array_splice($this->freeDoctorIDs, $randDoctorIDIndex, 1);
                    
                }
            }
            
            echo '北夜急救排完了11 : '.$shiftIndex.'<br>';
            
            // 北夜發燒 + 北夜內科需求人力3 $shiftIndex = 11 ~ 13
            if($allDocCount + $medDocCount >= 3) {
                // 北夜內科人力充足
                
                // 選告一個陣列紀錄被排入的內科醫師
                $filledMedDoctorIDs = [];
                
                // 內科醫師先排入
                foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        
                        // 將醫生ID放入暫存陣列
                        array_push($filledMedDoctorIDs, $doctorID);
                        
                        // 內科人力減1
                        $medDocCount -= 1;
                        
                        if($medDocCount <= 0 or $shiftIndex >= 13) {
                            break;
                        }
                    }
                }
                
                // 將排入的內科醫師從人力陣列中移除
                foreach($filledMedDoctorIDs as $doctorID) {
                    array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                }
                
                // 若內科的人排完，工作點有空缺，請綜合科醫師去排
                if($shiftIndex < 13) {
                    
                    //  宣告一個陣列存放被排入的綜合科醫生
                    $filledAllDoctorIDs = [];
                    
                    
                    // 如果將所有內科醫師排入之後工作點有空缺，請綜合科醫師下去排
                    foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            // 將醫生ID放入暫存陣列
                            array_push($filledAllDoctorIDs, $doctorID);
                            
                            $allDocCount -= 1;
                        }
                        // 如果綜合科人數歸零或是工作點已填滿則離開迴圈
                        if($allDocCount <= 0 or $shiftIndex >= 13) {
                            break;
                        }
                    }
                    
                    // 從人力資源的陣列中移除被排入的綜合科醫生
                    foreach($filledAllDoctorIDs as $doctorID) {
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                    }
                }
            }else {
                // 北夜內科人力短缺
                
                // 內科醫師先排
                if($medDocCount > 0) {
                    // 宣告一個陣列儲存被排入的醫師ID
                    $filledMedDoctorIDs = [];
                    
                    foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                            
                            // 將醫師加入當日班表
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            // 內科人力減1
                            $medDocCount -= 1;
                            
                            // 將選上的醫生加入暫存陣列
                            array_push($filledMedDoctorIDs, $doctorID);
                        }
                        
                        // 如果內科醫生資源數量歸零，或是工作點已經填滿則跳出迴圈
                        if($medDocCount <= 0 or $shiftIndex >= 13) {
                            break;
                        }
                    }
                    
                    // 將已經排入當日班表的醫生移除
                    foreach($filledMedDoctorIDs as $doctorID) {
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 如果內科醫師排完後，工作點沒有滿
                if($shiftIndex < 13) {
                    // 如果有綜合科醫師預約則排入
                    if($allDocCount > 0) {
                        // 存放被排入當日班表的醫生
                        $filledAllDoctorIDs = [];
                        
                        foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                            if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                                $this->schedDoctors[$shiftIndex++] = $doctorID;
                                
                                // 綜合科人力減1
                                $allDocCount -= 1;
                                
                                array_push($filledAllDoctorIDs, $doctorID);
                            }
                            
                            if($allDocCount <= 0 or $shiftIndex >= 13) {
                                break;
                            }
                        }
                        
                        // 將被排入的醫生移除
                        foreach($filledAllDoctorIDs as $doctorID) {
                            array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                        }
                    }
                    
                    // 如果綜合科醫師排完後，工作點還是沒有滿，則找有空的醫師上班
                    if($shiftIndex < 13) {
                        $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'med');
                        
                        // 存放被選上的醫師
                        $filledDoctorIDIndex = [];
                        
                        // 隨機選取醫師上班
                        while($shiftIndex <= 13) {
                            $randDoctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                            
                            if(array_key_exists($randDoctorIDIndex, $filledDoctorIDIndex) == false) {
                                // 加入隨機選出來的醫生ID index
                                array_push($filledDoctorIDIndex, $randDoctorIDIndex);
                                
                                // 將隨機選出之醫生排入班表
                                $this->schedDoctors[$shiftIndex++] = $this->freeDoctorIDs[$randDoctorIDIndex];
                            }
                        }
                        // 將醫生移除選單
                        foreach($filledDoctorIDIndex as $doctorIDIndex) {
                            array_splice($this->freeDoctorIDs, $doctorIDIndex, 1);
                        }
                    }
                }
                
                
            }
            echo '北夜內科排完了14 : '.$shiftIndex.'<br>';
            
            // 北夜外科人力需求2 $shiftIndex = 14 ~ 15
            if($allDocCount + $surDocCount >= 2) {
                // 北夜外科人力充足
                if($surDocCount > 0) {
                    // 宣告一個陣列儲存被排入的醫師
                    $filledSurDoctorIDs = [];
                    
                    foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            // 外科人力減1
                            $surDocCount -= 1;
                            
                            array_push($filledSurDoctorIDs, $doctorID);
                        }
                        
                        // 如果外科人力歸零，或是工作點已經填滿則跳出迴圈
                        if($surDocCount <= 0 or $shiftIndex >= 15) {
                            break;
                        }
                    }
                    
                    // 移除被填入的外科醫師
                    foreach($filledSurDoctorIDs as $doctorID) {
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 如果外科醫師都放進當日班表了，但還有工作點有空缺，排入綜合科醫師
                
                // 宣告陣列存放醫生
                $filledAllDoctorIDs = [];
                
                foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                    if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                        $this->schedDoctors[$shiftIndex++] = $doctorID;
                        
                        // 綜合科人力減1
                        $allDocCount -= 1;
                        
                        array_push($filledAllDoctorIDs, $doctorID);
                    }
                    
                    if($allDocCount <= 0 or $shiftIndex >= 15) {
                        break;
                    }
                }
                
                // 從資源名單移出醫師
                foreach($filledAllDoctorIDs as $doctorID) {
                    array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                }   
            }else {
                // 北夜外科人力短缺
                
                if($surDocCount > 0) {
                    // 宣告一個陣列儲存被排入的醫師
                    $filledSurDoctorIDs = [];
                    
                    foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            // 外科人力減1
                            $surDocCount -= 1;
                            
                            array_push($filledSurDoctorIDs, $doctorID);
                        }
                        
                        // 如果外科人力歸零，或是工作點已經填滿則跳出迴圈
                        if($surDocCount <= 0 or $shiftIndex >= 15) {
                            break;
                        }
                    }
                    
                    // 移除被填入的外科醫師
                    foreach($filledSurDoctorIDs as $doctorID) {
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 如果外科醫師都放進當日班表了，但還有工作點有空缺，排入綜合科醫師
                if($allDocCount > 0 and $shiftIndex < 15) {
                    // 宣告陣列存放醫生
                    $filledAllDoctorIDs = [];
                    
                    foreach($taipeiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Surgical') {
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            // 綜合科人力減1
                            $allDocCount -= 1;
                            
                            array_push($filledAllDoctorIDs, $doctorID);
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex >= 15) {
                            break;
                        }
                    }
                    
                    // 從資源名單移出醫師
                    foreach($filledAllDoctorIDs as $doctorID) {
                        array_splice($taipeiNightShiftDoctorIDs, array_search($doctorID, $taipeiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 如果剩餘醫師都已經排進去當日班表，但仍有空缺
                if($shiftIndex < 15) {
                    // 先找有空的醫師
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'sur');
                    
                    // 宣告陣列存放被填入的醫生
                    $filledDoctorIDIndex = [];
                    
                    while($shiftIndex <= 15) {
                        $randDoctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                        
                        if(array_key_exists($randDoctorIDIndex, $filledDoctorIDIndex) == false) {
                            // 將index 加入陣列
                            array_push($filledDoctorIDIndex, $randDoctorIDIndex);
                            
                            $this->schedDoctors[$shiftIndex++] = $this->freeDoctorIDs[$randDoctorIDIndex];
                        }
                    }
                    
                    // 移除剛才被填入的醫生
                    foreach($filledDoctorIDIndex as $doctorIDIndex) {
                        array_splice($this->freeDoctorIDs, $doctorIDIndex, 1);
                    }
                }
            }
            echo '北夜外科排完了16 : '.$shiftIndex.'<br>';
            
            
            // 先找出淡夜的預約醫師，淡水夜班需求3人，下面這一段需要填滿當日班表 $shiftIndex = 16~18
            $this->checkOnScheduleDoctors($day, 'D', 'n');
            $damsuiNightShiftDoctorIDs = $this->onSchDoctorIDs;
            
            // 計算淡水夜班各科人力
            $resourceDic = $this->countMajorResources($damsuiNightShiftDoctorIDs);
            $allDocCount = $resourceDic['all'];
            $medDocCount = $resourceDic['med'];
            $surDocCount = $resourceDic['sur'];
            
            // 淡水夜班內科人力需求2 $shiftIndex = 16 ~ 17
            if($allDocCount + $medDocCount >= 2) {
                // 淡水夜班內科人力充足
                
                // 內科醫師先排
                if($medDocCount > 0) {
                    // 宣告列儲存被填入的內科醫生
                    $filledMedDoctorIDs = [];
                    
                    foreach($damsuiNightShiftDoctorIDs as $dotorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                            // 將醫生排入當日班表
                            $this->schedDoctors[$shiftIndex++] = $dotorID;
                            
                            array_push($filledMedDoctorIDs, $doctorID);
                            
                            $medDocCount -= 1;
                        }
                        
                        if($medDocCount <= 0 or $shiftIndex >= 17) {
                            break;
                        }
                    }
                    
                    // 移除被填入的醫生
                    foreach($filledMedDoctorIDs as $doctorID) {
                        array_splice($damsuiNightShiftDoctorIDs, array_search($doctorID, $damsuiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 工作點沒有滿，請綜合科的醫生加入
                if($allDocCount > 0) {
                    // 宣告陣列存放將要被放入的綜合科醫生
                    $filledAllDoctorIDs = [];
                    
                    foreach($damsuiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            // 將醫生排入當日班表
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            array_push($filledAllDoctorIDs, $doctorID);
                            $allDocCount -= 1;
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex > 17) {
                            break;
                        }
                    }
                    
                    // 移除剛才被放入當日班表的醫生
                    foreach($filledAllDoctorIDs as $doctorID) {
                        array_splice($damsuiNightShiftDoctorIDs, array_search($doctorID, $damsuiNightShiftDoctorIDs), 1);
                    }
                }
            }else {
                // 淡水夜班內科人力不足
                
                // 內科醫師先排
                if($medDocCount > 0) {
                    // 宣告列儲存被填入的內科醫生
                    $filledMedDoctorIDs = [];
                    
                    foreach($damsuiNightShiftDoctorIDs as $dotorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'Medical') {
                            // 將醫生排入當日班表
                            $this->schedDoctors[$shiftIndex++] = $dotorID;
                            
                            array_push($filledMedDoctorIDs, $doctorID);
                            
                            $medDocCount -= 1;
                        }
                        
                        if($medDocCount <= 0 or $shiftIndex >= 17) {
                            break;
                        }
                    }
                    
                    // 移除被填入的醫生
                    foreach($filledMedDoctorIDs as $doctorID) {
                        array_splice($damsuiNightShiftDoctorIDs, array_search($doctorID, $damsuiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 工作點沒有滿，請綜合科的醫生加入
                if($allDocCount > 0) {
                    // 宣告陣列存放將要被放入的綜合科醫生
                    $filledAllDoctorIDs = [];
                    
                    foreach($damsuiNightShiftDoctorIDs as $doctorID) {
                        if($userObj->getDoctorInfoByID($doctorID)->major == 'All') {
                            // 將醫生排入當日班表
                            $this->schedDoctors[$shiftIndex++] = $doctorID;
                            
                            array_push($filledAllDoctorIDs, $doctorID);
                            $allDocCount -= 1;
                        }
                        
                        if($allDocCount <= 0 or $shiftIndex > 17) {
                            break;
                        }
                    }
                    
                    // 移除剛才被放入當日班表的醫生
                    foreach($filledAllDoctorIDs as $doctorID) {
                        array_splice($damsuiNightShiftDoctorIDs, array_search($doctorID, $damsuiNightShiftDoctorIDs), 1);
                    }
                }
                
                // 內科與綜合科醫師填入之後還沒有填滿，請有空的醫生加入
                if($shiftIndex <= 17) {
                    $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'med');
                    
                    // 宣告陣列儲存隨機選取的醫師
                    $filledDoctorIDIndex = [];
                    
                    while($shiftIndex <= 17) {
                        $randDoctorIDIndex = rand(0, count($this->freeDoctorIDs) - 1);
                        
                        if(array_key_exists($randDoctorIDIndex, $filledDoctorIDIndex) == false) {
                            array_push($filledDoctorIDIndex, $randDoctorIDIndex);
                            
                            $this->schedDoctors[$shiftIndex++] = $this->freeDoctorIDs[$randDoctorIDIndex];
                        }
                    }
                    
                    // 移除剛才選上的醫師
                    foreach($filledDoctorIDIndex as $doctorIDIndex) {
                        array_splice($this->freeDoctorIDs, $doctorIDIndex, 1);
                    }
                }
            }
            
            echo '淡夜內科排完了18 : '.$shiftIndex.'<br>';
            
            // 淡夜外科人力需求1 $shiftIndex = 18
            if($allDocCount + $surDocCount) {
                // 人力充足
                $this->schedDoctors[$shiftIndex++] = $damsuiNightShiftDoctorIDs[rand(0, count($damsuiNightShiftDoctorIDs) - 1)];
            }else {
                // 人力短缺
                $this->getFreeDoctorIDs($this->getOnDoctors($day), $this->getOffDoctors($day), 'sur');
                
                $this->schedDoctors[$shiftIndex++] = $this->freeDoctorIDs[rand(0, count($this->freeDoctorIDs) - 1)];
            }
            
            echo '淡夜外科排完了19 : '.$shiftIndex.'<br>';
            
            
            //  將每日班表加入陣列中
            array_push($this->schedule, new ClassTable2($day + 1, $this->schedDoctors));
            
        }
        
        $this->printSchedule();
        $this->storeSchedule();
    }
    
    //  ==================  排班運算用  =========================
    
    // 尋找當日預約on班的醫師，若這一天沒有預約記錄回傳空陣列
    public function getOnDoctors($day) {
        // 參數說明：當天是幾號
        
        $doctors = [];
        foreach($this->onRes as $res) {
            if($day == $res->day) {
                // 如果預約的日期與傳入的參數相同則取得預約的醫師
                $doctors = $res->doctorsID;
                break;
            }
        }
        
        return $doctors;
    }
    
    // 尋找當日預約off班的醫師，若這一天沒有預約記錄回傳空陣列
    public function getOffDoctors($day) {
        // 參數說明：當天是幾號
        
        $doctors = [];
        foreach($this->offRes as $res) {
            if($day == $res->day) {
                // 如果預約的日期與傳入的參數相同則取得預約的醫師
                $doctors = $res->doctorsID;
                break;
            }
        }
        
        return $doctors;
    }
    
    // 尋找特定時段地區預約on班的醫生ID
    public function checkOnScheduleDoctors($day, $location, $dayOrNight) {
        // 參數說明：當天是幾號, 地區, 白班或夜班
        
        // 初始化陣列
        $this->onSchDoctorIDs = [];
        
        foreach($this->onRes as $res) {
            if($res->day == $day and $res->location == $location and $res->dayOrNight == $dayOrNight) {
                foreach($res->doctorsID as $doctorID) {
                    array_push($this->onSchDoctorIDs, $doctorID);
                }
            }
        }
    }
    
    // 計算此醫生列表中的各科人力資源數量
    public function countMajorResources($doctorIDList) {
        // 參數說明：醫生ID的列表
        
        // 宣告model
        $userObj = new User();
        
        $resourceDic = [
            'all' =>0,
            'med' => 0,
            'sur' => 0
        ];
        
        foreach($doctorIDList as $docID) {
            if($userObj->getDoctorInfoByID($docID)->major == 'All') {
                $resourceDic['all']++;
            }else if($userObj->getDoctorInfoByID($docID)->major == 'Surgical') {
                $resourceDic['sur']++;
            }else {
                $resourceDic['med']++;
            }
        }
        
        return $resourceDic;
    }
    
    // 取得沒有預約此時段但是有空的醫生 需指定專職科別
    public function getFreeDoctorIDs($onResDoctorIDs, $offResDoctorIDs, $major) {
        // 參數說明：預約on班的醫生, 預約off班的醫生
        
        $this->freeDoctorIDs = [];
        
        // 取得醫生的編號
        foreach($this->doctors as $doc) {
            $doctorID = $doc->doctorID;
            
            if(($doc->major == $major or $doc->major == 'all') and
                array_key_exists($doctorID, $onResDoctorIDs) == false and 
               array_key_exists($doctorID, $offResDoctorIDs) == false and
              array_key_exists($doctorID, $this->schedDoctors) == false) {
                
                // 如果沒有預約on班 沒有預約off班 沒有被排入當日班表 就加入列表
                array_push($this->freeDoctorIDs, $doctorID);
            }
        }
        
//        return $this->freeDoctorIDs;
    }
    
    // 列印出一個月份的班表
    public function printSchedule() {
        echo '<br>月份班表<br>';
        for($day = 0; $day < count($this->schedule); $day++) {
            echo 'Day : '.($day + 1).'<br>';
            echo print_r($this->schedule[$day]->shifts).'<br>';
        }
        
        foreach($this->schedule as $sch) {
            echo 'Day : '.$sch->day.'<br>';
            echo print_r($sch->shifts).'<br>';
        }
    }
    
    // 計算排班月份的假日日期
    public function getWeekendDate() {
        for($day = 1; $day < $this->monthInfo->daysOfMonth; $day++) {
            $dateStr = $this->monthInfo->year.'-';
            
            // 判斷月份
            if($this->monthInfo->month < 10) {
                $dateStr = $dateStr.'0'.$this->monthInfo->month;
            }else {
                $dateStr = $dateStr.$this->monthInfo->month;
            }
            
            // 判斷日
            if($day < 10) {
                $dateStr = $dateStr.'0'.$day;
            }else {
                $dateStr = $dateStr.$day;
            }
            
            $weekday = date('N', strtotime($dateStr));
            
            if($weekday == 6 or $weekday == 7) {
                array_push($this->weekendDate, $day);
            }
        }
    }
    
    // 將班表寫入資料庫
    public function storeSchedule() {
        $schObj = new Schedule();
        
        for($day = 0; $day < count($this->schedule); $day++) {
            // 取得每日班表
            $classTableObj = $this->schedule[$day];
            
            // 下面的迴圈代表每一天所有的表，應該要有19個
            for($schCateSerial = 0; $schCateSerial < count($classTableObj->shifts); $schCateSerial++) {
                // 處理日期字串
                $dateStr = $dateStr = $this->monthInfo->year.'-';
                
                // 判斷月份
                if($this->monthInfo->month < 10) {
                    $dateStr = $dateStr.'0';
                }
                
                $dateStr = $dateStr.$this->monthInfo->month.'-';
                
                // 判斷日期
                if(($day + 1) < 10) {
                    $dateStr = $dateStr.'0';
                }
                
                $dateStr = $dateStr.($day + 1);
                
                $schDic = [
                    'doctorID' => $classTableObj->shifts[$schCateSerial],
                    'schCategorySerial' => ($schCateSerial + 3),
                    'isWeekday' => array_key_exists($day, $this->weekendDate) == false,
                    'location' => (in_array(($schCateSerial + 3), $this->taipeiSchCateSerial))?"Taipei":"Tamsui",
                    'date' => $dateStr,
                    'endDate' => date('Y-m-d', strtotime($dateStr.'+1 day')),
                    'confirmed' => false,
                    'status' => 0
                ];
                
                $schObj->setSchedule($schDic);
            }
        }
        
        // call procedure

        $procedureMonthStr = $this->monthInfo->year.'-';
        if($this->monthInfo->month < 10) {
            $procedureMonthStr += '0';
        }
        $procedureMonthStr += $this->monthInfo->month;

        DB::select("CALL usp_FillShift('".$procedureMonthStr."');");

        $schObj->callProcedure();

    }
    
    
    //  ==================  準備資料用  =========================
    
    // 取得演算法使用的on班資訊
    private function getOnReservation() {
        $resObj = new Reservation();
        $docAndResObj = new DoctorAndReservation();
        $shiftCateObj = new ShiftCategory();
        
        $onResList = [];
        // 取得次月預約編號，依照預約日期排序
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
        // 取得次月預約編號，依照預約日期排序
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
        if($month == 12) {
            $year += 1;
            $month = 1;
        }else {
            $month += 1;
        }
        
        // 計算當月有幾天，取得排班次月第一日後往前推一天
        $theMonthAfter = 0;
        if($month == 12) {
            $theMonthAfter = 1;
        }else {
            $theMonthAfter += 1;
        }
        
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
