<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use App\Http\Controllers\Auth\AuthUserRegisterController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ParticipateController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\SafariController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\MyHistoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\utilityController;


class CompanyController extends Controller
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
    /*Utility Code */
    public function utilityViewSales(Request $request) {
        if(Auth::check())
        {
        if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new utilityController)->utilityViewSales($input);
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
    public function utilitySubmitOrder(Request $request) {
        if(Auth::check())
        {
        if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new utilityController)->utilitySubmitOrder($input);
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
    /*Utility Code */
    /*Safari Stock New Code */
    public function searchSpendPurpose(Request $request){
        $input=$request->all();
        $item = strtolower($input["purpose"]);
        $itemSearch='%'.$item.'%';

        $check=DB::select("select purpose,amount from depenses where purpose LIKE :itemName limit 20",[
            "itemName"=>$itemSearch
        ]);
        if($check)
        {
            return response([
                "status"=>true,
                "result"=>$check,

            ],200);
        }
        else{
            return response([
                "status"=>false,
                "result"=>$check,

            ],200);
        }
    }
    public function AdminProductComeFrom()
    {
 $check=DB::select("select *from come_froms");

 if($check)
        {
         return response([
             "status"=>true,
             "result"=>$check,

         ],200);
        }
        else{
         return response([
             "status"=>false,
             "result"=>$check,

         ],200);
        }
}

    public function GetSafaris(Request $request) {
        if(Auth::check())
        {
        if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)-> GetSafaris($input);
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
    public function CreateSafari(Request $request) {
        if(Auth::check())
        {

       if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->Create($input);
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
    public function EditSafari(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->EditSafari($input);
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
    public function DeleteSafariStock(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->DeleteSafariStock($input);
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
    public function PrintQrProduct(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->PrintQrProduct($input);
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
    public function createQrProduct(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->createQrProduct($input);
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
    public function SearchUser(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->SearchUser($input);
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
    public function Products(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->Products($input);
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
    public function IsProductExist(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->IsProductExist($input);
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

    public function CreateStockProduct(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->AddItem($input);
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

    public function updateProducts(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->updateProducts($input);
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
    public function EditProducts(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->EditProducts($input);
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
    public function EditStockQty(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->EditStockQty($input);
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
    public function deleteStockQty(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->deleteStockQty($input);
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
    public function EditStockFactPrice(Request $request) {
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->EditStockFactPrice($input);
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
    public function updateDataOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->updateDataOrder($input);
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
    public function UseDefault(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new AuthUserRegisterController)->UserDefault($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }
    }
    public function placeOrder(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->productPlaceOrder($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }
    }

    public function EditTOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->productEditOrder($input);
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
    public function EditOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                //return (new StockController)->EditOrder($input);
                $jsonFalse = array(
                "editOrderAction" =>false
            );
               $jsonData=(Auth::user()->permission==='none')?$jsonFalse:json_decode(Auth::user()->permission,true);

            if($jsonData["editOrderAction"])
            {
                return (new StockController)->EditOrder($input);
            }
            else{
                return response([
                    "status"=>false,



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
    public function deleteTSingleOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->deleteTSingleOrder($input);
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
    public function deleteTOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->deleteTOrder($input);
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
    public function ViewTempOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->ViewTempOrder($input);
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
    public function ViewUserTempOrder(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->ViewUserTempOrder($input);
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
    public function displayCalculate(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->displayCalculate($input);
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
    public function calculateAll(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->calculateAll($input);
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

    public function GetDispTempCalculator(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->GetDispTempCalculator($input);
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
    public function ResetTempCalculator(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->ResetTempCalculator($input);
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
    public function SaveCalculateTemp(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->SaveCalculateTemp($input);
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
    public function UpdatecalculateTemp(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->UpdatecalculateTemp($input);
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
    public function DeleteCalculateTemp(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->DeleteCalculateTemp($input);
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
    public function GetAllcalculateTemp(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->GetAllcalculateTemp($input);
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

    public function UseThisCalculateTemp(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->UseThisCalculateTemp($input);
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

    public function checkDette(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->checkDette($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }
    }

    public function SubmitOrder(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->SubmitOrder($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }
    }
    public function viewAnySales(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->viewAnySales($input);
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
    public function viewSales(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->viewSales($input);
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
    public function viewSalesByUid(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)-> viewSalesByUid($input);
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


    public function GetDebt(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->GetDebt($input);
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
    public function PaidDept(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->PaidDept($input);
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
    public function EditPaidDept(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->EditPaidDept($input);
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
    public function viewDept(Request $request){

//
if(env('APP_VERS')===$request->input('app_vers'))
{
if(Auth::check())
{

if(Auth::user()->platform==$this->platform1)
    {
        $input=$request->all();

        return (new StockController)->viewDept($input);
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
    "result"=>1,
    "downNew"=>env('APP_DOWN'),
    "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

],200);
}
//


    }
    public function viewDeptDetails(Request $request){

        //
        if(env('APP_VERS')===$request->input('app_vers'))
        {
        if(Auth::check())
        {

        if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->viewDeptDetails($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
        }
        //


            }
    public function viewPaidDept(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->viewPaidDept($input);
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


public function viewSafeBalance(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->viewSafeBalance($input);
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
public function viewBorrowBalance(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->viewBorrowBalance($input);
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
public function viewSafeBorrow(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->viewSafeBorrow($input);
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
public function repaidBack(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->repaidBack($input);
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

public function confirmRepaidBack(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->confirmRepaidBack($input);
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
public function viewRepay(Request $request){
    if(Auth::check())
    {

        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new StockController)->viewRepay($input);
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



    public function OrderViewCount(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->OrderViewCount($input);
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
    public function OrderViewByUid(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->OrderViewByUid($input);
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
    public function StockViewDeliver(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->StockViewDeliver($input);
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
    public function StockCountEdit(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->StockCountEdit($input);
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
    public function StockCount(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->StockCount($input);
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
    public function addSpending(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->addSpending($input);
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
    public function updateSpending(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->updateSpending($input);
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
    public function viewSpending(Request $request){
        if(Auth::check())
        {

            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new StockController)->viewSpending($input);
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
    /*Safari Stock New Code */
   /*SafariCode calculation */
   public function CompanySafariGetAll(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->GetAll();
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
   public function CompanySafariCreate(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->create($input);
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
public function CompanySafariEdit(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->Edit($input);
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

public function CompanySafariDelete(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->Delete($input);
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

public function CompanySafariItemSearch(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->Search($input);
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

public function CompanySafariAddItem(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->AddItem($input);
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
public function CompanySafariEditItem(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->EditItem($input);
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

public function CompanySafariDeleteItem(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->DeleteItem($input);
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

public function CompanySafariSpent(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->Spent($input);
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

public function CompanySafariCalculate(Request $request){

    if(Auth::check())
    {





        if(Auth::user()->platform==$this->platform1)
        {
            $input=$request->all();

            return (new SafariController)->Calculate($input);
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
   /*SafariCode end calculation */



    public function CompanySyncUpload(Request $request){

        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new SyncController)->SyncCardUpload($input);
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

    public function CompanySyncCardDownload(Request $request){

        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new SyncController)->SyncCardDownload($input);
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
    public function CompanyGetNumberDetail(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)-> GetNumberDetail($input);
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
    public function CompanyGetCardDetail(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)-> GetCardDetail($input);
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
    public function CompanyPrintCard(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)->PrintCard($input);
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
    public function CompanyCreateCard(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)->create($input);
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
    public function CompanyCreateMultipleCard(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)->createMultiple($input);
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
    public function CompanyAssignCard(Request $request){//add Card to user
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new CardController)->AssignCard($input);
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
    public function CompanyCreateUser(Request $request){
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new AuthUserRegisterController)->UserCreatedByCompany($input);
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

    public function CompanyCreateUserAssign(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new AuthUserRegisterController)->UserCreatedByCompanyAssign($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }
    }
    public function CompanyEditUserAssign(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new AuthUserRegisterController)->UserEditedByCompanyAssign($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }

    }
    public function CompanyDeleteUserAssign(Request $request){
        if(env('APP_VERS')===$request->input('app_vers'))
        {
        if(Auth::check())
        {





            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new AuthUserRegisterController)->UserDeleteByCompanyAssign($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }

    }
    public function CompanyPromoget(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new PromotionController)->Promoget($input);
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
	}
    public function CompanyCreatePromo(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new PromotionController)->CreatePromo($input);
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
	}
    public function CompanyEditPromo(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new PromotionController)->EditPromo($input);
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
	}
    public function CompanyDeletePromo(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new PromotionController)->DeletePromo($input);
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
	}
    public function CompanyPaidSuperAdmin(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new StockController)->paidSuperAdmin($input);
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
	}
    public function CompanyAddPromo(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new StockController)->AddPromo($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }




    }
    public function CompanyCreatePromotionEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new PromotionController)->CreatePromotionEvent($input);
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

    public function CompanyEditPromotionEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new PromotionController)->EditPromotionEvent($input);
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
    public function CompanyGetAllPromotionEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new PromotionController)->GetAllPromotionEvent($input);
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

    public function CompanyViewAllPromotionEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new PromotionController)->ViewAllPromotionEvent($input);
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

    public function CompanySetPromotionEventStatus(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new PromotionController)->SetPromotionEventStatus($input);
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

    public function CompanyParticipateEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new ParticipateController)->ParticipateEvent($input);
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

    public function CompanyParticipateEditEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();

                return (new ParticipateController)->ParticipateEditEvent($input);
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

    public function CompanyGetAllParticipateEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetAllParticipateEvent($input);
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


    public function CompanyGetActiveParticipateEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetActiveParticipateEvent($input);
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



    public function CompanyCountParticipateEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->CountParticipateEvent($input);
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

    public function CompanyGetReachedParticipateEvent(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetReachedParticipateEvent($input);
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
    public function CompanyGetParticipatedHist(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new MyHistoryController)->GetParticipatedHist($input);
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
    public function CompanyGetAllParticipate(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetAllParticipate($input);
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
    public function CompanyGetAllParticipatedHist(Request $request){
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new MyHistoryController)->GetAllParticipatedHist($input);
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
    public function CompanyTopupUser(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->TopupUser($input);
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
    public function CompanyTopupEditBalance(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->EditBalance($input);
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
    public function CompanyTopupBalanceUser(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->GetBalanceUser($input);
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
    public function CompanyTopupBalanceHistUser(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new MyHistoryController)->BalanceHistUser($input);
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
    public function CompanyTopupBalanceHistCreator(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new MyHistoryController)->BalanceHistCreator($input);
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
    public function CompanyTopupWBalanceHistUser(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new MyHistoryController)->WBalanceHistUser($input);
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
    public function CompanyTopupRedeemBalance(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->RedeemBalance($input);
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
    public function CompanyTopupRedeemBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->RedeemBonus($input);
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
    public function CompanyTopupGetCompanyRecord(Request $request){//add money to your country
        if(env('APP_VERS')===$request->input('app_vers'))
        {

        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new TopupController)->GetCompanyRecord($input);
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
            "result"=>1,
            "downNew"=>env('APP_DOWN'),
            "error"=>"Your app has expired. Please update to the latest version. or Contact System Admin",

        ],200);
    }




    }
     /*Quick Bonus Code */
     public function CompanyPartCheckQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->CheckQuickBonus($input);
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

     public function CompanyPartSetupQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->SetupQuickBonus($input);
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

    public function CompanyPartGetAllQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetAllQuickBonus($input);
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
    public function CompanyPartSearchQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->SearchQuickBonus($input);
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
    public function CompanyPartSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->SubmitQuickBonus($input);
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
    public function CompanyPartUpdateSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->UpdateSubmitQuickBonus($input);
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

    public function CompanyPartConfirmAllSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->ConfirmAllSubmitQuickBonus($input);
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
    public function CompanyPartConfirmOnlySubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->ConfirmOnlySubmitQuickBonus($input);
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
    public function CompanyPartSearchSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->SearchSubmitQuickBonus($input);
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
    public function CompanyPartGetUidSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetUidSubmitQuickBonus($input);
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

    public function CompanyPartDeleteAllSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->DeleteAllSubmitQuickBonus($input);
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
    public function CompanyPartDeleteOnlySubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->DeleteOnlySubmitQuickBonus($input);
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

    public function CompanyPartGetAllSubmitQuickBonus(Request $request){//add money to your country
        if(Auth::check())
        {




            if(Auth::user()->platform==$this->platform1)
            {
                $input=$request->all();
                return (new ParticipateController)->GetAllSubmitQuickBonus($input);
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
        /*Quick Bonus Code */


}
