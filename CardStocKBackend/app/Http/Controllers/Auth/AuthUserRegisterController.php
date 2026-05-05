<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;


class AuthUserRegisterController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';

    }
    //

    public function UserCreatedByCompany($input)
    {

        $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['name']);//generated on production
        //echo $this->today;
        $uid=$uid.""."_".date(time());
                $check=DB::table("users")
                ->insert([
                    'name'=>strtolower($input['name']),

                    //'fname'=>$input['fname'],
                    //'lname'=>$input['lname'],
                    'email'=>$input['email'],
                    'Ccode'=>$input['Ccode']??'none',//country code
                    'phone'=>$input['phone']??'none',
                    'country'=>$input['country'],
                    'uidCreator'=>Auth::user()->uid,

                    'subscriber'=>Auth::user()->subscriber,
                    'platform'=>env('PLATFORM4'),
                    'password'=>bcrypt($input['password']),
                    //'passdecode' =>$input['password'],

                    'uid'=>$uid,
                    'created_at'=>$this->today,

                ]);
                if($check)
                {

                 return response([
                     "status"=>true,
                     "result"=>$check,
                     "userid"=>$uid

                 ],200);
                }
                else{
                 return response([
                     "status"=>false,
                     "result"=>$check,

                 ],200);
                }
    }
    public function UserDefault($input){

       // return $this->changePermission($input);
       DB::beginTransaction();

       try {


       if($this->UserCreated()==1){

       if($this->changePermission($input))
       {
        DB::commit();
        return response([
            "status"=>true,
            "default"=>$input["permV"],
            "name"=>Auth::user()->name,
            "uid"=>Auth::user()->uid,
            "result"=>"user Default Set",
           // "Auth"=>Auth::user()


        ],200);

       }else{
        DB::rollBack();
        return response([
            "status"=>true,
            "name"=>Auth::user()->name,
            "uid"=>Auth::user()->uid,
            "default"=>$input["permV"],
            "result"=>"Status not edited"

        ],200);
       }


       }
       else{
        DB::rollBack();
        return response([
            "status"=>false,
            "default"=>false,
            "result"=>"user Not created"

        ],200);
       }

    }
       catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'error' => 'An error occurred',
            'errorPrint' => $e->getMessage(),
            'errorCode' => $e->getLine(),
        ], 500);
    }
    }

    public function UserCreated(){
        $checkUser=DB::select("select uid from users where uid=:uid and subscriber=:subscriber",[
            "uid"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber
        ]);
        if($checkUser){
            return 1;
        }
        else{

            $check=DB::table("users")
            ->insert([
                'name'=>Auth::user()->name,
                'email'=>Auth::user()->email.""."_".date(time()),
                'Ccode'=>Auth::user()->phone.""."_".date(time()),
                'phone'=>Auth::user()->phone.""."_".date(time()),
                'PhoneNumber'=>Auth::user()->phone.""."_".date(time()),
                'uidCreator'=>Auth::user()->uid,

                'subscriber'=>Auth::user()->subscriber,
                'platform'=>env('PLATFORM4'),
                'password' =>"none",
                //'passdecode' =>$input['password'],
                'initCountry'=>"none",
                'country'=>"none",
                "carduid"=>"none",
                'uid'=>Auth::user()->uid,
                'created_at'=>$this->today,

            ]);
            if($check){
                return 1;
            }
            else{
                return 0;
            }
        }

    }
    public function changePermission($input){
        $key = $input["permKey"];
        $value =$input["permV"];

        $check = DB::update("
            UPDATE admins
            SET permission = JSON_SET(
                IF(JSON_VALID(permission), permission, '{}'),
                ?, ?
            )
            WHERE uid = ?
        ", [
            '$.' . $key,
            json_encode($value), // important
            Auth::user()->uid
        ]);
