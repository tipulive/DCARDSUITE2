<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class notifyController extends Controller
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

    public function notifyAdmin(mixed $input)
    {
        $perm= $input["permission"];

        if (empty($input["permission"])) {

        }
        else{
 $number=0;
       for($i=0;$i<count($perm);$i++)
        {
          $check=DB::table("notify")
            ->insert([
                "uid"=>$input["uid"],//this is similar to action Uid,for example if it is caisse, it means it is caisse Uid
                "status"=>env('STATUS_REQUEST'),
                "permission"=>$perm[$i]["permission"],
                "notificationType"=>$input["notificationType"]??'none',
                "notifyApproval"=>$perm[$i]["approvalAction"]??'0',//equal 1,less 1,greater 1  abantu bakwiye kuyikuramo cg kwemeza
               // "notifyCount"=>$input["notifyCount"]??'0',//count
                "subscriber"=>Auth::user()->subscriber,
                "uidCreator"=>Auth::user()->uid,
                "title"=>$input["title"],
                "message"=>$input["message"],
                "created_at"=>$this->today,
            ]);
            if ($check) {
                $number++;
            }


        }
       if($number==count($perm))
       {
        return true;
       }
       else{
        return false;
       }
        }

    }


public function updateNotify(mixed $input)
{
    return DB::update("update notify set approvalAction=approvalAction-1 where uid=:uid limit 1",[
        "uid"=>$input['uid']
    ]);
}

 public function checkPermNotify(mixed $input): array//this is to check if this action exists
{
    try {//this is a permissionACtion when i setup Action what user will access it

        $check = DB::select(
            "SELECT permission FROM permissionACtion
             WHERE action = :action
             AND subscriber = :subscriber
             AND status = :status
             LIMIT 1",
            [
                "action" => $input["action"],
                "subscriber" => Auth::user()->subscriber,
                "status" => env('STATUS_ACTIVE')
            ]
        );

        if (empty($check)) {
            return [
                'status' => false,
                'error' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'error' => false,
            'data' => $check[0]->permission
        ];

    } catch (\Illuminate\Database\QueryException $e) {

        \Log::error('checkNotify failed: ' . $e->getMessage());

        return [
            'status' => false,
            'error' => true,
            'data' => null
        ];
    }
}}

