import 'package:flutter/material.dart';
import 'package:get/get.dart';

class PricingController extends GetxController {
  final String productCode;
  final double cartonCostPrice;
  final int pcsInCarton;

  // Reactive variables
  var marginPerCarton = 0.0.obs;
  var selectedQuantity = 0.obs;

  PricingController({
    required this.productCode,
    required this.cartonCostPrice,
    required this.pcsInCarton,
    required double initialMargin,
  }) {
    marginPerCarton.value = initialMargin;
    selectedQuantity.value = 1; // Default to 1 piece
  }

  // Computed properties
  double get totalCartonSellingPrice => cartonCostPrice + marginPerCarton.value;
  double get pricePerPiece => totalCartonSellingPrice / pcsInCarton;
  double get profitPerPiece => marginPerCarton.value / pcsInCarton;

  double get finalTotalPrice => pricePerPiece * selectedQuantity.value;
  double get finalTotalProfit => profitPerPiece * selectedQuantity.value;

  void updateMargin(String val) {
    marginPerCarton.value = double.tryParse(val) ?? 0.0;
  }

  void updateQuantity(String val) {
    selectedQuantity.value = int.tryParse(val) ?? 0;
  }

  void setFractionQuantity(double fraction) {
    selectedQuantity.value = (pcsInCarton * fraction).round();
  }
}