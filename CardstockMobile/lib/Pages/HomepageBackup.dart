import 'dart:math';


import '../../../models/Topups.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl_phone_field/intl_phone_field.dart';

import '../../../Query/CardQuery.dart';
import '../../../Query/StockQuery.dart';
import '../../../models/CardModel.dart';
import '../../../models/QuickBonus.dart';


import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

import 'package:qr_code_scanner/qr_code_scanner.dart';
//import 'package:wakelock/wakelock.dart';
import 'package:get/get.dart';




import '../../../models/Participated.dart';

import '../../../models/Promotions.dart';
import '../Query/AdminQuery.dart';
import '../Pages/components/BottomNavigator/HomeNavigator.dart';




import '../../../Query/PromotionQuery.dart';

import '../models/User.dart';



class Homepage extends StatefulWidget {
  const Homepage({Key? key}) : super(key: key);



  @override
  State<Homepage> createState() => _HomepageState();


}
class _HomepageState extends State<Homepage> {

  List<dynamic> dataSearch = [];
  List<dynamic> cartData = [];
  List<dynamic> users=[];
  List<dynamic>qrSearch = [];

  PromotionQuery promotionState=Get.put(PromotionQuery());
  AdminQuery adminStatedata=Get.put(AdminQuery());
  //StockQuery stockQueryData=Get.put(StockQuery());
  String searchText = '';
  TextEditingController inputDataDept=TextEditingController();
  TextEditingController searchContro=TextEditingController();
  TextEditingController promoName=TextEditingController();
  TextEditingController uidInput=TextEditingController();//uid promo
  TextEditingController uidInput2=TextEditingController(text:'kebineericMuna_1668935593');//userid of user that will be available after qr scan
  TextEditingController uidInput3=TextEditingController();//input data to submit
  TextEditingController uidInput4=TextEditingController();
  TextEditingController uidInput5=TextEditingController();
  TextEditingController clientName=TextEditingController();
  TextEditingController commentData=TextEditingController();
  TextEditingController  initCountry=TextEditingController();

  String promoMsg="none";
  bool showProfile=false;
  bool showOver=false;
  bool isSubmitted=false;
  bool productSearch=false;
  bool  productSearchPopup=true;
  final GlobalKey qrKey = GlobalKey(debugLabel: 'QR');
  Barcode?result;
  QRViewController?controller;

  bool optionVal=true;
  List items=["male","female","others","Keb2"];

  bool cameraValue=false;
  bool flashValue=false;
  dynamic resultDataValue;

  GlobalKey userBottomSheetKey = GlobalKey();

  bool isValid = false;
  bool isSubmit=false;
  bool isQrShow=false;
  String searchName="";
  String phoneNumber="";
  int limitData=10;
  bool searchValOption=false;
  int editQty=0;


  @override

