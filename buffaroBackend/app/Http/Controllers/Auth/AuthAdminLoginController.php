<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use DB;

class AuthAdminLoginController extends Controller
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

        //$this->adminStatus_record=["test_PointSales1","Salary_PointSales1","beg_PointSales1","Sifa_PointSales1"];//Status_SystemUd
      $this->adminStatus_record=["Sales_PointSales1","Salary_PointSales1","GeneralSpend_PointSales1","Funded_PointSales1","Sponsor_PointSales1","OrderCount_PointSales1"];//Status_SystemUd


    }
    //
    public function AdminLoginEmail($input){
        if(Auth::guard('Admin')->attempt([

			'email'=>$input['email'], //means if it check username table =to input name them add input name;
			'password'=>$input['password'],


		]))

		{
            $user=auth::guard('Admin')->user();
            $success['token']=$user->createToken('MyApp')->plainTextToken;
            $success['name']=$user->email;
            $this->createAdmin_record();
            return response([
                "status"=>true,
               // "result"=>Auth::guard('Admin')->user(),
                "token"=>$success['token'],
                "User"=>[
                    "uid"=>Auth::guard('Admin')->user()->uid,
                    "first_name"=>Auth::guard('Admin')->user()->fname,
                    "last_name"=>Auth::guard('Admin')->user()->name,
                    "name"=>Auth::guard('Admin')->user()->name,
                    "email"=>Auth::guard('Admin')->user()->email,
                    "tel"=>Auth::guard('Admin')->user()->phone,
                    "Ccode"=>Auth::guard('Admin')->user()->Ccode,
                    "status"=>Auth::guard('Admin')->user()->status,
                    "platform"=>Auth::guard('Admin')->user()->platform,
                    "CompanyName"=>Auth::guard('Admin')->user()->CompanyName,
                    "subscriber"=>Auth::guard('Admin')->user()->subscriber,
                ]

            ],200);

		}
        else  if(Auth::guard('Admin')->attempt([

			'PhoneNumber'=>$input['email'], //means if it check username table =to input name them add input name;
			'password'=>$input['password'],


		]))
        {

            $user=auth::guard('Admin')->user();
            $success['token']=$user->createToken('MyApp')->plainTextToken;
            $success['name']=$user->email;
//create admin_records
      $this->createAdmin_record();

        return response([
            "status"=>true,
           // "result"=>Auth::guard('Admin')->user(),
            "token"=>$success['token'],
            "User"=>[
                "uid"=>Auth::guard('Admin')->user()->uid,
                "first_name"=>Auth::guard('Admin')->user()->fname,
                "last_name"=>Auth::guard('Admin')->user()->name,
                "name"=>Auth::guard('Admin')->user()->name,
                "email"=>Auth::guard('Admin')->user()->email,
                "tel"=>Auth::guard('Admin')->user()->phone,
                "Ccode"=>Auth::guard('Admin')->user()->Ccode,
                "status"=>Auth::guard('Admin')->user()->status,
                "platform"=>Auth::guard('Admin')->user()->platform,
                "CompanyName"=>Auth::guard('Admin')->user()->CompanyName,
                "subscriber"=>Auth::guard('Admin')->user()->subscriber,
            ]

        ],200);



        }

	else{
        return response([
            "status"=>false,


        ],200);

    }
    }
    public function createAdmin_record(){

        try {
            //code...

            $check=DB::transaction(function ()  {//
                 $arraySize = count($this->adminStatus_record);

            if(count($this->adminStatus_record)==(Auth::guard('Admin')->user()->AdminRecord_Status))
            {
              return true;
            }
            else{

                 $remainingArray = array_slice($this->adminStatus_record,(Auth::guard('Admin')->user()->AdminRecord_Status));

                 $limitData=count($remainingArray);
            for($i=0;$i<$limitData;$i++)
              {
                $underscorePos = strpos($remainingArray[$i], "_");
                  DB::table("admnin_records")
                  ->insert([
                    "uid"=>Auth::guard('Admin')->user()->uid,
                    "subscriber"=>Auth::guard('Admin')->user()->subscriber,
                    "status"=>(substr($remainingArray[$i], 0, $underscorePos)),
                    "systemUid"=>(substr($remainingArray[$i],$underscorePos +1)),
                    "created_at"=>$this->today
                  ]);

              }

              DB::update("update admins set AdminRecord_Status=AdminRecord_Status+:AdminRecord_Status where uid=:uid limit 1",array(
                "AdminRecord_Status"=>$limitData,
                "uid"=>Auth::guard('Admin')->user()->uid
              ));
              return true;
            }

            });

        } catch (\Exception $e) {
            DB::rollback();
           // throw $e;
            return response()->json(['error' => 'An error occurred',
        'errorPrint'=>$e->getMessage(),"errorCode"=>$e->getLine()], 500); // Return an error JSON response
        }



    }
    public function switchAccount($input)
    {

      $user = Admin::where([
            'uid'=>$input["uid"],
            'password'=>$input["encryptData"]
        ])->first();

        if (!$user) {
            return response(["status" => false]);
        }

        return $this->loginReusable($input,$user);


    }
    public function AdminLoginPhone($input){

        if(Auth::guard('Admin')->attempt([

            'PhoneNumber'=>$input['PhoneNumber'], //means if it check username table =to input name them add input name;
            'password'=>$input['password'],


        ]))

        {
            $user=auth::guard('Admin')->user();

            return $this->loginReusable($input,$user);


        }

    else{
        return response([
            "status"=>false,


        ],200);

    }



    }
    public function loginReusable($input,$user)
    {
        $success['token']=$user->createToken('MyApp')->plainTextToken;
        $success['name']=$user->email;
        $this->createAdmin_record();
        return response([
            "status"=>true,
           // "result"=>Auth::guard('Admin')->user(),
            "token"=>$success['token'],
            "User"=>[
                "uid"=>$user->uid,
                /*"first_name"=>$user->fname,
                "last_name"=>$user->name,*/
                "name"=>$user->name,
                "email"=>$user->email,
                "tel"=>$user->phone,
                "PhoneNumber"=>$user->PhoneNumber,
                "password"=>$user->password,
                "status"=>$user->status,
                "Ccode"=>$user->Ccode,
                "platform"=>$user->platform,
                "CompanyName"=>$user->CompanyName,
                "subscriber"=>$user->subscriber,
            ]

        ],200);
    }
    public function Reset_with_email($input){

    }
    public function Reset_with_phone($input){

    }

}
