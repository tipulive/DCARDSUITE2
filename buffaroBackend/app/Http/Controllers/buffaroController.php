<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\spendingController;
use App\Http\Controllers\caisseController;
use App\Http\Controllers\votingController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\notifyController as ControllersNotifyController;

class buffaroController extends Controller
{
    //
         public string $today;
public string $curdate;
    protected mixed $permissions;
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
        $this->permissions = config('permissions');
    }


public function reqCaisse(mixed $input){
     try {


            $check=DB::transaction(function () use ($input) {



                $this->AddCaisseProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Success",

            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                'errorCode' => $e->getLine()
            ], 500);
        }

}
public function AddCaisseProcessing(mixed $input){//done

//
$input["action"] = $this->permissions["notification"]["addCaisse"]->uid;


$result = (new NotifyController)->checkPermNotify($input);

if ($result['error']) {

    // Database error
     throw new \Exception("Error unable to notify Admin Database Error", 1);

} elseif (!$result['status']) {

    // Permission not found
   // return false;
      $input["permission"] = [
    [
        "permission" =>$this->permissions["notification"]["addCaisse"]->uid,
        "approvalAction" => $this->permissions["notification"]["addCaisse"]->approvalAction
    ]

   ];
  return $this->reqCaisseMethod($input);

} else {

    // Success


      $input["permission"] = $result['data'];
  return $this->reqCaisseMethod($input);

    // Continue your operation
}
//



}

public function reqCaisseMethod(mixed $input){
      $reqCaisse=(new caisseController)->reqCaisse($input);
   if($reqCaisse["status"]){


   $input["uid"]=$reqCaisse["uid"];
    if((new NotifyController)->notifyAdmin($input))
    {
        return true;
    }else{
        throw new \Exception("Error unable to notify Admin", 1);
   }
   }else{
        throw new \Exception("Error unable to add Caisse", 1);
   }
}

public function updateVoteCaisseStatus(mixed $input){

 try {


            $check=DB::transaction(function () use ($input) {



                $this->updateCaisseVoteStatusProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Success",

            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "file" => $e->getFile(),
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }

}

public function updateCaisseVoteStatusProcessing(mixed $input){

    if((new caisseController)->checkVoteReqCaisse($input))
    {
         $input["status"]=env('STATUS_APPROVED');
         if((new caisseController)->UpdateCaisseStatus($input))
         {

            //here status must be approve,and update Caisse and update Admin as well

            if((new caisseController)->reqCaisseHistory($input))//update reqCaisseHistory
            {
                //remove all notify
                if((new NotifyController)->updateNotify($input)){
                    return true;
                }else{
                     throw new \Exception("Error Updating Notify", 1);
                }
            }
            else{
                  throw new \Exception("Error Updating Caisse Status", 1);
            }
                //update User and give them notification
         }else{
             throw new \Exception("Error Updating Caisse Status", 1);

         }

    }else{
        $input["status"]=env('STATUS_VOTED');

  if((new caisseController)->UpdateCaisseStatus($input))
         {
            //update User and give them notification ,the


            if((new caisseController)->reqCaisseHistory($input))//update reqCaisseHistory
            {
                 return true;
            }else{
              throw new \Exception("Error unable to update Caisse Status", 1);
            }
         }else{
             throw new \Exception("Error unable to update Caisse Status", 1);

         }
    }

}

public function reqSpending(mixed $input){
     try {


            $check=DB::transaction(function () use ($input) {



                $this->AddSpendingProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Success",

            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "file" => $e->getFile(),
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }

}
public function AddSpendingProcessing(mixed $input){//done

//
$input["action"] = $this->permissions["notification"]["addSpending"]->uid;


$result = (new NotifyController)->checkPermNotify($input);

if ($result['error']) {

    // Database error
     throw new \Exception("Error unable to notify Admin Database Error", 1);

} elseif (!$result['status']) {

    // Permission not found
   // return false;
      $input["permission"] = [
    [
        "permission" =>$this->permissions["notification"]["addSpending"]->uid,
        "approvalAction" => $this->permissions["notification"]["addSpending"]->approvalAction
    ]

   ];
  return $this->reqSpendingMethod($input);

} else {

    // Success


      $input["permission"] = $result['data'];
  return $this->reqSpendingMethod($input);

    // Continue your operation
}
//



}

public function reqSpendingMethod(mixed $input){
      $reqSpending=(new SpendingController)->reqSpending($input);
   if($reqSpending["status"]){


   $input["uid"]=$reqSpending["uid"];
    if((new NotifyController)->notifyAdmin($input))
    {
        return true;
    }else{
        throw new \Exception("Error unable to notify Admin", 1);
   }
   }else{
        throw new \Exception("Error unable to add Spending", 1);
   }
}

public function updateVoteSpendingStatus(mixed $input){

 try {


            $check=DB::transaction(function () use ($input) {



                $this->updateSpendingVoteStatusProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Success",

            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "file" => $e->getFile(),
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }

}

public function updateSpendingVoteStatusProcessing(mixed $input){

    if((new SpendingController)->checkVoteReqSpending($input))
    {
         $input["status"]=env('STATUS_APPROVED');
         if((new SpendingController)->UpdateSpendingStatus($input))
         {

            //here status must be approve,and update Spending and update Admin as well

            if((new SpendingController)->reqSpendingHistory($input))//update reqSpendingHistory
            {
                //remove all notify
                if((new NotifyController)->updateNotify($input)){
                    return true;
                }else{
                     throw new \Exception("Error Updating Notify", 1);
                }
            }
            else{
                  throw new \Exception("Error Updating Spending Status", 1);
            }
                //update User and give them notification
         }else{
             throw new \Exception("Error Updating Spending Status", 1);

         }

    }else{
        $input["status"]=env('STATUS_VOTED');

  if((new SpendingController)->UpdateSpendingStatus($input))
         {
            //update User and give them notification ,the


            if((new SpendingController)->reqSpendingHistory($input))//update reqSpendingHistory
            {
                 return true;
            }else{
              throw new \Exception("Error unable to update Spending Status", 1);
            }
         }else{
             throw new \Exception("Error unable to update Spending Status", 1);

         }
    }

}
}