  @override
  Widget build(BuildContext context)
  {


    /*void reassemble(){
      super.reassemble();
      //controller!.resumeCamera();
      if(Platform.isAndroid)
      {
        controller!.resumeCamera();

      }else if (Platform.isIOS)
      {
        controller!.pauseCamera();
      }
    }*/

    //hidekeyboard();
    //UserQuery userQueryData = Get.put(UserQuery());



    // ParticipatedQuery participatedState=Get.put(ParticipatedQuery());

    //Map<String,dynamic> Promo_data=promotionState.obj["resultData"]??promotionState.obj;

    //FocusScope.of(context).unfocus();//hide keyboard on screen loadin
    return Scaffold(
      resizeToAvoidBottomInset: true,
      body:Stack(
        children: [
          Column(
            children: [
              //Qr Code


              const SizedBox(height: 40,),
              GetBuilder<StockQuery>(
                builder: (hideShowcontroller) {
                  //return Text('Data: ${_controller.data}');
                  return
                 // (hideShowcontroller.userProfile["uid"]!='none')?
                    (hideShowcontroller.hidePickClick)?
                    InkWell(
                      onTap: (){
                        if(((Get.put(StockQuery()).order)["resultData"][0]["uid"])=="none") {
                          pickDefaultUser(true,true);
                        }
                        else{
                          pickDefaultUser(true,false);
                        }
                        //pick Default Account;
                        //then Default Account Has set
                        //if sales has edit Status,please you can not set default account
                        //or you can not choose any Other Account,
                      },

                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        mainAxisSize: MainAxisSize.min,
                        children: const [
                          Icon(Icons.star, color: Colors.yellow), // Replace with your desired icon
                          SizedBox(width: 8.0), // Adjust the space between icon and text
                          Text('Pick Default Account', style: TextStyle(fontSize: 16.0)),
                        ],
                      ),

                    ):
                    const Visibility(
                        visible:false,
                        child: Text(""));
                },
              ),

              // SearchBarField(search: _data,searchController:searchContro,PerformSearch:,),
              SearchBarField(
                // Correct: explicitly assigning null
                searchMethod:(text) async{
                  if (text!= searchText) {

                    performSearch(text,"none");//note i must figure out how to avoid
                    searchText=text;
                  }else{



                  }

                },


                scanProductMethod: (){

                  scanProduct();
                },
                searchController: searchContro,
              ),

              if(productSearch)
                Expanded(
                  child: ProductSearchList(addCartMethod:(dynamicData){
                    addCartPlus(dynamicData);

                  },searchResult:(Get.put(StockQuery()).dataSearch)),
                ),

              // Center(child: Text("${(Get.put(StockQuery()).userProfile)["name"]}")),

              GetBuilder<StockQuery>(
                builder: (hideShowcontroller) {
                  //return Text('Data: ${_controller.data}');
                  return
                    //(hideShowcontroller.userProfile["uid"]!='none')?
                    (hideShowcontroller.hidePickClick)?
                    //code With Click Events
                    Row(
                      mainAxisSize: MainAxisSize.min,
                      children:  [
                        IconButton(
                            icon: const Icon(Icons.contact_phone),
                            iconSize: 23.0,
                            color: Colors.blue,
                            onPressed: () {
                              setState(() {
                                phoneNumber="test";
                                searchValOption=false;
                              });


                              getUserData();
                              searchUser(context);
                            }

                        ), // Replace with your desired icon
                        const SizedBox(width: 8.0), // Adjust the space between icon and text
                        InkWell(
                            onTap: () {
                              setState(() {
                                phoneNumber="none";
                                searchValOption=false;
                              });


                              getUserData();
                              searchUser(context);
                            },
                            child: Text('${(Get.put(StockQuery()).order)["resultData"][0]["name"]}', style: const TextStyle(fontSize: 16.0))),
                        const SizedBox(width: 8.0),
                        IconButton(
                            icon: const Icon(Icons.qr_code),
                            iconSize: 23.0,
                            color: Colors.pink,
                            onPressed: () {
                              scanUser();

                            }

                        ),
                      ],
                    ):
                    //code without Click event
                    Row(
                      mainAxisSize: MainAxisSize.min,
                      children:  [
                        // Adjust the space between icon and text
                        Text('${(Get.put(StockQuery()).order)["resultData"][0]["name"]}', style: const TextStyle(fontSize: 16.0)),

                      ],
                    );
                },
              ),

              if(((Get.put(StockQuery()).order)["resultData"][0]["uid"])!="none")

                Row(
                  mainAxisSize: MainAxisSize.min,
                  children:  [
                    // Adjust the space between icon and text
                    Text("OrderId:${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}", style: const TextStyle(fontSize: 16.0)),
                    const SizedBox(width: 8.0),
                    IconButton(
                        icon: const Icon(Icons.delete),
                        iconSize: 23.0,
                        color: Colors.red,
                        onPressed: () {
                          Get.dialog(
                            AlertDialog(
                              title: const Text('Confirmation'),
                              content: Text('Do you want to Delete ${(Get.put(StockQuery()).order)["resultData"][0]["uid"]} ?'),
                              actions: [
                                ElevatedButton(
                                  style: ElevatedButton.styleFrom(

                                    //primary: Colors.grey[300],
                                    backgroundColor: Colors.red,
                                    elevation:0,
                                  ),
                                  onPressed: () async{
                                    (Get.put(StockQuery()).updateHideLoader(false));

                                    var resultData=(await StockQuery().deleteTOrder(Topups(uid:"${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}"))).data;

                                    if(resultData["status"])
                                    {
                                      (Get.put(StockQuery()).updateHideLoader(true));

                                      /*List<dynamic> orderVal=[
                                        {
                                          "name":"Unknown",
                                          "uid":""
                                        }
                                      ];*/
                                      num totalVal=0;

                                      (Get.put(StockQuery()).updateSumOrder(totalVal));
                                      (Get.put(StockQuery()).updateHidePickClick(true));

                                      setState(() {
                                        showOver=false;
                                        cartData.clear();
                                        ///(Get.put(StockQuery()).updateOrder(orderVal));
                                        (Get.put(StockQuery()).updateDeptOrder(0));
                                        inputDataDept.text="";

                                        // dataSearch.clear();

                                      });
                                      pickDefaultUser(true,true);




                                    }
                                    else{
                                      (Get.put(StockQuery()).updateHideLoader(true));
                                    }


                                  },
                                  child: const Text('Yes'),
                                ),
                                ElevatedButton(
                                  onPressed: () {
                                    Get.back(); // close the alert dialog
                                  },
                                  child: const Text('Close'),
                                ),
                              ],
                            ),
                          );

                        }

                    ),
                  ],
                ),
              Text("Total:${(Get.put(StockQuery()).orderSum)}"),
              Padding(
                padding: const EdgeInsets.fromLTRB(40,0,40,0),
                child: Container(
                  padding: const EdgeInsets.fromLTRB(5,0,5,0),
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(10.0),
                    border: Border.all(
                      color: Colors.grey, // You can customize the border color
                    ),
                  ),
                  child: Row(

                    children: [
                      InkWell(
                        onTap: () {
                          // Perform an action when the "Delete" button is tapped

                        },
                        child: Visibility(
                          visible: true,
                          child: Container(
                            padding: const EdgeInsets.all(10.0),
                            decoration: const BoxDecoration(
                              color: Colors.red,
                              borderRadius: BorderRadius.only(
                                //topLeft: Radius.circular(10.0),
                                //bottomLeft: Radius.circular(10.0),
                              ),
                            ),
                            child: Text(
                              'Debt ${(Get.put(StockQuery()).dept)}',
                              style: const TextStyle(color: Colors.white),
                            ),
                          ),
                        ),
                      ),
                      Expanded(
                        child: Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 8.0),
                          child: TextField(
                            keyboardType: TextInputType.number,
                            decoration: const InputDecoration(
                              hintText: 'Enter Amount...',
                              border: InputBorder.none,
                            ),
                            controller: inputDataDept,
                            onChanged: (value){
                              if((double.tryParse(value) != null)){
                                num deptVal=(Get.put(StockQuery()).orderSum)-num.parse(value);
                                setState(() {
                                  (Get.put(StockQuery()).updateDeptOrder(deptVal));
                                });

                              }




                            },
                          ),
                        ),
                      ),
                      InkWell(
                        onTap: () async{
                          // print("${inputDataDept.text} ${(Get.put(StockQuery())).orderSum } ${Get.put(StockQuery().order["resultData"][0]["uid"])}");

                          // Perform an action when the "Confirm" button is tapped
                          setState(() {

                            showOver=true;
                            // dataSearch.clear();


                          });

                          try {
                            var inputDataText=(inputDataDept.text=="")?"0":inputDataDept.text;

                            var resultData=(await StockQuery().submitOrder(Participated(uid:"Nyota_1672353378"
                                ,uidUser:"${(Get.put(StockQuery()).userProfile)["uid"]}",subscriber:"${(Get.put(StockQuery()).order["resultData"][0]["uid"])}",inputData:inputDataText),Promotions(
                                token:"${(Get.put(StockQuery())).orderSum }",reach:"1200",gain:"350",uid:"PointSales1"
                            ))).data;
                            if(resultData["status"])
                            {
                              //print(resultData);



                              num totalVal=0;

                              (Get.put(StockQuery()).updateSumOrder(totalVal));

                              setState(() {
                                showOver=false;
                                cartData.clear();
                                //(Get.put(StockQuery()).updateOrder(orderVal));
                                (Get.put(StockQuery()).updateDeptOrder(0));
                                inputDataDept.text="";

                                // dataSearch.clear();

                              });
                              (Get.put(StockQuery()).updateHidePickClick(true));
                              pickDefaultUser(true,true);
                            }
                            else{

                              setState(() {

                                showOver=false;



                              });
                            }
                          } catch (e) {
                            setState(() {

                              showOver=false;



                            });
                          }

                        },
                        child: Container(
                          padding: const EdgeInsets.all(10.0),
                          decoration: const BoxDecoration(
                            color: Colors.green,
                            borderRadius: BorderRadius.only(
                              topRight: Radius.circular(10.0),
                              bottomRight: Radius.circular(10.0),
                            ),
                          ),
                          child: const Text(
                            'Confirm',
                            style: TextStyle(color: Colors.white),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),

              Expanded(child: CheckoutPage(chekoutResult:cartData,changeQtyCheckout:(index,price,valueData,checkHide,thisQty){
                setState(() {
                  editQty=thisQty;
                });
                changeQtyMethod(index,price,valueData,checkHide);

              },saveChangeQtyCheckout:(productCode,indexData,currentEditQty){
                saveChangeQtyMethod(productCode,indexData,currentEditQty);
              },deleteCheckout:(productCode) async{


                try {

                  setState(() {
                    showOver=true;
                  });


                  var resultData=(await StockQuery().deleteTSingleOrder(QuickBonus(productName:productCode,uid:await (Get.put(StockQuery()).order)["resultData"][0]["uid"] ))).data;
                  if(resultData["status"])
                  {
                    //print(resultData);
                   /* List<dynamic> orderVal=[
                      {
                        "name":"Unknown",
                        "uid":""
                      }
                    ];*/
                    setState(() {
                      showOver=false;
                      setState(() {
                        cartData.removeWhere((item) => item['productCode'] == productCode);
                        num totalVal = cartData.fold(0, (previousValue, element) => previousValue + element['totalAmount']);
                        (Get.put(StockQuery()).updateSumOrder(totalVal));

                        //inputDataDept.text="${(Get.put(StockQuery()).dept)==0?'':(Get.put(StockQuery()).orderSum)-(Get.put(StockQuery()).dept)}";

                        if(cartData.isEmpty)
                        {
                          (Get.put(StockQuery()).updateHidePickClick(true));
                         // (Get.put(StockQuery()).updateOrder(orderVal));
                          pickDefaultUser(true,true);
                          (Get.put(StockQuery()).updateDeptOrder(0));
                          inputDataDept.text="";
                        }
                      });

                    });


                  }
                  else{

                    setState(() {

                      showOver=false;
                      dataSearch.clear();


                    });
                  }
                } catch (e) {
                  /* showDialog(
                   context: context,
                   builder: (context) => AlertDialog(
                     title: const Text("Error"),
                     content: Text(e.toString()),
                   ),
                 );*/

                }


              },addcomentCheckout:(productCode,commentData){
                addComment(productCode,commentData);
              })),

              // CheckoutPage(),




              Visibility(
                visible: true,
                child: Expanded(
                  flex: 0,
                  child: SingleChildScrollView(

                    child: Center(
                        child:Column(
                          children: [
                            (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),










                          ],
                        )

                    ),
                  ),
                ),
              ),
            ],
          ),
          if(showOver)
            Positioned.fill(
              child: Center(
                child: Container(
                  alignment: Alignment.center,
                  color: Colors.white70,
                  child: const CircularProgressIndicator(),
                ),
              ),
            ),

        ],
      ) ,
      bottomNavigationBar:const HomeNavigator(),

      // This trailing comma makes auto-formatting nicer for build methods.

    );

  }


  void _onQRViewCreated(QRViewController controller)
  {
    this.controller=controller;
    controller.resumeCamera();
    controller.scannedDataStream.listen((scanData) async{
      setState((){
        result=scanData;
      });
      //await scanMethod();
      //print("${result!.code}");
      if(result!=null)
      {
        // controller!.pauseCamera();

        bool containsProductCode = qrSearch.any((item) => item['productCode'] == result!.code);
        if(containsProductCode)
        {
          //data already scaned
          //print("already exist");
          // print("${(Get.put(StockQuery()).dataSearch).toString()}");
        }
        else{
          var listData={
            "productCode":result!.code
          };
          qrSearch.insertAll(0,[listData]);
          //print(qrSearch);
          searchQr(result!.code);


        }
        //
      }
    });
  }
  searchQr(result) async{
    // await performSearch("$result","gh");
    await performSearch("$result","gh");
  }

  void _onUserQRViewCreated(QRViewController controller)
  {
    this.controller=controller;
    // Start scanning when the bottom sheet is opened
    controller.resumeCamera();
    controller.scannedDataStream.listen((scanData) async{
      setState((){
        result=scanData;
      });
      //await scanMethod();

      bool containsProductCode = qrSearch.any((item) => item['productCode'] == result!.code);
      if(containsProductCode)
      {
        //data already scaned
        //print("already exist");
        // print("${(Get.put(StockQuery()).dataSearch).toString()}");
      }
      else{
        var listData={
          "productCode":result!.code
        };
        qrSearch.insertAll(0,[listData]);
        //print(qrSearch);
        getCardDetail(result!.code);


      }

    });
  }
  getCardDetail(resultCode) async{
    (Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await CardQuery().getDetailCardOnline(CardModel(uid:"$resultCode"))).data;
    if(resultData["status"])
    {
      if (controller!= null) {
        controller!.pauseCamera();
        //controller!.stopCamera();
        try {
          (Get.put(StockQuery()).updateHideLoader(true));
          setState(() {
            (Get.put(StockQuery()).updateUserProfile(resultData["UserDetail"]));
            (Get.put(StockQuery()).order)["resultData"][0]["name"]=resultData["UserDetail"]["name"];
          });
        } finally {
          // Pop the route in the next microtask
          Future.microtask(() {
            Navigator.of(context).pop();
          });
        }
        //Get.close(1);

      }

      //print("result ${resultData["UserDetail"]}");


    }
    else{
      // controller!.stopCamera();
      if (controller!= null) {
        controller!.pauseCamera();
        try {
          (Get.put(StockQuery()).updateHideLoader(true));
          var userProfile =
          {
            "uid": "kebineericMuna_1674160265",
            "name": "unknown",

            "email": "on@gmail.com",
            "phone": "782389359",
            "Ccode": "+250",
            "country": "Rwanda",
            "initCountry": "none",
            "PhoneNumber": "+250782389359",
            "carduid": "TEALTD_7hEnj_1672352175"
          }
          ;
          setState(() {
            (Get.put(StockQuery()).updateUserProfile(userProfile));
            (Get
                .put(StockQuery())
                .order)["resultData"][0]["name"] = userProfile["name"];
          });
          // print("${(Get.put(StockQuery()).userProfile)}");
        } finally {
          // Pop the route in the next microtask
          Future.microtask(() {
            Navigator.of(context).pop();
          });
        }
        //Get.close(1);
      }
    }
    //

  }

  @override
  void dispose(){
    controller?.dispose();
    super.dispose();
  }
  Widget cameraSwitch()=>Transform.scale(
    scale: 1,
    child: Switch.adaptive(
        activeColor: Colors.red,
        activeTrackColor: Colors.red.withOpacity(0.4),
        inactiveThumbColor: Colors.orange,
        inactiveTrackColor: Colors.blueAccent,

        value: cameraValue,
        onChanged:(value)async{
          setState((){
            cameraValue=value;

            //print(value);
          });
          await controller!.resumeCamera();
        }
    ),
  );
  Widget flashSwitch()=>Transform.scale(
    scale: 1,
    child: Switch.adaptive(
        activeColor: Colors.red,
        activeTrackColor: Colors.red.withOpacity(0.4),
        inactiveThumbColor: Colors.orange,
        inactiveTrackColor: Colors.blueAccent,

        value:flashValue,
        onChanged:(value)async{
          setState((){
            flashValue=value;

            //print(value);
          });
          await controller!.toggleFlash();
        }
    ),
  );

  @override
  void initState()
  {
    super.initState();
    //getapi();
    cartDisplay();
    setState(() {
      showOver=false;
    });
  }

//Method

  cartDisplay()async
  {
    /*setState(() {
      (Get.put(StockQuery()).updateDeptOrder(0));
      inputDataDept.text="";

      cartData.clear();


    });*/


    try {

      var resultData=(await StockQuery().viewUserTempOrder(QuickBonus(uid:"nyota"))).data;
      if(resultData["status"])
      {



        num totalVal = resultData["result"].fold(0, (previousValue, element) {
          // Convert 'totalAmount' to a num using double.parse
          num totalAmount = num.parse(element['totalAmount'].toString());

          // Add the converted totalAmount to previousValue
          return previousValue + totalAmount;
        });

        (Get.put(StockQuery()).updateSumOrder(totalVal));
        var userProfile =
        {
          "uid": "${resultData["result"][0]["userid"]}",
          "name": "${resultData["result"][0]["name"]}",

          "email": "on@gmail.com",
          "phone": "782389359",
          "Ccode": "+250",
          "country": "Rwanda",
          "initCountry": "none",
          "PhoneNumber": "none",
          "carduid": "TEALTD_7hEnj_1672352175"
        };

        (Get.put(StockQuery()).updateUserProfile(userProfile));



        (Get.put(StockQuery()).updateOrder(resultData["result"]));
        String permission=(resultData["result"][0])["permission"];
        (permission=="false")?(Get.put(StockQuery()).updateHidePickClick(false)):(Get.put(StockQuery()).updateHidePickClick(true));//hidePick false is hide and true show
        num alldept=num.parse((resultData["result"][0])["orderDebt"]);
        num inputAll=(Get.put(StockQuery()).orderSum)-alldept;
        num inputDebtAll=(alldept==0)?alldept:inputAll;
        (Get.put(StockQuery()).updateDeptOrder(alldept));

        inputDataDept.text="${(inputDebtAll==0)?"":inputDebtAll}";
        setState(() {

          cartData.clear();

          cartData.addAll(resultData["result"]);
        });
      }
      else{
        setState(() {


          cartData.clear();


        });
      }


    } catch (e) {
      /* showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text("Error"),
          content: Text(e.toString()),
        ),
      );*/
    }




  }

  performSearch(String text,String statusSearch) async{


    try {
      bool searchHide=(statusSearch=='none')?true:false;//to check if is Qr search or no Qr
      var resultData=(await StockQuery().product(QuickBonus(uid:"none",productName:text,status:statusSearch),Topups(optionCase:"searchProductStock",startlimit:1,endlimit:10))).data;
      if(resultData["status"])
      {

        setState(() {
          productSearch=searchHide;

          //(Get.put(StockQuery()).updateTextMessage("$text Added Successfully"));
          (Get.put(StockQuery()).updateHideProductList(false));
          dataSearch.clear();

          dataSearch.addAll(resultData["result"]);
          (Get.put(StockQuery()).updatedataSearch(dataSearch));
        });
        //print("hello ${Get.put(StockQuery().dataSearch)}");
      }
      else{
        setState(() {


          dataSearch.clear();
          (Get.put(StockQuery()).updatedataSearch(dataSearch));


        });
      }


    } catch (e) {
     /* showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text("Error"),
          content: Text(e.toString()),
        ),
      );*/
    }



  }
  void changeQtyMethod(indexData,price,valueData,checkHide) {

    if(checkHide)
    {
      setState(() {
        cartData[indexData]["saveChangeBtn"]=false;

      });
    }
    else{

      setState(() {
        cartData[indexData]["saveChangeBtn"]=true;
        cartData[indexData]["totalAmount"]=price*valueData;
        cartData[indexData]["totalQty"]=valueData;

        //(Get.put(StockQuery()).updateSumOrder(totalVal));
      });

    }






  }
  addComment(productCode,commentDes) async{
    commentData.text=commentDes;
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
            Stack(
              children: [
                Container(
                  padding:const EdgeInsets.all(2.0),
                  height: 320,
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(30),
                      topRight: Radius.circular(30),
                    ),
                  ),
                  child: SingleChildScrollView(
                    child: Column(
                      children: [

                        // (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),

                        GetBuilder<StockQuery>(
                          builder: (controller) {
                            //return Text('Data: ${_controller.data}');
                            return Column(
                              children: [
                                Padding(
                                  padding:const EdgeInsets.fromLTRB(8,5,8,0),
                                  child: Card(
                                    elevation:0,
                                    margin: const EdgeInsets.symmetric(vertical:1,horizontal:5),
                                    //color:Colors.white,
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(15.0),
                                      //side: BorderSide(color:_data[0]["color_var"]??true?Colors.white:Colors.green, width: 2),
                                    ),

                                    child: ListTile(
                                        leading: CircleAvatar(
                                          backgroundColor:getRandomColor(),
                                          child: Icon(_getRandomIcon()),
                                        ),
                                        title:Row(
                                          children: [


                                            Expanded(
                                              flex: 1,
                                              child: Stack(
                                                children: [

                                                  Column(
                                                    children: [

                                                      Center(
                                                        child: RichText(
                                                          text: TextSpan(
                                                            text: "${(Get.put(StockQuery()).clientDebt)["name"]}",
                                                            style: DefaultTextStyle.of(context).style,
                                                            children: const <TextSpan>[


                                                            ],
                                                          ),
                                                        ),
                                                      ),
                                                    ],
                                                  ),


                                                ],
                                              ),
                                            ),
                                          ],
                                        ),

                                        subtitle: Row(
                                          mainAxisAlignment: MainAxisAlignment.center,
                                          children: [
                                            Column(

                                              children: [
                                                Wrap(
                                                  crossAxisAlignment: WrapCrossAlignment.center,
                                                  children: [

                                                    Text("$productCode",style:GoogleFonts.odorMeanChey(fontSize:16,color: Colors.green,fontWeight: FontWeight.w700)),


                                                  ],
                                                ),









                                              ],
                                            ),

                                          ],
                                        ),
                                        trailing:GestureDetector(
                                            onTap: () async{

                                              // getDebtWidget();

                                            },
                                            child:const Icon(Icons.grid_view,color:Colors.orange)
                                        )

                                      //trailing: Text()
                                    ),
                                  ),
                                ),

                              ],
                            );
                          },
                        ),
                        if((Get.put(StockQuery()).paidDeptScanHide))
                          Container(


                            padding:const EdgeInsets.fromLTRB(5,0,10,0),


                            decoration: const BoxDecoration(
                              color: Colors.white,
                              borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(30),
                                topRight: Radius.circular(30),
                              ),
                            ),
                            child: SingleChildScrollView(
                              child: Column(
                                children: [
                                  const SizedBox(height: 5.0,),




                                  const SizedBox(height: 10.0,),
                                  TextField(

                                    controller:commentData,
                                    keyboardType: TextInputType.multiline,
                                    maxLines: null,
                                    //obscureText: true,
                                    decoration: const InputDecoration(
                                      contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                      border: OutlineInputBorder(),
                                      labelText: 'Comment',
                                      hintText: 'Comment',
                                      hintStyle: TextStyle(
                                        color: Colors.grey,
                                      ),

                                    ),
                                  ),

                                  const SizedBox(height: 5.0,),

                                  FloatingActionButton.extended(
                                      label: const Text('AddComment'), // <-- Text
                                      backgroundColor: Colors.black,
                                      icon: const Icon( // <-- Icon
                                        Icons.thumb_up,
                                        size: 24.0,
                                      ),
                                      onPressed: () =>{
                                        //paidDebt()
                                        //addSpendingMethod(),
                                        addCommentMethod(productCode),

                                      }),
                                ],
                              ),
                            ),
                          ),

                        const SizedBox(height:2.0,),
                        //if(!(Get.put(StockQuery()).paidDeptScanHide))





                      ],
                    ),
                  ),
                ),
                GetBuilder<StockQuery>(
                  builder: (myLoadercontroller) {
                    //return Text('Data: ${_controller.data}');
                    return
                      (myLoadercontroller.hideLoader)?
                      const Text(""):
                      Positioned.fill(
                        child: Center(
                          child: Container(
                            alignment: Alignment.center,
                            color: Colors.white70,
                            child: const CircularProgressIndicator(),
                          ),
                        ),
                      );
                  },
                ),

              ],
            );

        },
      ),
    ).whenComplete(() {

    });

  }
  addCommentMethod(productCode) async {
    (Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await StockQuery().updateInOrder(QuickBonus(uid:"${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}",productName:productCode,description:commentData.text,status:"CommentInOrder"),Participated(uidUser:"newUser",status:"notUpdate"))).data;
    if(resultData["status"])
    {
      cartDisplay();
      (Get.put(StockQuery()).updateHideLoader(true));
      Future.microtask(() {
        Navigator.of(context).pop();
      });





    }
    else{
      (Get.put(StockQuery()).updateHideLoader(true));
      Future.microtask(() {
        Navigator.of(context).pop();
      });
    }
    //
  }

  void saveChangeQtyMethod(productCode,indexData,currentEditQty) async{

    //print("inputqty:${(cartData[indexData]["totalQty"])} ,currentQty:${currentEditQty}  normalQty:${editQty}");


    //print("inputqty:${(cartData[indexData]["totalQty"]).runtimeType} ,currentQty:${currentEditQty.runtimeType}  normalQty:${editQty.runtimeType}");

    try {
      setState(() {
        showOver=true;
      });

      String qtyData=(cartData[indexData]["totalQty"]).toString().replaceAll(' ', '');
      var resultData=(await StockQuery().editTOrder(QuickBonus(productName:"$productCode",reqQty:int.parse(qtyData),currentQtyEdit:editQty,uid:(Get.put(StockQuery()).order)["resultData"][0]["uid"]), User(uid:"${(Get.put(StockQuery()).userProfile)["uid"]}")));

      if(resultData["status"])
      {

        setState(() {

          showOver=false;


          cartData[indexData]["saveChangeBtn"]=true;

          num totalVal = cartData.fold(0, (previousValue, element) => previousValue + element['totalAmount']);

          (Get.put(StockQuery()).updateSumOrder(totalVal));




        });


      }
      else{

        setState(() {

          showOver=false;
          dataSearch.clear();
          (Get.put(StockQuery()).updatedataSearch(dataSearch));



        });
      }
    } catch (e) {
      setState(() {
        showOver=false;
      });
      /*showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('error'),
          content: Text(e.toString()),
        ),
      );*/
    }




  }

  void addCartPlus(dynamic dynamicData) async{
    if((Get.put(StockQuery()).userProfile)["uid"]=="none")
    {
      Get.dialog(
        AlertDialog(
          title: const Text('No Client Selected'),
          content: const Text('Please Choose Client By?'),
          actions: [
            ElevatedButton(
              style: ElevatedButton.styleFrom(

                //primary: Colors.grey[300],
                backgroundColor: Colors.red,
                elevation:0,
              ),
              onPressed: () async{
                pickDefaultUser(false,true);
                if((Get.put(StockQuery()).userProfile)["uid"]!='none')
                {
                  placeOrder(dynamicData);
                  //Get.back();
                }


              },
              child: const Text('Default'),
            ),

            ElevatedButton(
              onPressed: () {
                Get.back(); // close the alert dialog
              },
              child: const Text('close'),
            ),
          ],
        ),
      );
    }
    else{
      placeOrder(dynamicData);
    }





  }
  pickDefaultUser(resetOrder,isOrderNotExist) async{

    (Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await StockQuery().searchUser(User(uid:"",name:"anyName",phone:"any",platform:"4000",status:"Default"),Topups(optionCase:"false",startlimit:1,searchOption:false))).data;

    if(resultData["status"])
    {

      (Get.put(StockQuery()).updateHideLoader(true));

      if(resultData["result"]!=0)
      {

        (Get.put(StockQuery()).updateHideLoader(true));
        var userProfile =
        {
          "uid": "${resultData["result"][0]["uid"]}",
          "name": "${resultData["result"][0]["name"]}",

          "email": "on@gmail.com",
          "phone": "782389359",
          "Ccode": "+250",
          "country": "Rwanda",
          "initCountry": "none",
          "PhoneNumber": "none",
          "carduid": "TEALTD_7hEnj_1672352175"
        };

       


  if(isOrderNotExist==true){
    (Get.put(StockQuery()).updateUserProfile(userProfile));
    List<dynamic> orderVal=[
      {
        "name":"${resultData["result"][0]["name"]}",
        "uid":"${(resetOrder==true)?'none':(Get.put(StockQuery()).order)["resultData"][0]["uid"]}"
      }
    ];
    setState(() {
      (Get.put(StockQuery()).updateOrder(orderVal));
    });
  }else{
    changeUserInOrder(resultData["result"][0]["uid"],resultData["result"][0]["name"],"0789");
  }




      }
      else{
        setState(() {




        });
      }




    }
    else{
      (Get.put(StockQuery()).updateHideLoader(true));

      setState(() {

        users.clear();


      });
    }
  }

  changeUserInOrder(uidUser,name,phoneNumber)async{
    var resultData=(await StockQuery().updateInOrder(QuickBonus(uid:"${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}",productName:"productCode",description:"comment",status:"UpdateUserInOrder"),Participated(uidUser:"$uidUser",status:'Default'))).data;
    if(resultData["status"]) {
      var userProfile =
      {
        "uid": "$uidUser",
        "name": "$name",

        "email": "on@gmail.com",
        "phone": "782389359",
        "Ccode": "+250",
        "country": "Rwanda",
        "initCountry": "none",
        "PhoneNumber": "$phoneNumber",
        "carduid": "TEALTD_7hEnj_1672352175"
      };
      setState(() {
        (Get.put(StockQuery()).updateUserProfile(userProfile));
        (Get
            .put(StockQuery())
            .order)["resultData"][0]["name"] = userProfile["name"];
      });
    }

  }
  placeOrder(dynamicData) async{
    (Get.put(StockQuery()).updateHideLoader(false));
    bool containsProductCode = cartData.any((item) => item['productCode'] == dynamicData["productCode"]);

    if(containsProductCode)
    {
      (Get.put(StockQuery()).updateHideLoader(true));
      (Get.put(StockQuery()).updateTextMessage("${dynamicData['ProductName']} Product already Added"));
      (Get.put(StockQuery()).updateHideProductList(true));


    }
    else{
      // print(containsProductCode);


      setState(() {

        showOver=true;

        // productSearchPopup=false;
        // dataSearch.clear();


      });

      try {
        dynamicData["totalQty"]=((num.parse(dynamicData["req_qty"]))>1)?dynamicData["totalQty"]:1;
        dynamicData['totalAmount']=((num.parse(dynamicData["req_qty"]))>1)?dynamicData['totalAmount']:num.parse(dynamicData['price']);
        dynamicData['totalCount']=((num.parse(dynamicData["req_qty"]))>1)?dynamicData['totalQty']:1;
        num totalVal=((num.parse(dynamicData["req_qty"]))>1)?dynamicData["totalAmount"]+((Get.put(StockQuery()).orderSum)):(num.parse(dynamicData["price"]))+((Get.put(StockQuery()).orderSum));


        //print("${dynamicData["req_qty"]}");
        var resultData=(await StockQuery().placeOrder(QuickBonus(uid:dynamicData["productCode"],reqQty:int.parse(dynamicData["req_qty"]),subscriber:"${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}"),User(uid:"${(Get.put(StockQuery()).userProfile)["uid"]}"))).data;
        if(resultData["status"])
        {


          // print(cartData.length);

//here i must Add no assign Card Then Unknown else Card ClientName
          List<dynamic> orderVal=[
            {
              "name":"${(Get.put(StockQuery()).userProfile)["name"]}",
              "uid":resultData["OrderId"]
            }
          ];


          //print(resultData);
          setState(() {
            showOver=false;

            (Get.put(StockQuery()).updateOrder(orderVal));
            (Get.put(StockQuery()).updateSumOrder(totalVal));


            cartData.insertAll(0,[dynamicData]);

            dataSearch.clear();
            //(Get.put(StockQuery()).updatedataSearch(dataSearch));

            (Get.put(StockQuery()).updateTextMessage("${dynamicData['ProductName']} Added Successfully"));
            (Get.put(StockQuery()).updateHideProductList(true));
            (Get.put(StockQuery()).updateHideLoader(true));

          });


        }
        else{

          setState(() {

            showOver=false;
            dataSearch.clear();
            (Get.put(StockQuery()).updatedataSearch(dataSearch));

            (Get.put(StockQuery()).updateHideLoader(true));


          });
        }
      } catch (e) {
        /* showDialog(
         context: context,
         builder: (context) => AlertDialog(
           title: const Text("Error"),
           content: Text(e.toString()),
         ),
       );*/
      }



    }




  }
  searchUserMethod() async{

  }
  void searchUser(BuildContext context) {
    showModalBottomSheet(
      context: context,
      builder: (BuildContext context) {
        return Stack(children: [
          Container(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Visibility(
                  visible: false,
                  child: Container(
                    padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
                    child:  IntlPhoneField(
                      initialCountryCode: 'CD',
                      controller: uidInput,
                      autofocus: true,

                      decoration: InputDecoration(
                        labelText: 'Phone Number',
                        border: const OutlineInputBorder(
                          borderSide: BorderSide(),
                        ),
                        suffixIcon: isValid?const Icon(Icons.done,color:Colors.green,):const Icon(Icons.dangerous,color:Colors.red,),

                      ),


                      onChanged: (phone) async{

                        if((uidInput.text).isPhoneNumber)
                        {
                          phoneNumber=phone.number;

                          getUserData();



                        }
                        else{
                          setState(() {
                            isValid=false;

                          });
                        }


                        //uidInput4.text=phone.countryCode;
                        //uidInput2.text=phone.number;
                        // uidInput2.text=phone.countryISOCode;
                        //print(phone.completeNumber);



                      },

                      onCountryChanged: (country) {

                        uidInput4.text="+${country.dialCode}";
                        uidInput5.text=country.name;
                        initCountry.text=country.code;

                        if((uidInput.text).isPhoneNumber)
                        {

                          phoneNumber=uidInput.text;
                          getUserData();


                        }
                        else{
                          setState(() {
                            isValid=false;

                          });
                        }
                        // print('Country changed to: ' + country.name);
                        // print('Country changed to: ' + country.dialCode);
                      },
                    ),
                  ),
                ),
                Container(
                  height: 55,
                  //padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                  margin: const EdgeInsets.fromLTRB(10, 20, 10, 10),
                  child: TextField(

                    decoration: InputDecoration(
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(50.0),
                      ),
                      labelText: 'Search',
                    ),
                    onChanged: (text) async{

                      if(phoneNumber=='none')
                      {
                        setState(() {
                          searchValOption=true;
                          searchName=text;
                        });
                        if(searchValOption)
                        {
                          getUserData();
                        }
                      }
                      else{
                        setState(() {
                          searchValOption=true;
                          phoneNumber=text;
                        });
                        if(searchValOption)
                        {
                          getUserData();
                        }
                      }



                      //print(this._data[index]["total_var"]);
                      // print("Text changed to: $text");
                    },
                  ),
                ),
                Expanded(
                  child: ListView.separated(
                    itemCount: users.length+1,
                    separatorBuilder: (context, index) => const Divider(height: 1.0),
                    itemBuilder: (context, index) {
                      if(index<users.length)
                      {
                        return Card(
                          margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
                          child: ListTile(
                            leading: CircleAvatar(
                              backgroundColor:getRandomColor(),
                              child: Icon(_getRandomIcon()),

                              //backgroundImage: NetworkImage(users[index].photo_url):

                            ),
                            title: Text(users[index]["name"]),
                            subtitle: Text(users[index]["PhoneNumber"]),
                            trailing:  IconButton(
                              icon: const Icon(Icons.add),
                              iconSize: 23.0,
                              color: Colors.blue,
                              onPressed: () async{

                                (Get.put(StockQuery()).updateHideLoader(false));
                                if(((Get.put(StockQuery()).order)["resultData"][0]["uid"])=="none")
                                {
                                  var userProfile =
                                  {
                                    "uid":"${users[index]["uid"]}",
                                    "name":"${ users[index]["name"]}",

                                    "email": "on@gmail.com",
                                    "phone": "782389359",
                                    "Ccode": "+250",
                                    "country": "Rwanda",
                                    "initCountry": "none",
                                    "PhoneNumber":"${users[index]["PhoneNumber"]}",
                                    "carduid": "TEALTD_7hEnj_1672352175"
                                  };
                                  setState(() {
                                    (Get.put(StockQuery()).updateUserProfile(userProfile));
                                    (Get
                                        .put(StockQuery())
                                        .order)["resultData"][0]["name"] = userProfile["name"];
                                  });
                                  Future.microtask(() {
                                    Navigator.of(context).pop();
                                  });
                                }
                                else{

                                  var resultData=(await StockQuery().updateInOrder(QuickBonus(uid:"${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}",productName:"productCode",description:"comment",status:"UpdateUserInOrder"),Participated(uidUser:"${users[index]["uid"]}",status:'Default'))).data;
                                  if(resultData["status"])
                                  {
                                    var userProfile =
                                    {
                                      "uid":"${users[index]["uid"]}",
                                      "name":"${ users[index]["name"]}",

                                      "email": "on@gmail.com",
                                      "phone": "782389359",
                                      "Ccode": "+250",
                                      "country": "Rwanda",
                                      "initCountry": "none",
                                      "PhoneNumber":"${users[index]["PhoneNumber"]}",
                                      "carduid": "TEALTD_7hEnj_1672352175"
                                    };
                                    setState(() {
                                      (Get.put(StockQuery()).updateUserProfile(userProfile));
                                      (Get
                                          .put(StockQuery())
                                          .order)["resultData"][0]["name"] = userProfile["name"];
                                    });
                                    Future.microtask(() {
                                      Navigator.of(context).pop();
                                    });

                                  }
                                  else{

                                  }
                                }



                              },
                            ), // Add an icon on the trailing side
                          ),
                        );
                      }
                      else{
                        return Container();
                      }

                    },
                  ),
                ),
              ],
            ),
          ),
          GetBuilder<StockQuery>(
            builder: (myLoadercontroller) {
              //return Text('Data: ${_controller.data}');
              return
                (myLoadercontroller.hideLoader)?
                const Text(""):
                Positioned.fill(
                  child: Center(
                    child: Container(
                      alignment: Alignment.center,
                      color: Colors.white70,
                      child: const CircularProgressIndicator(),
                    ),
                  ),
                );
            },
          ),
        ],);
      },
    ).then((value) {
      // This callback will be executed when the BottomSheet is closed

    });
  }
  getUserData() async{

    (Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await StockQuery().searchUser(User(uid:"",name:searchName,phone:phoneNumber,platform:"4000",status:"offNotPick"),Topups(optionCase:"false",startlimit:limitData,searchOption:searchValOption))).data;

    if(resultData["status"])
    {

      (Get.put(StockQuery()).updateHideLoader(true));

      if(resultData["result"]!=0)
      {

        setState(() {

          users.clear();
          users.addAll(resultData["result"]);

        });
      }
      else{
        setState(() {

          users.clear();


        });
      }




    }
    else{
      (Get.put(StockQuery()).updateHideLoader(true));

      setState(() {

        users.clear();


      });
    }
  }
  void searchNumber() async{

    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
            Stack(
              children: [
                Container(
                  padding:const EdgeInsets.all(5.0),
                  height: 600,
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(30),
                      topRight: Radius.circular(30),
                    ),
                  ),
                  child: Column(
                    children: [

                      // (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),
                      const Center(child:Text("Search Number")),

                      Expanded(
                          flex:2,
                          child:ListView(
                            children: [

                              Container(
                                padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
                                child:  IntlPhoneField(
                                  initialCountryCode: 'CD',
                                  controller: uidInput,
                                  autofocus: true,

                                  decoration: InputDecoration(
                                    labelText: 'Phone Number',
                                    border: const OutlineInputBorder(
                                      borderSide: BorderSide(),
                                    ),
                                    suffixIcon: isValid?const Icon(Icons.done,color:Colors.green,):const Icon(Icons.dangerous,color:Colors.red,),

                                  ),


                                  onChanged: (phone) async{




                                    //uidInput4.text=phone.countryCode;
                                    //uidInput2.text=phone.number;
                                    // uidInput2.text=phone.countryISOCode;
                                    //print(phone.completeNumber);



                                  },

                                  onCountryChanged: (country) {

                                    // print('Country changed to: ' + country.name);
                                    // print('Country changed to: ' + country.dialCode);
                                  },
                                ),
                              ),




                              Visibility(
                                visible:false,
                                child: TextField(
                                  controller: uidInput4,
                                  //obscureText: true,
                                  decoration: const InputDecoration(
                                    contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                    border: OutlineInputBorder(),
                                    labelText: 'Ccode',
                                    hintText: 'Ccode',
                                    hintStyle: TextStyle(
                                      color: Colors.grey,
                                    ),

                                  ),
                                ),
                              ),
                              Visibility(
                                visible: false,
                                child: TextField(
                                  controller: uidInput5,
                                  //obscureText: true,
                                  decoration: const InputDecoration(
                                    contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                    border: OutlineInputBorder(),
                                    labelText: 'Country',
                                    hintText: 'Enter Country',
                                    hintStyle: TextStyle(
                                      color: Colors.grey,
                                    ),

                                  ),
                                ),
                              ),



                              //Qr Show

                              //Qr Show



                            ],
                          )

                      ),




                    ],
                  ),
                ),
                GetBuilder<StockQuery>(
                  builder: (myLoadercontroller) {
                    //return Text('Data: ${_controller.data}');
                    return
                      (myLoadercontroller.hideLoader)?
                      const Text(""):
                      Positioned.fill(
                        child: Center(
                          child: Container(
                            alignment: Alignment.center,
                            color: Colors.white70,
                            child: const CircularProgressIndicator(),
                          ),
                        ),
                      );
                  },
                ),

              ],
            );

        },
      ),
    ).whenComplete(() {
      qrSearch.clear();
    });

  }

  void scanProduct() async{

    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
            Stack(
              children: [
                Container(
                  padding:const EdgeInsets.all(5.0),
                  height: 600,
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(30),
                      topRight: Radius.circular(30),
                    ),
                  ),
                  child: Column(
                    children: [

                      // (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),
                      const Center(child: Text("Text")),
                      GetBuilder<StockQuery>(
                        builder: (myController) {
                          //return Text('Data: ${(_controller.dataSearch).toString()}');

                          return
                            (myController.hideProductList)?
                            Text(myController.textMessage):
                            Expanded(
                              child:ProductSearchList(addCartMethod:(dynamicData){
                                setState(() {
                                  productSearch=true;
                                });

                                addCartPlus(dynamicData);

                              },searchResult:(Get.put(StockQuery()).dataSearch)),
                            );


                        },
                      ),
                      //if(productSearchPopup)
                      const SizedBox(height: 20,),
                      Expanded(
                          flex: 5,
                          child:Stack(
                            alignment:Alignment.bottomCenter,
                            children: [
                              QRView(key: qrKey,onQRViewCreated: _onQRViewCreated,
                                overlay: QrScannerOverlayShape(
                                  borderColor: Colors.yellow,
                                  borderRadius: 10,
                                  borderLength: 30,
                                  borderWidth: 10,
                                  cutOutSize: 300,
                                  // Add the laser effect

                                ),

                              ),

                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [

                                      cameraSwitch(),
                                      //SizedBox(width: 10.0,),

                                      // SizedBox(width: 10.0,),
                                      flashSwitch(),
                                      Image.asset(
                                        flashValue ? 'images/on.png' : 'images/off.png',
                                        height: 30,
                                      ),
                                    ],
                                  ),
                                ],
                              ),

                            ],
                          )

                      )




                    ],
                  ),
                ),
                GetBuilder<StockQuery>(
                  builder: (myLoadercontroller) {
                    //return Text('Data: ${_controller.data}');
                    return
                      (myLoadercontroller.hideLoader)?
                      const Text(""):
                      Positioned.fill(
                        child: Center(
                          child: Container(
                            alignment: Alignment.center,
                            color: Colors.white70,
                            child: const CircularProgressIndicator(),
                          ),
                        ),
                      );
                  },
                ),

              ],
            );

        },
      ),
    ).whenComplete(() {
      qrSearch.clear();
    });

  }

  void scanUser() async{//not finished User


    Get.bottomSheet(

      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
            Stack(
              key:userBottomSheetKey,
              children: [
                Container(

                  padding:const EdgeInsets.all(5.0),

                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(30),
                      topRight: Radius.circular(30),
                    ),
                  ),
                  child: Column(
                    children: [

                      const SizedBox(height: 20,),
                      Expanded(
                          flex: 5,
                          child:Stack(
                            alignment:Alignment.bottomCenter,
                            children: [
                              QRView(key: qrKey,
                                onQRViewCreated:
                                _onUserQRViewCreated,
                                overlay: QrScannerOverlayShape(
                                  borderColor: Colors.white,
                                  borderRadius: 10,
                                  borderLength: 30,
                                  borderWidth: 10,
                                  cutOutSize: 300,
                                  // Add the laser effect

                                ),
                              ),


                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [

                                      cameraSwitch(),
                                      //SizedBox(width: 10.0,),

                                      // SizedBox(width: 10.0,),
                                      flashSwitch(),
                                      Image.asset(
                                        flashValue ? 'images/on.png' : 'images/off.png',
                                        height: 30,
                                      ),
                                    ],
                                  ),
                                ],
                              ),

                            ],
                          )

                      )




                    ],
                  ),
                ),
                GetBuilder<StockQuery>(
                  builder: (myLoadercontroller) {
                    //return Text('Data: ${_controller.data}');
                    return
                      (myLoadercontroller.hideLoader)?
                      const Text(""):
                      Positioned.fill(
                        child: Center(
                          child: Container(
                            alignment: Alignment.center,
                            color: Colors.white70,
                            child: const CircularProgressIndicator(),
                          ),
                        ),
                      );
                  },
                ),

              ],
            );

        },
      ),
    ).whenComplete(() {
      qrSearch.clear();
    });

  }
