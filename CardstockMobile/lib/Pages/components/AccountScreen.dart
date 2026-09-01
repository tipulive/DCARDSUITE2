import 'package:dstockapp/Pages/components/BottomNavigator/HomeNavigator.dart';
import 'package:dstockapp/Pages/components/PaymentsPage.dart';
import 'package:dstockapp/Pages/components/SalesPage.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../Query/AdminQuery.dart';
import '../../Query/SendStockController.dart';
import '../../Query/StockQuery.dart';
import '../../Query/account_controller.dart';
import '../../Utilconfig/ConstantClassUtil.dart';
import '../../models/Participated.dart';
import '../../models/Topups.dart';
import '../../models/User.dart';
import '../Homepage.dart';
import 'package:hive_flutter/hive_flutter.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Banking App Layout',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF1A315E),
          surface: const Color(0xFFF5F7FA),
        ),
        useMaterial3: true,
      ),
      home: const AccountScreen(),
    );
  }
}

class AccountScreen extends StatefulWidget {
  const AccountScreen({super.key});

  @override
  State<AccountScreen> createState() => _AccountScreenState();
}

class _AccountScreenState extends State<AccountScreen> {
  int _selectedIndex = 2;

  final AccountController controller = Get.put(AccountController());
  final StockQuery myStockQuery = Get.find<StockQuery>();
  var box = Hive.box("myBox");

  // Recent transactions state
  List<dynamic> _recentTransactions = [];
  bool _isLoadingRecent = true;

  // Accent colors for card stripes (same as SalesPage)
  final List<Color> _accentColors = [
    const Color(0xFF1A315E),
    Colors.teal.shade500,
    Colors.purple.shade500,
    Colors.amber.shade700,
    Colors.indigo.shade500,
    Colors.pink.shade400,
    Colors.green.shade600,
    Colors.cyan.shade600,
    Colors.deepOrange.shade400,
    Colors.blue.shade600,
  ];

  String searchName = "";
  String phoneNumber = "";
  int limitData = 10;
  bool searchValOption = false;


  String _selectedAction = 'Pending';
  String sStatus = "";
  String sTitle = 'Recent Pending Request Transfer';
  // Config data for action items
  final List<Map<String, dynamic>> _actions = [

    {
      'statusC': '0',
      'sTitle': 'Recent Pending Request Transfer',
      'label': 'Pending',
      'icon': Icons.receipt_long,
      'color': Colors.orange,
      'status': 'Pending'
    },
    {
      'statusC': '1',
      'sTitle': 'Recent Loading Transfer',
      'label': 'Loading',
      'icon': Icons.swap_horiz,
      'color': Colors.blue,
      'status': 'Loading'
    },
    {
      'statusC': '2',
      'sTitle': 'Recent Received Transfer',
      'label': 'Received',
      'icon': Icons.phone_android,
      'color': Colors.purple,
      'status': 'Received'
    },
    {
      'statusC': '3',
      'sTitle': 'Recent Cancelled Transfer',
      'label': 'Cancelled',
      'icon': Icons.qr_code_scanner,
      'color': Colors.teal,
      'status': 'Cancelled'
    },
  ];

  // ✅ Load both balance and transactions automatically on screen open
  @override
  void initState() {
    super.initState();
    _fetchRecentTransactions();
    controller.fetchCompanyRecord(); // 👈 fetches total balance and other data
  }

  // ------------------------------------------------------------------
  // 1. FETCH RECENT TRANSACTIONS
  // ------------------------------------------------------------------
  Future<void> _fetchRecentTransactions() async {
    setState(() => _isLoadingRecent = true);
    try {
      final response = await myStockQuery.viewReqStockPay(Participated(
        status: "0"
      ));
      if (response != null && response.data != null) {
        final List<dynamic> data = response.data is List
            ? response.data
            : (response.data["result"] ?? response.data["data"] ?? []);
        setState(() {
          _recentTransactions = data;
          _isLoadingRecent = false;
        });
      } else {
        setState(() => _isLoadingRecent = false);
      }
    } catch (e) {
      debugPrint("Error fetching recent transactions: $e");
      setState(() => _isLoadingRecent = false);
    }
  }

