<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfficialLeave;
use App\User;
use App\MustOnDutyShiftPerMonth;

class LeaveController extends Controller
{
	//排班人員確認公假
    public function confirmOffcialLeave($serial){
    	$officialLeave = new OfficialLeave();
        $mustOnDutyShiftPerMonth =new MustOnDutyShiftPerMonth();
    	$user = new User();

        $dutyInfo=[];
        $countOnDutyShift=[];

        $leave = $officialLeave->getLeaveBySerial($serial);
        $doctorID = $officialLeave->getLeaveBySerial($serial)->doctorID;
    	$leaveDic=[
    		'serial'=>$serial,
    		'confirmingPerson'=>$user->getCurrentUserID(),
            'updatedLeaveHours'=>'',
            'leaveHours'=>$leave->leaveHours,
    		'newStatus'=>1
    	];

        $leaveDic['updatedLeaveHours'] = $user->getDoctorInfoByID($leave->doctorID)->currentOfficialLeaveHours+$leave->leaveHours;


    	$doctor = $user->getDoctorInfoByID($leave->doctorID);
    	$officialLeave->changeConfirmStatus($leaveDic);
    	$officialLeave->updateLeaveHours($leave->doctorID,$doctor->currentOfficialLeaveHours+$leave->leaveHours);


        $onDutyInfo=[
            'doctorID' => $doctorID,
            'leaveMonth'=>$leave->leaveMonth,
            'mustOnDutyShift'=>""
        ];

        $onDutyInfo['mustOnDutyShift']=($user->getDoctorInfoByID($doctorID)->mustOnDutyTotalShifts)+(($leave->leaveHours)/12);

        $count = $mustOnDutyShiftPerMonth->countOnDutyShift($onDutyInfo);
        if($count == 0){
            $mustOnDutyShiftPerMonth->addOnDutyShift($onDutyInfo);
        }
        else{

         $updateOnDutyInfo=[
                'doctorID' => $doctorID,
                'month'=>$leave->leaveMonth,
                'updateMustOnDutyShift'=>""
            ];
          $updateOnDutyInfo['updateMustOnDutyShift']=($mustOnDutyShiftPerMonth->getOnDutyShift($onDutyInfo)->mustOnDutyShift)+($leave->leaveHours/12);
            $mustOnDutyShiftPerMonth->updateOnDutyShift($updateOnDutyInfo);
            
        }

    	return redirect('officialLeave');
    }

    //排班人員拒絕公假
    public function unconfirmOffcialLeave($serial){
    	$officialLeave = new OfficialLeave();
    	$user = new User();
    	$leaveDic=[
    		'serial'=>$serial,
    		'confirmingPerson'=>$user->getCurrentUserID(),
            'leaveHours'=>0,
            'updatedLeaveHours'=>$user->getCurrentUserInfo()->currentOfficialLeaveHours,
    		'newStatus'=>2
    	];

    	$officialLeave->changeConfirmStatus($leaveDic);

    	return redirect('officialLeave');
    }

     // 取奪所有醫師的已確認公假紀錄
    public function getOfficialLeavePage() {

        $user = new User();
        $officialLeave = new OfficialLeave();

        $leaves= $officialLeave->getconfirmLeaves();

        $leaveArr = [];
        foreach ($leaves as $leave) {
            $leaveDic =[
                'date' =>$leave->recordDate,
                'confirmingPerson' =>'',
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$leave->updatedLeaveHours,
                'remark'=>$leave->remark
            ];
            if($leave->confirmStatus != 0){
                $leaveDic['confirmingPerson'] = $user->getDoctorInfoByID($leave->confirmingPersonID)->name;
            }

            $leaveDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;

            array_push($leaveArr,$leaveDic);
        }

        $doctors= $user->getDoctorList();
        $doctorName = [];

        foreach ($doctors as $doctor) {
            $doctorDic =[
                'id' => $doctor->doctorID,
                'name' => $doctor->name,
                
            ];

           
            array_push($doctorName,$doctorDic);
        }
        
        $unconfirmLeaves = $officialLeave->getUnconfirmLeaves();
        $unconfirmLeaveArr = [];
        foreach ($unconfirmLeaves as $leave) {
            $unconfirmLeaveDic =[
                'serial' => $leave->leaveSerial,
                'date' =>$leave->recordDate,
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$user->getDoctorInfoByID($leave->doctorID)->currentOfficialLeaveHours,
                'remark'=>$leave->remark
            ];
            
            $unconfirmLeaveDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;

            array_push($unconfirmLeaveArr,$unconfirmLeaveDic);
        }

        $rejectedAndConfirmLeaves = $officialLeave->getRejectedAndConfirmLeaves();
        $rejectedAndConfirmArr = [];
        foreach ($rejectedAndConfirmLeaves as $leave) {
            $rejectedAndConfirmDic =[
                'serial' => $leave->leaveSerial,
                'confirmingPerson' =>'',
                'date' =>$leave->recordDate,
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$leave->updatedLeaveHours,
                'confirmStatus' => $leave->confirmStatus, 
                'remark'=>$leave->remark
            ];
            
            $rejectedAndConfirmDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;
            $rejectedAndConfirmDic['confirmingPerson'] = $user->getDoctorInfoByID($leave->confirmingPersonID)->name;

            array_push($rejectedAndConfirmArr,$rejectedAndConfirmDic);
        }



            //return $doctorsLeave;
        return view('pages.officialaffair', [
            'leaveArr' => $leaveArr,
            'rejectedAndConfirmArr' => $rejectedAndConfirmArr,
            'unconfirmLeaveArr' =>$unconfirmLeaveArr,
            'doctors' => $doctorName,
        ]);
       
    }
    
