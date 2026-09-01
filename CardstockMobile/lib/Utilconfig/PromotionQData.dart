


import 'dart:io';
import 'package:dio/dio.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import '../../../Query/AdminQuery.dart';
import 'package:get/get.dart';
import 'package:dio/dio.dart' as dio;

import '../Pages/components/CheckappVersion.dart';
import '../Utilconfig/AppInfo.dart';
import '../models/QuickBonus.dart';
import '../models/User.dart';
import 'ConstantClassUtil.dart';

class PromotionQData extends GetxController{

  var promoResult = <String, dynamic>{}.obs; // observable
  List<Map<String, dynamic>> promotions = [];
  /*List<Map<String, dynamic>> promotions = [
    {
      "success":false,
      "quick": [
        {
          "id": "promo_wB_1786194433",
          "inStock": [
            { "productName": "bombo", "qtyBonus": 1 }
          ],
          "BonusTotal": 100
        }
      ],
      "long": []
    }
  ];*/
  DateTime? _lastFetchTime;
  static const Duration _cacheDuration = Duration(minutes: 0); // Adjust as needed

  // ──────────────────────────────────────────────────────────────
  // Main method: returns true if promotions are available (cached or fresh).
  // If forceRefresh is true, it always fetches from server.
  // ──────────────────────────────────────────────────────────────
  Future<bool> fetchPromotions({bool forceRefresh = false}) async {
    // 1. Cache valid? Return true (data already in `promotions`).
    if (!forceRefresh && _lastFetchTime != null) {
      final age = DateTime.now().difference(_lastFetchTime!);
      if (age < _cacheDuration) {
        return true;
      }
    }

    // 2. Cache expired or force refresh → call the API.
    try {
      final response = await getPromoData();
      //print(response);
      if (response != null && response.data['status'] == true) {
        updatePromotions(response.data['result']);   // updates `promotions`
        _lastFetchTime = DateTime.now();
        return true;
      } else {
        print("promotion Data");
        final data = response?.data;
        if (data != null && data['result'] == 1) {
          checkAppVersion(
            title: "error",
            message: data["error"],
            primaryButtonText: "Download",
            primaryButtonUrl: data["downNew"],
          );
        }

        // API returned failure → keep old cache, but indicate failure.
        return false;
      }
    } catch (e) {
      // Network or parsing error
      debugPrint("❌ fetchPromotions error: $e");
      return false;
    }
  }

  // ──────────────────────────────────────────────────────────────
  // Existing API call (unchanged, but made private)
  // ──────────────────────────────────────────────────────────────
  Future<dio.Response?> _getPromoData() async {
    try {
      final dioClient = dio.Dio();
      final authToken =
      Get.find<AdminQuery>().obj["result"][0]["AuthToken"];

      final response = await dioClient.get(
        "${ConstantClassUtil.urlLink}/getPromoData",
        queryParameters: {
          "platform": "mobile",
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

  // ──────────────────────────────────────────────────────────────
  // Existing update method (unchanged)
  // ──────────────────────────────────────────────────────────────
  void updatePromotions(dynamic valData) {
    promotions.clear();
    if (valData != null) {
      if (valData is List) {
        promotions.addAll(valData.cast<Map<String, dynamic>>());
      } else if (valData is Map<String, dynamic>) {
        promotions.add(valData);
      }
    }
    update(); // notifies GetBuilder / Obx if you use them
  }

  // ──────────────────────────────────────────────────────────────
  // Helper to clear cache (e.g., for logout or manual reset)
  // ──────────────────────────────────────────────────────────────
  void clearCache() {
    _lastFetchTime = null;
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
      //debugPrint("Dio error: ${e.response?.data ?? e.message}");
      if (e.type == DioExceptionType.connectionError || e.error is SocketException) {
        Get.snackbar(
          'Connection Error',
          'Please check your internet connection',
          snackPosition: SnackPosition.TOP,
          backgroundColor: Colors.redAccent,
          colorText: Colors.white,
        );
      } else {
        Get.snackbar(
          'Error',
          e.message ?? 'An unexpected error occurred',
          snackPosition: SnackPosition.TOP,
        );
      }
      return null;
    } catch (e) {
      debugPrint("Unexpected error: $e");
      return null;
    }
  }
  Future<dio.Response?>withdrawLongPromo(QuickBonus bonusData) async {
    try {
      final dioClient = dio.Dio();

      final authToken = Get.find<AdminQuery>().obj["result"][0]["AuthToken"];

      final response = await dioClient.get(
        "${ConstantClassUtil.urlLink}/withdrawLongPromo",
        queryParameters: {
          "uidUser":bonusData.uid,
          "promoData":bonusData.bonusValue,
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

      ConstantClassUtil().hideLoadingDialog();
      Get.back();
      Get.back();
      ConstantClassUtil.showError(
        message: 'Failed to connect to the server. Check your internet connection.',
      );


      debugPrint("Dio error: ${e.response?.data ?? e.message}");
      return null;
    } catch (e) {
      ConstantClassUtil().hideLoadingDialog();
      Get.back();
      Get.back();
      ConstantClassUtil.showError(
        message: 'Failed to connect to the server. Check your internet connection.',
      );



      debugPrint("Unexpected error: $e");
      return null;
    }
  }


}