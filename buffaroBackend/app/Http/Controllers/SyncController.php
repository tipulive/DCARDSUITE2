<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class SyncController extends Controller
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

    public function syncAddUser($input)
    {

       /* DB::table("SyncOns")
        ->insert([
        "versionCount"=>,
        "subscriber"=>,
        "actionName"=>,
        "tableName"=>"users"
        ]);*/
    }
    public function SyncCardUpload($input)
    {
        $data=array();
        $chunckuploaded=count($input["onlineData"])>3?2:count($input["onlineData"]);
        for($i=0;$i<$chunckuploaded;$i++){
        $data[]=[
          "uid"=>$input["onlineData"][$i]["uid"],
          "uidCreator"=>$input["onlineData"][$i]["uidCreator"],
          "subscriber"=>$input["onlineData"][$i]["subscriber"],
          "uidUploader"=>$input["onlineData"][$i]["uidCreator"]

        ];

         }


         $check=DB::table("cards")
         ->insert($data);

         if($check)
         {
             //$numbrUploaded=count($input["onlineData"]);
            $check2=DB::update("update sync_offs set versionCount=versionCount+$chunckuploaded where subscriber=:subscriber and actionName=:actionName and tableName=:tableName limit 10",array(
                "subscriber"=>Auth::user()->subscriber,
                "actionName"=>"add",
                "tableName"=>"cards"
            ));
            if($check2)
            {
                return response([
                    // "allinput"=>$input,
                    // "data2"=>$input["item"],
                    "status"=>true,
                    "result"=>$data,
                     "countuploaded"=>$chunckuploaded,//because of index
                     "remainUploaded"=>count($input["onlineData"])-($chunckuploaded) //this for performance purpose only
                 ]);
            }
         }
         else{
return response([
    "status"=>"mene"
]);
         }



    }
    public function SyncCardDownload($input)//single Download
    {
        $versionCount=$input['versionCount'];
        $check=DB::select("SELECT * FROM sync_offs where versionCount>'$versionCount' and subscriber=:subscriber and actionName=:actionName and tableName=:tableName limit 1",array(

            "subscriber"=>Auth::user()->subscriber,
            "actionName"=>"add",
            "tableName"=>"cards"


        ));

       if($check)//download data and will go to mobile and add this data and add SyncAdd'download' and updated Syncoff versionCount to $versionCountOnline
       {
           $versionCountOnline=$check[0]->versionCount;
           $MaxVersion=$versionCountOnline-$versionCount;
           //$checkMax=$MaxVersion>50?10:$MaxVersion later on for optimization purpose
 $uidUser=Auth::user()->uid;
           $check1=DB::select("SELECT *from cards where subscriber=:subscriber and uidUploader!='$uidUser' and SyncAdd='new' or SyncAdd='uploaded' limit $versionCount,$MaxVersion",array(  //means it can not download own upload
               "subscriber"=>Auth::user()->subscriber,
               //"SyncAdd"=>"new"
           ));
           if($check1)
           {
            return response([
                "status"=>true,
                "result"=>$check1,
                "versionCountOnline"=>$versionCountOnline,//iyi niyo yingezi niyo ijya muri database ya offline
                "MaxVersion"=>$MaxVersion, //nzasimbuza $checkMax,
                "CurrentVersion"=>$versionCount,
                "SyncUid"=>$check[0]->uid



            ],200);
           }

       }
       else{

       }
    }
    public function syncAddCard($input)//online when user Add card using Web
    {
        $numbQr=$input['numberQr'];
        $check=DB::select("SELECT * FROM sync_offs where subscriber=:subscriber and actionName=:actionName and tableName=:tableName limit 1",array(

            "subscriber"=>Auth::user()->subscriber,
            "actionName"=>"add",
            "tableName"=>"cards"


        ));
        if($check){

         $check2=DB::update("update sync_offs set versionCount=versionCount+$numbQr where subscriber=:subscriber and actionName=:actionName and tableName=:tableName limit 10",array(
             "subscriber"=>Auth::user()->subscriber,
             "actionName"=>"add",
             "tableName"=>"cards"
         ));


        }
        else{
         $uid=preg_replace('/[^A-Za-z0-9-]/','',Auth::user()->name);//generated on production
         //echo $this->today;
         $uid=$uid.""."_".date(time());
         $check2=DB::table("sync_offs")
         ->insert([
          "uid"=>$uid,
         "subscriber"=>Auth::user()->subscriber,
         "actionName"=>"add",
         "versionCount"=>$numbQr,
         "tableName"=>"cards"
         ]);
        }

    }
    public function syncAddPromotion($input)
    {

    }
    public function syncAddEvents($input)//participateds
    {

    }
    public function syncAddTopup($input)
    {

    }

}