    // 時數存摺
    public function getTimeRecord() {

        $user = new User();
        $officialLeave = new OfficialLeave();

        $leaves= $officialLeave->getconfirmLeaves();

        $leaveArr = [];
        foreach ($leaves as $leave) {
            $leaveDic =[
                'date' =>$leave->recordDate,
                'confirmingPerson' =>'',
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$leave->updatedLeaveHours,
                'remark'=>$leave->remark
            ];
            if($leave->confirmStatus != 0){
                $leaveDic['confirmingPerson'] = $user->getDoctorInfoByID($leave->confirmingPersonID)->name;
            }

            $leaveDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;

            array_push($leaveArr,$leaveDic);
        }

        $doctors= $user->getDoctorList();
        $doctorName = [];

        foreach ($doctors as $doctor) {
            $doctorDic =[
                'id' => $doctor->doctorID,
                'name' => $doctor->name,
                'totalLeaveHours'=> $doctor->currentOfficialLeaveHours
            ];

            array_push($doctorName,$doctorDic);
        }
        
        $unconfirmLeaves = $officialLeave->getUnconfirmLeaves();
        $unconfirmLeaveArr = [];
        foreach ($unconfirmLeaves as $leave) {
            $unconfirmLeaveDic =[
                'serial' => $leave->leaveSerial,
                'date' =>$leave->recordDate,
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$user->getDoctorInfoByID($leave->doctorID)->currentOfficialLeaveHours,
                'remark'=>$leave->remark
            ];
            
            $unconfirmLeaveDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;

            array_push($unconfirmLeaveArr,$unconfirmLeaveDic);
        }

        $rejectedAndConfirmLeaves = $officialLeave->getRejectedAndConfirmLeaves();
        $rejectedAndConfirmArr = [];
        foreach ($rejectedAndConfirmLeaves as $leave) {
            $rejectedAndConfirmDic =[
                'serial' => $leave->leaveSerial,
                'confirmingPerson' =>'',
                'date' =>$leave->recordDate,
                'doctor' =>'',
                'hours'=>$leave->leaveHours,
                'updatedLeaveHours'=>$leave->updatedLeaveHours,
                'confirmStatus' => $leave->confirmStatus, 
                'remark'=>$leave->remark
            ];
            
            $rejectedAndConfirmDic['doctor'] = $user->getDoctorInfoByID($leave->doctorID)->name;
            $rejectedAndConfirmDic['confirmingPerson'] = $user->getDoctorInfoByID($leave->confirmingPersonID)->name;

            array_push($rejectedAndConfirmArr,$rejectedAndConfirmDic);
        }



            //return $doctorsLeave;
        return view('pages.timeRecord', [
            'leaveArr' => $leaveArr,
            'rejectedAndConfirmArr' => $rejectedAndConfirmArr,
            'unconfirmLeaveArr' =>$unconfirmLeaveArr,
            'doctors' => $doctorName,
        ]);
       
    }
    
    public function getTimeRecordDetails($id) {

        $officialLeave=new OfficialLeave();
        $user = new User();
        $doctorOfficialLeave = $officialLeave->getLeavesByDoctorID($id);

        $officialLeaveArr =[];

        foreach ($doctorOfficialLeave as $leave) {
            $leaveDic =[
                'name'=>$user->getDoctorInfoByID($id)->name,
                'date' => $leave->recordDate,
                'remark' => $leave->remark,
                'hour' => $leave->leaveHours,
                'status'=> ''
            ];

            
            array_push($officialLeaveArr,$leaveDic);

        }

        
        return view('pages.timeRecordDetails',[
            'doctorOfficialLeave'=>$officialLeaveArr,
            'doctorName'=>$user->getDoctorInfoByID($id)->name

        ]);
    }

    
    //排班人員加入公假
    public function addOfficialLeaveByAdmin(Request $request) {
        $data = $request->all();

        $user = new User();
        $officialLeave = new officialLeave();

        if($data['classification']==1){
            $leaveHours= $data['hour'];
        }
        if($data['classification']==0){
            $leaveHours= -1*$data['hour'];
        }

        $currentOfficialLeaveHours=$user->getDoctorInfoByID($data['doctor'])->currentOfficialLeaveHours+$leaveHours;

        $leave = [
            'doctorID' => $data['doctor'],
            'confirmingPersonID' => $user->getCurrentUserInfo()->doctorID,
            'leaveHours'=> $leaveHours,
            'updatedLeaveHours'=> $currentOfficialLeaveHours,
            'remark' => $data['content'],
            'confirmStatus'=>1

        ];

        $leave = $officialLeave->addLeaveByAdmin($leave);

        $updateLeaveHours = $officialLeave->updateLeaveHours($data['doctor'],$currentOfficialLeaveHours);

        return redirect('officialLeave');
        
    }
}
