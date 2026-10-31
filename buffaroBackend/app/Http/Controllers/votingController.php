<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class votingController extends Controller
{
    //
     public string $today;
     public string $curdate;
    public string $Appstate;
    public string $AppName;
    public string $otp;
    public string $email_confirm;
    public string $Admin_Auth_error;
    public string $Admin_Auth_result_error;
    public string $platform1;
     //
     public function __construct()
     {
         date_default_timezone_set(env('TIME_ZONE'));
         $this->today = date('Y-m-d H:i:s', time());
         $this->curdate=date('Y-m-d', time());
         $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
         $this->AppName=env('APP_NAME');

         $this->otp='1 hours';
       // $this->otp='20 seconds';//test purpose
         $this->email_confirm='24 hours';
         $this->Admin_Auth_error="You Are not authenticate please Request Permission to Admin";
         $this->Admin_Auth_result_error="0";//Admin auth result zero
         $this->platform1=env('PLATFORM3');
     }


     public function votingSetup(mixed $input)
     {
        /*nukuvugango hano  ,nibo  bagomba ku making sure ko bose batoye yes*/
        /* ni igihe nshobora ku limitating umubare wabantu bashobora gutora*/
         return DB::table("voting")
                ->insert([
                    "actionName"=>$input["actionName"],
                    "status"=>env('STATUS_ACTIVE'),
                    "subscriber"=>Auth::user()->subscriber,
                    "uidCreator"=>Auth::user()->uid,
                    "approvalVote"=>$input["approvalVote"],
                    "limitVote"=>$input["limitVote"]??'0',
                    "commentData"=>$input["commentData"]??'none',
                    "created_at"=>$this->today,
                ]);


     }

     public function votingUpdate(mixed $input)
     {
         return DB::update("update voting set actionName=COALESCE(NULLIF(:actionName,''),actionName),approvalVote=COALESCE(NULLIF(:approvalVote,''),approvalVote),limitVote=COALESCE(NULLIF(:limitVote,''),limitVote),commentData=COALESCE(NULLIF(:commentData,''),commentData),updated_at=:updated_at where uid=:uid and subscriber=:subscriber limit 1",[
             "actionName"=>$input["actionName"]??'none',
             "approvalVote"=>$input["approvalVote"]??'0',
             "limitVote"=>$input["limitVote"]??'0',
             "commentData"=>$input["commentData"]??'none',
             "updated_at"=>$this->today,
             "uid"=>$input["uid"],
             "subscriber"=>Auth::user()->subscriber
         ]);
     }
     public function votingRemove(mixed $input)
     {
         return DB::delete("delete from voting where uid=:uid and subscriber=:subscriber limit 1",[
             "uid"=>$input["uid"],
             "subscriber"=>Auth::user()->subscriber
         ]);
     }
     public function votingView(mixed $input)
     {
         return DB::select("select *from voting where uid=:uid and subscriber=:subscriber limit 1",[
             "uid"=>$input["uid"],
             "subscriber"=>Auth::user()->subscriber
         ]);
     }
     public function votingViewAll(mixed $input)
     {
         return DB::select("select *from voting where subscriber=:subscriber",[
             "subscriber"=>Auth::user()->subscriber
         ]);
     }
}
