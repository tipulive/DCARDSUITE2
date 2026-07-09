
class Promotion {
  /// Applies the best applicable promotion and returns a breakdown.
  /// Returns `quick` and `long` lists, each containing reward items (`inStock`) and bonus totals.
  static Map<String, dynamic> applyBestPromotion(
      Map<String, dynamic> cart,
      List<Map<String, dynamic>> promotions,
      ) {
    final Map<String, dynamic> promotionResults = {};
    final List<Map<String, dynamic>> applicablePromotions = [];
    final List<Map<String, dynamic>> nonApplicablePromotions = [];
    final List<Map<String, dynamic>> cartItems =
    (cart['items'] as List).cast<Map<String, dynamic>>();

    for (final promotion in promotions) {
      final condition = _normalizeCondition(promotion['condition']);
      final isApplicable = checkPromotionConditions(condition, cart, cartItems);
      final promoId = promotion['id'].toString();
      final promoType = promotion['promotype'] as String;

      if (isApplicable) {
        final filteredItems = filterCartProductsByCondition(condition, cartItems);
        final cartTotals = calculateCartTotals(filteredItems);
        final bonusData = _calculateBonus(promotion, cartTotals);
        final bonus = bonusData['bonus'] as int;
        final dividend = bonusData['dividend'] as int;

        promotionResults[promoId] = {
          'applied': true,
          'promotype': promoType,
          'amount': _toNum(promotion['promotion']['amount']),
          'bonusTot': bonus,
          'dividend': dividend,
          'cartTotal': cartTotals['amount'],
          'cartCount': cartTotals['count'],
          'reason': 'All conditions met',
        };
        applicablePromotions.add(promotion);
      } else {
        final reason = getPromotionFailureReason(condition, cart, cartItems);
        promotionResults[promoId] = {
          'applied': false,
          'promotype': promoType,
          'amount': _toNum(promotion['promotion']['amount']),
          'reason': reason,
        };
        nonApplicablePromotions.add(promotion);
      }
    }

    if (applicablePromotions.isEmpty) {
      return {
        'success': false,
        'message': 'No applicable promotions found',
        'quick': [],          // consistent empty lists
        'long': [],           // consistent empty lists
        'cart': cart,
        'allPromotionsStatus': promotionResults,
        'applicablePromotions': [],
        'nonApplicablePromotions': nonApplicablePromotions,
      };
    }

    // Sort by promotion amount (highest first)
    applicablePromotions.sort(
          (a, b) => _toNum(b['promotion']['amount']).compareTo(_toNum(a['promotion']['amount'])),
    );

    return _buildPromotionBreakdown(cart, promotions, promotionResults);
  }

  /// Normalises condition fields: unifies naming, converts types, removes "none".
  static Map<String, dynamic> _normalizeCondition(Map<String, dynamic> condition) {
    final normalized = Map<String, dynamic>.from(condition);

    // Map "productRule" → "allowProduct" (supports both keys)
    final productRuleKey = normalized.keys.firstWhere(
          (k) => k.toLowerCase() == 'productrule',
      orElse: () => '',
    );
    if (productRuleKey.isNotEmpty) {
      normalized['allowProduct'] = normalized[productRuleKey];
    }

    // Normalise productRule values
    if (normalized.containsKey('allowProduct')) {
      String rule = normalized['allowProduct'].toString().toLowerCase();
      if (rule == 'only') rule = 'Only';
      if (rule == 'all') rule = 'all';
      if (rule == 'allex' || rule == 'allexcept') rule = 'allex'; // supports "allExcept"
      normalized['allowProduct'] = rule;
    } else {
      normalized['allowProduct'] = 'all';
    }

    // Normalise TotalToCount
    if (normalized.containsKey('TotalToCount')) {
      String tot = normalized['TotalToCount'].toString().toLowerCase();
      if (tot == 'ccount') normalized['TotalToCount'] = 'cCount';
      if (tot == 'ctotal') normalized['TotalToCount'] = 'CTotal';
      if (tot == 'both') normalized['TotalToCount'] = 'both';
    } else {
      normalized['TotalToCount'] = 'cCount';
    }

    // Convert string numbers to num/int
    if (normalized.containsKey('cartTotal')) {
      if (normalized['cartTotal'] is String) {
        normalized['cartTotal'] = double.parse(normalized['cartTotal'] as String);
      }
    } else {
      normalized['cartTotal'] = 0.0;
    }

    if (normalized.containsKey('cartCount')) {
      if (normalized['cartCount'] is String) {
        normalized['cartCount'] = int.parse(normalized['cartCount'] as String);
      }
    } else {
      normalized['cartCount'] = 0;
    }

    // Normalise products list (remove "none", empty strings)
    if (normalized.containsKey('products')) {
      if (normalized['products'] is String) {
        normalized['products'] = [normalized['products'] as String];
      }
      normalized['products'] = (normalized['products'] as List)
          .map((e) => e.toString().trim())
          .where((e) => e.isNotEmpty && e.toLowerCase() != 'none')
          .toList();
    } else {
      normalized['products'] = [];
    }

    // Normalise exProducts (split commas, remove "none")
    if (normalized.containsKey('exProducts')) {
      if (normalized['exProducts'] is String) {
        normalized['exProducts'] = (normalized['exProducts'] as String)
            .split(',')
            .map((s) => s.trim())
            .where((s) => s.isNotEmpty && s.toLowerCase() != 'none')
            .toList();
      } else if (normalized['exProducts'] is List) {
        normalized['exProducts'] = (normalized['exProducts'] as List)
            .expand((e) => e is String ? e.split(',').map((s) => s.trim()) : [e.toString().trim()])
            .where((s) => s.isNotEmpty && s.toLowerCase() != 'none')
            .toList();
      }
    } else {
      normalized['exProducts'] = [];
    }

    // Normalise card value
    if (normalized.containsKey('card')) {
      String card = normalized['card'].toString().toLowerCase();
      if (card == 'yes') normalized['card'] = 'yes';
      if (card == 'no') normalized['card'] = 'no';
      if (card == 'both') normalized['card'] = 'both';
    } else {
      normalized['card'] = 'both';
    }

    return normalized;
  }

