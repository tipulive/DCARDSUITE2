import 'package:flutter/material.dart';
import 'package:get/get.dart';

class SendStockController extends GetxController {
  late TextEditingController quantityController;

  // Reactive State
  final quantityStr = "".obs;
  final selectedCompany = <String, dynamic>{}.obs;

  @override
  void onInit() {
    super.onInit();
    quantityController = TextEditingController();
    quantityController.addListener(_onQuantityChanged);
  }

  void _onQuantityChanged() {
    quantityStr.value = quantityController.text.trim();
  }

  /// Initializer method to reset/configure controller before opening sheet
  void initData({String initialQty = "5", Map<String, dynamic>? company}) {
    quantityController.text = initialQty;
    quantityStr.value = initialQty;
    selectedCompany.value = company ?? {};
  }

  /// Reset state to default (useful when re-opening sheet)
  void reset() {
    quantityController.clear();
    quantityStr.value = "";
    selectedCompany.clear();
  }

  /// Validation: Quantity must be integer > 0 AND company must be chosen
  bool get isValid {
    final qty = int.tryParse(quantityStr.value) ?? 0;
    return qty > 0 && selectedCompany.isNotEmpty;
  }

  /// Update selected recipient company
  void selectCompany(Map<String, dynamic> company) {
    selectedCompany.value = company;
  }

  @override
  void onClose() {
    quantityController.removeListener(_onQuantityChanged);
    quantityController.dispose();
    super.onClose();
  }
}