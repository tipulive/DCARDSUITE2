import 'dart:convert';
import 'dart:math';



import '../../../Utilconfig/HideShowState.dart';

import '../../../models/Topups.dart';
import 'package:get/get.dart';

import '../../Query/AdminQuery.dart';
import '../../Query/StockQuery.dart';
import 'package:flutter/material.dart';

import 'package:google_fonts/google_fonts.dart';

import '../../Utilconfig/ConstantClassUtil.dart';
import '../../Utilconfig/image_card_widget.dart';
import '../../models/QuickBonus.dart';





class SetAllSaleComp extends StatefulWidget {
  const SetAllSaleComp({super.key});

  @override
  State<SetAllSaleComp> createState() => _SetSaleCompState();
}

class _SetSaleCompState extends State<SetAllSaleComp> {

  final ScrollController _scrollController = ScrollController();// detect scroll
  final List<dynamic> _data = [];
  List<dynamic> thisListOrder = [];
  List<dynamic> orderData = [];


  var bottomResult=[];
  num countData=0;
  String thisDate="none";
  String toDate="";
  int _page=0;
  int limit=0;
  bool hasMoreData=true;
  bool isLoading=false;
  num qtyProduct=1;
  String productCode="";

  String clientOrder="";
  String orderId="";
  String productExist="true";





  bool showOveray=false;

  String advancedSearch="today";
  String viewTitle="Today";
  final List<String> _dropdownOptions = ['Name','OrderId'];
  String selectOption="Name";

  DateTime selectedDate=DateTime.now();
  DateTimeRange selectedDateRange=DateTimeRange(
      start: DateTime.now(),
      end: DateTime.now()
  );

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
        Center(child: Text(viewTitle)),

