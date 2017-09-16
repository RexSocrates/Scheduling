<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/doctors';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:Doctor',
            'birthday' => 'required|string|min:4',
            'name' => 'required|string|max:255',
            'level' => 'required|string',
            'major' => 'required|string',
            'location' => 'required|string',
            'identity' => 'required|string'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['birthday']),
            'major' => $data['major'],
            'level' => $data['level'],
            'location' => $data['location'],
            'identity' => $data['identity'],
            'totalShift' => $data['totalShift'],
            'mustOnDutyTotalShifts' => $data['mustOnDutyTotalShifts'],
            'mustOnDutyMedicalShifts' => $data['mustOnDutyMedicalShifts'],
            'mustOnDutySurgicalShifts' => $data['mustOnDutySurgicalShifts'],
            'mustOnDutyTaipeiShifts' => $data['mustOnDutyTaipeiShifts'],
            'mustOnDutyTamsuiShifts' => $data['mustOnDutyTamsuiShifts'],
            'mustOnDutyDayShifts' => $data['mustOnDutyDayShifts'],
            'mustOnDutyNightShifts' => $data['mustOnDutyNightShifts'],
            'weekendShifts' => $data['weekendShifts']
        ]);
    }
    
    // 顯示註冊表單
    public function showRegistrationForm() {
        return view('testPage.registerForm');
//        return view('system.pages.doctor');
    }
}
