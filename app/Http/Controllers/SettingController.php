<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
	//傳輸月份
    public function getSettingPage(){


        $nextMonth=date("m", strtotime('+1 month'));

        return view('pages.setting', array('month'=> $nextMonth ));

    }
}
