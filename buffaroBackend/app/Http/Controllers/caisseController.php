<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\StockController;

class caisseController extends Controller
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

    public function reqCaisse(mixed $input):array//kuri buffaro caisse
    {
        $uid=(new StockController)->CreateUid($input);
         // "uidApprove"=>,
      $check=DB::table("reqCaisse")
      ->insert([
          "uid"=>$uid,
          "status"=>env('STATUS_REQUEST'),
          "purpose"=>$input["purpose"]??'none',
          "source"=>$input["source"]??'none',
          "commentData"=>$input["commentData"]??'none',
          "subscriber"=>Auth::user()->subscriber,
          "uidReq"=>Auth::user()->uid,
          "approvalVote"=>$input["approvalVote"]??'0',
          "amount"=>$input["amount"],
          "currency"=>$input["currency"],
          "created_at"=>$this->today,
      ]);
      if($check)
        {
         return [
            'status'=>true,
            'uid'=>$uid
         ];
        }else{
            return [
                'status'=>false
            ];

        }
    }

    public function editReqCaisse(mixed $input){
        return DB::update("update reqCaisse set amount=COALESCE(NULLIF(:amount,''),amount),currency=COALESCE(NULLIF(:currency,''),currency),purpose=COALESCE(NULLIF(:purpose,''),purpose),source=COALESCE(NULLIF(:source,''),source),commentData=COALESCE(NULLIF(:commentData,''),commentData),updated_at=:updated_at where uidReq=:uidReq and uid=:uid and status=:status, subscriber=:subscriber limit 1 ",[
            "uid"=>$input["uid"],
            "status"=>env('STATUS_REQUEST'),
            "purpose"=>$input["purpose"]??'none',
            "source"=>$input["source"]??'none',
            "commentData"=>$input["commentData"]??'none',
            "subscriber"=>Auth::user()->subscriber,
            "uidReq"=>Auth::user()->uid,
            "amount"=>$input["amount"],
            "currency"=>$input["currency"],
            "updated_at"=>$this->today,
        ]);
    }
    public function delReqCaisse(mixed $input){
        return DB::delete("delete from reqCaisse where uid=:uid and status=:status and uidReq=:uidReq limit 1",[
            "uid"=>$input["uid"],
            "uidReq"=>Auth::user()->uid,
            "status"=>env('STATUS_REQUEST')
        ]);
    }
    public function UpdateCaisseStatus(mixed $input){
      return DB::update("update reqCaisse set status=:status,voter=voter+:vote,votingCount=votingCount+:votingCount,uidApprove=:uidApprove,updated_at=:updated_at where uid=:uid and subscriber=:subscriber limit 1",[
          "uid"=>$input["uid"],
          "voter"=>$input["voter"],
          "votingCount"=>$input["votingCount"]??'0',
          "status"=>$input["status"],
          "uidApprove"=>Auth::user()->uid,
          "subscriber"=>Auth::user()->subscriber,
          "updated_at"=>$this->today
      ]);
    }
     public function checkVoteReqCaisse(mixed $input){
       return DB::select("select *from reqCaisse where uid=:uid and subscriber=:subscriber and approvalVote=(votingCount+:votingCount) limit 1",[
            "uid"=>$input["uid"],
            "votingCount"=>$input["votingCount"]??'0',
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
    public function checkReqCaisse(mixed $input){
       return DB::select("select *from reqCaisse where uid=:uid and subscriber=:subscriber limit 1",[
            "uid"=>$input["uid"],
            "subscriber"=>Auth::user()->subscriber
        ]);
    }

    public function reqCaisseHistory(mixed $input){

      return DB::table("reqCaisseHistory")
      ->insert([
          "uid"=>$input["uid"],
          "actionName"=>$input["actionName"],
            "status"=>env('STATUS_REQUEST'),
            "commentData"=>$input["commentData"]??'none',
            "subscriber"=>Auth::user()->subscriber,
            "uidReq"=>$input["uidReq"]??'none',
            "uidApprove"=>Auth::user()->uid,
            "approvalVote"=>$input["approvalVote"],
             "voting"=>$input["voting"],
            "amount"=>$input["amount"],
            "currency"=>$input["currency"],
            "cAmount"=>$input["cAmount"]??'0',
            "cCurrency"=>$input["currency"]??'none',
            "created_at"=>$this->today,
            ]);
    }

    public function checkReqCaisseHistoryApproval(mixed $input){
        try {
            $check = DB::select(
                "SELECT uid FROM reqCaisseHistory
                 WHERE uid = :uid
                 AND subscriber = :subscriber
                 AND uidApprove = :uidApprove

                 LIMIT 1",
                [
                    "uid" => $input["uid"],
                    "subscriber" => Auth::user()->subscriber,
                    "uidApprove" => Auth::user()->uid,

                ]
            );
           if (!empty($check)) {
                return 1;
            } else {
                return 0;
            }
        } catch  (\Illuminate\Database\QueryException $e) {
            // Handle the exception, log it, or return an error response
           \Log::error('checkNotify failed: ' . $e->getMessage());
            return -1;
        }
    }


    public function checkVotingCaisse(mixed $input){
        return DB::select("select *from reqCaisse where uid=:uid and uidApprove=:uidApprove and subscriber=:subscriber  limit 1",[
            "uid"=>$input["uid"],
            "uidApprove"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
}
