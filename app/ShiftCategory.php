<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class ShiftCategory extends Model
{
    protected $table = "ShiftCategory";

    // 回傳班別的名稱
    public function findName($serial){
    	$name = DB::table('ShiftCategory')->where("categorySerial",$serial)->first();
        
    	return $name->categoryName;
    }
    
    // 回傳該 shift category的地點以及on/off資訊
    public function getCategoryInfo($categorySerial) {
        // 有可能要再增加白夜班等資訊
        $info = [
            'location' => '',
            'isOn' => true,
            'dayOrNight' => 'day'
        ];
        
        switch($categorySerial) {
            case 1 : 
                $info['location'] = 'Taipei';
                break;
            case 2 : 
                $info['location'] = 'Taipei';
                break;
            case 3 : 
                $info['location'] = 'Taipei';
                break;
            case 4 : 
                $info['location'] = 'Taipei';
                $info['dayOrNight'] = 'night';
                break;
            case 5 : 
                $info['location'] = 'Tamsui';
                break;
            case 6 : 
                $info['location'] = 'Tamsui';
                $info['dayOrNight'] = 'night';
                break;
            case 7 : 
                $info['isOn'] = false;
                break;
        }
        
        return $info;
    }
    
    // 回傳該時間、院區的預約人數是否超過缺額
    public function exceedLimit($numberOfPeople, $categorySerial) {
        if($categorySerial == 3 or $categorySerial == 4){   //台北白班 台北夜班
            if($numberOfPeople >= 6){
                return true;
            }else {
                return false;
            }
        }
        
        if($categorySerial == 5){     //淡水白班
            if($numberOfPeople >= 4){
                return true;
            }else {
                return false;
            }
        }
        if($categorySerial == 6){     //淡水夜班
            if($numberOfPeople >= 2){
                return true;
            }else {
                return false;
            }
        }
    }
}
