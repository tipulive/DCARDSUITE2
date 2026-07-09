import 'package:intl/intl.dart';
import 'package:get/get.dart';

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
  static const urlLink="https://stockapi.appdev.live/api";
  static const urlApp="https://stockapi.appdev.live";

  static const appVers="v2.0.0";




  //static final StockLink="http://10.0.2.2:8050/api";//Testing Link
  static const StockLink="https://stock.appdev.live/api";//production Link






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
      return text.substring(0, maxLength) + '...'; // Adding ellipsis
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



}

