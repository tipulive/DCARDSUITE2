<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\MyHistoryController;
use DB;
use Auth;

class ParticipateController extends Controller
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

    }

    public function ParticipateEvent($input)//not done something is wrong
    {
     return $this->participate($input);
    }
    public function participate($input){


        $check=DB::select("select uid,uidUser,inputData,subscriber from participateds where uid=:uid and uidUser=:uidUser and subscriber=:subscriber  limit 1",array(
            "uid"=>$input['uid'],//event Id
            "uidUser"=>$input['uidUser'],

           // "subscriber"=>$input['subscriber']
            "subscriber"=>Auth::user()->subscriber
        ));
        if($check)
        {
            $inputFromDB=true;
            $inputData=$check[0]->inputData+$input['inputData'];
            if($inputData>=$input['reach'])
            {
                return $this->ParticipateAddBonus($input,$inputData,$inputFromDB);

            }
            else{
               if($this->UpdateMethodParticipated($input,$inputData,"none"))
               {
                return $this->AddHisMethodParticipated($input,"Updated");
                }
                else{
                    return response([
                        "status"=>false,
                        "result"=>0,

                    ],200);
                }


            }
        }
        else{
            //hano ndareba nabwo igige $inputData>$input["reach] //call return $this->ParticipateAddBonus($input,$inputData);
            $inputFromDB=false;
            $inputData=$input['inputData'];
            if($inputData>=$input['reach'])
            {
                return $this->ParticipateAddBonus($input,$inputData,$inputFromDB);//add Bonus

            }
            else{
                if($this->AddMethodParticipated($input,$inputData))//insert InputData,there is no bonus
                {
                   return $this->AddHisMethodParticipated($input,"NewInsert");
                }
                else{
                    return response([
                        "status"=>false,
                        "result"=>0,

                    ],200);
                }

            }

        }

    }
    public function ParticipateAddBonus($input,$inputData,$inputFromDB){

        $inputDB=$inputData%$input['reach'];
        $bonus=$input["gain"]*intdiv($inputData,$input['reach']);//example 902/300=3 because of intdiv

        if($inputFromDB)//when Data is available
        {
         if($this->UpdateMethodParticipated($input,$inputDB,"reached"))
         {
             return $this->AddBonusMethodParticipated($input,$bonus,"Bonus");
         }
         else{
            echo"unable to update new Data";
         }
        }
        else{ //when Data is not Avaialble

        if($this->AddMethodParticipated($input,$inputDB))
         {
             return $this->AddBonusMethodParticipated($input,$bonus,"dataIn");
         }
         else{
             echo"unable to insert new Data";
         }
        }


    }
    public function AddBonusMethodParticipated($input,$bonus,$status){
if((new MyHistoryController)->participatedHist($input,"$status","none"))//after  Reached Bonus and Update Topup
{
   $action="Bonus";
   $moreQuery="";

//after topups then
  return (new TopupController)->AddBonus($input,$bonus,$status,$moreQuery);

}
else{
   return response([
       "status"=>false,
       "result"=>"unable to save participated History",

   ],200);
}

    }
    public function UpdateMethodParticipated($input,$inputDB,$status){//this method will update
        $check2=DB::update("update participateds set status='$status',updated_at=:updated_at,inputData=$inputDB where uid=:uid and uidUser=:uidUser and subscriber=:subscriber limit 1",array(
            "uid"=>$input['uid'],
            //"carduid"=>$input['carduid'],
            "uidUser"=>$input['uidUser'],
            "subscriber"=>Auth::user()->subscriber,
            "updated_at"=>$this->today,
        ));
        return $check2;
    }
    public function AddMethodParticipated($input,$inputDB)
    {
        $check2=DB::table("participateds")
        ->insert([
        "uid"=>$input["uid"],
        "uidUser"=>$input['uidUser'],
        "subscriber"=>Auth::user()->subscriber,
        "inputData"=>$inputDB,
//"carduid"=>$input["carduid"],
        "uidCreator"=>Auth::user()->uid,
        "created_at"=>$this->today,
        "updated_at"=>$this->today,
        ]);
        return $check2;

    }
    public function AddHisMethodParticipated($input,$status){//this method will apply when there is no Bonus

        if((new MyHistoryController)->participatedHist($input,$status,"none"))//First insert in participateds Table
        {
           return response([
               "status"=>true,
               "result"=>1


           ],200);

        }
        else{
            return response([
                "status"=>false,
                "result"=>"unable to save participated History",

            ],200);
        }

    }

    public function participateDate($input){
        return response([
            "status"=>true,
            "result"=>$input


        ],200);
    }


    public function ParticipateEditEvent($input)//not finished
    {
//here inputData=inputDataHist

$check=DB::select("select uid,uidUser,inputData,subscriber from participateds where uid=:uid and uidUser=:uidUser and subscriber=:subscriber  limit 1",array(
    "uid"=>$input['uid'],//event Id
    "uidUser"=>$input['uidUser'],

   // "subscriber"=>$input['subscriber']
    "subscriber"=>Auth::user()->subscriber
));
if($check)
{

    $inputFromDB=true;
    $inputDB=$check[0]->inputData-$input['inputData'];

  if((abs($inputDB))>=$input["reach"])
  {
    $inputData=$input['inputData'];
    //$inputDB=$inputData%$input['reach'];
    //$diffInpDB=$check[0]->inputData-$input['inputData'];
    $inpToDb=$inputDB%$input['reach'];
    $bonus=$input["gain"]*intdiv($inputDB,$input['reach']);

    if($this->UpdateMethodParticipated($input,$inpToDb,"none"))//problem
    {
       return $this->AddBonusMethodParticipated($input,$bonus,"reverse");

    }
   // Bonus reverse

  }
  else{
      // no Bonus reverse only Data to be added on participated_Hist

      if($this->UpdateMethodParticipated($input,$inputDB,"none"))
      {
         if((new MyHistoryController)->participatedHist($input,"reverse","none"))//after  Reached Bonus and Update Topup
         {
            return response([
                "status"=>true,
                "result"=>"success insert participatedHist"


            ],200);
         }
         else{
            return response([
                "status"=>true,
                "result"=>"unable insert into participateHist"


            ],200);
         }

    }

  }
}

    }


    public function CountParticipateEvent($input)
    {

        $uidUser=$input['uidUser'];
        $subscriber=Auth::user()->subscriber;
        $check=DB::select("SELECT (SELECT count(*) from participateds where uidUser='$uidUser' and subscriber='$subscriber' and status='none') AS Active, (SELECT count(*) from participateds where uidUser='$uidUser' and subscriber='$subscriber' and status='reached') AS Reached");


       if($check)
       {

        return response([
            "status"=>true,
             "all"=>($check[0]->Active+$check[0]->Reached),
            "Active"=>$check[0]->Active,
            "Reached"=>$check[0]->Reached


        ],200);
       }
       else{
        return response([
            "status"=>false,
            "result"=>$check,

        ],200);
       }
    }
    public function GetAllParticipate($input)
{
    $LimitStart=$input["LimitStart"]??0;
    $LimitEnd=$input["LimitEnd"]??10;
    $name=$input["name"]??"none";
    $nameQuery=($name!='none')?"and users.name Like '%$name%'  limit 10":"order by participateds.updated_at desc limit $LimitStart,$LimitEnd";
    //$Name



    /*$check=DB::select("select *from participated_hists where subscriber=:subscriber order by id desc limit $LimitStart,$LimitEnd",array(
       "subscriber"=>Auth::user()->subscriber

    ));*/
    $check=DB::select("SELECT users.uid as uidUser,participateds.id,participateds.uid,promotions.promoName,promotions.gain,promotions.reach,participateds.inputData,participateds.created_at,users.name FROM participateds
    INNER JOIN users INNER JOIN promotions ON participateds.uid=promotions.uid AND participateds.uidCreator=:uidCreator and participateds.subscriber=:subscriber and participateds.uid=promotions.uid and participateds.uidUser=users.uid  $nameQuery",array(

        "subscriber"=>Auth::user()->subscriber,
        "uidCreator"=>Auth::user()->uid
    ));

    if($check)
    {

     return response([
         "status"=>true,
         "count"=>count($check),
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
    public function GetAllParticipateEvent($input)//All

{
    $LimitStart=$input["LimitStart"]??0;
    $LimitEnd=$input["LimitEnd"]??10;

            $check=DB::select("select *from participateds where uidUser=:uidUser and subscriber=:subscriber order by updated_at desc limit $LimitStart,$LimitEnd",array(
                 "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
            ));

            if($check)
            {

             return response([
                 "status"=>true,
                 "count"=>count($check),
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

    public function GetActiveParticipateEvent($input)//
    {

        $LimitStart=$input["LimitStart"]??0;
        $LimitEnd=$input["LimitEnd"]??10;


            $check=DB::select("select *from participateds where uidUser=:uidUser and subscriber=:subscriber and status!='reached' limit $LimitStart,$LimitEnd",array(
                 "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
            ));

            if($check)
            {

             return response([
                 "status"=>true,
                 "count"=>count($check),
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
    public function GetReachedParticipateEvent($input)//Reached

    {
        $LimitStart=$input["LimitStart"]??0;
        $LimitEnd=$input["LimitEnd"]??10;

                $check=DB::select("select *from participateds where uidUser=:uidUser and subscriber=:subscriber and status='reached' limit $LimitStart,$LimitEnd",array(
                     "uidUser"=>$input["uidUser"],
                    "subscriber"=>Auth::user()->subscriber
                ));

                if($check)
                {

                 return response([
                     "status"=>true,
                     "count"=>count($check),
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

        /*Quick Bonus Code */

        public function CheckQuickBonus($input)
        {
            //this is to check if there is open QuickBonus Opened with Same Bonus Type,if is Available request to overide instead of recreating it again
            $bonusType=$input['bonusType'];
            $check=DB::select("select productName from quickbonuses where subscriber=:subscriber and status='on' and bonusType='$bonusType' limit 1"
            ,array(
                "subscriber"=>Auth::user()->subscriber
        ));

            if($check)
            {

             return response([
                 "status"=>true,
                 "count"=>count($check),
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
        public function SetupQuickBonus($input){
            //note here i am gonna use Api to get product Details
            $uid=preg_replace('/[^A-Za-z0-9-]/','',$input["productName"]);
            $uid=$uid.""."_".date(time());
            $bonusValue=($input['bonusType']=='Gift')?$input['giftPerPcs']:$input['bonusValue'];
            $check=DB::table("quickbonuses")
            ->insert([
            "quickUid"=>$uid,
            "productName"=>$input["productName"],
            "qty"=>$input['qty'],
            "price"=>$input['price'],
            "status"=>$input['status']??'on',//on or off
            "bonusType"=>$input['bonusType'],//Gift or Money
            "giftName"=>$input['giftName']??'none',//codeName of Carton
            "giftValues"=>$input['giftValues']??'none',//per Carton
            "giftPerPcs"=>$input['giftPerPcs']??'none',//price per 1 pieces
            "giftMin"=>$input['giftMin']??'1',//Min gift you can give to client
            "moneyMin"=>$input['moneyMin']??'1',//Money Minimum
            "bonusValue"=>$bonusValue,//Bonus Value per 1 pcs means if is gift BonusValue=giftPerPcs
            "subscriber"=>Auth::user()->subscriber,
            "uidCreator"=>Auth::user()->uid,
            "description"=>$input["description"],
            "created_at"=>$this->today,
            "updated_at"=>$this->today,
            ]);
            if($check)
            {

             return response([
                 "status"=>true,
                 "count"=>$check,
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
        public function GetAllQuickBonus($input){
            $LimitStart=$input["LimitStart"]??0;
    $LimitEnd=$input["LimitEnd"]??10;

            $check=DB::select("select *from quickbonuses where subscriber=:subscriber  limit $LimitStart,$LimitEnd",array(
                "subscriber"=>Auth::user()->subscriber
            ));

            if($check)
            {

                /*DB::table("testlimitdata")
                ->insert([
                    "limitstart"=>$LimitStart,
                    "limitend"=>$LimitEnd
                ]);*/
             return response([
                 "status"=>true,
                 "count"=>count($check),
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
        public function SearchQuickBonus($input){
            $productName=$input["productName"];
            $check=DB::select("select *from quickbonuses where subscriber=:subscriber and status='on' and productName Like '%$productName%'  limit 10",array(
                //"productName"=>$input["productName"],
                "subscriber"=>Auth::user()->subscriber
            ));

            if($check)
            {

             return response([
                 "status"=>true,
                 "count"=>count($check),
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
        public function SubmitQuickBonus($input){//user submit Data from Mobile Device


                $uid=preg_replace('/[^A-Za-z0-9-]/','',"Quick");
                $uid=$uid.""."_".date(time());
                $uidForm=($input["uid"]==='none')?$uid:$input["uid"];
                $check=DB::table("quickbosubmits")
                ->insert([
                "uid"=>$uidForm,
                "uidUser"=>$input["uidUser"],
                "quickUid"=>$input["quickUid"],
                "productName"=>$input["productName"],
                "qty"=>$input['qty'],
                "price"=>$input['price'],
                "total"=>$input['qty']*$input['price'],//total qty*price
                "status"=>$input['status']??'on',//close to check available on this card
                "bonusType"=>$input['bonusType'],//Gift or Money
                "giftName"=>$input['giftName']??'none',//codeName of Carton//if giftName is 'none' it means that there is no gift involved
                "giftPcs"=>$input['giftPcs']??'none',//tot pcs
                "bonusValue"=>$input['bonusValue']??'none',//Bonus value per pcs
                "totBonusValue"=>$input['totBonusValue']??'none',//Total bonus value i.e:bonusValue*giftPcs
                "subscriber"=>Auth::user()->subscriber,
                "uidCreator"=>Auth::user()->uid,
                "description"=>$input["description"]??'none',
                "created_at"=>$this->today,
                "updated_at"=>$this->today,
                ]);
                if($check)
                {



                 return response([
                     "status"=>true,
                     "result"=>$check,
                     "uid"=>(strtolower($input["status"])=="confirm")?"none":$uid


                 ],200);
                }
                else{
                 return response([
                     "status"=>false,
                     "result"=>$check,

                 ],200);
                }



        }


        public function UpdateSubmitQuickBonus($input){//Update user submit Data from Mobile Device


            $check=DB::update("update quickbosubmits set qty=:qty,price=:price,total=:total,giftPcs=:giftPcs,bonusValue=:bonusValue,totBonusValue=:totBonusValue,updated_at=:updated_at,uidCreator=:uidCreator where id=:id and subscriber=:subscriber limit 1",array(
            "id"=>$input["id"],
            "qty"=>$input['qty'],
            "price"=>$input['price'],
            "total"=>$input['qty']*$input['price'],//total qty*price
            "giftPcs"=>$input['giftPcs']??'none',//tot pcs
            "bonusValue"=>$input['bonusValue']??'none',//Bonus value per pcs
            "totBonusValue"=>$input['totBonusValue']??'none',//Total bonus value i.e:bonusValue*giftPcs
            "subscriber"=>Auth::user()->subscriber,
            "uidCreator"=>Auth::user()->uid,


            "updated_at"=>$this->today,

            ));

            if($check)
            {

             return response([
                 "status"=>true,
                 //"uid"=>$uid,
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
        public function ConfirmAllSubmitQuickBonus($input)
        {
            $check=DB::update("update quickbosubmits set status='confirm',uidCreator=:uidCreator where uid=:uid and status='on' and subscriber=:subscriber  limit 100",array(
                "uid"=>$input["uid"],
                "uidCreator"=>Auth::user()->uid,
                "subscriber"=>Auth::user()->subscriber
            ));
            if($check)
            {

             return response([
                 "status"=>true,
                 //"count"=>count($check),
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
        public function ConfirmOnlySubmitQuickBonus($input)
        {
            $check=DB::update("update quickbosubmits set status='confirm',uidCreator=:uidCreator where id=:id and subscriber=:subscriber limit 1",array(
                "id"=>$input["id"],
                "uidCreator"=>Auth::user()->uid,
                "subscriber"=>Auth::user()->subscriber
            ));
            if($check)
            {

             return response([
                 "status"=>true,
                 //"count"=>count($check),
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

        public function SearchSubmitQuickBonus($input){//

            $LimitStart=$input["LimitStart"]??0;
            $LimitEnd=$input["LimitEnd"]??10;
            $product=$input['productName']??'';
            $status=$input['status']??'';
            $statusQuery=($status!='')?"and quickbosubmits.status='$status'":"and quickbosubmits.status='on'";
            $uidUser=$input["uidUser"]??'';
            $uidUserQuery=($uidUser!='')?"and quickbosubmits.uidUser='$uidUser'":"";

            $productName=($product!='')?"and quickbosubmits.productName Like '%$product%' limit 10":"order by id desc limit $LimitStart,$LimitEnd";


           /*$check=DB::select("select *from quickbosubmits where uidUser=:uidUser and subscriber=:subscriber and status='on' $productName",array(
                "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
            ));*/
            $check=DB::select("SELECT quickbosubmits.id,quickbosubmits.uid,quickbosubmits.uidUser,quickbosubmits.productName,quickbosubmits.qty,quickbosubmits.total
            ,quickbosubmits.bonusType,quickbosubmits.giftName,quickbosubmits.totBonusValue,quickbosubmits.updated_at,quickbonuses.bonusValue,quickbonuses.giftName as bonGiftName,quickbonuses.bonusType as bonBonusType,quickbonuses.giftValues as bonGiftValues,quickbonuses.giftMin,quickbonuses.moneyMin,quickbonuses.price,quickbonuses.giftPerPcs FROM quickbosubmits
            INNER JOIN quickbonuses ON quickbosubmits.subscriber=:subscriber $uidUserQuery $statusQuery and quickbosubmits.quickUid=quickbonuses.quickUid $productName",array(

                "subscriber"=>Auth::user()->subscriber
            ));




                    if($check)
                    {

                     return response([
                         "status"=>true,
                         "count"=>count($check),
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
        public function GetUidSubmitQuickBonus($input){//





            $check=DB::select("select price,quickUid,productName,uidUser,subscriber from quickbosubmits where uidUser=:uidUser and subscriber=:subscriber and status='on' limit 100",array(
                "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
            ));


                    if($check)
                    {

                     return response([
                         "status"=>true,
                         "count"=>count($check),
                         "resultData"=>$check,


                     ],200);
                    }
                    else{
                     return response([
                         "status"=>false,
                         "result"=>$check,

                     ],200);
                    }


        }
        public function DeleteAllSubmitQuickBonus($input)
        {
            $check=DB::delete("delete from quickbosubmits where uid=:uid and uidUser=:uidUser and subscriber=:subscriber limit 100",array(
                "uid"=>$input["uid"],
                "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
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
        public function DeleteOnlySubmitQuickBonus($input)
        {
            $check=DB::delete("delete from quickbosubmits where id=:id and uidUser=:uidUser and subscriber=:subscriber limit 1",array(
                "id"=>$input["id"],
                "uidUser"=>$input["uidUser"],
                "subscriber"=>Auth::user()->subscriber
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

        public function GetAllSubmitQuickBonus($input){//not yet finish submit

            $LimitStart=$input["LimitStart"]??0;
            $LimitEnd=$input["LimitEnd"]??10;

                    $check=DB::select("select *from quickbosubmits where subscriber=:subscriber  limit $LimitStart,$LimitEnd",array(
                        "subscriber"=>Auth::user()->subscriber
                    ));

                    if($check)
                    {

                     return response([
                         "status"=>true,
                         "count"=>count($check),
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

        /*Quick Bonus Code */

}
