import 'package:dio/dio.dart';
import 'package:get/get.dart';

import '../Pages/components/CheckappVersion.dart';
import '../Utilconfig/AppInfo.dart';
import '../Utilconfig/ConstantClassUtil.dart';
import 'AdminQuery.dart';

class AccountController extends GetxController {
  // Reactive state management variables
  var isLoading = true.obs;
  var totalBalance = '\$0.00'.obs;
  var amount = '\$0.00'.obs;
  var bonus = '0 pts'.obs;
  var spending = '\$0.00'.obs;
  var withdraw = '\$0.00'.obs;
  var qtySpent = '0 Items'.obs;

  // Optimized Single Dio Instance Configuration
  final Dio _dio = Dio(BaseOptions(
    baseUrl: ConstantClassUtil.urlLink,
    connectTimeout: const Duration(seconds: 5),
    receiveTimeout: const Duration(seconds: 3),
  ));

  @override
  void onInit() {
    super.onInit();
    _setupHeadersAndFetch();
  }


  void _setupHeadersAndFetch() {
    final authToken = (Get.find<AdminQuery>().obj)["result"][0]["AuthToken"];
    _dio.options.headers['Authorization'] = 'Bearer $authToken';
    _dio.options.headers['Accept'] = 'application/json';

    // Initial fetch when controller is created
    fetchCompanyRecord(showLoader: true);
  }

  // Public pull/refresh trigger helper
  void onRefreshPage() {
    fetchCompanyRecord(showLoader: false);
  }

  // Fast API Request execution
  Future<void> fetchCompanyRecord({bool showLoader = true}) async {
    try {
      if (showLoader) isLoading(true);

      var params = {
        "name": "none",
        "app_vers": AppInfo.version,
      };

      final response = await _dio.get(
        '/GetCompanyRecord',
        queryParameters: params,
      );

      if (response.statusCode == 200 && response.data != null) {
        final result = response.data;

        if (result["status"] == true || result["status"] == "true") {
          final data = result["result"][0];

          // Map your real-time database values instantly into UI elements
          totalBalance.value = data['balance'] ?? '\$0.00';
          amount.value = data['amount'] ?? '\$0.00';
          bonus.value = data['outPromoAmount'] ?? '0 pts';
          spending.value = data['spending'] ?? '\$0.00';
          withdraw.value = data['safeBalance'] ?? '\$0.00';
          qtySpent.value = data['outProAssetQty'] ?? '0 Items';
        } else {
          if (result["result"] == 1) {
            checkAppVersion(
                title: "error",
                message: result["error"],
                primaryButtonText: "Download",
                primaryButtonUrl: result["downNew"]
            );
          }
        }
      }
    } catch (e) {
      print("Dio Runtime Tracking Error: $e");
    } finally {
      if (showLoader) isLoading(false);
    }
  }
}