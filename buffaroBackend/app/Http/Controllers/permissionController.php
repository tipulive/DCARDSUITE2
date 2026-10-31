<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class permissionController extends Controller
{
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

    public function AdminPermission(mixed $input){//permission
    $permission=$input["permission"];
    $boolean=$input["boolean"];
           return DB::update("UPDATE admins
SET updated_at=:updated_at, permission = JSON_OBJECT(
    '$permission', $boolean

)
WHERE uid := uid and subscriber=:subscriber limit 1",[
            "uid"=>$input["uid"],
            "subscriber"=>Auth::user()->subscriber,
            "updated_at"=>$this->today
        ]);
    }



    public function Permission(mixed $input){

    }
    public function CreatePermision(mixed $input)
    {
        if($this->checkPermission($input))
        {
            if($this->insertPermission($input))
            {
                return response([
                    "status" => true,
                    "result" => "Success",

                ]);
            }else{
                return response([
                    "status" => false,
                    "result" => "Success",

                ]);
            }
        }else{
            return response([
                "status" => false,
                "result" => "Success",

            ]);

        }

    }

    public function checkPermission(mixed $input)
    {
        return DB::select("select name from permissions where name=:name and subscriber=:subscriber limit 1",[
            "name"=>$input["name"],
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
    public function insertPermission(mixed $input){//Create amazina yamapermission kugirango age agaragara,igihe tugiye guha umuntu permission
        return DB::table("permissions")
        ->insert([
            "uid"=>$input["uid"],
            "name"=>$input["name"],
            "status"=>env('STATUS_ACTIVE'),
            "description"=>$input["description"],//icyo permission izaba Ikora
            "subscriber"=>Auth::user()->subscriber,
            "uidCreator"=>Auth::user()->uid,
            "created_at"=>$this->today
        ]);
    }
    public function DeletePermission(mixed $input){
       return DB::delete("delete from permissions where subscriber=:subscriber and uid=:uid",[
        "uid"=>$input["uid"],
        "subscriber"=>Auth::user()->subscriber
        ]);
    }
    public function EditPermission(mixed $input){

       /* UPDATE questions
SET question = COALESCE(NULLIF('jeshi', ''), question),questionId="vest"
WHERE id = 1;*/
           return DB::update("update permissions set name=:name,description=COALESCE(NULLIF(:description,''),description),updated_at=:updated_at where uid=:uid and subscriber=:subscriber limit 1 ",[
               "uid"=>$input["uid"],
               "name"=>$input["name"],
               "description"=>$input["comentData"],
               "subscriber"=>$input["subscriber"],
               "updated_at"=>$this->today

           ]);
    }
    public function removePermission(mixed $input){//

        if($this->checkPermssionAdded($input))
        {
            //unable to delete permission
            return response([
                "status" => false,
                "result" => "unable to delete created",

            ]);
        }else{
            if($this->DeletePermission($input))
            {
                return response([
                    "status" => true,
                    "result" => "Success",

                ]);
            }else{
                return response([
                    "status" => false,
                    "result" => "Something wrong please contact system Admin",

                ]);
            }
        }
    }
    public function viewPermission(mixed $input){
      return DB::select("select *from permissions");
    }
    public function AssignPermission(mixed $input){

    }

    public function checkPermssionAdded(mixed $input){
       return  DB::select("select uid from permissionAdded where uid=:uid and subscriber=:subscriber limit 1",[
            "uid"=>$input["uid"],
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
    public function permissionAdded(mixed $input){
        return DB::table("permissionAdded")
        ->insert([
            "uid"=>$input["uid"],
            "uidUser"=>$input["uidUser"],
            "status"=>env('STATUS_ACTIVE'),

            "uidCreator"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber,
            "created_at"=>$this->today
        ]);
    }

    public function permissionAddedAction(mixed $input){//this is to setup action on notification by default
        return DB::table("permissionACtion")
        ->insert([

            "action"=>$input["action"],//notification  createCaisse
            "permission"=>$input["permission"],//this is permission Added,with approvalAction,it means it will look like this [{"permission":"createCaisse","approvalAction":"1"}]

            "status"=>env('STATUS_ACTIVE'),

            "uidCreator"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber,
            "created_at"=>$this->today
        ]);
    }

}