  static num _toNum(dynamic value) {
    if (value is num) return value;
    if (value is String) return num.parse(value);
    return 0;
  }

  /// Calculates bonus and multiplier for quick promotions.
  /// For long promotions, dividend = 1 and bonus = promotion amount.
  static Map<String, dynamic> _calculateBonus(
      Map<String, dynamic> promotion,
      Map<String, dynamic> cartTotals,
      ) {
    if (promotion['promotype'] != 'quick') {
      return {
        'status': true,
        'bonus': _toNum(promotion['promotion']['amount']).toInt(),
        'dividend': 1,
      };
    }

    final condition = _normalizeCondition(promotion['condition']);
    final rule = condition['TotalToCount'] as String;
    final promoAmount = _toNum(promotion['promotion']['amount']);
    final requiredTotal = condition['cartTotal'] as num;
    final requiredCount = condition['cartCount'] as int;
    final actualTotal = cartTotals['amount'] as num;
    final actualCount = cartTotals['count'] as int;

    if (rule == 'both') {
      final totalFactor = actualTotal / requiredTotal;
      final countFactor = actualCount / requiredCount;
      final factor = totalFactor < countFactor ? totalFactor : countFactor;
      final multiplier = factor.floor();
      final bonus = (promoAmount * multiplier).toInt();
      return {
        'status': true,
        'type': 'both',
        'bonus': bonus,
        'dividend': multiplier,
      };
    }

    if (rule == 'CTotal') {
      final multiplier = (actualTotal / requiredTotal).floor();
      final bonus = (promoAmount * multiplier).toInt();
      return {
        'status': true,
        'type': 'CTotal',
        'bonus': bonus,
        'dividend': multiplier,
      };
    }

    if (rule == 'cCount') {
      final multiplier = (actualCount / requiredCount).floor();
      final bonus = (promoAmount * multiplier).toInt();
      return {
        'status': true,
        'type': 'cCount',
        'bonus': bonus,
        'dividend': multiplier,
      };
    }

    return {'status': false, 'bonus': 0, 'dividend': 0};
  }

  static String getPromotionFailureReason(
      Map<String, dynamic> condition,
      Map<String, dynamic> cart,
      List<Map<String, dynamic>> cartItems,
      ) {
    final cond = _normalizeCondition(condition);

    if (!checkCardCondition(cond['card'], cart['card'] as bool)) {
      return "Card condition not met: expected '${cond['card']}', actual '${cart['card']}'";
    }

    final filteredItems = filterCartProductsByCondition(cond, cartItems);
    if (filteredItems.isEmpty && cond['allowProduct'] != 'all') {
      final filterDesc = _describeFilter(cond);
      return "No eligible products in cart | $filterDesc";
    }

    final totals = calculateCartTotals(filteredItems);
    final rule = cond['TotalToCount'] as String;
    final requiredTotal = cond['cartTotal'] as num;
    final requiredCount = cond['cartCount'] as int;
    final actualTotal = totals['amount'];
    final actualCount = totals['count'];
    final filterDesc = _describeFilter(cond);

    if (rule == 'both') {
      if (actualTotal < requiredTotal && actualCount < requiredCount) {
        return "Cart total & count insufficient: amount ($actualTotal < $requiredTotal) AND count ($actualCount < $requiredCount) | $filterDesc";
      } else if (actualTotal < requiredTotal) {
        return "Cart total insufficient: amount ($actualTotal < $requiredTotal) | count ($actualCount >= $requiredCount) | $filterDesc";
      } else if (actualCount < requiredCount) {
        return "Cart count insufficient: count ($actualCount < $requiredCount) | amount ($actualTotal >= $requiredTotal) | $filterDesc";
      }
    } else if (rule == 'CTotal' && actualTotal < requiredTotal) {
      return "Cart total insufficient: amount ($actualTotal < $requiredTotal) | $filterDesc";
    } else if (rule == 'cCount' && actualCount < requiredCount) {
      return "Cart count insufficient: count ($actualCount < $requiredCount) | $filterDesc";
    }
    return "Unknown condition failure";
  }

