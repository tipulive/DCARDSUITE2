import 'package:intl/intl.dart';
import 'package:get/get.dart';
import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'package:url_launcher/url_launcher.dart';

class ConstantClassUtil extends GetxController
{
  static final DateTime now = DateTime.now();
  static final DateFormat formatter = DateFormat('yyyy-MM-dd hh:mm aaa');
  var formatted = (formatter.format(now)).obs;
  //static const urlLink="http://10.0.2.2:8000/api";//Testing Link

  /*static const urlLink="https://api.appdev.live/api"; //production Link
  static const urlApp="https://api.appdev.live";*/
  /*static const urlLink="https://sanboxstock.appdev.live/api";
  static const urlApp="https://sanboxstock.appdev.live";*/
  /*static const String urlApp =
      "https://stockapi.appdev.live";*/
  static const String urlApp =
      "https://stockapi.appdev.live";

  static const String urlLink = "$urlApp/api";

  /*static const urlLink="https://stockapi.appdev.live/api";
  static const urlApp="https://stockapi.appdev.live";*/

  static const appVers="v2.0.0";




  //static final StockLink="http://10.0.2.2:8050/api";//Testing Link
  static const stockLink="https://stock.appdev.live/api";//production Link






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
  double calcTotObjJSon(List<dynamic> list, String key) {
    return list.fold(0, (sum, item) {
      final value = item[key];
      if (value == null) return sum;


      return sum + double.tryParse(value.toString())!;
    });
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