//method
}

Color getRandomColor() {
  Random random = Random();
  return Color.fromARGB(
    255,
    random.nextInt(256),
    random.nextInt(256),
    random.nextInt(256),
  );
}
IconData _getRandomIcon() {
  Random random = Random();
  List<IconData> icons = [Icons.favorite,Icons.star,Icons.thumb_up,Icons.access_time,Icons.access_time,Icons.fastfood,Icons.directions_bike,      Icons.directions_walk,      Icons.directions_car,      Icons.directions_boat,      Icons.airplanemode_active,      Icons.airport_shuttle,      Icons.beach_access,      Icons.camera,      Icons.movie,      Icons.music_note,      Icons.spa,      Icons.palette,      Icons.account_balance,      Icons.attach_money,    ];
  return icons[random.nextInt(icons.length)];
}

class SearchBarField extends StatelessWidget {

  /*const SearchBarField({
    Key? key,
    required this.search,
    required this.searchController,
    required this.PerformSearch,
  }) : super(key: key);

  final dynamic search;
  final TextEditingController searchController;
  final VoidCallback PerformSearch;*/

  const SearchBarField({
    Key? key,
    required this.searchMethod,
    required this.scanProductMethod,
    required this.searchController,
  }) : super(key: key);

  final void Function(String) searchMethod;
  final void Function() scanProductMethod;
  final TextEditingController searchController;


  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.fromLTRB(5, 20, 5, 0),
      child: TextField(
        controller: searchController,
        decoration: InputDecoration(
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(50.0),
          ),
          labelText: 'Search',

          suffixIcon: IconButton(
            icon: const Icon(Icons.camera_alt),
            onPressed: () async {
              try {


                /*var resultData=(await StockQuery().viewUserTempOrder(QuickBonus(uid:"nyota"))).data;
                print(resultData);*/
                scanProductMethod();


              } catch (e) {
                /* showDialog(
                  context: context,
                  builder: (context) => AlertDialog(
                    title: const Text("Error"),
                    content: Text(e.toString()),
                  ),
                );*/

              }
              // Handle scan button press
              // You can navigate to a scan screen or perform a scan action here
            },
          ),
        ),
        onChanged: (text) async{

          searchMethod(text);



        },
      ),
    );
  }
}

