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
import '../../Query/SendStockController.dart';
import '../../Query/StockQuery.dart';
import 'package:flutter/material.dart';

import 'package:google_fonts/google_fonts.dart';

import '../../Utilconfig/image_card_widget.dart';
import 'package:hive_flutter/hive_flutter.dart';

import '../../models/Participated.dart';





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
  bool showOver=false;
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
  var box=Hive.box("myBox");
  final List<String> _dropdownOptions = ['Name', 'Code'];
  String selectOption="Code";
String versionN="172363500";



  bool showOveray=false;

  final StockQuery _stockQuery = Get.find<StockQuery>();


  /* picture upload*/

final fontSizeData=13.0;

  String _selectedAction = 'Stocks';
  String sTitle='Products In Stocks';
  // Config data for action items
  final List<Map<String, dynamic>> _actions = [
    {'sTitle':'Products In Stocks','label': 'Stocks', 'icon': Icons.swap_horiz, 'color': Colors.blue,'status': 'Stocks','sStatus':''},
    {'sTitle':'Pending Products','label': 'Pending', 'icon': Icons.receipt_long, 'color': Colors.orange,'status': 'Pending','sStatus':'0'},
    {'sTitle':'Received Products','label': 'Received', 'icon': Icons.phone_android, 'color': Colors.purple,'status': 'Received','sStatus':'1'},
    {'sTitle':'Cancelled Products','label': 'Cancelled', 'icon': Icons.qr_code_scanner, 'color': Colors.teal,'status': 'Cancelled','sStatus':'2'},
  ];

  String sStatus = "";

  String adminSubscriber=Get.put(AdminQuery()).obj["result"][0]["subscriber"];
  // State Management Variables
  bool _isLoading = true;
  List<dynamic> _rawStockPayList = [];
  List<dynamic> _filteredStockPayList = [];
  // Place this inside your _SalesPageState class or as a helper list
  final List<Color> _accentColors = [
    const Color(0xFF1A315E), // Deep Navy
    Colors.teal.shade500,
    Colors.purple.shade500,
    Colors.amber.shade700,
    Colors.indigo.shade500,
    Colors.pink.shade400,    // Standard Flutter alternative to Rose
    Colors.green.shade600,   // Standard Flutter alternative to Emerald
    Colors.cyan.shade600,
    Colors.deepOrange.shade400,
    Colors.blue.shade600,
  ];

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
          padding: const EdgeInsets.symmetric(horizontal: 20.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Quick Actions',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),
              const SizedBox(height: 12),
              GridView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: _actions.length,
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 4,
                  childAspectRatio: 0.8,
                  crossAxisSpacing: 8,
                ),
                itemBuilder: (context, index) {
                  final item = _actions[index];
                  final isSelected = _selectedAction == item['status'];

                  final Color color = item['color'];

                  return _buildActionButton(
                    label: item['label'],
                    icon: item['icon'],
                    color: color,
                    isSelected: isSelected,
                    onTap: () {
                     // setState(() => _selectedAction = item['status']);
                      setState(() {
                        _selectedAction = item['status'];
                        sTitle=item['sTitle'];
                        sStatus=item['sStatus'];
                      });
                     // print('${item['label']} selected');
                      if(_selectedAction=='Stocks')
                        {

                        }else{

                        _fetchStockPayData();
                        }



                    },
                  );
                },
              ),
            ],
          ),
        ),
//mycode


        Container(
          height: 50,
          //padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
          margin: const EdgeInsets.fromLTRB(10, 10, 10, 5),
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
         Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              sTitle,
              style: const TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.bold,
                color: Color(0xFF1A315E),
              ),
            ),
          ],
        ),



        (_selectedAction=='Stocks')?Expanded(
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

                                                      if((double.tryParse(text) != null)){
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
                              onTap: () {
                                

                                sendStockQuantity(context,_data[index],_data[index]["qty"]);
                              },
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
        ):Expanded(child: _buildSalesListSection()),

      ],
    );
  }
  // Quick Action Utilities

