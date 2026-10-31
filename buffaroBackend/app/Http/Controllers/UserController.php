<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Controllers\OrderController;
/*use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;*/
use App\Http\Controllers\Auth\AuthUserRegisterController;
use App\Http\Controllers\Auth\AuthUserLoginController;


class UserController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';
        $this->User_Auth_error="You Are not authenticate please Request Permission to Admin";
        $this->User_Auth_result="0";

    }



    public function UserRegisterEmail(Request $request){
        $input=$request->all();

        return (new AuthUserRegisterController)->UserRegisterEmail($input);

    }

    public function UserLoginEmail(Request $request){
        $input=$request->all();

        return (new AuthUserLoginController)->UserLoginEmail($input);
       // return "hell";

    }
    public function UserLoginPhone(Request $request){
        $input=$request->all();

        return (new AuthUserLoginController)->UserLoginPhone($input);

    }
    public function UserViewProfile(Request $request){
        if(Auth::check())
        {
            $input=$request->all();

            return (new AccountController)->view($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }

    }

    public function UserUpdateProfile(Request $request){

      if(Auth::check())
        {
            $input=$request->all();

           return (new AccountController)->update($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }

    }
    public function UserDeleteProfile(Request $request){

        if(Auth::check())
        {
            $input=$request->all();
         return (new AccountController)->delete($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }
    }
    public function UserLogoutProfile(Request $request){

       if(Auth::check())
        {
            $input=$request->all();
            return (new AccountController)->logout($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }
    }
    public function UserResetPassword(Request $request){
        if(Auth::check())
        {
            $input=$request->all();
           // return (new AccountController)->logout($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }
    }
    public function UserDeleteAccount(Request $request){

        if(Auth::check())
        {
            $input=$request->all();
           // return (new AccountController)->logout($input);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->User_Auth_result,
                "error"=>$this->User_Auth_error,
            ],200);
        }

    }









}
