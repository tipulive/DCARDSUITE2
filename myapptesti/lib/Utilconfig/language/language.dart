
import '../../Query/StockQuery.dart';
import 'package:get/get.dart';
import 'package:flutter/material.dart';
import 'package:get/get_state_manager/src/simple/get_controllers.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Language extends GetxController{
final languageId="eric-software";
  Map<String, dynamic> languageV = {
    //English
    "English": {
      "Home": {
        "pickDft": "Pick Default Account",
        "name": "veda"
      },
      "pageName": {
        "title": "English",
        "name": "veda"
      },
      "pageName2": {
        "title": "anglais",
        "name": "veda"
      },
    },
    //French
    "French": {
      "Home": {
        "pickDft": "utilise Nos Compte",
        "name": "veda"
      },
      "pageName": {
        "title": "French",
        "name": "veda"
      },
      "pageName2": {
        "title": "francais",
        "name": "veda"
      },
    },
    //Kinyarwanda
    "Kinyarwanda": {
      "Home": {
        "pickDft":"Koresha Compte Yacu",
        "name": "veda"
      },
      "pageName": {
        "title": "Kinyarwanda",
        "name": "veda"
      },
      "pageName2": {
        "title": "francais",
        "name": "veda"
      },
    },
    //Kinyarwanda
    "Kiswahili": {
      "Home": {
        "pickDft":"Tumikisha Compte Yetu",
        "name": "veda"
      },
      "pageName": {
        "title": "KiSwahili",
        "name": "veda"
      },
      "pageName2": {
        "title": "francais",
        "name": "veda"
      },
    }
  };

  getLanguage() async{
    final prefs = await SharedPreferences.getInstance();
    final String? keyData =prefs.getString(languageId);
    String lang=keyData??'English';
    (Get.put(StockQuery()).updateLang(lang));
    //return lang;

    //return keyData??'french';


  }

saveData(String valueData) async {
  //final prefs = await SharedPreferences.getInstance();
  //prefs.setString(languageId,valueData);
  (Get.put(StockQuery()).updateLang(valueData));
  final prefs = await SharedPreferences.getInstance();
  prefs.setString(languageId,valueData);

}
deleteData(String valueData) async{
  final prefs = await SharedPreferences.getInstance();
  await prefs.remove("$valueData");//CardUid
  //print(prefs.getString("my_data"));


}

}