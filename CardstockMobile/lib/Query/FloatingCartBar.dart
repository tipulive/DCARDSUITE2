import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'PricingBottomSheet.dart';
import 'cart_controller.dart';

class FloatingCartBar extends StatelessWidget {
  final String currencySymbol;

  const FloatingCartBar({Key? key, this.currencySymbol = '\$'}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final cartController = Get.find<CartController>();
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;

    // Initialize center position on first load
    cartController.initializePosition(screenWidth, screenHeight);

    return Obx(() {
      if (cartController.items.isEmpty) return const SizedBox.shrink();

      return Positioned(
        left: cartController.posX.value,
        top: cartController.posY.value,
        child: GestureDetector(
          // Enables dragging anywhere on screen
          onPanUpdate: (details) {
            cartController.posX.value += details.delta.dx;
            cartController.posY.value += details.delta.dy;
          },
          child: GestureDetector(
            onTap: () => _showCartDetails(context, cartController),
            child: Container(
              width: screenWidth * 0.85, // Responsive width centered nicely
              padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 14),
              decoration: BoxDecoration(
                color: Colors.grey[900],
                borderRadius: BorderRadius.circular(16),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.35),
                    blurRadius: 15,
                    offset: const Offset(0, 8),
                  ),
                ],
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(8),
                        decoration: BoxDecoration(
                          color: Colors.blueAccent,
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Text(
                          "${cartController.totalArticles}",
                          style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                        ),
                      ),
                      const SizedBox(width: 12),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          const Text("View Order Cart", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 15)),
                          Text(
                            "Interest: $currencySymbol${cartController.grandInterest.toStringAsFixed(2)}",
                            style: const TextStyle(color: Colors.greenAccent, fontSize: 12),
                          ),
                        ],
                      ),
                    ],
                  ),
                  Row(
                    children: [
                      Text(
                        "$currencySymbol${cartController.grandTotal.toStringAsFixed(2)}",
                        style: const TextStyle(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(width: 12),
                      GestureDetector(
                        onTap: () => cartController.clearCart(),
                        child: const Icon(Icons.close, color: Colors.white54, size: 20),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      );
    });
  }

  void _showCartDetails(BuildContext context, CartController controller) {
    Get.bottomSheet(
      Container(
        padding: const EdgeInsets.all(20),
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text("Order Summary", style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                TextButton.icon(
                  onPressed: () {
                    controller.clearCart();
                    Get.back();
                  },
                  icon: const Icon(Icons.delete_sweep, color: Colors.red, size: 18),
                  label: const Text("Clear All", style: TextStyle(color: Colors.red)),
                ),
              ],
            ),
            const Divider(),
            const SizedBox(height: 8),
            ConstrainedBox(
              constraints: const BoxConstraints(maxHeight: 350),
              child: Obx(() => ListView.separated(
                shrinkWrap: true,
                itemCount: controller.items.length,
                separatorBuilder: (_, __) => const Divider(height: 16),
                itemBuilder: (context, index) {
                  final item = controller.items[index];
                  return Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Expanded(
                        flex: 3,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(item.productCode, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
                            const SizedBox(height: 2),
                            Text(
                              "${item.quantity} pcs × $currencySymbol${item.pricePerPiece.toStringAsFixed(2)}",
                              style: TextStyle(color: Colors.grey[600], fontSize: 13),
                            ),
                            Text(
                              "Profit: +$currencySymbol${item.totalProfit.toStringAsFixed(2)}",
                              style: const TextStyle(color: Colors.green, fontSize: 11, fontWeight: FontWeight.w500),
                            ),
                          ],
                        ),
                      ),
                      Expanded(
                        flex: 2,
                        child: Text(
                          "$currencySymbol${item.totalPrice.toStringAsFixed(2)}",
                          textAlign: TextAlign.right,
                          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                        ),
                      ),
                      Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          IconButton(
                            icon: const Icon(Icons.edit_outlined, size: 20, color: Colors.blueAccent),
                            onPressed: () {
                              Get.back();
                              PricingBottomSheet.show(
                                productCode: item.productCode,
                                cartonPrice: item.cartonCostPrice,
                                pcsInCarton: item.pcsInCarton,
                                defaultMargin: item.marginPerCarton,
                                currencySymbol: currencySymbol,
                                onConfirm: (qty, total, profit) {
                                  controller.addItem(CartItem(
                                    productCode: item.productCode,
                                    quantity: qty,
                                    pricePerPiece: total / qty,
                                    totalPrice: total,
                                    totalProfit: profit,
                                    cartonCostPrice: item.cartonCostPrice,
                                    pcsInCarton: item.pcsInCarton,
                                    marginPerCarton: item.marginPerCarton,
                                  ));
                                },
                              );
                            },
                          ),
                          IconButton(
                            icon: const Icon(Icons.delete_outline, size: 20, color: Colors.redAccent),
                            onPressed: () => controller.removeItem(item.productCode),
                          ),
                        ],
                      ),
                    ],
                  );
                },
              )),
            ),
            const SizedBox(height: 16),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.grey[100],
                borderRadius: BorderRadius.circular(12),
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text("Total Interest Earned:", style: TextStyle(fontWeight: FontWeight.w600)),
                  Obx(() => Text(
                    "$currencySymbol${controller.grandInterest.toStringAsFixed(2)}",
                    style: const TextStyle(color: Colors.green, fontWeight: FontWeight.bold, fontSize: 16),
                  )),
                ],
              ),
            ),
          ],
        ),
      ),
      isScrollControlled: true,
    );
  }
}