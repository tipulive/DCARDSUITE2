import 'dart:convert';
import 'dart:math';


import '../../../Query/ParticipatedQuery.dart';
import '../../../Utilconfig/HideShowState.dart';
import '../../../models/QuickBonus.dart';

import '../../../models/Topups.dart';
import '../../../models/User.dart';
import 'package:get/get.dart';

import '../../Query/AdminQuery.dart';
import '../../Query/CardQuery.dart';
import '../../Query/StockQuery.dart';
import '../../Utilconfig/image_card_widget.dart';
import '../../models/BonusModel.dart';
import 'package:flutter/material.dart';
import 'package:qr_code_scanner/qr_code_scanner.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/CardModel.dart';
import '../../../Utilconfig/ConstantClassUtil.dart';





class SetOrderComp extends StatefulWidget {
  const SetOrderComp({super.key});

  @override
  State<SetOrderComp> createState() => _SetOrderCompState();
}

class _SetOrderCompState extends State<SetOrderComp> {

  final ScrollController _scrollController = ScrollController();// detect scroll
  final List<dynamic> _data = [];
  List<dynamic> thisListOrder = [];
  List<dynamic> orderData = [];


  TextEditingController qtychange=TextEditingController();
  var bottomResult=[];
  num countData=0;

  int _page=0;
  int limit=0;
  bool hasMoreData=true;
  bool isLoading=false;
  num qtyProduct=1;
  String productCode="";

  String clientOrder="";
  String orderId="";
  String uidTransport="UidTransport";
  String productExist="true";

  bool isButtonDisabled =true;



  bool showOveray=false;


  final GlobalKey qrkey = GlobalKey(debugLabel: '${UniqueKey()}');
  Barcode?result;
  QRViewController?controller;
  List<dynamic>qrDebt = [];
  bool cameraValue=false;
  bool flashValue=false;



  @override
  Widget build(BuildContext context) {



    //return listdata();

    /*WidgetsBinding.instance.addPostFrameCallback((_) {

      QuickBonus();
    });*/
    return Stack(
      children: [
        listdata(),
        if(showOveray)
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
    );
    //return Center(child: Text("hello"));




  }
  Widget listdata(){
    return  Column(
      children: [
        //ProfilePic().profile(),

        Text("Orders",style:GoogleFonts.pacifico(fontSize:15,color: Colors.teal,fontWeight: FontWeight.w700)),


        Padding(
          padding:const EdgeInsets.fromLTRB(8,10,8,0),
          child: Card(
            elevation:0,
            margin: const EdgeInsets.symmetric(vertical:1,horizontal:5),
            color:Colors.white,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(15.0),
              //side: BorderSide(color:_data[0]["color_var"]??true?Colors.white:Colors.green, width: 2),
            ),

            child: ListTile(
              leading: CircleAvatar(
                backgroundColor:getRandomColor(),
                child: Icon(_getRandomIcon()),
              ),
              title:const Row(
                children: [


                  Expanded(
                    flex: 1,
                    child: Stack(
                      children: [




                      ],
                    ),
                  ),
                ],
              ),

              subtitle: const Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [

                ],
              ),
              trailing:PopupMenuButton(
                itemBuilder:(container)=>[
                  PopupMenuItem(
                      child: InkWell(
                        onTap: () async{
                         /* setState(() {
                            advancedSearch="today";
                            viewTitle="today";

                          });
                          await viewData('test',"false");*/

                        },
                        child: const Column(
                          children: [
                            SizedBox(
                              height: 10,
                            ),
                            Row(
                              children: [
                                Icon(
                                  Icons.today,
                                  color: Colors.blue,
                                ),
                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("Today"),
                                ),

                              ],
                            ),
                            Divider(
                              height: 20, // Adjust the height as needed
                              thickness: 0.2, // Adjust the thickness as needed
                              color: Colors.grey,
                            ),

                          ],
                        ),
                      )
                  ),
                  PopupMenuItem(
                      child: InkWell(
                        onTap: () async{
                          /*setState(() {
                            advancedSearch="week";
                            viewTitle="This Week";

                          });
                          await viewData('test',"false");*/
                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.calendar_view_week,
                                  color: Colors.orange,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("This Week"),
                                ),

                              ],
                            ),
                            Divider(
                              height: 20, // Adjust the height as needed
                              thickness: 0.2, // Adjust the thickness as needed
                              color: Colors.grey,
                            ),

                          ],
                        ),
                      )
                  ),



                ],
                offset: const Offset(0, 40),
                child:InkWell(

                  child: Ink(
                    decoration: ShapeDecoration(
                      color: Colors.grey.withOpacity(0.2),
                      shape: const CircleBorder(),
                    ),
                    child: const Padding(
                      padding: EdgeInsets.all(5.0),
                      child: Icon(

                        Icons.grid_view, // Replace with your desired icon
                        color: Colors.pink,
                      ),
                    ),
                  ),
                ),
              ),


