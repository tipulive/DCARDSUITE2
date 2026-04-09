


import '../../../Query/CardQuery.dart';
import '../../../Query/TopupQuery.dart';
import '../../../models/CardModel.dart';
import '../../../models/Topups.dart';
import '../models/BonusModel.dart';

import '../Pages/ProfilePage.dart';
import '../Pages/QuickBonusPage.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

import 'package:qr_code_scanner/qr_code_scanner.dart';
//import 'package:wakelock/wakelock.dart';
import 'package:get/get.dart';




import '../../../models/Participated.dart';
import '../../../models/Promotions.dart';
import '../Query/AdminQuery.dart';
import '../Pages/components/BottomNavigator/HomeNavigator.dart';


import 'package:cool_alert/cool_alert.dart';


import '../../../Query/PromotionQuery.dart';
import '../Query/ParticipatedQuery.dart';
import '../Utilconfig/HideShowState.dart';



class Homepage extends StatefulWidget {
  const Homepage({Key? key}) : super(key: key);



  @override
  State<Homepage> createState() => _HomepageState();


}
class _HomepageState extends State<Homepage> {


  PromotionQuery promotionState=Get.put(PromotionQuery());
  AdminQuery adminStatedata=Get.put(AdminQuery());

  TextEditingController PromoName=TextEditingController();
  TextEditingController uidInput=TextEditingController();//uid promo
  TextEditingController uidInput2=TextEditingController(text:'kebineericMuna_1668935593');//userid of user that will be available after qr scan
  TextEditingController uidInput3=TextEditingController();//input data to submit
  TextEditingController uidInput4=TextEditingController();
  TextEditingController uidInput5=TextEditingController();
  TextEditingController ClientName=TextEditingController();
  String PromoMsg="none";
  bool showprofile=false;
  bool showOveray=false;
  bool IsSubmitted=false;
  final GlobalKey qrkey = GlobalKey(debugLabel: 'QR');
  Barcode?result;
  QRViewController?controller;
  var _groupVal ="male";

  bool optionVal=true;
  List items=["male","female","others","Keb2"];