if($check){
    return true;
}
else{
    return 0;
}
    }
    public function UserCreatedByCompanyAssign($input) //create User and Assigned With new Cards
    {

        $PhoneNumber=$input['Ccode']."".$input['phone'];
        $email=$input['email']."_".date(time());
        $check=DB::select("select PhoneNumber,email,carduid from users where subscriber=:subscriber and( PhoneNumber=:PhoneNumber or email=:email) limit 2",array(

        "subscriber"=>Auth::user()->subscriber,
        "PhoneNumber"=>$PhoneNumber,
         "email"=>$email,
        ));
        if($check)
        {
            $countCheck=count($check)==2?$check[1]->PhoneNumber==$PhoneNumber:"";
            $countCheckEmail=count($check)==2?$check[1]->email==$email:"";
            $CheckPhone=$check[0]->PhoneNumber==$PhoneNumber || $countCheck?'PhoneNumber already Exist':'Phone is not Exist';
            $CheckEmail=$check[0]->email==$email || $countCheckEmail?'Email already Exist':'Email is not Exist';
           // $CheckCard=$check[0]->email==$input['email'] || $countCheckEmail?'Email already Exist':'Email is not Exist';
         return response([
             "status"=>false,
             "Count"=>count($check),
             "phone"=>$CheckPhone,
             "Email"=>$CheckEmail
             //"cardUid"=>


         ],200);
        }
        else{
            if($input["actionStatus"]==="noCard")
            {
                $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['name']);//generated on production
                //echo $this->today;
                $uid=$uid.""."_".date(time());
                        $check=DB::table("users")
                        ->insert([
                            'name'=>strtolower($input['name']),

                            //'fname'=>$input['fname'],
                            //'lname'=>$input['lname'],
                            'email'=>$email??'none',
                            'Ccode'=>$input['Ccode']??'none',//country code
                            'phone'=>$input['phone']??'none',
                            'PhoneNumber'=>$PhoneNumber,
                            'uidCreator'=>Auth::user()->uid,

                            'subscriber'=>Auth::user()->subscriber,
                            'platform'=>env('PLATFORM4'),
                            'password' =>bcrypt($input['password']),
                            //'passdecode' =>$input['password'],
                            'initCountry'=>$input['initCountry'],
                            'country'=>$input['country'],
                            "carduid"=>$input["carduid"]??'none',
                            'uid'=>$uid,
                            'created_at'=>$this->today,

                        ]);
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
            else{

            $carduid=$input["carduid"];
            $checkCard=DB::update("update cards set status='Assigned',updated_at=:updated_at where uid=:uid and status='none' limit 1",array(
                "uid"=>$carduid,
                "updated_at"=>$this->today

            ));//this query will make us check if card existed and Assigned to user straight
            if($checkCard)
            {
                $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['name']);//generated on production
                //echo $this->today;
                $uid=$uid.""."_".date(time());
                        $check=DB::table("users")
                        ->insert([
                            'name'=>strtolower($input['name']),

                            //'fname'=>$input['fname'],
                            //'lname'=>$input['lname'],
                            'email'=>$email??'none',
                            'Ccode'=>$input['Ccode']??'none',//country code
                            'phone'=>$input['phone']??'none',
                            'PhoneNumber'=>$PhoneNumber,
                            'uidCreator'=>Auth::user()->uid,

                            'subscriber'=>Auth::user()->subscriber,
                            'platform'=>env('PLATFORM4'),
                            'password' =>bcrypt($input['password']),
                            //'passdecode' =>$input['password'],
                            'initCountry'=>$input['initCountry'],
                            'country'=>$input['country'],
                            "carduid"=>$input["carduid"],
                            'uid'=>$uid,
                            'created_at'=>$this->today,

                        ]);
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
            else{
                return response([
                    "status"=>false,
                    "result"=>"Card is Invalid or already Assigned",

                ],200);
            }

            }



        }

    }
    public function UserEditedByCompanyAssign($input) //Edit User Phone and
    {


        if(strtolower($input["status"])=='card')
        {
          if($this->EditCard($input))
          {

              return $this->UpdateUserQuery($input);
          }
          else{
            return response([
                "status"=>false,
                "result"=>"0",
                "message"=>"This Card is already Assigned please use another one"

            ],200);
          }
        }else{


         if($this->searchUserEdit($input))
          {
            return response([
                "status"=>false,
                "result"=>"0",
                "message"=>"phone Number is taken please add New Phone Number"

            ],200);
          }
          else{

            return $this->UpdateUserQuery($input);
          }
        }

       //DB::update("update users set PhoneNumber=$PhoneNumber, where PhoneNumber=");



    }
    public function UserDeleteByCompanyAssign($input) //Edit User Phone and
    {
        $check=DB::select("select userid from orderhistories where userid=:userid limit 1",array(
            "userid"=>$input["uid"]
        ));
        if($check){
            return response([
                "status"=>false,
                "result"=>"0",
                "message"=>"This User have orders history you can't delete it"

            ],200);
        }
        else{
            $checkDelete=DB::delete("delete from users where uid=:uid limit 1",array(
                "uid"=>$input["uid"]
            ));
            if($checkDelete)
            {
                return response([
                    "status"=>true,
                    "result"=>$checkDelete

                ],200);
            }
            else{
                return response([
                    "status"=>false,
                    "result"=>$checkDelete

                ],200);
            }

        }
    }
    public function EditCard($input)
    {
        $carduid=$input["carduid"];
            $checkCard=DB::update("update cards set status='Assigned' where uid=:uid and status='none' limit 1",array(
                "uid"=>$carduid
            ));
            return $checkCard;
    }
    public function searchUserEdit($input)
   {
    $PhoneNumber=$input['Ccode']."".$input['phone'];
    $email=$input['email'];
    $uid=$input['uid'];
   $check=DB::select("select PhoneNumber,uid from users where uid=:uid or PhoneNumber=:PhoneNumber and subscriber=:subscriber limit 2",array(
       "uid"=>$uid,
       "PhoneNumber"=>$PhoneNumber,
       "subscriber"=>Auth::user()->subscriber
    ));
    if($check)
    {
    if(count($check)>1)
    {

     return true;//phone number exist for another user
    }
    else{
     if($check[0]->PhoneNumber==$PhoneNumber && $check[0]->uid!=$uid)
     {
         return true;//phone number exist for another user
     }
     return false;//phone number not exist for another user
    }

    }else{
     return true;//phone number and uid not exist which is not possible because uid must exist but we will return true to stop update and make user add new phone number
    }

    }
    public function UpdateUserQuery($input)
    {
        $carduid=$input["carduid"];
        $queryCard=strtolower($input["status"])!='card'?"":",carduid='$carduid'";
        $PhoneNumber=$input['Ccode']."".$input['phone'];
        $email=$input['email']??$input['name'].""."@".date(time());;
        $check2=DB::update("update users set phone=:phone,PhoneNumber=:PhoneNumber,name=:name,email=:email,Ccode=:Ccode,password=:password,country=:country,initCountry=:initCountry,updated_at=:updated_at $queryCard where uid=:uid limit 1",array(
            "uid"=>$input["uid"],
            'name'=>strtolower($input['name']),
            'email'=>$email,
            'Ccode'=>$input['Ccode'],//country code
            'phone'=>$input['phone']??'none',
            'PhoneNumber'=>$PhoneNumber,
            'password'=>bcrypt($input['password']),
            //'passdecode' =>$input['password'],
            'initCountry'=>$input['initCountry'],
            'country'=>$input['country'],

            'updated_at'=>$this->today,

        ));
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
                "result"=>$check2

            ],200);
        }
    }

    public function TestUid(){

        return response([
            "status"=>false,
            "result"=>'result',
            "userid"=>4

        ],200);
    }
    public function UserRegisterEmail($input)
    {
        $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['name']);//generated on production
        //echo $this->today;
        $uid=$uid.""."_".date(time());
                $check=DB::table("users")
                ->insert([
                    'name'=>strtolower($input['name']),
                    //'fname'=>$input['fname'],
                    //'lname'=>$input['lname'],
                    'email'=>$input['email'],
                    'Ccode'=>$input['Ccode'],
                    'phone'=>$input['phone'],
                    'uidCreator'=>$input['uidCreator'],
                    'subscriber'=>$input['subscriber'],
                    'platform'=>'client',
                    'password' =>bcrypt($input['password']),
                    //'passdecode' =>$input['password'],
                    'country'=>'USA',
                    'uid'=>$uid,
                    'created_at'=>$this->today,

                ]);
                if($check)
                {

                 return response([
                     "status"=>true,
                     "result"=>$check,
                     "userid"=>$uid

                 ],200);
                }
                else{
                 return response([
                     "status"=>false,
                     "result"=>$check,

                 ],200);
                }
    }
    public function Register_with_phone($input)
    {

    }





}
