<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;

class AuthUserLoginController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';

    }
    //
    public function UserLoginEmail($input){

        if(Auth::attempt([

			'email'=>$input['email'], //means if it check username table =to input name them add input name;
			'password'=>$input['password'],


		]))

		{
           $user=auth::user();
            $success['token']=$user->createToken('MyApp')->plainTextToken;
            $success['name']=$user->email;

            return response([
                "status"=>true,
                //"result"=>$_SERVER,
                "token"=>$success['token'],
                "User"=>[
                    "first_name"=>Auth::user()->fname,
                    "last_name"=>Auth::user()->name,
                    "email"=>Auth::user()->email,
                    "tel"=>Auth::user()->phone,
                ]

            ],200);

		}
        else{
            return response([
                "status"=>false,


            ],200);

        }
    }
    public function UserLoginPhone($input){
        if(Auth::attempt([

			'phone'=>$input['phone'], //means if it check username table =to input name them add input name;
			'password'=>$input['password'],


		]))

		{

            return response([
                "status"=>true,
                "result"=>$check,

            ],200);

		}

	else{
        return response([
            "status"=>false,


        ],200);

    }

    }
    public function Reset_with_email($input){

    }
    public function Reset_with_phone($input){

    }
}
