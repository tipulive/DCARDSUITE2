

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

  updatePromotions(valData){
    promotions.clear();

    if (valData != null) {
      promotions.add(valData);
    }

    update();

  }
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
}