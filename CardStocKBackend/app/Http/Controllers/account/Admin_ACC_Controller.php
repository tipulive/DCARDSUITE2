<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class Admin_ACC_Controller extends Controller
{
    //

   //
   public function view(){

    $users=array(

        "userid"=>Auth::user()->userid,
        "email"=>Auth::user()->email,
       // "name"=>Auth::user()->name,
        "fname"=>Auth::user()->fname,
        "lname"=>Auth::user()->lname,
        "password"=>Auth::user()->passdecode,
        "tel"=>Auth::user()->tel,
        "country"=>Auth::user()->country,

);

return response([
    "result"=>true,
    "response"=>$users
        ],200);

}
public function update($input)
{
    $password=isset($input['password'])?$input['password']:Auth::user()->passdecode;
        $name=isset($input['name'])?$input['name']:Auth::user()->name;

    /*$check=DB::update("update admins set name=:name,password=:password,passdecode=:passdecode where userid=:userid limit 1",array(
        "userid"=>Auth::user()->userid,
       // "fname"=>$input['fname'],
        //"lname"=>$input['lname'],
        "name"=>$name,
            //"email"=>$input['email'],
           // "tel"=>$input['tel'],
            "password"=>bcrypt($password),
            "passdecode"=>$password,
    ));*/

    $check=Auth::user()->update(array( //this work only when you add fillable field on your models
        "name"=>$name,
        "password"=>bcrypt($password),
        "passdecode"=>$password

        ));
    if($check)
    {
        $checkUpdate=DB::update("update users set name=:name where uid=:uid and subscriber=:subscriber",[
            "uid"=>Auth::user()->uid,
            "name"=>$name,
            "subscriber"=>Auth::user()->subscriber,
        ]);
        if($checkUpdate){
            return response([
                "status"=>true,
                "userProfileName"=>Auth::user()->name,
                "result"=>$check,

            ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$check,

            ],200);
        }

    }
    else{
     return response([
         "status"=>false,
         "result"=>$check,

     ],200);
    }

}
public function delete($input){

    $check=DB::delete("delete from admins where userid=:userid limit 1",array(
        "userid"=>Auth::user()->userid,
    ));
    if($check)
    {
     return response([
         "status"=>true,
         "result"=>$check,

     ],200);
    }
    else{
     return response([
         "status"=>false,
         "result"=>$check,

     ],200);
    }

}
    public function Logout($input){

        auth()->guard('Admin')->logout();

    }
}
