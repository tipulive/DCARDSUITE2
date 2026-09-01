import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'PricingController.dart';

class PricingBottomSheet extends StatelessWidget {
  final PricingController controller;
  final String currencySymbol;
  final Function(int quantity, double totalPrice, double totalProfit) onConfirm;

  const PricingBottomSheet({
    Key? key,
    required this.controller,
    required this.currencySymbol,
    required this.onConfirm,
  }) : super(key: key);

  /// Call this static method from anywhere in your app
  static void show({
    required String productCode,
    required double cartonPrice,
    required int pcsInCarton,
    double defaultMargin = 5.0,
    String currencySymbol = '\$',
    required Function(int quantity, double totalPrice, double totalProfit) onConfirm,
  }) {
    final controller = Get.put(PricingController(
      productCode: productCode,
      cartonCostPrice: cartonPrice,
      pcsInCarton: pcsInCarton,
      initialMargin: defaultMargin,
    ));

    Get.bottomSheet(
      PricingBottomSheet(
        controller: controller,
        currencySymbol: currencySymbol,
        onConfirm: onConfirm,
      ),
      isScrollControlled: true,
      backgroundColor: Colors.white,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
    ).whenComplete(() => Get.delete<PricingController>());
  }

  @override
  Widget build(BuildContext context) {
    // SingleChildScrollView allows the content to scroll if the keyboard pushes it up
    return SingleChildScrollView(
      child: Padding(
        padding: EdgeInsets.only(
          left: 20,
          right: 20,
          top: 12,
          // Pushes the UI up dynamically based on the keyboard height
          bottom: MediaQuery.of(context).viewInsets.bottom + 24,
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Drag Handle
            Center(
              child: Container(
                width: 40, height: 4,
                decoration: BoxDecoration(
                  color: Colors.grey[300],
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
            ),
            const SizedBox(height: 20),

            // Header
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  controller.productCode,
                  style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                ),
                Text(
                  "${controller.pcsInCarton} pcs/carton",
                  style: TextStyle(color: Colors.grey[600], fontSize: 14),
                ),
              ],
            ),
            const SizedBox(height: 24),

            // Margin Input & Per Piece Display
            Row(
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text("Carton Margin", style: TextStyle(color: Colors.grey[600], fontSize: 12)),
                      const SizedBox(height: 8),
                      TextFormField(
                        initialValue: controller.marginPerCarton.value.toStringAsFixed(2),
                        keyboardType: const TextInputType.numberWithOptions(decimal: true),
                        onChanged: controller.updateMargin,
                        decoration: InputDecoration(
                          prefixIcon: Padding(
                            padding: const EdgeInsets.all(12.0),
                            child: Text(currencySymbol, style: const TextStyle(fontSize: 16)),
                          ),
                          prefixIconConstraints: const BoxConstraints(minWidth: 0, minHeight: 0),
                          contentPadding: const EdgeInsets.symmetric(vertical: 12, horizontal: 12),
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.blue[50],
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text("Price / Piece", style: TextStyle(color: Colors.blue[800], fontSize: 12)),
                        const SizedBox(height: 4),
                        Obx(() => Text(
                          "$currencySymbol${controller.pricePerPiece.toStringAsFixed(2)}",
                          style: TextStyle(color: Colors.blue[900], fontSize: 18, fontWeight: FontWeight.bold),
                        )),
                      ],
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 24),

            // Quick Quantity Selectors
            Text("Select Quantity", style: TextStyle(color: Colors.grey[800], fontWeight: FontWeight.w600)),
            const SizedBox(height: 12),
            Wrap(
              spacing: 8,
              runSpacing: 8,
              children: [
                _buildChip("1 Dozen", () => controller.selectedQuantity.value = 12),
                _buildChip("1/4 Carton", () => controller.setFractionQuantity(0.25)),
                _buildChip("1/3 Carton", () => controller.setFractionQuantity(0.3333)),
                _buildChip("1/2 Carton", () => controller.setFractionQuantity(0.5)),
              ],
            ),
            const SizedBox(height: 16),

            // Custom Quantity Input
            Obx(() => TextFormField(
              key: ValueKey(controller.selectedQuantity.value), // Forces rebuild when chip is tapped
              initialValue: controller.selectedQuantity.value.toString(),
              keyboardType: TextInputType.number,
              onChanged: controller.updateQuantity,
              decoration: InputDecoration(
                labelText: "Custom Pieces",
                contentPadding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
                border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
              ),
            )),
            const SizedBox(height: 24),

            // Final Totals & Confirm Button
            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                gradient: LinearGradient(colors: [Colors.grey[900]!, Colors.grey[800]!]),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Column(
                children: [
                  Obx(() => Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text("Total Price", style: TextStyle(color: Colors.white70, fontSize: 14)),
                          const SizedBox(height: 4),
                          Text(
                            "$currencySymbol${controller.finalTotalPrice.toStringAsFixed(2)}",
                            style: const TextStyle(color: Colors.white, fontSize: 24, fontWeight: FontWeight.bold),
                          ),
                        ],
                      ),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.end,
                        children: [
                          const Text("Your Profit", style: TextStyle(color: Colors.greenAccent, fontSize: 14)),
                          const SizedBox(height: 4),
                          Text(
                            "$currencySymbol${controller.finalTotalProfit.toStringAsFixed(2)}",
                            style: const TextStyle(color: Colors.greenAccent, fontSize: 20, fontWeight: FontWeight.bold),
                          ),
                        ],
                      ),
                    ],
                  )),
                  const SizedBox(height: 20),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.blueAccent,
                        padding: const EdgeInsets.symmetric(vertical: 16),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                      ),
                      onPressed: () {
                        // Pass data back and close the sheet
                        onConfirm(
                          controller.selectedQuantity.value,
                          controller.finalTotalPrice,
                          controller.finalTotalProfit,
                        );
                        Get.back();
                      },
                      child: const Text("Confirm & Add", style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.white)),
                    ),
                  )
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildChip(String label, VoidCallback onTap) {
    return ActionChip(
      label: Text(label),
      backgroundColor: Colors.grey[200],
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      onPressed: onTap,
    );
  }
}