class ProductSearchList extends StatelessWidget {
  const ProductSearchList({
    Key? key,
    required this.addCartMethod,
    required this.searchResult,
  }) : super(key: key);
  final void Function(dynamic) addCartMethod;
  final dynamic searchResult;
  @override

  Widget build(BuildContext context) {

    return ListView.builder(


      itemCount: searchResult.length+1,
      itemBuilder: (context, index) {

        if(index<searchResult.length)
        {
          searchResult[index]['req_qty']="1";
          searchResult[index]['name']="none";




          return Container(
            margin: const EdgeInsets.fromLTRB(0, 5, 0, 0),
            child: Card(
              elevation:0,
              //margin: EdgeInsets.symmetric(vertical:1,horizontal:5),
              //color:Colors.white,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(9.0),
                // side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
              ),

              child: Column(
                children: [
                  ListTile(
                      leading: CircleAvatar(
                        backgroundColor:getRandomColor(),
                        child: Icon(_getRandomIcon()),
                      ),
                      title:Row(
                        children: [
                          Expanded(

                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [

                                RichText(
                                  text: TextSpan(
                                    text:"${searchResult[index]["productCode"]} (${searchResult[index]["pcs"]} pcs):",
                                    style: DefaultTextStyle.of(context).style,
                                    children: <TextSpan>[
                                      TextSpan(
                                        text: " 1X${searchResult[index]["price"]}",
                                        style: const TextStyle(color: Colors.blue),


                                      ),

                                    ],
                                  ),
                                ),
                                Text.rich(
                                    TextSpan(
                                        children: [
                                          const TextSpan(
                                            text: 'Qty :',

                                          ),

                                          WidgetSpan(

                                            child: IntrinsicWidth(
                                              stepWidth: 0.5,
                                              child: TextField(
                                                //controller: TextEditingController(text:"${_data[index]["textchange_var"]??_data[index]["qty"]}"),

                                                keyboardType: TextInputType.number,
                                                decoration: const InputDecoration(
                                                  hintText: '-1-',
                                                  hintStyle: TextStyle(color: Colors.blue),
                                                  contentPadding: EdgeInsets.all(0),
                                                  isDense: true,



                                                ),
                                                style: const TextStyle(
                                                  color: Colors.blue, // Set the text color to red

                                                ),
                                                onChanged: (text) {

                                                  if((int.tryParse(text) != null)){
                                                    searchResult[index]['req_qty']=text;
                                                    // print(searchResult[index]);

                                                    searchResult[index]['totalQty']=text;
                                                    searchResult[index]['totalAmount']=int.parse(searchResult[index]['price'])*int.parse(text);
                                                    searchResult[index]['totalCount']=text;
                                                    (Get.put(StockQuery()).updateHideaddCart(false));


                                                  }
                                                  else{
                                                    (Get.put(StockQuery()).updateHideaddCart(true));
                                                  }




                                                },
                                              ), // set minimum width to 100
                                            ),
                                          ),

                                        ]
                                    )
                                ),
                                const SizedBox(height: 5,),
                                Text("Qty left:${num.parse(searchResult[index]["qty"])-num.parse(searchResult[index]["qty_sold"])}"),


                              ],
                            ),
                          )






                        ],
                      ),

                      subtitle: Wrap(
                        //crossAxisAlignment: WrapCrossAlignment.center,
                        children: [

                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                          Text("tags:${searchResult[index]["tags"]} "),



                        ],
                      ),
                      trailing:Column(
                        children: [
                          Row(
                            mainAxisSize: MainAxisSize.min,
                            children: <Widget>[



                              GetBuilder<StockQuery>(
                                builder: (myLoadercontroller) {
                                  //return Text('Data: ${_controller.data}');
                                  return
                                    (myLoadercontroller.hideaddCart)?
                                    const Text(""):
                                    IconButton(
                                      icon: const Icon(Icons.add_shopping_cart,
                                          size: 23.0,
                                          color: Colors.grey),
                                      onPressed: () async{
                                        addCartMethod(searchResult[index]);
                                      },
                                    );
                                },
                              ),
                              const Visibility(
                                  visible:true,
                                  child: Text("")),
                              IconButton(
                                icon: const Icon(
                                    Icons.grid_view,
                                    size: 23.0,
                                    color: Colors.orange
                                ),
                                onPressed: () {


                                },
                              ),
                            ],
                          ),

                        ],
                      )

                    //trailing: Text()
                  ),
                  Visibility(
                    visible: false,
                    child: Padding(
                      padding: const EdgeInsets.fromLTRB(8,0,8,8),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.end,
                        children: const [
                          Text("1088888880808  8766"),
                        ],
                      ),
                    ),
                  ),

                ],
              ),
            ),
          );

        }
        else{
          return Container();
        }

      },
    );
  }

}


