import 'dart:convert';
import 'dart:math';



import 'package:qr_code_scanner/qr_code_scanner.dart';

import '../../../Utilconfig/HideShowState.dart';
import '../../../models/QuickBonus.dart';

import '../../../models/Topups.dart';
import '../../../models/User.dart';
import 'package:get/get.dart';
import '../../../Query/AdminQuery.dart';
import '../../../Utilconfig/ConstantClassUtil.dart';
import '../../Query/StockQuery.dart';
import 'package:flutter/material.dart';

import 'package:google_fonts/google_fonts.dart';

import '../../Utilconfig/image_card_widget.dart';





class ProductComp extends StatefulWidget {
  const ProductComp({super.key});

  @override
  State<ProductComp> createState() => _ProductCompState();
}

class _ProductCompState extends State<ProductComp> {
  double customFontSize=13.0;
  final ScrollController _scrollController = ScrollController();// detect scroll
  final List<dynamic> _data = [];
  List<dynamic> thisListOrder = [];
  List<dynamic> orderData = [];
  List<dynamic>qrDebt = [];

  var bottomResult=[];
  num countData=0;

  int _page=0;
  int limit=0;
  bool hasMoreData=true;
  bool isLoading=false;
  num qtyProduct=1;
  String productCode="";
  String productName="";
  String qrSearch="none";
  String isProductAction="viewProduct";
  num inputData=0;
  bool cameraValue=false;
  bool flashValue=false;

  String clientOrder="";
  String orderId="";
  String viewOption="false";

  final GlobalKey qrkey = GlobalKey(debugLabel: 'QR');
  Barcode?result;
  QRViewController?controller;
  String productCode1="";
  String productName1="";
  String price1="";
  String pcs="";
  String actionStatus="updatePrice";
  String withTotal="true";

  final List<String> _dropdownOptions = ['Name', 'Code'];
  String selectOption="Code";
String versionN="172363500";



  bool showOveray=false;




  /* picture upload*/

final fontSizeData=13.0;


