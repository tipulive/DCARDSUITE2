
import 'dart:io';

import '../../../Query/CardQuery.dart';
import '../../../Utilconfig/HideShowState.dart';



import 'package:flutter/material.dart';

import 'package:qr_code_scanner/qr_code_scanner.dart';

import 'package:get/get.dart';


import '../../../models/Admin.dart';



import '../../models/CardModel.dart';



import '../../Pages/components/BottomNavigator/HomeNavigator.dart';
import 'package:intl_phone_field/intl_phone_field.dart';





class AddCardPage extends StatefulWidget {
  const AddCardPage({Key? key}) : super(key: key);

  @override
  State<AddCardPage> createState() => _AddCardPageState();


}
class _AddCardPageState extends State<AddCardPage> {




  TextEditingController uidInput=TextEditingController();
  TextEditingController uidInput2=TextEditingController();
  TextEditingController uidInput3=TextEditingController(text:"on1@gmail.com");
  TextEditingController uidInput4=TextEditingController(text:"+243");
  TextEditingController initCountry=TextEditingController(text:"CD");
  TextEditingController uidInput5=TextEditingController(text:"Congo,Democratic Republic of the Congo");
  TextEditingController uidInput6=TextEditingController(text:"1");
  TextEditingController uidInput7=TextEditingController();
  final GlobalKey qrkey = GlobalKey(debugLabel: 'QR2');
  Barcode?result;
  QRViewController?controller;
  bool Cameravalues=false;
  bool Flashvalues=false;
  bool showOveray=false;
  bool isValid = false;

  @override