  // ------------------------------------------------------------------
  // 2. REQUEST PAYMENT (FIXED: no conflicting Get.back() calls)
  // ------------------------------------------------------------------
  Future<void> reqPayment(String qty, String uid, BuildContext context) async {
    FocusManager.instance.primaryFocus?.unfocus();

    // Show loading dialog
    Get.dialog(
      const Center(
        child: CircularProgressIndicator(color: Colors.orange),
      ),
      barrierDismissible: false,
    );

    bool success = false;

    try {


      final resultData = await myStockQuery.reqPaymentStock(
        Participated(
          inputData: qty,
          uidCreator: uid,
          status: "Req Payment",
          promotion_msg: "req to receive Amount",
        ),
      );

      if (resultData != null && resultData["status"] == true) {
        // Refresh transactions (and optionally balance)
        await _fetchRecentTransactions();
        // controller.fetchCompanyRecord(); // uncomment if you want balance refresh too
        success = true;
      }
    } catch (e) {
      debugPrint("Error requesting payment: $e");
    } finally {
      // 1. Close loading dialog if still open
      if (Get.isDialogOpen ?? false) {
        Get.back();
      }

      // 2. Show snackbar based on result
      if (success) {
        Get.snackbar(
          'Success',
          'Payment request sent successfully!',
          snackPosition: SnackPosition.BOTTOM,
          backgroundColor: Colors.green,
          colorText: Colors.white,
        );
        // 3. Close the bottom sheet only on success
        if (context.mounted) {
          Navigator.pop(context);
        }
      } else {
        Get.snackbar(
          'Error',
          'Failed to send request. Please try again.',
          snackPosition: SnackPosition.BOTTOM,
          backgroundColor: Colors.red,
          colorText: Colors.white,
        );
      }
    }
  }

