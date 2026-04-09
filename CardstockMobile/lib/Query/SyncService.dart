import 'dart:convert';
import 'dart:io';

import 'package:get/get.dart';
import 'package:dio/dio.dart';

import '../Utilconfig/ConstantClassUtil.dart';
import '../Query/SyncDatabaseQuery.dart';
import '../Query/CardQuery.dart';
import '../models/CardModel.dart';
import '../models/Syncoff.dart';
import '../models/Syncon.dart';
import '../Query/AdminQuery.dart';



class SyncService { //online and offline download
  AdminQuery adminStatedata=Get.put(AdminQuery());

  SyncUploadCard() async{
    //print(await SyncDatabaseQuery().getSyncOnCard());

   if((await SyncDatabaseQuery().getSyncOnCard())==0) return "no data to update";
   try {

     var params =  {
       "item": "itemx",
       "onlineData":await SyncDatabaseQuery().getSyncOnCard(),
       //"options": [1,2,3],
     };

     var token="24|pypkPRKJJq7LbXfjVeAd6bXVRylMZ0xPYBM4F00v";
     var url="${ConstantClassUtil.urlLink}/CompanySyncUpload";
     var response = await Dio().post(url,
       options: Options(headers: {
         HttpHeaders.contentTypeHeader: "application/json",
         "Authorization": "Bearer ${token}",
       }),
       data: jsonEncode(params),
     );
     if (response.statusCode == 200) {


       //return response.data;
       return (await CardQuery().synCardUpdated(CardModel(uid:"hello"),Syncon(result:response.data)));
     } else {
       return false;
       //print(false);
     }
   } catch (e) {
     return e;
     //print(false);
   }
  }
  SyncDownloadCard() async{ //download Card online

    try {

      var params =  {
        "versionCount":await SyncDatabaseQuery().getSyncOffCard(),

        //"options": [1,2,3],
      };

      var token="24|pypkPRKJJq7LbXfjVeAd6bXVRylMZ0xPYBM4F00v";
      //var token=(adminStatedata.obj)["result"][0]["AuthToken"];
      var url="${ConstantClassUtil.urlLink}/CompanySyncCardDownload";
      var response = await Dio().request(url,
        queryParameters:params,
        options: Options(method:'GET',headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          "Authorization": "Bearer ${token}",
          //HttpHeaders.authorizationHeader:""
        }),

      );
      if (response.statusCode == 200) {

        //return response.data;
        //return response.data["User"]["name"];
        //print((response.data));
        for(var i=0;i<((response.data)["result"]).length;i++)
        {
          //print((await apiData())["products"][i]["title"])
          //print((response.data));
          await CardQuery().syncOffCardDownload(CardModel(uid:(response.data)["result"][i]["uid"],uidCreator:(response.data)["result"][i]["uidCreator"],subscriber:(response.data)["result"][i]["subscriber"]),Syncoff(uid:(response.data)["SyncUid"],versionCount:(response.data)["CurrentVersion"],VersionOnline:(response.data)["versionCountOnline"]));
          //await CardQuery().SyncOffCardDownload(CardData, syncoffdata)
        }
        //await CardQuery().SyncOffCardDownload();


      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      return e;
      // print(e);
    }

  }




}