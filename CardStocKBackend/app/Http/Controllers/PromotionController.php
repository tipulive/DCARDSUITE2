<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\StockController;
use DB;
use Auth;


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

    public function reusePromo($input)
    {
        $inStock = $input["promo"]["promotion"]["items"]["inStock"];
        $json_items = [];

        for($i = 0; $i < count($inStock); $i++) {
            $json_items[] = "JSON_OBJECT('productName','" . addslashes($inStock[$i]['productName']) . "', 'qty','" . addslashes($inStock[$i]['qty']) . "', 'price', '" . addslashes($inStock[$i]['price']) . "')";
        }

        $inStockJsonString = implode(",", $json_items);
       return $stringData="JSON_OBJECT(
            'id', :promoId,
            'name',:name,
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
              'allowProduct', 'Only',
              'products',JSON_ARRAY(:allowproducts),
              'exProducts', JSON_ARRAY(:exproducts),
              'TotalToCount', :TotalToCount,
              'cartTotal', :cartTotal,
              'cartCount', :cartCount,
              'card', :cardData
            )
          )
        )";
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
        $input["promoIdN"]=1;
$input["promoArrId"]=0;
        $data = json_decode($this->Promotion($input)[0]->promoschema, true);

        if(count($data)==count($this->searchInPromotion($input)))
        {
              //Uid not exist you can create

              $stringData=$this->reusePromo($input);
              $query = "UPDATE promotions
              SET promoschema = JSON_ARRAY_APPEND(
                COALESCE(promoschema, JSON_ARRAY()),
                '$',
                $stringData
              WHERE id = :promoIdN and subscriber=:subscriber";

              if(DB::update($query,$this->reusableParams($input)))
              {
                return response([
                    "status" => true,
                    "result" =>"Promo Created Successfuly"
                ]);
              }else{
                return response([
                    "status" => false,
                    "result" =>"Promo Not Created please contact system Admin"
                ]);
              }
        }
        else{

            return response([
                "status" => false,
                "result" =>"you can not create promo"
            ]);


        }


    }
    public function EditPromotion($input)
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




    }
    public function DeletePromotion($input)
    {
        $input["promoIdN"]=1;
        $input["promoArrId"]=0;
    $data = json_decode($this->Promotion($input)[0]->promoschema, true);

    if(count($data)==count($this->searchInPromotion($input)))
    {
          //Uid not exist you can not delete anything

          return response([
            "status" => false,
            "result" =>"this Promo does not exist"
        ]);
    }
    else{
        //you may be able to delete
$filtered = array_values($this->searchInPromotion($input));

$input["newpromoschema"] = json_encode($filtered);

if($this->UpdatePromotion($input))
{
    return response([
        "status" => true,
        "result" =>"Promo deleted Successful"
    ]);
}
else{
    return response([
        "status" => true,
        "result" =>"Promo Not deleted Something wrong please contact system Admin"
    ]);
}




    }
    }
    public function searchInPromotion($input)
    {
        $data = json_decode($this->Promotion($input)[0]->promoschema, true);

$filtered = array_filter($data, function ($item) use ($input){
    return $item['id'] !==$input["promo"]["id"];
});

/*$filtered = array_values($filtered); // reindex

$newpromoschema = json_encode($filtered);*/
     return $filtered;
}
    public function reusableParams($input)
    {
        return [
            "promoId"=>$input["promo"]["id"],
            "promoType" =>$input["promo"]["promotype"],
            "name"=>$input["promo"]["name"],
            "startDate"=>$input["promo"]["startDate"],
            "endDate"=>$input["promo"]["endDate"],
            "amount"=>$input["promo"]["promotion"]["amount"],
            "allowproducts"=>$input["allowproducts"],
            "exproducts"=>$input["exproducts"],
            "TotalToCount"=>$input["promo"]["condition"]["TotalToCount"],
            "cartTotal"=>$input["promo"]["condition"]["cartTotal"],
            "cartCount"=>$input["promo"]["condition"]["cartCount"],
            "cardData"=>$input["promo"]["condition"]["card"],

            "subscriber"=>Auth::user()->subscriber,
            "promoIdN"=>$input["promoIdN"]
        ];
    }


    public function Promotion($input){
        return DB::select("select promoschema from promotions where id=:id and subscriber=:subscriber",[
            "id"=>$input["promoIdN"],
            "subscriber"=>Auth::user()->subscriber
        ]);

    }
    public function UpdatePromotion($input)
    {
        return DB::update('update promotions set promoschema=:promoschema,updated_at=:updated_at where id=:promoIdN and subscriber=:subscriber',[
            'promoschema'=>$input["newpromoschema"],
            "promoIdN"=>$input["promoIdN"],
            "subscriber"=>Auth::user()->subscriber,
            'updated_at'=>$this->today,

        ]);

    }

    public function QuickPromo($input, $data)
{
    $results = [];
    $totalPromo = 0;
    $totalQty = 0;

    for ($i = 0; $i < count($data["quick"]["inStock"]); $i++) {
        $result = $this->saveQuickPromo($data["quick"]["inStock"][$i], $input);

        if ($result) {
            $results[] = $result;
            $totalPromo += $result["totalPromo"] ?? 0;
            $totalQty += $result["totalQty"] ?? 0;
        } else {
            return false; // Or handle failure as needed
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
    public function checkLongPromo($input,$data):bool{
        for ($i = 0; $i < count($data["long"]); $i++) {

            $this->saveLongPromo($input,$data["long"][$i]);
          }
          return true;
    }
    public function LongPromo($input,$data){
        if (isset($data["long"]) && count($data["long"])>0) {

            if($this->checkLongPromo($input,$data))
            {


                $this->ProcessQuickPromo($data,$input);
            }
            else{
                throw new \Exception("Unable to Process Long Promotion");
            }
        }
        else{
           $this->ProcessQuickPromo($data,$input);
        }
    }
    public function ProcessQuickPromo($data, $input)
    {
        if (isset($data["quick"]["inStock"]) && count($data["quick"]["inStock"]) > 0) {
            $input["outPromoAmountSub"] = $data["quick"]["BonusAmountTotal"];
           // $input["outPromoAssetSub"] = $data["quick"]["BonusItemValue"];
            //$input["outProAssetQtySub"] = $data["quick"]["BonusQty"];

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
        $input["myOrderId"] = $input["OrderId"] ?? (new StockController)->CreateUid();

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
            "uidUser"=>$input["uidUser"],
            "pointIN"=>$data["inputPoint"],
            "subscriber"=>Auth::user()->subscriber,
            "uidCreator"=>Auth::user()->uid,
            "created_at"=>$this->today
        ]);
    }

    public function UpdateLongPromoAccount($input,$data){
        return DB::update("update promoaccount set pointIN=pointIN+:pointIN,updated_at=:updated_at,uidCreator=:uidCreator where uidUser=:uidUser and uid=:uid limit 1",array(
            "pointIN"=>$data["inputPoint"],
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
            "result" => "Success"
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

        $data = json_decode($this->getPromo(), true);
        if($this->LongPromo($input,$data))//succesfully
        {

            return true;

        }
        else{
            return false;
        }




    }
    public function getPromo(){
        return '{
            "quick": {
              "inStock": [
                {
                  "productName": "imigati",
                  "qtyBonus": 5
                },
                {
                  "productName": "ibijumba",
                  "qtyBonus": 4
                }
              ],
              "BonusAmountTotal": 1200,
              "BonusItemValue": 110,
              "BonusQty": 9
            },
            "long": [
              {
                "id": "fbx",
                "startDate": "2030-06-27 10:00",
                "endDate": "2030-06-27 10:00",
                "inStock": [
                  {
                    "productName": "castel",
                    "qtyBonus": 3
                  },
                  {
                    "productName": "primus",
                    "qtyBonus": 2
                  }
                ],
                "BonusTotal": 500,
                "condition": {
                  "allowProduct": "Only",
                  "products": ["simba", "fanta"],
                  "exProducts": ["simba", "fanta"],
                  "TotalToCount": "cCount",
                  "cartTotal": 100,
                  "cartCount": 50,
                  "card": "yes",
                  "TargetPoint": 7000
                },
                "inputCount": 200,
                "inputTotal": 5000.0,
                "inputPoint": 200
              },
              {
                "id": "fbv",
                "inStock": [
                  {
                    "productName": "castel",
                    "qtyBonus": 7
                  },
                  {
                    "productName": "serengeti",
                    "qtyBonus": 3
                  }
                ],
                "BonusTotal": 400,
                "condition": {
                  "allowProduct": "Only",
                  "products": ["coke"],
                  "exProducts": ["simba", "fanta"],
                  "TotalToCount": "CTotal",
                  "cartTotal": 100,
                  "cartCount": 5,
                  "card": "yes",
                  "TargetPoint": 7000
                },
                "inputCount": 10,
                "inputTotal": 500.0,
                "inputPoint": 500.0
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