// Sales List Section Powered by StockQuery API
  Widget _buildSalesListSection() {
    return SingleChildScrollView(
      physics: const BouncingScrollPhysics(),
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text(
                  'Recent Request Transfer',
                  style: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF1A315E),
                  ),
                ),
                TextButton(
                  onPressed: _fetchStockPayData,
                  style: TextButton.styleFrom(
                    padding: EdgeInsets.zero,
                    minimumSize: Size.zero,
                    tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                  ),
                  child: Text(
                    'Refresh',
                    style: TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                      color: Colors.blue.shade700,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),

            // Loading & Data State Handling
            if (_isLoading)
              const Center(
                child: Padding(
                  padding: EdgeInsets.symmetric(vertical: 30),
                  child: CircularProgressIndicator(color: Color(0xFF1A315E)),
                ),
              )
            else if (_filteredStockPayList.isEmpty)
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(24),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Center(
                  child: Text(
                    'No stock transfers found.',
                    style: TextStyle(color: Colors.grey, fontSize: 13),
                  ),
                ),
              )
            else
              ListView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: _filteredStockPayList.length,
                itemBuilder: (context, index) {
                  final item = _filteredStockPayList[index];

                  // Populated from dynamic payload keys
                  final String uid = item['uid'] ?? 'N/A';
                  final String name = item['name'] ?? 'N/A';
                  final String productCode = item['productCode'] ?? 'N/A';
                  final String qty = item['qty']?.toString() ?? '0';
                  final String payer = item['subscriber']  ?? 'Unknown Payer';
                  final String receiver = item['recSubscriber']  ?? 'N/A';
                  final String commentData = item['commentData'] ?? 'Stock Transfer';
                  final String createdAt = item['created_at'] ?? 'N/A';

                  // Map raw status ("1") to friendly display string
                  final String rawStatus = item['status']?.toString() ?? '0';
                 // final String status = (rawStatus == '1') ? 'COMPLETED' : 'PENDING';
                  final String status = _selectedAction;
                  final Color itemColor = _accentColors[uid.hashCode.abs() % _accentColors.length];

                  return _buildSalesItemCard(
                    salesName: '$name ($payer)',
                    uid: uid,
                    receiverSub: receiver,
                    senderSub:item['subscriber'],
                    paymentStatus: status,
                    qty:qty,
                    productCode: productCode,
                    productName:item['productName'],
                    pcs:item['pcs'],
                    imgUrl:item['img_url'],
                    price:item['price'],
                    uidSender:item['uidSender'],
                    uidReceiver:item['uidReceiver'],
                    dateCaptured: createdAt,
                    commentData: commentData,
                    accentColor: itemColor,
                    products: (item['products'] as List<dynamic>?)
                        ?.map((e) => Map<String, dynamic>.from(e))
                        .toList() ??
                        [
                          {
                            'productCode': productCode,
                            'name': name,
                            'qty': qty,
                          }
                        ],
                    onPrintPayment: () {},
                  );
                },
              ),
          ],
        ),
      ),
    );
  }

  // Modernized Individual Sales Card Widget
  Widget _buildSalesItemCard({
    required String salesName,
    required String uid,
    required String receiverSub,
    required String senderSub,
    required String paymentStatus,
    required String qty,
    required String productCode,
    required String productName,
    required String pcs,
    required String imgUrl,
    required String price,
    required String uidSender,
    required String uidReceiver,
    required String dateCaptured,
    required String commentData,
    required Color accentColor,
    required List<Map<String, dynamic>> products,
    bool isHighValue = false,
    VoidCallback? onPrintPayment,
  }) {
    // Dynamic Status Color Switch
    final String cleanStatus = paymentStatus.toUpperCase();

    Color statusBgColor;
    Color statusTextColor;

    if (cleanStatus == 'PAID' || cleanStatus == 'COMPLETED' || cleanStatus == 'SUCCESS' || cleanStatus == '1') {
      statusBgColor = Colors.green.shade50;
      statusTextColor = Colors.green.shade700;
    } else if (cleanStatus == 'FAILED' || cleanStatus == 'CANCELLED') {
      statusBgColor = Colors.red.shade50;
      statusTextColor = Colors.red.shade700;
    } else {
      // Default / PENDING -> High contrast Orange Badge
      statusBgColor = Colors.orange.shade100;
      statusTextColor = Colors.deepOrange.shade800;
    }

    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: IntrinsicHeight(
          child: Row(
            children: [
              // Dynamic Visual Accent Stripe
              Container(
                width: 4,
                color: accentColor,
              ),

              // Core Information Fields
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 14.0, vertical: 12.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Left Side: Status, UID, & Item Name
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Payment Status Badge (Top-Left)
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                  decoration: BoxDecoration(
                                    color: statusBgColor,
                                    borderRadius: BorderRadius.circular(4),
                                  ),
                                  child: Text(
                                    cleanStatus,
                                    style: TextStyle(
                                      fontSize: 8,
                                      fontWeight: FontWeight.bold,
                                      color: statusTextColor,
                                    ),
                                  ),
                                ),
                                const SizedBox(height: 4),

                                // UID Directly Below Status
                                Text(
                                  'UID: $uid',
                                  style: TextStyle(
                                    fontSize: 10,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.blue.shade800,
                                    letterSpacing: 0.3,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                                const SizedBox(height: 2),

                                // Product/Item Title
                                Text(
                                  ConstantClassUtil().capitalizeFirstLetter(productCode),
                                  style: const TextStyle(
                                    fontSize: 13,
                                    fontWeight: FontWeight.w600,
                                    color: Colors.black87,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(width: 8),

                          // Quantity / Amount Display
                          Text(
                            qty,
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF1A315E),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 10),

                      // Secondary Metadata Footer (Payer & Comments)
                      Text(
                        'Payer: $salesName',
                        style: TextStyle(fontSize: 10, color: Colors.grey.shade600),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ],
                  ),
                ),
              ),

              // Vertical Separator
              VerticalDivider(
                width: 1,
                thickness: 1,
                color: Colors.grey.shade200,
              ),

              // Right-Side Action Icons Column with Receiver Right On Top
              Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  // Receiver badge positioned directly above right icons
                  Container(
                    margin: const EdgeInsets.only(top: 6, left: 4, right: 4),
                    padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                    decoration: BoxDecoration(
                      color: const Color(0xFF1A315E).withOpacity(0.08),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Rec: $receiverSub',
                      style: const TextStyle(
                        fontSize: 8,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1A315E),
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),

                  // Actions Group
                  Column(
                    children: [
                      // Print Action
                      Tooltip(
                        message: 'Confirm Payment & Print',
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: onPrintPayment,
                            child: Padding(
                              padding: const EdgeInsets.symmetric(horizontal: 12.0, vertical: 6.0),
                              child: Icon(
                                Icons.print_outlined,
                                size: 18,
                                color: Colors.teal.shade700,
                              ),
                            ),
                          ),
                        ),
                      ),

                      // Horizontal separator between action icons
                      Container(
                        width: 20,
                        height: 1,
                        color: Colors.grey.shade200,
                      ),

                      // View Details Action
                      Tooltip(
                        message: 'View Details',
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: () => _showRequestDetailsBottomSheet(
                              uid: uid,
                              uidUser: uidSender,
                              uidReceiver: uidReceiver,
                              receiver: receiverSub,
                              status: paymentStatus,
                              clientName:salesName,
                              qty: qty,
                              purpose: commentData,
                              date: dateCaptured,
                              senderSub: senderSub,
                              uidReceiverSub: uidReceiver,
                                onConfirm: (){
                                  Get.back();
                                  //print(uidReceiver);
                                  receiveStock(uid,productCode,senderSub,qty);
                                  //print(uid);
                                },
                                onCancel: (){
                                  stockCancelStock(uid,senderSub);
                                }


                            ),
                            child: const Padding(
                              padding: EdgeInsets.symmetric(horizontal: 12.0, vertical: 6.0),
                              child: Icon(
                                Icons.visibility_outlined,
                                size: 18,
                                color: Color(0xFF1A315E),
                              ),
                            ),
                          ),
                        ),
                      ),

                      // Created Date directly under View Details
                      Padding(
                        padding: const EdgeInsets.only(bottom: 6.0, left: 4.0, right: 4.0),
                        child: Text(
                          dateCaptured,
                          style: TextStyle(
                            fontSize: 8,
                            color: Colors.grey.shade600,
                          ),
                          textAlign: TextAlign.center,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
// ------------------------------------------------------------------
// 6. DETAILS BOTTOM SHEET
// ------------------------------------------------------------------
  void _showRequestDetailsBottomSheet({
    required String uid,
    required String uidUser,
    required String uidReceiver,
    required String receiver,
    required String clientName,
    required String status,
    required String qty,
    required String purpose,
    required String date,
    required String senderSub,
    required String uidReceiverSub,
    VoidCallback? onConfirm,
    VoidCallback? onCancel,
  }) {
    debugPrint("print $uidUser $uidReceiver $status");
    Get.bottomSheet(
      Container(
        constraints: BoxConstraints(
          maxHeight: Get.height * 0.7, // Increased slightly to comfortably fit buttons
        ),
        padding: const EdgeInsets.fromLTRB(24, 16, 24, 24),
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.only(
            topLeft: Radius.circular(24),
            topRight: Radius.circular(24),
          ),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Drag handle
            Center(
              child: Container(
                width: 40,
                height: 4,
                decoration: BoxDecoration(
                  color: Colors.grey.shade300,
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
            ),
            const SizedBox(height: 16),

            // Header: Purpose & Amount
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        purpose,
                        style: const TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF1A315E),
                        ),
                      ),
                      const SizedBox(height: 2),
                      Text(
                        'Status: ${status.toUpperCase()} ',
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      ),
                      Text(
                        '• UID: $uid ',
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      ),
                      Text(
                        '• Receiver: $receiver',
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      ),
                    ],
                  ),
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    const Text(
                      'QUANTITY',
                      style: TextStyle(
                        fontSize: 9,
                        fontWeight: FontWeight.bold,
                        color: Colors.grey,
                        letterSpacing: 0.5,
                      ),
                    ),
                    Text(
                      '$qty',
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                        color: Colors.green,
                      ),
                    ),
                  ],
                ),
              ],
            ),

            const Divider(height: 24, thickness: 1),
            const SizedBox(height: 8),

            // Details section
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Payer:',
                  style: TextStyle(fontSize: 12, fontWeight: FontWeight.w500, color: Colors.grey.shade600),
                ),
                Text(
                  clientName,
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.black87),
                ),
              ],
            ),
            const SizedBox(height: 8),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Date:',
                  style: TextStyle(fontSize: 12, fontWeight: FontWeight.w500, color: Colors.grey.shade600),
                ),
                Text(
                  date,
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.black87),
                ),
              ],
            ),

            const SizedBox(height: 24),

            // Action Buttons
            Row(
              children: [

               Expanded(
                  child: OutlinedButton(
                    onPressed: () {
                      Get.back(); // Dismiss bottom sheet
                      if (onCancel != null) onCancel();
                    },
                    style: OutlinedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      side: BorderSide(color: Colors.grey.shade400),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: const Text(
                      'Cancel',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                        color: Colors.black87,
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 12),

                    Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      //Get.back(); // Dismiss bottom sheet
                      if (onConfirm != null) onConfirm();

                      //onConfirm();
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFF1A315E),
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      elevation: 0,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: const Text(
                      'Confirm',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      isScrollControlled: true,
    );
  }
  Widget _buildActionButton({
    required String label,
    required IconData icon,
    required Color color,
    required bool isSelected,
    required VoidCallback onTap,
  }) {
    return AnimatedContainer(
      duration: const Duration(milliseconds: 200),
      curve: Curves.easeInOut,
      decoration: BoxDecoration(
        color: isSelected ? Colors.white : Colors.grey.shade50,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: isSelected ? color : Colors.transparent,
          width: 1.5,
        ),
        boxShadow: isSelected
            ? [
          BoxShadow(
            color: color.withOpacity(0.15),
            blurRadius: 10,
            offset: const Offset(0, 4),
          )
        ]
            : [],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: onTap,
          borderRadius: BorderRadius.circular(16),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              AnimatedContainer(
                duration: const Duration(milliseconds: 200),
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: isSelected ? color : color.withOpacity(0.1),
                  shape: BoxShape.circle,
                ),
                child: Icon(
                  icon,
                  color: isSelected ? Colors.white : color,
                  size: 20,
                ),
              ),
              const SizedBox(height: 0),
              Text(
                label,
                style: TextStyle(
                  fontSize: 11,
                  fontWeight: isSelected ? FontWeight.bold : FontWeight.w500,
                  color: isSelected ? color : Colors.black87,
                ),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      ),
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



  void _showFeatureSnackbar(String title, String message) {
    Get.snackbar(
      title,
      message,
      snackPosition: SnackPosition.TOP,
      backgroundColor: const Color(0xFF1A315E).withOpacity(0.9),
      colorText: Colors.white,
      margin: const EdgeInsets.all(15),
      duration: const Duration(seconds: 2),
      icon: const Icon(Icons.info_outline, color: Colors.white),
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
        Get.snackbar("Success", productName1,
            backgroundColor: const Color(0xff9a1c55),
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

  // ------------------------------------------------------------------
  // 2. REQUEST PAYMENT (FIXED: no conflicting Get.back() calls)
  // ------------------------------------------------------------------
  Future<void> reqSendProduct(String qty,Map<String, dynamic> stockProduct,Map<String, dynamic> company, BuildContext context) async {
    FocusManager.instance.primaryFocus?.unfocus();

    // Show loading dialog
   // ConstantClassUtil().showLoadingDialog(message: "Sending Stocks..");

    bool success = false;

    String resultTest="";

    try {

     // print(stockProduct.runtimeType);
      int qtyData=int.parse(qty);
      //print(qtyData);

      final resultData = await _stockQuery.reqStock(
        QuickBonus(
          uid:stockProduct["productCode"],
          productName: stockProduct["ProductName"],
          //productName: stockProduct["prod"],
          giftPcs: stockProduct["pcs"],
          giftName: stockProduct["img_url"],
          price: stockProduct["price"],
          reqQty: qtyData,
          subscriber: company["subscriber"],//received subscriber
          description: "req to receive Product",

        ),
      );
     // debugPrint(stockProduct.toString());
     // debugPrint('${stockProduct["productCode"]} ${stockProduct["productName"]} ${stockProduct["pcs"]} ${stockProduct["img_url"]}${stockProduct["price"]} ${company["subscriber"]}');
      resultTest=resultData["result"];
      //print(resultData);
      if (resultData != null && resultData["status"] == true) {
        // Refresh transactions (and optionally balance)
        // await _fetchRecentTransactions();
        _showFeatureSnackbar('Transfer Products', 'you Have send ${qty} to ${company["subscriber"]}');
        ConstantClassUtil().hideLoadingDialog();
        // controller.fetchCompanyRecord(); // uncomment if you want balance refresh too
        success = true;
      }else{
        Get.snackbar(
          'Success',
          'Payment request sent successfully!',
          snackPosition: SnackPosition.TOP,
          backgroundColor: Colors.green,
          colorText: Colors.white,
        );
      }
    } catch (e) {
      debugPrint("Error Sending Products: $e");
    } finally {
      // 1. Close loading dialog if still open


      // 2. Show snackbar based on result
      if (success) {

        ConstantClassUtil().hideLoadingDialog();
        //
        setState(() {
          sStatus="0";
          _selectedAction="Pending";
        });
        _fetchStockPayData();
        Get.snackbar(
          'Success',
          'Payment request sent successfully!',
          snackPosition: SnackPosition.TOP,
          backgroundColor: Colors.green,
          colorText: Colors.white,
        );
        // 3. Close the bottom sheet only on success
        if (context.mounted) {
          Navigator.pop(context);
        }
      } else {
        print("error no data found");
        Get.snackbar(
          'Error',
          resultTest,
          snackPosition: SnackPosition.TOP,
          backgroundColor: Colors.red,
          colorText: Colors.white,
        );
      }
    }
  }

  Future<void>receiveStock(String uid,String productCode,String senderSub,qty) async//both pending and cancel
      {
        debugPrint("${uid} ${productCode} ${senderSub} ${qty}");
    var validation=ConstantClassUtil().validationTwo(senderSub,adminSubscriber,"You can not be able to Confirm This Payment because you are sender","Success fully");
    if(validation["status"]) {
      //print("hello validation $uidAuth");
      Get.snackbar(
        'Error',
        validation["message"],
        snackPosition: SnackPosition.TOP,
        backgroundColor: Colors.redAccent,
        colorText: Colors.white,
      );
    }else{
      ConstantClassUtil().showLoadingDialog(message: "Confirm receiving ......");
      try {

        int qtyData=int.parse(qty);

        // Topups parameter passed as needed by your controller
        final response = await _stockQuery.receiveStock(QuickBonus(
            uid: uid,
            productName:productCode,
            subscriber: senderSub,
            reqQty: qtyData
        ));

        if (response != null && response["status"] == true) {
          // Adjust key according to API response wrapper (e.g., response.data["result"] or response.data)

          ConstantClassUtil().hideLoadingDialog();
          setState(() {
            sStatus="2";
            _selectedAction="Received";
          });
          // print("paid receiver");
          Get.snackbar(
            'Success',
            'Payment  Received!',
            snackPosition: SnackPosition.TOP,
            backgroundColor: Colors.blueAccent,
            colorText: Colors.white,
          );
        } else {

          ConstantClassUtil().hideLoadingDialog();
        }
      } catch (e) {
        debugPrint("Error fetching stock pay details: $e");
        ConstantClassUtil().hideLoadingDialog();
      }
    }



  }


  Future<void>stockCancelStock(String uid,String senderSub) async//both pending and cancel
      {
        //print("$senderSub $adminSubscriber");
    var validation=ConstantClassUtil().validationTwo(senderSub,adminSubscriber,"You can not be able to cancel This Payment","Success fully");
    if(validation["status"])
    {
      ConstantClassUtil().showLoadingDialog(message: "Confirm receiving ......");
      try {

        // Topups parameter passed as needed by your controller
        final response = await _stockQuery.stockCancelStock(Participated(
            uid: uid,
            status: "2"
        ));

        if (response != null && response["status"] == true) {
          // Adjust key according to API response wrapper (e.g., response.data["result"] or response.data)
          ConstantClassUtil().hideLoadingDialog();
          Get.snackbar(
            'Success',
            'Request Payment Cancelled',
            snackPosition: SnackPosition.TOP,
            backgroundColor: Colors.pink,
            colorText: Colors.white,
          );

          setState(() {
            sStatus="2";
            _selectedAction="Cancelled";
          });
          _fetchStockPayData();
        } else {

          ConstantClassUtil().hideLoadingDialog();
        }
      } catch (e) {
        debugPrint("Error fetching stock pay details: $e");
        ConstantClassUtil().hideLoadingDialog();
      }
    }else{
      Get.snackbar(
        'Error',
        validation["message"],
        snackPosition: SnackPosition.TOP,
        backgroundColor: Colors.redAccent,
        colorText: Colors.white,
      );
    }




  }
  // Fetch API Data from StockQuery Controller
  Future<void> _fetchStockPayData() async {
    setState(() => _isLoading = true);

    try {
      // Topups parameter passed as needed by your controller
      final response = await _stockQuery.viewRecReqStock(Participated(
          status: sStatus
      ));

      if (response != null && response.data != null) {
        // Adjust key according to API response wrapper (e.g., response.data["result"] or response.data)
        //print(response);
        final List<dynamic> data = response.data is List
            ? response.data
            : (response.data["result"] ?? response.data["data"] ?? []);

        setState(() {
          _rawStockPayList = data;
          _filteredStockPayList = data;
          _isLoading = false;
        });
      } else {
        setState(() => _isLoading = false);
      }
    } catch (e) {
      debugPrint("Error fetching stock pay details: $e");
      setState(() => _isLoading = false);
    }
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
  Future<void> getCompData(String optionCase, String name) async {
    FocusManager.instance.primaryFocus?.unfocus();

    // 1. Show immediate loading dialog
    Get.dialog(
      const Center(
        child: CircularProgressIndicator(
          color: Colors.orange,
        ),
      ),
      barrierDismissible: false,
    );

    final stockQueryController = Get.isRegistered<StockQuery>()
        ? Get.find<StockQuery>()
        : Get.put(StockQuery());

    try {
      final ownerData = box.get('owner');
      final String uid = (ownerData != null && ownerData.isNotEmpty)
          ? ownerData[0]["uid"] ?? ""
          : "";

      final resultData = await _stockQuery.sharing(
        Topups(
          optionCase: optionCase,
          name: name,
          uid: uid,
        ),
      );

      print(resultData);
      if (resultData != null && resultData["status"] == true) {
        final rawResult = resultData["result"];

        if (rawResult is List && rawResult.isNotEmpty) {
          stockQueryController.updatecompPick(
            List<Map<String, dynamic>>.from(rawResult),
          );
        } else {
          stockQueryController.updatecompPick([]);
        }
      } else {
        stockQueryController.updatecompPick([]);
      }
    } catch (e) {
      debugPrint("Error fetching company data: $e");
      stockQueryController.updatecompPick([]);
    } finally {
      // 2. Dismiss the loading dialog when finished
      if (Get.isDialogOpen ?? false) {
        Get.back();
      }
    }
  }
  /// 1. MAIN BOTTOM SHEET: SEND STOCK QUANTITY
  void sendStockQuantity(
      BuildContext context,
      dynamic stockProduct,
      dynamic qtyData, {
        String initialQuantity = "1",
      }) {
    // Safe registration: Find existing or instantiate new controller
    final SendStockController controller = Get.isRegistered<SendStockController>()
        ? Get.find<SendStockController>()
        : Get.put(SendStockController());

    // Parse total available stock safely
    final double totalAvailable = double.tryParse(qtyData.toString()) ?? 0.0;

    // Initialize fresh state for this session
    controller.initData(initialQty: initialQuantity);

    Get.bottomSheet(
      SafeArea(
        child: Container(
          padding: EdgeInsets.only(
            bottom: MediaQuery.of(context).viewInsets.bottom,
          ),
          decoration: const BoxDecoration(
            color: Color(0xffF8F9FB),
            borderRadius: BorderRadius.vertical(
              top: Radius.circular(30),
            ),
          ),
          child: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min, // <--- Add 'MainAxisSize.' prefix here
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

                const SizedBox(height: 20),

                /// Header Title
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 24.0),
                  child: Text(
                    "Send ${ConstantClassUtil().capitalizeFirstLetter(stockProduct["productCode"].toString())}",
                    style: const TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                      letterSpacing: -0.5,
                    ),
                  ),
                ),

                const SizedBox(height: 6),

                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 24),
                  child: Text(
                    "Specify quantity and recipient company below.",
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: Colors.grey.shade600,
                      fontSize: 14,
                    ),
                  ),
                ),

                const SizedBox(height: 20),

                /// LIVE CURRENT & REMAINING STOCK TILE
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: Obx(() {
                    final enteredQty = double.tryParse(controller.quantityStr.value) ?? 0.0;
                    final remaining = totalAvailable - enteredQty;
                    final isExceeded = enteredQty > totalAvailable;

                    return Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 12,
                      ),
                      decoration: BoxDecoration(
                        color: isExceeded ? Colors.red.shade50 : Colors.orange.shade50,
                        borderRadius: BorderRadius.circular(16),
                        border: Border.all(
                          color: isExceeded ? Colors.red.shade300 : Colors.orange.shade200,
                          width: 1,
                        ),
                      ),
                      child: Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: isExceeded ? Colors.red.shade100 : Colors.orange.shade100,
                              shape: BoxShape.circle,
                            ),
                            child: Text(
                              isExceeded ? '⚠️' : '🥭',
                              style: const TextStyle(fontSize: 20),
                            ),
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Text(
                                      "Current Stock",
                                      style: TextStyle(
                                        fontSize: 12,
                                        color: isExceeded
                                            ? Colors.red.shade900
                                            : Colors.orange.shade900,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                    Text(
                                      "$qtyData Available",
                                      style: TextStyle(
                                        fontSize: 12,
                                        fontWeight: FontWeight.bold,
                                        color: isExceeded
                                            ? Colors.red.shade700
                                            : Colors.orange.shade800,
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  isExceeded
                                      ? "Exceeds available stock!"
                                      : "${remaining % 1 == 0 ? remaining.toInt() : remaining.toStringAsFixed(1)} Remaining after send",
                                  style: TextStyle(
                                    fontSize: 14,
                                    fontWeight: FontWeight.bold,
                                    color: isExceeded
                                        ? Colors.red.shade700
                                        : Colors.green.shade800,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    );
                  }),
                ),

                const SizedBox(height: 20),

                /// INLINE EDITABLE QUANTITY FIELD
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 24),
                  child: Column(
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.edit_note_rounded,
                            size: 18,
                            color: Colors.orange.shade800,
                          ),
                          const SizedBox(width: 4),
                          Text(
                            "TAP TO ENTER QUANTITY",
                            style: TextStyle(
                              fontSize: 11,
                              fontWeight: FontWeight.bold,
                              letterSpacing: 0.5,
                              color: Colors.orange.shade800,
                            ),
                          ),

                        ],
                      ),
                      const SizedBox(height: 8),

                      SizedBox(
                        width: 170,
                        child: Material(
                          elevation: 2,
                          borderRadius: BorderRadius.circular(18),
                          shadowColor: Colors.black12,
                          child: TextField(
                            controller: controller.quantityController,
                            textAlign: TextAlign.center,
                            keyboardType: const TextInputType.numberWithOptions(decimal: true),
                            autofocus: false,
                            style: TextStyle(
                              fontSize: 26,
                              fontWeight: FontWeight.bold,
                              color: Colors.orange.shade900,
                            ),
                            decoration: InputDecoration(
                              contentPadding: const EdgeInsets.symmetric(
                                vertical: 12,
                                horizontal: 16,
                              ),
                              filled: true,
                              fillColor: Colors.white,
                              hintText: "0",
                              suffixIcon: Padding(
                                padding: const EdgeInsets.only(right: 8.0),
                                child: Icon(
                                  Icons.edit_outlined,
                                  size: 18,
                                  color: Colors.orange.shade400,
                                ),
                              ),
                              suffixIconConstraints: const BoxConstraints(
                                minWidth: 24,
                                minHeight: 24,
                              ),
                              enabledBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(18),
                                borderSide: BorderSide(
                                  color: Colors.orange.shade200,
                                  width: 1.5,
                                ),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(18),
                                borderSide: BorderSide(
                                  color: Colors.orange.shade700,
                                  width: 2,
                                ),
                              ),
                            ),
                          ),
                        ),
                      ),
                      Icon(
                        Icons.comment,
                        color: Colors.grey,
                        size: 24.0,
                      )
                    ],
                  ),
                ),

                const SizedBox(height: 20),

                /// SELECT COMPANY CARD (UPDATES DYNAMICALLY)
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: Obx(() {
                    final hasCompany = controller.selectedCompany.isNotEmpty;
                    final compName = controller.selectedCompany["companyName"] ??
                        controller.selectedCompany["name"] ??
                        "Select Company";
                    final subTitle = hasCompany
                        ? (controller.selectedCompany["name"] ?? "Selected Recipient")
                        : "Tap to choose recipient";

                    return Material(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(18),
                      elevation: 1,
                      shadowColor: Colors.black12,
                      child: InkWell(
                        borderRadius: BorderRadius.circular(18),
                        onTap: () async {
                          await getCompData("view", "");
                          if (!context.mounted) return;
                          searchCompany(context);
                        },
                        child: Padding(
                          padding: const EdgeInsets.all(14),
                          child: Row(
                            children: [
                              Container(
                                width: 48,
                                height: 48,
                                decoration: BoxDecoration(
                                  color: hasCompany
                                      ? Colors.green.shade50
                                      : Colors.blue.shade50,
                                  borderRadius: BorderRadius.circular(14),
                                ),
                                child: Icon(
                                  hasCompany
                                      ? Icons.check_circle_rounded
                                      : Icons.business_rounded,
                                  color: hasCompany
                                      ? Colors.green.shade700
                                      : Colors.blue.shade700,
                                ),
                              ),
                              const SizedBox(width: 14),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      compName,
                                      style: TextStyle(
                                        fontWeight: FontWeight.w700,
                                        fontSize: 15,
                                        color: hasCompany
                                            ? Colors.black
                                            : Colors.grey.shade800,
                                      ),
                                    ),
                                    const SizedBox(height: 2),
                                    Text(
                                      subTitle,
                                      style: TextStyle(
                                        color: hasCompany
                                            ? Colors.green.shade800
                                            : Colors.grey.shade600,
                                        fontSize: 13,
                                        fontWeight: hasCompany
                                            ? FontWeight.w500
                                            : FontWeight.normal,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              Icon(
                                Icons.arrow_forward_ios_rounded,
                                size: 16,
                                color: Colors.grey.shade400,
                              ),
                            ],
                          ),
                        ),
                      ),
                    );
                  }),
                ),

                const SizedBox(height: 24),

                /// CONFIRM ACTION BUTTON (DISABLES & HIDES WHEN ENTERED QTY > AVAILABLE)
                Padding(
                  padding: const EdgeInsets.fromLTRB(20, 0, 20, 20),
                  child: Obx(() {
                    final enteredQty = double.tryParse(controller.quantityStr.value) ?? 0.0;
                    final isExceeded = enteredQty > totalAvailable;

                    // Must be valid (has recipient & quantity > 0) AND within stock limit
                    final canSend = controller.isValid && !isExceeded;

                    // Hides or disables the button when stock limit is exceeded
                    if (isExceeded) {
                      return Container(
                        width: double.infinity,
                        padding: const EdgeInsets.symmetric(vertical: 14),
                        decoration: BoxDecoration(
                          color: Colors.red.shade100,
                          borderRadius: BorderRadius.circular(18),
                        ),
                        child: Text(
                          "Cannot send: Quantity exceeds available stock",
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            color: Colors.red.shade900,
                            fontWeight: FontWeight.bold,
                            fontSize: 13,
                          ),
                        ),
                      );
                    }

                    return SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: canSend
                            ? () async{
                          final qty = controller.quantityStr.value;
                          final company = controller.selectedCompany;

                          //print(company);


                          await reqSendProduct(qty,stockProduct,company,context);
                          //await reqPayment(qty, company["uid"], context);

                          debugPrint("================================= $qty");
                          debugPrint("DISPATCH SUBMITTED $company");
                          debugPrint("Product: ${stockProduct}");
                          debugPrint("Quantity Sent: $qty");
                          debugPrint(
                            "Recipient: ${company['companyName'] ?? company['name']}",
                          );
                          debugPrint("=================================");

                          Get.back(); // Close sheet
                        }
                            : null,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.orange.shade700,
                          disabledBackgroundColor: Colors.grey.shade300,
                          foregroundColor: Colors.white,
                          disabledForegroundColor: Colors.grey.shade500,
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(18),
                          ),
                          elevation: 0,
                        ),
                        child: Text(
                          "Send ${ConstantClassUtil().capitalizeFirstLetter(stockProduct["productCode"].toString())}",
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            color: canSend ? Colors.white : Colors.grey.shade500,
                          ),
                        ),
                      ),
                    );
                  }),
                ),
              ],
            ),
          ),
        ),
      ),
      isScrollControlled: true,
    ).then((_) {
      controller.reset();
    });
  }
  /// 2. SECONDARY BOTTOM SHEET: SEARCH & SELECT COMPANY
  void searchCompany(BuildContext context) {
    final SendStockController controller = Get.find<SendStockController>();

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
                  "Choose recipient Company",
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
                  "Select a company to send your stock to.",
                  style: TextStyle(
                    color: Colors.grey.shade600,
                    fontSize: 14,
                  ),
                ),
              ),

              const SizedBox(height: 25),

              /// Search Input Field
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20),
                child: Material(
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
                        borderRadius: BorderRadius.circular(18),
                        borderSide: BorderSide.none,
                      ),
                    ),
                    onChanged: (text) {
                      // Implement search filtering logic here
                    },
                  ),
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
                  builder: (stockController) {
                    if (stockController.compPick.isEmpty) {
                      return Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
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
                      padding: const EdgeInsets.fromLTRB(20, 0, 20, 20),
                      itemCount: stockController.compPick.length,
                      separatorBuilder: (_, __) => const SizedBox(height: 12),
                      itemBuilder: (context, index) {
                        final item = stockController.compPick[index];

                        return Material(
                          color: Colors.white,
                          elevation: .5,
                          borderRadius: BorderRadius.circular(18),
                          child: InkWell(
                            borderRadius: BorderRadius.circular(18),
                            onTap: () {
                              // Assign selected company map to SendStockController
                              controller.selectCompany(
                                Map<String, dynamic>.from(item),
                              );

                              // Close search modal and return to main bottom sheet
                              Get.back();
                            },
                            child: Padding(
                              padding: const EdgeInsets.all(16),
                              child: Row(
                                children: [
                                  Container(
                                    width: 50,
                                    height: 50,
                                    decoration: BoxDecoration(
                                      color: Colors.blue.withOpacity(.08),
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    child: Icon(
                                      Icons.business,
                                      color: Colors.blue.shade700,
                                    ),
                                  ),
                                  const SizedBox(width: 16),
                                  Expanded(
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          item["companyName"] ?? "",
                                          style: const TextStyle(
                                            fontWeight: FontWeight.w700,
                                            fontSize: 16,
                                          ),
                                        ),
                                        const SizedBox(height: 4),
                                        Text(
                                          item["name"] ?? "",
                                          style: TextStyle(
                                            color: Colors.grey.shade600,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                  Icon(
                                    Icons.arrow_forward_ios_rounded,
                                    size: 16,
                                    color: Colors.grey.shade400,
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




