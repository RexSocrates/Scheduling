<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;

class TestController extends Controller
{
    
    public function getUserID() {
        echo 'User ID : '.User::getCurrentUserID();
    }
    
    public function getDateForm() {
        return view('testPage.testDate');
    }
    
    public function getDateValue() {
        $date = Input::get('date');
        
        echo $date;
    }
}