        Padding(
          padding:const EdgeInsets.fromLTRB(8,10,8,0),
          child: Card(
            elevation:0,
            margin: const EdgeInsets.symmetric(vertical:1,horizontal:5),
            //color:Colors.white,
            color:Colors.white70,
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
                          Text("${(_data.isNotEmpty)?_data[0]['saleBalance']:0}",style:GoogleFonts.pacifico(fontSize:15,color: Colors.orange,fontWeight: FontWeight.w700)),


                        ],
                      ),






                    ],
                  ),

                ],
              ),
              trailing:PopupMenuButton(
                itemBuilder:(container)=>[
                  PopupMenuItem(
                      child: InkWell(
                        onTap: () async{
                          setState(() {
                            advancedSearch="today";
                            viewTitle="today";

                          });
                          await viewData('test',"false");

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
                          setState(() {
                            advancedSearch="week";
                            viewTitle="This Week";

                          });
                          await viewData('test',"false");
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
                  PopupMenuItem(
                      child: InkWell(
                        onTap: () async{
                          setState(() {
                            advancedSearch="month";
                            viewTitle="This Month";

                          });
                          await viewData('test',"false");
                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.calendar_month,
                                  color: Colors.orange,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("This Month"),
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
                          setState(() {

                            advancedSearch="year";
                            viewTitle="This Year";
                          });
                          await viewData('test',"false");
                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.event_available,
                                  color: Colors.orange,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("This Year"),
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

                              advancedSearch="year";
                              viewTitle="This Year";
                            });
                            await viewData('test',"false");*/
                          final DateTime? datetime= await showDatePicker(
                              context: context,
                              initialDate: selectedDate,
                              firstDate: DateTime(2024),
                              lastDate: DateTime(2100));
                          if(datetime!=null  && datetime != selectedDate){
                            setState(() {
                              advancedSearch="choosedate";
                              selectedDate=datetime;

                              thisDate="${selectedDate.year}-${selectedDate.month}-${selectedDate.day}";
                              viewTitle="Date:$thisDate";
                            });
                            Navigator.pop(context);
                            await viewData('test',"false");
                            //print("${selectedDate.year}-${selectedDate.month}-${selectedDate.day}");
                          }
                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.event_note,
                                  color: Colors.pink,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("Choose Date"),
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

                              advancedSearch="year";
                              viewTitle="This Year";
                            });
                            await viewData('test',"false");*/
                          final DateTimeRange? datetimeRange= await showDateRangePicker(
                              context: context,
                              firstDate: DateTime(2024),
                              lastDate: DateTime(2100));
                          if(datetimeRange!=null){
                            setState(() {
                              advancedSearch="choosedaterange";
                              selectedDateRange=datetimeRange;

                              thisDate="${selectedDateRange.start.year}-${selectedDateRange.start.month}-${selectedDateRange.start.day}";
                              toDate="${selectedDateRange.end.year}-${selectedDateRange.end.month}-${selectedDateRange.end.day}";
                              viewTitle="From:$thisDate To $toDate";
                            });
                            await viewData('test',"false");
                          }
                        },
                        child: const Column(
                          children: [
                            Row(
                              children: [
                                Icon(
                                  Icons.date_range,
                                  color: Colors.pink,
                                ),

                                Padding(
                                  padding: EdgeInsets.only(left:10.0),
                                  child: Text("Date Range"),
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
                          setState(() {
                            advancedSearch="mysales";
                            viewTitle="My Sales";

                          });
                          await viewData('test',"false");
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
                                  child: Text("All My Sales"),
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

              viewData(text,selectOption.toLowerCase());

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
                      color:Colors.white70,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(9.0),
                        side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
                      ),

                      child: ListTile(
                        leading: InkWell(
                          onTap: () async{
                           // print("share");

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

                                      Padding(
                                        padding: const EdgeInsets.fromLTRB(0, 10, 0, 2),
                                        child: RichText(
                                          text: TextSpan(
                                            text: "${_data[index]['name']}:",
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

                                      const Icon(Icons.segment,color:Colors.orange,size:13,),
                                      Text("${ConstantClassUtil().truncateWithEllipsis(_data[index]['OrderId'],18)}",style: const TextStyle(
                                        fontSize:12.0, // Set the font size here
                                      ),),

                                    ],
                                  ),

                                  Wrap(
                                    crossAxisAlignment: WrapCrossAlignment.center,
                                    children: [

                                      const Icon(Icons.segment,color:Colors.orange,size:13,),
                                      Text("Amount:${_data[index]['totalPaid']}"),


                                    ],
                                  ),

                                  Wrap(
                                    crossAxisAlignment: WrapCrossAlignment.center,
                                    children: [

                                      const Icon(Icons.segment,color:Colors.orange,size:13,),

                                      Text("By:${ConstantClassUtil().truncateWithEllipsis((_data[index]['adminName']).toUpperCase(), 9)}"),

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
                                  icon: const Icon(Icons.grid_view,color:Colors.orange),
                                  onPressed: () async{
                                    // This function will be called when the icon is tapped.
                                    // thisOrder(_data[index],index);

                                    setState(() {

                                      showOveray=true;



                                    });



                                    orderData=_data[index].values.toList();


                                    //print((await thisOrder())["result"]);
                                    var resultData=(await thisOrder());
                                    //print(resultData);
                                    if(resultData["status"]){
                                      //print("test this");


                                      setState(() {
                                        isLoading=false;
                                        showOveray=false;

                                        thisListOrder.clear();

                                        thisListOrder.addAll(resultData["result"]);


                                      });
                                      viewThisOrder();
                                    }
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
    super.dispose();
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

  quickData()async
  {
    viewData('test',"false");

  }
  viewData(nameVal,searchVal) async{
    if(isLoading) return;
    isLoading=true;
    int limit=10;


    var resultData=(await StockQuery().viewAnySales(Topups(startlimit:limit,endlimit:_page,name:nameVal,optionCase:"$searchVal",advancedSearch:advancedSearch,created_at:thisDate,updated_at:toDate))).data;

    print(resultData);
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
  deliverStockView(productC,uidOrder) async{

    //print(uidOrder);
    (Get.put(StockQuery()).updateHideLoader(false));


    var resultData=(await StockQuery().stockViewDeliver(Topups(uid:uidOrder,optionCase:productExist),QuickBonus(uid:productC))).data;
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
                                          color:Colors.white70,
                                          elevation: 0,
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
  void viewComment(commentData){
    Get.bottomSheet(
      Container(
        height: 200,
        padding: const EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text('$commentData'),
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

                  RichText(
                    text: TextSpan(
                      style: const TextStyle(color: Colors.black),
                      children: [

                        //TextSpan(text: "Total dettes:${totalD.toString()}"),
                        WidgetSpan(
                          child:  IconButton(
                            visualDensity: VisualDensity.compact,
                            icon: const Icon(Icons.share, color: Colors.blueAccent),
                            onPressed: ()async{
                              // print(users);
                              final List<Map<String, dynamic>> usersMap =
                              List<Map<String, dynamic>>.from(thisListOrder);

                             // final shareMsg = buildWhatsAppMessage(usersMap,orderData[1]);
                              Map<String, dynamic> users = {
                                "name": orderData[1],

                                "title": "Order Sales"
                              };
                              final shareMsg =ConstantClassUtil().buildWhatsAppMessage(usersMap,users);
                              await ConstantClassUtil().shareToWhatsApp("", shareMsg);


                            },
                          ),


                        ),
                      ],
                    ),
                  ),
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


                          return Stack(
                            children: [
                              Container(
                                margin: const EdgeInsets.fromLTRB(0, 0, 0, 0),
                                child: Card(
                                  elevation:0.5,
                                  //margin: EdgeInsets.symmetric(vertical:1,horizontal:5),
                                  color:Colors.white,
                                  //color:Colors.white70,
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(7),
                                    //side: BorderSide(color:_data[index]["color_var"]??true?Colors.white:Colors.green, width: 2),
                                  ),

                                  child: Column(
                                    children: [
                                      // Text("sum:${orderSum}"),
                                      ListTile(
                                        leading: GestureDetector(
                                          onTap:(){
                                            viewPicture(thisListOrder[index]["productCode"],thisListOrder[index]["img_url"]);

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
                                                      text:"${thisListOrder[index]["productCode"]} (${thisListOrder[index]["pcs"]} pcs):",
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
                                                            await deliverStockView((Get.put(HideShowState()).delivery)[index]["productCode"],(Get.put(HideShowState()).delivery)[index]["uid"]);
                                                          },


                                                          child: const Icon(Icons.local_shipping,color:Colors.red,size:25,)):const Text("")
                                                    ],
                                                  ),

                                                ],
                                              ),
                                            )






                                          ],
                                        ),


                                        trailing:Text("${thisListOrder[index]["totalAmount"]}"),

                                        //trailing: Text()
                                      ),


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