  @override
  Widget build(BuildContext context) {



    //return listdata();

    /*WidgetsBinding.instance.addPostFrameCallback((_) {

      QuickBonus();
    });*/
    return Stack(
      children: [

        listdata(),
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
    //return Center(child: Text("hello"));




  }



  Widget listdata(){
    return  Column(
      children: [
        //ProfilePic().profile(),

        Padding(
          padding:const EdgeInsets.fromLTRB(8,10,8,0),
          child: Card(
            elevation:0,
            margin: const EdgeInsets.symmetric(vertical:1,horizontal:5),
            //color:Colors.white,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(15.0),
              //side: BorderSide(color:_data[0]["color_var"]??true?Colors.white:Colors.green, width: 2),
            ),

            child: ListTile(
              leading: GestureDetector(
                onTap: (){
                  getDebtWidget();
                },
                child: CircleAvatar(
                  backgroundColor:getRandomColor(),
                  child: Icon(_getRandomIcon()),
                ),
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
                                  text: "Total:",
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

                          const Icon(Icons.segment,color:Colors.orange,size:13,),
                         // Text("${(_data.isNotEmpty)?ConstantClassUtil().truncateToDecimalPlaces(_data[0]['totalStock'], 2):0}",style:GoogleFonts.pacifico(fontSize:15,color: Colors.orange,fontWeight: FontWeight.w700)),



                        ],
                      ),






                    ],
                  ),

                ],
              ),
              trailing:PopupMenuButton(
                itemBuilder:(container)=>[
                  PopupMenuItem(
                      child: GestureDetector(
                        onTap: (){
                          setState(() {
                            viewOption="false";
                          });
                          viewData('test',false);
                        },
                        child: const Column(
                          children: [
                            SizedBox(
                              height: 10,
                            ),
                            Row(
                              children: [
                                Icon(
                                  Icons.person,
                                  color: Colors.blue,
                                ),
                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("View"),
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
                      child: GestureDetector(
                        onTap: (){
                          //print("type All");
                          setState(() {
                            viewOption="true";
                          });
                          viewData('test',false);

                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.apartment,
                                  color: Colors.orange,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("Company"),
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

                        Icons.visibility, // Replace with your desired icon
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
              prefixIcon: Padding(
                padding: const EdgeInsets.fromLTRB(15, 0, 0, 0),
                child: DropdownButtonHideUnderline(
                  child: DropdownButton<String>(
                    value:selectOption,
                    onChanged: (newValue) {
                      setState(() {
                        selectOption=newValue!;
                      });
                    },
                    items: _dropdownOptions.map((option) {
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
              floatingLabelBehavior: FloatingLabelBehavior.always, // Always show the label above the TextField
            ),
            onChanged: (text) async{

              viewData(text,'search');

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
                      color:Colors.white70,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(9.0),
                        side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
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

                                  Padding(
                                    padding: const EdgeInsets.fromLTRB(0, 10, 0, 2),
                                    child:                   Text.rich(
                                        style: DefaultTextStyle.of(context).style,
                                        TextSpan(
                                            children: [


                                              TextSpan(
                                                style:TextStyle(
                                                    fontSize:fontSizeData
                                                  // color: Colors.blue, // Set the text color to red

                                                ),
                                                text: '${_data[index]['productCode'].toUpperCase()}',

                                              ),
                                              TextSpan(
                                                style:TextStyle(
                                                    fontSize:fontSizeData
                                                  // color: Colors.blue, // Set the text color to red

                                                ),
                                                text: '(',

                                              ),
                                              WidgetSpan(

                                                child: IntrinsicWidth(

                                                  stepWidth: 0.5,
                                                  child: TextField(

                                                    controller: TextEditingController(text:"${(_data[index]['pcs']=='none')?'0':_data[index]['pcs']}"),

                                                    keyboardType: TextInputType.number,
                                                    decoration: const InputDecoration(
                                                      hintText:"",
                                                      hintStyle: TextStyle(color: Colors.blue),
                                                      contentPadding: EdgeInsets.all(0),
                                                      isDense: true,



                                                    ),
                                                    style:TextStyle(
                                                      color: Colors.blue,
                                                      fontSize:fontSizeData,
                                                      // Set the text color to red

                                                    ),
                                                    onChanged: (text) {
                                                      if((int.tryParse(text) != null)){

                                                        pcs=text;
                                                        productCode1=_data[index]["productCode"];
                                                        actionStatus="updatePcs";

                                                      }
                                                      else{
                                                        (Get.put(StockQuery()).updateHideaddCart(true));
                                                      }




                                                    },
                                                  ), // set minimum width to 100
                                                ),
                                              ),
                                              TextSpan(
                                                style:TextStyle(
                                                    fontSize:fontSizeData
                                                  // color: Colors.blue, // Set the text color to red

                                                ),
                                                text: 'Pcs)',

                                              ),

                                              TextSpan(
                                                style:TextStyle(
                                                    fontSize:fontSizeData
                                                  // color: Colors.blue, // Set the text color to red

                                                ),
                                                text: '1X',

                                              ),
                                              WidgetSpan(
                                                style: DefaultTextStyle.of(context).style,
                                                child: IntrinsicWidth(
                                                  stepWidth: 0.5,
                                                  child: TextField(
                                                    controller: TextEditingController(text:"${_data[index]["price"]}"),

                                                    keyboardType: TextInputType.number,
                                                    decoration: const InputDecoration(
                                                      hintText:"",
                                                      hintStyle: TextStyle(color: Colors.blue),
                                                      contentPadding: EdgeInsets.all(0),
                                                      isDense: true,



                                                    ),
                                                    style: TextStyle(
                                                        color: Colors.blue,
                                                        fontSize:fontSizeData// Set the text color to red

                                                    ),
                                                    onChanged: (text) {

                                                      if((int.tryParse(text) != null)){
                                                        price1=text;
                                                        productCode1=_data[index]["productCode"];
                                                        actionStatus="updatePrice";

                                                      }
                                                      else{


                                                      }




                                                    },
                                                  ), // set minimum width to 100
                                                ),
                                              ),
                                            ]
                                        )
                                    ),
                                  ),


                                ],
                              ),
                            )






                          ],
                        ),

                        subtitle: Padding(
                          padding: const EdgeInsets.fromLTRB(0, 5, 0, 10),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Wrap(
                                crossAxisAlignment: WrapCrossAlignment.center,
                                children: [


                                  Text("Qty:${num.parse(_data[index]['qty'])-num.parse(_data[index]['qty_sold'])} X ${_data[index]['price']}=${(num.parse(_data[index]['qty'])-num.parse(_data[index]['qty_sold']))*num.parse(_data[index]['price'])}", style:TextStyle(
                                      fontSize:fontSizeData
                                    // color: Colors.blue, // Set the text color to red

                                  ),),


                                ],


                              ),
                              const SizedBox(height: 5,),
                              // Text("tags:${_data[index]['tags']}"),
                              Text.rich(
                                  style: DefaultTextStyle.of(context).style,
                                  TextSpan(
                                      children: [

                                        TextSpan(
                                          style:TextStyle(
                                            fontSize:fontSizeData,
                                            color: Colors.grey, // Set the text color to red

                                          ),
                                          text: 'Name:',

                                        ),

                                        WidgetSpan(
                                          //style: DefaultTextStyle.of(context).style,
                                          child: IntrinsicWidth(
                                            //stepWidth: 0.5,
                                            child:  TextField(
                                              controller: TextEditingController(text:"${(_data[index]['ProductName']).toUpperCase()}"),


                                              decoration: const InputDecoration(
                                                hintText:"",
                                                hintStyle: TextStyle(color: Colors.blue),
                                                contentPadding: EdgeInsets.all(0),
                                                isDense: true,



                                              ),
                                              style:  TextStyle(
                                                  fontSize: fontSizeData
                                                // color: Colors.blue, // Set the text color to red

                                              ),
                                              onChanged: (text) {



                                                productName1=text;
                                                productCode1=_data[index]["productCode"];
                                                actionStatus="updateProductName";







                                              },
                                            ), // set minimum width to 100
                                          ),
                                        ),
                                      ]
                                  )

                              ),

                            ],
                          ),
                        ),
                        trailing:Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            InkWell(
                              onTap: () {},
                              child: const Padding(
                                padding: EdgeInsets.all(8.0),
                                child: Icon(Icons.send, color: Colors.blue),
                              ),
                            ),

                            const SizedBox(width: 2), // Minimal gap
                            InkWell(
                              onTap: updateProducts,
                              child: const Padding(
                                padding: EdgeInsets.all(8.0), // Adjust as needed
                                child: Icon(Icons.save, color: Colors.deepOrange),
                              ),
                            ),
                          ],
                        )

                        //trailing: Text()
                      ),
                    ),
                    Positioned(
                      top: -10,
                      right: 3,
                      child: GestureDetector(
                        onTap: () {
                          /*Map<String, dynamic> jsonObject = jsonDecode(_data[index]["img_url"]);
                          if(jsonObject["numb3"]==null){
                            print("null value");
                          }
                          else{
                            print("${jsonObject["numb3"]}");
                          }*/

                          //print(_data[index]);
                          //print(Get.put(S))
                          attachPicture(_data[index]["productCode"],_data[index]["img_url"]);
                        },
                        child: Container(
                          width: 50,
                          height: 50,
                          decoration: const BoxDecoration(
                           // color: Colors.greenAccent,
                            //shape: BoxShape.circle,
                          ),
                          child: Center(
                            child: Icon(
                              Icons.attach_file,
                              size: 30,
                              color: Colors.grey[700],
                            ),
                          ),
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

    quickData();
    _scrollController.addListener(_scrollListener);

  }

  void _scrollListener() {
    if (_scrollController.offset >= _scrollController.position.maxScrollExtent &&
        !_scrollController.position.outOfRange) {
      _page=_page+10;

      quickData();
    }
  }


  @override
  void dispose() {


    _scrollController.dispose();
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
      // print("${result!.code}");
      if(result!=null)
      {
        // controller!.pauseCamera();

        bool containsProductCode = qrDebt.any((item) => item['cardUid'] == result!.code);
        if(containsProductCode)
        {
          //data already scaned

        }
        else{
          var listData={
            "cardUid":result!.code
          };
          qrDebt.insertAll(0,[listData]);

          getDebt(result!.code);


        }
        //
      }
    });
  }

  resetForm(){
    setState(() {
       productCode1="";
       productName1="";
     price1="";
     pcs="";
     actionStatus="";
    });
  }
  changeProduct(name,val){
    setState(() {
      productCode1="";
      productName1="";
      price1="";
      pcs="";
      actionStatus="";
    });
  }
  updateProducts() async{


    try {

      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await StockQuery().updateProducts(QuickBonus(uid:productCode1,productName:productName1,price:price1,giftPcs:pcs,status:actionStatus))).data;
      if(resultData["status"])
      {
       // resetForm();
        Get.snackbar("Success", productName1,backgroundColor: const Color(0xff9a1c55),
            colorText: const Color(0xffffffff),
            titleText: const Text("Updated Successfully",  style: TextStyle(
              color: Colors.white, // Set the text color here

            ),),

            icon: const Icon(Icons.access_alarm),
            duration: const Duration(seconds: 3));
        if(actionStatus=="updatePrice")
          {
            //await stockTotal("test","totalStock");
          }

        (Get.put(StockQuery()).updateHideLoader(true));


        /* setState(() {
        (Get.put(StockQuery()).updateClientDebt(resultData["result"][0]));

      });*/





      }
      else{
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      return e;
    }
  }
  getDebt(qrScanData) async{
    try {
      (Get.put(StockQuery()).updatePaidDeptScanHide(true));
      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await StockQuery().getDebt(User(uid:'none',carduid:qrScanData))).data;
      //print(resultData);
      if(resultData["status"])
      {
        (Get.put(StockQuery()).updateHideLoader(true));
        (Get.put(StockQuery()).updatePaidDeptScanHide(false));
        (Get.put(StockQuery()).updateClientDebt(resultData["result"][0]));

        /* setState(() {
        (Get.put(StockQuery()).updateClientDebt(resultData["result"][0]));

      });*/





      }
      else{
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      return e;
    }
  }
  paidDebt() async{
    try {
      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await StockQuery().paidDept(User(uid:"${(Get.put(StockQuery()).clientDebt)["uidUser"]}",inputData:inputData))).data;
      if(resultData["status"])
      {
        viewData('test',false);

        (Get.put(StockQuery()).clientDebt).clear();
        (Get.put(StockQuery()).updateHideLoader(true));

        (Get.put(StockQuery()).updateClientDebt(resultData["result"]));
        if((Get.put(StockQuery()).hideComp))
        {

        }
        else{
          Future.microtask(() {
            Navigator.of(context).pop();
          });
        }
      }
      else{
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      (Get.put(StockQuery()).updateHideLoader(true));
    }
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

  quickData()
  {
    viewData('test',"ViewProduct");

  }
  viewData(nameVal,isProductAction) async{
    if(isLoading) return;
    isLoading=true;
    int limit=10;

    String productCode=(selectOption=="Code")?nameVal:"none";
    String productNames=(selectOption=="Name")?nameVal:'none';

    var resultData=(await StockQuery().product(QuickBonus(uid:productCode,productName:productNames,status:qrSearch),Topups(optionCase:isProductAction,startlimit:limit,endlimit:_page,purpose:withTotal))).data;


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

  stockTotal(nameVal,isProductAction) async{


    var resultData=(await StockQuery().product(QuickBonus(uid:nameVal,productName:productName,status:qrSearch),Topups(optionCase:isProductAction,startlimit:limit,endlimit:_page,purpose:withTotal))).data;


    if(resultData["status"])
    {



      if(resultData["result"]!=0)
      {
        setState(() {


          _data[0]['totalStock']=((resultData["result"])[0]['totalStock']);

        });
      }
      else{

      }




    }
    else{

    }
  }
  void getDebtWidget() async{

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

                                                  Text("DEPT",style:GoogleFonts.odorMeanChey(fontSize:16,color: Colors.green,fontWeight: FontWeight.w700)),


                                                ],
                                              ),
                                              const Wrap(
                                                crossAxisAlignment: WrapCrossAlignment.center,
                                                children: [

                                                  Icon(Icons.segment,color:Colors.orange,size:13,),



                                                ],
                                              ),








                                            ],
                                          ),

                                        ],
                                      ),
                                      trailing:GestureDetector(
                                          onTap: () async{


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

                                TextField(
                                  // controller: uidEdit,

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
                                  onChanged: (value){
                                    if((num.tryParse(value) != null)){
                                      setState((){
                                        inputData=num.parse(value);

                                        //print(value);
                                      });



                                    }




                                  },


                                ),


                                const SizedBox(height: 2.0,),

                                FloatingActionButton.extended(
                                    label: const Text('Paid Dept'), // <-- Text
                                    backgroundColor: Colors.black,
                                    icon: const Icon( // <-- Icon
                                      Icons.thumb_up,
                                      size: 24.0,
                                    ),
                                    onPressed: () =>{
                                      paidDebt()

                                    }),
                              ],
                            ),
                          ),
                        ),
                      if((Get.put(StockQuery()).hideComp))
                        const SizedBox(height:2.0,),
                      //if(!(Get.put(StockQuery()).paidDeptScanHide))
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
      (Get.put(StockQuery()).updatehideComp(true));
      qrDebt.clear();
    });

  }


  thisOrder()async
  {
    if(isLoading) return;
    isLoading=true;
    int limit=10;


    var resultData=(await StockQuery().orderViewByUid(Topups(uid:"${orderData[0]}",startlimit:limit,endlimit:_page))).data;
    // var resultData=(await StockQuery().orderViewByUid(Topups(uid:"0s",startlimit:limit,endlimit:_page))).data;
    //print(resultData);
    if(resultData["status"])
    {

      return resultData;
    }
    else{
      return false;
    }




  }

  void attachPicture(productCode,imgUrl){
    imgUrl=(imgUrl=='none')?'{}':imgUrl;
    Map<String, dynamic> imgVersion = jsonDecode(imgUrl);
    //Get.put(StockQuery().updateImgVersion(imgVersion));
   // Get.put(StockQuery()).updateImgVersion(jsonDecode(img_url));
    /*setState(() {
      Get.put(StockQuery()).updateImgVersion(jsonDecode(img_url));
    });*/

    //print((Get.put(StockQuery()).imgVersion));
    //print((Get.put(StockQuery()).imgVersion)["numb1"]);
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
                        "editDisplay":"true",


                      },
                      mainImageUrl:(imgVersion["numb1"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb1"]}&img=1&ogImg=${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg?Ver=${imgVersion["numb1"]}&img=1',
                      smallImageUrls: [
                        (imgVersion["numb2"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb2"]}&img=2&ogImg=${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_2.jpg":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_2.jpg?Ver=${imgVersion["numb2"]}&img=2',
                        (imgVersion["numb3"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb3"]}&img=3&ogImg=${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_3.jpg":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_3.jpg?Ver=${imgVersion["numb1"]}&img=3',
                        (imgVersion["numb4"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb4"]}&img=4&ogImg=${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_4.jpg":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_4.jpg?Ver=${imgVersion["numb4"]}&img=4',

                      ], initialImageUrl:(imgVersion["numb1"]==null)?"${urLink}api4.jpg?Ver=${imgVersion["numb1"]}&img=1&ogImg=${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg":'$urLink${productCode}_${(Get.put(AdminQuery()).obj)["result"][0]["subscriber"]}_1.jpg?Ver=${imgVersion["numb1"]}&img=1',
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

  void viewThisOrder() {

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
              child: Column(
                children: [

                  Center(child: Text("Client:${orderData[1]}")),
                  Center(child: Text("UID:${orderData[0]}")),

                  Expanded(
                    child: ListView.builder(


                      itemCount:thisListOrder.length+1,
                      itemBuilder: (context, index) {

                        if(index<thisListOrder.length)
                        {

                          (Get.put(HideShowState())).isDelivery(thisListOrder);



                          //Get.put(HideShowState())).isDelivery(thisListOrder[index]);


                          return Container(
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
                                                    text:"${thisListOrder[index]["productName"]} (${thisListOrder[index]["pcs"]} pcs):",
                                                    style: DefaultTextStyle.of(context).style,
                                                    children: const <TextSpan>[


                                                    ],
                                                  ),
                                                ),
                                                Text("Price:${(thisListOrder[index]["price"])}"),


                                                Text.rich(
                                                    style: DefaultTextStyle.of(context).style,
                                                    TextSpan(
                                                        children: [
                                                          TextSpan(
                                                            text: 'Qty ${thisListOrder[index]["totalQty"]}:',

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
                                                                onChanged: (text) {
                                                                  if((double.tryParse(text) != null)){
                                                                    (Get.put(HideShowState()).delivery)[index]["currentQty"]=num.parse(text);



                                                                    if(((Get.put(HideShowState()).delivery)[index]["totalQty"])>=(Get.put(HideShowState()).delivery)[index]["currentQty"])
                                                                    {




                                                                      setState(() {
                                                                        (Get.put(HideShowState()).delivery)[index]["hideAddCart"]=1;


                                                                      });


                                                                    }
                                                                    else{

                                                                      setState(() {
                                                                        (Get.put(HideShowState()).delivery)[index]["hideAddCart"]=0;
                                                                      });

                                                                    }

                                                                  }
                                                                  else{

                                                                    setState(() {

                                                                      (Get.put(HideShowState()).delivery)[index]["hideAddCart"]=0;

                                                                    });

                                                                  }


                                                                },
                                                              ), // set minimum width to 100
                                                            ),
                                                          ),

                                                        ]
                                                    )
                                                ),
                                                Text("Deliver:${(((Get.put(HideShowState()).delivery)[index]["totalQty"])!=((Get.put(HideShowState()).delivery)[index]["totalCount"]))?(((Get.put(HideShowState()).delivery)[index]["totalQty"]-(Get.put(HideShowState()).delivery)[index]["totalCount"])):0}"),


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
                                              if((Get.put(HideShowState()).delivery)[index]["hideAddCart"]==1)
                                                IconButton(
                                                  icon: const Icon(Icons.add_shopping_cart,
                                                      size: 23.0,
                                                      color: Colors.grey),
                                                  onPressed: () async{
                                                    productCode=thisListOrder[index]["productCode"];


                                                    //await stockCount(index);


                                                    num totCount=(((Get.put(HideShowState()).delivery)[index]["totalCount"]-(Get.put(HideShowState()).delivery)[index]["currentQty"])>=0)?(Get.put(HideShowState()).delivery)[index]["totalCount"]:0;
                                                    if(totCount>0)
                                                    {
                                                      var resultData=(await StockQuery().stockCount(Topups(uid:"${orderData[0]}"),QuickBonus(uid:productCode,qty:"${(Get.put(HideShowState()).delivery)[index]["currentQty"]}",subscriber:"StockName",status:"status",description:"Delivered"), User(uid: "UidTransport",name:"refName"))).data;

                                                      if(resultData["status"])
                                                      {
                                                        quickData();
                                                        // thisOrder2();
                                                        setState(() {

                                                          (Get.put(HideShowState()).delivery)[index]["totalCount"]=(Get.put(HideShowState()).delivery)[index]["totalCount"]-(Get.put(HideShowState()).delivery)[index]["currentQty"];

                                                        });
                                                      }

                                                    }









                                                  },
                                                ),


                                              IconButton(
                                                icon: const Icon(
                                                    Icons.delete,
                                                    size: 23.0,
                                                    color: Colors.red
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
                                    visible: true,
                                    child: Padding(
                                      padding: const EdgeInsets.fromLTRB(8,0,8,8),
                                      child: Row(
                                        mainAxisAlignment: MainAxisAlignment.end,
                                        children: [
                                          Text("${thisListOrder[index]["totalAmount"]}"),
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
                    ),
                  ),
                ],
              ),
            );
        },
      ),
    ).whenComplete(() {
      // Get.put(HideShowState()).isDelivery(0);
      //do whatever you want after closing the bottom sheet
    });

  }


//
}


