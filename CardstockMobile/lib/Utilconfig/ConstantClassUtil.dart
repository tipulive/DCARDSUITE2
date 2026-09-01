import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:get/get.dart';
import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'package:url_launcher/url_launcher.dart';
import 'dart:math' as Math;

import '../Query/StockQuery.dart';
import 'AppInfo.dart';

class ConstantClassUtil extends GetxController
{
  static final DateTime now = DateTime.now();
  static final DateFormat formatter = DateFormat('yyyy-MM-dd hh:mm aaa');
  var formatted = (formatter.format(now)).obs;
  final StockQuery myStockQuery = Get.find<StockQuery>();
  //static const urlLink="http://10.0.2.2:8000/api";//Testing Link

  /*static const urlLink="https://api.appdev.live/api"; //production Link
  static const urlApp="https://api.appdev.live";*/
  /*static const urlLink="https://sanboxstock.appdev.live/api";
  static const urlApp="https://sanboxstock.appdev.live";*/
  /*static const String urlApp =
      "https://stockapi.appdev.live";*/
  //static const String urlApp ="https://lion-threatened-maximize-set.trycloudflare.com";
  static const String urlApp="https://stockapi.appdev.live";
      //"https://stockapi.appdev.live";
  //"https://volt-gbp-kijiji-hampshire.trycloudflare.com";

  static const String urlLink="$urlApp/api";

  /*static const urlLink="https://stockapi.appdev.live/api";
  static const urlApp="https://stockapi.appdev.live";*/

  String appVers=AppInfo.version;




  //static final StockLink="http://10.0.2.2:8050/api";//Testing Link
  static const stockLink="https://stock.appdev.live/api";//production Link


  var isLoading = false.obs;
  var message = "Loading...".obs;

  void show({String msg = "Loading..."}) {
    message.value = msg;
    isLoading.value = true;
  }

  void hide() {
    isLoading.value = false;
  }

// Global helper functions to match your existing syntax
  void showPageLoadingDialog({String message = "Loading..."}) {
    Get.put(ConstantClassUtil()).show(msg: message);
  }

  void hidePageLoadingDialog() {
    Get.put(ConstantClassUtil()).hide();
  }

