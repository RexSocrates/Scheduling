<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Remark;
use App\User;

class RemarkController extends Controller

{
    // 取得特定月份的備註紀錄
    public function getRemarkByMonth(Request $request){
   		$data = $request->all();
        $month = $data['month'];

        $remark = new Remark();
        $userObj = new User();

        $remarks = $remark->getRemarksByMonth($month);

        $displayRemarksArr = [];

        foreach($remarks as $remark) {
            $remarkDic = [
                'author' => '',
                'date' => $remark->date,
                'content' => $remark->remark
            ];
            
            $remarkDic['author'] = $userObj->getDoctorInfoByID($remark->doctorID)->name;
            
            array_push($displayRemarksArr, $remarkDic);
        }
        
        return $displayRemarksArr;
   }
}