  // ------------------------------------------------------------------
  // 3. COMPANY SELECTION
  // ------------------------------------------------------------------
  void searchCompany(BuildContext context) {
    final SendStockController controller = Get.find<SendStockController>();
    Get.bottomSheet(
      SafeArea(
        child: Container(
          height: Get.height * 0.82,
          decoration: const BoxDecoration(
            color: Color(0xffF8F9FB),
            borderRadius: BorderRadius.vertical(top: Radius.circular(30)),
          ),
          child: Column(
            children: [
              const SizedBox(height: 12),
              Container(
                width: 42,
                height: 5,
                decoration: BoxDecoration(
                  color: Colors.grey.shade300,
                  borderRadius: BorderRadius.circular(20),
                ),
              ),
              const SizedBox(height: 24),
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
                              controller.selectCompany(
                                Map<String, dynamic>.from(item),
                              );
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
                                          item["name"] ?? "",
                                          style: const TextStyle(
                                            fontWeight: FontWeight.w700,
                                            fontSize: 16,
                                          ),
                                        ),
                                        const SizedBox(height: 4),
                                        Text(
                                          item["PhoneNumber"] ?? "",
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

  // ------------------------------------------------------------------
  // 4. SEND STOCK BOTTOM SHEET (UPDATED: passes context to reqPayment)
  // ------------------------------------------------------------------
  void sendStockAmount(
      BuildContext context,
      dynamic productCode,
      dynamic qtyData, {
        String initialQuantity = "1",
      }) {
    final SendStockController controller = Get.isRegistered<SendStockController>()
        ? Get.find<SendStockController>()
        : Get.put(SendStockController());

    final double totalAvailable = double.tryParse(qtyData.toString()) ?? 0.0;
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
              mainAxisSize: MainAxisSize.min,
              children: [
                const SizedBox(height: 12),
                Container(
                  width: 42,
                  height: 5,
                  decoration: BoxDecoration(
                    color: Colors.grey.shade300,
                    borderRadius: BorderRadius.circular(20),
                  ),
                ),
                const SizedBox(height: 20),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 24.0),
                  child: Text(
                    "Send ${ConstantClassUtil().capitalizeFirstLetter(productCode.toString())}",
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
                    "Specify Amount and recipient company below.",
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: Colors.grey.shade600,
                      fontSize: 14,
                    ),
                  ),
                ),
                const SizedBox(height: 20),
                // ----- Stock info box (no exceeding check) -----
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: Obx(() {
                    final enteredQty = double.tryParse(controller.quantityStr.value) ?? 0.0;
                    final remaining = totalAvailable - enteredQty;

                    return Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 16,
                        vertical: 12,
                      ),
                      decoration: BoxDecoration(
                        color: Colors.orange.shade50,
                        borderRadius: BorderRadius.circular(16),
                        border: Border.all(
                          color: Colors.orange.shade200,
                          width: 1,
                        ),
                      ),
                      child: Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: Colors.orange.shade100,
                              shape: BoxShape.circle,
                            ),
                            child: const Text('🥭', style: TextStyle(fontSize: 20)),
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
                                        color: Colors.orange.shade900,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                    Text(
                                      "$qtyData Available",
                                      style: TextStyle(
                                        fontSize: 12,
                                        fontWeight: FontWeight.bold,
                                        color: Colors.orange.shade800,
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  "${remaining % 1 == 0 ? remaining.toInt() : remaining.toStringAsFixed(1)} Remaining after send",
                                  style: TextStyle(
                                    fontSize: 14,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.green.shade800,
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
                            "TAP TO ENTER AMOUNT",
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
                    ],
                  ),
                ),
                const SizedBox(height: 20),
                // ----- Company selection (unchanged) -----
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: Obx(() {
                    final hasCompany = controller.selectedCompany.isNotEmpty;
                    final compName = controller.selectedCompany["name"] ??
                        controller.selectedCompany["PhoneNumber"] ??
                        "Select Company";
                    final subTitle = hasCompany
                        ? (controller.selectedCompany["PhoneNumber"] ?? "Selected Recipient")
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
                // ----- Send button (exceeding check removed) -----
                Padding(
                  padding: const EdgeInsets.fromLTRB(20, 0, 20, 20),
                  child: Obx(() {
                    // Only check if the form is valid (company selected + quantity > 0)
                    final canSend = controller.isValid;

                    return SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: canSend
                            ? () async {
                          final qty = controller.quantityStr.value;
                          final company = controller.selectedCompany;
                          await reqPayment(qty, company["uid"], context);
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
                          "Send ${ConstantClassUtil().capitalizeFirstLetter(productCode.toString())}",
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

  // ------------------------------------------------------------------
  // 5. GET COMPANY DATA
  // ------------------------------------------------------------------
  Future<void> getCompData(String optionCase, String name) async {
    FocusManager.instance.primaryFocus?.unfocus();
    Get.dialog(
      const Center(
        child: CircularProgressIndicator(color: Colors.orange),
      ),
      barrierDismissible: false,
    );
    final stockQueryController = Get.isRegistered<StockQuery>()
        ? Get.find<StockQuery>()
        : Get.put(StockQuery());
    try {

      final resultData = await myStockQuery.searchAdminUser(
        User(uid: "", name: searchName, phone: phoneNumber, platform: "3000", status: "offNotPick"),
        Topups(optionCase: "true", startlimit: limitData, searchOption: searchValOption, sortOrder: "ASC"),
      );
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
      if (Get.isDialogOpen ?? false) Get.back();
    }
  }

  void _showFeatureSnackbar(String title, String message) {
    Get.snackbar(
      title,
      message,
      snackPosition: SnackPosition.BOTTOM,
      backgroundColor: const Color(0xFF1A315E).withOpacity(0.9),
      colorText: Colors.white,
      margin: const EdgeInsets.all(15),
      duration: const Duration(seconds: 2),
      icon: const Icon(Icons.info_outline, color: Colors.white),
    );
  }

  // ------------------------------------------------------------------
  // 6. DETAILS BOTTOM SHEET
  // ------------------------------------------------------------------
  void _showRequestDetailsBottomSheet({
    required String uid,
    required String receiver,
    required String clientName,
    required String status,
    required String amount,
    required String purpose,
    required String date,
  }) {
    Get.bottomSheet(
      Container(
        constraints: BoxConstraints(
          maxHeight: Get.height * 0.6,
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
                        'Status: ${status.toUpperCase()} • UID: $uid • Receiver: $receiver',
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      ),
                    ],
                  ),
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    const Text(
                      'AMOUNT',
                      style: TextStyle(
                        fontSize: 9,
                        fontWeight: FontWeight.bold,
                        color: Colors.grey,
                        letterSpacing: 0.5,
                      ),
                    ),
                    Text(
                      '\$$amount',
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
            const SizedBox(height: 16),
          ],
        ),
      ),
      isScrollControlled: true,
    );
  }

  // ------------------------------------------------------------------
  // 7. BUILD UI
  // ------------------------------------------------------------------
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: 240,
            color: const Color(0xFF1A315E),
          ),
          SafeArea(
            child: RefreshIndicator(
              onRefresh: () async {
                // Refresh both transactions and balance on pull-down
                await Future.wait([
                  _fetchRecentTransactions(),
                  controller.fetchCompanyRecord(),
                ]);
              },
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const SizedBox(height: 10),
                    _buildHeaderProfile(),
                    const SizedBox(height: 15),
                    _buildBalanceCard(),
                    const SizedBox(height: 16),

                    _buildFeatureGrid(),
                    const SizedBox(height: 16),
                    _buildRecentTransactionsSection(),
                    const SizedBox(height: 30),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
      //bottomNavigationBar: _buildBottomNavigationBar(),
        bottomNavigationBar:const HomeNavigator(currentIndex: 2),
    );
  }

  Widget _buildHeaderProfile() {
    return  Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
          Get.put(AdminQuery()).obj["result"][0]["name"],
                style: const TextStyle(color: Colors.white70, fontSize: 14),
              ),
              const SizedBox(height: 4),
              const Text(
                'My Account',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 26,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ],
          ),
          const CircleAvatar(
            radius: 20,
            backgroundColor: Colors.white24,
            child: Icon(Icons.person, color: Colors.white),
          ),
        ],
      ),
    );
  }

  Widget _buildBalanceCard() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          )
        ],
      ),
      padding: const EdgeInsets.all(20),
      child: InkWell(
        onTap: () {
          sendStockAmount(context, controller.amount.value, controller.totalBalance.value);
        },
        child: Column(
          children: [
            const Text(
              'TOTAL GROSS SALES',
              style: TextStyle(
                color: Colors.grey,
                fontSize: 12,
                fontWeight: FontWeight.w600,
                letterSpacing: 0.5,
              ),
            ),
            const SizedBox(height: 8),
            Obx(() => Text(
              '${controller.totalBalance.value}~${controller.amount.value}',
              style: const TextStyle(
                color: Color(0xFF1A315E),
                fontSize: 30,
                fontWeight: FontWeight.bold,
              ),
            )),
          ],
        ),
      ),
    );
  }


  Widget _buildFeatureGrid() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Obx(() => Column(
        children: [
          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: 2,
            crossAxisSpacing: 12,
            mainAxisSpacing: 12,
            childAspectRatio: 1.8,
            children: [
              _buildGridCard(
                icon: Icons.arrow_forward,
                iconColor: Colors.blue,
                title: 'TRANSFER',
                subtitle: 'Sent Money',
                value: controller.transfer.value,

                onTap: () => _showFeatureSnackbar('Transfer Funds', 'Opening money transfer portal setup against total account valuation: ${controller.transfer.value}'),
              ),
              _buildGridCard(
                icon: Icons.account_balance_wallet,
                iconColor: Colors.blue,
                title: 'AMOUNT',
                subtitle: 'Received Funds',
                value: controller.received.value,
                onTap: () => _showFeatureSnackbar('Available Funds', 'Your current spendable amount is ${controller.received.value}'),
              ),

              _buildGridCard(
                icon: Icons.card_giftcard,
                iconColor: Colors.teal,
                title: 'DETTES',
                subtitle: 'Rewards Balance',
                value: controller.dept.value,
                onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.dept.value}!'),
              ),
              _buildGridCard(
                icon: Icons.pie_chart,
                iconColor: Colors.blue,
                title: 'SPENDING',
                subtitle: 'view Spending',
                value: controller.spending.value,
                onTap: () => showCustomBottomSheet(),
              ),
              _buildGridCard(
                icon: Icons.card_giftcard,
                iconColor: Colors.teal,
                title: 'BONUS',
                subtitle: 'Rewards Balance',
                value: "${controller.bonus.value}  | qty:${controller.qtySpent.value}",
                onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.bonus.value}!'),
              ),
              _buildGridCard(
                icon: Icons.atm,
                iconColor: Colors.teal,
                title: 'WITHDRAW',
                subtitle: 'Rewards Withdraw',
                value: controller.withdraw.value,
                onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.withdraw.value}!'),
              ),

            ],
          ),
          const SizedBox(height: 4),
          const Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                'Quick Withdraw Details ',
                style: TextStyle(
                  fontSize: 12,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),
              Text(
                'Long Withdraw Details',
                style: TextStyle(
                  fontSize: 12,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),

            ],
          ),
          const SizedBox(height: 4),
          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: 2,
            crossAxisSpacing: 12,
            mainAxisSpacing: 12,
            childAspectRatio: 1.8,
            children: [
              _buildGridCard(
                icon: Icons.arrow_forward,
                iconColor: Colors.deepOrange,
                title: 'OUT',
                subtitle: 'Qty Value',
                value: controller.outPromoAssetQty.value,

                onTap: () => _showFeatureSnackbar('Transfer Funds', 'Opening money transfer portal setup against total account valuation: ${controller.transfer.value}'),
              ),
              _buildGridCard(
                icon: Icons.arrow_forward,
                iconColor: Colors.blue,
                title: 'OUT',
                subtitle: 'Qty Value',
                value: controller.promoAsset.value,

                onTap: () => _showFeatureSnackbar('Transfer Funds', 'Opening money transfer portal setup against total account valuation: ${controller.transfer.value}'),
              ),
              _buildGridCard(
                icon: Icons.account_balance_wallet,
                iconColor: Colors.deepOrange,
                title: 'AMOUNT',
                subtitle: 'Promo Amount',
                value: controller.outPromoAmount.value,
                onTap: () => _showFeatureSnackbar('Available Funds', 'Your current spendable amount is ${controller.received.value}'),
              ),
              _buildGridCard(
                icon: Icons.account_balance_wallet,
                iconColor: Colors.blue,
                title: 'AMOUNT',
                subtitle: 'Promo Amount',
                value: controller.promoAmount.value,
                onTap: () => _showFeatureSnackbar('Available Funds', 'Your current spendable amount is ${controller.received.value}'),
              ),

              _buildGridCard(
                icon: Icons.card_giftcard,
                iconColor: Colors.deepOrange,
                title: 'REWARDS',
                subtitle: 'Rewards Balance',
                value: controller.outProAssetQty.value,
                onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.dept.value}!'),
              ),
              _buildGridCard(
                icon: Icons.card_giftcard,
                iconColor: Colors.blue,
                title: 'REWARDS',
                subtitle: 'Rewards Balance',
                value: controller.proAssetQty.value,
                onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.dept.value}!'),
              ),


            ],
          ),
        ],
      )),
    );
  }


  void showCustomBottomSheet() {
    Get.bottomSheet(
      Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            // Drag Handle Bar
            Container(
              width: 40,
              height: 4,
              margin: const EdgeInsets.only(bottom: 16),
              decoration: BoxDecoration(
                color: Colors.grey[300],
                borderRadius: BorderRadius.circular(10),
              ),
            ),

            // Sheet Title
            const Text(
              'Select Option',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            _buildTopTab(),
            // Scrollable List of Cards
            Flexible(
              child: ListView.separated(
                shrinkWrap: true,
                itemCount: 4,
                separatorBuilder: (context, index) => const SizedBox(height: 8),
                itemBuilder: (context, index) {
                  return _buildListCard(
                    title: 'Option ${index + 1}',
                    subtitle: 'Description for option ${index + 1}',
                    icon: Icons.layers_outlined,
                    onTap: () {
                      Get.back(); // Close bottom sheet
                      // Add tap handling logic here
                    },
                  );
                },
              ),
            ),
            const SizedBox(height: 8),
          ],
        ),
      ),
      isScrollControlled: true, // Allows sheet to height-fit dynamic content
      backgroundColor: Colors.transparent,
    );
  }