  static String _describeFilter(Map<String, dynamic> condition) {
    final rule = condition['allowProduct'] as String;
    switch (rule) {
      case 'Only':
        final products = (condition['products'] as List).join(', ');
        return "Only products: $products";
      case 'allex':
        final excluded = (condition['exProducts'] as List).join(', ');
        return "All except: $excluded";
      default:
        return "All products";
    }
  }

  static bool checkPromotionConditions(
      Map<String, dynamic> condition,
      Map<String, dynamic> cart,
      List<Map<String, dynamic>> cartItems,
      ) {
    final cond = _normalizeCondition(condition);
    if (!checkCardCondition(cond['card'], cart['card'] as bool)) return false;

    final filteredItems = filterCartProductsByCondition(cond, cartItems);
    if (filteredItems.isEmpty && cond['allowProduct'] != 'all') return false;

    final totals = calculateCartTotals(filteredItems);
    return _checkCartTotalCondition(cond, totals);
  }

  static bool checkCardCondition(String required, bool userHasCard) {
    if (required == 'both') return true;
    if (required == 'yes') return userHasCard;
    if (required == 'no') return !userHasCard;
    return false;
  }

  static List<Map<String, dynamic>> filterCartProductsByCondition(
      Map<String, dynamic> condition,
      List<Map<String, dynamic>> cartItems,
      ) {
    final cond = _normalizeCondition(condition);
    final rule = cond['allowProduct'] as String;
    if (rule == 'all') return cartItems;

    final allowed = (cond['products'] as List).cast<String>();
    final excluded = (cond['exProducts'] as List).cast<String>();

    if (rule == 'Only') {
      return cartItems.where((item) => allowed.contains(item['productName'])).toList();
    }

    if (rule == 'allex') {
      return cartItems.where((item) => !excluded.contains(item['productName'])).toList();
    }

    return cartItems;
  }

  static Map<String, dynamic> calculateCartTotals(List<Map<String, dynamic>> items) {
    double total = 0;
    int count = 0;
    for (final item in items) {
      total += (item['price'] as num) * (item['qty'] as int);
      count += item['qty'] as int;
    }
    return {'amount': total, 'count': count};
  }

  static bool _checkCartTotalCondition(
      Map<String, dynamic> condition,
      Map<String, dynamic> totals,
      ) {
    final cond = _normalizeCondition(condition);
    final rule = cond['TotalToCount'] as String;
    final requiredTotal = cond['cartTotal'] as num;
    final requiredCount = cond['cartCount'] as int;

    if (rule == 'both') {
      return totals['amount'] >= requiredTotal && totals['count'] >= requiredCount;
    }
    if (rule == 'CTotal') return totals['amount'] >= requiredTotal;
    if (rule == 'cCount') return totals['count'] >= requiredCount;
    return false;
  }

