<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Imagick;
use Auth;
use DB;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;
use App;
use App\Http\Controllers\Auth\AuthAdminRegisterController;

use Illuminate\Support\Facades\Cache;



class TestController extends Controller
{
    //



public function generateUserAdmin(Request $request)//with compaign{
{

    $input = $request->all();
    $input["status"]="test";
    $input["CompanyName"]="TEST";
    $input["name"]="test";
    $input["email"]="test@"."_".date(time());;
    $input["password"]="1";
    $input["uid"]="Test";


    return (new AuthAdminRegisterController)->AdminCreateCompany($input);

}

public function deleteApp(Request $request)
{
    $input = $request->all();

     return $this->deleteSubApp($input);

    // Decode response safely

}
// Simple API response with readable output

    //this will test my whole app
public function deleteSubApp($input)//this will delete whole company Testing data i must check if it has testing on it
{
    try {
        //code...
        $check=DB::transaction(function () use ($input) {

            //$this->mainDeleteApp($input);
            $this->mainArrDeleteApp($input);
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
public function Testchecksubscriber(){
    $check=DB::select("select  *from admins where  status='test'");
    if($check)
    {
        return response([
            "data"=>"new Data",
            "status"=>$check,


        ],200);
    }else{
        echo "none";
    }
}


public function checkSubscriber($input){
    return DB::select("select status from admins where subscriber=:subscriber and status='test'",[
        "subscriber"=>$input["subscriber"]
    ]);
}

public function mainArrDeleteApp($input)
{
    if (!$this->checkSubscriber($input)) {
        throw new \Exception("No testing data found with this subscriber");
    }

    // Direct table array - NO extra method calls
    $tables = [
        'users','admnin_records','admins','subscriber','dettes','safaristocks', 'safariproducts',
        'products', 'orders','orderhistories', 'promotions',
        'promoaccount', 'repaid_users', 'paid_dettes'
    ];

    $results = [];
    $totalDeleted = 0;

    // Disable foreign key checks for speed (optional but recommended)
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    foreach ($tables as $table) {
        try {
            if($table=='subscriber')
            {
                $deletedCount = DB::delete("DELETE FROM {$table} WHERE uid= :subscriber", [
                    "subscriber"=> $input["subscriber"]
                ]);

                $totalDeleted += $deletedCount;
                $results[$table] = $deletedCount;
            }else{
                $deletedCount = DB::delete("DELETE FROM {$table} WHERE subscriber = :subscriber", [
                    "subscriber"=> $input["subscriber"]
                ]);

                $totalDeleted += $deletedCount;
                $results[$table] = $deletedCount;
            }


        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            throw new \Exception("Failed deleting from {$table}: " . $e->getMessage());
        }
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    return [
        'total_deleted' => $totalDeleted,
        'tables_with_data' => count(array_filter($results)),
        'details' => $results
    ];
}

// You can delete ALL the individual methods (deleteUser, deleteAdmin, etc.)
// They're not needed anymore!
public function mainDeleteApp($input)
{
    if($this->checkSubscriber($input))
    {


    }else{
        throw new \Exception("there is no data with this subscriber");
    }
}
public function deleteUser($input)
{
   return DB::delete("delete users where subscriber=:subscribe",[
    "subscriber"=>$input["subscriber"]
   ]);
}
public function deleteAdminRecord($input)
{
    return DB::delete("delete admnin_records where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteAdmin($input)
{
    return DB::delete("delete admnins where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteDette($input){
    return DB::delete("delete dettes where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteSafaristocks($input){
    return DB::delete("delete safaristocks where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteSafariProduct($input){
    return DB::delete("delete safariproducts where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteProduct($input){
    return DB::delete("delete products where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteOrder($input){
    return DB::delete("delete orders where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteOrderHistory($input){
    return DB::delete("delete orderhistories where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteSubscriber($input){
    return DB::delete("delete subscriber where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deletePromotions($input){
    return DB::delete("delete promotions where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deletePromoaccount($input){
    return DB::delete("delete promoaccount where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}
public function deleteRepaid_users($input){
    return DB::delete("delete repaid_users where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);

}
public function deletePaid_dettes($input){
    return DB::delete("delete paid_dettes where subscriber=:subscribe",[
        "subscriber"=>$input["subscriber"]
       ]);
}

    //this will test my whole app




    public function testdisplayCalculate(Request $request){

        $input=$request->all();

        $stockInterest=$input['SafariId']."_"."int";//interest
        $stockDisplay=$input['SafariId']."_"."dis";//display Stock

        if($this->interest_check($input))
        {


         return response([

                "result"=>Cache::get($stockDisplay),
                "interest"=>Cache::get($stockInterest),
           ],200);

        }
        else{


            return response([
                "test"=>"go",

                "result"=>Cache::get($stockDisplay),
                "interest"=>Cache::get($stockInterest),
             ],200);
        }
        // End time

    }
      public function interest_check($input){
        $SafariId=$input['SafariId'];
        $stockInterest=$input['SafariId']."_"."int";//interest
        $stockDisplay=$input['SafariId']."_"."dis";//display Stock
        if(Cache::get($stockInterest))
        {

            return true;
        }
        else{
            $interest=DB::select("select (sum(TotSoldAmount)-sum(TotBuyAmount)) as interest from producttest where SafariId=:SafariId limit 1000",array(
                "SafariId"=>$SafariId
             ));
             $displayData=DB::select("select * from producttest where SafariId=:SafariId limit 1000",array(
                 "SafariId"=>$SafariId
              ));



             Cache::put($stockInterest,$interest,now()->addMinutes(60));
             Cache::put($stockDisplay,$displayData,now()->addMinutes(60));
        }
      }
    public function testcalculate(Request $request){

        $input=$request->all();
        $SafariId=$input['SafariId'];
        $stockInterest=$input['SafariId']."_"."int";
        $stockTempInterest=$input['SafariId']."_"."tempInt";//Tempinterest
        $spend=(strpos(strtolower($input['status']),'spend') !== false)?true:false;
        $TotQtyPrice=$input['qty']*$input['price'];
        $TotTempBuy=(strpos(strtolower($input['status']),'spend') !== false)?$TotQtyPrice:"0";
        $TotTempSold=(strpos(strtolower($input['status']),'gain') !== false)?$TotQtyPrice:"0";
        /*$TotTempBuy=($input['status']==='spend')?$TotQtyPrice:"0";
        $TotTempSold=($input['status']==='gain')?$TotQtyPrice:"0";*/

        $interest=($this->interest_check($input))?Cache::get($stockInterest)[0]->interest:'0';

        if(Cache::get($stockTempInterest)) //means there is no update in Stock in Safari or no expiration in Safari
        {
            $data1=Cache::get($stockTempInterest);


            $data1["TotTempBuy"]=(Cache::get($stockTempInterest)["TotTempBuy"])+$TotTempBuy;
            $data1["TotTempSold"]=(Cache::get($stockTempInterest)["TotTempSold"])+$TotTempSold;
            $data1["TempInterest"]=((Cache::get($stockTempInterest)["TotTempSold"])+$TotTempSold)-((Cache::get($stockTempInterest)["TotTempBuy"])+$TotTempBuy);
            $data1["Interest"]= $interest;//really interest
            $data1["SumInterest"]=$interest +((Cache::get($stockTempInterest)["TotTempSold"])+$TotTempSold)-((Cache::get($stockTempInterest)["TotTempBuy"])+$TotTempBuy);

            $data1["results"][]=[
                'SafariId' =>$input["SafariId"],
                 'productId' =>$input["productId"],
                 'price' =>$input["price"],
                 'qty' =>$input["qty"],
                 'status' =>$input["status"],
                'TotBuyAmount' =>$TotTempBuy,
                 'TotSoldAmount' =>$TotTempSold,
                 'CommentStatus'=>$input["CommentStatus"]??'none'

                // Add more rows here if needed
            ];


            //Cache::put("Sum",$data1,now()->addMinutes(60));

            Cache::put($stockTempInterest,$data1,now()->addMinutes(60));
            return response([



                "data1"=>Cache::get($stockTempInterest),
                "data2"=>Cache::get($stockInterest)[0]->interest




                ],200);
        }
        else{


            $data1["TotTempBuy"]=$TotTempBuy;
            $data1["TotTempSold"]=$TotTempSold;
            $data1["TempInterest"]=$TotTempSold-$TotTempBuy;
            $data1["Interest"]=$interest;//really interest
            $data1["SumInterest"]=$interest +($TotTempSold-$TotTempBuy);//Sum interest (really Interest- TempInterest)
            $data1["results"][]=[
                'SafariId' =>$input["SafariId"],
                 'productId' =>$input["productId"],
                 'price' =>$input["price"],
                 'qty' =>$input["qty"],
                 'status' =>$input["status"],
                 'TotBuyAmount' =>$TotTempBuy,
                 'TotSoldAmount' =>$TotTempSold,
                 'CommentStatus'=>$input["CommentStatus"]??'none'

                // Add more rows here if needed
            ];
            Cache::put($stockTempInterest,$data1,now()->addMinutes(60));

            return response([



                "data1"=>Cache::get($stockTempInterest)



                ],200);
        }

    }


    public function testGetProductSafari(Request $request){//to place order
$input=$request->all();
       //$check=DB::select("SELECT temporalData FROM orders");
            return response([
                "status"=>true,
                "qt1"=>gettype($input['req_qty']),
               "value"=>$input['req_qty'],
                //"safariuid"=>json_decode($check[0]->temporalData,true)
               // "name"=>$input["SafariName"]

            ],200);
    }

    public function placeOrder($input){

        $req_qty=$input['req_qty'];
        $productId=$input['productId'];
        $check=DB::update("update products set qty_sold=qty_sold+$req_qty where productCode=:productId and qty>=qty_sold+$req_qty limit 1",array(
            "productId"=>$productId
         ));
         if($check)
         {
            DB::select("SET @requested_qty = ?", [$req_qty]);

            $results = DB::select("
                SELECT
                    id,
                    SafariId,
                    CASE
                        WHEN @requested_qty >= qty THEN qty
                        ELSE @requested_qty
                    END AS qty,
                    CASE
                        WHEN @requested_qty >= qty THEN 0
                        ELSE @requested_qty - qty
                    END AS remaining,
                    @requested_qty := GREATEST(@requested_qty - qty, 0) AS updated_requested_qty
                FROM
                    safaritest
                WHERE
                    productId='$productId' AND
                    qty != 0 AND
                    @requested_qty > 0
                ORDER BY
                    id;
            ");



                return $this->testorderPlace($results,$input);
         }
         else{

        return response([
                "status"=>false,
                "message"=>'Something Wrong check if you have enough qty of '."".$productId,
                 ],200);
         }
    }
    public function testorderPlace($results,$input){
        $req_qty=$input['req_qty'];
        $productId=$input['productId'];
        $product=DB::select("select price from products where productCode=:productCode limit 1",array(
         "productCode"=>$productId
        ));
        $uid = Str::random(5);
        $data=[];
        $ids=[];
          $limitData=count($results);
        for($i=0;$i<$limitData;$i++)
        {
            $id=$results[$i]->id;
            $ids[]=$results[$i]->id;
            $data[] = [
                'uid' =>$uid,
                'userid'=>'test',
                'SafariId'=>$results[$i]->SafariId,
                'ProductCode'=>$productId,
                'price'=>$product[0]->price,
                'qty'=>$results[$i]->qty,
                'total'=>$results[$i]->qty*$product[0]->price


                // Add more rows here if needed
            ];

            $SoldOut=$results[$i]->qty;
            $totAm=$SoldOut*$product[0]->price;
            $qtyData=abs($results[$i]->remaining);
           DB::update("update safaritest set qty=:qty,SoldOut=SoldOut+$SoldOut,TotSoldAmount=TotSoldAmount+$totAm where SafariId=:SafariId and productId=:productId limit $limitData",array(
           "qty"=>$qtyData,

           "SafariId"=>$results[$i]->SafariId,
           "productId"=>$productId,

           ));

        }


        DB::table("orderhistories")
        ->insert($data);
        /*DB::update("update orders set userid=:userid where uid='1' limit 1",array(
            'userid' =>'kati6'
            ));*/




        return response([


            "result"=>$results,
            //"data"=>$data



            ],200);
    }
    public function testEditorder(Request $request){
        $input=$request->all();
        $req_qty=$input['req_qty'];
        $productId=$input['productId'];
        $current_qty=$input['current_qty'];
        if($req_qty>$current_qty){
            return $this->placeOrder($input);
        }
        else{

            DB::select("SET @requested_qty = ?", [$req_qty]);

            $results = DB::select("
                SELECT
                    id,
                    SafariId,
                    price,
                    CASE
                        WHEN @requested_qty >= qty THEN qty
                        ELSE @requested_qty
                    END AS qty,
                    CASE
                        WHEN @requested_qty >= qty THEN 0
                        ELSE @requested_qty - qty
                    END AS remaining,
                    @requested_qty := GREATEST(@requested_qty - qty, 0) AS updated_requested_qty
                FROM
                    orderhistories
                WHERE
                    productCode='$productId' AND
                    qty != 0 AND
                    @requested_qty > 0
                ORDER BY
                    id desc;
            ");
            /*return response([
                "status"=>true,
                "results"=>$results,
                 ],200);*/
                 return $this->EditOrder($results,$input);
        }



    }
    public function EditOrder($results,$input){

        $req_qty=$input['req_qty'];
        $productId=$input['productId'];

        $uid = Str::random(5);
        $data=[];
        $ids=[];
          $limitData=count($results);
        for($i=0;$i<$limitData;$i++)
        {
            $id=$results[$i]->id;
            $ids[]=$results[$i]->id;
            $data[] = [
                'uid' =>$uid,
                'userid'=>'test',
                'SafariId'=>$results[$i]->SafariId,
                'ProductCode'=>$productId,
                'price'=>$results[$i]->price,
                'qty'=>$results[$i]->qty,
                'total'=>$results[$i]->qty*$results[$i]->price


                // Add more rows here if needed
            ];

            $SoldOut=$results[$i]->qty;
            $totAm=$SoldOut*$results[$i]->price;
            $qtyData=abs($results[$i]->remaining);
           DB::update("update safaritest set qty=:qty,SoldOut=SoldOut-$SoldOut,TotSoldAmount=TotSoldAmount-$totAm where SafariId=:SafariId and productId=:productId limit $limitData",array(
           "qty"=>$qtyData,

           "SafariId"=>$results[$i]->SafariId,
           "productId"=>$productId,

           ));


           $QueryFactoryDelete="Delete";

           $sqlDelete="delete from ordertest where id=:id limit $limitData";
           $myArrayDelete=[
                "id"=>$results[$i]->id
            ];
            $QueryFactoryUpdate="Update";

           $sqlUpdate="Update ordertest set qty=:qty,total=:total where id=:id and productCode=:productCode limit $limitData";
           $myArrayUpdate=[
            "qty"=>$qtyData,

            "id"=>$results[$i]->id,
            "productCode"=>$productId,
            "total"=>$qtyData*$results[$i]->price
            ];


         //  list($var1, $var2) = ($remaining_qty > $threshold) ? [$remaining_qty - 1, 'greater'] : [$remaining_qty, 'lesser'];
           list($QueryFactory,$SqlData,$myArray) = ($results[$i]->remaining==0) ? [$QueryFactoryDelete,$sqlDelete,$myArrayDelete] : [$QueryFactoryUpdate,$sqlUpdate,$myArrayUpdate];

          DB::$QueryFactory($SqlData,$myArray);





        }



        /*DB::update("update orders set userid=:userid where uid='1' limit 1",array(
            'userid' =>'kati6'
            ));*/




        return response([


            "result"=>$results,
            //"data"=>$data



            ],200);

    }
    public function testCancelOrder(){


    }
public function testSubmitOrder(){

   /* $check=DB::update("update users set  notify");
    $createOrder=DB::table("Orders")
        ->insert();
    $addrecords="admnin_records";*/


try {


// Prepare the SQL statement



// Bind the values to the query parameters


$check=DB::transaction(function () {
    $query1 = "
    INSERT INTO testtable1 (testdata, qty, status)
    VALUES (?, ?, ?)
";

$test="vide";
$query2="
INSERT INTO testtable1_hist (testdata, qty)
VALUES (?, ?)";
       DB::select("select *from testtable1 where id=3");

        DB::insert($query2,[
            'bk', 'dore'
        ]);

        $condition = true; // Replace with your actual condition

        if ($condition) {
            // If the condition is met, return a success response
            return response()->json(['message' => 'Transaction successful'], 200);
        } else {
            // If the condition is not met, return an error response
            return response()->json(['error' => 'Transaction condition not met'], 400);
        }



});

// Execute the prepared statement


//DB::commit();// Use DB::unprepared for multi-statement queries



// Code executed successfully, return a JSON response
//return response()->json(['message' => 'Data inserted successfully',"status"=>$check->original['message']], 200);
} catch (\Exception $e) {
    DB::rollback();
   // throw $e;
    return response()->json(['error' => 'An error occurred',
'errorPrint'=>$e->getMessage()], 500); // Return an error JSON response
}


}
public function test(){
    $query2="
    INSERT INTO testtable1_hist (testdata, qty)
    VALUES (?, ?)";
    $check=DB::insert($query2,[
        'bk', 'game'
    ]);
    if($check){
    return response()->json(['message' => 'Data inserted successfully'], 200);
    }

}


    public function submitForm(Request $request)
{
    auth::user();
    // Process form submission
    header("Location: https://example.com");
}
    public function generateQrCode(){
        /*\QrCode::size(500)
        ->format('png')
        ->generate('codingdriver.com', public_path('images/qrcode.png'));


return view('qr-code');*/


return \QrCode::size(500)
->format('png')
->merge('images/api.jpg', 0.5, true)
->generate('codingdriver.com', public_path('images/qrcode2.png'));

//phpinfo();




    }
    public function testPostData(Request $request){
        $input=$request->all();
       $data=array();
       for($i=0;$i<count($input["onlineData"]);$i++){
       $data[]=[
         "name"=>$input["onlineData"][$i]["name"],
         "email"=>$input["onlineData"][$i]["name"],
       ];

        }


        $check=DB::table("testdatas")
        ->insert($data);

        if($check)
        {
            return response([
                // "allinput"=>$input,
                // "data2"=>$input["item"],
                 "onlineto"=>$input["onlineData"][0]["name"]
             ]);
        }




    }

    public function testGetData(){





      /* $check=DB::select("select *from testdatas");
        return response([
            "status"=>true,
            "result"=>$check,



            ],200);*/


             /* $check=\QrCode::size(500)
        ->format('png')
        ->generate('Vuba ndaje', public_path('images/qrcode1.png'));

        var_dump($check);//null */


$bol="1";
$m="teta";
$n="keb";
    list($q,$v)=($bol=="1")?[$m,$n]:["deja"];
    return response([
        "data" => $q
    ]);

    }

    public function testPdf(){


        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('myPDFog', $data);

       // return $pdf->download('itsolutionstuffte.pdf');
       return $pdf->stream();

       /* $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();*/

    }
    public function testencrypt(){
       echo"hello";
    }

}
