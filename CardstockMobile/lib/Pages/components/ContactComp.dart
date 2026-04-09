import 'dart:math';


import 'package:intl_phone_field/phone_number.dart';

import '../../../Utilconfig/HideShowState.dart';
import '../../../models/QuickBonus.dart';

import '../../../models/Topups.dart';
import '../../../models/User.dart';
import 'package:get/get.dart';

import '../../../Query/StockQuery.dart';
import 'package:flutter/material.dart';


import '../../Query/CardQuery.dart';
import '../../models/Admin.dart';
import '../../models/CardModel.dart';
import 'package:intl_phone_field/intl_phone_field.dart';
import '../../../Utilconfig/ConstantClassUtil.dart';




class ContactComp extends StatefulWidget {
  const ContactComp({super.key});

  @override
  State<ContactComp> createState() => _ContactCompState();
}

class _ContactCompState extends State<ContactComp> {

  final ScrollController _scrollController = ScrollController();// detect scroll
  final List<dynamic> _data = [];
  List<dynamic> thisListOrder = [];
  List<dynamic> orderData = [];

  ConstantClassUtil constantUtil = ConstantClassUtil();
  var bottomResult=[];
  num countData=0;
  var resultData="";

  int _page=0;
  int limit=0;
  bool hasMoreData=true;
  bool isLoading=false;
  num qtyProduct=1;
  String productCode="";


  String clientOrder="";
  String orderId="";
  bool btnExpenseHide=false;
  bool btnExpenseEditHide=false;
  TextEditingController balance=TextEditingController();
  TextEditingController purpose=TextEditingController();
  TextEditingController commentData=TextEditingController();
  TextEditingController uidEdit=TextEditingController();

  TextEditingController balanceEdit=TextEditingController();
  TextEditingController purposeEdit=TextEditingController();
  TextEditingController commentDataEdit=TextEditingController();
  String safariId="none";


  String safariName="SafariName";
  String options="others";
  num inputData=0;
  int maxLength = 15; // Set your desired maximum length

  String actionStatus="";
  int limitData=10;
  String sortOrderVal="ASC";

  String phoneNumber="none";
  String editUid="";


  TextEditingController uidData=TextEditingController();
  TextEditingController name=TextEditingController();
  TextEditingController email=TextEditingController();

  TextEditingController uidInput=TextEditingController();

  TextEditingController uidInput4=TextEditingController(text:"+243");
  TextEditingController initCountry=TextEditingController(text:"CD");
  TextEditingController uidInput5=TextEditingController(text:"Congo,Democratic Republic of the Congo");
  TextEditingController password=TextEditingController();
  TextEditingController status=TextEditingController(text:"card");
  TextEditingController carduid=TextEditingController();

  bool isValid = false;
  bool isSubmit=false;
  bool isQrShow=false;





  bool showOveray=false;



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
                leading: CircleAvatar(
                  backgroundColor:getRandomColor(),
                  child: Icon(_getRandomIcon()),
                ),



                trailing:GestureDetector(
                    onTap: () async{
                      formReset();
                      addContact();

                    },
                    child:const Icon(Icons.person_add_alt,size:35,color:Colors.orange)
                )

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

