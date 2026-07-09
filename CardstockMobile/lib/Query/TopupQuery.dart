import 'dart:convert';
import 'dart:io';

import '../../../Query/AdminQuery.dart';
import '../../../models/User.dart';
import 'package:dio/dio.dart';
import 'package:get/get.dart';
import 'package:sqflite/sqflite.dart';
import '../Utilconfig/AppInfo.dart';
import '../Utilconfig/ConstantClassUtil.dart';
import '../Utilconfig/HideShowState.dart';
import '../models/Topups.dart';

import '../DatabaseHelper.dart';

class TopupQuery extends GetxController{

  var store=8.obs;
  Map<String,dynamic> obj={
    "name":"name",
    "id":1,
    "result":[
      {
        "id":10
      }
    ],
  }.obs;
  Map<String,dynamic> obj2={
    "name":"name",
    "id":1,
    "result":[
      {
        "id":10
      }
    ],
  }.obs;
  AddBalanceOnline(Topups TopupData) async{

    try {

      var params =  {
        "uid":TopupData.uid,//just to avoid error nothing else
        "uidUser":TopupData.uidCreator,//uidUser
        "balance":TopupData.amount,
        "description":TopupData.desc

        //"options": [1,2,3],
      };
      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/AddBalance";
      var response = await Dio().post(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {

        //updateParticipateState(response.data);
        return response;



      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }

  }
  EditBalanceOnline(Topups TopupData) async{

    try {

      var params =  {
        "uid":TopupData.uid,//just to avoid error nothing else
        "uidUser":TopupData.uidCreator,//uidUser
        "balance":TopupData.amount,
        "description":TopupData.desc

        //"options": [1,2,3],
      };
      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/EditBalance";
      var response = await Dio().post(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {

        //updateParticipateState(response.data);
        return response;



      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }

  }

  RedeemBalanceOnline(Topups TopupData) async{

    try {

      var params =  {
        "uid":TopupData.uid,//uidUser
        "uidUser":TopupData.uidCreator,
        "amount":TopupData.amount,
        "description":TopupData.desc

        //"options": [1,2,3],
      };
      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/RedeemBalance";
      var response = await Dio().post(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {

        //updateParticipateState(response.data);
        return response;



      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }

  }
  RedeemBonusOnline(Topups TopupData) async{

    try {

      var params =  {
        "uid":TopupData.uid,//uidUser
        "uidUser":TopupData.uidCreator,
        "amount":TopupData.amount,
        "description":TopupData.desc

        //"options": [1,2,3],
      };
      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/RedeemBonus";
      var response = await Dio().post(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {

        //updateParticipateState(response.data);
        return response;



      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }

  }
  getCompanyRecord() async{//balance and Bonus History
    try {

      var params =  {


        "name":"none",
        "app_vers":AppInfo.version


      };

      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/GetCompanyRecord";
      var response = await Dio().get(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {


        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";

        //updateBalanceHistState(response.data);
        //return response.data;

        if(response.data["status"]!=null){
          return response;
        }
        else{
          Get.put(HideShowState()).setHomenavigator(0);
          await Get.put(AdminQuery()).logout(true);

          Get.toNamed('/Login');
        }
        //


      } else {
        return false;
        //print(false);
      }
    } catch (e) {

      //return false;
      print(e);
    }
  }
  getBalanceHistCreator(Topups topupData,User userData) async{//balance and Bonus History
    try {

      var params =  {

        "LimitStart":topupData.endlimit,  //page
        "LimitEnd":topupData.startlimit,//limit
        "name":userData.name,
        "optionCase":topupData.optionCase//optionCase

      };

      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/GetBalanceHistCreator";
      var response = await Dio().get(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {


        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";

        //updateBalanceHistState(response.data);
        //return response.data;

        return response;


      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }
  }
  getWBalanceHistUser(Topups topupData,User userData) async{//balance and Bonus Widthdraw History
    try {

      var params =  {

        "LimitStart":topupData.endlimit,  //page
        "LimitEnd":topupData.startlimit,//limit
        "uid":userData.uid,//userid
        "optionCase":topupData.optionCase//optionCase

      };

      String authToken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/GetWBalanceHistUser";
      var response = await Dio().get(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${authToken}"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {


        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";

        //updateBalanceHistState(response.data);
        //return response.data;

        return response;


      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }
  }
  GetBalanceHist(Topups TopupData) async{//balance and Bonus History
    try {

      var params =  {

        "uid":TopupData.uid,//userid
        "LimitStart":TopupData.endlimit,  //page
        "LimitEnd":TopupData.startlimit,//limit
        "optionCase":TopupData.optionCase//optionCase
        //"uid":"kebineericMuna_1668935593",
        //"options": [1,2,3],
      };

      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/GetBalanceHist";
      var response = await Dio().get(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {


        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";

        //updateBalanceHistState(response.data);
        //return response.data;
        return response;


      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      print(e);
    }
  }
  GetBalance(Topups TopupData) async{//balance and Bonus
    try {

      var params =  {

        "uid":TopupData.uid

        //"options": [1,2,3],
      };

      String Authtoken =(Get.put(AdminQuery()).obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/GetBalanceUser";
      var response = await Dio().get(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader:"Bearer ${Authtoken}"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {


        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";

        //updateTopupState(response.data);
        return response;


      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;

    }
  }
  Future<List<Topups>> getGroceries() async {
    Database db = await DatabaseHelper.instance.database;
    var groceries = await db.query('groceries', orderBy: 'name');
    List<Topups> topupsList = groceries.isNotEmpty
        ? groceries.map((c) => Topups.fromMap(c)).toList()
        : [];
    return topupsList;
  }

  Future<int> add(Topups topupsdata) async {
    Database db = await DatabaseHelper.instance.database;
    return await db.insert('groceries', topupsdata.toMap());
  }

  Future<List<Topups>> getData() async{
    Database db = await DatabaseHelper.instance.database;
    var groceries=await db.rawQuery('SELECT *FROM groceries');
    List<Topups> topupsList = groceries.isNotEmpty
        ? groceries.map((c) => Topups.fromMap(c)).toList()
        : [];
    return topupsList;

  }
  Future addData() async{
    Database db = await DatabaseHelper.instance.database;
    await db.rawQuery('INSERT INTO testdata(name) VALUES("ndaje")');
  }
  testdata(Topups topupsdata) async {

    Database db = await DatabaseHelper.instance.database;
    //await db.rawQuery('INSERT INTO groceries(name) VALUES("${Topupsdata.name}")');
    int t1=0;
    await db.transaction((txn) async{
      int id1 = await txn.rawInsert(
          'INSERT INTO groceries(name) VALUES("${topupsdata.uid}")');

      t1=id1;
    });
    return t1;


  }

  updateTopupState(list){ //save user
    //store.value=7;
    obj={
      "id":4,
      "resultData":list,
    };
    update();




  }
  updateBalanceHistState(list){ //save user
    //store.value=7;
    obj2={
      "id":4,
      "resultData":list,
    };
    update();




  }


  getMyData() async{
    Database db = await DatabaseHelper.instance.database;
    List<Map> list=await db.rawQuery('select *from groceries');
    return list;
  }
}