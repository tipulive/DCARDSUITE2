import 'dart:convert';
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
import '../Query/FloatingCartBar.dart';
import '../Query/cart_controller.dart';
import '../Query/PricingBottomSheet.dart';
import '../Utilconfig/ConstantClassUtil.dart';
import '../Utilconfig/PageLoaderWrapper.dart';
import '../Utilconfig/language/language.dart';
import '../Pages/components/checkAppVersion.dart';




import '../../../models/Participated.dart';

import '../Query/AdminQuery.dart';
import '../Pages/components/BottomNavigator/HomeNavigator.dart';
import '../Utilconfig/image_card_widget.dart';



import '../../../Query/PromotionQuery.dart';

import '../models/Admin.dart';
import '../models/Promotions.dart';
import '../models/User.dart';
import '../Utilconfig/Promotion.dart';
import '../Utilconfig/PromotionQData.dart';
import 'package:hive_flutter/hive_flutter.dart';


import 'components/Promobadge.dart';
import 'components/promo_badge.dart';





class Homepage extends StatefulWidget {
  const Homepage({super.key});



  @override
  State<Homepage> createState() => _HomepageState();


}
class _HomepageState extends State<Homepage> {

  List<dynamic> dataSearch = [];
  List<dynamic> cartData = [];

  List<dynamic> users=[];
  List<dynamic>qrSearch = [];
  bool buyBtn=true;
  bool expenseBtn=true;

  PromotionQuery promotionState=Get.put(PromotionQuery());
  AdminQuery adminStatedata=Get.put(AdminQuery());
  //StockQuery stockQueryData=Get.put(StockQuery());
  final StockQuery myStockQuery = Get.find<StockQuery>();
  final PromotionQData promoData = Get.find<PromotionQData>();
  //final resultAdmin = Get.put(AdminQuery()).obj["result"];
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
  final Map<String, FocusNode> focusNodes = {};
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
  String pageName="Home";
  Language langV=Language();
  var box=Hive.box("myBox");
  String selectedCurrency = "FRC";
  final products = [
    const PromoProduct(
      id: '1',
      icon: Icons.wallet_giftcard,
      name: 'Wireless Earbuds',
      oldPrice: '\$19.99',
    ),
    const PromoProduct(
      id: '2',
      icon: Icons.phone_iphone,
      name: 'Premium Phone Case',
      oldPrice: '\$29.99',
    ),
    // ... up to 5 items (they scroll)
  ];
  final Map<String, dynamic> rawPromoJson = {
    "quick": [
      {
        "id": "promo_tH_1786160055",
        "inStock": [
          { "productName": "bombo", "qtyBonus": 4 }
        ],
        "BonusTotal": 200,
      }
    ],
    "long": [
      {
        "id": "promo_Ml_1786153059",
        "inStock": [
          { "productName": "ifi", "qtyBonus": 1 }
        ],
        "BonusTotal": 100,
      }
    ]
  };

