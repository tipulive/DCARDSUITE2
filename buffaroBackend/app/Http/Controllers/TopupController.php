<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MyHistoryController;
use Auth;
use DB;
use Validator;

class TopupController extends Controller
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
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';
        $this->Admin_Auth_error="You Are not authenticate please Request Permission to Admin";
        $this->Admin_Auth_result_error="0";//Admin auth result zero

    }

    public function TopupUser($input)//add balance
    {
        $validateAmount = Validator::make($input, [
            // "price" => "numeric|min:0|max:100000000",
             "balance" => "numeric|min:0|max:100000000",

          ]);

          if($validateAmount->fails()){
              return response([
                  "status"=>false,
                  //"result"=>$validatePrice->errors(),
                  "result"=> $validateAmount->errors()->getMessages()['balance'][0],

              ],200);
          }
          else{
           $balance=$input["balance"];
            $check=DB::update("update topups set uidCreator=:uidCreator,subscriber=:subscriber,updated_at=:updated_at,description=:description,balance=balance+$balance where uid=:uid limit 1",array(
                "uid"=>$input["uidUser"],//uid of user
                "uidCreator"=>Auth::user()->uid,
                "subscriber"=>Auth::user()->subscriber,
                "description"=>$input["description"]??'none',
                "updated_at"=>$this->today

            ));
            if($check)
            {
                $action="AddNew";
                $moreQuery="";
               return (new MyHistoryController)->AddBalance($input,$action,$moreQuery);
            }
            else{
                $check=DB::table("topups")
                ->insert([
                    "uid"=>$input["uidUser"],//uid of user
                    "uidCreator"=>Auth::user()->uid,
                    "subscriber"=>Auth::user()->subscriber,
                    "balance"=>$input["balance"],
                    "CBalance"=>$input["CBalance"]??'US',
                    "description"=>$input["description"]??'none',
                    "created_at"=>$this->today,
                ]);

                if($check)
                {

                    $action="FirstTimeAddNew";
                    $moreQuery="";
                   return (new MyHistoryController)->AddBalance($input,$action,$moreQuery);


                }
                else{

                        return response([
                            "status"=>false,
                            "result"=>$check,
                            "message"=>"Topup failed to insert new Topup"

                        ],200);


                }
            }
            //

          }




    }
    public function EditBalance($input)
    {
        $validateAmount = Validator::make($input, [
            // "price" => "numeric|min:0|max:100000000",
             "balance" => "numeric|min:-100000000|max:100000000",

          ]);

          if($validateAmount->fails()){
              return response([
                  "status"=>false,
                  //"result"=>$validatePrice->errors(),
                  "result"=> $validateAmount->errors()->getMessages()['balance'][0],

              ],200);
          }
          else{
            $balance=$input["balance"];
            $check=DB::update("update topups set uidCreator=:uidCreator,subscriber=:subscriber,updated_at=:updated_at,description=:description,balance=balance+$balance where uid=:uid limit 1",array(
                "uid"=>$input["uidUser"],//uid of user
                "uidCreator"=>Auth::user()->uid,
                "subscriber"=>Auth::user()->subscriber,
               // "currency"=>$input["amount"],
                "description"=>$input["description"]??'none',
                "updated_at"=>$this->today
            ));
            if($check)
            {
                $action="EditedBalance";
                $moreQuery="";
               return (new MyHistoryController)->AddBalance($input,$action,$moreQuery);
            }
          }

    }
    public function AddBonus($input,$bonus,$action,$moreQuery)
    {
        $uid=$input["uidUser"];

       $uidCreator=Auth::user()->uid;
        $subscriber=Auth::user()->subscriber;
        //$bonus=$input["gaine"];
       // $CBonus=$input["CBonus"]??'US';
        //$desc=$input["desc"]??'none';
        $today=$this->today;

        $check=DB::insert("INSERT INTO topups(uid,uidcreator,subscriber,bonus,created_at,updated_at) VALUES
        ('$uid','$uidCreator','$subscriber','$bonus','$today','$today')
             ON DUPLICATE KEY UPDATE bonus=bonus+$bonus,updated_at='$today'");

if($check)
{


   return (new MyHistoryController)->AddBonus($input,$bonus,$action,$moreQuery);


}
else{

        return response([
            "status"=>false,
            "result"=>$check,
            "message"=>"Topup failed to insert new Topup"

        ],200);


}
    }

    public function GetBalanceUser($input)
    {

        $check=DB::select("select balance,bonus from topups where uid=:uid  limit 1",array(
            "uid"=>$input["uid"]
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
    public function RedeemBalance($input){

        $validateAmount = Validator::make($input, [
            // "price" => "numeric|min:0|max:100000000",
             "amount" => "numeric|min:1|max:1000000000",

          ]);

          if($validateAmount->fails()){
              return response([
                  "status"=>false,
                  //"result"=>$validatePrice->errors(),
                  "result"=> $validateAmount->errors()->getMessages()['amount'][0],

              ],200);
          }else{

            $amount=$input["amount"];
            $CheckAmount=DB::update("update topups set balance=balance-$amount where uid=:uid and balance>=$amount limit 1",array(
                "uid"=>$input["uid"])
            );
            if($CheckAmount)
            {
                $check=DB::table("redeemeds")
                ->insert([
                    "uid"=>$input["uid"],//uid of user
                    "uidCreator"=>Auth::user()->uid,
                   "subscriber"=>Auth::user()->subscriber,
                    "balance"=>$amount,
                    "CBalance"=>$input["CBalance"]??'US',
                    "description"=>$input["description"]??'none',
                    "created_at"=>$this->today,
                ]);
                if($check)
                {
                    $uidCreator=Auth::user()->uid; //is the one who will pay money to client when he will withdraw
                    $subscriber=Auth::user()->subscriber; //company id
                    $check2=DB::insert("
                    INSERT INTO admnin_records(uid,balance,updated_at,currentAction,subscriber)
VALUES ('$uidCreator','$amount','$this->today','WithdrawBalance','$subscriber')
ON DUPLICATE KEY UPDATE
balance=balance+VALUES(balance),
updated_at=VALUES(updated_at),
currentAction=VALUES(currentAction)

                    ");//it means this query is very fast because VALUES to use Amount

                    if($check2)
                    {
                        return response([
                            "status"=>true,
                            "result"=>$check2


                        ],200);
                    }
                    else{
                        return response([
                            "status"=>false,
                            "message"=>"admin records table have some problem",
                            "result"=>$check2,

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
            else{
                //sorry you can not withdraw greater amount than what you have
                return response([
                    "status"=>false,
                    "result"=>"0",
                    "message"=>"You Have Insufficient Bonus !"

                ],200);
            }
          }

    }

    public function RedeemBonus($input){
        $validateAmount = Validator::make($input, [
            // "price" => "numeric|min:0|max:100000000",
             "amount" => "numeric|min:1|max:1000000000",

          ]);

          if($validateAmount->fails()){
              return response([
                  "status"=>false,
                  //"result"=>$validatePrice->errors(),
                  "result"=> $validateAmount->errors()->getMessages()['amount'][0],

              ],200);
          }else{
        $amount=$input["amount"];
        $CheckAmount=DB::update("update topups set bonus=bonus-$amount where uid=:uid and bonus>=$amount limit 1",array(
            "uid"=>$input["uid"])
        );
        if($CheckAmount)
        {
            $check=DB::table("redeemeds")
            ->insert([
                "uid"=>$input["uid"],//uid of user
                "uidCreator"=>Auth::user()->uid,
               "subscriber"=>Auth::user()->subscriber,
                "bonus"=>$amount,
                "CBonus"=>$input["CBonus"]??'US',
                "description"=>$input["description"]??'none',
                "created_at"=>$this->today,
            ]);
            if($check)
            {
                $uidCreator=Auth::user()->uid; //is the one who will pay money to client when he will withdraw
                $subscriber=Auth::user()->subscriber; //company id
                $check2=DB::insert("
                INSERT INTO admnin_records(uid,bonus,updated_at,currentAction,subscriber)
VALUES ('$uidCreator','$amount','$this->today','WithdrawBonus','$subscriber')
ON DUPLICATE KEY UPDATE
bonus=bonus+VALUES(bonus),
updated_at=VALUES(updated_at),
currentAction=VALUES(currentAction)

                ");//it means this query is very fast because VALUES to use Amount

                if($check2)
                {
                    return response([
                        "status"=>true,
                        "result"=>$check2


                    ],200);
                }
                else{
                    return response([
                        "status"=>false,
                        "message"=>"admin records table have some problem",
                        "result"=>$check2,

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
        else{
            //sorry you can not withdraw greater amount than what you have
            return response([
                "status"=>false,
                "result"=>"0",
                "message"=>"You Have Insufficient Bonus !"

            ],200);
        }
    }
    }

    public function GetCompanyRecord($input){
        $check=DB::select("select *from admnin_records where uid=:uid limit 1",array(
            "uid"=>Auth::user()->uid
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



}