    if((int.tryParse(text) != null)){
      setState(() {
        phoneNumber=text;
      });
      viewData(text,true);
    }
    else{

      setState(() {
        phoneNumber="none";
      });
      viewData(text,true);
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
                      //color:Colors.white,
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

                                  Column(
                                    children: [

                                      Padding(
                                        padding: const EdgeInsets.fromLTRB(0, 10, 0, 2),
                                        child: RichText(
                                          text: TextSpan(
                                            text: "${_data[index]['name']}",
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

                        subtitle: Padding(
                          padding: const EdgeInsets.fromLTRB(0, 5, 0,5),
                          child: Row(
                            children: [
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Wrap(
                                    crossAxisAlignment: WrapCrossAlignment.center,
                                    children: [


                                      Text(constantUtil.truncateWithEllipsis("${(_data[index]['PhoneNumber']).toLowerCase()}", 15)),

                                    ],
                                  ),






                                ],
                              ),

                            ],
                          ),
                        ),
                        trailing: Stack(
                          children: [

                            Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                IconButton(
                                  icon: const Icon(Icons.edit),
                                  onPressed: () async{
                                    // await updateSpending(_data[index]);
                                    await editContactShow(_data[index]);
                                    // Handle the first icon tap

                                  },
                                ),

                                IconButton(
                                  icon: const Icon(Icons.delete_forever,color:Colors.redAccent),
                                  onPressed: () async{
                                    Get.dialog(
                                      AlertDialog(
                                        title: const Text('Delete'),
                                        content: Text('Do you want to Delete ${_data[index]['spendId']} ?'),
                                        actions: [
                                          ElevatedButton(
                                            style: ElevatedButton.styleFrom(

                                              //primary: Colors.grey[300],
                                              backgroundColor: Colors.red,
                                              elevation:0,
                                            ),
                                            onPressed: () async{
                                              setState(() {
                                                actionStatus="delete_OtherSpending";
                                              });
                                              uidEdit.text=_data[index]["spendId"];
                                              balance.text=_data[index]["spending"];
                                              purpose.text=_data[index]["purpose"];
                                              commentData.text=_data[index]["commentData"];


                                              updateSpendingMethod();
                                              // Get.back();
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
                                  },
                                ),
                              ],
                            ),

                          ],
                        ),

                        //trailing: Text()
                      ),
                    ),
                    Positioned(
                      top:10,
                      right: 28,


                      child: Center(
                        child: Text(
                          '${_data[index]['created_at']}',
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
    formDispose();
    super.dispose();
  }

  void formReset(){
    uidEdit.clear();
    balance.clear();
    commentData.clear();
    purpose.clear();
  }
  void formDispose(){
    uidEdit.dispose();
    balance.dispose();
    purpose.dispose();
    commentData.dispose();

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


  //

  quickData()
  {
    viewData('test',false);

  }
  viewData(nameVal,searchVal) async
  {
    if(isLoading) return;
    isLoading=true;

    var resultData=(await StockQuery().searchUser(User(uid:"",name:nameVal,phone:phoneNumber,platform:"4000",status:"offNotPick"),Topups(optionCase:"false",startlimit:limitData,searchOption:searchVal,sortOrder:sortOrderVal))).data;



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
    if(isLoading) return;
    isLoading=true;
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

  thisOrder()async
  {
    if(isLoading) return;
    isLoading=true;
    int limit=10;


    var resultData=(await StockQuery().viewSalesByUid(Topups(uid:"${orderData[0]}",startlimit:limit,endlimit:_page))).data;
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
                              elevation:0.5,
                              //margin: EdgeInsets.symmetric(vertical:1,horizontal:5),
                              //color:Colors.white,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(7),
                                //side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
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
  getDataFromNo(phoneNumber) async{

    uidData.text="";
    name.text="";
    email.text="";
    //initCountry.text="";
    password.text="";
    setState(() {
      isLoading=true;
    });

    var resultData=(await CardQuery().getNumberDetailCardOnline(Admin(uid: "tets", subscriber: "test",phone:phoneNumber,Ccode: uidInput4.text))).data;
    //return resultData;
    if(resultData["status"])
    {
      uidData.text=resultData["UserDetail"]["uid"];
      name.text="${resultData["UserDetail"]["name"]} Exist";
      email.text=resultData["UserDetail"]["email"];
      initCountry.text=resultData["UserDetail"]["initCountry"];
      password.text=resultData["UserDetail"]["password"]??'none';
      Get.put(HideShowState()).isValid(false);

      setState(() {
        isValid=true;
        isLoading=false;
      });
    }
    else{
      Get.put(HideShowState()).isValid(true);
      uidData.text="";
      name.text="";
      email.text="";
      // initCountry.text="";
      password.text="";
      setState(() {
        isValid=false;
        isLoading=false;
      });



    }
    //print(resultData);

  }
  addUserMethod() async{

    try {
      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await CardQuery().createAssignCardEventOnline(CardModel(uid:"none"),Admin(phone:uidInput.text,name:name.text,email:email.text,Ccode:uidInput4.text,initCountry:initCountry.text,country:uidInput5.text,password:password.text,uid: "no need", subscriber:"no need",status:"noCard"))).data;
     //print(resultData);
      if(resultData["status"])
      {
        setState(() {
          sortOrderVal="DESC";
        });
        viewData('test',false);
        (Get.put(StockQuery()).updateHideLoader(true));

        (Get.put(StockQuery()).updateClientDebt(resultData["result"]));
        formReset();
      }
      else{
        //print(resultData);
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      (Get.put(StockQuery()).updateHideLoader(true));
    }


  }
  editUserMethod() async{
    print(editUid);
    try {
      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await CardQuery().editAssignCardEventOnline(CardModel(uid:editUid),Admin(phone:uidInput.text,name:name.text,email:email.text,Ccode:uidInput4.text,initCountry:initCountry.text,country:uidInput5.text,password:password.text,uid: "no need", subscriber:"no need",status:"noCard"))).data;
      //print(resultData);
      if(resultData["status"])
      {

        viewData('test',false);
        (Get.put(StockQuery()).updateHideLoader(true));

        (Get.put(StockQuery()).updateClientDebt(resultData["result"]));
        formReset();
      }
      else{
        //print(resultData);
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      (Get.put(StockQuery()).updateHideLoader(true));
    }


  }
   editContactShow(Map<String, dynamic> indexData) async{
   /* uidData.text=indexData["uid"];
    name.text=indexData["name"];
    uidInput.text=indexData["PhoneNumber"];*/
     String fullPhone = indexData["PhoneNumber"];
     editUid=indexData["uid"];
     final phone = PhoneNumber.fromCompleteNumber(
       completeNumber: fullPhone,
     );

     String initialCountryCode = phone.countryISOCode; // ✅ "CD"
     uidInput.text = phone.number;
     name.text=indexData["name"];
     String clientPhone=phone.number;
     String clientName=indexData["name"];
     uidInput4.text="+${phone.countryCode}";
     uidData.text=indexData["uid"];
     Get.put(HideShowState()).isValid(true);


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
                                      title:const Row(
                                        children: [


                                          Expanded(
                                            flex: 1,
                                            child: Stack(
                                              children: [

                                                Center(child: Text("Edit User"))


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

                                  Container(
                                    padding: const EdgeInsets.fromLTRB(20, 0, 20, 0),
                                    child:  IntlPhoneField(
                                      initialCountryCode:initialCountryCode,
                                      controller: uidInput,
                                      autofocus: true,

                                      decoration: InputDecoration(
                                        labelText: 'Phone Number',
                                        border: const OutlineInputBorder(
                                          borderSide: BorderSide(),
                                        ),
                                        suffixIcon:Obx(() => Get.put(HideShowState()).isNumberValid.value?const Icon(Icons.done,color:Colors.green,):const Icon(Icons.dangerous,color:Colors.red,)),


                                      ),


                                      onChanged: (phone) async{
                                        name.text=clientName;

                                        if((uidInput.text).isPhoneNumber)
                                        {

                                            await getDataFromNo(phone.number);
                                            if(phone.number==clientPhone) {
                                              name.text=clientName;
                                              Get.put(HideShowState()).isValid(true);
                                            }
                                            name.text=clientName;



                                        }
                                        else{
                                          Get.put(HideShowState()).isValid(false);
                                          uidData.text="";
                                          name.text=clientName;
                                          email.text="";
                                          // initCountry.text="";
                                          password.text="";
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

                                          getDataFromNo(uidInput.text);
                                          if(phone.number==clientPhone) {
                                            name.text=clientName;
                                            Get.put(HideShowState()).isValid(true);
                                          }
                                          name.text=clientName;
                                        }
                                        else{
                                          Get.put(HideShowState()).isValid(false);
                                          uidData.text="";
                                          name.text=clientName;
                                          email.text="";
                                          // initCountry.text="";
                                          password.text="";
                                        }
                                        // print('Country changed to: ' + country.name);
                                        // print('Country changed to: ' + country.dialCode);
                                      },
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: uidData,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'uid',
                                        hintText: 'uid',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.fromLTRB(16,0, 16, 0),
                                    child: TextField(
                                      controller: name,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),

                                        labelText: 'name',
                                        hintText: 'name',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),


                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: email,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'email',
                                        hintText: 'email',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
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
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: initCountry,
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
                                  Visibility(
                                    visible:false,
                                    child: TextField(
                                      controller:password,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'password',
                                        hintText: 'password',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible:false,
                                    child: TextField(
                                      controller:status,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'status',
                                        hintText: 'status',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: Container(
                                      padding: const EdgeInsets.fromLTRB(16,16,16,0),
                                      child: TextField(
                                        controller:carduid,
                                        //obscureText: true,
                                        decoration: const InputDecoration(
                                          contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                          border: OutlineInputBorder(),
                                          labelText: 'cardui',
                                          hintText: 'cardui',
                                          hintStyle: TextStyle(
                                            color: Colors.grey,
                                          ),

                                        ),
                                      ),
                                    ),
                                  ),
                                  //Qr Show

                                  //Qr Show





                                  const SizedBox(height: 5.0,),
                                  Obx(() => Get.put(HideShowState()).isNumberValid.value?FloatingActionButton.extended(
                                      label: const Text('Edit User'), // <-- Text
                                      backgroundColor: Colors.black,
                                      foregroundColor: Colors.white,
                                      icon: const Icon( // <-- Icon
                                        Icons.add,
                                        size: 24.0,
                                      ),
                                      onPressed: () =>{
                                        //paidDebt()
                                        editUserMethod(),
                                        formReset(),


                                      }):const Text("")),



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
  void addContact() async{

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
                                      title:const Row(
                                        children: [


                                          Expanded(
                                            flex: 1,
                                            child: Stack(
                                              children: [

                                                Center(child: Text("Add User"))


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
                                        suffixIcon:Obx(() => Get.put(HideShowState()).isNumberValid.value?const Icon(Icons.done,color:Colors.green,):const Icon(Icons.dangerous,color:Colors.red,)),


                                      ),


                                      onChanged: (phone) async{

                                        if((uidInput.text).isPhoneNumber)
                                        {

                                          getDataFromNo(phone.number);



                                        }
                                        else{
                                          Get.put(HideShowState()).isValid(false);
                                          uidData.text="";
                                          name.text="";
                                          email.text="";
                                         // initCountry.text="";
                                          password.text="";
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

                                          getDataFromNo(uidInput.text);

                                        }
                                        else{
                                          Get.put(HideShowState()).isValid(false);
                                          uidData.text="";
                                          name.text="";
                                          email.text="";
                                         // initCountry.text="";
                                          password.text="";
                                        }
                                        // print('Country changed to: ' + country.name);
                                        // print('Country changed to: ' + country.dialCode);
                                      },
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: uidData,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'uid',
                                        hintText: 'uid',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.fromLTRB(16,0, 16, 0),
                                    child: TextField(
                                      controller: name,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),

                                        labelText: 'name',
                                        hintText: 'name',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),


                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: email,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'email',
                                        hintText: 'email',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
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
                                  Visibility(
                                    visible: false,
                                    child: TextField(
                                      controller: initCountry,
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
                                  Visibility(
                                    visible:false,
                                    child: TextField(
                                      controller:password,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'password',
                                        hintText: 'password',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible:false,
                                    child: TextField(
                                      controller:status,
                                      //obscureText: true,
                                      decoration: const InputDecoration(
                                        contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                        border: OutlineInputBorder(),
                                        labelText: 'status',
                                        hintText: 'status',
                                        hintStyle: TextStyle(
                                          color: Colors.grey,
                                        ),

                                      ),
                                    ),
                                  ),
                                  Visibility(
                                    visible: false,
                                    child: Container(
                                      padding: const EdgeInsets.fromLTRB(16,16,16,0),
                                      child: TextField(
                                        controller:carduid,
                                        //obscureText: true,
                                        decoration: const InputDecoration(
                                          contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                                          border: OutlineInputBorder(),
                                          labelText: 'cardui',
                                          hintText: 'cardui',
                                          hintStyle: TextStyle(
                                            color: Colors.grey,
                                          ),

                                        ),
                                      ),
                                    ),
                                  ),
                                  //Qr Show

                                  //Qr Show





                                  const SizedBox(height: 5.0,),
                                  Obx(() => Get.put(HideShowState()).isNumberValid.value?FloatingActionButton.extended(
                                      label: const Text('Add User'), // <-- Text
                                      backgroundColor: Colors.black,
                                      foregroundColor: Colors.white,
                                      icon: const Icon( // <-- Icon
                                        Icons.add,
                                        size: 24.0,
                                      ),
                                      onPressed: () =>{
                                        //paidDebt()
                                        addUserMethod(),
                                        formReset(),


                                      }):const Text("")),



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
  updateSpendingMethod() async{
    try {
      (Get.put(StockQuery()).updateHideLoader(false));
      var resultData=(await StockQuery().updateSpending(Topups(safariId:safariId,uid:uidEdit.text,amount:balance.text,purpose:purpose.text,optionCase:actionStatus,desc:commentData.text))).data;
      if(resultData["status"])
      {
        formReset();
        Future.microtask(() {
          Navigator.of(context).pop();
        });
        viewData('test',false);
        (Get.put(StockQuery()).updateHideLoader(true));

        (Get.put(StockQuery()).updateClientDebt(resultData["result"]));

      }
      else{
        //print(resultData);
        (Get.put(StockQuery()).updateHideLoader(true));

      }


    } catch (e) {
      (Get.put(StockQuery()).updateHideLoader(true));
    }

  }
   updateSpending(Map<String, dynamic> indexData) {
    print(indexData);
    actionStatus="Edit_otherSpending";
    uidEdit.text=indexData["uid"];
    balance.text=indexData["platform"];
    purpose.text=indexData["name"];
    commentData.text=indexData["PhoneNumber"];
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
                  child: SingleChildScrollView(
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Column(
                        children: [
                          const SizedBox(height: 10.0,),
                          const Center(child: Text("Edit Spending")),
                          Center(child: Text("${indexData["spendId"]}")),
                          const SizedBox(height: 10.0,),
                          TextField(
                            controller: uidEdit,

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


                          ),
                          const SizedBox(height: 10.0,),

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
                            controller: balance,
                            onChanged: (value){
                              if((num.tryParse(value) != null)){




                              }




                            },


                          ),

                          const SizedBox(height: 10.0,),
                          TextField(
                            controller: purpose,


                            //obscureText: true,
                            decoration: const InputDecoration(
                              contentPadding: EdgeInsets.symmetric(vertical: 3,horizontal: 3),
                              border: OutlineInputBorder(),
                              labelText: 'Purpose',
                              hintText: 'Purpose',
                              hintStyle: TextStyle(
                                color: Colors.grey,
                              ),

                            ),
                          ),
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

                          const SizedBox(height: 10.0,),
                          //if(btnExpenseEditHide)
                          FloatingActionButton.extended(
                              label: const Text('update'), // <-- Text
                              backgroundColor: Colors.black,
                              icon: const Icon( // <-- Icon
                                Icons.thumb_up,
                                size: 24.0,
                              ),
                              onPressed: () =>{

                                updateSpendingMethod(),


                              }),
                        ],
                      ),
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
            )
          ;
        },
      ),
    ).whenComplete(() {
      // Get.put(HideShowState()).isDelivery(0);
      //do whatever you want after closing the bottom sheet
    });



  }





//
}