  void showLoadingDialog({String message = "Loading..."}) {
    //if (Get.isDialogOpen == true) return; // Prevent duplicate dialogs

    Get.dialog(
      PopScope(
        canPop: false, // Prevents Android hardware back button from closing it
        child: Center(
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 24),
            constraints: const BoxConstraints(minWidth: 140, maxWidth: 220),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.08),
                  blurRadius: 24,
                  spreadRadius: 0,
                  offset: const Offset(0, 8),
                ),
              ],
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min, // Hug content instead of hardcoded height
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const SizedBox(
                  width: 28,
                  height: 28,
                  child: CircularProgressIndicator(
                    strokeWidth: 2.5, // Thinner strokes feel far more refined
                    valueColor: AlwaysStoppedAnimation<Color>(Colors.blueAccent),
                    strokeCap: StrokeCap.round, // Rounded edges on the indicator arc
                  ),
                ),
                if (message.isNotEmpty) ...[
                  const SizedBox(height: 16),
                  Text(
                    message,
                    textAlign: TextAlign.center,
                    style: GoogleFonts.poppins(
                      color: const Color(0xFF2D3748), // Dark, slate-grey tone
                      fontWeight: FontWeight.w500,
                      fontSize: 13,
                      height: 1.2,
                      decoration: TextDecoration.none, // Removes yellow debug underline
                    ),
                  ),
                ],
              ],
            ),
          ),
        ),
      ),
      barrierDismissible: false,
      barrierColor: Colors.black.withOpacity(0.25), // Softened backdrop overlay
      transitionDuration: const Duration(milliseconds: 200),
      transitionCurve: Curves.easeOutCubic,
    );
  }

  void hideLoadingDialog() {
    if (Get.isDialogOpen == true) {
      Get.back(); // close the loading dialog
    }
  }
  updateDate() async{
   final DateTime now = DateTime.now();
   final DateFormat formatter = DateFormat('yyyy-MM-dd hh:mm:ss');
    formatted.value=formatter.format(now);
    return formatted;
    //update();
  }
  truncateWithEllipsis(String text, int maxLength) {
    if (text.length <= maxLength) {
      return text;
    } else {
      return '${text.substring(0, maxLength)}...'; // Adding ellipsis
    }
  }
  String capitalizeFirstLetter(String input) {
    if (input.isEmpty) return input; // Return empty string if input is empty
    return input.toLowerCase().split(' ').map((word) {
      if (word.isEmpty) return word; // Return empty word if word is empty
      return word[0].toUpperCase() + word.substring(1);
    }).join(' ');
  }
  num? convertToNum(dynamic input) {
    if (input is num) {
      // If the input is already a number, return it as is
      return input;
    } else if (input is String) {
      // If the input is a string, attempt to parse it as a number
      return num.tryParse(input);
    } else {
      // If the input is neither a number nor a string, return null
      return null;
    }
  }
  // This is to convert for what my promotion generator will understand

  Map<String, dynamic> convertCart(List<dynamic>? items) {
    if (items == null || items.isEmpty) {
      return {
        "total": 0.0,
        "count": 0,
        "userType": "standard",
        "card": true,
        "items": [],
      };
    }

    double total = 0.0;
    int count = 0;

    for (final item in items) {
      // Safely parse totalAmount as double
      final rawAmount = item['totalAmount'];
      total += (rawAmount is num)
          ? rawAmount.toDouble()
          : double.tryParse(rawAmount?.toString() ?? '0') ?? 0.0;

      // Safely parse quantity as int
      final rawQty = item['totalQty'];
      count += (rawQty is num)
          ? rawQty.toInt()
          : int.tryParse(rawQty?.toString() ?? '0') ?? 0;
    }

    final formattedItems = items.map((item) {
      final rawPrice = item['price'];
      final price = (rawPrice is num)
          ? rawPrice
          : num.tryParse(rawPrice?.toString() ?? '0') ?? 0;

      final rawQty = item['totalQty'];
      final qty = (rawQty is num)
          ? rawQty.toInt()
          : int.tryParse(rawQty?.toString() ?? '0') ?? 0;

      return {
        "productName": item['productCode']?.toString() ?? '',
        "price": price,
        "qty": qty,
      };
    }).toList();

    // Pull marital_status directly from the item or fallback to profile
    final userType = items.first['marital_status']?.toString() ??
        myStockQuery.userProfile?["marital_status"] ??
        "standard";

    return {
      "total": total,
      "count": count,
      "userType": userType,
      "card": true,
      "items": formattedItems,
    };
  }
  double calcTotObjJSon(List<dynamic> list, String key) {
    return list.fold(0, (sum, item) {
      final value = item[key];
      if (value == null) return sum;


      return sum + double.tryParse(value.toString())!;
    });
  }
  double truncateToDecimalPlaces(double value, int fractionalDigits) {
    double mod = Math.pow(10.0, fractionalDigits).toDouble();
    return ((value * mod).truncate().toDouble() / mod);
  }

  Map<String, dynamic>validationTwo(String param1,String param2,String error,String message){
    if(param1==param2)
    {
      return {
        'status':true,
        'message':message
      };
    }else{
      return {
        'status':false,
        'message':error
      };
    }

  }
  String formatNumber(num value) {
    return (value % 1 == 0) ? value.toInt().toString() : value.toString();
  }
  String buildWhatsAppMessage(List<Map<String, dynamic>> data,Map<String, dynamic> users) {
    // Helper to safely convert dynamic values to int

    int toInt(dynamic value) {
      if (value == null) return 0;
      if (value is int) return value;
      if (value is num) return value.toInt();
      if (value is String) return int.tryParse(value) ?? 0;
      return 0;
    }

    // Calculate total amount
    final totalAmount = data.fold<int>(
      0,
          (sum, item) => sum + toInt(item['totalAmount']),
    );
    // Calculate total Qty
    final totalQty = data.fold<int>(
      0,
          (sum, item) => sum + toInt(item['totalQty']),
    );

    final buffer = StringBuffer();
    buffer.writeln('===${users["title"]??""}===\n');
    buffer.writeln('===${data[0]['uid']}===\n');
    buffer.writeln(users["name"].toUpperCase());
    buffer.writeln('=================\n');
    buffer.writeln('TOTAL: $totalAmount ($totalQty Koli)');
    buffer.writeln('--------------------\n');

    // Determine padding for labels
// enough for 'Dettes  ' and 'Paid    '
    int counter = 1;
    for (var item in data) {
      final name = (item['productCode']?.toString() ?? 'UNKNOWN').toUpperCase();
      final dettes = "${item['totalQty']}*${item['price']}=${item['totalAmount']}";
      toInt(item['price']);

      buffer.writeln("$counter)$name (${item['pcs']} pcs)");
      buffer.writeln('--------------------');
      buffer.writeln('  $dettes');
      //buffer.writeln(' ${'Deliver'.padRight(labelWidth)}  : $paid\n');
      buffer.writeln('--------------------\n');
      counter++;
    }

    buffer.writeln('====================');

    return buffer.toString();
  }

  String buildReportSalesWhatsAppMessage(List<dynamic> salesData, String reportDate) {
    final sales = salesData
        .where((e) => e['saleType'] == 'normal')
        .toList();

    final bonus = salesData
        .where((e) => e['saleType'] == 'promotion')
        .toList();

    // Calculate sales totals safely
    num salesTotal = 0;
    num salesQty = 0;

    for (final item in sales) {
      salesTotal += num.tryParse(item['total']?.toString() ?? '0') ?? 0;
      salesQty += num.tryParse(item['qty']?.toString() ?? '0') ?? 0;
    }

    // Calculate bonus totals safely
    num bonusTotal = 0;
    num bonusQty = 0;

    for (final item in bonus) {
      bonusTotal += num.tryParse(item['total']?.toString() ?? '0') ?? 0;
      bonusQty += num.tryParse(item['qty']?.toString() ?? '0') ?? 0;
    }

    // Unique product count
    final salesArticles =
        sales.map((e) => e['productCode']).toSet().length;

    final bonusArticles =
        bonus.map((e) => e['productCode']).toSet().length;

    final StringBuffer msg = StringBuffer();

    // ================= HEADER =================
    msg.writeln("*--Date:$reportDate--\n");
    msg.writeln("*===Report Sales===*");

    if (bonus.isNotEmpty) {
      msg.writeln(
        "*${salesTotal.toStringAsFixed(0)} Sales | "
            "${bonusTotal.toStringAsFixed(0)} BONUS*",
      );
    }

    // ================= SALES =================
    msg.writeln('--------------------');
    msg.writeln("*--------Sales--------*");
    msg.writeln('--------------------');
    msg.writeln(
      "*TOTAL: ${salesTotal.toStringAsFixed(0)} | "
          "${salesQty.toStringAsFixed(0)} qty | "
          "$salesArticles articles*",
    );

    msg.writeln('---------------------------------\n');

    for (int i = 0; i < sales.length; i++) {
      final item = sales[i];

      final product = item['productCode'];
      final pcs = item['pcs'];
      final price = item['price'];
      final qty = item['qty'];
      final total = item['total'];

      final parsedQty = num.tryParse(qty?.toString() ?? '0') ?? 0;
      final parsedPrice = num.tryParse(price?.toString() ?? '0') ?? 0;
      final parsedTotal = num.tryParse(total?.toString() ?? '0') ?? 0;

      msg.writeln("${i + 1})$product ($pcs pcs)");
      msg.writeln('--------------------');
      msg.writeln(
        "$parsedQty*$parsedPrice=${parsedTotal.toStringAsFixed(0)}",
      );
      msg.writeln('----------------------');
    }

    // ================= BONUS =================

    if (bonus.isNotEmpty) {
      msg.writeln("*--------- BONUS ---------*");

      msg.writeln(
        "*TOTAL: ${bonusTotal.toStringAsFixed(0)} | "
            "${bonusQty.toStringAsFixed(0)} qty | "
            "$bonusArticles articles*",
      );
      msg.writeln('---------------------------\n');

      for (int i = 0; i < bonus.length; i++) {
        final item = bonus[i];

        final product = item['productCode'];
        final pcs = item['pcs'];
        final price = item['price'];
        final qty = item['qty'];
        final total = item['total'];

        final parsedQty = num.tryParse(qty?.toString() ?? '0') ?? 0;
        final parsedPrice = num.tryParse(price?.toString() ?? '0') ?? 0;
        final parsedTotal = num.tryParse(total?.toString() ?? '0') ?? 0;

        msg.writeln("${i + 1})$product ($pcs pcs)");
        msg.writeln('--------------------');
        msg.writeln(
          "$parsedQty*$parsedPrice=${parsedTotal.toStringAsFixed(0)}",
        );
        msg.writeln('--------------------');
      }
    }

    // ================= END =================

    msg.writeln("-------End-------");

    return msg.toString();
  }
  static void showError({
    required String message,
    String title = 'Error',
    String actionLabel = 'RETRY',
    VoidCallback? onAction,
    Duration duration = const Duration(seconds: 4),
  }) {
    // Close active snackbars to avoid queuing delay
    if (Get.isSnackbarOpen) {
      Get.closeCurrentSnackbar();
    }

    Get.snackbar(
      title,
      message,
      // Icon & Layout
      icon: Container(
        padding: const EdgeInsets.all(6),
        decoration: BoxDecoration(
          color: const Color(0xFFEF4444).withOpacity(0.2),
          shape: BoxShape.circle,
        ),
        child: const Icon(
          Icons.error_outline_rounded,
          color: Color(0xFFFCA5A5),
          size: 22,
        ),
      ),
      snackPosition: SnackPosition.TOP,
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      borderRadius: 12,

      // Theme & Styling
      backgroundColor: const Color(0xFFDC2323), // Dark Red
      colorText: Colors.white,
      messageText: Text(
        message,
        style: const TextStyle(
          color: Color(0xD0FFFFFF),
          fontSize: 12,
        ),
        maxLines: 2,
        overflow: TextOverflow.ellipsis,
      ),
      titleText: Text(
        title,
        style: const TextStyle(
          color: Colors.white,
          fontWeight: FontWeight.bold,
          fontSize: 14,
        ),
      ),

      // Behavior & Shadows
      duration: duration,
      isDismissible: true,
      dismissDirection: DismissDirection.horizontal,
      boxShadows: [
        BoxShadow(
          color: Colors.black.withOpacity(0.2),
          blurRadius: 10,
          offset: const Offset(0, 4),
        ),
      ],
      borderWidth: 1,
      borderColor: const Color(0xFFEF4444).withOpacity(0.4),

      // Optional Action Button
      mainButton: onAction != null
          ? TextButton(
        onPressed: () {
          if (Get.isSnackbarOpen) Get.closeCurrentSnackbar();
          onAction();
        },
        style: TextButton.styleFrom(
          backgroundColor: Colors.white.withOpacity(0.1),
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
          minimumSize: Size.zero,
          tapTargetSize: MaterialTapTargetSize.shrinkWrap,
        ),
        child: Text(
          actionLabel,
          style: const TextStyle(
            color: Colors.white,
            fontWeight: FontWeight.bold,
            fontSize: 12,
          ),
        ),
      )
          : null,
    );
  }

  Future<void> shareToWhatsApp(String phone, String message) async {
    // 1. Prepare the URI
    // If phone is empty, it opens the contact picker in WhatsApp
    final String native="whatsapp://send?phone=$phone&text=${Uri.encodeComponent(message)}";
    final String pwa="https://wa.me/$phone?text=${Uri.encodeComponent(message)}";
    final String url = (kIsWeb)?pwa:native;
    final Uri uri = Uri.parse(url);

    try {
      // 2. Check if the URL can actually be opened
      bool canLaunch = await canLaunchUrl(uri);

      if (canLaunch) {
        await launchUrl(
          uri,
          mode: LaunchMode.externalNonBrowserApplication,
        );
      } else {
        // This usually triggers if WhatsApp is not installed
        Get.snackbar(
          "WhatsApp Required",
          "WhatsApp is not installed on this device.",
          snackPosition: SnackPosition.BOTTOM,
          backgroundColor: Colors.redAccent,
          colorText: Colors.white,
        );
      }
    } catch (e) {
      // 3. Catch unexpected errors (malformed URLs, OS permission issues)
      Get.snackbar(
        "Launch Error",
        "An unexpected error occurred: $e",
        snackPosition: SnackPosition.BOTTOM,
      );
    }
  }

}

