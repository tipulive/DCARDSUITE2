import 'dart:io';
import 'package:dio/dio.dart';
import '../Utilconfig/ConstantClassUtil.dart';

class ApiClient {
  static final Dio dio = Dio(
    BaseOptions(
      baseUrl: ConstantClassUtil.urlLink,
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {
        HttpHeaders.contentTypeHeader: "application/json",
      },
    ),
  );

  static void setAuthToken(String token) {
    dio.options.headers[HttpHeaders.authorizationHeader] = "Bearer $token";
  }
}