  void showConfirmBottomSheet() async{
    String userProfile=(myStockQuery.userProfile)["uid"];
    // print("Total dettes: $userProfile");
    // print((myStockQuery.userProfile)["uid"]);
    setState(() {

      showOver=true;
      // dataSearch.clear();


    });
    final response = await myStockQuery.checkUserDept(User(uid:userProfile));

    if (response != null) {
      final result=response.data;
      if(result["status"])
      {
        setState(() {

          showOver=false;
          // dataSearch.clear();


        });
        final users=result["result"];
        final totalD = ConstantClassUtil().calcTotObjJSon(users, 'dettes');
        final totalC=totalD+(Get.put(StockQuery()).dept);        // Output: 460
        //
        final double heightFactor = (users.length>1) ? 0.7 : 0.5;
        Get.bottomSheet(
          Container(
            height: Get.height * heightFactor,
            decoration: const BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
            ),
            child: SafeArea(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const SizedBox(height: 5),

                  // Title
                  const Text(
                    "Confirm?",
                    style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 5),
                  Text("Total dettes:${totalD.toString()} + ${(Get.put(StockQuery()).dept).toString()}=${totalC.toString()}"),
                  const SizedBox(height: 5),

                  // Action buttons
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: [
                      ElevatedButton(
                        onPressed: () async{
                          // YES action
                          await myOrderSubmit();
                          Get.back();
                        },
                        child: const Text("Yes"),
                      ),
                      OutlinedButton(
                        onPressed: Get.back,
                        child: const Text("Cancel"),
                      ),
                    ],
                  ),

                  const SizedBox(height: 0),

                  // User list
                  Flexible(
                    child: ListView.builder(
                      shrinkWrap: true,
                      itemCount: 1,
                      itemBuilder: (_, index) {
                        //final user = users[index];
                        return UserCard(
                          name:(myStockQuery.userProfile)["name"],
                          price: totalD,
                        );
                      },
                    ),
                  ),
                ],
              ),
            ),
          ),
          isScrollControlled: true,
          backgroundColor: Colors.transparent,
        );
        //
      }else{
        await myOrderSubmit();
        setState(() {

          showOver=false;
          // dataSearch.clear();


        });
        if(result["result"]==1){
          checkAppVersion(title: "error", message: result["error"],primaryButtonText:"Download",primaryButtonUrl: result["downNew"]);
        }
      }
    } else {
      setState(() {

        showOver=false;
        // dataSearch.clear();


      });
    }

  }

  /*void showConfirmBottomSheet() async{
     String userProfile=(myStockQuery.userProfile)["uid"];
    // print("Total dettes: $userProfile");
     setState(() {

       showOver=true;
       // dataSearch.clear();


     });
       final response = await myStockQuery.checkUserDept(User(uid:userProfile));

       if (response != null) {
         final result=response.data;
         if(result["status"])
           {
             setState(() {

               showOver=false;
               // dataSearch.clear();


             });
             final users=result["result"];
             final totalD = ConstantClassUtil().calcTotObjJSon(users, 'dettes');

            // Output: 460
             //
             final double heightFactor = (users.length>1) ? 0.7 : 0.5;
             Get.bottomSheet(
               Container(
                 height: Get.height * heightFactor,
                 decoration: const BoxDecoration(
                   color: Colors.white,
                   borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
                 ),
                 child: SafeArea(
                   child: Column(
                     mainAxisSize: MainAxisSize.min,
                     children: [
                       const SizedBox(height: 5),

                       // Title
                       const Text(
                         "Confirm?",
                         style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                       ),
                       const SizedBox(height: 5),
                       Text("Total dettes:${totalD.toString()}"),
                       const SizedBox(height: 5),

                       // Action buttons
                       Row(
                         mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                         children: [
                           ElevatedButton(
                             onPressed: () async{
                               // YES action
                               await myOrderSubmit();
                             },
                             child: const Text("Yes"),
                           ),
                           OutlinedButton(
                             onPressed: Get.back,
                             child: const Text("Cancel"),
                           ),
                         ],
                       ),

                       const SizedBox(height: 0),

                       // User list
                       Flexible(
                         child: ListView.builder(
                           shrinkWrap: true,
                           itemCount: users.length,
                           itemBuilder: (_, index) {
                             final user = users[index];
                             return UserCard(
                               name: user["Name"]!,
                               price: user["dettes"]!,
                             );
                           },
                         ),
                       ),
                     ],
                   ),
                 ),
               ),
               isScrollControlled: true,
               backgroundColor: Colors.transparent,
             );
             //
           }else{
           setState(() {

             showOver=false;
             // dataSearch.clear();


           });
           if(result["result"]==1){
             checkAppVersion(title: "error", message: result["error"],primaryButtonText:"Download",primaryButtonUrl: result["downNew"]);
           }
         }
       } else {
         setState(() {

           showOver=false;
           // dataSearch.clear();


         });
       }

  }*/

  myOrderSubmit() async{
    //Get.back();
    //print("submit");
    setState(() {

      showOver=true;
      // dataSearch.clear();


    });

    try {
      var inputDataText=(inputDataDept.text=="")?"0":inputDataDept.text;

      /* hano ngiye gutuma variable nzi resetting mbere ya submission */

      String userProfile=(Get.put(StockQuery()).userProfile)["uid"];

      String orderId=(Get.put(StockQuery()).order["resultData"][0]["uid"]);
      num orderSum=(Get.put(StockQuery())).orderSum;
      (Get.put(StockQuery()).updateHidePickClick(true));
      List<dynamic> orderVal=[
        {
          "name":"unknown",
          "uid":"none"
        }
      ];
      num totalVal=0;

      (Get.put(StockQuery()).updateSumOrder(totalVal));

      setState(() {
        //showOver=false;
        cartData.clear();
        //(Get.put(StockQuery()).updateOrder(orderVal));
        (Get.put(StockQuery()).updateDeptOrder(0));
        (Get.put(StockQuery()).updateOrder(orderVal));
        inputDataDept.text="";

        // dataSearch.clear();

      });


      //pickDefaultUser(true,true);

      /* hano ngiye gutuma variable nzi resetting mbere ya submission */

      //print(myStockQuery.promo);

      //var mypromo=JsonEncoder.withIndent('  ').convert(myStockQuery.promo);
      //
      //print("submit");

      var myPromo=myStockQuery.promo;
      Map<String, dynamic> data = jsonDecode(myPromo);
      // print("hello");
      var promo=(data["success"])?myPromo:'none';

      var resultData=(await StockQuery().submitOrder(Participated(uid:"Nyota_1672353378"
          ,uidUser:userProfile,subscriber:orderId,inputData:inputDataText),Promotions(
          token:"$orderSum",promoData:promo,gain:"350",uid:"PointSales1"
      ))).data;

      if(resultData["status"])
      {

        setState(() {
          showOver=false;
          inputDataDept.text="";



        });

        pickDefaultUser(true,true);
        /* num totalVal=0;

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
                              pickDefaultUser(true,true);*/
      }
      else{

        setState(() {

          showOver=false;



        });
        pickDefaultUser(true,true);
      }
    } catch (e) {

      setState(() {

        showOver=false;



      });
      pickDefaultUser(true,true);
    }

  }

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
      //resizeToAvoidBottomInset:(Get.put(StockQuery()).resizable),
      resizeToAvoidBottomInset:myStockQuery.resizable,


      body:PageLoaderWrapper(
          child:Stack(
            children: [

              Column(
                children: [
                  //Qr Code
                  //    const SizedBox(height: 40,),

                  /* ImageCardWidget(
                mainImageUrl: '${ConstantClassUtil.urlApp}/images/bg_1og2.jpg',
                smallImageUrls: [
                  '${ConstantClassUtil.urlApp}/images/bg_10g6.jpg',
                  '${ConstantClassUtil.urlApp}/images/api.jpg',
                  '${ConstantClassUtil.urlApp}/images/bg_20.jpg',

                ], initialImageUrl: '${ConstantClassUtil.urlApp}/images/bg_1og2.jpg',
              ),*/
                  const SizedBox(height: 30,),

                  InkWell(
                    onTap: (){
                      getCompData("view","");
                      searchCompany(context);
                    },
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [

                        Text(
                          Get.put(AdminQuery()).obj["result"] != null &&
                              Get.put(AdminQuery()).obj["result"] is List &&
                              Get.put(AdminQuery()).obj["result"].isNotEmpty
                              ? Get.put(AdminQuery()).obj["result"][0]["name"].toString()
                              : "",
                          style: GoogleFonts.bebasNeue(
                            fontSize: 20,
                            color: Colors.red,
                          ),
                        ),

                        Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            const SizedBox(width:30),
                            Text(
                                Get.put(AdminQuery()).obj["result"] != null &&
                                    Get.put(AdminQuery()).obj["result"] is List &&
                                    Get.put(AdminQuery()).obj["result"].isNotEmpty
                                    ? Get.put(AdminQuery()).obj["result"][0]["CompanyName"].toString()
                                    : "", style: GoogleFonts.bebasNeue(fontSize: 20,color: Colors.black)),
                            const SizedBox(width: 5),
                            const Icon(Icons.arrow_drop_down),
                          ],
                        ),
                      ],
                    ),
                  ),

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

                          child:  Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              const Icon(Icons.star, color: Colors.yellow), // Replace with your desired icon
                              const SizedBox(width: 8.0), // Adjust the space between icon and text
                              Text("${langV.languageV[(Get.put(StockQuery()).lang)][pageName]["pickDft"]}", style: const TextStyle(fontSize: 16.0)),
                            ],
                          ),

                        ):
                        const SizedBox.shrink();
                    },
                  ),

                  // SearchBarField(search: _data,searchController:searchContro,PerformSearch:,),
                  SearchBarField(
                    searchBy:(text) async{
                      setState(() {
                        (Get.put(StockQuery()).updateSelected(text));

                      });
                      //(Get.put(StockQuery()).selectedOption),
                    } ,
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
                  if (Get.put(StockQuery()).dataSearch.isNotEmpty)
                    Expanded(
                      child: ProductSearchList(
                        addCartMethod: (dynamicData) {
                          // print(dynamicData);
                          addCartPlus(dynamicData);
                        },
                        viewPictureMethod: (productCode, imgUrl) {
                          viewPicture(productCode, imgUrl);
                        },
                        searchResult: Get.put(StockQuery()).dataSearch,
                      ),
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
                                icon: const Icon(Icons.wallet_giftcard),
                                iconSize: 28.0,
                                color: Colors.deepOrange,
                                onPressed: () async{
                                  final uid=(myStockQuery.userProfile)["uid"];
                                  var response=await PromotionQData().getMyPromotion(User(uid: uid));
                                  if (response != null && response.data != null) {
                                    viewPromo(response.data);
                                  }
                                }

                            ), // Replace with your desired icon
                            const SizedBox(width: 8.0), // Adjust the space between icon and text
                            InkWell(
                                onTap: () async {
                                  setState(() {
                                    phoneNumber="none";
                                    searchValOption=false;
                                  });


                                  await getUserData();
                                  searchUser(context);
                                },
                                child: Text('${(Get.put(StockQuery()).order)["resultData"][0]["name"]}', style: const TextStyle(fontSize: 16.0))),
                            const SizedBox(width: 8.0),
                            IconButton(
                                icon: const Icon(Icons.qr_code),
                                iconSize: 28.0,
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
                        /*InkWell(
                            onTap: () async{
                              //print((myStockQuery.userProfile)["carduid"]);
                              print(myStockQuery.promo);
                              //print(await (Get.put(PromotionQData()).promotions));
                            },
                            child: const Text("promo")

                        ),*/
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
                                        Get.back(canPop: false);
                                        setState(() {
                                          showOver=true;
                                        });

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

                                            cartData.clear();
                                            ///(Get.put(StockQuery()).updateOrder(orderVal));
                                            (Get.put(StockQuery()).updateDeptOrder(0));
                                            inputDataDept.text="";

                                            // dataSearch.clear();

                                          });
                                          await pickDefaultUser(true,true);

                                          setState(() {
                                            showOver=false;
                                          });




                                        }
                                        else{
                                          (Get.put(StockQuery()).updateHideLoader(true));
                                        }


                                      },
                                      child: const Text('Yes',style:TextStyle(
                                          color: Colors.white
                                      ),),
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
                  //Text("id ${(Get.put(StockQuery()).order["resultData"][0]["uid"])}"),
                  // Text("Total:${(Get.put(StockQuery()).orderSum)}"),
                  Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const SizedBox(width: 16),
                      Text(
                        "Total: ${(Get.put(StockQuery()).orderSum)}",
                        style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(width: 8), // spacing between text and icon
                      InkWell(
                        onTap: ()async{
                          final List<Map<String, dynamic>> orderMap =
                          List<Map<String, dynamic>>.from(cartData);

                          Map<String, dynamic> users = {
                            "name":(Get.put(StockQuery()).order)["resultData"][0]["name"],

                            "title": "Temporary Order"
                          };

                          final shareMsg =ConstantClassUtil().buildWhatsAppMessage(orderMap,users);
                          await ConstantClassUtil().shareToWhatsApp("", shareMsg);

                        },
                        child: const Icon(
                          Icons.share, // choose any icon you want
                          size: 20,
                          color: Colors.blue,

                        ),
                      ),

                    ],
                  ),
                  Column(
                    children: [
                      Padding(
                        padding: const EdgeInsets.fromLTRB(40, 0, 40, 0),
                        child: Container(
                          padding: const EdgeInsets.symmetric(horizontal: 5),
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(10.0),
                            border: Border.all(
                              color: Colors.grey,
                            ),
                          ),
                          child: Row(
                            children: [
                              // Debt
                              InkWell(
                                onTap: () {},
                                child: Visibility(
                                  visible: true,
                                  child: Container(
                                    padding: const EdgeInsets.all(10.0),
                                    decoration: const BoxDecoration(
                                      color: Colors.red,
                                    ),
                                    child: Text(
                                      'dettes ${(Get.put(StockQuery()).dept)}',
                                      style: const TextStyle(color: Colors.white),
                                    ),
                                  ),
                                ),
                              ),

                              // Ayo Yishyuye (Original functionality preserved)
                              Expanded(
                                child: Padding(
                                  padding:
                                  const EdgeInsets.symmetric(horizontal: 8.0),
                                  child: TextField(
                                    keyboardType: TextInputType.number,

                                    decoration: const InputDecoration(
                                      hintText: 'Ayo Yishyuye...',
                                      border: InputBorder.none,
                                      //isDense: true,

                                    ),

                                    controller: inputDataDept,
                                    focusNode: getFocusNode("qty_1"),
                                    onChanged: (value) {
                                      final myValue = double.tryParse(value);
                                      if (myValue != null && myValue >= 0) {
                                        num deptVal =
                                            (Get.put(StockQuery()).orderSum) -
                                                num.parse(value);

                                        double valueData =
                                        (deptVal).toDouble();

                                        double deptValAmount =
                                        ConstantClassUtil()
                                            .truncateToDecimalPlaces(
                                          valueData,
                                          2,
                                        );

                                        if (deptValAmount < 0) {
                                          num deptVal = 0;

                                          setState(() {
                                            buyBtn = true;
                                            expenseBtn= buyBtn;
                                            Get.put(StockQuery())
                                                .updateDeptOrder(deptVal);
                                          });
                                        } else {

                                          setState(() {
                                            buyBtn = false;
                                            expenseBtn= buyBtn;
                                            Get.put(StockQuery())
                                                .updateDeptOrder(
                                              deptValAmount,
                                            );
                                          });
                                        }
                                      } else {
                                        num deptVal = 0;

                                        setState(() {
                                          buyBtn = true;
                                          expenseBtn= buyBtn;
                                          Get.put(StockQuery())
                                              .updateDeptOrder(deptVal);
                                        });
                                      }
                                    },
                                  ),
                                ),
                              ),

                              // Buy Button (Original functionality preserved)
                              buyBtn
                                  ? const Padding(
                                padding: EdgeInsets.all(10),
                                child: Icon(
                                  Icons.warning,
                                  color: Colors.orange,
                                  size: 28,
                                ),
                              )
                                  : InkWell(
                                onTap: () async {



                                  double dept =
                                      double.tryParse(
                                        (Get.put(
                                          StockQuery(),
                                        ).dept)
                                            .toString(),
                                      ) ??
                                          0;

                                  if (dept > 0) {
                                    showConfirmBottomSheet();
                                  } else {
                                    await myOrderSubmit();
                                  }
                                },
                                child: Container(
                                  padding: const EdgeInsets.all(10.0),
                                  decoration: const BoxDecoration(
                                    color: Colors.green,
                                    borderRadius: BorderRadius.only(
                                      topRight:
                                      Radius.circular(10.0),
                                      bottomRight:
                                      Radius.circular(10.0),
                                    ),
                                  ),
                                  child: const Text(
                                    'Buy',
                                    style: TextStyle(
                                      color: Colors.white,
                                    ),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),

                      // Expense Field aligned under Ayo Yishyuye
                      (expenseBtn)?const SizedBox.shrink():Padding(
                        padding: const EdgeInsets.fromLTRB(
                          110,
                          1,
                          80,
                          0,
                        ),
                        child: Container(

                          decoration: BoxDecoration(
                            border: Border.all(color: Colors.grey),
                            borderRadius: const BorderRadius.only(
                              bottomLeft: Radius.circular(8),
                              bottomRight: Radius.circular(8),
                            ),
                          ),
                          child: TextField(
                            keyboardType: TextInputType.number,
                            textAlign: TextAlign.start,
                            decoration: InputDecoration(
                              hintText: 'Expense...',
                              border: InputBorder.none,
                              /* prefixIcon: const Icon(
                            Icons.receipt_long_outlined,
                          ),*/

                              // Currency dropdown on right
                              suffixIcon: DropdownButtonHideUnderline(
                                child: DropdownButton<String>(
                                  value: selectedCurrency,
                                  items: const [
                                    DropdownMenuItem(
                                      value: "FRC",
                                      child: Text("FRC"),
                                    ),
                                    DropdownMenuItem(
                                      value: "USD",
                                      child: Text("USD"),
                                    ),
                                    DropdownMenuItem(
                                      value: "GBP",
                                      child: Text("GBP"),
                                    ),
                                  ],
                                  onChanged: (value) {
                                    if (value != null) {
                                      setState(() {
                                        selectedCurrency = value;
                                      });
                                    }
                                  },
                                ),
                              ),

                              contentPadding: const EdgeInsets.symmetric(
                                vertical: 12,
                              ),
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                  /*Padding(
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
                              'Ideni ${(Get.put(StockQuery()).dept)}',
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
                              hintText: 'Ayo Yishyuye...',
                              border: InputBorder.none,
                            ),
                            controller: inputDataDept,

                            focusNode: getFocusNode("qty_1"),
                            onChanged: (value){

                              final myValue = double.tryParse(value);
                              if(myValue != null && myValue >= 0){
                                num deptVal=(Get.put(StockQuery()).orderSum)-num.parse(value);
                                double valueData = (deptVal as num).toDouble();
                                 double deptValAmount=ConstantClassUtil().truncateToDecimalPlaces(valueData, 2);

                                 if(deptValAmount<0)
                                   {
                                     num deptVal=0;
                                     setState(() {
                                       buyBtn=true;
                                       (Get.put(StockQuery()).updateDeptOrder(deptVal));
                                     });
                                   }else{
                                   setState(() {
                                     buyBtn=false;
                                     (Get.put(StockQuery()).updateDeptOrder(deptValAmount));
                                   });
                                 }


                              }else{

                                num deptVal=0;
                                setState(() {
                                  buyBtn=true;
                                  (Get.put(StockQuery()).updateDeptOrder(deptVal));
                                });
                              }




                            },
                          ),
                        ),
                      ),
                      (buyBtn)?const Icon(
                        Icons.warning,
                        color: Colors.orange,
                        size: 28,
                      ):InkWell(
                        onTap: () async{
                          // print("${inputDataDept.text} ${(Get.put(StockQuery())).orderSum } ${Get.put(StockQuery().order["resultData"][0]["uid"])}");
                       double dept=double.tryParse((Get.put(StockQuery()).dept).toString())??0;

                          if(dept>0) {
                            print(dept);
                         showConfirmBottomSheet();
                           }
                          else{
                            //submit order code

                            await myOrderSubmit();

                          }


                        },
                        child:Container(
                          padding: const EdgeInsets.all(10.0),
                          decoration: const BoxDecoration(
                            color: Colors.green,
                            borderRadius: BorderRadius.only(
                              topRight: Radius.circular(10.0),
                              bottomRight: Radius.circular(10.0),
                            ),
                          ),
                          child: const Text(
                            'Buy',
                            style: TextStyle(color: Colors.white),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),*/

                  Expanded(child: CheckoutPage(chekoutResult:cartData,changeQtyCheckout:(index,price,valueData,checkHide,thisQty){
                    /*setState(() {
                  editQty=thisQty;
                });*/

                    changeQtyMethod(index,price,valueData,checkHide);

                  },viewPictureM:(productCode,imgUrl){
                    viewPicture(productCode,imgUrl);

                  },saveChangeQtyCheckout:(productCode,indexData,currentEditQty){
                    saveChangeQtyMethod(productCode,indexData,currentEditQty);
                  },deleteCheckout:(productCode) async{

                    if(await getPromotion())
                    {
                      try {

                        setState(() {
                          buyBtn = true;
                          showOver=true;
                        });


                        var resultData=(await StockQuery().deleteTSingleOrder(QuickBonus(productName:productCode,uid:await (Get.put(StockQuery()).order)["resultData"][0]["uid"] ))).data;

                        if(resultData["status"])
                        {
                          print(resultData);
                          //print(resultData);
                          /* List<dynamic> orderVal=[
                      {
                        "name":"Unknown",
                        "uid":""
                      }
                    ];*/


                          setState(() {
                            //showOver=false;
                            cartData.removeWhere((item) => item['productCode'] == productCode);
                            /*print("cartData: $cartData");
                          print("cartData type: ${cartData.runtimeType}");
                          print("cartData length: ${cartData.length}");*/
                            // num totalVal = cartData.fold(0, (previousValue, element) => previousValue + element['totalAmount']);

                            num totalVal = cartData.fold<num>(
                              0,
                                  (sum, element) {
                                final amount = num.tryParse(
                                  element['totalAmount']?.toString() ?? '0',
                                ) ?? 0;

                                return sum + amount;
                              },
                            );

                            print("TOTAL = $totalVal");
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

                            showOver=false;
                          });






                          //applyPromotion();

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
                    }



                  },addcomentCheckout:(productCode,commentData){
                    addComment(productCode,commentData);
                  },focusNodes: focusNodes,getFocusCheckout:getFocusNode)),

                  // CheckoutPage(),




                  Visibility(
                    visible: true,
                    child: Expanded(
                      flex: 0,
                      child: SingleChildScrollView(

                        child: Center(
                            child:Column(
                              children: [
                                (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"):SizedBox.shrink(),










                              ],
                            )

                        ),
                      ),
                    ),
                  ),
                ],
              ),
              /* Positioned(
            top: MediaQuery.of(context).size.height * 0.4,
            right: 0,
            child: PromoBadge(
              products: products,
            ),
          ),*/
              // Middle-Right Offer Badge
              // Floating Middle-Right Badge
              // Middle-Right Multi-Level Badge Position
              // Floating, Draggable Badge
              Obx(() {
                final promoData = Get.find<PromotionQData>().promoResult.value;

                // Debug print (optional)

                // Check if there is at least one promotion
                final hasPromos = (promoData['quick'] as List? ?? []).isNotEmpty ||
                    (promoData['long'] as List? ?? []).isNotEmpty;

                if (!hasPromos) {
                  return const SizedBox.shrink(); // hide when empty
                }

                return DynamicPromoBadge(promoJson: promoData);
              }),
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
              const FloatingCartBar(currencySymbol: "\$"),
            ],
          ) ),
      bottomNavigationBar:HomeNavigator(currentIndex: 0),

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
            "carduid": "none"
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


    /*final mockData = [
      {"productCode": "P1", "totalAmount": "12.50", "totalQty": 2, "price": "6.25"},
      {"productCode": "P2", "totalAmount": null, "totalQty": "3", "price": 10},
    ];
    final result = ConstantClassUtil().convertCart(mockData);
    print(result);*/

    //getapi();
    /*focusNode.addListener(() {
      if (focusNode.hasFocus) {
       // print("EVENT: Focus gained (user is inside TextField)");
        setState(() {
          (myStockQuery.updatedataSearch([]));

        });

      } else {
        print("EVENT: Focus lost (user left TextField)");
      }
    });*/
    _initialize();
    // cartDisplay();
    setState(() {
      showOver=false;
    });

  }

  Future<void> _initialize() async {
    // Load promotions from cache or network (first call = fetch)
    // await getPromotion();
    await cartDisplay();   // now promotions are available
  }
  FocusNode getFocusNode(String key) {
    return focusNodes.putIfAbsent(key, () {
      final node = FocusNode();

      node.addListener(() {
        if (node.hasFocus) {

          // clear search safely here
          setState(() {


            myStockQuery.updatedataSearch([]);
            myStockQuery.updateResizable(true);
            //Get.put(StockQuery()).updateResizable(true);
          });

        } else {
        }
      });

      return node;
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

    // print(await getPromotion());
    if(await getPromotion()) {


      try {
        ConstantClassUtil().showPageLoadingDialog(message: "");
        var resultData = (await StockQuery().viewUserTempOrder(
            QuickBonus(uid: "nyota"))).data;
        if (resultData["status"]) {

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
            "marital_status": resultData["result"][0]["marital_status"],
            "email": "on@gmail.com",
            "phone": "782389359",
            "Ccode": "+250",
            "country": "Rwanda",
            "initCountry": "none",
            "PhoneNumber": "none",
            "carduid": "none"
          };

          //print(resultData["result"][0]["martial_status"]);
          (Get.put(StockQuery()).updateUserProfile(userProfile));


          (Get.put(StockQuery()).updateOrder(resultData["result"]));
          String permission = (resultData["result"][0])["permission"];
          (permission == "false") ? (Get.put(StockQuery()).updateHidePickClick(
              false)) : (Get.put(StockQuery()).updateHidePickClick(
              true)); //hidePick false is hide and true show
          num alldept = num.parse((resultData["result"][0])["orderDebt"]);
          num inputAll = (Get
              .put(StockQuery())
              .orderSum) - alldept;
          num inputDebtAll = (alldept == 0) ? alldept : inputAll;
          (Get.put(StockQuery()).updateDeptOrder(alldept));

          inputDataDept.text = "${(inputDebtAll == 0) ? "" : inputDebtAll}";
          setState(() {
            cartData.clear();

            cartData.addAll(resultData["result"]);
          });
          //print(cartData);
          // Map<String, dynamic> cartD =ConstantClassUtil().convertCart(cartData);
          //var promo1=const JsonEncoder.withIndent('  ').convert(Promotion.applyBestPromotion(cartD, promoData.promotions));
          // print(promoData.promotions);
          //print(promo1);
          //(myStockQuery.updatePromo(promo1));
          print("app yako");
          applyPromotion();

          ConstantClassUtil().hidePageLoadingDialog();
        }
        else {
          ConstantClassUtil().hidePageLoadingDialog();
          setState(() {
            List<dynamic> orderVal = [
              {
                "name": Get
                    .put(AdminQuery())
                    .obj["result"][0]["name"],
                "uid": "none"
              }
            ];
            ((Get.put(StockQuery()).updateDeptOrder(0)));
            ((Get.put(StockQuery()).updateOrder(orderVal)));
            inputDataDept.text = "";
            num totalVal = 0;

            ((Get.put(StockQuery()).updateSumOrder(totalVal)));
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


  }

  performSearch(String text,String statusSearch) async{


    try {
      bool searchHide=(statusSearch=='none')?true:false;//to check if is Qr search or no Qr
      String productCode=((Get.put(StockQuery()).selectedOption)=="Code")?text:"none";
      String productName=((Get.put(StockQuery()).selectedOption)=="Name")?text:'none';
      var resultData=(await StockQuery().product(QuickBonus(uid:productCode,productName:productName,status:statusSearch),Topups(optionCase:"searchProductStock",startlimit:1,endlimit:10))).data;
//print(resultData["status"]);
      if(resultData["status"])
      {
        (Get.put(StockQuery()).updateResizable(false));
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

          (Get.put(StockQuery()).updateResizable(true));
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

    if (await getPromotion()) {
      try {
        setState(() {
          buyBtn = true;
          showOver = true;
        });

        // --- SAFELY PARSE THE QUANTITY FROM cartData ---
        // Get the raw value (could be int, double, String, or null)
        dynamic rawQty = cartData[indexData]["totalQty"];
        int qtyInt = 0;

        if (rawQty is int) {
          qtyInt = rawQty;
        } else if (rawQty is double) {
          // Use .round() if you want mathematical rounding, or .toInt() to truncate
          qtyInt = rawQty.round(); // change to .toInt() if you prefer truncation
        } else if (rawQty is String) {
          String cleaned = rawQty.replaceAll(' ', '').trim();
          // Try parsing as integer first
          qtyInt = int.tryParse(cleaned) ??
              double.tryParse(cleaned)?.round() ?? 0;
        } else {
          // Fallback: if it's null or some other type, treat as 0
          qtyInt = 0;
        }

        // --- CALL THE API WITH THE PARSED INTEGER ---
        var resultData = await StockQuery().editTOrder(
          QuickBonus(
            productName: "$productCode",
            reqQty: qtyInt,   // now safely parsed
            currentQtyEdit: cartData[indexData]["old_qty"],
            uid: (Get.put(StockQuery()).order)["resultData"][0]["uid"],
          ),
          User(uid: "${(Get.put(StockQuery()).userProfile)["uid"]}"),
        );

        if (resultData["status"]) {
          print("twese");
          setState(() {
            showOver = false;
            // Update old_qty with the safe integer
            cartData[indexData]["old_qty"] = qtyInt;
            cartData[indexData]["saveChangeBtn"] = true;

            // --- CONVERT CART AND APPLY PROMOTION ---

            // --- SAFELY SUM TOTAL AMOUNT ---
            num totalVal = 0;
            for (var item in cartData) {
              var amount = item['totalAmount'];
              if (amount is String) {
                // Try parsing as num (handles both int and double)
                amount = num.tryParse(amount.replaceAll(' ', '')) ?? 0;
              } else if (amount is! num) {
                // If it's something else (bool, etc.), treat as 0
                amount = 0;
              }
              totalVal += amount;
            }

            (Get.put(StockQuery()).updateSumOrder(totalVal));
          });

          applyPromotion(); // your external function

        } else {
          // --- ERROR DIALOG ---
          Get.dialog(
            AlertDialog(
              title: const Text('Something Wrong'),
              content: const Text('Please put less Qty or Contact System Admin'),
              actions: [
                ElevatedButton(
                  onPressed: () {
                    Get.back();
                  },
                  child: const Text('Close'),
                ),
              ],
            ),
          );
          setState(() {
            showOver = false;
            dataSearch.clear();
            (Get.put(StockQuery()).updatedataSearch(dataSearch));
          });
        }

      } catch (e) {
        print("twese $e");
        setState(() {
          showOver = false;
        });
        // Optionally show a user-friendly error dialog here
        // Get.snackbar("Error", "An unexpected error occurred: $e");
      }
    }


  }
  void viewPicture(productCode,imgUrl){
    imgUrl=(imgUrl=='none')?'{}':imgUrl;
    Map<String, dynamic> imgVersion = jsonDecode(imgUrl);
    String urLink='${ConstantClassUtil.urlApp}/images/product/';



    // i need to add first images  with product Code
    // print("${imgVersion["numb1"]}");

    //print("code:${productCode}  link:${ConstantClassUtil.urlApp}/images/product/${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg");
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
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
              child: SingleChildScrollView(
                child: Column(
                  children: [
                    ImageCardWidget(
                      imgArguments:{
                        "productCode":productCode,
                        "editDisplay":"false",


                      },
                      mainImageUrl:(imgVersion["numb1"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb1"]}&img=1":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg?Ver=${imgVersion["numb1"]}&img=1',
                      smallImageUrls: [
                        (imgVersion["numb2"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb2"]}&img=2":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_2.jpg?Ver=${imgVersion["numb2"]}&img=2',
                        (imgVersion["numb3"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb3"]}&img=3":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_3.jpg?Ver=${imgVersion["numb3"]}&img=3',
                        (imgVersion["numb4"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb4"]}&img=4":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_4.jpg?Ver=${imgVersion["numb4"]}&img=4',

                      ], initialImageUrl:(imgVersion["numb1"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb1"]}&img=1":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg?Ver=${imgVersion["numb1"]}&img=1',
                    ),

                  ],
                ),
              ),
            );
        },
      ),
    ).whenComplete(() {
      // Get.put(HideShowState()).isDelivery(0);
      //do whatever you want after closing the bottom sheet
    });

  }
  void addCartPlus(dynamic dynamicData) async{
    //print((Get.put(StockQuery()).userProfile)["uid"]);
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



                Get.back(canPop: false);
                await pickDefaultUser(false,true);

                if((Get.put(StockQuery()).userProfile)["uid"]!='none')
                {
                  //print(myStockQuery.reqProductData);

                  await placeOrder(myStockQuery.reqProductData);
                  //Get.back(canPop: false);

                }



              },
              child: const Text('Default',style:TextStyle(
                  color: Colors.white
              ),),
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
    //var resultData=(await StockQuery().searchUser(User(uid:"",name:"anyName",phone:"any",platform:"4000",status:"Default"),Topups(optionCase:"false",startlimit:1,searchOption:false))).data;
    try {
      var resultData=(await StockQuery().pickDefault());

//print((myStockQuery.userProfile));
      //print(resultData);
      if(resultData["status"])
      {


        (Get.put(StockQuery()).updateHideLoader(true));

        if(resultData["result"]!=0)
        {

          (Get.put(StockQuery()).updateHideLoader(true));
          var userProfile =
          {
            /* "uid": "${resultData["result"][0]["uid"]}",
          "name": "${resultData["result"][0]["name"]}",*/
            "uid": resultData["uid"],
            "name":resultData["name"],
            "marital_status":resultData["marital_status"],
            "email": "on@gmail.com",
            "phone": "782389359",
            "Ccode": "+250",
            "default":"true",
            "country": "Rwanda",
            "initCountry": "none",
            "PhoneNumber": "none",
            "carduid": "none"
          };




          if(isOrderNotExist==true){
            (Get.put(StockQuery()).updateUserProfile(userProfile));
            List<dynamic> orderVal=[
              {
                //"name":"${resultData["result"][0]["name"]}",
                "name": resultData["name"],
                "uid":"${(resetOrder==true)?'none':(Get.put(StockQuery()).order)["resultData"][0]["uid"]}"
              }
            ];
            setState(() {
              (Get.put(StockQuery()).updateOrder(orderVal));
            });
          }else{
            // changeUserInOrder(resultData["result"][0]["uid"],resultData["result"][0]["name"],"0789");
            changeUserInOrder(resultData["uid"],resultData["name"],"0789");
          }
          await cartDisplay();         // now uses the correct order UID
          applyPromotion();



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
    } catch (e) {
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
        "carduid": "none"
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



    setState(() {
      productSearch=false;
    });
    (Get.put(StockQuery()).updateResizable(true));
    (Get.put(StockQuery()).updateHideLoader(false));
    bool containsProductCode = cartData.any((item) => item['productCode'] == dynamicData["productCode"]);

    if(containsProductCode)
    {
      (Get.put(StockQuery()).updateHideLoader(true));
      (Get.put(StockQuery()).updateTextMessage("${dynamicData['ProductName']} Product already Added"));
      (Get.put(StockQuery()).updateHideProductList(true));

      Get.snackbar("error", " Product already Added Please increase Qty",backgroundColor: const Color(0xff9a1c55),
          colorText: const Color(0xffffffff),
          titleText:Text("${dynamicData['ProductName']}",style:const TextStyle(color:Color(
              0xffffffff),fontSize:18,fontWeight:FontWeight.w500,fontStyle: FontStyle.normal),),

          icon: const Icon(Icons.access_alarm),
          duration: const Duration(seconds: 4));


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
          //print(cartData);

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


            searchContro.text="";

          });

          // num prevqt = cartData.fold(0, (previousValue, element) => previousValue + element['req_qty']);
          // print(cartData);
          // print(ConstantClassUtil().convertCart(cartData));
          /*Map<String, dynamic> cartD =ConstantClassUtil().convertCart(cartData);
            //
            //print("hello");

            applyPromotion(cartD);*/
          // print(cartData);
          //applyPromotion();

          cartDisplay();
        }
        else{

          setState(() {

            showOver=false;
            dataSearch.clear();
            (Get.put(StockQuery()).updatedataSearch(dataSearch));

            (Get.put(StockQuery()).updateHideLoader(true));


          });
          if(resultData["result"]==1){
            checkAppVersion(title: "error", message: resultData["error"],primaryButtonText:"Download",primaryButtonUrl: resultData["downNew"]);
          }
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




    /*if(await getPromotion())
            {

            }else{

          }*/
  }
  // In _HomepageState
  Future<bool> getPromotion({bool forceRefresh = false}) async {
    return await promoData.fetchPromotions(forceRefresh: forceRefresh);
  }
  /*applyPromotion(cartD){
    Map<String, dynamic> cartD =ConstantClassUtil().convertCart(cartData);
    //
    // print(cartD);
    var promo1=const JsonEncoder.withIndent('  ').convert(Promotion.applyBestPromotion(cartD,promoData.promotions));
    (myStockQuery.updatePromo(promo1));
  }*/
  void applyPromotion() {

    print(cartData);
    Map<String, dynamic> cartD = ConstantClassUtil().convertCart(cartData);

    final result = Promotion.applyBestPromotion(cartD, promoData.promotions);

    final promoJson = const JsonEncoder.withIndent('  ').convert(result);
    myStockQuery.updatePromo(promoJson);
    print(promoJson);
    // final fullResult = Promotion.applyBestPromotion(cartD, promoData.promotions);
    final extracted = {
      'quick': List<Map<String, dynamic>>.from(result['quick'] ?? []),
      'long': List<Map<String, dynamic>>.from(result['long'] ?? []),
    };

    // ✅ Use Get.find to update the same instance
    Get.find<PromotionQData>().promoResult.value = extracted;
  }
  searchUserMethod() async{

  }
  //switch Company

  switchAccount(String userId,String pass) async{
    //FocusManager.instance.primaryFocus?.unfocus();
    //print(box.get('auth')[0]);
    //print(box.get('auth'));
    //print(box.get('owner'));
    setState(() {

      // (Get.put(StockQuery()).updateHideLoader(false));
      showOver=true;
    });

    var resultData=(await myStockQuery.switchAccount(User(uid:userId,password: pass)));

    if(resultData["status"])
    {


      await Get.put(AdminQuery()).logout(false);//this will delete everything except oowner
      setState(() {
        //(Get.put(StockQuery()).updateHideLoader(true));
        showOver=false;
      });
      if((await AdminQuery().switchAcc(Admin(uid:resultData["User"]["uid"],name:resultData["User"]["name"],subscriber:resultData["User"]["subscriber"],AuthToken: resultData["token"],email: resultData["User"]["email"],phone: resultData["User"]["tel"],CompanyName:resultData["User"]["CompanyName"] )))>0)
      {
        Map<String, dynamic> userProfile=
        {
          //"uid": "kebineericMuna_1674160265",
          "uid": "none",


          "email": "on@gmail.com",
          "phone": "782389359",
          "Ccode": "+250",
          "country": "Rwanda",
          "initCountry": "none",
          "PhoneNumber": "+250782389359",
          "marital_status":"none",
          "carduid": "none"
        }
        ;
        await Get.put(StockQuery()).updateUserProfile(userProfile);
        //Get.to(Homepage());
        //Get.to(() => Homepage());

        await adminStatedata.auth();
        myStockQuery.updatedataSearch([]);
        myStockQuery.updateResizable(true);
        searchContro.text="";
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

          cartData.clear();
          ///(Get.put(StockQuery()).updateOrder(orderVal));
          (Get.put(StockQuery()).updateDeptOrder(0));
          inputDataDept.text="";

          // dataSearch.clear();

        });
        await pickDefaultUser(true,true);


        //Get.toNamed('/sale');

      }
      else{
        // print((await AdminQuery().addData(Admin(uid:uidInput.text,subscriber: uidInput2.text)))),
      }




    }
    else{
      (Get.put(StockQuery()).updateHideLoader(true));

      setState(() {

        // users.clear();


      });
    }
  }
  getCompData(String optionCase,String name) async{
    //FocusManager.instance.primaryFocus?.unfocus();

    setState(() {
      showOver=true;
    });

    var resultData=(await myStockQuery.miniAccount(Topups(optionCase:optionCase,name: name,uid:box.get('owner')[0]["uid"])));
    //print("amaData:${resultData}");

    if(resultData["status"])
    {

      (Get.put(StockQuery()).updateHideLoader(true));

      if(resultData["result"]!=0)
      {

        setState(() {
          showOver=false;
          //users.clear();
          //users.addAll(resultData["result"]);
          (Get.put(StockQuery()).updatecompPick(resultData["result"]));

        });
        // print(users);
      }
      else{
        setState(() {

          //users.clear();


        });
      }




    }
    else{
      (Get.put(StockQuery()).updateHideLoader(true));

      setState(() {

        // users.clear();


      });
    }
  }
  void searchCompany(BuildContext context) {
    Get.bottomSheet(
      SafeArea(
        child: Container(
          height: Get.height * 0.82,
          decoration: const BoxDecoration(
            color: Color(0xffF8F9FB),
            borderRadius: BorderRadius.vertical(
              top: Radius.circular(30),
            ),
          ),
          child: Column(
            children: [
              const SizedBox(height: 12),

              /// Drag Handle
              Container(
                width: 42,
                height: 5,
                decoration: BoxDecoration(
                  color: Colors.grey.shade300,
                  borderRadius: BorderRadius.circular(20),
                ),
              ),

              const SizedBox(height: 24),

              /// Title
              const Padding(
                padding: EdgeInsets.symmetric(horizontal: 24.0),
                child: Text(
                  "Switch Account",
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    letterSpacing: -0.5,
                  ),
                ),
              ),

              const SizedBox(height: 8),

              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 24),
                child: Text(
                  "Choose another company account to continue.",
                  style: TextStyle(
                    color: Colors.grey.shade600,
                    fontSize: 14,
                  ),
                ),
              ),

              const SizedBox(height: 25),

              /// Current Account
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20),
                child: Material(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(18),
                  elevation: 1,
                  child: InkWell(
                    borderRadius: BorderRadius.circular(18),
                    onTap: () async {
                      //Get.back();
                      Get.back();
                      await switchAccount(
                        box.get('owner')[0]["uid"],
                        box.get('owner')[0]["password"],
                      );
                    },
                    child: Padding(
                      padding: const EdgeInsets.all(16),
                      child: Row(
                        children: [
                          Container(
                            width: 52,
                            height: 52,
                            decoration: BoxDecoration(
                              color: Colors.black,
                              borderRadius: BorderRadius.circular(15),
                            ),
                            child: const Icon(
                              Icons.business_rounded,
                              color: Colors.white,
                            ),
                          ),

                          const SizedBox(width: 16),

                          Expanded(
                            child: Column(
                              crossAxisAlignment:
                              CrossAxisAlignment.start,
                              children: [
                                Text(
                                  box.get('owner')[0]["companyName"] ??
                                      box.get('owner')[0]["name"],
                                  style: const TextStyle(
                                    fontWeight: FontWeight.w700,
                                    fontSize: 16,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  box.get('owner')[0]["name"] ?? "",
                                  style: TextStyle(
                                    color: Colors.grey.shade600,
                                  ),
                                ),
                              ],
                            ),
                          ),

                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: Colors.green.shade50,
                              borderRadius: BorderRadius.circular(30),
                            ),
                            child: Icon(
                              Icons.check_circle,
                              color: Colors.green.shade600,
                              size: 22,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              ),

              const SizedBox(height: 24),

              /// Search
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20),
                child: StatefulBuilder(
                  builder: (context, setState) {
                    return Material(
                      elevation: 2,
                      borderRadius: BorderRadius.circular(18),
                      shadowColor: Colors.black12,
                      child: TextField(
                        decoration: InputDecoration(
                          hintText: "Search company or phone...",
                          prefixIcon: const Icon(Icons.search),
                          filled: true,
                          fillColor: Colors.white,
                          border: OutlineInputBorder(
                            borderRadius:
                            BorderRadius.circular(18),
                            borderSide: BorderSide.none,
                          ),
                        ),
                        onChanged: (text) async {
                          if (int.tryParse(text) != null) {
                            searchValOption = true;
                            phoneNumber = text;
                          } else {
                            searchValOption = true;
                            phoneNumber = "none";
                            searchName = text;
                          }

                          setState(() {});
                          await getUserData();
                        },
                      ),
                    );
                  },
                ),
              ),

              const SizedBox(height: 24),

              /// Section Title
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 24),
                child: Row(
                  children: [
                    Text(
                      "Available Accounts",
                      style: TextStyle(
                        color: Colors.grey.shade700,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 12),

              Expanded(
                child: GetBuilder<StockQuery>(
                  builder: (controller) {
                    if (controller.compPick.isEmpty) {
                      return Center(
                        child: Column(
                          mainAxisAlignment:
                          MainAxisAlignment.center,
                          children: [
                            Icon(
                              Icons.search_off_rounded,
                              size: 60,
                              color: Colors.grey.shade400,
                            ),
                            const SizedBox(height: 12),
                            Text(
                              "No accounts found",
                              style: TextStyle(
                                color: Colors.grey.shade600,
                                fontSize: 16,
                              ),
                            ),
                          ],
                        ),
                      );
                    }

                    return ListView.separated(
                      padding: const EdgeInsets.fromLTRB(
                          20, 0, 20, 20),
                      itemCount: controller.compPick.length,
                      separatorBuilder: (_, __) =>
                      const SizedBox(height: 12),
                      itemBuilder: (context, index) {
                        final item = controller.compPick[index];

                        return Material(
                          color: Colors.white,
                          elevation: .5,
                          borderRadius:
                          BorderRadius.circular(18),
                          child: InkWell(
                            borderRadius:
                            BorderRadius.circular(18),
                            onTap: () async {
                              Get.put(StockQuery())
                                  .updateHideLoader(false);
                              Get.back();
                              await switchAccount(
                                item["uid"].toString(),
                                item["password"].toString(),
                              );
                            },
                            child: Padding(
                              padding:
                              const EdgeInsets.all(16),
                              child: Row(
                                children: [
                                  Container(
                                    width: 50,
                                    height: 50,
                                    decoration: BoxDecoration(
                                      color: Colors.blue
                                          .withOpacity(.08),
                                      borderRadius:
                                      BorderRadius
                                          .circular(15),
                                    ),
                                    child: Icon(
                                      Icons.business,
                                      color:
                                      Colors.blue.shade700,
                                    ),
                                  ),

                                  const SizedBox(width: 16),

                                  Expanded(
                                    child: Column(
                                      crossAxisAlignment:
                                      CrossAxisAlignment
                                          .start,
                                      children: [
                                        Text(
                                          item["companyName"] ??
                                              "",
                                          style:
                                          const TextStyle(
                                            fontWeight:
                                            FontWeight.w700,
                                            fontSize: 16,
                                          ),
                                        ),
                                        const SizedBox(
                                            height: 4),
                                        Text(
                                          item["name"] ?? "",
                                          style: TextStyle(
                                            color: Colors
                                                .grey.shade600,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),

                                  Icon(
                                    Icons
                                        .arrow_forward_ios_rounded,
                                    size: 16,
                                    color:
                                    Colors.grey.shade400,
                                  ),
                                ],
                              ),
                            ),
                          ),
                        );
                      },
                    );
                  },
                ),
              ),
            ],
          ),
        ),
      ),
      isScrollControlled: true,
    );
  }
  void viewPromo(Map<String, dynamic> apiResponse) {
    // Extract list from response safely
    final List<dynamic> promos = apiResponse['result'] ?? [];

    // Pool of random colors and icons to pick from
    final List<Color> randomColors = [
      Colors.orange,
      Colors.blue,
      Colors.green,
      Colors.purple,
      Colors.teal,
      Colors.deepOrange,
    ];

    final List<IconData> randomIcons = [
      Icons.local_offer,
      Icons.local_shipping,
      Icons.account_balance_wallet,
      Icons.card_giftcard,
      Icons.stars,
      Icons.flash_on,
    ];

    final Random random = Random();

    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return Container(
            height: MediaQuery.of(context).size.height * 0.65,
            decoration: const BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Drag Handle
                Center(
                  child: Container(
                    width: 40,
                    height: 4,
                    margin: const EdgeInsets.only(bottom: 16),
                    decoration: BoxDecoration(
                      color: Colors.grey[300],
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                ),

                const Text(
                  'Available Promotions',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 12),

                // Empty List Fallback
                if (promos.isEmpty)
                  const Expanded(
                    child: Center(
                      child: Text(
                        'No promotions available.',
                        style: TextStyle(color: Colors.grey),
                      ),
                    ),
                  )
                else
                // Promotions List
                  Expanded(
                    child: ListView.builder(
                      itemCount: promos.length,
                      physics: const BouncingScrollPhysics(),
                      itemBuilder: (context, index) {
                        final promo = promos[index];

                        // Assign random color and icon per item
                        final Color badgeColor =
                        randomColors[random.nextInt(randomColors.length)];
                        final IconData icon =
                        randomIcons[random.nextInt(randomIcons.length)];

                        // Extract fields from API payload
                        final String promoUid =
                            promo['uid'] ?? 'promo_7G_1785491870';
                        final String promoName =
                            promo['promoName'] ?? 'Vega Promotion';

                        // Mapped values based on request
                        final String badgeText = promoUid;
                        final String title = promoName.toUpperCase();
                        const String subtitle =
                            'Get special rewards and exclusive discounts when you complete this promo.';
                        // const String buttonText = 'Apply';
                        const String buttonText = 'Claim';

                        return Card(
                          elevation: 0,
                          color: Colors.grey[50],
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(16),
                            side: BorderSide(color: Colors.grey.shade200),
                          ),
                          child: Padding(
                            padding: const EdgeInsets.all(12),
                            child: Row(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                CircleAvatar(
                                  radius: 20,
                                  backgroundColor: badgeColor.withOpacity(0.1),
                                  child: Icon(icon, color: badgeColor, size: 20),
                                ),
                                const SizedBox(width: 12),
                                Expanded(
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      // Badge showing UID
                                      Container(
                                        padding: const EdgeInsets.symmetric(
                                          horizontal: 6,
                                          vertical: 2,
                                        ),
                                        decoration: BoxDecoration(
                                          color: badgeColor.withOpacity(0.15),
                                          borderRadius: BorderRadius.circular(4),
                                        ),
                                        child: Text(
                                          badgeText,
                                          style: TextStyle(
                                            color: badgeColor,
                                            fontSize: 10,
                                            fontWeight: FontWeight.bold,
                                          ),
                                        ),
                                      ),
                                      const SizedBox(height: 4),

                                      // Promotion Name
                                      Text(
                                        title,
                                        style: const TextStyle(
                                          fontWeight: FontWeight.bold,
                                          fontSize: 14,
                                        ),
                                      ),
                                      const SizedBox(height: 2),

                                      // Dummy Description
                                      Text(
                                        subtitle,
                                        style: TextStyle(
                                          color: Colors.grey[600],
                                          fontSize: 12,
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                                const SizedBox(width: 8),

                                // Right Side Buttons
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.end,
                                  mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                                  children: [
                                    // Top-Right Button (Info/Details)
                                    InkWell(
                                      onTap: () {
                                        // Action for info tap
                                      },
                                      borderRadius: BorderRadius.circular(12),
                                      child: Padding(
                                        padding: const EdgeInsets.all(4.0),
                                        child: Icon(
                                          Icons.info_outline,
                                          size: 18,
                                          color: Colors.grey[500],
                                        ),
                                      ),
                                    ),

                                    const SizedBox(height: 16),

                                    // Bottom-Right Button (Apply Action)
                                    ElevatedButton(
                                      onPressed: () {
                                        //debugPrint("Applied Promo UID: $promoUid");
                                        //

                                        viewPromotions(promos[index]);
                                      },
                                      style: ElevatedButton.styleFrom(
                                        elevation: 0,
                                        padding: const EdgeInsets.symmetric(
                                          horizontal: 12,
                                          vertical: 8,
                                        ),
                                        minimumSize: Size.zero,
                                        tapTargetSize:
                                        MaterialTapTargetSize.shrinkWrap,
                                        shape: RoundedRectangleBorder(
                                          borderRadius: BorderRadius.circular(10),
                                        ),
                                      ),
                                      child: const Text(
                                        buttonText,
                                        style: TextStyle(fontSize: 12),
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        );
                      },
                    ),
                  ),
              ],
            ),
          );
        },
      ),
    ).whenComplete(() {});
  }
  withdraw(String userid,String promoData) async
  {
    ConstantClassUtil().showLoadingDialog(message: "Processing Withdraw...");
    var response= await PromotionQData().withdrawLongPromo(
        QuickBonus(
            uid: userid,
            bonusValue: promoData
        )
    );
    if (response != null && response.data!= null) {
      if(response.data["status"])
      {
        ConstantClassUtil().hideLoadingDialog();


      }else{

        ConstantClassUtil().hideLoadingDialog();
      }

    }else{

      ConstantClassUtil().hideLoadingDialog();
    }
  }
  void viewPromotions(Map<String, dynamic> promoData) {
    // Use the passed promo directly – no outer 'result' envelope needed.
    // All fields are taken from this map.
    final String promoCode =
        promoData['promoName']?.toString().toUpperCase() ?? "PROMO";
    final String promoUid = promoData['uid']?.toString() ?? '';

    // Parse thresholds and current input totals
    final double condCount =
        double.tryParse(promoData['condCount']?.toString() ?? '0') ?? 0;
    final double condTotal =
        double.tryParse(promoData['condTotal']?.toString() ?? '0') ?? 0;
    final double cCount =
        double.tryParse(promoData['cCount']?.toString() ?? '0') ?? 0;
    final double cTotal =
        double.tryParse(promoData['cTotal']?.toString() ?? '0') ?? 0;

    final String countCondition =
        promoData['countCondition']?.toString() ?? 'cCount';

    // 1. Calculate Multiplier
    int multiplier = 0;
    if (countCondition == 'cCount') {
      if (condCount > 0) multiplier = (cCount / condCount).floor();
    } else if (countCondition == 'cTotal') {
      if (condTotal > 0) multiplier = (cTotal / condTotal).floor();
    } else if (countCondition == 'both') {
      if (condCount > 0 && condTotal > 0) {
        int countMultiplier = (cCount / condCount).floor();
        int totalMultiplier = (cTotal / condTotal).floor();
        multiplier = min(countMultiplier, totalMultiplier);
      }
    }

    // 2. Calculate remaining balances
    int remaincCount = 0, remaincTotal = 0;
    if (countCondition == 'cCount') {
      remaincCount = (cCount - (multiplier * condCount)).toInt();
      remaincTotal = cTotal.toInt();
    } else if (countCondition == 'cTotal') {
      remaincCount = cCount.toInt();
      remaincTotal = (cTotal - (multiplier * condTotal)).toInt();
    } else if (countCondition == 'both') {
      remaincCount = (cCount - (multiplier * condCount)).toInt();
      remaincTotal = (cTotal - (multiplier * condTotal)).toInt();
    }

    // 3. Calculate Total Bonus Amount
    final double baseBonusAmount =
        double.tryParse(promoData['bonusAmount']?.toString() ?? '0') ?? 0.0;
    final double totalBonusAmount = baseBonusAmount * multiplier;

    // 4. Parse bonusStocks
    final List<Map<String, String>> freeProducts = [];
    final List<Map<String, dynamic>> itemsBonusPayload = [];
    const List<String> availableIcons = ['✨', '🛍️', '🧴', '🎁', '⭐', '📦', '🎉'];
    final Random random = Random();

    String? bonusStocksRaw = promoData['bonusStocks'];
    if (multiplier > 0 && bonusStocksRaw != null && bonusStocksRaw.isNotEmpty) {
      try {
        List<dynamic> parsedStocks = jsonDecode(bonusStocksRaw);
        for (var item in parsedStocks) {
          int baseQty = int.tryParse(item['qty']?.toString() ?? '0') ?? 0;
          int finalQty = baseQty * multiplier;
          String name = item['productName']?.toString() ?? 'Product';
          String randomIcon = availableIcons[random.nextInt(availableIcons.length)];

          itemsBonusPayload.add({
            'productName': name,
            'qty': finalQty,
          });

          freeProducts.add({
            'productName': name,
            'qty': finalQty.toString(),
            'icon': randomIcon,
          });
        }
      } catch (e) {
        debugPrint("Error parsing bonusStocks: $e");
      }
    }

    // Create output payload object
    final Map<String, dynamic> resultPayload = {
      "uid": promoUid,
      "countCondition": countCondition,
      "remaincCount": remaincCount.toString(),
      "remaincTotal": remaincTotal.toString(),
      "TotalBonus": totalBonusAmount.toInt().toString(),
      "itemsBonus": itemsBonusPayload,
    };

    // ---------- Bottom Sheet UI (unchanged except for using local variables) ----------
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          final theme = Theme.of(context);
          return Container(
            decoration: BoxDecoration(
              color: theme.scaffoldBackgroundColor,
              borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Drag Handle
                Center(
                  child: Container(
                    width: 40,
                    height: 4,
                    decoration: BoxDecoration(
                      color: Colors.grey.shade300,
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                ),
                const SizedBox(height: 20),

                // Header
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Promotions',
                      style: theme.textTheme.titleLarge?.copyWith(
                        fontWeight: FontWeight.bold,
                        letterSpacing: -0.5,
                      ),
                    ),
                    IconButton(
                      onPressed: () => Get.back(),
                      icon: const Icon(Icons.close_rounded, size: 20),
                      visualDensity: VisualDensity.compact,
                    ),
                  ],
                ),
                const SizedBox(height: 16),

                // Savings Card
                Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: [
                        theme.primaryColor.withOpacity(0.08),
                        theme.primaryColor.withOpacity(0.02),
                      ],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(
                      color: theme.primaryColor.withOpacity(0.2),
                    ),
                  ),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(10),
                        decoration: BoxDecoration(
                          color: theme.primaryColor.withOpacity(0.15),
                          shape: BoxShape.circle,
                        ),
                        child: Icon(
                          Icons.local_offer_outlined,
                          color: theme.primaryColor,
                          size: 22,
                        ),
                      ),
                      const SizedBox(width: 14),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Code: $promoCode',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.w600,
                                color: theme.primaryColor,
                              ),
                            ),
                            const SizedBox(height: 2),
                            const Text(
                              'Total Discount',
                              style: TextStyle(
                                fontSize: 14,
                                color: Colors.grey,
                              ),
                            ),
                          ],
                        ),
                      ),
                      Text(
                        '-\$${totalBonusAmount.toStringAsFixed(2)}',
                        style: theme.textTheme.headlineSmall?.copyWith(
                          fontWeight: FontWeight.bold,
                          color: theme.primaryColor,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 24),

                // Free Products Section
                if (freeProducts.isNotEmpty) ...[
                  Row(
                    children: [
                      Text(
                        'Free Gifts Unlocked',
                        style: theme.textTheme.titleMedium?.copyWith(
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      const SizedBox(width: 8),
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 8,
                          vertical: 2,
                        ),
                        decoration: BoxDecoration(
                          color: Colors.amber.shade100,
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Text(
                          '${freeProducts.length}',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.bold,
                            color: Colors.amber.shade900,
                          ),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),

                  Flexible(
                    child: ListView.separated(
                      shrinkWrap: true,
                      itemCount: freeProducts.length,
                      separatorBuilder: (_, __) => const SizedBox(height: 8),
                      itemBuilder: (context, index) {
                        final item = freeProducts[index];
                        return Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 14,
                            vertical: 10,
                          ),
                          decoration: BoxDecoration(
                            color: theme.cardColor,
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(
                              color: Colors.grey.withOpacity(0.15),
                            ),
                          ),
                          child: Row(
                            children: [
                              Text(
                                item['icon'] ?? '🎁',
                                style: const TextStyle(fontSize: 22),
                              ),
                              const SizedBox(width: 12),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      item['productName'] ?? '',
                                      style: const TextStyle(
                                        fontWeight: FontWeight.w600,
                                        fontSize: 14,
                                      ),
                                    ),
                                    Text(
                                      'Qty: ${item['qty'] ?? '1'}',
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: Colors.grey.shade600,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              Container(
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 10,
                                  vertical: 4,
                                ),
                                decoration: BoxDecoration(
                                  color: Colors.green.shade50,
                                  borderRadius: BorderRadius.circular(20),
                                ),
                                child: Text(
                                  'FREE',
                                  style: TextStyle(
                                    color: Colors.green.shade700,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 11,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        );
                      },
                    ),
                  ),
                ],

                const SizedBox(height: 24),

                // Got It Button
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      elevation: 0,
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    onPressed: () async{
                      const JsonEncoder encoder = JsonEncoder.withIndent('  ');
                      final String formattedJson = encoder.convert(resultPayload);
                      //debugPrint(formattedJson);
                      final String userid=promoData['uidUser'];
                      await withdraw(userid,formattedJson);
                      //Get.back();
                    },
                    child: const Text(
                      //'Got It',
                      'Withdraw',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                ),
                const SizedBox(height: 10),
              ],
            ),
          );
        },
      ),
      isScrollControlled: true,
    );
  }
  void searchUser(BuildContext context) {
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return SingleChildScrollView(
            child: Container(
              padding: const EdgeInsets.all(5.0),
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
                  //const Center(child: Text("Client:Name")),
                  Container(
                    margin: const EdgeInsets.fromLTRB(10, 20, 10, 10),
                    child: TextField(
                      decoration: InputDecoration(
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(50.0),
                        ),
                        labelText: 'Search',
                      ),
                      onChanged: (text) async {
                        if ((int.tryParse(text) != null)) {
                          setState(() {
                            searchValOption = true;
                            phoneNumber = text;
                          });
                          await getUserData();
                        } else {
                          setState(() {
                            searchName = text;
                            searchValOption = true;
                            phoneNumber = "none";
                          });
                          await getUserData();
                        }
                      },
                    ),
                  ),

                  GetBuilder<StockQuery>(
                      builder: (myController) {
                        return   Expanded(
                          child: ListView.separated(
                            shrinkWrap: true,
                            itemCount: myController.usersPick.length + 1,
                            separatorBuilder: (context, index) => const Divider(height: 1.0),
                            itemBuilder: (context, index) {
                              if (index < myController.usersPick.length) {
                                return Card(
                                  margin: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
                                  child: InkWell(
                                    onTap: () async{
                                      bool isSuccess = await updatePickedUser(myController.usersPick[index]);
                                      if(isSuccess)
                                      {
                                        if(cartData.length>0) {
                                          cartDisplay();
                                        }else{
                                          //Get.back();
                                        }
                                      }else{
                                        print("something wrong and fish");
                                      }
                                    },
                                    child: ListTile(
                                      leading: CircleAvatar(
                                        backgroundColor: getRandomColor(),
                                        child: Icon(_getRandomIcon()),
                                      ),
                                      title: Text(myController.usersPick[index]["name"]),
                                      subtitle: Text((myController.usersPick[index]["PhoneNumber"]).split('_').first),
                                      trailing: IconButton(
                                        icon: const Icon(Icons.add),
                                        iconSize: 23.0,
                                        color: Colors.blue,
                                        onPressed: () async {

                                          bool isSuccess = await updatePickedUser(myController.usersPick[index]);
                                          if(isSuccess)
                                          {
                                            cartDisplay();
                                          }else{
                                            print("something wrong and fish");
                                          }
                                        },
                                      ),
                                    ),
                                  ),
                                );
                              } else {
                                return Container();
                              }
                            },
                          ),
                        );
                      }),


                ],
              ),
            ),
          );
        },
      ),
    ).whenComplete(() {
      // Do whatever you want after closing the bottom sheet
    });
  }



  getUserData() async{
    //FocusManager.instance.primaryFocus?.unfocus();

    setState(() {
      showOver=true;
    });
    //(Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await StockQuery().searchUser(User(uid:"",name:searchName,phone:phoneNumber,platform:"4000",status:"offNotPick"),Topups(optionCase:"false",startlimit:limitData,searchOption:searchValOption,sortOrder:"ASC"))).data;

    if(resultData["status"])
    {

      (Get.put(StockQuery()).updateHideLoader(true));

      if(resultData["result"]!=0)
      {

        setState(() {
          showOver=false;
          //users.clear();
          //users.addAll(resultData["result"]);
          (Get.put(StockQuery()).updateusersPick(resultData["result"]));

        });
        // print(users);
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

                              },viewPictureMethod:(productCode,imgUrl){
                                viewPicture(productCode,imgUrl);

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

  Future<bool> updatePickedUser(Map<String, dynamic> thisUser) async {

    ConstantClassUtil().showLoadingDialog(message: "Change Client");
    Get.put(StockQuery()).updateHideLoader(false);

    if (((Get.put(StockQuery()).order)["resultData"][0]["uid"]) == "none") {
      var userProfile = {
        "uid": "${thisUser["uid"]}",
        "name": "${thisUser["name"]}",
        "email": "on@gmail.com",
        "phone": "782389359",
        "Ccode": "+250",
        "country": "Rwanda",
        "initCountry": "none",
        "marital_status": "${thisUser["marital_status"]}",
        "PhoneNumber": "${thisUser["PhoneNumber"]}",
        "carduid": "none"
      };

      Get.put(StockQuery()).updateUserProfile(userProfile);
      setState(() {
        (Get.put(StockQuery()).order)["resultData"][0]["name"] = userProfile["name"];
        (Get.put(StockQuery()).order)["resultData"][0]["myphone"] = thisUser["PhoneNumber"];
      });


      ConstantClassUtil().hideLoadingDialog();

      Future.microtask(() {
        Navigator.of(context).pop();
      });

      return true; // Return true on success
    } else {
      var resultData = (await StockQuery().updateInOrder(
        QuickBonus(
          uid: "${(Get.put(StockQuery()).order)["resultData"][0]["uid"]}",
          productName: "productCode",
          description: "comment",
          status: "UpdateUserInOrder",
        ),
        Participated(uidUser: "${thisUser["uid"]}", status: 'Default'),
      )).data;

      if (resultData["status"]) {
        var userProfile = {
          "uid": "${thisUser["uid"]}",
          "name": "${thisUser["name"]}",
          "email": "on@gmail.com",
          "phone": "782389359",
          "Ccode": "+250",
          "country": "Rwanda",
          "initCountry": "none",
          "marital_status": "${thisUser["marital_status"]}",
          "PhoneNumber": "${thisUser["PhoneNumber"]}",
          "carduid": "none"
        };

        setState(() {
          Get.put(StockQuery()).updateUserProfile(userProfile);
          (Get.put(StockQuery()).order)["resultData"][0]["name"] = userProfile["name"];
          (Get.put(StockQuery()).order)["resultData"][0]["myphone"] = thisUser["PhoneNumber"];
        });

        //applyPromotion();
        ConstantClassUtil().hideLoadingDialog();

        Future.microtask(() {
          Navigator.of(context).pop();
        });

        return true; // Return true on success
      } else {
        // Handle error path
        ConstantClassUtil().hideLoadingDialog();
        return false;
      }
    }


    return false; // Return false if getPromotion() returns false
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
    super.key,
    required this.searchMethod,
    required this.scanProductMethod,
    required this.searchController,
    required this.searchBy,
  });

  final void Function(String) searchMethod;
  final void Function() scanProductMethod;
  final TextEditingController searchController;
  final void Function(String) searchBy;


  @override
  Widget build(BuildContext context) {
    // Default selected option

    List<String> dropdownOptions = ['Name', 'Code'];
    return Container(
      margin: const EdgeInsets.fromLTRB(5, 7, 5, 0),
      child: TextField(
        controller: searchController,
        decoration: InputDecoration(
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(50.0),
          ),

          prefixIcon: Padding(
            padding: const EdgeInsets.fromLTRB(15, 0, 0, 0),
            child: DropdownButtonHideUnderline(
              child: DropdownButton<String>(
                value:(Get.put(StockQuery()).selectedOption),
                onChanged: (newValue) {
                  //(Get.put(StockQuery()).updateSelected(newValue));
                  searchBy(newValue!);
                },
                items: dropdownOptions.map((option) {
                  return DropdownMenuItem(
                    value: option,
                    child: Text(option),
                  );
                }).toList(),
              ),
            ),
          ),
          labelText: 'Search By',

          labelStyle: const TextStyle(color: Colors.black), // Customize label color
          floatingLabelBehavior: FloatingLabelBehavior.always,


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
    super.key,
    required this.addCartMethod,
    required this.searchResult,
    required this.viewPictureMethod,
  });

  final void Function(dynamic) addCartMethod;
  final void Function(String, String) viewPictureMethod;
  final dynamic searchResult;

  @override
  Widget build(BuildContext context) {
    // Create a FocusNode for each item (list length + 1, but we only need for actual items)
    final List<FocusNode> focusNodes = List.generate(
      searchResult.length,
          (index) => FocusNode(),
    );

    return ListView.builder(
      padding: EdgeInsets.zero,
      itemCount: searchResult.length + 1,
      itemBuilder: (context, index) {
        if (index < searchResult.length) {
          searchResult[index]['req_qty'] = "1";
          searchResult[index]['name'] = "none";

          return Container(
            margin: const EdgeInsets.fromLTRB(5,2, 5, 2),
            child: Card(
              margin: EdgeInsets.zero,

              elevation: 0,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(9.0),
              ),
              child: Column(
                children: [
                  ListTile(
                    leading: CircleAvatar(
                      backgroundColor: getRandomColor(),
                      child: Icon(_getRandomIcon()),
                    ),
                    title: Row(
                      children: [
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              InkWell(
                                onTap: (){
                                  PricingBottomSheet.show(
                                    productCode: "${searchResult[index]["productCode"]}",
                                    cartonPrice: double.parse(searchResult[index]["price"]),
                                    pcsInCarton: int.parse(searchResult[index]["pcs"])??0,
                                    defaultMargin: 5.0, // Easily change default margin per item
                                    currencySymbol: "\$", // Support different currencies
                                    onConfirm: (quantity, totalPrice, totalProfit) {
                                      // This runs when the user clicks "Confirm & Add"
                                     /* print("User wants $quantity pieces.");
                                      print("Total charge: €$totalPrice");
                                      print("Total profit: €$totalProfit");*/
                                      // 1. Grab the active CartController instance
                                      final cartController = Get.find<CartController>();

                                      // 2. Build the CartItem with your dynamic data
                                      final cartItem = CartItem(
                                        productCode: "${searchResult[index]["productCode"]}",
                                        quantity: quantity,
                                        pricePerPiece: quantity > 0 ? (totalPrice / quantity) : 0.0,
                                        totalPrice: totalPrice,
                                        totalProfit: totalProfit,
                                        cartonCostPrice: double.tryParse("${searchResult[index]["price"]}") ?? 0.0,
                                        pcsInCarton: int.tryParse("${searchResult[index]["pcs"]}") ?? 0,
                                        marginPerCarton: 5.0,
                                      );

                                      // 3. Add it to the cart (this instantly triggers the FloatingCartBar to update and appear)
                                      cartController.addItem(cartItem);

                                      // Example: myCartController.addItem(productCode, quantity, totalPrice);
                                    },
                                  );
                                },
                                child: RichText(
                                  text: TextSpan(
                                    text: "${searchResult[index]["productCode"]} (${searchResult[index]["pcs"]} pcs):",
                                    style: DefaultTextStyle.of(context).style,
                                    children: <TextSpan>[
                                      TextSpan(
                                        text: " 1X${searchResult[index]["price"]}",
                                        style: const TextStyle(color: Colors.blue),
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                              Text.rich(
                                TextSpan(
                                  children: [
                                    // Make the "Qty :" text tappable
                                    WidgetSpan(
                                      child: GestureDetector(
                                        onTap: () {
                                          // Request focus on the corresponding TextField
                                          FocusScope.of(context).requestFocus(focusNodes[index]);
                                        },
                                        child: const Text(
                                          'Qty : ',
                                          style: TextStyle(
                                            decoration: TextDecoration.underline,
                                            color: Colors.blue,
                                          ),
                                        ),
                                      ),
                                    ),
                                    WidgetSpan(
                                      child: IntrinsicWidth(
                                        stepWidth: 0.5,
                                        child: TextField(
                                          focusNode: focusNodes[index], // Attach FocusNode
                                          keyboardType: TextInputType.number,
                                          decoration: const InputDecoration(
                                            hintText: '-1-',
                                            hintStyle: TextStyle(color: Colors.blue),
                                            contentPadding: EdgeInsets.all(0),
                                            isDense: true,
                                          ),
                                          style: const TextStyle(
                                            color: Colors.blue,
                                          ),
                                          onChanged: (text) {
                                            final value = int.tryParse(text);
                                            if (value != null && value > 0) {
                                              searchResult[index]['req_qty'] = text;
                                              searchResult[index]['totalQty'] = text;
                                              searchResult[index]['totalAmount'] =
                                                  double.parse(searchResult[index]['price']) *
                                                      double.parse(text);
                                              searchResult[index]['totalCount'] = text;
                                              (Get.put(StockQuery()).updateHideaddCart(false));
                                            } else {
                                              (Get.put(StockQuery()).updateHideaddCart(true));
                                            }
                                          },
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              const SizedBox(height: 5),
                              Text("Qty left:${num.parse(searchResult[index]["qty"]) - num.parse(searchResult[index]["qty_sold"])}"),
                            ],
                          ),
                        ),
                      ],
                    ),
                    subtitle: Wrap(
                      children: [
                        const Icon(Icons.segment, color: Colors.orange, size: 13),
                        Text("tags:${searchResult[index]["ProductName"]} "),
                      ],
                    ),
                    trailing: Column(
                      children: [
                        Row(
                          mainAxisSize: MainAxisSize.min,
                          children: <Widget>[
                            GetBuilder<StockQuery>(
                              builder: (myLoadercontroller) {
                                return myLoadercontroller.hideaddCart
                                    ? const Text("")
                                    : IconButton(
                                  icon: const Icon(Icons.add_shopping_cart,
                                      size: 23.0, color: Colors.grey),
                                  onPressed: () async {
                                    myLoadercontroller.updateReqProductData(searchResult[index]);
                                    addCartMethod(searchResult[index]);
                                  },
                                );
                              },
                            ),
                            const Visibility(visible: true, child: Text("")),
                            IconButton(
                              icon: const Icon(Icons.grid_view, size: 23.0, color: Colors.orange),
                              onPressed: () {
                                viewPictureMethod(
                                    searchResult[index]["productCode"],
                                    searchResult[index]["img_url"]);
                              },
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          );
        } else {
          return const SizedBox.shrink();
        }
      },
    );
  }

  // Remember to dispose FocusNodes to avoid memory leaks
  @override
  void dispose() {
    // This is a StatelessWidget, so we can't override dispose.
    // If you convert to StatefulWidget, you can dispose the focus nodes.
    // Alternatively, manage them outside and pass them in.
  }
}


class CheckoutPage extends StatelessWidget {
  const CheckoutPage({
    super.key,
    required this.chekoutResult,
    required this.changeQtyCheckout,
    required this.saveChangeQtyCheckout,
    required this.deleteCheckout,
    required this.addcomentCheckout, required this.viewPictureM,
    required this.focusNodes,
    required this.getFocusCheckout,
  });

  final dynamic chekoutResult;
  final void Function(String,String) viewPictureM;
  final void Function(int,double,double,bool,int) changeQtyCheckout;

  final void Function(String,int,String) saveChangeQtyCheckout;
  final void Function(String) deleteCheckout;
  final void Function(String,String) addcomentCheckout;
  final Map<String, FocusNode> focusNodes;
  final Function(String) getFocusCheckout;


  @override
  Widget build(BuildContext context) {


    return ListView.builder(
      padding: EdgeInsets.zero,

      itemCount: chekoutResult.length+1,
      itemBuilder: (context, index) {

        if(index<chekoutResult.length)
        {
          if (chekoutResult[index].containsKey("old_qty")) {

          }
          else{
            chekoutResult[index]["old_qty"] = chekoutResult[index]["totalQty"] is int
                ? chekoutResult[index]["totalQty"]
                : int.parse(chekoutResult[index]["totalQty"].toString());

          }

          return Stack(
            children: [
              Container(

                margin: const EdgeInsets.fromLTRB(0, 0, 0, 0),
                child: Card(
                  margin: EdgeInsets.zero,
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
                          leading: GestureDetector(
                            onTap: (){
                              viewPictureM(chekoutResult[index]["productCode"],chekoutResult[index]["img_url"]);
                            },
                            child: CircleAvatar(
                              backgroundColor:getRandomColor(),
                              child: Icon(_getRandomIcon()),
                            ),
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
                                                    focusNode: getFocusCheckout(chekoutResult[index]["productCode"]),
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
                                                      //chekoutResult[index]["old_qty"]=int.parse(chekoutResult[index]["totalQty"]);

                                                      (Get.put(StockQuery()).updateResizable(true));
                                                      if((int.tryParse(text) != null) && (int.tryParse(text)!=0)){
                                                        if(int.parse(text)>0)
                                                        {
                                                          //String qtyDa=text.
                                                          //print("${(chekoutResult[index]["price"]).runtimeType} ${(chekoutResult[index]["totalQty"]).runtimeType} ${text.runtimeType}");


                                                          double price=double.parse(chekoutResult[index]["price"]);
                                                          double qtyEdit=double.parse(text);
                                                          // double oldqty=double.parse(chekoutResult[index]["old_qty"]);
                                                          changeQtyCheckout(index,price,qtyEdit,false,chekoutResult[index]["old_qty"]);
                                                          // changeQtyCheckout(index,(int.parse(chekoutResult[index]["price"])),(int.parse(text)),false,chekoutResult[index]["old_qty"]);

                                                        }



                                                      }else{
                                                        changeQtyCheckout(index,1,1,true,chekoutResult[index]["old_qty"]);
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
                                        //print("checkout");
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


class UserCard extends StatelessWidget {
  final String name;
  final double price;

  const UserCard({
    super.key,
    required this.name,
    required this.price,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      child: Card(
        elevation: 4,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        child: Padding(
          padding: const EdgeInsets.all(0),
          child: Column(
            children: [
              // Drag indicator
              Container(
                height: 4,
                width: 40,
                margin: const EdgeInsets.only(bottom: 16),
                decoration: BoxDecoration(
                  color: Colors.grey[400],
                  borderRadius: BorderRadius.circular(2),
                ),
              ),

              ListTile(
                leading: const Icon(Icons.person, color: Colors.blue),
                title: Text(
                  name,
                  style: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                subtitle: const Text("Name"),
              ),

              const Divider(),

              ListTile(
                leading:
                const Icon(Icons.monetization_on, color: Colors.orange),
                title: Text(
                  price.toString(),
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                subtitle: const Text("Price"),
              ),

              Align(
                alignment: Alignment.centerRight,
                child: ElevatedButton(
                  onPressed: () => Get.back(),
                  child: const Text("Close"),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}