class CheckoutPage extends StatelessWidget {
  const CheckoutPage({
    Key? key,
    required this.chekoutResult,
    required this.changeQtyCheckout,
    required this.saveChangeQtyCheckout,
    required this.deleteCheckout,
    required this.addcomentCheckout,
  }) : super(key: key);

  final dynamic chekoutResult;
  final void Function(int,int,int,bool,int) changeQtyCheckout;
  final void Function(String,int,String) saveChangeQtyCheckout;
  final void Function(String) deleteCheckout;
  final void Function(String,String) addcomentCheckout;


  @override
  Widget build(BuildContext context) {


    return ListView.builder(


      itemCount: chekoutResult.length+1,
      itemBuilder: (context, index) {

        if(index<chekoutResult.length)
        {


          return Stack(
            children: [
              Container(
                margin: const EdgeInsets.fromLTRB(0, 0, 0, 0),
                child: Card(
                  elevation:0,
                  //margin: EdgeInsets.symmetric(vertical:1,horizontal:5),
                  //color:Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(9.0),
                    // side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
                  ),

                  child: Column(
                    children: [
                      // Text("sum:${orderSum}"),
                      ListTile(
                          leading: CircleAvatar(
                            backgroundColor:getRandomColor(),
                            child: Icon(_getRandomIcon()),
                          ),
                          title:Row(
                            children: [
                              Expanded(

                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [

                                    RichText(
                                      text: TextSpan(
                                        text:"${chekoutResult[index]["productCode"]} (${chekoutResult[index]["pcs"]} pcs):",
                                        style: DefaultTextStyle.of(context).style,
                                        children: <TextSpan>[
                                          TextSpan(
                                            text: "${chekoutResult[index]["totalQty"]}X${chekoutResult[index]["price"]}",
                                            style: const TextStyle(color: Colors.blue),


                                          ),

                                        ],
                                      ),
                                    ),
                                    Text.rich(
                                        TextSpan(
                                            children: [
                                              const TextSpan(
                                                text: 'Qty :',

                                              ),

                                              WidgetSpan(

                                                child: IntrinsicWidth(
                                                  stepWidth: 0.5,
                                                  child: TextField(
                                                    //controller: TextEditingController(text:"${_data[index]["textchange_var"]??_data[index]["qty"]}"),

                                                    keyboardType: TextInputType.number,
                                                    decoration: InputDecoration(
                                                      hintText: '-${chekoutResult[index]["totalQty"]}-',
                                                      hintStyle: const TextStyle(color: Colors.blue),
                                                      contentPadding: const EdgeInsets.all(0),
                                                      isDense: true,



                                                    ),
                                                    style: const TextStyle(
                                                      color: Colors.blue, // Set the text color to red

                                                    ),
                                                    onChanged: (text) {
                                                      if((int.tryParse(text) != null) && (int.tryParse(text)!=0)){
                                                        if(int.parse(text)>0)
                                                        {
                                                          //String qtyDa=text.
                                                          //print("${(chekoutResult[index]["price"]).runtimeType} ${(chekoutResult[index]["totalQty"]).runtimeType} ${text.runtimeType}");

                                                          changeQtyCheckout(index,(int.parse(chekoutResult[index]["price"])),(int.parse(text)),false,1);

                                                        }



                                                      }else{
                                                        changeQtyCheckout(index,1,1,true,1);
                                                      }

                                                      //print(this._data[index]["total_var"]);
                                                      // print("Text changed to: $text");
                                                    },
                                                  ), // set minimum width to 100
                                                ),
                                              ),

                                            ]
                                        )
                                    ),


                                  ],
                                ),
                              )






                            ],
                          ),


                          trailing:Column(
                            children: [
                              Row(
                                mainAxisSize: MainAxisSize.min,
                                children: <Widget>[

                                  if((chekoutResult[index]["saveChangeBtn"])??false)
                                    IconButton(
                                      icon: const Icon(Icons.add_shopping_cart,
                                          size: 23.0,
                                          color: Colors.grey),
                                      onPressed: () async{
                                        saveChangeQtyCheckout("${chekoutResult[index]["productCode"]}",index,"${chekoutResult[index]["totalQty"]}");
                                      },
                                    ) ,
                                  IconButton(
                                    icon: const Icon(
                                        Icons.delete,
                                        size: 23.0,
                                        color: Colors.red
                                    ),
                                    onPressed: () {
                                      deleteCheckout("${chekoutResult[index]["productCode"]}");

                                    },
                                  ),
                                ],
                              ),

                            ],
                          )

                        //trailing: Text()
                      ),
                      Visibility(
                        visible: true,
                        child: Padding(
                          padding: const EdgeInsets.fromLTRB(8,0,8,8),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.end,
                            children: [
                              Text("${chekoutResult[index]["totalAmount"]}"),
                            ],
                          ),
                        ),
                      ),

                    ],
                  ),
                ),
              ),
              Positioned(
                bottom:-10,
                right: 50,
                left: 50,


                child: Center(
                  child: IconButton(
                    icon: const Icon(Icons.add_comment,color:Colors.orange),
                    onPressed: () {
                      // Handle the first icon tap
                      addcomentCheckout(chekoutResult[index]["productCode"],"${chekoutResult[index]["commentData"]}");
                      //open
                    },
                  ),
                ),
              ),

            ],
          );

        }
        else{
          return Container();
        }

      },
    );
  }








}










