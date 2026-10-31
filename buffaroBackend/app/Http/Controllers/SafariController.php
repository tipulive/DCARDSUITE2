<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Str;

class SafariController extends Controller
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
        $this->platform1=env('PLATFORM3');
    }


    public function GetAll()
    {

        $check=DB::select("select *from safaris ORDER BY id DESC
        LIMIT 100");
        if($check)
        {
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>true,

                "result"=>$check//safari UId

             ]);
        }
        else{
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>false,


             ]);
        }
    }
    public function create(mixed $input)
    {
        $uid=$input["name"].""."_".Str::random(5).""."_".date(time());
        $check=DB::table("safaris")
         ->insert([
             "uid"=>$uid,
             "name"=>$input["name"],
             "comment"=>$input["comment"]??'none',
             "uidCreator"=>Auth::user()->uid,
             "subscriber"=>Auth::user()->subscriber,
             "created_at"=>$this->today
         ]);

         if($check)
         {
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>true,
                "safariuid"=>$uid,
                "name"=>$input["name"],
                "result"=>$uid//safari UId

             ]);

         }
         else{
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>false,
                "result"=>$check

             ]);
         }
    }
    public function Edit(mixed $input)
    {
        //"comment"=>$input["name"]??'none',

        $uid=$input['uid'];
        $check=DB::update("update safaris set name=:name,comment=:comment,updated_at=:updated_at where uid=:uid limit 1",array(
            "uid"=>$input["uid"],
            "name"=>$input["name"],
            "comment"=>$input["comment"],
            "updated_at"=>$input["updated_at"],
            //$checkupdate
        ));
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

         ],201);
        }

    }
    public function Delete(mixed $input){
        $check=DB::delete("delete from safaris where uid=:uid limit 1",array(

            "uid"=>$input["uid"]
        ));
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

         ],201);
        }
    }

    public function Search(mixed $input)
    {

$itemName=$input["ItemName"];
        $check=DB::select("select *from safari_products where typeData=:typeData and uid LIKE '%$itemName%' LIMIT 50",array(
            "typeData"=>$input["typeData"],

           ));

        if($check)
        {
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>true,

               "result"=>$check

            ]);

        }
        else{
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>false,
               "result"=>$check

            ]);
        }
    }
    public function AddItem(mixed $input)//Add product of Safari
    {
        //$uid=Auth::user()->subscriber.""."_".Str::random(5).""."_".date(time());
        $check=DB::table("safari_products")
         ->insert([
             "safariuid"=>$input["safariuid"],
             "uid"=>$input["uid"],
             "price"=>$input["price"],
             "currency"=>$input["currency"]??"none",
             "qty"=>$input["qty"],
             "pcs"=>$input["pcs"]??"none",
             "size"=>$input["size"]??"none",
             "comment"=>$input["comment"]??"none",
             "typeData"=>$input["typeData"]??"none",//products
             //soldPrice will be in USD
             //status
             //exchangerate
             //currency


             "exchangeRate"=>$input["exchangeRate"]??"none",
             "uidCreator"=>Auth::user()->uid,
             "subscriber"=>Auth::user()->subscriber,
             "created_at"=>$this->today
         ]);

         if($check)
         {
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>true,
                "safariuid"=>$input["safariuid"],
                "safariName"=>$input["name"],
                "result"=>$input["uid"]

             ]);

         }
         else{
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>false,
                "result"=>$check

             ]);
         }

    }

    public function EditItem(mixed $input)
    {

        $check=DB::update("update safari_products set uid=:uid,price=:price,SoldInterest=:SoldInterest,qty=:qty,pcs=:pcs,updated_at=:updated_at,comment=:comment where safariuid=:safariuid and id=:id limit 1",array(
            "safariuid"=>$input["safariuid"],
             "id"=>$input["id"],
             "uid"=>$input["uid"],
             "price"=>$input["price"],
             "SoldInterest"=>$input["SoldInterest"],

             "qty"=>$input["qty"],
             "pcs"=>$input["pcs"],

             "comment"=>$input["comment"],

             "updated_at"=>$this->today
        ));
        if($check)
        {
            return response([
                "status"=>true,
                "safariuid"=>$input["safariuid"],
                "name"=>$input["name"]

            ],200);

        }
        else{
         return response([
             "status"=>false,
             "result"=>$check,

         ],201);
        }
    }


    public function DeleteItem(mixed $input)
    {
        $safariuid=$input["safariuid"];
        $check=DB::delete("delete from safari_products where safariuid=:safariuid limit 1",array(

            "safariuid"=>$safariuid
        ));
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

         ],201);
        }
    }
    public function Spent(mixed $input)//Money depense(ayo wa depensije cg igihe uri kumwishyura ufite ideni)
    {
        $check=DB::table("spents")
        ->insert([
            "safariuid"=>$input["safariuid"],
           // "uid"=>$input["uid"],
            "price"=>$input["price"],//by default paid currency it will be USD


            //"qty"=>$input["qty"],

            "comment"=>$input["comment"]??"none",
            "uidCreator"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber,
            "created_at"=>$this->today
        ]);

        if($check)
        {
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>true,
               "result"=>$check

            ]);

        }
        else{
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>false,
               "result"=>$check

            ]);
        }
    }
    public function Calculate(mixed $input)//ayo bizagera hano product zihagaze
    {
        //x=sum all price buy products/sum(products)=
        //then eachProduct+x

        $ProductSum=DB::select("select sum(qty) as ProductSumQty from safari_products where safariuid=:safariuid and typeData=:typeData  limit 2000 ",array(
            "safariuid"=>$input["safariuid"],
            "typeData"=>"product"
        ));
        $SpendSum=DB::select("select sum(price) as SumPrice from safari_products where safariuid=:safariuid and typeData!='product' limit 2000 ",array(
            "safariuid"=>$input["safariuid"]

        ));

        /*$check=DB::select("select sum(price) as sumPrice,id,uid,safariuid,price,currency,exchangeRate,typeData,status,qty,pcs,size,comment,uidCreator,subscriber from safari_products where safariuid=:safariuid GROUP BY id limit 2000",array(
            "safariuid"=>$input["safariuid"]
        ));*/
        /*$check=DB::select("select *from safari_products where safariuid=:safariuid and typeData=:typeData limit 2000",array(
            ":safariuid"=>$input["safariuid"],
            "typeData"=>"product"
        ));*/
        $check=DB::select("select *from safari_products where safariuid=:safariuid ORDER BY id DESC limit 2000",array(
            ":safariuid"=>$input["safariuid"]

        ));

        $dataProduct=array();
        $totalBuyProduct=0;
        $totalSoldProduct=0;
        $dataOtherSpend=array();//other spend
        foreach($check as $checkData){
            if($checkData->typeData=='product')
            {
                $totalBuyProduct+=((($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty))*$checkData->qty);
                $totalSoldProduct+=((($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty)+$checkData->SoldInterest)*$checkData->qty);
                $pcsCheck=$checkData->pcs=='none'?'no pcs set':$checkData->pcs;
                $PricePerPiece=$checkData->pcs=='none'?'there is no Price per piece because pcs is not set':(($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty))/$pcsCheck;
                $SoldPricePerPiece=$checkData->pcs=='none'?'there is no Price per piece because pcs is not set':(($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty)+$checkData->SoldInterest)/$pcsCheck;
                $dataProduct[]=[
                    "id"=>$checkData->id,
                    "safariuid"=>$checkData->safariuid,
                    "uid"=>$checkData->uid,
                    "qty"=>$checkData->qty,
                    "pcs"=>$pcsCheck,
                    "size"=>$checkData->size,
                    "price"=>$checkData->price,//price

                    "currency"=>$checkData->currency,
                    "exchangeRate"=>$checkData->exchangeRate,
                    "typeData"=>$checkData->typeData,
                    "status"=>$checkData->status,
                    "uidCreator"=>$checkData->uidCreator,
                    "subscriber"=>$checkData->subscriber,

                    //

                    "pricePerPiece"=>$PricePerPiece,//price kuri pcs imwe without interest
                    "ProductPriceOneQty"=>($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty),//Product Price izahagera ihagazeho kuri 1Qty (ishobora kuba ari 1 carton)
                    "ProductPriceNumberQty"=>(($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty))*$checkData->qty,//Product Price izahagera ihagazeho kuri certain number of Qty
                    "PriceToAdd"=>($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty),//ayo Twongereyeho bitewe na spending
                    //

                    //interest check//
                    "SoldInterestOneQty"=>$checkData->SoldInterest,
                    "SoldPricePerPiece"=>$SoldPricePerPiece,
                    "SoldPriceOneQty"=>($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty)+$checkData->SoldInterest,//Sold Price of one Qty //nukuvugango hano nongeyeho abiri ku ikarito
                    "SoldPriceNumberQty"=>(($checkData->price/$checkData->qty)+($SpendSum[0]->SumPrice/$ProductSum[0]->ProductSumQty)+$checkData->SoldInterest)*$checkData->qty,
                    //interest check//
                    "comment"=>$checkData->comment,
                    "created_at"=>$checkData->created_at
                  ];
            }
            else{
                $dataOtherSpend[]=[
                    "name"=>$checkData->uid,
                    "price"=>$checkData->price,//price
                    "comment"=>$checkData->comment,
                    "typeData"=>$checkData->typeData,
                    "created_at"=>$checkData->created_at



                  ];

            }

        }
        if($check)
        {
            $interest=array(
                    "TotalBuyProduct"=>$totalBuyProduct,
                    "TotalSoldProduct"=>$totalSoldProduct,
                    "interest"=>$totalSoldProduct-$totalBuyProduct


            );
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>true,
               "name"=>$input["name"],
               "safariuid"=>$input["safariuid"],
               "CalculateInterest"=>$interest,
               "TotalQtyProduct"=>$ProductSum[0]->ProductSumQty,//total of all Prize
               "TotalPriceOtherSpend"=>$SpendSum[0]->SumPrice,//total price of others spending not produtcs
               "ProductResult"=>$dataProduct,
               "OtherSpend"=>$dataOtherSpend



            ]);

        }
        else{
           return response([
               // "allinput"=>$input,
               // "data2"=>$input["item"],
               "status"=>false,
               "name"=>$input["name"],
               "safariuid"=>$input["safariuid"],

            ]);
        }


    }
    public function CalculateInterest(mixed $input)//interest calculation
    {

    }
    public function getTotalSpent(mixed $input)
    {

    }

}