  @override
  Widget build(BuildContext context)
  {


    void reassemble(){
      super.reassemble();
      if(Platform.isAndroid)
      {
        controller!.resumeCamera();
      }else if (Platform.isIOS)
      {
        controller!.pauseCamera();
      }
    }

    //hidekeyboard();
    //UserQuery userQueryData = Get.put(UserQuery());


    // ParticipatedQuery participatedState=Get.put(ParticipatedQuery());


    //FocusScope.of(context).unfocus();//hide keyboard on screen loading
    return Scaffold(
      body:Stack(
        children: [
          Column(
            children: [

              Visibility(
                visible:true,
                child: Expanded(
                    flex: 6,
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
                                  Flashvalues ? 'images/on.png' : 'images/off.png',
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
              Visibility(
                visible: false,
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Center(
                    child: Column(
                      children: [
                        TextButton(
                            onPressed: () async=>{
                              //await controller!.toggleFlash(),
                              // Wakelock.enable()
                              // await controller!.pauseCamera(),
                              //Get.to(() => Homepage()),
                              Get.dialog(


                                AlertDialog(
                                  title: Center(child: Text('Message')),
                                  content: Container(
                                    height: 50,
                                    child: Column(
                                      children: const [
                                        Center(child: Icon(Icons.thumb_up_alt_outlined, color: Colors.green)),
                                        SizedBox(width: 10),
                                        Expanded(
                                          child: Text('This is an alert message.'),
                                        ),
                                      ],
                                    ),
                                  ),
                                  actions: [
                                    TextButton(
                                      onPressed: () => Get.back(),
                                      child: Text('Close'),
                                    ),
                                  ],
                                ),
                              )



                            },

                            child: const Text("alert")
                        ),
                        TextButton(
                            onPressed: () async=>{
                              //await controller!.toggleFlash(),
                              // Wakelock.enable()
                              // await controller!.pauseCamera(),
                              //Get.to(() => Homepage()),
                              ScanPopup("none"),


                            },

                            child: const Text("Enable")
                        ),
                      ],
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
      ),
      bottomNavigationBar:HomeNavigator(),

    );

  }
  void _onQRViewCreated(QRViewController controller)
  {
    this.controller=controller;
    controller.scannedDataStream.listen((scanData) {
      setState((){
        result=scanData;

        String CheckCode=(result!=null)?"${result!.code}":"0";
        ScanPopup(CheckCode);
      });
    });
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

        value: Cameravalues,
        onChanged:(value)async{
          setState((){
            this.Cameravalues=value;

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

        value:Flashvalues,
        onChanged:(value)async{
          setState((){
            this.Flashvalues=value;

            //print(value);
          });
          await controller!.toggleFlash();
        }
    ),
  );

  ScanPopup(checkcode){
controller!.pauseCamera();
uidInput7.text=checkcode;

    Get.bottomSheet(
        Stack(
          alignment: Alignment.bottomCenter,
          children: [
            Container(
              height: 400,

              child: ListView(
                children: [
                  Container(

                    height: 400,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(20),
                        topRight: Radius.circular(20),
                      ),
                    ),
                    child: ListView(
                      children: [

                        MyTextWidget()
                      ],
                    ),
                  ),
                ],
              ),
            ),


          ],
        )
    ).whenComplete(() {
      controller!.resumeCamera();
      //do whatever you want after closing the bottom sheet
    });
  }
  Widget MyTextWidget(){

    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(

        children: [
          Center(
              child:Column(
                children: [
                  SizedBox(height: 8,),
                  // (result!=null)?Text("barcode Type ${describeEnum(result!.format)} Data ${result!.code}"): const Text("Scan Code"),
                  (result!=null)?Text("${result!.code}"): const Text("Scan Code"),

                  Column(
                    children: [
                      SizedBox(height: 8,),
                      IntlPhoneField(
                        initialCountryCode: 'CD',
                        controller: uidInput,
                        decoration: InputDecoration(
                          labelText: 'Phone Number',
                          border: OutlineInputBorder(
                            borderSide: BorderSide(),
                          ),
                          suffixIcon:Obx(() => Get.put(HideShowState()).isNumberValid.value?Icon(Icons.done,color:Colors.green,):Icon(Icons.dangerous,color:Colors.red,)),

                        ),
                        onChanged: (phone) {

                          //uidInput4.text=phone.countryCode;
                          //uidInput2.text=phone.number;
                          // uidInput2.text=phone.countryISOCode;
                          //print(phone.completeNumber);

                          if((uidInput.text).isPhoneNumber)
                          {
                            Get.put(HideShowState()).isValid(true);


                          }
                          else{
                            Get.put(HideShowState()).isValid(false);

                            // print("not empty");
                          }

                        },

                        onCountryChanged: (country) {
                          //print("gegr");

                          uidInput4.text="+"+country.dialCode;
                          //uidInput4.text="+"+country.dialCode;
                          uidInput5.text=country.name;
                          initCountry.text=country.code;
                          // print('Country changed to: ' + country.name);
                          // print('Country changed to: ' + country.dialCode);

                          if((uidInput.text).isPhoneNumber)
                          {
                            Get.put(HideShowState()).isValid(true);
                          }
                          else{
                            Get.put(HideShowState()).isValid(false);
                          }
                        },
                      ),
                      TextField(
                        controller: uidInput2,



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
                      SizedBox(height: 10.0,),
                      Visibility(
                        visible: false,
                        child: TextField(
                          controller: uidInput3,

                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                            border: OutlineInputBorder(),
                            labelText: 'Email',
                            hintText: 'Enter your Email',
                            hintStyle: TextStyle(
                              color: Colors.grey,
                            ),

                          ),
                        ),
                      ),

                      Visibility(
                        visible: false,
                        child: TextField(
                          controller: uidInput4,
                          //obscureText: true,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                            border: OutlineInputBorder(),
                            labelText: 'country Code',
                            hintText: 'country Code',
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
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                            border: OutlineInputBorder(),
                            labelText: 'Country',
                            hintText: 'Enter Country',
                            hintStyle: TextStyle(
                              color: Colors.grey,
                            ),

                          ),
                        ),
                      ),

                      Visibility(
                        visible: false,
                        child: TextField(
                          controller: uidInput6,
                          //obscureText: true,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                            border: OutlineInputBorder(),
                            labelText: 'Password',
                            hintText: 'Enter your Password',
                            hintStyle: TextStyle(
                              color: Colors.grey,
                            ),

                          ),
                        ),
                      ),
                      SizedBox(height: 10.0,),
                      Visibility(
                        visible: false,
                        child: TextField(
                          controller: uidInput7,
                          //obscureText: true,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                            border: OutlineInputBorder(),
                            labelText: 'CardUData',
                            hintText: 'Enter your name',
                            hintStyle: TextStyle(
                              color: Colors.grey,
                            ),

                          ),
                        ),
                      ),

                    ],
                  ),
                  SizedBox(height: 10.0,),
                  Obx(() =>
                      Visibility(
                        visible:Get.put(HideShowState()).isNumberValid.value,
                        child: FloatingActionButton.extended(
                          label: Text('Add Card'), // <-- Text
                          backgroundColor: Color(0xff940e4b),
                          icon: Icon( // <-- Icon
                            Icons.add_card,
                            size: 24.0,
                          ),
                          onPressed: ()async =>{
                            setState(() {
                              showOveray=true;
                            }),
                            //print(uidInput2.text),

                            // print( (await ParticipatedQuery().getAllParticipateEventOnline()).data["status"])
                            //print( (await PromotionQuery().getAllPromotionEventOnline()),

                            if((await CardQuery().createAssignCardEventOnline(CardModel(uid:uidInput7.text),Admin(phone:uidInput.text,name:uidInput2.text,email:uidInput3.text,Ccode:uidInput4.text,initCountry:initCountry.text,country:uidInput5.text,password:uidInput6.text,uid: "no need", subscriber:"no need",status:"Card"))).data["status"])
                              {
                                setState(() {
                                  showOveray=false;
                                }),
                                uidInput7.text="",
                                Get.close(1),
                                controller!.resumeCamera(),
                                Get.snackbar("Success", "Card Addedd",backgroundColor: Color(0xff9a1c55),
                                    colorText: Color(0xffffffff),
                                    titleText: const Text("Card User",style:TextStyle(color:Color(
                                        0xffffffff),fontSize:18,fontWeight:FontWeight.w500,fontStyle: FontStyle.normal),),

                                    icon: Icon(Icons.access_alarm),
                                    duration: Duration(seconds: 4))
                              }
                            else{
                              setState(() {
                                showOveray=false;
                              }),
                              uidInput7.text="",
                              Get.close(1),
                              controller!.resumeCamera(),
                              Get.snackbar("Error", "Card ,Card Can't be assigned please Contact System Admin",backgroundColor: Color(
                                  0xffdc2323),
                                  colorText: Color(0xffffffff),
                                  titleText: const Text("Card User",style:TextStyle(color:Color(
                                      0xffffffff),fontSize:18,fontWeight:FontWeight.w500,fontStyle: FontStyle.normal),),

                                  icon: Icon(Icons.access_alarm),
                                  duration: Duration(seconds: 4))

                            }


                          },

                        ),
                      )

                  ),



                ],
              )

          ),

        ],
      ),
    );
  }
  loadData() async{
    //await PromotionQuery().getAllPromotionEventOnline();
    // Perform data loading here
    // Map<String, dynamic> _data=((await PromotionQuery().getAllPromotionEventOnline()));
    //print(_data);

    // return _data;
    //return ((await PromotionQuery().getAllPromotionEventOnline()));
  }
//Method

//method
}


