<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class exportPriceController extends Controller
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



public function ExportChooseProductInSafari(mixed $input){

    return       DB::select("
        SELECT
            s.id,
            s.safariId,
            s.qty,
            p.price,
            p.productCode
        FROM safariproducts s
        INNER JOIN exportProductPrice p ON s.productCode = p.productCode
            AND s.subscriber = p.subscriber
        WHERE s.subscriber = ?
            AND s.productCode = ?
            AND p.currency=?
            AND s.qty > 0
        ORDER BY s.id ASC
        FOR UPDATE
    ", [Auth::user()->subscriber, $input['productCodeSub'],$input["currency"]]);
}


}
