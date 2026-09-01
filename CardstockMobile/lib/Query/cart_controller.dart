import 'package:get/get.dart';

class CartItem {
  final String productCode;
  final int quantity;
  final double pricePerPiece;
  final double totalPrice;
  final double totalProfit;
  final double cartonCostPrice;
  final int pcsInCarton;
  final double marginPerCarton;

  CartItem({
    required this.productCode,
    required this.quantity,
    required this.pricePerPiece,
    required this.totalPrice,
    required this.totalProfit,
    required this.cartonCostPrice,
    required this.pcsInCarton,
    required this.marginPerCarton,
  });
}

class CartController extends GetxController {
  var items = <CartItem>[].obs;
// Draggable position coordinates
  var posX = 0.0.obs;
  var posY = 0.0.obs;
  var isPositionInitialized = false.obs;
  double get grandTotal => items.fold(0.0, (sum, item) => sum + item.totalPrice);
  double get grandInterest => items.fold(0.0, (sum, item) => sum + item.totalProfit);
  int get totalArticles => items.length;


  void initializePosition(double screenWidth, double screenHeight) {
    if (!isPositionInitialized.value) {
      // Center the floating bar initially
      posX.value = screenWidth * 0.1; // 10% margin on sides
      posY.value = screenHeight * 0.45; // Center vertically
      isPositionInitialized.value = true;
    }
  }
  void addItem(CartItem newItem) {
    int index = items.indexWhere((i) => i.productCode == newItem.productCode);

    if (index != -1) {
      final existing = items[index];
      final combinedQty = existing.quantity + newItem.quantity;
      final updatedTotalPrice = existing.pricePerPiece * combinedQty;
      final profitPerPiece = existing.totalProfit / existing.quantity;
      final updatedTotalProfit = profitPerPiece * combinedQty;

      items[index] = CartItem(
        productCode: existing.productCode,
        quantity: combinedQty,
        pricePerPiece: existing.pricePerPiece,
        totalPrice: updatedTotalPrice,
        totalProfit: updatedTotalProfit,
        cartonCostPrice: existing.cartonCostPrice,
        pcsInCarton: existing.pcsInCarton,
        marginPerCarton: existing.marginPerCarton,
      );
    } else {
      items.add(newItem);
    }
  }

  void updateItem(CartItem updatedItem) {
    int index = items.indexWhere((i) => i.productCode == updatedItem.productCode);
    if (index != -1) {
      items[index] = updatedItem;
    }
  }

  void removeItem(String productCode) {
    items.removeWhere((item) => item.productCode == productCode);
  }

  void clearCart() {
    items.clear();
  }
}