              //trailing: Text()
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

              try {

                var resultData=(await ParticipatedQuery().getSearchAllStockOnline(Topups(startlimit:limit,endlimit:_page),BonusModel(uidUser:'',productName:text))).data;
                if(resultData["status"])
                {
                  setState(() {
                    //print(Resul);
                    isLoading=false;
                    hasMoreData=false;
                    _data.clear();

                    _data.addAll(resultData["result"]);
                  });
                }
                else{
                  _data.clear();
                  quickdata();
                }


              } catch (e) {
                //print('Error: $e');
              }

              //print(this._data[index]["total_var"]);
              // print("Text changed to: $text");
            },
          ),
        ),

        Expanded(
          child: ListView.builder(

            controller: _scrollController,
            itemCount: _data.length+1,
            itemBuilder: (context, index) {

              if(index<_data.length)
              {
                FocusNode test=FocusNode() ;

                _data[index]['focusNode']=test;
                return Stack(
                  children: [
                    Card(
                      elevation:0,

                      //margin: EdgeInsets.symmetric(vertical:1,horizontal:5),
                      color:Colors.white,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(9.0),
                        side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
                      ),

                      child: Padding(
                        padding: const EdgeInsets.only(top:8),
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

                                          Padding(
                                            padding: const EdgeInsets.fromLTRB(0, 10, 0, 2),
                                            child: InkWell(
                                              onTap: () async{

                                                setState(() {
                                                  productExist="false";
                                                  showOveray=true;



                                                });


                                                //
                                                await deliverStockView("none",_data[index]["OrderId"]);
                                              },
                                              child: RichText(
                                                text: TextSpan(
                                                  text: "${_data[index]['name']}:",
                                                  style: DefaultTextStyle.of(context).style,
                                                  children: const <TextSpan>[


                                                  ],
                                                ),
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

                            subtitle: Padding(
                              padding: const EdgeInsets.fromLTRB(0, 5, 0, 10),
                              child: Row(
                                children: [
                                  Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      Wrap(
                                        crossAxisAlignment: WrapCrossAlignment.center,
                                        children: [

                                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                                          Text("UID:${_data[index]['OrderId']}"),

                                        ],
                                      ),

                                      Wrap(
                                        crossAxisAlignment: WrapCrossAlignment.center,
                                        children: [

                                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                                          Text("Qty:${_data[index]['totalQty']}"),

                                        ],
                                      ),

                                      Wrap(
                                        crossAxisAlignment: WrapCrossAlignment.center,
                                        children: [

                                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                                          Text("Amount:${_data[index]['totalAmount']}"),

                                        ],
                                      ),

                                      Wrap(
                                        crossAxisAlignment: WrapCrossAlignment.center,
                                        children: [

                                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                                          Text("Deliver:${num.parse(_data[index]['totalQty'])-num.parse(_data[index]['totalCount'])}"),
                                          const SizedBox(width:8,),
                                          ((num.parse(_data[index]['totalQty'])-num.parse(_data[index]['totalCount']))>0)?
                                          InkWell(
                                              onTap: () async{
                                                setState(() {
                                                  productExist="false";
                                                  showOveray=true;



                                                });


                                                //
                                                await deliverStockView("none",_data[index]["OrderId"]);
                                              },


                                              child: const Icon(Icons.rocket_launch,color:Colors.red,size:25,)):const Text(""),



                                        ],
                                      ),
                                      Wrap(
                                        crossAxisAlignment: WrapCrossAlignment.center,
                                        children: [

                                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                                          Text("Send By:${ConstantClassUtil().truncateWithEllipsis((_data[index]['adminName']).toUpperCase(), 9)}"),



                                        ],
                                      ),


                                    ],
                                  ),

                                ],
                              ),
                            ),
                            trailing:GestureDetector(
                                onTap: () async{
                                  // This function will be called when the icon is tapped.
                                  // thisOrder(_data[index],index);



                                  orderData=_data[index].values.toList();



                                 thisOrder(_data[index]['OrderId']);






                                  viewThisOrder();






                                  //


                                },
                                child:const Icon(Icons.grid_view,color:Colors.orange)
                            )

                          //trailing: Text()
                        ),
                      ),
                    ),
                    Positioned(
                      top:12,
                      right: 28,


                      child: Center(
                        child: Text(
                          '${_data[index]['created_at']}',
                          //'test',
                          style: const TextStyle(color: Colors.deepOrange,fontSize: 10),
                        ),
                      ),
                    ),
                  ],

                );

              }
              else{
                return  Padding(
                  padding:const EdgeInsets.symmetric(vertical: 32),
                  child:Center(
                      child:hasMoreData?
                      const CircularProgressIndicator()
                          :const Text("no more Data")

                  ),
                );
              }

            },
          ),
        ),
      ],
    );
  }
  @override
  void initState()
  {
    super.initState();
    //getapi();


    quickdata();
    _scrollController.addListener(_scrollListener);

  }
  void _scrollListener() {
    if (_scrollController.offset >= _scrollController.position.maxScrollExtent &&
        !_scrollController.position.outOfRange) {
      _page=_page+10;

      quickdata();
    }
  }


  @override
  void dispose() {


    _scrollController.dispose();
    controller?.dispose();
    super.dispose();
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
      if(result!=null)
      {
        // controller!.pauseCamera();

        bool containsQrCode = qrDebt.any((item) => item['cardUid'] == result!.code);
        if(containsQrCode)
        {
          controller.pauseCamera();
          var listData={
            "cardUid":result!.code
          };
          qrDebt.insertAll(0,[listData]);

          String cardUid="${result!.code}";
          // print(cardUid);
          //getCardDetail(cardUid);
          // getData("TEALTD_JgTq4_1695233576");
          var checkCard=await getData(cardUid);
          if(checkCard !=null){
            checkCard=jsonDecode(checkCard);
            setState(() {
              uidTransport="${checkCard[0]["uid"]}";
            });
            confirmUser("${checkCard[0]["name"]}","${checkCard[0]["uid"]}");
            /*  await stockCountSubmit(Get.put(HideShowState()).indexCountData);
                Get.back(canPop: false);*/
          }
          else{
            await getCardDetail(cardUid);

            /*await stockCountSubmit(Get.put(HideShowState()).indexCountData);
                Get.back(canPop: false);*/
          }

          //
        // print("card exist");

          //

        }
        else{
          controller.pauseCamera();
          var listData={
            "cardUid":result!.code
          };
          qrDebt.insertAll(0,[listData]);

          String cardUid="${result!.code}";
          // print(cardUid);
          //getCardDetail(cardUid);
          // getData("TEALTD_JgTq4_1695233576");
          var checkCard=await getData(cardUid);
          if(checkCard !=null){
            checkCard=jsonDecode(checkCard);
            setState(() {
              uidTransport="${checkCard[0]["uid"]}";
            });
            confirmUser("${checkCard[0]["name"]}","${checkCard[0]["uid"]}");
            /*  await stockCountSubmit(Get.put(HideShowState()).indexCountData);
                Get.back(canPop: false);*/
          }
          else{
            await getCardDetail(cardUid);

            /*await stockCountSubmit(Get.put(HideShowState()).indexCountData);
                Get.back(canPop: false);*/
          }




          //getDebt(result!.code);


        }
        //
      }
    });
  }

  getCountWidget(index) async{

    qtychange.text="${(Get.put(HideShowState()).delivery)[index]["currentQty"]}";
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return
            Stack(
              children: [
                Container(
                  padding:const EdgeInsets.all(2.0),
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
                                    color:Colors.white,
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(15.0),
                                      //side: BorderSide(color:_data[0]["color_var"]??true?Colors.white:Colors.green, width: 2),
                                    ),

                                    child: Column(
                                      children: [
                                        Text("${(controller.dispatchOrder)[index]["productCode"]}"),
                                        const Text("hellob"),
                                      ],
                                    )
                                ),
                              ),

                            ],
                          );
                        },
                      ),

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

                              TextField(
                                controller: qtychange,

                                keyboardType: TextInputType.number,
                                //obscureText: true,
                                decoration: const InputDecoration(
                                  contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                  border: OutlineInputBorder(),
                                  labelText: 'Enter Amount',
                                  hintText: 'Enter Amount',
                                  hintStyle: TextStyle(
                                    color: Colors.grey,
                                  ),

                                ),
                                onChanged: (text) async{

                                  await changeQtyCount(index,text);



                                },


                              ),


                              const SizedBox(height: 2.0,),


                            ],
                          ),
                        ),
                      ),

                      const SizedBox(height:2.0,),
                      //if(!(Get.put(StockQuery()).paidDeptScanHide))
                      GetBuilder<HideShowState>(
                          builder: (hideController) {
                            //if((Get.put(HideShowState()).delivery)[index]["hideAddCart"]==1)

                            return((hideController.delivery)[index]["hideAddCart"]==1)?
                            Expanded(
                                flex: 5,
                                child:Stack(
                                  alignment:Alignment.bottomCenter,
                                  children: [
                                    QRView(key: qrkey,onQRViewCreated: _onQRViewCreated,
                                      overlay: QrScannerOverlayShape(
                                        borderColor: Colors.pink,
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

                            ):Text("${(hideController.delivery)[index]["hideAddCart"]}");
                          }
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
    ).whenComplete(() async{

      qrDebt.clear();
      setState(() {
        uidTransport="UidTransport";
      });
      //Get.back(canPop: false);

      await thisOrder(_data[index]['OrderId']);
      viewThisOrder();






    });

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


  //

  quickdata()async
  {


    var resultData=(await StockQuery().orderViewCount(Topups(startlimit:limit,endlimit:_page))).data;

    if(resultData["status"])
    {



      if(resultData["result"]!=0)
      {
        setState(() {
          isLoading=false;
          hasMoreData=false;
          _data.clear();
          _data.addAll(resultData["result"]);

        });
      }
      else{
        setState(() {
          isLoading=false;
          hasMoreData=false;
          _data.clear();


        });
      }




    }
    else{
      setState(() {
        isLoading=false;
        hasMoreData=false;
        _data.clear();


      });
    }

  }

  thisOrder2()async
  {

    int limit=10;

    var resultData=(await StockQuery().orderViewByUid(Topups(uid:"${orderData[0]}",startlimit:limit,endlimit:_page))).data;


    if(resultData["status"])
    {
      setState(() {
        isLoading=false;
        hasMoreData=false;


        thisListOrder.clear();
        thisListOrder.addAll(resultData["result"]);


      });
      return true;
    }
    else{
      return false;
    }

  }

  thisOrder(orderId)async
  {
    //

    (Get.put(StockQuery()).updateHideLoader(false));


    //var resultData=(await StockQuery().orderViewByUid(Topups(uid:"${orderData[0]}",startlimit:limit,endlimit:_page))).data;
    var resultData=(await StockQuery().orderViewByUid(Topups(uid:orderId,startlimit:limit,endlimit:_page))).data;

    if(resultData["status"])
    {
      (Get.put(StockQuery()).updateHideLoader(true));
      if(resultData["result"]!=0)
      {




        (Get.put(StockQuery()).updateDispatchOrder(resultData["result"]));

      }
      else{
        Get.back(canPop: false);
      }


      //  print(resultData["result"]);



//print(orderId);
      /* final stockQuery = Get.put(StockQuery());
      print((stockQuery.dispatchOrder)[0]);*/


    }
    else{
      //return false;
    }





  }
  void viewComment(commentData){
    Get.bottomSheet(
      Container(
        height: 200,
        padding: const EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text('${commentData=='null'?"no Comment":commentData}'),
            const SizedBox(height: 20),

          ],
        ),
      ),
      barrierColor: Colors.transparent,
      backgroundColor: Colors.white,
    );
  }
  void viewPicture(productCode,imgUrl){
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
  viewThisOrder() {



    return Get.bottomSheet(
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

                      Center(child: Text("Client:${orderData[1]}")),
                      Center(child: Text("UID:${orderData[0]}")),


                      GetBuilder<StockQuery>(
                        builder: (controller) {
                          return  Expanded(
                              child:ListView.separated(
                                itemCount:(controller.dispatchOrder).length+1,
                                itemBuilder: (context, index) {
                                  if(index<(controller.dispatchOrder).length) {
                                    final GlobalKey qrkey1 = GlobalKey(debugLabel: 'QR Key $index');
                                    (Get.put(HideShowState())).isDelivery(controller.dispatchOrder);
                                    return Card(
                                      elevation: 0,
                                      child: ListTile(
                                          title: Row(
                                            children: [
                                              Expanded(

                                                child: Column(
                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                  children: [

                                                    RichText(
                                                      text: TextSpan(
                                                        text:"${controller.dispatchOrder[index]["productCode"]} (${controller.dispatchOrder[index]["pcs"]} pcs):",
                                                        style: DefaultTextStyle.of(context).style,
                                                        children: const <TextSpan>[


                                                        ],
                                                      ),
                                                    ),
                                                    Text("Price:${(controller.dispatchOrder[index]["price"])}"),


                                                    Text.rich(
                                                        TextSpan(
                                                            children: [
                                                              TextSpan(
                                                                text: 'Qty ${controller.dispatchOrder[index]["totalQty"]}:',

                                                              ),

                                                              WidgetSpan(

                                                                child: IntrinsicWidth(
                                                                  stepWidth: 0.5,
                                                                  child: TextField(



                                                                    keyboardType: TextInputType.number,
                                                                    decoration: const InputDecoration(
                                                                      hintText: '-1-',
                                                                      // hintText: '   -${(((Get.put(HideShowState()).delivery)[index]["totalQty"])!=((Get.put(HideShowState()).delivery)[index]["totalCount"]))?(((Get.put(HideShowState()).delivery)[index]["totalQty"]-(Get.put(HideShowState()).delivery)[index]["totalCount"])):1}-',
                                                                      hintStyle: TextStyle(color: Colors.red),
                                                                      contentPadding: EdgeInsets.all(0),
                                                                      isDense: true,




                                                                    ),

                                                                    style: const TextStyle(
                                                                      color: Colors.blue, // Set the text color to red

                                                                    ),
                                                                    onChanged: (text) async{
                                                                      (Get.put(HideShowState()).trackIndex(index));
                                                                      await changeQtyCount(index,text);


                                                                    },
                                                                  ), // set minimum width to 100
                                                                ),
                                                              ),

                                                            ]
                                                        )
                                                    ),

                                                    Wrap(
                                                      crossAxisAlignment: WrapCrossAlignment.center,
                                                      children: [


                                                        Text("Deliver:${(((Get.put(HideShowState()).delivery)[index]["totalQty"])!=((Get.put(HideShowState()).delivery)[index]["totalCount"]))?((num.parse((Get.put(HideShowState()).delivery)[index]["totalQty"])-num.parse((Get.put(HideShowState()).delivery)[index]["totalCount"]))):0}"),
                                                        const SizedBox(width:8,),
                                                        (((Get.put(HideShowState()).delivery)[index]["totalQty"])!=((Get.put(HideShowState()).delivery)[index]["totalCount"]))?
                                                        InkWell(
                                                            onTap: () async{
                                                              setState(() {
                                                                productExist="true";

                                                              });


                                                              //
                                                              await deliverStockView(controller.dispatchOrder[index]["productCode"],controller.dispatchOrder[index]["uid"]);
                                                            },


                                                            child: const Icon(Icons.local_shipping,color:Colors.red,size:25,)):const Text(""),

                                                      ],
                                                    ),


                                                    GetBuilder<HideShowState>(
                                                      builder: (myLoadercontroller) {
                                                        //return Text('Data: ${_controller.data}');

                                                        return
                                                          (((myLoadercontroller.delivery)[index]["hideAddCart"])==1)?

                                                          SizedBox(
                                                            width:200,
                                                            height: 200,
                                                            child: Stack(
                                                              alignment:Alignment.bottomCenter,
                                                              children: [
                                                                QRView(key:qrkey1,onQRViewCreated: _onQRViewCreated,
                                                                  overlay: QrScannerOverlayShape(
                                                                    borderColor: Colors.pink,
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
                                                            ),
                                                          ):const Visibility(
                                                              visible: false,
                                                              child: Text(""));
                                                      },
                                                    ),





                                                  ],
                                                ),
                                              )






                                            ],
                                          ),
                                          // subtitle: Text('Subtitle for ${_controller.dispatchOrder[index]["price"]}'),
                                          leading: InkWell(
                                              onTap: () async{
                                                viewPicture((controller.dispatchOrder[index]["productCode"]),(controller.dispatchOrder[index]["img_url"]));

                                                /*Get.back(canPop: false);

                                              (Get.put(HideShowState()).trackIndex(index));
                                             await getCountWidget(index);*/



                                                //_saveData();
                                                //getData("cardUid");
                                                //deleteData();
                                                /*var data=await getData("TEALTD_JgTq4_1695233576");
                                             data=jsonDecode(data);
                                             print("${data[0]["uid"]}");*/
                                                //var data=await getData("TEALTD_JgTq4_1695233575");


                                              },
                                              child: const Icon(Icons.qr_code)
                                          ),
                                          trailing:Column(
                                            children: [
                                              Row(
                                                mainAxisSize: MainAxisSize.min,
                                                children: <Widget>[

                                                  GetBuilder<HideShowState>(
                                                    builder: (myLoadercontroller) {
                                                      //return Text('Data: ${_controller.data}');

                                                      return
                                                        (((myLoadercontroller.delivery)[index]["hideAddCart"])==1)?

                                                        IconButton(
                                                          icon:const Icon(Icons.add_shopping_cart,
                                                              size: 23.0,
                                                              color: Colors.grey),
                                                          onPressed: () async{
                                                            (Get.put(HideShowState()).isHideDelivery(index,0));
                                                            (Get.put(StockQuery()).updateHideLoader(false));
                                                            if (isButtonDisabled) {
                                                              setState(() {
                                                                isButtonDisabled = false;
                                                              });
                                                              await stockCountSubmit(index);



                                                            }





                                                          },):const Text("");
                                                    },
                                                  ),

                                                  GetBuilder<StockQuery>(
                                                    builder: (myLoadercontroller) {
                                                      //return Text('Data: ${_controller.data}');
                                                      return
                                                        (myLoadercontroller.dispatchOrder[index]["commentData"]!=null)?
                                                        IconButton(
                                                          icon: const Icon(
                                                              Icons.mark_unread_chat_alt,
                                                              size: 23.0,
                                                              color: Colors.red
                                                          ),
                                                          onPressed: () {
                                                            //print("${myLoadercontroller.dispatchOrder[index]["commentData"]}");
                                                            viewComment("${(myLoadercontroller.dispatchOrder[index])["commentData"]}");

                                                          },
                                                        ):const Text("");
                                                    },
                                                  ),



                                                ],
                                              ),

                                            ],
                                          )
                                      ),
                                    );
                                  }else{
                                    return const Text("");
                                  }
                                },
                                separatorBuilder: (context, index) {
                                  return const Divider(
                                    height: 1,
                                    color: Colors.grey,
                                  );
                                },

                              ));

                        },
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
      // Get.put(HideShowState()).isDelivery(0);
      //do whatever you want after closing the bottom sheet
    });

  }

  changeQtyCount(index,text){
    final value = int.tryParse(text);
    //if((double.tryParse(text) != null)){
    if(value != null && value > 0){
      (Get.put(HideShowState()).delivery)[index]["currentQty"]=num.parse(text);

      num deliver=(((Get.put(HideShowState()).delivery)[index]["totalQty"])!=((Get.put(HideShowState()).delivery)[index]["totalCount"]))?((num.parse((Get.put(HideShowState()).delivery)[index]["totalQty"])-num.parse((Get.put(HideShowState()).delivery)[index]["totalCount"]))):0;
      //print("Deliver:${(Get.put(HideShowState()).delivery).length}");
     
    num currentQty=num.parse("${ConstantClassUtil().convertToNum((Get.put(HideShowState()).delivery)[index]["currentQty"])}");

      if((num.parse((Get.put(HideShowState()).delivery)[index]["totalQty"]))>=((currentQty)+(deliver-0)))
      {
        // print((Get.put(HideShowState()).delivery)[index]["currentQty"]);




        (Get.put(HideShowState()).isHideDelivery(index,1));


      }
      else{

        (Get.put(HideShowState()).isHideDelivery(index,0));

      }

    }
    else{

      (Get.put(HideShowState()).isHideDelivery(index,0));

    }
  }

  stockCountSubmit(index) async{




    productCode=(Get.put(StockQuery()).dispatchOrder)[index]["productCode"];

   // print("Submit variable Variable :${((Get.put(HideShowState()).delivery)[index]["currentQty"]).runtimeType}");


    num currentQty=num.parse("${ConstantClassUtil().convertToNum((Get.put(HideShowState()).delivery)[index]["currentQty"])}");
    num totCount=((num.parse((Get.put(HideShowState()).delivery)[index]["totalCount"])-currentQty)>=0)?num.parse((Get.put(HideShowState()).delivery)[index]["totalCount"]):0;
    if(totCount>0)
    {

      var resultData=(await StockQuery().stockCount(Topups(uid:"${orderData[0]}"),QuickBonus(uid:productCode,qty:"${(Get.put(HideShowState()).delivery)[index]["currentQty"]}",subscriber:"StockName",status:"status",description:"Delivered"), User(uid:uidTransport,name:"refName"))).data;

      if(resultData["status"])
      {
        /*Future.delayed(Duration.zero,(){
        //your code goes here
        //

      });*/

        //thisOrder2();
        if(resultData["result"]!=0) {
          setState(() {
            isButtonDisabled = true;
          });
          await thisOrder(orderData[0]);
          await quickdata();
        }





        /*setState(() {

        num dats=(num.parse((Get.put(HideShowState()).delivery)[index]["totalCount"]))-num.parse((Get.put(HideShowState()).delivery)[index]["currentQty"]);
       // (Get.put(HideShowState()).delivery)[index]["totalCount"]="$dats";
        (Get.put(HideShowState()).isChangeDelivery(index,'totalCount',dats));

      });*/
      }

    }
  }
  deliverStockView(productC,uidOrder) async{
    //print(uidOrder);
    (Get.put(StockQuery()).updateHideLoader(false));


    var resultData=(await StockQuery().stockViewDeliver(Topups(uid:uidOrder,optionCase:productExist),QuickBonus(uid:productC))).data;

    //print(resultData);
    if(resultData["status"])
    {
      setState(() {
        showOveray=false;
      });
      (Get.put(StockQuery()).updateHideLoader(true));
      if(resultData["result"]!=0)
      {




        viewDeliver(resultData["result"]);





        //
      }
      else{
        setState(() {
          showOveray=false;
        });
        Get.back(canPop: false);
      }
    }
    else{
      setState(() {
        showOveray=false;
      });
      Get.snackbar("Success", uidOrder,backgroundColor: const Color(0xff9a1c55),
          colorText: const Color(0xffffffff),
          titleText: const Text("No Data found",  style: TextStyle(
            color: Colors.white, // Set the text color here

          ),),

          icon: const Icon(Icons.access_alarm),
          duration: const Duration(seconds: 4));
    }
  }
  viewDeliver(dataV){
    (Get.put(StockQuery()).updateDispatchOrder2(dataV));
    return Get.bottomSheet(
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


                      Center(child: Text("UID:${dataV[0]["uid"]}")),
                      const SizedBox(height:8.5,),

                      const Divider(
                        height: 1,
                        color: Colors.grey,
                      ),


                      GetBuilder<StockQuery>(
                        builder: (controller) {
                          return  Expanded(
                              child:ListView.separated(
                                itemCount:(controller.dispatchOrder2).length+1,
                                itemBuilder: (context, index) {
                                  if(index<(controller.dispatchOrder2).length) {
                                    //final GlobalKey qrkey1 = GlobalKey(debugLabel: 'QR Key2 $index');
                                    // (Get.put(HideShowState())).isDelivery(_controller.dispatchOrder2);
                                    return Stack(
                                      children: [
                                        Card(
                                          elevation: 0,
                                          color:Colors.white,
                                          child: Padding(
                                            padding: const EdgeInsets.only(top:10.0),
                                            child: ListTile(

                                              title: Row(
                                                children: [
                                                  Expanded(

                                                    child: Column(
                                                      crossAxisAlignment: CrossAxisAlignment.start,
                                                      children: [
                                                        Wrap(
                                                          crossAxisAlignment: WrapCrossAlignment.center,
                                                          children: [

                                                            const Icon(Icons.segment,color:Colors.orange,size:13,),
                                                            Text("${(controller.dispatchOrder2[index]["productCode"].toUpperCase())}",
                                                              style: const TextStyle(fontSize: 14),
                                                            ),
                                                          ],
                                                        ),
                                                        Wrap(
                                                          crossAxisAlignment: WrapCrossAlignment.center,
                                                          children: [

                                                            const Icon(Icons.segment,color:Colors.orange,size:13,),
                                                            Text("Carry by:${ConstantClassUtil().capitalizeFirstLetter((controller.dispatchOrder2[index]["userName"]))}",
                                                              style: const TextStyle(fontSize: 14),
                                                            ),
                                                          ],
                                                        ),
                                                        Wrap(
                                                          crossAxisAlignment: WrapCrossAlignment.center,
                                                          children: [

                                                            const Icon(Icons.segment,color:Colors.orange,size:13,),
                                                            Text("Qty:${(controller.dispatchOrder2[index]["qty"])}",
                                                              style: const TextStyle(fontSize: 14),
                                                            ),
                                                          ],
                                                        ),

                                                        Wrap(
                                                          crossAxisAlignment: WrapCrossAlignment.center,
                                                          children: [


                                                            const Icon(Icons.segment,color:Colors.orange,size:13,),
                                                            Text("Send by:${ConstantClassUtil().capitalizeFirstLetter((controller.dispatchOrder2[index]["adminName"]))}",
                                                              style: const TextStyle(fontSize: 14),
                                                            ),
                                                          ],
                                                        ),














                                                      ],
                                                    ),
                                                  )






                                                ],
                                              ),
                                              // subtitle: Text('Subtitle for ${_controller.dispatchOrder2[index]["price"]}'),
                                              leading: CircleAvatar(
                                                backgroundColor:getRandomColor(),
                                                child: Icon(_getRandomIcon()),
                                              ),

                                            ),
                                          ),
                                        ),
                                        Positioned(
                                          top:10,
                                          right: 28,


                                          child: Center(
                                            child: Text(
                                              '${controller.dispatchOrder2[index]['created_at']}',
                                              style: const TextStyle(color: Colors.deepOrange,fontSize: 10),
                                            ),
                                          ),
                                        ),
                                      ],
                                    );
                                  }else{
                                    return const Text("");
                                  }
                                },
                                separatorBuilder: (context, index) {
                                  return const Divider(
                                    height: 1,
                                    color: Colors.grey,
                                  );
                                },

                              ));

                        },
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
      // Get.put(HideShowState()).isDelivery(0);
      //do whatever you want after closing the bottom sheet
    });

  }
  saveData(String carduid,dynamic user) async {
    List<Map<String, dynamic>> dataList = [
      {"uid":user["uid"],"name": user["name"],"photo":""}

    ];
    final prefs = await SharedPreferences.getInstance();
    final key = carduid;//CardUid
    final value = jsonEncode(dataList); // Convert list of maps to JSON string
    prefs.setString(key, value);
    setState(() {
      uidTransport="${user["uid"]}";
    });
    confirmUser("${user["name"]}","${user["uid"]}");
  }
  getData(cardUid) async{
    final prefs = await SharedPreferences.getInstance();
    final String? action =prefs.getString(cardUid);//CardUid
    return action;
    //print(action);
  }
  confirmUser(name,uid){
    // ${(Get.put(HideShowState()).delivery)[Get.put(HideShowState()).indexCountData]["currentQty"]}
    // (Get.put(StockQuery()).dispatchOrder)[Get.put(HideShowState()).indexCountData]["productCode"];
    Get.dialog(
      AlertDialog(
        title: Text("Ni $name ?"),
        content: Text('Utwaye ${(Get.put(StockQuery()).dispatchOrder)[Get.put(HideShowState()).indexCountData]["productCode"]}:${(Get.put(HideShowState()).delivery)[Get.put(HideShowState()).indexCountData]["currentQty"]}?'),
        actions: [
          ElevatedButton(
            style: ElevatedButton.styleFrom(

              //primary: Colors.grey[300],
              backgroundColor: Colors.red,
              elevation:0,
            ),
            onPressed: () async{
              Get.back(canPop: false);
              (Get.put(HideShowState()).isHideDelivery(Get.put(HideShowState()).indexCountData,0));
              (Get.put(StockQuery()).updateHideLoader(false));
              if (isButtonDisabled) {
                qrDebt.clear();
                setState(() {
                  isButtonDisabled = false;
                  uidTransport = "$uid";
                });
                await stockCountSubmit(Get
                    .put(HideShowState())
                    .indexCountData);


              }


            },
            child: const Text('Yes',style:TextStyle(
                color: Colors.white
            ),),
          ),
          ElevatedButton(
            onPressed: () {
              qrDebt.clear();
              setState(() {
                uidTransport="UidTransport";
              });
              Get.back(canPop: false); // close the alert dialog
            },
            child: const Text('Close'),
          ),
        ],
      ),
    );
  }
  deleteData(carduid) async{
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove("$carduid");//CardUid
    //print(prefs.getString("my_data"));


  }
  getCardDetail(resultCode) async{
    // print("hello");
    //(Get.put(StockQuery()).updateHideLoader(false));
    var resultData=(await CardQuery().getDetailCardOnline(CardModel(uid:"$resultCode"))).data;
    if(resultData["status"])
    {

      //resultData["UserDetail"]["name"]

      // print(resultData["UserDetail"]);
      saveData(resultCode, resultData["UserDetail"]);

      //print("result ${resultData["UserDetail"]}");


    }
    else{
      //stockCountEdit
    }

    //

  }
  stockCount(indexData)async
  {


    //(Get.put(HideShowState())).isChangeDelivery(thisListOrder[indexData],indexData,qtyProduct);


    // print((Get.put(HideShowState()).delivery)[indexData]);
    //print(thisListOrder[indexData]);





    /*var resultData=(await StockQuery().stockCount(Topups(uid:"${orderData[0]}"),QuickBonus(uid:"${productCode}",qty:"${qty_product}",subscriber:"StockName",status:"status",description:"Delivered"), User(uid: "UidTransport",name:"refName"))).data;


    if(resultData["status"])
    {
      Quickdata();
      thisOrder2();

    }*/







  }



//
}


