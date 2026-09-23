<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\StockController;
use DB;
use Auth;
use Illuminate\Support\Str;


class PromotionController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set(env('TIME_ZONE'));
        $this->today = date('Y-m-d H:i:s', time());
        $this->today2 = date('d-m-Y H:i:s', time());
        $this->Appstate=env('APP_LIVE')?env('APP_PRO'):env('APP_DEV');
        $this->AppName=env('APP_NAME');

        $this->otp='1 hours';
      // $this->otp='20 seconds';//test purpose
        $this->email_confirm='24 hours';
        $this->Admin_Auth_error="You Are not authenticate please Request Permission to Admin";
        $this->Admin_Auth_result_error="0";//Admin auth result zero

    }

/*withdraw Long PromoData */
    public function withdawPromo($input)//long promo withdraw
    {
        try {


            DB::transaction(function () use ($input) {
                $mamaUid="MSolange_1709926940";
            $input["UserId"]=($input["uidUser"]===$mamaUid)?$mamaUid:Auth::user()->uid;
            $input["uidCreator"]=Auth::user()->uid; //is the one who will pay money to client when he will withdraw
            $input["subscriber"]=Auth::user()->subscriber;
               $this->ProcesswithdrawLongPromo($input);
            });

            return response([
                "status" => true,
                "result" => "Sucess"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }
    }


    public function updateUserPromoAccount($input,$data){
        return DB::update("update promoaccount set cCount=:cCount,cTotal=:cTotal,updated_at=:updated_at where uid=:uid and uidUser=:uidUser and subscriber=:subscriber limit 1",[
            "cCount"=>$data["remaincCount"],
            "cTotal"=>$data["remaincTotal"],
            "uidUser"=>$input["uidUser"],
            "uid"=>$data["uid"],
            "subscriber"=>Auth::user()->subscriber,
            "updated_at"=>$this->today
        ]);
    }
    public function checkPromoAccount($input,$data){
    if($this-> withdrawHistory($input,$data))
    {
        if($this->updateUserPromoAccount($input,$data))
        {
          return true;
        }
        else{
            throw new \Exception("Unable to update Promotion".$data["uid"]);
        }
    }else{
        throw new \Exception("Unable to withdraw Promotion");
    }


    }

    public function withdrawHistory($input,$data)
    {
        return DB::table("withdrawlongpromo")
        ->insert([
            "uid"=>(new StockController)->CreateUid($input),
            "promoId"=>$data["uid"],
            "userId"=>$input["uidUser"],
            "uidCreator"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber,
            "commentData"=>$input["commentData"]??'none',
            "dataWithdraw"=>json_encode($data),
        ]);
    }
    public function ProcesswithdrawLongPromo($input)
    {


        $input["longPromoWithDraw"]="widthraw";
           // $input["outPromoAmountSub"] = $data["quick"]["BonusAmountTotal"];
           $input["OrderId"]= (new StockController)->CreateUid($input);
           $input["myOrderId"] = $input["OrderId"] ;

            $promo=$input["promoData"];
        //$promo=$this->longPromoData();
           // $promo=$input["promoData"];
            $data = json_decode($promo, true);


            if($this->checkPromoAccount($input,$data))
            {
                $input["promoAmountSub"] =$data["TotalBonus"];
                $input["gainPromoSub"]=$input["promoAmountSub"];
                $result = $this->withdrawLongPromo($input,$data);

                if ($result) {

                    //var_dump($mydata["condition"]); var_dump($mydata["condition"]);
                    $input["totalPromoT"]=$result["totalPromo"];
                    $input["totalPromoQtyT"]=$result["totalQty"];
                     $input["promoAssetSub"] =$result["totalPromo"];
                    $input["proAssetQtySub"] =$result["totalQty"];

                    // Success - process order
                    (new StockController)->NewSubmitOrder($input);
                    // $result; // Return results instead of throwing exception
                } else {
                    throw new \Exception("Unable to Process Quick Promotion");
                }

            }else{
                throw new \Exception("Unable to update Withdraw Data");
            }


    }
    public function withdrawLongPromo($input,$data)
    {
        $results = [];
        $totalPromo = 0;
        $totalQty = 0;



            $input["saveQuickUid"]=$data["uid"];
            for($iv=0;$iv<count($data["itemsBonus"]);$iv++)
            {

                $result = $this->saveWithdrawLongPromo($data["itemsBonus"][$iv], $input);
               // var_dump($result);

                if ($result) {
                    $results[] = $result;
                    $totalPromo += $result["totalPromo"] ?? 0;
                    $totalQty += $result["totalQty"] ?? 0;
                } else {
                    return false; // Or handle failure as needed
                }
            }

            return [
                "totalPromo" => $totalPromo,
                "totalQty" => $totalQty,
                "details" => $results  // Optional: keep individual results
            ];
    }
        public function saveWithdrawLongPromo($data,$input)
        {
            $input["productCodeSub"] = $data["productName"];
            $input["req_qtySub"] = (int)$data['qty'];
            $input["uidClient"] = "eric_177358819";

            $input["subscriberSub"]=Auth::user()->subscriber;

            $stockController = new StockController();
            $result = $stockController->UpdateSafariOrderHistory($input);

            return $result ?: false;
        }

        public function longPromoData()
        {
            return '{
                "uid": "promo_b4_1785919506",
                "countCondition": "cCount",
                "remaincCount": "2",
                "remaincTotal": "350",
                "TotalBonus": "300",
                "itemsBonus": [
                  {
                    "productName": "bombo",
                    "qty": 2
                  }
               ]
              }';
        }
   /*withdraw Long PromoData */
    public function reusePromo($input)
    {
        $inStock = $input["promo"]["promotion"]["items"]["inStock"]??[];
        $json_items = [];

        for($i = 0; $i < count($inStock); $i++) {
           // $json_items[] = "JSON_OBJECT('productName','" . addslashes($inStock[$i]['productName']) . "', 'qty','" . addslashes($inStock[$i]['qty']) . "', 'price', '" . addslashes($inStock[$i]['price']) . "')";
           $json_items[] = "JSON_OBJECT('productName','" . addslashes($inStock[$i]['productName']) . "', 'qty','" . addslashes($inStock[$i]['qty']) . "')";
        }

        $result = $this->conditionParts($input);
        $conditionString = $result['conditionString'];
        $inStockJsonString = implode(",", $json_items);
       return $stringData="JSON_OBJECT(
            'id', :promoId,
            'name',:name,
            'description', :description,
            'startDate',:startDate,
            'endDate',:endDate,
            'promotype', :promoType,
            'promotion', JSON_OBJECT(
              'amount', :amount,
              'items', JSON_OBJECT(
                'inStock', JSON_ARRAY(
                    {$inStockJsonString}
                    ),
                'OutStock', JSON_ARRAY()
              )
            ),
            'condition', JSON_OBJECT(
                $conditionString
            )
          )
        )";
    }

    public function conditionParts($input): array
    {
        // Default bind parameters for the fixed conditions
        $bindParams = [];

        // Start with the fixed conditions
        $conditionParts = [
            "'productRule', :productRule",
            "'TotalToCount', :TotalToCount",
            "'cartTotal', :cartTotal",
            "'cartCount', :cartCount",
            "'targetCount', :targetCount",
            "'targetTotal', :targetTotal",


           // "'userType', :userType",

            "'card', :cardData"
        ];

        $conditionParts[] = "'userTypes', JSON_EXTRACT(:userTypes, '$')";
        $userTypesJson = json_encode(
            array_map('trim', explode(',', $input["userTypes"]))
        );
        $bindParams['userTypes'] =$userTypesJson ?? null;

        $productRule =$input["promo"]["condition"]["productRule"];


        // Conditionally add product/exProduct fields
        if ($productRule === 'all') {
            // add neither
        } elseif ($productRule === 'only') {
            $conditionParts[] = "'products', JSON_EXTRACT(:products, '$')";
            $productJson = json_encode(
                array_map('trim', explode(',', $input["products"]))
            );
            $bindParams['products'] =$productJson ?? null;
        } elseif ($productRule === 'allExcept') {
            $conditionParts[] = "'exProducts', JSON_EXTRACT(:exproducts, '$')";

            $exproductJson = json_encode(
                array_map('trim', explode(',', $input["exproducts"]))
            );
            $bindParams['exproducts'] = $exproductJson ?? null;
        } else {
            // fallback: include both (for any other value)
            $conditionParts[] = "'products', JSON_EXTRACT(:products, '$')";
            $conditionParts[] = "'exProducts', JSON_EXTRACT(:exproducts, '$')";
            $productJson = json_encode(
                array_map('trim', explode(',', $input["products"]))
            );
            $exproductJson = json_encode(
                array_map('trim', explode(',', $input["exproducts"]))
            );
            $bindParams['products'] =$productJson ?? null;
            $bindParams['exproducts'] = $exproductJson ?? null;
        }

        $conditionString = implode(",\n      ", $conditionParts);

        return [
            'conditionString' => $conditionString,
            'bindParams'      => $bindParams,
        ];
    }
    public function GetPromoData($input)
    {
        $check=DB::select("select uid,promoschema from promotions where subscriber=:subscriber",[
            "subscriber"=>Auth::user()->subscriber
        ]);
        if($check)
        {
            $platform=$input["platform"]??'none';

            $objects = json_decode($check[0]->promoschema);
            $platformData=($platform!='mobile')?$check:$objects;
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                "status"=>true,

                //"result"=>$objects,//safari UId
                "result"=>$platformData


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
    public function Promoget($input)
    {
       // $json=json_decode($check[0]->promoschema,true);
//
$input["promoIdN"]=1;
$input["promoArrId"]=0;
return $this->CreatePromo($input);
//return $this->EditPromotion($input);
//return $this-> DeletePromotion($input);

     /*$check=DB::select("select promoschema from promotions where id=1");

     $json=json_decode($check[0]->promoschema,true);
     return response([
        "status" => true,
        "result" =>$json
    ]);*/

    /*return response([
        "status" => true,
        "result" =>$input["promo"]["promotion"]["items"]["inStock"]
    ]);*/

    }

  /*  public function reusePromo($input,$stock)
    {
        $inStock = $input["promo"]["promotion"]["items"]["inStock"];
$json_items = [];

for($i = 0; $i < count($inStock); $i++) {
    $json_items[] = "JSON_OBJECT('productName','" . addslashes($inStock[$i]['productName']) . "', 'qty','" . addslashes($inStock[$i]['qty']) . "', 'price', '" . addslashes($inStock[$i]['price']) . "')";
}

return $inStockJsonString = implode(",", $json_items);
    }*/

    public function CreatePromo($input)
    {
        try {


            DB::transaction(function () use ($input) {

               $this->CreatePromoProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Sucess"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }
    }

    public function CreatePromoProcessing($input)
    {

        $mainPromo=$input["mainPromoId"]??"none";
       /// $stringData=$this->reusePromo($input);
    if($mainPromo!="none")
    {

        if($this->checkPromo($input))
        {
          return false;//existed promoId
        }else{

             $input["promoMainUid"]=$input["mainPromoId"];
             $input["promo"]["id"]="promo"."_".Str::random(2).""."_".date(time());
            if($this->promoCreate($input))
            {
                $this->updatePromo($input);
            }
            else{
                throw new \Exception("unable to Create Promo");

            }
        }
    }else{

        $input["promoMainUid"]="promo"."_".Str::random(2).""."_".date(time());
        $input["promo"]["id"]=$input["promoMainUid"];
        //CreatePromoData
        //$stringData=$this->CreatePromoData($input);
        $check=DB::table("promotions")
                ->insert([
                    "uid"=>$input["promoMainUid"],
                    "uidCreator"=>Auth::user()->uid,
                    "subscriber"=>Auth::user()->subscriber,
                   // "promoName"=>$input["promoName"]??"none",
                   // "promo_msg"=>$input["promoMsg"]??"none",
                    "promoschema"=>json_encode($input["promo"]),
                    "reach"=>$input["reach"]??"0",//number
                    "gain"=>$input["gain"]??"0",//number
                    "token"=>$input["token"]??'0',//token that is equal after promotion finished

                    //"ended_date"=>(STR_TO_DATE($endto, '%Y-%m-%d %H:%i:%s')),
                    "status"=>"On",
                    "created_at"=>$this->today,
                ]);

                if($check)
                {
                    if($this->promoCreate($input))
                    {
                       //echo "create successful";
                       return true;
                    }
                    else{
                        throw new \Exception("unable to create");

                    }
                    //return true;
                }
                else{
                    throw new \Exception("unable to create process");
                }
    }


    }

    public function updatePromo($input){
        $stringData=$this->reusePromo($input);
              $query = "UPDATE promotions
              SET promoschema = JSON_ARRAY_APPEND(
                COALESCE(promoschema, JSON_ARRAY()),
                '$',
                $stringData
              WHERE uid = :promoIdN and subscriber=:subscriber";

              if(DB::update($query,$this->reusableParams($input)))
              {
                return true;
              }else{
                throw new \Exception("unable to Create This Promo");
              }

    }
    public function promoCreate($input){
                   return DB::table("promocreate")
                    ->insert([
                        "uid"=>$input["promo"]["id"],
                        "name"=>$input["promo"]["name"],
                        "description"=>$input["promo"]["description"],
                        "refId"=>$input["promoMainUid"],
                        "uidCreator"=>Auth::user()->uid,
                        "promoschema"=>json_encode($input["promo"]),
                        "cCount"=>$input["promo"]["condition"]["cartCount"],
                        "cTotal"=>$input["promo"]["condition"]["cartTotal"],
                        "countCondition"=>$input["promo"]["condition"]["TotalToCount"],
                        "bonusAmount"=>$input["promo"]["promotion"]["amount"],
                        "bonusStocks"=>json_encode($input["promo"]["promotion"]["items"]["inStock"]??[]),
                       // "target"=>$input["promo"]["condition"]["TargetPoint"],//means minimum to withdraw
                        "targetCount"=>$input["promo"]["condition"]["targetCount"]??'0',//means minimum to withdraw
                        "targetTotal"=>$input["promo"]["condition"]["targetTotal"]??'0',//means minimum to withdraw
                        "subscriber"=>Auth::user()->subscriber,
                        "created_at"=>$this->today

                    ]);
    }

    public function UpdatePromoCreate($input)
    {
        return DB::update("update promocreate set promoschema=:promoschema,name=:name,description=:description,cCount=:cCount,cTotal=:cTotal,countCondition=:countCondition,bonusAmount=:bonusAmount,targetCount=:targetCount,targetTotal=:targetTotal,bonusStocks=:bonusStocks where uid=:uid and subscriber=:subscriber",[
            "promoschema"=>json_encode($input["promo"]),
            "name"=>$input["promo"]["name"],
            "description"=>$input["promo"]["description"],
            "uid"=>$input["promo"]["id"],
            "cCount"=>$input["promo"]["condition"]["cartCount"],
            "cTotal"=>$input["promo"]["condition"]["cartTotal"],
            "countCondition"=>$input["promo"]["condition"]["TotalToCount"],
            "bonusAmount"=>$input["promo"]["promotion"]["amount"],
            "targetCount"=>$input["promo"]["condition"]["targetCount"]??'0',//means minimum to withdraw
            "targetTotal"=>$input["promo"]["condition"]["targetTotal"]??'0',//means minimum to withdraw
            "bonusStocks"=>json_encode($input["promo"]["promotion"]["items"]["inStock"]??[]),
           //
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
    public function DeletePromoCreate($input)
    {
        return DB::delete(
            "DELETE FROM promocreate
             WHERE uid = :uid
             AND subscriber = :subscriber
             LIMIT 1",
            [
                "uid" => $input["promo"]["id"],
                "subscriber" => Auth::user()->subscriber
            ]
        );
    }


    public function checkPromo($input){
       return DB::select("select *from promocreate where uid=:uid and refId=:refId and subscriber=:subscriber",[
            "uid"=>$input["promo"]["id"],
            "refId"=>$input["mainPromoId"]??"none",
            "subscriber"=>Auth::user()->subscriber
        ]);
    }
   /* public function EditPromotion($input)
    {
        $input["promoIdN"]=1;
$input["promoArrId"]=0;
        $data = json_decode($this->Promotion($input)[0]->promoschema, true);

        if(count($data)==count($this->searchInPromotion($input)))
        {
//Uid does not exist
return response([
    "status" => false,
    "result" =>"this Promo does not exist"
]);
        }else{

            $stringData=$this->reusePromo($input);
            $myNewreusableParams=array_merge($this->reusableParams($input),array(
                "promoArrId"=>$input["promoArrId"]
    ));
            $query = "UPDATE promotions
            SET promoschema = JSON_SET(
              COALESCE(promoschema, JSON_ARRAY()),
              CONCAT('$[', :promoArrId, ']'),
              $stringData
            WHERE id=:promoIdN and subscriber=:subscriber";

            if(DB::update($query,$myNewreusableParams))
            {
                return response([
                    "status" => true,
                    "result" =>"Promo Edited Successfuly"
                ]);

            }else{
                return response([
                    "status" => false,
                    "result" =>"Promo Not Edited please contact system Admin"
                ]);
            }
        }




    }*/

    public function GetMyPromotion(Request $request)
    {
        $input=$request->all();
        $check=DB::select("
        SELECT
            r.uid,
            r.uidUser,
            r.updated_at,
            r.cCount,
            r.cTotal,
            r.pointIn,

            a.name AS promoOwner,
            b.name AS promoName,
            b.cCount AS condCount,
            b.cTotal AS condTotal,
            b.countCondition AS countCondition,
            b.bonusAmount AS bonusAmount,
            b.bonusStocks AS bonusStocks,
            b.targetTotal AS targetTotal,
            b.description,
            b.targetCount AS targetCount
        FROM promoaccount r
        INNER JOIN  promocreate b ON r.uid = b.uid
        INNER JOIN users a ON r.uidUser = a.uid
        WHERE r.uidUser = :uid
        ORDER BY r.id DESC
        LIMIT 10
    ", [
        "uid"=>$input["uidUser"]??Auth::user()->uid

    ]);

    if($check)
    {
        return response([

            "status"=>true,

            "result"=>$check,


         ]);
    }
    else{
        return response([
            "status"=>false,
            "mess"=>"No Promo Found",


         ]);
    }


    }
    public function GetMyPromotionHist(Request $request)
    {
        $input=$request->all();
        $check=DB::select("
        SELECT
            r.uid,
            r.uidUser,
            r.created_at,

            a.name AS promoOwner,
            b.name AS promoName,
            b.countCondition AS countCondition,
            b.bonusAmount AS bonusAmount,
            b.bonusStocks AS bonusStocks,
            b.targetTotal AS targetTotal,
            b.description,
            b.targetCount AS targetCount
        FROM  longpromohist r
        INNER JOIN  promocreate b ON r.uid = b.uid
        INNER JOIN users a ON r.uidUser = a.uid
        WHERE r.uidUser = :uidUser and r.uid=:uidPromo
        ORDER BY r.id DESC
        LIMIT 10
    ", [
        "uidUser"=>$input["uidUser"]??Auth::user()->uid,
        "uidPromo"=>$input["uidPromo"],

    ]);

    if($check)
    {
        return response([

            "status"=>true,

            "result"=>$check,


         ]);
    }
    else{
        return response([
            "status"=>false,
            "mess"=>"No Promo Found",


         ]);
    }


    }
    public function EditPromotion($input){
        try {

            $input["promoMainUid"]=$input["mainPromoId"];
            DB::transaction(function () use ($input) {

                //return $this->searchInPromotion($input);


               $this->promoEditProcessing($input);
            });
            $data = json_decode($this->Promotion($input)[0]->promoschema, true);
            return response([
                "status" => true,
                "result" => "Sucess",
                "promo"=>count($data)
            ]);

        } catch (\Exception $e) {
            $filtered = array_values($this->searchInPromotion($input));

            $input["newpromoschema"] =json_encode($filtered);
            return response()->json([
                "status" => false,
                "test"=>$input["newpromoschema"],
                "input"=>$input["promoMainUid"],
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }
    }
    public function promoEditProcessing($input)
    {

       if($this->checkPromo($input))
       {
               if($this->UpdatePromoCreate($input))
               {
                $filtered = array_values($this->searchInPromotion($input));

                $input["newpromoschema"] = json_encode($filtered);

                if($this->UpdatePromoSchema($input))
                {
                        return true;
                }else{
                    throw new \Exception("we can not delete something wrong");
                }
               }else{
                throw new \Exception("we can not delete something wrong");
               }
       }else{
        throw new \Exception("Unable to delete because Promo ID is not available");
       }
    }

    public function UpdatePromoSchema($input)
    {
        $stringData=$this->reusePromo($input);
            $myNewreusableParams=array_merge($this->reusableParams($input),array(
                "promoArrId"=>$input["promoArrId"]
    ));
            $query = "UPDATE promotions
            SET promoschema = JSON_SET(
              COALESCE(promoschema, JSON_ARRAY()),
              CONCAT('$[', :promoArrId, ']'),
              $stringData
            WHERE uid=:promoIdN and subscriber=:subscriber";

            return DB::update($query,$myNewreusableParams);


    }
    public function DeletePromotion($input)
    {
        try {

            $input["promoMainUid"]=$input["mainPromoId"];
            DB::transaction(function () use ($input) {

                //return $this->searchInPromotion($input);
               $this->promodelProcessing($input);
            });

            return response([
                "status" => true,
                "result" => "Sucess"
            ]);

        } catch (\Exception $e) {
            $filtered = array_values($this->searchInPromotion($input));

            $input["newpromoschema"] =json_encode($filtered);
            return response()->json([
                "status" => false,
                "test"=>$input["newpromoschema"],
                "input"=>$input["promoMainUid"],
                "message" => $e->getMessage(),
                'errorCode' => $e->getLine()
            ], 500);
        }

    }
    public function promodelProcessing($input)
    {
       if($this->checkPromo($input))
       {

               if($this->DeletePromoCreate($input))
               {

                $filtered = array_values($this->searchInPromotion($input));

                $input["newpromoschema"] =json_encode($filtered);
                if($this->UpdatePromotion($input))
                {
                        return true;
                }else{
                    throw new \Exception("we can not delete");
                }
               }else{
                throw new \Exception("we can not delete something wrong");
               }
       }else{
        throw new \Exception("Unable to delete because Promo ID is not available");
       }
    }
    public function searchExistPromotion($input)
    {
        $data = json_decode($this->Promotion($input)[0]->promoschema, true);

$filtered = array_filter($data, function ($item) use ($input){
    return $item['id']==$input["promo"]["id"];
});

/*$filtered = array_values($filtered); // reindex

$newpromoschema = json_encode($filtered);*/
     return $filtered;
}
    public function searchInPromotion($input)
    {
        $data = json_decode($this->Promotion($input)[0]->promoschema, true);

/*$filtered = array_filter($data, function ($item) use ($input){
    return $item['id'] !==$input["promo"]["id"];
});*/
$filtered = array_filter($data, function ($item) use ($input) {
    return $item !== $input['promo']['id'];
});

/*$filtered = array_values($filtered); // reindex

$newpromoschema = json_encode($filtered);*/
     return $filtered;
}
    public function reusableParams($input)
    {
       // $array = array_map('trim', explode(',', $yourString));

    $params=[
            "promoId"=>$input["promo"]["id"],
            "promoType" =>$input["promo"]["promotype"],
            "name"=>$input["promo"]["name"],
            'description' => $input['promo']['description'] ?? 'You wil get free discount',
            "startDate"=>$input["promo"]["startDate"],
            "endDate"=>$input["promo"]["endDate"],
            "amount"=>$input["promo"]["promotion"]["amount"],
           //"amount"=>123,
           "productRule"=>$input["promo"]["condition"]["productRule"],
           // "allowproducts"=>$input["products"],//products

           //"products"=>$productJson,
            //"exproducts"=>$exproductJson,
            "TotalToCount"=>$input["promo"]["condition"]["TotalToCount"],
            "cartTotal"=>$input["promo"]["condition"]["cartTotal"],
            "cartCount"=>$input["promo"]["condition"]["cartCount"],
            "targetCount"=>$input["promo"]["condition"]["targetCount"],
            "targetTotal"=>$input["promo"]["condition"]["targetTotal"],

            "cardData"=>$input["promo"]["condition"]["card"],

            "subscriber"=>Auth::user()->subscriber,
            "promoIdN"=>$input["promoMainUid"]
        ];
        $result = $this->conditionParts($input);
        $bindParams = $result['bindParams'];
        $newArr=array_merge($bindParams,$params);
        return $newArr;

    }


    public function Promotion($input){
        return DB::select("select promoschema from promotions where uid=:uid and subscriber=:subscriber",[
            "uid"=>$input["promoMainUid"],
            "subscriber"=>Auth::user()->subscriber
        ]);

    }
    public function UpdatePromotion($input)
    {
        return DB::update('update promotions set promoschema=:promoschema,updated_at=:updated_at where uid=:promoIdN and subscriber=:subscriber',[
            'promoschema'=>$input["newpromoschema"],
            "promoIdN"=>$input["promoMainUid"],
            "subscriber"=>Auth::user()->subscriber,
            'updated_at'=>$this->today,

        ]);

    }

    public function QuickPromo($input, $data)
{
    $results = [];
    $totalPromo = 0;
    $totalQty = 0;


    for ($i = 0; $i < count($data["quick"]); $i++) {
        $input["saveQuickUid"]=$data["quick"][$i]["id"];
        for($iv=0;$iv<count($data["quick"][$i]["inStock"]);$iv++)
        {
            $result = $this->saveQuickPromo($data["quick"][$i]["inStock"][$iv], $input);
            if ($result) {
                $results[] = $result;
                $totalPromo += $result["totalPromo"] ?? 0;
                $totalQty += $result["totalQty"] ?? 0;
            } else {
                return false; // Or handle failure as needed
            }
        }

    }

    // Return combined result
    return [
        "totalPromo" => $totalPromo,
        "totalQty" => $totalQty,
        "details" => $results  // Optional: keep individual results
    ];
}
    public function getPromotionStatus($startDate, $endDate)
    {
        $today = strtotime(date('Y-m-d H:i'));
        $start = strtotime($startDate);
        $end   = strtotime($endDate);

        if (!$start || !$end) {
            return "invalid";
        }

        if ($today < $start) {
            return "not_started";
        }

        if ($today > $end) {
            return "ended";
        }

        return "active";
        /*$status = getPromotionStatus(
            "2026-05-04 10:00",
            "2015-06-27 10:00"
        );

        if ($status === "active") {
            // promotion is running
            echo "is running";
        }
        else{
          echo $status;
        }*/
    }
    public function GetLongDetail($input){

    }
    public function longWithdraw($input)
    {

    }
    public function checkLongPromo($input,$data):bool{
        for ($i = 0; $i < count($data["long"]); $i++) {

            $mydata=$data["long"][$i];
            $input["myUid"]=$data["long"][$i]["id"];
           if($this->conditionLongPromo($input,$mydata))
           {
            $this->saveLongPromo($input,$data["long"][$i]);
           }else{
            //$condParts= $mydata["condition"]["TotalToCount"];

            throw new \Exception("unable to Create History Long Promo");

           }


          }
          return true;
    }
    public function ConditionLParts($input,$data):array
    {
        $condParts=$data["condition"]["TotalToCount"];


        if($condParts==='cCount')
        {
            return [
                'cCount' => $data["inputCount"],
                'cTotal'=>'0',
            ];
        }
        elseif($condParts==='CTotal')
        {

            return [
                'cCount' => "0",
                'cTotal'=> $data["inputTotal"],
            ];

        }elseif($condParts==='both')
        {

            return [
                'cCount' => $data["inputCount"],
                'cTotal'=> $data["inputTotal"],
            ];
        }else{
            throw new \Exception("unable Ccount");
        }



    }
    public function conditionLongPromo($input,$data){


        $condParts=$data["condition"]["TotalToCount"];


        if($condParts==='cCount')
        {
            $input["tType"]="cCount";
            $input["cCount"]=$data["inputCount"];
            $input["cTotal"]="0";

            if($this->LongpromoHist($input))
            {
                return true;
            }else{
                throw new \Exception("unable Ccount");
            }
        }elseif($condParts==='CTotal')
        {
            $input["tType"]="CTotal";
            $input["cCount"]="0";
            $input["cTotal"]=$data["inputTotal"];
            if($this->LongpromoHist($input))
            {
                return true;
            }else{
                throw new \Exception("unable CTotal");
            }
        }elseif($condParts==='both')
        {
            $input["tType"]="both";
            $input["cCount"]=$data["inputCount"];
            $input["cTotal"]=$data["inputTotal"];
            if($this->LongpromoHist($input))
            {
                return true;
            }else{
                throw new \Exception("unable both");
            }
        }else{
          return false;
        }


    }
    public function LongpromoHist($input){

        return DB::table("longpromohist")
            ->insert([
                "uid"=>$input["myUid"],//promoUid
                "orderId"=>$input["OrderId"],
                "uidUser"=>$input["uidUser"],
                "tType"=>$input["tType"],
                "cCount"=>$input["cCount"]??'0',
                "cTotal"=>$input["cTotal"]??'0',
                "subscriber"=>Auth::user()->subscriber,
                "uidCreator"=>Auth::user()->uid,
                "created_at"=>$this->today
            ]);
    }
    public function LongPromo($input,$data){

        if (isset($data["long"]) && count($data["long"])>0) {

            if($this->checkLongPromo($input,$data))
            {
                //throw new \Exception("Unable to Process Long Promotion");

                $this->ProcessQuickPromo($data,$input);
            }
            else{
                throw new \Exception("Unable to Process Long Promotion");
            }
        }
        else{
            //throw new \Exception("Unable to Process Pom".$input);
           $this->ProcessQuickPromo($data,$input);
        }
    }
    public function ProcessQuickPromo($data, $input)
    {
        if (isset($data["quick"]) && count($data["quick"]) > 0) {
           // $input["outPromoAmountSub"] = $data["quick"]["BonusAmountTotal"];
            $input["outPromoAmountSub"] =array_sum(array_column($data["quick"], 'BonusTotal'));

            $input["gainPromoSub"]=$input["outPromoAmountSub"];
            $result = $this->QuickPromo($input, $data);

            if ($result) {
                $input["totalPromoT"]=$result["totalPromo"];
                $input["totalPromoQtyT"]=$result["totalQty"];
                 $input["outPromoAssetSub"] =$result["totalPromo"];
                $input["outProAssetQtySub"] =$result["totalQty"];

                // Success - process order
                (new StockController)->NewSubmitOrder($input);
                // $result; // Return results instead of throwing exception
            } else {
                throw new \Exception("Unable to Process Quick Promotion");
            }
        } else {
            // No quick promotions - just submit order
            (new StockController)->NewSubmitOrder($input);
        }
    }
    public function saveQuickPromo($data, $input)
    {
        $input["productCodeSub"] = $data["productName"];
        $input["req_qtySub"] = (int)$data['qtyBonus'];
        $input["uidClient"] = "eric_177358819";
        $input["myOrderId"] = $input["OrderId"] ?? (new StockController)->CreateUid($input);
        $input["subscriberSub"]=Auth::user()->subscriber;

        $stockController = new StockController();
        $result = $stockController->UpdateSafariOrderHistory($input);

        return $result ?: false;
    }
   /* public function saveQuickPromo($data, $input): bool
    {
        $subscriber  = Auth::user()->subscriber;
        $productCode = $data["productName"];
        $req_qty     = (int) $data['qtyBonus'];

        // 🔒 1. Lock product row (prevents race conditions)
        $product = DB::table('products')
            ->where('subscriber', $subscriber)
            ->where('productCode', $productCode)
            ->lockForUpdate()
            ->first();

        if (!$product) {
            throw new \Exception("Product not found: $productCode");
        }

        // 🔴 2. Check available stock
        $available = $product->qty - $product->qty_sold;

        if ($available < $req_qty) {
            throw new \Exception("Insufficient stock for $productCode");
        }

        // ✅ 3. Update main product stock
        $updated = DB::table('products')
            ->where('id', $product->id)
            ->update([
                'qty_sold' => DB::raw("qty_sold + {$req_qty}")
            ]);

        if (!$updated) {
            throw new \Exception("Failed to update product stock");
        }

        // 🔒 4. Lock FIFO batches
        $batches = DB::table('safariproducts')
            ->where('subscriber', $subscriber)
            ->where('productCode', $productCode)
            ->where('qty', '>', 0)
            ->orderBy('id') // FIFO
            ->lockForUpdate()
            ->get();

        if ($batches->isEmpty()) {
            throw new \Exception("No batch stock found");
        }

        // ✅ 5. FIFO deduction
        $remaining = $req_qty;
        $distribution = [];

        foreach ($batches as $batch) {

            if ($remaining <= 0) break;

            $deduct = min($remaining, $batch->qty);

            // Save distribution (optional use)
            $distribution[] = [
                "batch_id" => $batch->id,
                "safariId" => $batch->safariId,
                "deducted_qty" => $deduct
            ];

            // Update batch
            $affected = DB::table('safariproducts')
                ->where('id', $batch->id)
                ->update([
                    'qty' => DB::raw("qty - {$deduct}")
                ]);

            if (!$affected) {
                throw new \Exception("Failed to update batch ID {$batch->id}");
            }

            $remaining -= $deduct;
        }

        // ❌ 6. If not fully satisfied → rollback everything
        if ($remaining > 0) {
            throw new \Exception("Not enough stock in batches for $productCode");
        }

        // ✅ 7. Optional: save movement / logs / order
        // $this->testorderPlace($distribution, $input, $subscriber);

        return true;
    }*/




    public function SaveQuickPromoINCompany($data,$input){

        if((new StockController)->addSubscriber($input))
        {
            return true;
        }else{
            throw new \Exception("Not unable to update Company Account");
        }
    }


    public function saveLongPromo($input,$data): bool
    {
      if($this->GetThisLongPromo($input,$data))
      {
        $result = $this->ConditionLParts($input,$data);
           $input["cCount"]=$result["cCount"];
           $input["cTotal"]=$result["cTotal"];

          if($this->UpdateLongPromoAccount($input,$data))
          {
            return true;
          }
          else{
            throw new \Exception("Something Wrong unable to update This Promo" . $data["id"]);
          }
      }
      else{
          if($this->InsertLongPromoAccount($input,$data))
          {
            return true;
          }
          else{
            throw new \Exception("Something Wrong unable to insert This Promo" . $data["id"]);
          }
      }


    }

    public function GetThisLongPromo($input,$data){
        return DB::select("select uid,uidUser from promoaccount where uidUser=:uidUser and uid=:uid limit 1",array(
            "uidUser"=>$input["uidUser"],
            "uid"=>$data["id"]
           ));
    }
    public function InsertLongPromoAccount($input,$data){
        return DB::table("promoaccount")
        ->insert([
            "uid"=>$data["id"],//promoUid
            "orderId"=>$input["OrderId"],
            "uidUser"=>$input["uidUser"],
            "pointIN"=>$data["inputPoint"],
            "cCount"=>$data["inputCount"]??'0',
            "cTotal"=>$data["inputTotal"]??'0',
            "subscriber"=>Auth::user()->subscriber,
            "uidCreator"=>Auth::user()->uid,
            "created_at"=>$this->today
        ]);
    }

    public function UpdateLongPromoAccount($input,$data){
        return DB::update("update promoaccount set cCount=cCount+:cCount,cTotal=cTotal+:cTotal,pointIN=pointIN+:pointIN,updated_at=:updated_at,uidCreator=:uidCreator where uidUser=:uidUser and uid=:uid limit 1",array(
            "pointIN"=>$data["inputPoint"],
            "cCount"=>$input["cCount"]??'0',
            "cTotal"=>$input["cTotal"]??'0',
            "uidUser"=>$input["uidUser"],
            "uid"=>$data["id"],
            "uidCreator"=>Auth::user()->uid,
            "updated_at"=>$this->today
           ));
    }

    public function Promo($input)
{
    try {


        DB::transaction(function () use ($input) {
            $mamaUid="MSolange_1709926940";
        $input["UserId"]=($input["uidUser"]===$mamaUid)?$mamaUid:Auth::user()->uid;
        $input["uidCreator"]=Auth::user()->uid; //is the one who will pay money to client when he will withdraw
        $input["subscriber"]=Auth::user()->subscriber;
           $this->addData($input);
        });

        return response([
            "status" => true,
            "result" => "Sucess"
        ]);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => $e->getMessage(),
            'errorCode' => $e->getLine()
        ], 500);
    }
}
    public function addData($input):bool
    {

        //code...

                  //$data = json_decode($this->getPromo(), true);
       // $promo=$input["promoData"];
        //$promo=$this->getPromo();

        $promo=$input["promoData"];
        if($promo!='none')
        {
            $data = json_decode($promo, true);
            // var_dump($data);
             if($this->LongPromo($input,$data))//succesfully
             {

                 return true;

             }
             else{
                 return false;
             }

        }else{
        if((new StockController)->NewSubmitOrder($input))
        {
            return true;
        }
        else{
            return false;
        }
        }






    }
    public function getPromo(){
        return '
        {
            "quick": [],
            "long": [
              {
                "id": "promo_long",
                "inStock": [
                  {
                    "productName": "laptop",
                    "qtyBonus": 1
                  }
                ],
                "BonusTotal": 300,
                "condition": {
                  "productRule": "all",
                  "TotalToCount": "CTotal",
                  "cartTotal": 500.0,
                  "cartCount": 10,
                  "card": "yes",
                  "allowProduct": "all",
                  "products": [],
                  "exProducts": []
                },
                "inputCount": 40,
                "inputTotal": 2000.0,
                "inputPoint": 2000.0
              },{
                "id": "promo_vigo",
                "inStock": [
                  {
                    "productName": "laptop",
                    "qtyBonus": 1
                  }
                ],
                "BonusTotal": 300,
                "condition": {
                  "productRule": "all",
                  "TotalToCount": "cCount",
                  "cartTotal": 500.0,
                  "cartCount": 10,
                  "card": "yes",
                  "allowProduct": "all",
                  "products": [],
                  "exProducts": []
                },
                "inputCount": 60,
                "inputTotal": 6000.0,
                "inputPoint": 2000.0
              },
              {
                "id": "promo_zinga",
                "inStock": [
                  {
                    "productName": "laptop",
                    "qtyBonus": 1
                  }
                ],
                "BonusTotal": 300,
                "condition": {
                  "productRule": "all",
                  "TotalToCount": "both",
                  "cartTotal": 500.0,
                  "cartCount": 10,
                  "card": "yes",
                  "allowProduct": "all",
                  "products": [],
                  "exProducts": []
                },
                "inputCount": 90,
                "inputTotal": 6000.0,
                "inputPoint": 2000.0
              }
            ]
          }';
    }
    public function CreatePromotionEvent($input)
    {
        $uid=preg_replace('/[^A-Za-z0-9-]/','',$input['promoName']);
        $uid=$uid.""."_".date(time());
        $extension=$input["extended_date"];
           $started=explode('to',$extension)[0];
           $endto=explode('to',$extension)[1];
        $check=DB::table("promotions")
        ->insert([
         "uid"=>$uid,
         "uidCreator"=>Auth::user()->uid,
         "subscriber"=>Auth::user()->subscriber,
         "promoName"=>$input["promoName"],
         "promo_msg"=>$input["promoMsg"],
         "reach"=>$input["reach"],//number
         "gain"=>$input["gain"],//number
         "token"=>$input["token"]??'none',//token that is equal after promotion finished
         "started_date"=>$started,
         "ended_date"=>$endto,
         //"ended_date"=>(STR_TO_DATE($endto, '%Y-%m-%d %H:%i:%s')),
         "status"=>"On",
         "created_at"=>$this->today,

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


    public function EditPromotionEvent($input)
    {
        $uid=$input['uid'];
        $extension=$input["extended_date"];
           $started=explode('to',$extension)[0];
           $endto=explode('to',$extension)[1];
        $check=DB::update("update promotions set promoName=:promoName,promo_msg=:promo_msg,reach=:reach,gain=:gain,started_date=:started_date,ended_date=:ended_date,updated_at=:updated_at,status=:status where uid=:uid and subscriber=:subscriber limit 1",array(
            "uid"=>$input["uid"],
            //"uidCreator"=>Auth::user()->uid,
            "subscriber"=>Auth::user()->subscriber,
            "promoName"=>$input["promoName"],
            "promo_msg"=>$input["promoMsg"],
            "reach"=>$input["reach"],//number
            "gain"=>$input["gain"],//number
            //"token"=>$input["token"]??'none',//token that is equal after promotion finished
            "started_date"=>$started,
            "ended_date"=>$endto,
            //"ended_date"=>(STR_TO_DATE($endto, '%Y-%m-%d %H:%i:%s')),
            "status"=>"On",
            "updated_at"=>$this->today,
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
    public function ViewAllPromotionEvent($input)//Get all promotion that has  On status
    {


        $check=DB::select("select *from promotions where subscriber=:subscriber limit 100",array(
            "subscriber"=>Auth::user()->subscriber
        ));
        if($check)
        {


         return response([
             "status"=>true,
             "result"=>$check,
             "datas"=>$this->today


         ],200);
        }
        else{

                return response([
                    "status"=>false,
                    "result"=>$check,

                ],200);


        }




    }
    //start here
    public function GetAllPromotionEvent($input)//Get all promotion that has  On status
    {

        $check1=DB::update("update promotions set status='close' where status='on' and subscriber=:subscriber and ended_date<='$this->today' limit 50",array(
            "subscriber"=>Auth::user()->subscriber
        ));
        $check=DB::select("select *from promotions where subscriber=:subscriber and status='On' limit 100",array(
            "subscriber"=>Auth::user()->subscriber
        ));
        if($check)
        {


         return response([
             "status"=>true,
             "result"=>$check,
             "datas"=>$this->today


         ],200);
        }
        else{

                return response([
                    "status"=>false,
                    "result"=>$check,

                ],200);


        }




    }


    public function SetPromotionEventStatus($input)//On,Off,Close //not Default status it does not need to be set on Database
    {
        $check=DB::update("update promotions set status=:status where uid=:uid and subscriber=:subscriber  limit 1",array(
            "uid"=>$input["uid"],
            "subscriber"=>Auth::user()->subscriber,
            "status"=>$input["status"]
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
