import 'dart:math';

import 'package:qr_code_scanner/qr_code_scanner.dart';

import '../../../Utilconfig/HideShowState.dart';
import '../../../models/QuickBonus.dart';
import '../../../models/Topups.dart';
import '../../../models/User.dart';
import 'package:get/get.dart';

import '../../Query/StockQuery.dart';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../Utilconfig/ConstantClassUtil.dart';
import '../../Query/TextListController.dart';
import 'package:url_launcher/url_launcher.dart';

import 'CheckappVersion.dart';

class SetDeptComp extends StatefulWidget {
  const SetDeptComp({super.key});

  @override
  State<SetDeptComp> createState() => _SetDeptCompState();
}

class _SetDeptCompState extends State<SetDeptComp> {
  final StockQuery myStockQuery = Get.find<StockQuery>();
  final ScrollController _scrollController = ScrollController();
  final List<dynamic> _data = [];
  List<dynamic> thisListOrder = [];
  List<dynamic> orderData = [];
  List<dynamic> qrDebt = [];

  var bottomResult = [];
  num countData = 0;

  int _page = 0;
  int limit = 0;
  bool hasMoreData = true;
  bool isLoading = false;
  num qtyProduct = 1;
  String productCode = "";
  num inputData = 0;
  bool cameraValue = false;
  bool flashValue = false;

  String clientOrder = "";
  String orderId = "";
  String viewOption = "true";

  final GlobalKey qrkey = GlobalKey(debugLabel: 'QR');
  Barcode? result;
  QRViewController? controller;
  bool botSheet = false;

  final TextListController logic = Get.put(TextListController());
  String userProfile = "";
  String userName = "";
  bool showOveray = false;
  Map<String, bool> btnHideMap = {};

  // ===== SINGLE PAYMENT METHOD =====
  Future<void> _performPayment(String clientId, String uidOwner, String amount) async {
    ConstantClassUtil().showLoadingDialog(message: "Processing payment...");

    try {

      final resultData = (await myStockQuery.paidDept2(
        User(uid: clientId, inputData: num.parse(amount), uidCreator: uidOwner),
      ));

      if (resultData["status"]) {
       // close the bottom sheet itself
        updateBtnSheet(true);
        await viewDeptUsers();
        if (Get.isDialogOpen == true) Get.back(); // close confirmation dialog
        Get.back();
        Get.back();

        // Close confirmation dialog (if any)


        // Close the loading dialog
       // ConstantClassUtil().hideLoadingDialog();

        // Close the bottom sheet


        myStockQuery.clientDebt.clear();
        myStockQuery.updateClientDebt(resultData["result"]);
      } else {
        // On error, hide loader and optionally show error snackbar
        ConstantClassUtil().hideLoadingDialog();
      }
    } catch (e) {
      ConstantClassUtil().hideLoadingDialog();
      // Handle error
    } finally {
      // Safety cleanup
      ConstantClassUtil().hideLoadingDialog();

    }
  }

