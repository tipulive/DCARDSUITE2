class PromotionService {

  Map<String, dynamic> cart = {
    "total": 4000,
    "count": 215,
    "card": true,
    "items": [
      {"productName": "simba", "price": 20, "qty": 10},
      {"productName": "fanta", "price": 30, "qty": 10},
      {"productName": "bread", "price": 30, "qty": 20},
      {"productName": "coke", "price": 10, "qty": 50}
    ]
  };

  //Map<String, dynamic> cart ={"total": 291, "count": 4, "card": true, "items": [{"productName": "nyota", "price": 70, "qty": 1}, {"productName": "1101 igikombe", "price": 65, "qty": 1}, {"productName":"simba", "price": 78, "qty": 2}]};
  /// Apply best applicable promotion from multiple promotions
  static Map<String, dynamic> applyBestPromotion(
      Map<String, dynamic> cart, List<Map<String, dynamic>> promotions) {
    List<Map<String, dynamic>> applicablePromotions = [];

    // Check each promotion for applicability
    for (var promotion in promotions) {
      bool conditionsMet = checkPromotionConditions(
          promotion['condition'], promotion['promotion']['items'], cart);

      if (conditionsMet) {
        applicablePromotions.add(promotion);
      }
    }

    if (applicablePromotions.isEmpty) {
      return {
        'success': false,
        'message': 'No applicable promotions found',
        'promotion': null,
        'cart': cart
      };
    }

    // Find the best promotion (highest amount)
    applicablePromotions.sort((a, b) {
      return b['promotion']['amount'].compareTo(a['promotion']['amount']);
    });

    Map<String, dynamic> bestPromotion = applicablePromotions[0];

    // Apply the best promotion
    Map<String, dynamic> result = applyPromotionToCart(
        bestPromotion['promotion'], cart);
    result['promotion']['id'] = bestPromotion['id'];
    result['promotion']['promotype'] = bestPromotion['promotype'];

    return result;
  }

  /// Apply promotion based on cart data
  static Map<String, dynamic> applyPromotion(
      Map<String, dynamic> cart, Map<String, dynamic> promotionConfig) {
    // Check if conditions are met
    bool conditionsMet = checkPromotionConditions(promotionConfig['condition'],
        promotionConfig['promotion']['items'], cart);

    if (!conditionsMet) {
      return {
        'success': false,
        'message': 'Promotion conditions not met',
        'promotion': null,
        'cart': cart
      };
    }

    // Apply promotion
    Map<String, dynamic> result =
    applyPromotionToCart(promotionConfig['promotion'], cart);
    result['promotion']['id'] = promotionConfig['id'];
    result['promotion']['promotype'] = promotionConfig['promotype'];

    return result;
  }

  /// Check if all promotion conditions are satisfied
  static bool checkPromotionConditions(Map<String, dynamic> condition,
      List<Map<String, dynamic>> promotionItems, Map<String, dynamic> cart) {
    // 1. Check card condition
    if (!checkCardCondition(condition['card'], cart['card'])) {
      return false;
    }

    // 2. Filter cart items based on allowProduct rule
    List<Map<String, dynamic>> filteredCartItems =
    filterCartProductsByCondition(condition, cart['items']);

    // 3. Calculate totals from filtered cart items
    Map<String, dynamic> cartTotals = calculateCartTotals(filteredCartItems);

    // 4. Check cart total/count conditions
    return checkCartTotalCondition(condition, cartTotals);
  }

  /// Check card condition
  static bool checkCardCondition(String requiredCardStatus, bool userHasCard) {
    if (requiredCardStatus == 'both') {
      return true;
    }
    if (requiredCardStatus == 'yes') {
      return userHasCard == true;
    }
    if (requiredCardStatus == 'no') {
      return userHasCard == false;
    }
    return false;
  }

  /// Filter cart products based on allowProduct rule
  /// For "Only": Only count products specified in 'products' array
  /// For "allex": Count all products EXCEPT those in 'exProducts' array
  /// For "all": Count all products
  static List<Map<String, dynamic>> filterCartProductsByCondition(
      Map<String, dynamic> condition, List<Map<String, dynamic>> cartItems) {
    String allowRule = condition['allowProduct'];
    List<String> allowedProducts = condition['products'] != null
        ? List<String>.from(condition['products'])
        : [];
    List<String> excludedProducts = condition['exProducts'] != null
        ? List<String>.from(condition['exProducts'])
        : [];

    // If rule is "all", include all items
    if (allowRule == 'all') {
      return cartItems;
    }

    // If rule is "Only", only include products in the allowed list
    if (allowRule == 'Only') {
      List<Map<String, dynamic>> filtered = [];
      for (var item in cartItems) {
        if (allowedProducts.contains(item['productName'])) {
          filtered.add(item);
        }
      }
      return filtered;
    }

    // If rule is "allex", include all products except excluded ones
    if (allowRule == 'allex') {
      List<Map<String, dynamic>> filtered = [];
      for (var item in cartItems) {
        if (!excludedProducts.contains(item['productName'])) {
          filtered.add(item);
        }
      }
      return filtered;
    }

    // Default: return all items
    return cartItems;
  }

  /// Calculate total amount and total count from cart items
  static Map<String, dynamic> calculateCartTotals(
      List<Map<String, dynamic>> cartItems) {
    double totalAmount = 0;
    int totalCount = 0;

    for (var item in cartItems) {
      totalAmount += (item['price'] as num) * (item['qty'] as num);
      totalCount += item['qty'] as int;
    }

    return {
      'amount': totalAmount,
      'count': totalCount,
    };
  }

  /// Check cart total condition based on TotalToCount rule
  static bool checkCartTotalCondition(
      Map<String, dynamic> condition, Map<String, dynamic> cartTotals) {
    String rule = condition['TotalToCount'];
    num requiredAmount = condition['cartTotal'] as num;
    int requiredCount = condition['cartCount'] as int;

    if (rule == 'both') {
      return (cartTotals['amount'] >= requiredAmount &&
          cartTotals['count'] >= requiredCount);
    }

    if (rule == 'CTotal') {
      return (cartTotals['amount'] >= requiredAmount);
    }

    if (rule == 'cCount') {
      return (cartTotals['count'] >= requiredCount);
    }

    return false;
  }

  /// Apply promotion to cart
  static Map<String, dynamic> applyPromotionToCart(
      Map<String, dynamic> promotion, Map<String, dynamic> cart) {
    num promotionAmount = promotion['amount'] as num;
    List<Map<String, dynamic>> promotionItems =
    List<Map<String, dynamic>>.from(promotion['items']);

    // Check which promotion items exist in cart
    List<Map<String, dynamic>> applicableItems = [];
    List<Map<String, dynamic>> missingItems = [];

    for (var promoItem in promotionItems) {
      bool found = false;
      for (var cartItem in cart['items']) {
        if (cartItem['productName'] == promoItem['productName']) {
          Map<String, dynamic> applicableItem =
          Map<String, dynamic>.from(promoItem);
          applicableItem.addAll({
            'cartPrice': cartItem['price'],
            'cartQty': cartItem['qty'],
          });
          applicableItems.add(applicableItem);
          found = true;
          break;
        }
      }
      if (!found) {
        missingItems.add(promoItem);
      }
    }

    // Calculate discount or promotion value
    num discountValue = promotionAmount;
    num newCartTotal = (cart['total'] as num) - discountValue;
    if (newCartTotal < 0) newCartTotal = 0;

    return {
      'success': true,
      'message': 'Promotion applied successfully',
      'promotion': {
        'amount': promotionAmount,
        'discount': discountValue,
        'items': promotionItems,
        'applicable_items': applicableItems,
        'missing_items': missingItems,
      },
      'cart': {
        'original_total': cart['total'],
        'new_total': newCartTotal,
        'saved': discountValue,
        'count': cart['count'],
        'has_card': cart['card'],
      },
    };
  }
}