  static Map<String, dynamic> _buildPromotionBreakdown(
      Map<String, dynamic> cart,
      List<Map<String, dynamic>> promotions,
      Map<String, dynamic> promotionResults,
      ) {
    final List<Map<String, dynamic>> quickEntries = [];
    final List<Map<String, dynamic>> longEntries = [];

    for (final promo in promotions) {
      final id = promo['id'].toString();
      final result = promotionResults[id];
      if (result == null || result['applied'] != true) continue;

      final promoType = promo['promotype'] as String;
      final condition = _normalizeCondition(promo['condition']);
      final bonusTotal = result['bonusTot'] as int;
      final dividend = result['dividend'] as int;
      final cartTotal = (result['cartTotal'] as num).toDouble();
      final cartCount = result['cartCount'] as int;
      final rule = condition['TotalToCount'] as String;
      final inputPoint = rule == 'cCount' ? cartCount : cartTotal;

      final multiplier = (promoType == 'quick') ? dividend : 1;

      // Extract reward items (the products the customer will receive)
      final promoItemsRaw = promo['promotion']['items']['inStock'] as List;
      final rewardItems = promoItemsRaw.map((item) {
        return {
          'productName': item['productName'] as String,
          'qty': _toNum(item['qty']).toInt(),
        };
      }).toList();

      // Rewards are given in full – no cart stock check
      final rewards = _buildRewardItems(rewardItems, multiplier);

      final entry = {
        'id': id,
        'inStock': rewards,
        'BonusTotal': bonusTotal,
        'condition': condition,
        'inputCount': cartCount,
        'inputTotal': cartTotal,
        'inputPoint': inputPoint,
      };

      if (promoType == 'quick') {
        quickEntries.add(entry);
      } else {
        longEntries.add(entry);
      }
    }

    return {'success':true,'quick': quickEntries, 'long': longEntries};
  }

  /// Returns the full list of reward items multiplied by the multiplier.
  static List<Map<String, dynamic>> _buildRewardItems(
      List<Map<String, dynamic>> rewardItems,
      int multiplier,
      ) {
    final Map<String, int> rewardQty = {};
    for (final item in rewardItems) {
      final name = item['productName'] as String;
      final qty = (item['qty'] as int) * multiplier;
      rewardQty[name] = (rewardQty[name] ?? 0) + qty;
    }

    final List<Map<String, dynamic>> rewards = [];
    for (final entry in rewardQty.entries) {
      rewards.add({'productName': entry.key, 'qtyBonus': entry.value});
    }
    return rewards;
  }

  /// Formats the promotion result as human‑readable text.
  static String formatResultAsText(Map<String, dynamic> result) {
    final buffer = StringBuffer();
    // If the result has a success flag and it's false, show the message
    if (result.containsKey('success') && result['success'] == false) {
      buffer.writeln('😞 ${result['message']}');
      buffer.writeln('   Check your card status or add more qualifying products.');
      return buffer.toString();
    }

    final quickList = result['quick'] as List<Map<String, dynamic>>;
    final longList = result['long'] as List<Map<String, dynamic>>;

    if (quickList.isNotEmpty) {
      buffer.writeln('🎁 QUICK PROMOTIONS (multiplied by your cart):\n');
      for (final promo in quickList) {
        buffer.writeln('📌 Promotion ID: ${promo['id']}');
        buffer.writeln('   💰 Bonus total: ${promo['BonusTotal']} RWF');
        buffer.writeln('   📊 Based on: ${_describeTotalToCount(promo['condition']['TotalToCount'])}');
        buffer.writeln('   🛒 Your qualifying cart: ${promo['inputCount']} items / ${promo['inputTotal']} RWF');

        if (promo['inStock'].isNotEmpty) {
          buffer.writeln('   ✅ REWARDS (you get these for free):');
          for (final item in promo['inStock']) {
            buffer.writeln('      - ${item['productName']} x ${item['qtyBonus']}');
          }
        } else {
          buffer.writeln('   ⚠️ No reward items defined for this promotion.');
        }
        buffer.writeln();
      }
    }

    if (longList.isNotEmpty) {
      buffer.writeln('🎁 LONG PROMOTIONS (single application):\n');
      for (final promo in longList) {
        buffer.writeln('📌 Promotion ID: ${promo['id']}');
        buffer.writeln('   💰 Bonus total: ${promo['BonusTotal']} RWF');
        buffer.writeln('   📊 Based on: ${_describeTotalToCount(promo['condition']['TotalToCount'])}');
        buffer.writeln('   🛒 Your qualifying cart: ${promo['inputCount']} items / ${promo['inputTotal']} RWF');

        if (promo['inStock'].isNotEmpty) {
          buffer.writeln('   ✅ REWARDS (you get these for free):');
          for (final item in promo['inStock']) {
            buffer.writeln('      - ${item['productName']} x ${item['qtyBonus']}');
          }
        } else {
          buffer.writeln('   ⚠️ No reward items defined for this promotion.');
        }
        buffer.writeln();
      }
    }

    if (quickList.isEmpty && longList.isEmpty) {
      buffer.writeln('😞 No promotions are applicable to your current cart.');
      buffer.writeln('   Check your card status or add more qualifying products.');
    }

    return buffer.toString();
  }

  static String _describeTotalToCount(String rule) {
    switch (rule) {
      case 'cCount': return 'item quantity';
      case 'CTotal': return 'cart total amount';
      case 'both': return 'both quantity and amount';
      default: return rule;
    }
  }
}