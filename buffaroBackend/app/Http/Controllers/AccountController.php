<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\account\User_ACC_Controller;
use App\Http\Controllers\account\Admin_ACC_Controller;
use Auth;
use DB;


class AccountController extends Controller
{
    //

    public  function testAccount(Request $request){
        return response([
            "status"=>true,
            "result"=>'hello',

        ],200);
    }
    public function view(){
        if(Auth::check())
        {

           return (new User_ACC_Controller)->view();
        }
        else if(Auth::guard('Admin')->check())
        {
            return (new Admin_ACC_Controller)->view();
        }
    }

    public function update(Request $request)
    {
        $input=$request->all();
        $platform1=env('PLATFORM1');
        if(Auth::check())
        {
            if(Auth::user()->platform==$platform1)
            {
                return (new Admin_ACC_Controller)->update($input);
            }
            else{
                return (new User_ACC_Controller)->update($input);
            }
        }

    }
    public function delete($input){
        if(Auth::check())
        {
            return (new User_ACC_Controller)->delete($input);
        }
        else if(Auth::guard('Admin')->check())
        {
            return (new Admin_ACC_Controller)->delete($input);
        }
    }

    public function logout(Request $request){

            //return (new User_ACC_Controller)->logout($input);

            //auth()->logout();


              //auth()->user()->currentAccessToken()->delete();

              //$request->user()->currentAccessToken()->delete();
             // $user->tokens()->where('id', $tokenId)->delete();


         return $this->LogoutUSer();
    }
    public function LogoutUSer(){//admin or user

        if(auth()->user()->currentAccessToken()->delete())
        {
            return response([
                "status"=>true

            ],200);
        }
        else{
            return response([
                "status"=>true

            ],201);
        }
    }


    public function login(){
       // return view('login');
       return response([
        "status"=>Auth::user()

    ],200);
    }
}
