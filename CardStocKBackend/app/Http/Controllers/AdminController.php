<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use App\Http\Controllers\Auth\AuthAdminRegisterController;
use App\Http\Controllers\Auth\AuthAdminLoginController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\account\User_ACC_Controller;
use App\Http\Controllers\declarationController;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        //date_default_timezone_set(env('Africa/Johannesburg'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';
        $this->Admin_Auth_error="You Are not authenticate please Request Permission to Admin";
        $this->Admin_Auth_result_error="0";//Admin auth result zero
        $this->platform1=env('PLATFORM1');
    }

    public function addExistUserMini($input)
    {

        $input["addedStatus"]="1";//added as new one;
        if($this->checkUidExist($input))
        {
            throw new \Exception("Account already exist");
        }
        else{
            if($this->addMiniAccount($input))
            {
                $input["status"]="active2";
                $input["CompanyName"]=$input["minicompanyName"];

                $input["email"]="test@"."_".date(time());;
                $input["password"]="1";
                $input["uid"]=$input["ownerSub"];
                (new AuthAdminRegisterController)->AdminCreateCompany($input);
            }else{
                throw new \Exception("Soething Wrong unable to create Account");
            }
        }
    }
    public function AddnewUserMini($input)//add new User
    {
        try {
            //code...
            $check=DB::transaction(function () use ($input) {

                //$this->mainDeleteApp($input);
                $this->processNewMiniAccount($input);
            });

            return response([
                "status" => true,
                "result" => "Success",
                "message"=> $check
            ]);


       } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }

    }
    public function processNewMiniAccount($input){
        $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['name']);###this is  a name of existing user
        $input['UidAdminCreated']="Mn_".$uid.""."_".date(time());
        $input["subscriber"]=$input["miniOwnerSubscriber"];
        if($this->checkSubscriberExist($input))
        {
            throw new \Exception("Account already exist");
        }
        else{
            if($this->addMiniAccount($input))
            {
                $input["status"]="active2";
                $input["CompanyName"]=$input["minicompanyName"];

                $input["email"]="test@"."_".date(time());;
                $input["password"]="1";
                $input["uid"]=$input["uidOwner"];
                (new AuthAdminRegisterController)->AdminCreateCompany($input);
            }else{
                throw new \Exception("Soething Wrong unable to create Account");
            }
        }

    }
    public function checkUidExist($input)
{
    return DB::select(
        "SELECT uidOwner, miniOwner
         FROM mini_accounts
         WHERE uidOwner = :uidOwner
         AND miniOwner = :miniOwner
         LIMIT 1",
        [
            "miniOwner" => $input['UidAdminCreated'],
            "uidOwner" => $input["uidOwner"]
        ]
    );
}
    public function checkSubscriberExist($input)
    {
        return DB::select(
            "SELECT uidOwner, miniOwnerSubscriber
             FROM mini_accounts
             WHERE uidOwner = :uidOwner
             AND miniOwnerSubscriber = :miniOwnerSubscriber
             LIMIT 1",
            [
                "miniOwnerSubscriber"=>$input["subscriber"],
                "uidOwner" => $input["uidOwner"]
            ]
        );
    }
    public function addMiniAccount($input)
    {
        return DB::table("mini_accounts")
               ->insert([
                   "uidOwner"=>$input["uidOwner"],
                   "ownerSubscriber"=>$input["ownerSub"],
                   "miniOwner"=>$input['UidAdminCreated'],
                   "miniOwnerSubscriber"=>$input["subscriber"],
                   "uidCreator"=>Auth::user()->uid,
                   "addedStatus"=>$input["addedStatus"]??'0',
                   "created_at"=>$this->today

               ]);
    }


    public function MiniAccount($input){

 if($input["optionCase"]='view')
 {

     return response([
        "status" => true,
        "result" =>$this->viewMinAcc($input)
    ]);

 }
 else if($input["optionCase"]='search'){

     return response([
        "status" => true,
        "result" =>searchByUidowner($input)
    ]);
 }
    }
    public function viewMinAcc($input)
    {
        return DB::select("
    SELECT
        u.uid,
        u.PhoneNumber,
        u.password,
        u.subscriber,
        u.name,
        u.companyName,
        m.addedStatus,
        m.uidOwner
    FROM mini_accounts m
    INNER JOIN admins u
        ON m.miniOwner = u.uid
    WHERE m.uidOwner = :uidOwner
", [
    "uidOwner"=>$input["uidOwner"]
]);
    }
    public function searchByUidowner($input)
    {
        $item = strtolower($input["name"]);
        $itemSearch='%'.$item.'%';
        return DB::select("
        SELECT
            u.uid,
            u.password,
            u.PhoneNumber,
            u.subscriber,
            u.name,
            u.companyName,
            m.addedStatus,
            m.uidOwner
        FROM mini_accounts m
        INNER JOIN admins u
            ON m.miniOwner = u.uid
        WHERE m.uidOwner = :uidOwner and u.name Like :Name
    ", [
        "uidOwner"=>$input["uidOwner"],
        "Name"=>$itemSearch
    ]);
    }
    public function SwitchAccount(Request $request)
    {

    }

    public function AdminCreateCompany(Request $request){

        $input=$request->all();
        return (new AuthAdminRegisterController)->AdminCreateCompany($input);





        }



