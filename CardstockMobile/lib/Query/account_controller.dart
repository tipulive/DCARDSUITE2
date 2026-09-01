

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
  var received='0.00'.obs;
  var transfer='0.00'.obs;
  var dept='0.00'.obs;

  var outPromoAssetQty='0.00'.obs;
  var outPromoAmount='0.00'.obs;
  var outProAssetQty='0.00'.obs;
  var proAssetQty='0.00'.obs;
  var promoAmount='0.00'.obs;
  var promoAsset='0.00'.obs;


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
        '/myAccount',
        queryParameters: params,
      );

      if (response.statusCode == 200 && response.data != null) {
        final result = response.data;
        print(result);

        if (result["status"] == true || result["status"] == "true") {
          final data = result["result"][0];
          double sumB = double.parse(data['outPromoAmount']) +
              double.parse(data['promoAmount']) +
              double.parse(data['outPromoAsset']) +
              double.parse(data['promoAsset']);


/*calculate really Amount of User */
          double safeAmount = double.parse(data['balanceSent'] ?? '0');//sent Amount
          double receivedAmount= double.parse(data['safeBalance'] ?? '0');//received from others users
          double mainAmount = double.parse(data['balance'] ?? '0');

          double sumA = mainAmount+receivedAmount - safeAmount;

          double sumC = double.parse(data['promoAmount'] ?? '0') +
              double.parse(data['outPromoAmount'] ?? '0') +
              double.parse(data['outPromoAsset'] ?? '0') +
              double.parse(data['promoAsset'] ?? '0') +
              //double.parse(data['safeBalance'] ?? '0') +//received from others users
              double.parse(data['spending'] ?? '0'); // Note: 'sent' was listed twice in your formula
          double withdrawV = double.parse(data['promoAmount'] ?? '0') +
              double.parse(data['outPromoAmount'] ?? '0') +
              double.parse(data['outPromoAsset'] ?? '0') +
              double.parse(data['promoAsset'] ?? '0');
          double amountTot = sumA - sumC;
          double totQtyBonus= double.parse(data['outProAssetQty'] ?? '0')+ double.parse(data['proAssetQtyt'] ?? '0');
          /*calculate really Amount of User */

          // Map your real-time database values instantly into UI elements
          totalBalance.value = data['balance'] ?? '\$0.00';
          amount.value = ConstantClassUtil().formatNumber(amountTot);
          bonus.value = ConstantClassUtil().formatNumber(sumB);
          spending.value = data['spending'] ?? '\$0.00';
          withdraw.value =ConstantClassUtil().formatNumber(withdrawV);
          received.value=data['safeBalance'] ?? '\$0.00';
          transfer.value=data['balanceSent'] ?? '\$0.00';
          dept.value=data['dettes'] ?? '\$0.00';
           outPromoAssetQty.value= data['outPromoAsset'] ?? '0';
          outPromoAmount.value= data['outPromoAmount'] ?? '0';
          outProAssetQty.value= data['outProAssetQty'] ?? '0';

          proAssetQty.value=data['proAssetQty'] ?? '0';
          promoAmount.value= data['promoAmount'] ?? '0';
          promoAsset.value= data['promoAsset'] ?? '0';

          qtySpent.value = ConstantClassUtil().formatNumber(totQtyBonus);
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
    } finally {
      if (showLoader) isLoading(false);
    }
  }
}