// Custom Reusable List Card Widget
  Widget _buildListCard({
    required String title,
    required String subtitle,
    required IconData icon,
    required VoidCallback onTap,
  }) {
    return Card(
      elevation: 0,
      color: Colors.grey[100],
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: BorderSide(color: Colors.grey[200]!),
      ),
      child: ListTile(
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
        leading: Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: Colors.blue.withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Icon(icon, color: Colors.blue),
        ),
        title: Text(
          title,
          style: const TextStyle(fontWeight: FontWeight.w600),
        ),
        subtitle: Text(
          subtitle,
          style: TextStyle(color: Colors.grey[600], fontSize: 12),
        ),
        trailing: const Icon(Icons.chevron_right, color: Colors.grey),
        onTap: onTap,
      ),
    );
  }
  Widget _buildTopTab(){
    return Padding(
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
                    sStatus=item["statusC"];
                    sTitle=item['sTitle'];
                  });
                  // print('${item['label']} selected');
                  if(sStatus!="")
                  {
                    //_fetchStockPayData();


                  }



                },
              );
            },
          ),
        ],
      ),
    );
  }
  //button navigator
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
  Widget _buildGridCard({
    required IconData icon,
    required Color iconColor,
    required String title,
    required String subtitle,
    required String value,
    required VoidCallback onTap,
    bool isActionOnly = false,
  }) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(14),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.02),
            blurRadius: 5,
            offset: const Offset(0, 2),
          )
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          borderRadius: BorderRadius.circular(14),
          onTap: onTap,
          child: Padding(
            padding: const EdgeInsets.all(12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  children: [
                    Icon(icon, color: iconColor, size: 20),
                    const SizedBox(width: 6),
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1A315E),
                      ),
                    ),
                  ],
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      subtitle,
                      style: const TextStyle(fontSize: 10, color: Colors.grey),
                    ),
                    if (!isActionOnly) ...[
                      const SizedBox(height: 2),
                      Text(
                        value,
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                          color: Colors.black87,
                        ),
                      ),
                    ]
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  // ------------------------------------------------------------------
  // 8. RECENT TRANSACTIONS SECTION
  // ------------------------------------------------------------------
  Widget _buildRecentTransactionsSection() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'Recent Request Transactions',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),
              TextButton(
                onPressed: () async {
                  await _fetchRecentTransactions();
                },
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
          const SizedBox(height: 10),
          if (_isLoadingRecent)
            const Center(
              child: Padding(
                padding: EdgeInsets.symmetric(vertical: 20),
                child: CircularProgressIndicator(color: Color(0xFF1A315E)),
              ),
            )
          else if (_recentTransactions.isEmpty)
            const Center(
              child: Padding(
                padding: EdgeInsets.symmetric(vertical: 20),
                child: Text(
                  'No recent transactions.',
                  style: TextStyle(color: Colors.grey),
                ),
              ),
            )
          else
            ListView.separated(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              itemCount: _recentTransactions.length > 5 ? 5 : _recentTransactions.length,
              separatorBuilder: (_, __) => const SizedBox(height: 12),
              itemBuilder: (context, index) {
                final item = _recentTransactions[index];
                return _buildRequestCard(item);
              },
            ),
          if (_recentTransactions.length > 5)
            Padding(
              padding: const EdgeInsets.only(top: 8.0),
              child: Align(
                alignment: Alignment.centerRight,
                child: TextButton(
                  onPressed: () => Get.to(() => const SalesPage()),
                  child: const Text('View All →'),
                ),
              ),
            ),
        ],
      ),
    );
  }

  // ------------------------------------------------------------------
  // 9. SALESPAGE-STYLE REQUEST CARD
  // ------------------------------------------------------------------
  Widget _buildRequestCard(dynamic item) {
    final String uid = item['uid'] ?? 'N/A';
    final String receiver = item['OwnerAmount'] ?? 'N/A';
    final String amount = item['amount'] ?? '0';
    final String purpose = item['purpose'] ?? 'Stock Transfer';
    final String createdAt = item['created_at'] ?? 'N/A';
    final String payer = item['payer'] ?? 'Unknown Payer';
    // final String status = item['status'] ?? item['payment_status'] ?? 'Pending';
    String status = "Pending"; // Adjust if your API has a status field

    // Get a distinct color per card based on UID
    final Color accentColor = _accentColors[uid.hashCode.abs() % _accentColors.length];

    // Determine status badge colors
    final String cleanStatus = status.toUpperCase();
    Color statusBgColor;
    Color statusTextColor;
    if (cleanStatus == 'PAID' || cleanStatus == 'COMPLETED' || cleanStatus == 'SUCCESS') {
      statusBgColor = Colors.green.shade50;
      statusTextColor = Colors.green.shade700;
    } else if (cleanStatus == 'FAILED' || cleanStatus == 'CANCELLED') {
      statusBgColor = Colors.red.shade50;
      statusTextColor = Colors.red.shade700;
    } else {
      statusBgColor = Colors.orange.shade100;
      statusTextColor = Colors.deepOrange.shade800;
    }

    return Container(
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
              // Dynamic accent stripe
              Container(
                width: 4,
                color: accentColor,
              ),
              // Main content
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
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Status Badge
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
                                // UID
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
                                // Purpose
                                Text(
                                  purpose,
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
                          // Amount
                          Text(
                            '\$$amount',
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF1A315E),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 10),
                      // Footer: Payer and Date
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            'Payer: $payer',
                            style: TextStyle(fontSize: 10, color: Colors.grey.shade600),
                          ),

                        ],
                      ),
                      Row(

                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [

                          Text(
                            createdAt,
                            style: TextStyle(fontSize: 10, color: Colors.grey.shade600),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
              // Vertical separator
              VerticalDivider(
                width: 1,
                thickness: 1,
                color: Colors.grey.shade200,
              ),
              // Right side: Receiver badge + View icon
              Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  // Receiver badge
                  Container(
                    margin: const EdgeInsets.only(top: 6, left: 4, right: 4),
                    padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                    decoration: BoxDecoration(
                      color: const Color(0xFF1A315E).withOpacity(0.08),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Receiver: $receiver',
                      style: const TextStyle(
                        fontSize: 8,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1A315E),
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                  // View action
                  Tooltip(
                    message: 'View Details',
                    child: Material(
                      color: Colors.transparent,
                      child: InkWell(
                        onTap: () => _showRequestDetailsBottomSheet(
                          uid: uid,
                          receiver: receiver,
                          clientName: payer,
                          status: status,
                          amount: amount,
                          purpose: purpose,
                          date: createdAt,
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
                  const SizedBox(height: 4),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  // ------------------------------------------------------------------
  // 10. BOTTOM NAVIGATION
  // ------------------------------------------------------------------
  Widget _buildBottomNavigationBar() {
    return BottomNavigationBar(
      currentIndex: _selectedIndex,
      type: BottomNavigationBarType.fixed,
      selectedItemColor: const Color(0xFF1A315E),
      unselectedItemColor: Colors.grey,
      selectedFontSize: 11,
      unselectedFontSize: 11,
      onTap: (index) {
        setState(() {
          _selectedIndex = index;
        });
        if (index == 0) Get.to(() => const Homepage());
        if (index == 1) Get.to(() => const PaymentsPage());
        if (index == 3) Get.to(() => const SalesPage());
      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.analytics_outlined), label: 'Analytics'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    );
  }
}