  bool Cameravalue=false;
  bool Flashvalue=false;
  var ResultDatas;

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
      body:Stack(
        children: [
          Column(
            children: [
          Obx(
          () =>Visibility(
                visible:Get.put(HideShowState()).isCameraVisible.value,
                child: Expanded(
                    flex: 5,
                    child:Stack(
                      alignment:Alignment.bottomCenter,
                      children: [
                        QRView(key: qrkey,onQRViewCreated: _onQRViewCreated,),

                        Row(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [

                                CameraSwitch(),
                                //SizedBox(width: 10.0,),

                                // SizedBox(width: 10.0,),
                                FlashSwitch(),
                                Image.asset(
                                  Flashvalue ? 'images/on.png' : 'images/off.png',
                                  height: 30,
                                ),
                              ],
                            ),
                          ],
                        ),

                      ],
                    )

                ),

              ),
          ),

              Visibility(
                visible: true,
                child: Expanded(
                  flex: 2,
                  child: SingleChildScrollView(

                    child: Center(
                        child:Column(
                          children: [
                            (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),
                         Text("Text Eric"),








                          ],
                        )

                    ),
                  ),
                ),
              ),
            ],
          ),
          if(showOveray)
            Positioned.fill(
              child: Center(
                child: Container(
                  alignment: Alignment.center,
                  color: Colors.white70,
                  child: CircularProgressIndicator(),
                ),
              ),
            ),

        ],
      ) ,
      bottomNavigationBar:HomeNavigator(),

      // This trailing comma makes auto-formatting nicer for build methods.

    );

  }

  ScanPopup(uid,name){

    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
         return

           Stack(
            alignment: Alignment.bottomCenter,
            children: [
              Container(
                height:400,

                child: Column(
                  children: [
                    Container(

                      height: 400,
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.only(
                          topLeft: Radius.circular(16),
                          topRight: Radius.circular(16),
                        ),
                      ),
                      child: ListView(
                        children: [

                          MyTextWidget(uid,name)
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                // height: 60,
                //color: Colors.white,
                child: HomeNavigator(),
              ),

              Positioned(
                right: 15.0,
                bottom:70,
                child: FloatingActionButton(
                  onPressed:()async {
                    Get.put(HideShowState()).isVisible(true);
                    ResultDatas=(await Get.put(TopupQuery()).GetBalance(Topups(uid:"${(Get.put(CardQuery()).obj)["resultData"]["UserDetail"]["uid"]??'none'}"))).data;
                    if(ResultDatas["status"])
                    {
                      await Get.put(TopupQuery()).updateTopupState(ResultDatas);
                      Get.put(HideShowState()).isVisible(false);
                      Get.to(() => ProfilePage());
                    }
                    else{

                      await Get.put(TopupQuery()).updateTopupState(ResultDatas);
                      Get.put(HideShowState()).isVisible(false);
                      Get.to(() => ProfilePage());
                    }


                  },
                  tooltip: 'Increment',
                  child: CircleAvatar(
                    radius: 50,
                    backgroundImage: AssetImage("images/profile.jpg",
                    ),
                  ),
                ),
              ),

              Positioned.fill(
                  child:  Obx(
          () =>Visibility(
            visible: Get.put(HideShowState()).isVisible.value,
                    child: Container(
                      color: Colors.black.withOpacity(0.65),
                    ),
                  ),
                  )
                ),

                Positioned(
                  top: 0,

                  child:  Obx(
          () =>Visibility(
            visible: Get.put(HideShowState()).isVisible.value,
                    child: Container(
                      //padding: EdgeInsets.all(16),
                      child: CircularProgressIndicator(),
                    ),
                  ),
                  )
                ),
            ],
          );
        },
      ),
    ).whenComplete(() {
      controller!.resumeCamera();
      //do whatever you want after closing the bottom sheet
    });
  }
  Widget MyTextWidget(uid,name){
    if((promotionState.obj["id"])==1) return Center(child: CircularProgressIndicator());
    PromoName.text="${(promotionState.obj["resultData"]["result"][0]["promoName"])}";
    PromoMsg=(promotionState.obj["resultData"]["result"][0]["promo_msg"]);
    uidInput.text="${(promotionState.obj["resultData"]["result"][0]["uid"])}";
    uidInput4.text="${(promotionState.obj["resultData"]["result"][0]["reach"])}";
    uidInput5.text="${(promotionState.obj["resultData"]["result"][0]["gain"])}";
    uidInput2.text="${uid}";
    ClientName.text="${name}";

    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(

        children: [
          Visibility(
              visible: true,
              child: Column(

                children: [

                  TextButton(
                      onPressed: ()  async{

                        try {
                         setState(() {
                           showOveray=true;
                         });
                          var resul=(await ParticipatedQuery().GetUidSubmitQuickBonusEventOnline(BonusModel(uidUser:'${(Get.put(CardQuery()).obj)["resultData"]["UserDetail"]["uid"]??'none'}'))).data;


                          if(resul["status"])
                          {
                         var dataresult=resul["resultData"];
                         for(int i=0;i<resul["count"];i++)
                           {
                             setState(() {
                               showOveray=false;
                               Get.put(ParticipatedQuery()).updateCartUi(resul,true,true);
                               Get.put(ParticipatedQuery()).dataCartui["countData"]["count"]=resul["count"];
                               Get.put(ParticipatedQuery()).dataCartui["products"]["${dataresult[i]["quickUid"]}"]=dataresult[i]["price"];

                               // Update the value of _counter and trigger a rebuild
                             });
                           }


                            Get.to(() => QuickBonusPage());


                          }
                          else{
                            //hide cart
                            setState(() {
                              Get.put(ParticipatedQuery()).updateCartUi(resul,false,false);
                              Get.put(ParticipatedQuery()).dataCartui["countData"]["count"]=0;


                              // Update the value of _counter and trigger a rebuild
                            });

                            Get.to(() => QuickBonusPage());


                          }


                        } catch (e) {
                          setState(() {
                            showOveray=false;
                          });
                          print('Error: $e');
                        }

                        //print(this._data[index]["total_var"]);
                        // print("Text changed to: $text");
                      },
                      child: const Text("QuickBonus Qr")
                  ),                  Center(child: Text(name)),
                  SizedBox(height:10.0,),
                  TextField(
                    controller:PromoName,
                    enabled: false,
                    //obscureText: true,
                    decoration: InputDecoration(
                      contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                      border: OutlineInputBorder(),
                      labelText: 'Promotion Name',
                      hintText: 'Promotion Name',
                      hintStyle: TextStyle(
                        color: Colors.grey,
                      ),

                    ),
                  ),
                  Visibility(
                    visible:false,
                    child: TextField(
                      controller: uidInput,
                      //obscureText: true,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                        border: OutlineInputBorder(),
                        labelText: 'Uid of Promotion ',
                        hintText: 'Uid of Promotion',
                        hintStyle: TextStyle(
                          color: Colors.grey,
                        ),

                      ),
                    ),
                  ),
                  SizedBox(height: 10.0,),
                  Visibility(
                    visible:false,
                    child: TextField(
                      controller: uidInput2,
                      //obscureText: true,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                        border: OutlineInputBorder(),
                        labelText: 'UserID',
                        hintText: 'Enter your name',
                        hintStyle: TextStyle(
                          color: Colors.grey,
                        ),

                      ),
                    ),
                  ),
                  //SizedBox(height: 10.0,),
                  Visibility(
                    visible:false,
                    child: TextField(
                      controller: ClientName,
                      enabled: false,
                      //obscureText: true,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                        border: OutlineInputBorder(),
                        labelText: 'Name',
                        hintText: 'Enter your name',
                        hintStyle: TextStyle(
                          color: Colors.grey,
                        ),

                      ),
                    ),
                  ),
                  SizedBox(height: 10.0,),
                  TextField(
                    controller: uidInput3,

                    //obscureText: true,
                    keyboardType: TextInputType.number,
                    decoration: InputDecoration(
                      contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                      border: OutlineInputBorder(),
                      // labelText: 'Enter ${Promo_data["result"][0]["promo_msg"]}',${promotionState.obj["resultData"]["result"][0]["uid"]}
                      labelText: '${PromoMsg}',
                      hintText: 'InputData',
                      hintStyle: TextStyle(
                        color: Colors.grey,
                      ),
                      suffixIcon:  GestureDetector(
                        child: Icon(Icons.settings),
                        onTap: () {
                          _groupVal=uidInput.text;
                          Get.dialog(
                            AlertDialog(
                              title: Center(child: const Text('Choose Promotion')),
                              content:SingleChildScrollView(
                                child: Column(
                                  mainAxisSize: MainAxisSize.min,
                                  mainAxisAlignment:MainAxisAlignment.start,
                                  crossAxisAlignment:CrossAxisAlignment.start,
                                  children: <Widget> [


                                    if(((Get.put(PromotionQuery()).obj)["id"])==1)...[Center(child: CircularProgressIndicator())],

                                    for(var i=0;i<(Get.put(PromotionQuery()).obj)["resultData"]["result"].length;i++)
                                      RadioListTile(
                                        title: Text("${i==null?"none":(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["promoName"]}"),
                                        value: "${i==null?"none":(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["uid"]}",
                                        //value:"${items[i]}",

                                        groupValue:_groupVal,
                                        onChanged: (value){

                                          this._groupVal=value.toString();
                                          //value="male";

                                          uidInput.text=this._groupVal;
                                          PromoName.text="${(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["promoName"]}";
                                          PromoMsg="${(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["promo_msg"]}";
                                          uidInput4.text="${(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["reach"]}";
                                          uidInput5.text="${(Get.put(PromotionQuery()).obj)["resultData"]["result"][i]["gain"]}";

                                          //print(_groupVal);
                                          //Get.back(result: value);
                                          Get.back();
                                        },
                                      ),

                                  ],
                                ),
                              ),
                              actions: [
                                TextButton(
                                  child: const Text("Close"),
                                  onPressed: () => Get.back(),
                                ),
                              ],
                            ),
                          );


                          // Perform some action when the icon is pressed
                        },
                      ),
                    ),
                  ),
                  SizedBox(height: 10.0,),
                  Visibility(
                    visible:false,
                    child: TextField(
                      controller: uidInput4,
                      //obscureText: true,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                        border: OutlineInputBorder(),
                        labelText: 'reach',
                        hintText: 'reache',
                        hintStyle: TextStyle(
                          color: Colors.grey,
                        ),

                      ),
                    ),
                  ),
                  SizedBox(height: 10.0,),
                  Visibility(
                    visible:false,
                    child: TextField(
                      controller: uidInput5,
                      //obscureText: true,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                        border: OutlineInputBorder(),
                        labelText: 'gain',
                        hintText: 'gain',
                        hintStyle: TextStyle(
                          color: Colors.grey,
                        ),

                      ),
                    ),
                  ),



                  FloatingActionButton.extended(
                    label: Text('Participate'), // <-- Text
                    backgroundColor: Colors.black,
                    icon: Icon( // <-- Icon
                      Icons.thumb_up,
                      size: 24.0,
                    ),
                    onPressed: ()async =>{
                      Get.put(HideShowState()).isVisible(true),

                     /* setState(() {


                        showOveray=true;
                      }),*/


                      await Get.put(ParticipatedQuery()).ParticipateEventOnline(Participated(uid:uidInput.text,uidUser:uidInput2.text,inputData:uidInput3.text),Promotions(reach:uidInput4.text,gain:uidInput5.text)),
                      //print((Get.put(ParticipatedQuery()).obj)),
                      if((Get.put(ParticipatedQuery()).obj)["resultData"]["reach"]!=null)
                        {
                         /* setState(() {


                            showOveray=false;
                          }),*/
                          Get.put(HideShowState()).isVisible(false),
                          uidInput3.text="",
                          Get.close(1),
                          controller!.resumeCamera(),
                          CoolAlert.show(
                            context: context,
                            backgroundColor:Color(0xff940e4b),
                            type: CoolAlertType.success,
                            title:"Congratulation !!!",
                            text: "You Reach ${(Get.put(ParticipatedQuery()).obj)["resultData"]["reach"]}\$ and You win ${(Get.put(ParticipatedQuery()).obj)["resultData"]["gain"]} !",

                          ),



                          //Get.back(),

                        }else{
                        if((Get.put(ParticipatedQuery()).obj)["resultData"]["status"])
                          {
                            /*setState(() {

                              showOveray=false;
                            }),*/
                            Get.put(HideShowState()).isVisible(false),
                            uidInput3.text="",
                            Get.close(1),
                            controller!.resumeCamera(),

                            Get.snackbar("Success", "Data Submitted",backgroundColor: Color(0xff9a1c55),
                                colorText: Color(0xffffffff),
                                titleText: Text("Participate"),

                                icon: Icon(Icons.access_alarm),
                                duration: Duration(seconds: 5)),




                          },


                        //print((Get.put(ParticipatedQuery()).obj)),
                      },
                      //
                      //


                    },
                  ),
                ],
              )
          ),
        ],
      ),
    );
  }
  void _onQRViewCreated(QRViewController controller)
  {
    this.controller=controller;
    controller.scannedDataStream.listen((scanData) async{
      setState((){
        result=scanData;
      });
      await scanMethod();
    });
  }
  scanMethod() async{

    // uidInput2.text="${result!.code}";
    //uidInput2.text="${(await Get.put(CardQuery()).GetDetailCardOnline(CardModel(uid:'${result!.code}')))["UserDetail"]["uid"]}";
    if(result!=null)
    {

      controller!.pauseCamera();
      setState(() {
        showOveray=true;
      });
      try {


        // controller!.pauseCamera();
        //controller!.pauseCamera();
        var ResultData=(await Get.put(CardQuery()).getDetailCardOnline(CardModel(uid:'${result!.code}'))).data;
        if(ResultData["status"])
        {
          setState(() {
            showOveray=false;
          });

          //print(ResultData["UserDetail"]["uid"]);
          ScanPopup(ResultData["UserDetail"]["uid"],ResultData["UserDetail"]["name"]);
          (await Get.put(CardQuery()).updateCardState(ResultData));
        }
        else{
          controller!.pauseCamera();
          setState(() {
            showOveray=false;
          });
          CoolAlert.show(
            context: context,
            backgroundColor:Color(0xff940e4b),
            type: CoolAlertType.error,
            title:"Error !!!",
            text: "This Card is not exist",

          ).then((value) {
            // Event to trigger when the alert is dismissed
            controller!.resumeCamera();
          });
          //uidInput2.text="${ResultData["status"]}";
        }

      } catch (e) {
        setState(() {
          showOveray=false;
        });
        //return false;
        //print(e);
      }

    }
    else{

      setState(() {
        showOveray=false;
      });
      uidInput2.text="test";
    }



  }
  @override
  void dispose(){
    controller?.dispose();
    super.dispose();
  }
  Widget CameraSwitch()=>Transform.scale(
    scale: 1,
    child: Switch.adaptive(
        activeColor: Colors.red,
        activeTrackColor: Colors.red.withOpacity(0.4),
        inactiveThumbColor: Colors.orange,
        inactiveTrackColor: Colors.blueAccent,

        value: Cameravalue,
        onChanged:(value)async{
          setState((){
            this.Cameravalue=value;

            //print(value);
          });
          await controller!.resumeCamera();
        }
    ),
  );
  Widget FlashSwitch()=>Transform.scale(
    scale: 1,
    child: Switch.adaptive(
        activeColor: Colors.red,
        activeTrackColor: Colors.red.withOpacity(0.4),
        inactiveThumbColor: Colors.orange,
        inactiveTrackColor: Colors.blueAccent,

        value:Flashvalue,
        onChanged:(value)async{
          setState((){
            this.Flashvalue=value;

            //print(value);
          });
          await controller!.toggleFlash();
        }
    ),
  );

  void initState()
  {
    super.initState();
    //getapi();
    setState(() {
      showOveray=false;
    });
  }

//Method

//method
}


