import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'FloatingCartBar.dart';
import 'PricingBottomSheet.dart';
import 'cart_controller.dart';
// Make sure to import your CartController, FloatingCartBar, and PricingBottomSheet files here
// import 'cart_controller.dart';
// import 'pricing_bottom_sheet.dart';
// import 'floating_cart_bar.dart';

class ProductCatalogScreen extends StatelessWidget {
  ProductCatalogScreen({Key? key}) : super(key: key);

  // Example dynamic search result data structure matching your code
  final List<Map<String, dynamic>> searchResult = [
    {"productCode": "SKU-001", "price": "120.0", "pcs": "24"},
    {"productCode": "SKU-002", "price": "85.5", "pcs": "12"},
    {"productCode": "SKU-003", "price": "200.0", "pcs": "48"},
  ];

  @override
  Widget build(BuildContext context) {
    // 1. Initialize CartController safely
    final CartController cartController = Get.put(CartController(), permanent: true);

    return Scaffold(
      appBar: AppBar(
        title: const Text("Search Results"),
      ),
      // 2. Wrap the body with a Stack to overlay the FloatingCartBar at the bottom
      body: Stack(
        children: [
          // Main dynamic search results list
          ListView.builder(
            itemCount: searchResult.length,
            // Extra bottom padding ensures the last item isn't blocked by the floating bar
            padding: const EdgeInsets.only(left: 16, right: 16, top: 16, bottom: 100),
            itemBuilder: (context, index) {
              final product = searchResult[index];
              final String code = "${product["productCode"]}";
              final double cartonPrice = double.tryParse("${product["price"]}") ?? 0.0;
              final int pcs = int.tryParse("${product["pcs"]}") ?? 0;

              return Card(
                margin: const EdgeInsets.only(bottom: 12),
                elevation: 2,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                child: ListTile(
                  contentPadding: const EdgeInsets.all(16),
                  title: Text(code, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                  subtitle: Padding(
                    padding: const EdgeInsets.only(top: 6),
                    child: Text("Carton Price: \$$cartonPrice | $pcs pcs/carton"),
                  ),
                  trailing: ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.blueAccent,
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                    onPressed: () {
                      // 3. Open PricingBottomSheet with the dynamic data and connected onConfirm
                      PricingBottomSheet.show(
                        productCode: code,
                        cartonPrice: cartonPrice,
                        pcsInCarton: pcs,
                        defaultMargin: 5.0,
                        currencySymbol: "\$",
                        onConfirm: (quantity, totalPrice, totalProfit) {
                          final cartItem = CartItem(
                            productCode: code,
                            quantity: quantity,
                            pricePerPiece: quantity > 0 ? (totalPrice / quantity) : 0.0,
                            totalPrice: totalPrice,
                            totalProfit: totalProfit,
                            cartonCostPrice: cartonPrice,
                            pcsInCarton: pcs,
                            marginPerCarton: 5.0,
                          );

                          // Adds or updates item, instantly rendering the FloatingCartBar
                          cartController.addItem(cartItem);
                        },
                      );
                    },
                    child: const Text("Select", style: TextStyle(color: Colors.white)),
                  ),
                ),
              );
            },
          ),

          // 4. Floating Cart Bar pinned at the bottom of the Stack
          const FloatingCartBar(currencySymbol: "\$"),
        ],
      ),
    );
  }
}