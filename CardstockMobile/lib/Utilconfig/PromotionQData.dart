

import 'dart:ffi';
import 'dart:io';
import 'package:flutter/cupertino.dart';

import '../../../Query/AdminQuery.dart';
import 'package:get/get.dart';
import 'package:dio/dio.dart' as dio;

import '../Utilconfig/AppInfo.dart';
import '../models/User.dart';
import 'ConstantClassUtil.dart';

class PromotionQData extends GetxController{

  List<Map<String, dynamic>> promotions =[];

  void updatePromotions(dynamic valData) {
    promotions.clear();

    if (valData != null) {
      if (valData is List) {
        // Add each promotion from the list
        promotions.addAll(valData.cast<Map<String, dynamic>>());
      } else if (valData is Map<String, dynamic>) {
        // Single promotion
        promotions.add(valData);
      }
    }

    update(); // your UI update method
  }
  /*updatePromotions(valData){
    promotions.clear();

    if (valData != null) {
      promotions.add(valData);
      //print(valData);
      //promotions.add(valData);
    }

    update();

  }*/

  /*void updatePromotions(dynamic valData) {
    promotions.clear();

    if (valData != null && valData is List) {
      // Safely cast each item in the list to Map<String, dynamic>
      promotions.add(
        valData.map((item) => Map<String, dynamic>.from(item)),
      );
     // print(promotions);
    }

    update();
  }*/
  Future<dio.Response?> getPromoData() async {
    try {
      final dioClient = dio.Dio();

      final authToken =
      Get.find<AdminQuery>().obj["result"][0]["AuthToken"];

      final response = await dioClient.get(
        "${ConstantClassUtil.urlLink}/getPromoData",
        queryParameters: {
          "platform":"mobile",
          "app_vers": AppInfo.version,
        },
        options: dio.Options(
          headers: {
            HttpHeaders.contentTypeHeader: "application/json",
            HttpHeaders.authorizationHeader: "Bearer $authToken",
          },
          receiveTimeout: const Duration(seconds: 15),
          sendTimeout: const Duration(seconds: 15),
        ),
      );

      return response.statusCode == 200 ? response : null;
    } on dio.DioException catch (e) {
      debugPrint("Dio error: ${e.response?.data ?? e.message}");
      return null;
    } catch (e) {
      debugPrint("Unexpected error: $e");
      return null;
    }
  }
  Future<dio.Response?> getMyPromotion(User userData) async {
    try {
      final dioClient = dio.Dio();

      final authToken =
      Get.find<AdminQuery>().obj["result"][0]["AuthToken"];

      final response = await dioClient.get(
        "${ConstantClassUtil.urlLink}/GetMyPromotion",
        queryParameters: {
          "uidUser":userData.uid,
          "app_vers": AppInfo.version,
        },
        options: dio.Options(
          headers: {
            HttpHeaders.contentTypeHeader: "application/json",
            HttpHeaders.authorizationHeader: "Bearer $authToken",
          },
          receiveTimeout: const Duration(seconds: 15),
          sendTimeout: const Duration(seconds: 15),
        ),
      );

      return response.statusCode == 200 ? response : null;
    } on dio.DioException catch (e) {
      debugPrint("Dio error: ${e.response?.data ?? e.message}");
      return null;
    } catch (e) {
      debugPrint("Unexpected error: $e");
      return null;
    }
  }
  Future<dio.Response?> withdrawLongPromo(User userData) async {
    try {
      final dioClient = dio.Dio();

      final authToken =
      Get.find<AdminQuery>().obj["result"][0]["AuthToken"];

      final response = await dioClient.post(
        "${ConstantClassUtil.urlLink}/GetMyPromotion",
        data: {
          "uidUser": userData.uid,
          "app_vers": AppInfo.version,
        },
        options: dio.Options(
          headers: {
            HttpHeaders.contentTypeHeader: "application/json",
            HttpHeaders.authorizationHeader: "Bearer $authToken",
          },
          receiveTimeout: const Duration(seconds: 15),
          sendTimeout: const Duration(seconds: 15),
        ),
      );

      return response.statusCode == 200 ? response : null;
    } on dio.DioException catch (e) {
      debugPrint("Dio error: ${e.response?.data ?? e.message}");
      return null;
    } catch (e) {
      debugPrint("Unexpected error: $e");
      return null;
    }
  }

}