  // ===== REUSABLE BOTTOM SHEET BUILDER =====
  void _showBottomSheetWithList({
    required List<dynamic> items,
    required Widget Function(BuildContext, dynamic) itemBuilder,
    required String title,
    bool showTotal = true,
  }) {
    Get.bottomSheet(
      GetBuilder<TextListController>(
        builder: (logicController) {
          final totalD = ConstantClassUtil().calcTotObjJSon(items, 'dettes');
          final double heightFactor = items.length > 1 ? 0.7 : 0.5;
          return Container(
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
                  Text(title, style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                  if (showTotal)
                    RichText(
                      text: TextSpan(
                        style: const TextStyle(color: Colors.black),
                        children: [
                          TextSpan(text: "Total: $totalD"),
                          WidgetSpan(
                            child: IconButton(
                              visualDensity: VisualDensity.compact,
                              icon: const Icon(Icons.share, color: Colors.blueAccent),
                              onPressed: () {
                                final shareMsg = buildWhatsAppMessage(
                                  List<Map<String, dynamic>>.from(items),
                                );
                                shareToWhatsApp("", shareMsg);
                              },
                            ),
                          ),
                        ],
                      ),
                    ),
                  const SizedBox(height: 5),
                  Expanded(
                    child: ListView.builder(
                      itemCount: items.length,
                      itemBuilder: (_, index) => itemBuilder(context, items[index]),
                    ),
                  ),
                ],
              ),
            ),
          );
        },
      ),
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
    ).whenComplete(() async {
      if (botSheet) {
        await viewData('test', false);
        updateBtnSheet(false);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        listdata(),
        if (showOveray)
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
  }

  Widget listdata() {
    return Column(
      children: [
        // ... (same header card as before, unchanged) ...
        Padding(
          padding: const EdgeInsets.fromLTRB(8, 10, 8, 0),
          child: Card(
            elevation: 0,
            margin: const EdgeInsets.symmetric(vertical: 1, horizontal: 5),
            color: Colors.white,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(15.0),
            ),
            child: ListTile(
              leading: GestureDetector(
                onTap: () {
                  getDebtWidget();
                },
                child: CircleAvatar(
                  backgroundColor: getRandomColor(),
                  child: Icon(_getRandomIcon()),
                ),
              ),
              title: Row(
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
                                  children: const <TextSpan>[],
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
                          const Icon(Icons.segment, color: Colors.orange, size: 13),
                          Text(
                            "${(_data.isNotEmpty) ? _data[0]['totDept'] : 0}",
                            style: GoogleFonts.pacifico(
                              fontSize: 15,
                              color: Colors.orange,
                              fontWeight: FontWeight.w700,
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ],
              ),
              trailing: PopupMenuButton(
                itemBuilder: (container) => [
                  PopupMenuItem(
                    child: InkWell(
                      onTap: () async {
                        setState(() {
                          viewOption = "false";
                        });
                        await viewData('test', false);
                      },
                      child: const Column(
                        children: [
                          SizedBox(height: 10),
                          Row(
                            children: [
                              Icon(Icons.person, color: Colors.blue),
                              Padding(
                                padding: EdgeInsets.only(left: 10.0),
                                child: Text("View"),
                              ),
                            ],
                          ),
                          Divider(height: 20, thickness: 0.2, color: Colors.grey),
                        ],
                      ),
                    ),
                  ),
                  PopupMenuItem(
                    child: InkWell(
                      onTap: () async {
                        setState(() {
                          viewOption = "true";
                        });
                        await viewData('test', false);
                      },
                      child: const Column(
                        children: [
                          Row(
                            children: [
                              Icon(Icons.apartment, color: Colors.orange),
                              Padding(
                                padding: EdgeInsets.only(left: 10.0),
                                child: Text("Company"),
                              ),
                            ],
                          ),
                          Divider(height: 20, thickness: 0.2, color: Colors.grey),
                        ],
                      ),
                    ),
                  ),
                ],
                offset: const Offset(0, 40),
                child: InkWell(
                  child: Ink(
                    decoration: ShapeDecoration(
                      color: Colors.grey.withOpacity(0.2),
                      shape: const CircleBorder(),
                    ),
                    child: const Padding(
                      padding: EdgeInsets.all(5.0),
                      child: Icon(Icons.visibility, color: Colors.pink),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ),
        Container(
          height: 55,
          margin: const EdgeInsets.fromLTRB(10, 20, 10, 10),
          child: TextField(
            decoration: InputDecoration(
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(50.0),
              ),
              labelText: 'Search name or number',
            ),
            onChanged: (text) async {
              await viewData(text, true);
            },
          ),
        ),
        Expanded(
          child: ListView.builder(
            controller: _scrollController,
            itemCount: _data.length + 1,
            itemBuilder: (context, index) {
              if (index < _data.length) {
                FocusNode test = FocusNode();
                _data[index]['focusNode'] = test;
                return Card(
                  elevation: 0,
                  color: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(9.0),
                    side: BorderSide(
                      color: _data[index]["color_var"] ?? true ? Colors.white : Colors.green,
                      width: 2,
                    ),
                  ),
                  child: ListTile(
                    leading: CircleAvatar(
                      backgroundColor: getRandomColor(),
                      child: Icon(_getRandomIcon()),
                    ),
                    title: Text(
                      _data[index]['name'].toString(),
                      style: const TextStyle(
                        fontWeight: FontWeight.w600,
                        fontSize: 16,
                      ),
                    ),
                    subtitle: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          _data[index]['Phone'].toString(),
                          style: TextStyle(color: Colors.grey.shade600),
                        ),
                        const SizedBox(height: 2),
                        Text(
                          "Dette:${_data[index]['debt']}",
                          style: const TextStyle(
                            color: Colors.green,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                    trailing: GestureDetector(
                      onTap: () async {
                        setState(() {
                          userProfile = _data[index]['myDeptId'];
                          userName = _data[index]['name'];
                        });
                        //if (Get.bottomSheet() == true) return;
                       // ConstantClassUtil().showLoadingDialog(message:"Pay Dettes..");
                        await viewDeptUsers();
                        await showConfirmBottomSheet();
                        //ConstantClassUtil().hideLoadingDialog();
                      },
                      child: const Icon(Icons.grid_view, color: Colors.orange),
                    ),
                  ),
                );
              } else {
                return Padding(
                  padding: const EdgeInsets.symmetric(vertical: 32),
                  child: Center(
                    child: hasMoreData
                        ? const CircularProgressIndicator()
                        : const Text("no more Data"),
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
  void initState() {
    super.initState();
    quickData();
    _scrollController.addListener(_scrollListener);
  }

  void _scrollListener() {
    if (_scrollController.offset >= _scrollController.position.maxScrollExtent &&
        !_scrollController.position.outOfRange) {
      _page = _page + 10;
      quickData();
    }
  }

  @override
  void dispose() {
    _scrollController.dispose();
    super.dispose();
  }

  void _onQRViewCreated(QRViewController controller) {
    this.controller = controller;
    controller.resumeCamera();
    controller.scannedDataStream.listen((scanData) async {
      setState(() {
        result = scanData;
      });
      if (result != null) {
        bool containsProductCode = qrDebt.any((item) => item['cardUid'] == result!.code);
        if (!containsProductCode) {
          var listData = {
            "cardUid": result!.code,
          };
          qrDebt.insertAll(0, [listData]);
          getDebt(result!.code);
        }
      }
    });
  }

  Future<void> shareToWhatsApp(String phone, String message) async {
    final String url =
        "whatsapp://send?phone=$phone&text=${Uri.encodeComponent(message)}";
    final Uri uri = Uri.parse(url);
    try {
      bool canLaunch = await canLaunchUrl(uri);
      if (canLaunch) {
        await launchUrl(uri, mode: LaunchMode.externalNonBrowserApplication);
      } else {
        Get.snackbar(
          "WhatsApp Required",
          "WhatsApp is not installed on this device.",
          snackPosition: SnackPosition.BOTTOM,
          backgroundColor: Colors.redAccent,
          colorText: Colors.white,
        );
      }
    } catch (e) {
      Get.snackbar(
        "Launch Error",
        "An unexpected error occurred: $e",
        snackPosition: SnackPosition.BOTTOM,
      );
    }
  }

  getDebt(qrScanData) async {
    try {
      Get.find<StockQuery>().updatePaidDeptScanHide(true);
      Get.find<StockQuery>().updateHideLoader(false);
      var resultData = (await StockQuery().getDebt(User(uid: 'none', carduid: qrScanData))).data;
      if (resultData["status"]) {
        Get.find<StockQuery>().updateHideLoader(true);
        Get.find<StockQuery>().updatePaidDeptScanHide(false);
        Get.find<StockQuery>().updateClientDebt(resultData["result"][0]);
      } else {
        Get.find<StockQuery>().updateHideLoader(true);
      }
    } catch (e) {
      return e;
    }
  }

  viewDeptUsers() async {

    ConstantClassUtil().showLoadingDialog(message:"Pay Dettes..");
    final response = await myStockQuery.checkUserDept(User(uid: userProfile));
    if (response != null) {
      final result = response.data;
      if (result["status"]) {
        logic.setUsers(result["result"]);
        ConstantClassUtil().hideLoadingDialog();
      } else {
        ConstantClassUtil().hideLoadingDialog();
        return false;
      }
    } else {
      ConstantClassUtil().hideLoadingDialog();
      return false;
    }
  }

  showPaidDetails(clientId, clientName) async {
    final response = await myStockQuery.viewPaidDeptHist(User(uid: clientId));
    if (response != null) {
      final result = response.data;
      if (result["status"]) {
        logic.setPaidtHist(result["result"]);
        setState(() {});
        _showBottomSheetWithList(
          items: logic.paidHist,
          title: "Paid History - $clientName",
          showTotal: true,
          itemBuilder: (context, user) {
            return PaidDeptHist(
              myIndex: 0,
              client: userProfile,
              clientName: userName,
              paidHist: user,
              name: userName,
              uidOwner: user["uid"]!,
              price: ConstantClassUtil().calcTotObjJSon(logic.paidHist, 'dettes'),
              shareToWhatsApp: shareToWhatsApp,
              showOrderPaidHist: showPaidDetails,
              controller: logic.getController(user["uid"]),
              updateBotSheet: updateBtnSheet,
              viewDeptUsers: viewDeptUsers,
              myFunct: () async {
                await viewData('test', false);
              },
              onPay: _performPayment, // <-- pass the payment callback
            );
          },
        );
      }
    }
  }

  showDeptDetails(clientId, clientName) async {
    final response = await myStockQuery.viewDeptDetails(User(uid: clientId));
    if (response != null) {
      final result = response.data;
      if (result["status"]) {
        logic.setDeptHist(result["result"]);
        setState(() {});
        _showBottomSheetWithList(
          items: logic.deptHist,
          title: "Department Details - $clientName",
          showTotal: true,
          itemBuilder: (context, user) {
            return OrderDeptHist(
              myIndex: 0,
              client: userProfile,
              clientName: userName,
              deptHist: user,
              name: userName,
              uidOwner: user["OrderId"]!,
              price: ConstantClassUtil().calcTotObjJSon(logic.deptHist, 'dettes'),
              shareToWhatsApp: shareToWhatsApp,
              showOrderDeptHist: showDeptDetails,
              showOrderDeptDetailHist: showOrderDeptDetailHist,
              controller: logic.getController(user["OrderId"]),
              updateBotSheet: updateBtnSheet,
              viewDeptUsers: viewDeptUsers,
              myFunct: () async {
                await viewData('test', false);
              },
              onPay: _performPayment, // <-- pass the payment callback
            );
          },
        );
      }
    }
  }

  void showOrderDeptDetailHist(orderId, clientName, orderTotal, createdAt) async {
    final response = await myStockQuery.viewSalesByUid(
        Topups(uid: orderId, startlimit: limit, endlimit: _page));
    if (response != null) {
      final result = response.data;
      if (result["status"]) {
        logic.setDeptDetailHist(result["result"]);
        _showBottomSheetWithList(
          items: logic.deptDetailHist,
          title: "Order Detail - $clientName",
          showTotal: true,
          itemBuilder: (context, user) {
            return OrderDeptDetailHist(
              myIndex: 0,
              client: userProfile,
              clientName: userName,
              deptDetailHist: user,
              name: userName,
              uidOwner: user["uid"]!,
              price: ConstantClassUtil().calcTotObjJSon(logic.deptDetailHist, 'dettes'),
              shareToWhatsApp: shareToWhatsApp,
              controller: logic.getController(user["uid"]),
              updateBotSheet: updateBtnSheet,
              viewDeptUsers: viewDeptUsers,
              myFunct: () async {
                await viewData('test', false);
              },
              onPay: _performPayment, // <-- pass the payment callback
            );
          },
        );
      }
    }
  }

  showConfirmBottomSheet() async {

    final users = logic.users;
    _showBottomSheetWithList(
      items: users,
      title: "Confirm?",
      showTotal: true,
      itemBuilder: (context, user) {
        final uid = user["uid"];
        return Obx(() => UserCard(
          myIndex: 0,
          client: userProfile,
          clientName: userName,
          name: userName,
          uidOwner: uid!,
          price: ConstantClassUtil().calcTotObjJSon(users, 'dettes'),
          shareToWhatsApp: shareToWhatsApp,
          showOrderDeptHist: showDeptDetails,
          showOrderPaidHist: showPaidDetails,
          controller: logic.getController(user["uid"]),
          updateBotSheet: updateBtnSheet,
          viewDeptUsers: viewDeptUsers,
          myFunct: () async {
            await viewData('test', false);
          },
          myhideBtn: logic.btnHideMap[uid] ?? true,
          hideBtn: (value) {
            setState(() {
              logic.btnHideMap[uid] = value;
            });
          },
          onPay: _performPayment, // <-- pass the payment callback
        ));
      },
    );
  }

  String buildWhatsAppMessage(List<Map<String, dynamic>> data) {
    int toInt(dynamic value) {
      if (value == null) return 0;
      if (value is int) return value;
      if (value is num) return value.toInt();
      if (value is String) return int.tryParse(value) ?? 0;
      return 0;
    }

    final totalAmount = data.fold<int>(
      0,
          (sum, item) => sum + toInt(item['dettes']),
    );

    final buffer = StringBuffer();
    buffer.writeln('TOTAL DETTES: $totalAmount');
    buffer.writeln('====================\n');

    const labelWidth = 8;
    for (var item in data) {
      final name = (item['Name']?.toString() ?? 'UNKNOWN').toUpperCase();
      final dettes = toInt(item['dettes']);
      final paid = toInt(item['paidAmount']);

      buffer.writeln(name);
      buffer.writeln('--------------------');
      buffer.writeln('${'Dettes'.padRight(labelWidth)}: $dettes');
      buffer.writeln('${'Paid'.padRight(labelWidth)}  : $paid\n');
      buffer.writeln('--------------------\n');
    }
    buffer.writeln('====================');
    return buffer.toString();
  }

  updateBtnSheet(bool data) {
    setState(() {
      botSheet = data;
    });
  }

  paidDebt() async {
    try {
      Get.find<StockQuery>().updateHideLoader(false);
      var resultData = (await StockQuery().paidDept(
        User(
          uid: "${Get.find<StockQuery>().clientDebt["uidUser"]}",
          inputData: inputData,
        ),
      )).data;
      if (resultData["status"]) {
        viewData('test', false);
        Get.find<StockQuery>().clientDebt.clear();
        Get.find<StockQuery>().updateHideLoader(true);
        Get.find<StockQuery>().updateClientDebt(resultData["result"]);
        if (!Get.find<StockQuery>().hideComp) {
          Future.microtask(() {
            Navigator.of(context).pop();
          });
        }
      } else {
        Get.find<StockQuery>().updateHideLoader(true);
      }
    } catch (e) {
      Get.find<StockQuery>().updateHideLoader(true);
    }
  }

  Widget cameraSwitch() => Transform.scale(
    scale: 1,
    child: Switch.adaptive(
      activeColor: Colors.red,
      activeTrackColor: Colors.red.withOpacity(0.4),
      inactiveThumbColor: Colors.orange,
      inactiveTrackColor: Colors.blueAccent,
      value: cameraValue,
      onChanged: (value) async {
        setState(() {
          cameraValue = value;
        });
        await controller!.resumeCamera();
      },
    ),
  );

  Widget flashSwitch() => Transform.scale(
    scale: 1,
    child: Switch.adaptive(
      activeColor: Colors.red,
      activeTrackColor: Colors.red.withOpacity(0.4),
      inactiveThumbColor: Colors.orange,
      inactiveTrackColor: Colors.blueAccent,
      value: flashValue,
      onChanged: (value) async {
        setState(() {
          flashValue = value;
        });
        await controller!.toggleFlash();
      },
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
    List<IconData> icons = [
      Icons.favorite,
      Icons.star,
      Icons.thumb_up,
      Icons.access_time,
      Icons.access_time,
      Icons.fastfood,
      Icons.directions_bike,
      Icons.directions_walk,
      Icons.directions_car,
      Icons.directions_boat,
      Icons.airplanemode_active,
      Icons.airport_shuttle,
      Icons.beach_access,
      Icons.camera,
      Icons.movie,
      Icons.music_note,
      Icons.spa,
      Icons.palette,
      Icons.account_balance,
      Icons.attach_money,
    ];
    return icons[random.nextInt(icons.length)];
  }

  quickData() {
    viewData('test', false);
  }

  viewData(nameVal, searchVal) async {
    if (isLoading) return;
    isLoading = true;
    int limit = 20;
    var phone = ((int.tryParse(nameVal) != null)) ? nameVal : "none";
    var resultData = (await StockQuery().viewDept(
      Topups(
        startlimit: limit,
        endlimit: _page,
        name: nameVal,
        phone: phone,
        searchOption: searchVal,
        optionCase: viewOption,
      ),
    )).data;

    if (resultData["status"]) {
      if (resultData["result"] != 0) {
        setState(() {
          isLoading = false;
          hasMoreData = false;
          _data.clear();
          _data.addAll(resultData["result"]);
        });
      } else {
        setState(() {
          isLoading = false;
          hasMoreData = false;
          _data.clear();
        });
      }
    } else {
      setState(() {
        isLoading = false;
        hasMoreData = false;
        _data.clear();
      });
      if (resultData["result"] == 1) {
        var myResult = resultData;
        checkAppVersion(
          title: "error",
          message: myResult["error"],
          primaryButtonText: "Download",
          primaryButtonUrl: myResult["downNew"],
        );
      }
    }
  }

  void getDebtWidget() async {
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return Stack(
            children: [
              Container(
                padding: const EdgeInsets.all(2.0),
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
                    GetBuilder<StockQuery>(
                      builder: (controller) {
                        return Column(
                          children: [
                            Padding(
                              padding: const EdgeInsets.fromLTRB(8, 5, 8, 0),
                              child: Card(
                                elevation: 0,
                                margin: const EdgeInsets.symmetric(vertical: 1, horizontal: 5),
                                color: Colors.white,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(15.0),
                                ),
                                child: ListTile(
                                  leading: CircleAvatar(
                                    backgroundColor: getRandomColor(),
                                    child: Icon(_getRandomIcon()),
                                  ),
                                  title: Row(
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
                                                      text:
                                                      "${Get.find<StockQuery>().clientDebt["name"]}",
                                                      style: DefaultTextStyle.of(context).style,
                                                      children: const <TextSpan>[],
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
                                              Text(
                                                "Dept",
                                                style: GoogleFonts.poppins(
                                                  fontSize: 14,
                                                  color: Colors.green,
                                                  fontWeight: FontWeight.w700,
                                                ),
                                              ),
                                            ],
                                          ),
                                          Wrap(
                                            crossAxisAlignment: WrapCrossAlignment.center,
                                            children: [
                                              const Icon(Icons.segment, color: Colors.orange, size: 13),
                                              Text(
                                                "${Get.find<StockQuery>().clientDebt["debt"]}",
                                                style: GoogleFonts.pacifico(
                                                  fontSize: 15,
                                                  color: Colors.orange,
                                                  fontWeight: FontWeight.w700,
                                                ),
                                              ),
                                            ],
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                  trailing: GestureDetector(
                                    onTap: () async {},
                                    child: const Icon(Icons.grid_view, color: Colors.orange),
                                  ),
                                ),
                              ),
                            ),
                          ],
                        );
                      },
                    ),
                    if (Get.find<StockQuery>().paidDeptScanHide)
                      Container(
                        padding: const EdgeInsets.fromLTRB(5, 0, 10, 0),
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
                              const SizedBox(height: 5.0),
                              TextField(
                                keyboardType: TextInputType.number,
                                decoration: const InputDecoration(
                                  contentPadding: EdgeInsets.symmetric(vertical: 3, horizontal: 3),
                                  border: OutlineInputBorder(),
                                  labelText: 'Enter Amount',
                                  hintText: 'Enter Amount',
                                  hintStyle: TextStyle(color: Colors.grey),
                                ),
                                onChanged: (value) {
                                  if ((num.tryParse(value) != null)) {
                                    setState(() {
                                      inputData = num.parse(value);
                                    });
                                  }
                                },
                              ),
                              const SizedBox(height: 2.0),
                              FloatingActionButton.extended(
                                label: const Text('Paid Dept'),
                                backgroundColor: Colors.black,
                                icon: const Icon(Icons.thumb_up, size: 24.0),
                                onPressed: () => paidDebt(),
                              ),
                            ],
                          ),
                        ),
                      ),
                    if (Get.find<StockQuery>().hideComp) const SizedBox(height: 2.0),
                    Expanded(
                      flex: 5,
                      child: Stack(
                        alignment: Alignment.bottomCenter,
                        children: [
                          QRView(
                            key: qrkey,
                            onQRViewCreated: _onQRViewCreated,
                            overlay: QrScannerOverlayShape(
                              borderColor: Colors.pink,
                              borderRadius: 10,
                              borderLength: 30,
                              borderWidth: 10,
                              cutOutSize: 300,
                            ),
                          ),
                          Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Row(
                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                children: [
                                  cameraSwitch(),
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
                    ),
                  ],
                ),
              ),
              GetBuilder<StockQuery>(
                builder: (myLoadercontroller) {
                  return (myLoadercontroller.hideLoader)
                      ? const Text("")
                      : Positioned.fill(
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
      Get.find<StockQuery>().updatehideComp(true);
      qrDebt.clear();
    });
  }

  thisOrder2() async {
    if (isLoading) return;
    isLoading = true;
    int limit = 10;
    var resultData =
        (await StockQuery().orderViewByUid(Topups(uid: "${orderData[0]}", startlimit: limit, endlimit: _page)))
            .data;
    if (resultData["status"]) {
      setState(() {
        isLoading = false;
        hasMoreData = false;
        thisListOrder.clear();
        thisListOrder.addAll(resultData["result"]);
      });
      return true;
    } else {
      return false;
    }
  }

  thisOrder() async {
    if (isLoading) return;
    isLoading = true;
    int limit = 10;
    var resultData =
        (await StockQuery().orderViewByUid(Topups(uid: "${orderData[0]}", startlimit: limit, endlimit: _page)))
            .data;
    if (resultData["status"]) {
      return resultData;
    } else {
      return false;
    }
  }

  void viewThisOrder() {
    Get.bottomSheet(
      StatefulBuilder(
        builder: (BuildContext context, StateSetter setState) {
          return Container(
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
                Center(child: Text("Client:${orderData[1]}")),
                Center(child: Text("UID:${orderData[0]}")),
                Expanded(
                  child: ListView.builder(
                    itemCount: thisListOrder.length + 1,
                    itemBuilder: (context, index) {
                      if (index < thisListOrder.length) {
                        Get.find<HideShowState>().isDelivery(thisListOrder);
                        return Container(
                          margin: const EdgeInsets.fromLTRB(0, 0, 0, 0),
                          child: Card(
                            elevation: 0,
                            color: Colors.white,
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
                                            RichText(
                                              text: TextSpan(
                                                text:
                                                "${thisListOrder[index]["productName"]} (${thisListOrder[index]["pcs"]} pcs):",
                                                style: DefaultTextStyle.of(context).style,
                                                children: const <TextSpan>[],
                                              ),
                                            ),
                                            Text("Price:${thisListOrder[index]["price"]}"),
                                            Text.rich(
                                              TextSpan(
                                                children: [
                                                  TextSpan(
                                                      text:
                                                      'Qty ${thisListOrder[index]["totalQty"]}:'),
                                                  WidgetSpan(
                                                    child: IntrinsicWidth(
                                                      stepWidth: 0.5,
                                                      child: TextField(
                                                        keyboardType: TextInputType.number,
                                                        decoration: const InputDecoration(
                                                          hintText: '-1-',
                                                          hintStyle: TextStyle(color: Colors.red),
                                                          contentPadding: EdgeInsets.all(0),
                                                          isDense: true,
                                                        ),
                                                        style: const TextStyle(color: Colors.blue),
                                                        onChanged: (text) {
                                                          if ((double.tryParse(text) != null)) {
                                                            Get.find<HideShowState>()
                                                                .delivery[index]["currentQty"] =
                                                                num.parse(text);
                                                            if (Get.find<HideShowState>()
                                                                .delivery[index]["totalQty"] >=
                                                                Get.find<HideShowState>()
                                                                    .delivery[index]["currentQty"]) {
                                                              setState(() {
                                                                Get.find<HideShowState>()
                                                                    .delivery[index]["hideAddCart"] =
                                                                1;
                                                              });
                                                            } else {
                                                              setState(() {
                                                                Get.find<HideShowState>()
                                                                    .delivery[index]["hideAddCart"] =
                                                                0;
                                                              });
                                                            }
                                                          } else {
                                                            setState(() {
                                                              Get.find<HideShowState>()
                                                                  .delivery[index]["hideAddCart"] =
                                                              0;
                                                            });
                                                          }
                                                        },
                                                      ),
                                                    ),
                                                  ),
                                                ],
                                              ),
                                            ),
                                            Text(
                                              "Deliver:${(Get.find<HideShowState>().delivery[index]["totalQty"] != Get.find<HideShowState>().delivery[index]["totalCount"]) ? (Get.find<HideShowState>().delivery[index]["totalQty"] - Get.find<HideShowState>().delivery[index]["totalCount"]) : 0}",
                                            ),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                  trailing: Column(
                                    children: [
                                      Row(
                                        mainAxisSize: MainAxisSize.min,
                                        children: <Widget>[
                                          if (Get.find<HideShowState>()
                                              .delivery[index]["hideAddCart"] ==
                                              1)
                                            IconButton(
                                              icon: const Icon(Icons.add_shopping_cart,
                                                  size: 23.0, color: Colors.grey),
                                              onPressed: () async {
                                                productCode = thisListOrder[index]["productCode"];
                                                num totCount = (Get.find<HideShowState>()
                                                    .delivery[index]["totalCount"] -
                                                    Get.find<HideShowState>()
                                                        .delivery[index]["currentQty"]) >=
                                                    0
                                                    ? Get.find<HideShowState>()
                                                    .delivery[index]["totalCount"]
                                                    : 0;
                                                if (totCount > 0) {
                                                  var resultData = (await StockQuery()
                                                      .stockCount(
                                                    Topups(uid: "${orderData[0]}"),
                                                    QuickBonus(
                                                      uid: productCode,
                                                      qty:
                                                      "${Get.find<HideShowState>().delivery[index]["currentQty"]}",
                                                      subscriber: "StockName",
                                                      status: "status",
                                                      description: "Delivered",
                                                    ),
                                                    User(uid: "UidTransport", name: "refName"),
                                                  ))
                                                      .data;
                                                  if (resultData["status"]) {
                                                    quickData();
                                                    setState(() {
                                                      Get.find<HideShowState>()
                                                          .delivery[index]["totalCount"] =
                                                          Get.find<HideShowState>()
                                                              .delivery[index]["totalCount"] -
                                                              Get.find<HideShowState>()
                                                                  .delivery[index]["currentQty"];
                                                    });
                                                  }
                                                }
                                              },
                                            ),
                                          IconButton(
                                            icon: const Icon(Icons.delete, size: 23.0, color: Colors.red),
                                            onPressed: () {},
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),
                                Visibility(
                                  visible: true,
                                  child: Padding(
                                    padding: const EdgeInsets.fromLTRB(8, 0, 8, 8),
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
                      } else {
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
    ).whenComplete(() {});
  }
}

// ===== UPDATED STATELESS WIDGETS (with onPay callback) =====

class UserCard extends StatelessWidget {
  final String client;
  final String clientName;
  final String name;
  final String uidOwner;
  final double price;
  final int myIndex;
  final TextEditingController controller;
  final VoidCallback myFunct;
  final Function(bool) updateBotSheet;
  final Function(bool) hideBtn;
  final bool myhideBtn;
  final Function() viewDeptUsers;
  final Function(String, String) shareToWhatsApp;
  final Function(String, String) showOrderDeptHist;
  final Function(String, String) showOrderPaidHist;
  final Future<void> Function(String, String, String) onPay; // <-- added

  const UserCard({
    super.key,
    required this.client,
    required this.clientName,
    required this.name,
    required this.uidOwner,
    required this.price,
    required this.myIndex,
    required this.controller,
    required this.myFunct,
    required this.hideBtn,
    required this.myhideBtn,
    required this.updateBotSheet,
    required this.viewDeptUsers,
    required this.shareToWhatsApp,
    required this.showOrderDeptHist,
    required this.showOrderPaidHist,
    required this.onPay, // <-- required
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
              Container(
                height: 4,
                width: 40,
                margin: const EdgeInsets.only(bottom: 16),
                decoration: BoxDecoration(
                  color: Colors.grey[400],
                  borderRadius: BorderRadius.circular(2),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(12.0),
                child: Row(
                  children: [
                    const Icon(Icons.person, color: Colors.blue),
                    const SizedBox(width: 16),
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          ConstantClassUtil().truncateWithEllipsis(
                              ConstantClassUtil().capitalizeFirstLetter(name), 12),
                          style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
                        ),
                        const Text("Name", style: TextStyle(color: Colors.grey, fontSize: 15)),
                      ],
                    ),
                    const Spacer(),
                    IconButton(
                      visualDensity: VisualDensity.compact,
                      icon: const Icon(Icons.grid_4x4_rounded, color: Colors.grey),
                      onPressed: () async {
                        await showOrderPaidHist(client, clientName);
                      },
                    ),
                    IconButton(
                      visualDensity: VisualDensity.compact,
                      icon: const Icon(Icons.grid_4x4_rounded, color: Colors.orange),
                      onPressed: () async {
                        await showOrderDeptHist(client, clientName);
                      },
                    ),
                    IconButton(
                      visualDensity: VisualDensity.compact,
                      icon: const Icon(Icons.share, color: Colors.blueAccent),
                      onPressed: () async {
                        String shareMsg =
                            "Muraho, $clientName Afite Ideni rya ${price.toString()} Asabwa kwishyura $name .";
                        await shareToWhatsApp("", shareMsg);
                      },
                    ),
                  ],
                ),
              ),
              const Divider(),
              ListTile(
                leading: const Icon(Icons.monetization_on, color: Colors.orange),
                title: Text(
                  price.toString(),
                  style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
                ),
                subtitle: const Text("Price"),
              ),
              Padding(
                padding: const EdgeInsets.only(right: 8, left: 8),
                child: Align(
                  alignment: Alignment.centerRight,
                  child: TextField(
                    controller: controller,
                    textInputAction: TextInputAction.search,
                    keyboardType: TextInputType.number,
                    onChanged: (value) {
                      final isValid = double.tryParse(value) != null && value.isNotEmpty;
                      if (isValid != myhideBtn) {
                        hideBtn(isValid);
                      }
                    },
                    decoration: InputDecoration(
                      hintText: 'Ayo Ngiye Kwishyura ',
                      suffixIcon: Padding(
                        padding: const EdgeInsets.only(right: 4),
                        child: (myhideBtn)
                            ? TextButton.icon(
                          icon: const Icon(Icons.payment, size: 18),
                          label: const Text('Pay'),
                          onPressed: () {
                            var amount = controller.text;
                            if (amount.isNotEmpty) {
                              Get.dialog(
                                AlertDialog(
                                  title: const Text('Confirmation?'),
                                  content: Text.rich(
                                    TextSpan(
                                      text: 'urashakako ',
                                      style: const TextStyle(color: Colors.black, fontSize: 16),
                                      children: [
                                        TextSpan(
                                          text: ConstantClassUtil()
                                              .capitalizeFirstLetter(clientName),
                                          style: const TextStyle(
                                              color: Colors.blue,
                                              fontWeight: FontWeight.bold),
                                        ),
                                        const TextSpan(text: ' Yishyura '),
                                        const TextSpan(text: ' amafaranga '),
                                        TextSpan(
                                          text: amount,
                                          style: const TextStyle(
                                              color: Colors.orange,
                                              fontWeight: FontWeight.bold,
                                              backgroundColor: Colors.black12),
                                        ),
                                      ],
                                    ),
                                  ),
                                  actions: [
                                    ElevatedButton(
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: Colors.red,
                                        elevation: 0,
                                      ),
                                      onPressed: () async {
                                        // Use the callback
                                        await onPay(client, uidOwner, amount);
                                      },
                                      child: const Text('Yes', style: TextStyle(color: Colors.white)),
                                    ),
                                    ElevatedButton(
                                      onPressed: () {
                                        if (Get.isDialogOpen == true) {
                                          Get.back();
                                        }
                                      },
                                      child: const Text('Close'),
                                    ),
                                  ],
                                ),
                              );
                            } else {
                              Get.dialog(
                                AlertDialog(
                                  title: const Text('Error !!!'),
                                  content: Text.rich(
                                    TextSpan(
                                      text: ConstantClassUtil().capitalizeFirstLetter(clientName),
                                      style: const TextStyle(
                                          color: Colors.blue, fontWeight: FontWeight.bold),
                                      children: const [
                                        TextSpan(
                                          text: "Please Fill first Price Field ",
                                          style: TextStyle(color: Colors.black, fontSize: 16),
                                        ),
                                      ],
                                    ),
                                  ),
                                  actions: [
                                    ElevatedButton(
                                      onPressed: () {
                                        if (Get.isDialogOpen == true) {
                                          Get.back();
                                        }
                                      },
                                      child: const Text('Close'),
                                    ),
                                  ],
                                ),
                              );
                            }
                          },
                          style: TextButton.styleFrom(
                            foregroundColor: Colors.white,
                            backgroundColor: Theme.of(context).colorScheme.primary,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(8),
                            ),
                          ),
                        )
                            : const Icon(Icons.warning, color: Colors.red, size: 28),
                      ),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(8),
                      ),
                    ),
                  ),
                ),
              ),
              const SizedBox(height: 15),
            ],
          ),
        ),
      ),
    );
  }
}

class OrderDeptHist extends StatelessWidget {
  final String client;
  final String clientName;
  final String name;
  final String uidOwner;
  final double price;
  final int myIndex;
  final Map<String, dynamic> deptHist;
  final TextEditingController controller;
  final VoidCallback myFunct;
  final Function(bool) updateBotSheet;
  final Function() viewDeptUsers;
  final Function(String, String) shareToWhatsApp;
  final Function(String, String) showOrderDeptHist;
  final Function(String, String, String, String) showOrderDeptDetailHist;
  final Future<void> Function(String, String, String) onPay; // <-- added

  const OrderDeptHist({
    super.key,
    required this.client,
    required this.clientName,
    required this.name,
    required this.deptHist,
    required this.uidOwner,
    required this.price,
    required this.myIndex,
    required this.controller,
    required this.myFunct,
    required this.updateBotSheet,
    required this.viewDeptUsers,
    required this.shareToWhatsApp,
    required this.showOrderDeptHist,
    required this.showOrderDeptDetailHist,
    required this.onPay, // <-- required
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
          child: Stack(
            children: [
              Column(
                children: [
                  Container(
                    height: 4,
                    width: 40,
                    margin: const EdgeInsets.only(bottom: 16),
                    decoration: BoxDecoration(
                      color: Colors.grey[400],
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(12.0),
                    child: Row(
                      children: [
                        const Icon(Icons.person, color: Colors.blue),
                        const SizedBox(width: 16),
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              ConstantClassUtil().truncateWithEllipsis(
                                  ConstantClassUtil().capitalizeFirstLetter(deptHist["creator"]), 12),
                              style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
                            ),
                            Text("User Paid:${deptHist["orderUserPaid"]}",
                                style: const TextStyle(color: Colors.grey, fontSize: 13)),
                            Text("Ideni:${deptHist["debt"]}",
                                style: const TextStyle(color: Colors.red, fontSize: 13)),
                          ],
                        ),
                        const Spacer(),
                        IconButton(
                          visualDensity: VisualDensity.compact,
                          icon: const Icon(Icons.grid_4x4_rounded, color: Colors.orange),
                          onPressed: () async {
                            await showOrderDeptDetailHist(
                                deptHist["OrderId"], deptHist["creator"], deptHist["orderTotal"], deptHist["created_at"]);
                          },
                        ),
                        IconButton(
                          visualDensity: VisualDensity.compact,
                          icon: const Icon(Icons.share, color: Colors.blueAccent),
                          onPressed: () async {
                            String shareMsg =
                                "Muraho, $clientName Afite Ideni rya ${price.toString()} Asabwa kwishyura $name .";
                            await shareToWhatsApp("", shareMsg);
                          },
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              Positioned(
                top: 10,
                left: 15,
                child: Center(
                  child: Text(
                    'Uid:${deptHist["OrderId"]}',
                    style: const TextStyle(color: Colors.deepOrange, fontSize: 10),
                  ),
                ),
              ),
              Positioned(
                top: 10,
                right: 15,
                child: Center(
                  child: Text(
                    '${deptHist["created_at"]}',
                    style: const TextStyle(color: Colors.deepOrange, fontSize: 10),
                  ),
                ),
              ),
              Positioned(
                bottom: 10,
                right: 28,
                child: Center(
                  child: Text(
                    'Total:${deptHist["orderTotal"]}',
                    style: const TextStyle(color: Colors.green, fontSize: 10),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class OrderDeptDetailHist extends StatelessWidget {
  final String client;
  final String clientName;
  final String name;
  final String uidOwner;
  final double price;
  final int myIndex;
  final Map<String, dynamic> deptDetailHist;
  final TextEditingController controller;
  final VoidCallback myFunct;
  final Function(bool) updateBotSheet;
  final Function() viewDeptUsers;
  final Function(String, String) shareToWhatsApp;
  final Future<void> Function(String, String, String) onPay; // <-- added

  const OrderDeptDetailHist({
    super.key,
    required this.client,
    required this.clientName,
    required this.name,
    required this.deptDetailHist,
    required this.uidOwner,
    required this.price,
    required this.myIndex,
    required this.controller,
    required this.myFunct,
    required this.updateBotSheet,
    required this.viewDeptUsers,
    required this.shareToWhatsApp,
    required this.onPay, // <-- required
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
      child: Card(
        elevation: 4,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        child: Padding(
          padding: const EdgeInsets.all(0),
          child: Stack(
            children: [
              Column(
                children: [
                  Container(
                    height: 4,
                    width: 40,
                    margin: const EdgeInsets.only(bottom: 10),
                    decoration: BoxDecoration(
                      color: Colors.grey[400],
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(12.0),
                    child: Row(
                      children: [
                        const Icon(Icons.person, color: Colors.blue),
                        const SizedBox(width: 16),
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              "${ConstantClassUtil().truncateWithEllipsis(ConstantClassUtil().capitalizeFirstLetter(deptDetailHist["productCode"]), 18)}(${deptDetailHist["pcs"]} pcs)",
                              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold),
                            ),
                            Text("price:${deptDetailHist["price"]}",
                                style: const TextStyle(color: Colors.grey, fontSize: 13)),
                            Text("qty:${deptDetailHist["totalQty"]}",
                                style: const TextStyle(color: Colors.red, fontSize: 13)),
                          ],
                        ),
                        const Spacer(),
                        IconButton(
                          visualDensity: VisualDensity.compact,
                          icon: const Icon(Icons.share, color: Colors.blueAccent),
                          onPressed: () async {
                            String shareMsg =
                                "Muraho, $clientName Afite Ideni rya ${price.toString()} Asabwa kwishyura $name .";
                            await shareToWhatsApp("", shareMsg);
                          },
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              Positioned(
                bottom: 10,
                right: 28,
                child: Center(
                  child: Text(
                    'Total:${deptDetailHist["totalAmount"]}',
                    style: const TextStyle(color: Colors.green, fontSize: 12),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class PaidDeptHist extends StatelessWidget {
  final String client;
  final String clientName;
  final String name;
  final String uidOwner;
  final Map<String, dynamic> paidHist;
  final double price;
  final int myIndex;
  final TextEditingController controller;
  final VoidCallback myFunct;
  final Function(bool) updateBotSheet;
  final Function() viewDeptUsers;
  final Function(String, String) shareToWhatsApp;
  final Function(String, String) showOrderPaidHist;
  final Future<void> Function(String, String, String) onPay; // <-- added

  const PaidDeptHist({
    super.key,
    required this.client,
    required this.clientName,
    required this.name,
    required this.uidOwner,
    required this.price,
    required this.paidHist,
    required this.myIndex,
    required this.controller,
    required this.myFunct,
    required this.updateBotSheet,
    required this.viewDeptUsers,
    required this.shareToWhatsApp,
    required this.showOrderPaidHist,
    required this.onPay, // <-- required
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
          child: Stack(
            children: [
              Column(
                children: [
                  Container(
                    height: 4,
                    width: 40,
                    margin: const EdgeInsets.only(bottom: 16),
                    decoration: BoxDecoration(
                      color: Colors.grey[400],
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(12.0),
                    child: Row(
                      children: [
                        const Icon(Icons.person, color: Colors.blue),
                        const SizedBox(width: 16),
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              ConstantClassUtil().truncateWithEllipsis(
                                  ConstantClassUtil().capitalizeFirstLetter(paidHist["creator"]), 12),
                              style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
                            ),
                            const Text("Receiver", style: TextStyle(color: Colors.grey, fontSize: 15)),
                          ],
                        ),
                        const Spacer(),
                        IconButton(
                          visualDensity: VisualDensity.compact,
                          icon: const Icon(Icons.grid_4x4_rounded, color: Colors.grey),
                          onPressed: () async {},
                        ),
                        IconButton(
                          visualDensity: VisualDensity.compact,
                          icon: const Icon(Icons.share, color: Colors.blueAccent),
                          onPressed: () async {
                            String shareMsg =
                                "Muraho, $clientName Afite Ideni rya ${price.toString()} Asabwa kwishyura $name .";
                            await shareToWhatsApp("", shareMsg);
                          },
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              Positioned(
                top: 10,
                left: 15,
                child: Center(
                  child: Text(
                    'Uid:${paidHist["uid"]}',
                    style: const TextStyle(color: Colors.deepOrange, fontSize: 10),
                  ),
                ),
              ),
              Positioned(
                top: 10,
                right: 15,
                child: Center(
                  child: Text(
                    '${paidHist["created_at"]}',
                    style: const TextStyle(color: Colors.deepOrange, fontSize: 10),
                  ),
                ),
              ),
              Positioned(
                bottom: 10,
                right: 28,
                child: Center(
                  child: Text(
                    'Amount Paid:${paidHist["userPaid"]}',
                    style: const TextStyle(color: Colors.green, fontSize: 10),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}