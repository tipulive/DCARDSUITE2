<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class User_ACC_Controller extends Controller
{
    //
    public function view(){

        $uid=Auth::user()->uid;
        $subscriber=Auth::user()->subscriber;
        $link=env('PLATFORM3')==(Auth::user()->platform)?'company/'.$subscriber.'':'admin/'.$uid.'';

        $users=array(

            "uid"=>Auth::user()->uid,
            "email"=>Auth::user()->email,
           // "name"=>Auth::user()->name,
            "name"=>Auth::user()->name,
            "companyName"=>Auth::user()->CompanyName,
            "subscriber"=>Auth::user()->subscriber,
            "link"=>$link,

            "country"=>Auth::user()->country,

    );

    return response([
        "result"=>true,
        "response"=>$users
            ],200);

    }
    public function ViewUsers($input)
    {
        $check=DB::select("select name,created_at,userid,platform from users");
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

      ],201);
     }
    }
    public function ChangePlatform($input)//status
    {
        $check=DB::update("update admins set status=:status where uid=:uid",array(
            "status"=>$input["status"],
            "uid"=>$input["userid"],
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

      ],201);
     }
    }
    public function SearchUserByName($input)
    {
        $Name=$input['name'];
         $check=DB::select("SELECT name,userid,email,tel,country
         FROM users
         WHERE `name` LIKE '%$Name%' limit 10",array(

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
    public function update($input)
    {
        $password=isset($input['password'])?$input['password']:Auth::user()->passdecode;
        $name=isset($input['name'])?$input['name']:Auth::user()->name;


        $check=Auth::user()->update(array( //this work only when you add fillable field on your models
            "name"=>$name,
            "password"=>bcrypt($password),
            "passdecode"=>$password

            ));
        if($check)
        {

            //Auth::user()->fresh();
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

        $check=DB::delete("delete from users where userid=:userid limit 1",array(
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

        auth()>logout();

    }


}