public function ExportCsv(Request $request){

    $input=$request->all();
    $exchange=$input['exchangerate'];
    $uid=$input['uid'];
    $uidLink=$input['uidLink'];
    $TokenLink=$input['TokenLink'];
    $uidOwner=$TokenLink.""."_".$uidLink;

$check=DB::select("select uid from logs where uid=:uid limit 1",array(
    "uid"=>$uidOwner
));

if($check)
{
    //
    $url =$uidLink;
    /*return response([
        "status"=>$input,
    ],200);*/
    $uidfile=preg_replace('/[^A-Za-z0-9-]/','',$input['plaque']);//generated on production
    //echo $this->today;
    $fileData=$uidfile.""."_".date(time());

    $plaque=$input['plaque'];

    $users=DB::select("
    SELECT name,qty,round(((total/qty)*$exchange),0) as PriceUnitFrw,(round(((total/qty)*$exchange),0)*qty) as totalPriceFrw
    FROM items WHERE uid='$uid';");




    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$url.'');
    header("Pragma: no-cache");
    header("Expires: 0");

    ob_clean();
    $output = fopen('php://output', 'w');
    $plaque=$input['plaque'];
    fputcsv($output, array($plaque, '','',''));
    fputcsv($output, array("\n"));
    fputcsv($output, array('Name', 'Qty','PriceUnitFrw','TotalPriceFrw'));
    fputcsv($output, array("\n"));

    /*return response([
        "status"=>true,
        "result"=>$users,

    ],200);*/
    $totalAllPriceFrw=0;
    if (count($users) > 0) {
        foreach ($users as $res) {
            fputcsv($output, [$res->name,$res->qty,$res->PriceUnitFrw,$res->totalPriceFrw]);
              //print_r($res["name"]);
              $totalAllPriceFrw+=$res->totalPriceFrw;

        }

        fputcsv($output, array("\n"));
        fputcsv($output, array('Total','','',$totalAllPriceFrw));

    }
    $check=DB::delete("delete from logs where uid=:uid limit 1",array(
        "uid"=>$uidOwner
    ));
    //
}
else{
    return response([
        "status"=>false,

        "result"=>$this->Admin_Auth_result_error,
        "error"=>$this->Admin_Auth_error,

    ],200);
}
//


            //Session::forget('session1');//delete session1




}
    public function ResultExcel(Request $request){


//

//




        if(auth::check())
        {
            $input=$request->all();

            $exchange=$input['exchangerate'];
            $uid=$input['uid'];

            $platform1=env('PLATFORM1');//superAdmin
            $platform3=env('PLATFORM3');//UserRegister
            if(Auth::user()->platform==$platform1||Auth::user()->platform==$platform3)
            {






                    //create session
            $uidfile=preg_replace('/[^A-Za-z0-9-]/','',$input['plaque']);//generated on production

            $url=$uidfile.""."_".date(time()).".csv";
            $uidOwner=Auth::user()->userid.""."_".$url;
            $check=DB::table("logs")
            ->insert([
"uid"=>$uidOwner
            ]);
            if($check)
            {
                return response([
                    "status"=>true,
                    "uidLink"=>$url,
                    "TokenLink"=>Auth::user()->userid
                ],200);
            }













            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,

                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

              //End code here




              //End code here




    }
    //from
    public function AdminProductComeFrom(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');//superAdmin
            $platform3=env('PLATFORM3');//UserRegister
            if(Auth::user()->platform==$platform1||Auth::user()->platform==$platform3)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new productController)->ProductComeFrom($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    //from
    //Declaration
    public function CheckDeclaration(Request $request)//Loading open Declaration
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->CheckDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminDeclarationCreate(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->create($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminEditDeclaration(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->EditDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    public function AdminDeleteDeclaration(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->DeleteDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminDeclarationLoad(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->DeclarationLoad($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    public function AdminItemDeclarationLoad(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->ItemDeclarationLoad($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }


    public function AdminDeclarationAddItem(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->AddItem($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    public function AdminDeclarationEditItem(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->EditItemDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminDeleteItemDeclaration(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->DeleteItemDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    public function AdminSearchDeclarationItem(Request $request)//Autocomplete
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->SearchDeclarationItem($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }

    public function AdminDeclarationCalculate(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->Calculate($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminCloseDeclaration(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new declarationController)->CloseDeclaration($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    //Declaration
    public function AdminAllOpenReport(Request $request)
    {

        if(auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new SaleController)->AllOpenReport($input);
            }
            else{
                return response([
                    "status"=>false,
                    "platform"=>Auth::user()->platform,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "platform"=>Auth::user()->platform,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }

    }
    public function AdminClosedSales(Request $request)
    {

        if(Auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                $input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new SaleController)->CloseSales($input);
            }
            else{
                return response([
                    "status"=>false,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }


    }
    public function AdminViewUsers(Request $request)
    {

        if(Auth::check())
        {




            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {
                //$input=$request->all();
                /*return response([
                    "status"=>$input,
                ],200);*/
                //return (new User_ACC_Controller)->ViewUsers($input);

                $check=DB::select("select name,created_at,uid,status,CompanyName,subscriber from admins");
                if($check)
             {
              return response([
                "myuid"=>Auth::user()->uid,
                  "myStatus"=>Auth::user()->status,
                  "status"=>true,
                  "result"=>$check,

              ],200);
             }
             else{
              return response([
                  "status"=>false,
                  "result"=>$check,

              ],201);
             }


            }
            else if(Auth::user()->platform==(env('PLATFORM3'))){

                $check=DB::select("select name,created_at,uid,status,CompanyName,subscriber from admins where subscriber=:subscriber limit 10",array(
                    "subscriber"=>Auth::user()->subscriber
                ));
                if($check)
             {
              return response([
                "myuid"=>Auth::user()->uid,
                "myStatus"=>Auth::user()->status,
                  "status"=>true,
                  "result"=>$check,

              ],200);
             }
             else{
              return response([
                  "status"=>false,
                  "result"=>$check,

              ],201);
             }

                return response([
                    "status"=>false,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }


    }
    public function AdminChangePlatform(Request $request)
    {

        if(Auth::check())
        {



            $input=$request->all();
            $platform1=env('PLATFORM1');
            if(Auth::user()->platform==$platform1)
            {

                /*return response([
                    "status"=>$input,
                ],200);*/
                return (new User_ACC_Controller)->ChangePlatform($input);
            }
            else if(Auth::user()->platform==(env('PLATFORM3')))
            {
                if(Auth::user()->subscriber==$input["subscriber"])
                {
                    return (new User_ACC_Controller)->ChangePlatform($input);
                }
                else{
                    return response([
                        "status"=>false,
                        "result"=>$this->Admin_Auth_result_error,
                        "error"=>$this->Admin_Auth_error,

                    ],200);
                }

            }
            else{

                return response([
                    "status"=>false,
                    "result"=>$this->Admin_Auth_result_error,
                    "error"=>$this->Admin_Auth_error,

                ],200);
            }
        }
        else{
            return response([
                "status"=>false,
                "result"=>$this->Admin_Auth_result_error,
                "error"=>$this->Admin_Auth_error,

            ],200);
        }


    }
    public function AdminRegisterEmail(Request $request){
        $input=$request->all();

        return (new AuthAdminRegisterController)->AdminRegisterEmail($input);

    }

    public function AdminLoginEmail(Request $request){
        $input=$request->all();

        return (new AuthAdminLoginController)->AdminLoginEmail($input);

    }
    public function AdminLoginPhone(Request $request){
        $input=$request->all();

        return (new AuthAdminLoginController)->AdminLoginPhone($input);

    }





}
