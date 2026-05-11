


class Promotion {
  /// Apply best applicable promotion from multiple promotions
  static Map<String, dynamic> applyBestPromotion(
      Map<String, dynamic> cart, List<Map<String, dynamic>> promotions) {

    List<Map<String, dynamic>> applicablePromotions = [];
    List<Map<String, dynamic>> nonApplicablePromotions = [];
    Map<String, dynamic> promotionResults = {};

    // Check each promotion for applicability
    for (var promotion in promotions) {
      bool conditionsMet = checkPromotionConditions(
          promotion['condition'], promotion['promotion']['items']["inStock"], cart);

      String promotionId = promotion['id'].toString();
      String promotionType = promotion['promotype'];

      if (conditionsMet) {
        // Filter cart items based on allowProduct rule
        List<Map<String, dynamic>> filteredCartItems =
        filterCartProductsByCondition(promotion['condition'], cart['items']);

        // Calculate totals from filtered cart items
        Map<String, dynamic> cartTotals = calculateCartTotals(filteredCartItems);
        applicablePromotions.add(promotion);

        /*double minValue = (cartTotals['amount'] / promotion['condition']["cartTotal"]) < (cartTotals['count'] /promotion['condition']["cartCount"]) ? cartTotals['amount'] / promotion['condition']["cartTotal"] : cartTotals['count'] / promotion['condition']["cartCount"];
        int bonus = (promotion['promotion']['amount'] * minValue).floor();*/
        // int bonus=((cartTotals['amount'] / promotion['condition']["cartTotal"]) * promotion['promotion']['amount']).floor();
        var result =calculateBonus(promotion,cartTotals);
        int bonus=result["bonus"];
        promotionResults[promotionId] = {
          'applied': true,

          'promotype': promotionType,

          'amount': promotion['promotion']['amount'],

          'bonusTot':bonus,
          "dividend":result["dividend"],
          'cartTotal':cartTotals['amount'],
          'cartCount':cartTotals['count'],
          //"proAm":promotion['condition'],
          //"proTotal":cartTotals,
          'reason': 'All conditions met'
        };
      } else {
        nonApplicablePromotions.add(promotion);

        // Get detailed reason why promotion wasn't applied
        String reason = getPromotionFailureReason(promotion['condition'], cart);
        promotionResults[promotionId] = {
          'applied': false,
          'promotype': promotionType,
          'amount': promotion['promotion']['amount'],
          'reason': reason
        };
      }
    }

    if (applicablePromotions.isEmpty) {
      return {
        'success': false,
        'message': 'No applicable promotions found',
        'promotion': null,
        'cart': cart,
        'allPromotionsStatus': promotionResults,
        'applicablePromotions': [],
        'nonApplicablePromotions': nonApplicablePromotions
      };
    }

    // Find the best promotion (highest amount)
    applicablePromotions.sort((a, b) {
      return b['promotion']['amount'].compareTo(a['promotion']['amount']);
    });

    Map<String, dynamic> bestPromotion = applicablePromotions[0];
    String bestPromotionId = bestPromotion['id'].toString();

    // Apply the best promotion
    /*Map<String, dynamic> result = applyPromotionToCart(
        bestPromotion['promotion'], cart,promotions);
    result['promotion']['id'] = bestPromotion['id'];
    result['promotion']['promotype'] = bestPromotion['promotype'];

    // Add detailed promotion status
    result['allPromotionsStatus'] = promotionResults;
    result['applicablePromotions'] = applicablePromotions.map((p) => {
      'id': p['id'],
      'promotype': p['promotype'],
      'amount': p['promotion']['amount']
    }).toList();
    result['nonApplicablePromotions'] = nonApplicablePromotions.map((p) => {
      'id': p['id'],
      'promotype': p['promotype'],
      'amount': p['promotion']['amount'],
      'reason': promotionResults[p['id'].toString()]['reason']
    }).toList();
    result['bestPromotionId'] = bestPromotionId;*/

    return  formResult(cart, promotions,promotionResults);
  }
  static Map<String, dynamic> calculateBonus(
      Map<String, dynamic> promotion,
      Map<String, dynamic> cartTotals,
      ) {

    if (promotion['promotype'] == "quick") {

      if (promotion['condition']["TotalToCount"] == "both") {

        double totalFactor =
            cartTotals['amount'] / promotion['condition']["cartTotal"];

        double countFactor =
            cartTotals['count'] / promotion['condition']["cartCount"];

        double factor = totalFactor.clamp(0, countFactor);

        int bonus =
        (factor).floor();
        //print(bonus);
        // bonus=(promotion['condition']["cartTotal"]/cartTotals['amount'])



        return {
          "status": true,
          "type": "both",
          "bonus": bonus,
          "factor": factor,
          "dividend":bonus
        };
      }

      if (promotion['condition']["TotalToCount"] == "CTotal") {

        print(cartTotals);
        int bonus = (
            (promotion['promotion']['amount'] /
                promotion['condition']["cartTotal"]) *
                cartTotals['amount']
        ).floor();
        int divident = (
            (cartTotals['amount'] /
                promotion['condition']["cartTotal"])).floor();

        return {
          "status": true,
          "type": "CTotal",
          "bonus": bonus,
          "dividend":divident
        };
      }

      if (promotion['condition']["TotalToCount"] == "cCount") {

        int bonus = (
            (promotion['promotion']['amount'] /
                promotion['condition']["cartCount"]) *
                cartTotals['count']
        ).floor();
        int dividen=(
            (cartTotals['count'] /
                promotion['condition']["cartCount"])

        ).floor();

        return {
          "status": true,
          "type": "cCount",
          "bonus": bonus,
          "dividend":dividen
        };
      }
    }

    return {
      "status": false,
      "bonus": 0,
    };
  }
  /// Get detailed reason why promotion conditions were not met
  static String getPromotionFailureReason(
      Map<String, dynamic> condition, Map<String, dynamic> cart) {

    // Check card condition
    if (!checkCardCondition(condition['card'], cart['card'])) {
      String expectedCard = condition['card'];
      bool actualCard = cart['card'];
      return "Card condition not met: Expected card='$expectedCard', Actual card='$actualCard'";
    }

    // Filter cart items based on allowProduct rule
    List<Map<String, dynamic>> filteredCartItems =
    filterCartProductsByCondition(condition, cart['items']);

    // Calculate totals from filtered cart items
    Map<String, dynamic> cartTotals = calculateCartTotals(filteredCartItems);

    // Check cart total/count conditions
    String rule = condition['TotalToCount'];
    num requiredAmount = condition['cartTotal'] as num;
    int requiredCount = condition['cartCount'] as int;
    num actualAmount = cartTotals['amount'];
    int actualCount = cartTotals['count'];

    String filterRule = condition['allowProduct'];
    String filterDescription = '';

    switch(filterRule) {
      case 'Only':
        List<String> allowedProducts = List<String>.from(condition['products']);
        filterDescription = "Only products: ${allowedProducts.join(', ')}";
        break;
      case 'allex':
        List<String> excludedProducts = List<String>.from(condition['exProducts']);
        filterDescription = "All except products: ${excludedProducts.join(', ')}";
        break;
      case 'all':
        filterDescription = "All products";
        break;
    }

    if (rule == 'both') {
      if (actualAmount < requiredAmount && actualCount < requiredCount) {
        return "Cart total and count insufficient: Amount (${actualAmount.toStringAsFixed(2)} < $requiredAmount) AND Count ($actualCount < $requiredCount) | Filter: $filterDescription";
      } else if (actualAmount < requiredAmount) {
        return "Cart total insufficient: Amount (${actualAmount.toStringAsFixed(2)} < $requiredAmount) | Count ($actualCount >= $requiredCount) | Filter: $filterDescription";
      } else if (actualCount < requiredCount) {
        return "Cart count insufficient: Count ($actualCount < $requiredCount) | Amount (${actualAmount.toStringAsFixed(2)} >= $requiredAmount) | Filter: $filterDescription";
      }
    } else if (rule == 'CTotal') {
      if (actualAmount < requiredAmount) {
        return "Cart total insufficient: Amount (${actualAmount.toStringAsFixed(2)} < $requiredAmount) | Filter: $filterDescription";
      }
    } else if (rule == 'cCount') {
      if (actualCount < requiredCount) {
        return "Cart count insufficient: Count ($actualCount < $requiredCount) | Filter: $filterDescription";
      }
    }

    return "Unknown condition failure";
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
  static List<Map<String, dynamic>> filterCartProductsByCondition(
      Map<String, dynamic> condition, List<Map<String, dynamic>> cartItems) {
    String allowRule = condition['allowProduct'];
    List<String> allowedProducts = condition['products'] != null
        ? List<String>.from(condition['products'])
        : [];
    List<String> excludedProducts = condition['exProducts'] != null
        ? List<String>.from(condition['exProducts'])
        : [];

    if (allowRule == 'all') {
      return cartItems;
    }

    if (allowRule == 'Only') {
      List<Map<String, dynamic>> filtered = [];
      for (var item in cartItems) {
        if (allowedProducts.contains(item['productName'])) {
          filtered.add(item);
        }
      }
      return filtered;
    }

    if (allowRule == 'allex') {
      List<Map<String, dynamic>> filtered = [];
      for (var item in cartItems) {
        if (!excludedProducts.contains(item['productName'])) {
          filtered.add(item);
        }
      }
      return filtered;
    }

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
      Map<String, dynamic> promotion, Map<String, dynamic> cart,List<Map<String, dynamic>> promotionsData) {
    num promotionAmount = promotion['amount'] as num;
    List<Map<String, dynamic>> promotionItems =
    List<Map<String, dynamic>>.from(promotion['items']["inStock"]);

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

    num discountValue = promotionAmount;
    num newCartTotal = (cart['total'] as num) - discountValue;
    if (newCartTotal < 0) newCartTotal = 0;

    return {
      'success': true,
      'message': 'Promotion applied successfully',
      'promotion': {
       //'data':formResult(cart, promotionsData),
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
   // return formResult(cart, promotionsData);
  }


  /// Complete function that applies best promotion and returns formatted result
  static Map<String, dynamic> getBestPromotionFormatted(
      Map<String, dynamic> cart, List<Map<String, dynamic>> promotions) {
    Map<String, dynamic> result = applyBestPromotion(cart, promotions);
    return result;
    //return formatPromotionResult(result);
  }

  static Map<String, dynamic> formResult(
      Map<String, dynamic> cart, List<Map<String, dynamic>> promotions,Map<String, dynamic> promotionResults) {
    // Get actual cart total (you can modify this value)
   // int actualCartTotal = 1500; // Example: customer's cart total

    // Separate quick and long promotions
    List<Map<String, dynamic>> quickPromos = [];
    List<Map<String, dynamic>> longPromos = [];
//print(promotionResults["1bv"]["applied"]);
    //print(promotionResults);

    for (var promo in promotions) {

      if(promotionResults[promo["id"]]["applied"])
      {
        if (promo["promotype"] == "quick") {
          quickPromos.add(promo);
        } else if (promo["promotype"] == "long") {
          promo["inputCount"]=promotionResults[promo["id"]]["cartCount"];
          promo["inputTotal"]=promotionResults[promo["id"]]["cartTotal"];
          promo["inputPoint"]=(promo["condition"]["TotalToCount"]=="cCount")?promotionResults[promo["id"]]["cartCount"]:promotionResults[promo["id"]]["cartTotal"];
          longPromos.add(promo);
        }
      }

    }

    // Process QUICK promotions (apply multiplier based on cartTotal)
    Map<String, int> quickQtyMap = {};

    num quickBonusTotal = 0;

    for (var promo in quickPromos) {
      //int conditionCartTotal = promo["condition"]["cartTotal"] as int;


      // Calculate how many times to apply this promotion
      int multiplier = promotionResults[promo["id"]]["dividend"].floor();

      if (multiplier > 0) {
        // Add bonus amount multiplied
       // quickBonusTotal += (promo["promotion"]["amount"] as int) * multiplier;
       // quickBonusTotal +=promotionResults[promo["id"]]["bonusTot"];
        quickBonusTotal +=(promotionResults[promo["id"]]["dividend"]*promo["promotion"]['amount']).floor();
        // Add items with multiplier
        var inStockList = promo["promotion"]["items"]["inStock"] as List;
        for (var item in inStockList) {
          String name = item["productName"] as String;
          int qty = (item["qty"] as int) * multiplier;
          quickQtyMap[name] = (quickQtyMap[name] ?? 0) + qty;
        }
      }
    }

    List<Map<String, dynamic>> quickInStock = [];
    quickQtyMap.forEach((productName, qtyBonus) {
      quickInStock.add({
        "productName": productName,
        "qtyBonus": qtyBonus,
      });
    });

    Map<String, dynamic> quickResult = {
      "inStock": quickInStock,
      "BonusTotal": quickBonusTotal,
    };

    // Process LONG promotions (keep separate, no multiplier)
    List<Map<String, dynamic>> longResultList = [];

    for (var promo in longPromos) {
      Map<String, int> longQtyMap = {};
      var inStockList = promo["promotion"]["items"]["inStock"] as List;

      for (var item in inStockList) {
        String name = item["productName"] as String;
        int qty = item["qty"] as int;
        longQtyMap[name] = (longQtyMap[name] ?? 0) + qty;
      }

      List<Map<String, dynamic>> longInStock = [];
      longQtyMap.forEach((productName, qtyBonus) {
        longInStock.add({
          "productName": productName,
          "qtyBonus": qtyBonus,
        });
      });

      longResultList.add({
        "id": promo["id"],
        "inStock": longInStock,
        "BonusTotal": promo["promotion"]["amount"] as int,
        "condition": promo["condition"],
        "inputCount": promo["inputCount"]??0,
        "inputTotal":promo["inputTotal"]??0,
        "inputPoint":promo["inputPoint"]??0,//to be submitted in database
      });
    }

    // Final result
    Map<String, dynamic> result = {
      "quick": quickResult,
      "long": longResultList,
    };
    return result;
    //return formatPromotionResult(result);
  }
}