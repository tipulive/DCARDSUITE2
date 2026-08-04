<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Controllers\SyncController;
use Illuminate\Support\Str;


class CardController extends Controller
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
        $this->Admin_Auth_error="You Are not authenticate please Request Permission to Admin";
        $this->Admin_Auth_result_error="0";//Admin auth result zero
        $this->platform1=env('PLATFORM3');
    }

    public function PrintCard($input){

        $check=DB::select("select *from cards where subscriber=:subscriber and status='none'",array("subscriber"=>Auth::user()->subscriber));

        return response([
            "status"=>true,
            "result"=>$check


        ],200);

    }

    public function Create($input)// i will eliminate this one
    {
        $filename=Auth::user()->subscriber.""."_".Str::random(2).""."_".date(time());
        $uid=Auth::user()->subscriber.""."_".Str::random(5).""."_".date(time());
        $check=DB::table("cards")
        ->insert([
        "uid"=>$uid,
        "uidCreator"=>Auth::user()->uid,
        "subscriber"=>Auth::user()->subscriber??"none"
        ]);
        if($check)
        {
            return \QrCode::size(500)
            ->format('png')
            //->merge('images/api.jpg', 0.5, true)
            ->generate($uid, public_path("images/Qr/".$filename.".png"));

        }
        else{

        }



    }

    public function CreateMultiple($input)//create Multiple card at once
    {
        //i will add forloop

        for($i=0;$i<$input["numberQr"];$i++){

            $filename=Auth::user()->subscriber.""."_".Str::random(2).""."_".date(time());
            $uid=Auth::user()->subscriber.""."_".Str::random(5).""."_".date(time());
            $CardNumber=mt_rand(100000,999999)."".date(time());
            $check=DB::table("cards")
                  ->insert([
                    "uid"=>$uid,
                    "uidCreator"=>Auth::user()->uid,
                    "CardNumber"=>$CardNumber,
                    "filename"=>$filename,
                    //"syncadd"=>"downadd",
                    //"syncupdate"=>"downupdate",

                    "subscriber"=>Auth::user()->subscriber??"none",
                    "created_at"=>$this->today
                    ]);
                    \QrCode::size(500)
                    ->format('png')
                    //->merge('images/api.jpg', 0.5, true)
                   // ->generate($uid, public_path("images/Qr/".$filename.".png"));
                   ->generate($uid,"images/Qr/".$filename.".png");




                    if($i==($input["numberQr"]-1))
                    {
                       // (new SyncController)->syncAddCard($input); this i will make it active if i will add mobile offline and online
                       return response([
                           "status"=>true,
                           "result"=>$i,




                           ],200);
                           break;
                    }
                    else{


                    }
       }

    }
    public function AssignCard($input) //Company assign Card to user
    {

        $check=DB::update("update users set carduid=:carduid where phone=:phone and Ccode=:Ccode",array(
            "Ccode"=>$input["Ccode"],//phone ,
            "phone"=>$input["phone"],//phone ,
            "carduid"=>$input["carduid"]//carduid,
        ));
        if($check)
        {

         return response([
             "status"=>true,
             "result"=>$check


         ],200);
        }
        else{
         return response([
             "status"=>false,
             "result"=>$check,

         ],200);
        }

    }
    public function GetNumberDetail($input)
    {

        $PhoneNumber=$input['Ccode']."".$input['phone'];
        $check1=DB::select("select *from users where PhoneNumber=:PhoneNumber and subscriber=:subscriber limit 1",array(
            "PhoneNumber"=>$PhoneNumber,
            "subscriber"=>auth::user()->subscriber
        ));
        if($check1)
        {

         return response([
             "status"=>true,
             "UserDetail"=>[
                "uid"=>$check1[0]->uid,
                "name"=>$check1[0]->name,
                "email"=>$check1[0]->email,
                "phone"=>$check1[0]->phone,
                "Ccode"=>$check1[0]->Ccode,
                "country"=>$check1[0]->country,
                "initCountry"=>$check1[0]->initCountry,
                "PhoneNumber"=>$check1[0]->PhoneNumber,
                "carduid"=>$check1[0]->carduid

             ],



         ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$check1,

            ],200);
           }
    }
    public function GetCardDetail($input){// to check if he is already reach target

        $check1=DB::select("select *from users where carduid=:carduid and subscriber limit 1",array(
            "carduid"=>$input["carduid"],
            "subscriber"=>auth::user()->subscriber
        ));
        if($check1)
        {

         return response([
             "status"=>true,
             "UserDetail"=>[
                "uid"=>$check1[0]->uid,
                "name"=>$check1[0]->name,
                "email"=>$check1[0]->email,
                "phone"=>$check1[0]->phone,
                "Ccode"=>$check1[0]->Ccode,
                "country"=>$check1[0]->country,
                "initCountry"=>$check1[0]->initCountry,
                "PhoneNumber"=>$check1[0]->PhoneNumber,
                "carduid"=>$check1[0]->carduid

             ],



         ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$check1,

            ],200);
           }






    }

    /*public function GetCardDetail($input){// to check if he is already reach target deprecated

        $check=DB::select("select *from participateds where carduid=:carduid limit 1",array(
            "carduid"=>$input["carduid"],
        ));
        if($check)
        {
            return response([
                "status"=>false,
                "result"=>$check,

            ],200);
        }
        else{

            $check1=DB::select("select *from users where carduid=:carduid limit 1",array(
            "carduid"=>$input["carduid"],
        ));
        if($check1)
        {

         return response([
             "status"=>true,
             "UserDetail"=>[
                "uid"=>$check1[0]->uid,
                "name"=>$check1[0]->name,
                "email"=>$check1[0]->email,
                "phone"=>$check1[0]->phone,
                "Ccode"=>$check1[0]->Ccode,
                "country"=>$check1[0]->country

             ],



         ],200);
        }
        else{
         return response([
             "status"=>false,
             "result"=>$check1,

         ],200);
        }

        }






    }*/
}
