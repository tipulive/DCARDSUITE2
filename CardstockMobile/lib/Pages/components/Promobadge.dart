import 'package:flutter/material.dart';

// ==========================================
// 1. DATA MODELS
// ==========================================

class PromoData {
  final List<PromoItem> quick;
  final List<PromoItem> longPromos;

  PromoData({required this.quick, required this.longPromos});

  factory PromoData.fromJson(Map<String, dynamic> json) {
    return PromoData(
      quick: (json['quick'] as List<dynamic>?)
          ?.map((item) => PromoItem.fromJson(item))
          .toList() ??
          [],
      longPromos: (json['long'] as List<dynamic>?)
          ?.map((item) => PromoItem.fromJson(item))
          .toList() ??
          [],
    );
  }

  /// Groups products by promoId along with Promo Name, BonusTotal & Type
  List<PromoGroup> getGroupedPromos() {
    final List<PromoGroup> groups = [];

    for (var promo in quick) {
      if (promo.inStock.isNotEmpty) {
        groups.add(
          PromoGroup(
            promoId: promo.id,
            promoName: promo.name,
            bonusTotal: promo.bonusTotal,
            typeTag: 'Quick Promo',
            products: promo.inStock,
          ),
        );
      }
    }

    for (var promo in longPromos) {
      if (promo.inStock.isNotEmpty) {
        groups.add(
          PromoGroup(
            promoId: promo.id,
            promoName: promo.name,
            bonusTotal: promo.bonusTotal,
            typeTag: 'Long Promo',
            products: promo.inStock,
          ),
        );
      }
    }

    return groups;
  }

  int get totalProductCount {
    int count = 0;
    for (var p in quick) {
      count += p.inStock.length;
    }
    for (var p in longPromos) {
      count += p.inStock.length;
    }
    return count;
  }
}

class PromoItem {
  final String id;
  final String name; // Added promo name
  final List<InStockProduct> inStock;
  final num bonusTotal;

  PromoItem({
    required this.id,
    required this.name,
    required this.inStock,
    required this.bonusTotal,
  });

  factory PromoItem.fromJson(Map<String, dynamic> json) {
    final idStr = json['id'] ?? '';
    return PromoItem(
      id: idStr,
      name: json['name'] ?? idStr, // Fallback to ID if name is missing
      bonusTotal: json['BonusTotal'] ?? 0,
      inStock: (json['inStock'] as List<dynamic>?)
          ?.map((item) => InStockProduct.fromJson(item))
          .toList() ??
          [],
    );
  }
}

class InStockProduct {
  final String productName;
  final int qtyBonus;

  InStockProduct({
    required this.productName,
    required this.qtyBonus,
  });

  factory InStockProduct.fromJson(Map<String, dynamic> json) {
    return InStockProduct(
      productName: json['productName'] ?? '',
      qtyBonus: json['qtyBonus'] ?? 0,
    );
  }
}

class PromoGroup {
  final String promoId;
  final String promoName; // Added promo name
  final num bonusTotal;
  final String typeTag;
  final List<InStockProduct> products;

  const PromoGroup({
    required this.promoId,
    required this.promoName,
    required this.bonusTotal,
    required this.typeTag,
    required this.products,
  });
}

// ==========================================
// 2. DYNAMIC DRAGGABLE & STRETCHABLE BADGE WIDGET
// ==========================================

class DynamicPromoBadge extends StatefulWidget {
  final Map<String, dynamic> promoJson;
  final IconData icon;
  final String title;
  final Color backgroundColor;
  final double collapsedWidth;
  final double expandedWidth;
  final double height;

  const DynamicPromoBadge({
    super.key,
    required this.promoJson,
    this.icon = Icons.card_giftcard_rounded,
    this.title = 'Active Promos',
    this.backgroundColor = const Color(0xFF6200EE),
    this.collapsedWidth = 56.0,
    this.expandedWidth = 220.0,
    this.height = 56.0,
  });

  @override
  State<DynamicPromoBadge> createState() => _DynamicPromoBadgeState();
}

class _DynamicPromoBadgeState extends State<DynamicPromoBadge> {
  late final ValueNotifier<Offset?> _positionNotifier;
  late PromoData _parsedPromoData;
  late List<PromoGroup> _promoGroups;
  bool _isExpanded = false;

  @override
  void initState() {
    super.initState();
    _positionNotifier = ValueNotifier<Offset?>(null);
    _updatePromoProducts();
  }

  @override
  void didUpdateWidget(covariant DynamicPromoBadge oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (oldWidget.promoJson != widget.promoJson) {
      _updatePromoProducts();
    }
  }

  void _updatePromoProducts() {
    _parsedPromoData = PromoData.fromJson(widget.promoJson);
    _promoGroups = _parsedPromoData.getGroupedPromos();
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (_positionNotifier.value == null) {
      final screenSize = MediaQuery.of(context).size;
      _positionNotifier.value = Offset(
        screenSize.width - widget.collapsedWidth - 16,
        screenSize.height * 0.45,
      );
    }
  }

  @override
  void dispose() {
    _positionNotifier.dispose();
    super.dispose();
  }

  void _handleBadgeTap(BuildContext context) {
    final screenSize = MediaQuery.of(context).size;
    final currentPos = _positionNotifier.value!;

    if (currentPos.dx + widget.expandedWidth > screenSize.width) {
      _positionNotifier.value = Offset(
        screenSize.width - widget.expandedWidth - 8,
        currentPos.dy,
      );
    }

    setState(() {
      _isExpanded = true;
    });

    _openProductsBottomSheet(context);
  }

  void _collapseBadge() {
    setState(() {
      _isExpanded = false;
    });
  }

  void _openProductsBottomSheet(BuildContext context) {
    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.transparent,
      isScrollControlled: true,
      builder: (context) => _FreeProductsBottomSheet(
        groups: _promoGroups,
        accentColor: widget.backgroundColor,
      ),
    ).then((_) {
      if (mounted) {
        _collapseBadge();
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final screenSize = MediaQuery.of(context).size;
    final topPadding = MediaQuery.of(context).padding.top;
    final bottomPadding = MediaQuery.of(context).padding.bottom;
    final currentWidth =
    _isExpanded ? widget.expandedWidth : widget.collapsedWidth;

    return ValueListenableBuilder<Offset?>(
      valueListenable: _positionNotifier,
      builder: (context, position, child) {
        final currentPos = position ??
            Offset(screenSize.width - widget.collapsedWidth - 16, 200);

        return Positioned(
          left: currentPos.dx,
          top: currentPos.dy,
          child: GestureDetector(
            onPanUpdate: (details) {
              final newX = (currentPos.dx + details.delta.dx).clamp(
                0.0,
                screenSize.width - currentWidth,
              );
              final newY = (currentPos.dy + details.delta.dy).clamp(
                topPadding,
                screenSize.height - widget.height - bottomPadding,
              );

              _positionNotifier.value = Offset(newX, newY);
            },
            onTap: () => _handleBadgeTap(context),
            child: AnimatedContainer(
              duration: const Duration(milliseconds: 300),
              curve: Curves.easeOutBack,
              width: currentWidth,
              height: widget.height,
              clipBehavior: Clip.hardEdge,
              decoration: BoxDecoration(
                color: widget.backgroundColor,
                borderRadius: BorderRadius.circular(widget.height / 2),
                boxShadow: [
                  BoxShadow(
                    color: widget.backgroundColor.withOpacity(0.35),
                    blurRadius: 12,
                    offset: const Offset(0, 5),
                  ),
                ],
              ),
              child: Stack(
                children: [
                  // Icon Pinned Left
                  Positioned(
                    left: 0,
                    top: 0,
                    width: widget.collapsedWidth,
                    height: widget.height,
                    child: Center(
                      child: Icon(
                        widget.icon,
                        color: Colors.white,
                        size: 26,
                      ),
                    ),
                  ),

                  // Content Canvas
                  Positioned(
                    left: widget.collapsedWidth,
                    top: 0,
                    width: widget.expandedWidth - widget.collapsedWidth,
                    height: widget.height,
                    child: AnimatedOpacity(
                      duration:
                      Duration(milliseconds: _isExpanded ? 200 : 80),
                      opacity: _isExpanded ? 1.0 : 0.0,
                      child: Padding(
                        padding: const EdgeInsets.only(right: 16.0),
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              widget.title,
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                              style: const TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.bold,
                                fontSize: 13,
                              ),
                            ),
                            const SizedBox(height: 1),
                            Text(
                              '${_parsedPromoData.totalProductCount} Rewards Available',
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                              style: TextStyle(
                                color: Colors.white.withOpacity(0.85),
                                fontSize: 11,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}

// ==========================================
// 3. GROUPED BOTTOM SHEET FOR DYNAMIC PRODUCTS
// ==========================================

class _FreeProductsBottomSheet extends StatelessWidget {
  final List<PromoGroup> groups;
  final Color accentColor;

  const _FreeProductsBottomSheet({
    required this.groups,
    required this.accentColor,
  });

  @override
  Widget build(BuildContext context) {
    final mediaQuery = MediaQuery.of(context);

    return Container(
      constraints: BoxConstraints(
        maxHeight: mediaQuery.size.height * 0.8,
      ),
      decoration: const BoxDecoration(
        color: Color(0xFFF8F9FA),
        borderRadius: BorderRadius.vertical(top: Radius.circular(28)),
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          // Drag Handle
          const SizedBox(height: 12),
          Container(
            width: 44,
            height: 5,
            decoration: BoxDecoration(
              color: Colors.grey.shade300,
              borderRadius: BorderRadius.circular(2.5),
            ),
          ),

          // Header Bar
          Padding(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 12),
            child: Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: accentColor.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Icon(Icons.card_giftcard_rounded, color: accentColor, size: 22),
                ),
                const SizedBox(width: 12),
                const Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Available Rewards',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF1F2937),
                        ),
                      ),
                      Text(
                        'Available Promotions',
                        style: TextStyle(
                          fontSize: 12,
                          color: Color(0xFF6B7280),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          const Divider(height: 1),

          // Content List
          if (groups.isEmpty)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 40.0),
              child: Center(
                child: Text(
                  'No promo products available.',
                  style: TextStyle(color: Colors.grey),
                ),
              ),
            )
          else
            Flexible(
              child: ListView.separated(
                padding: const EdgeInsets.all(16),
                shrinkWrap: true,
                itemCount: groups.length,
                separatorBuilder: (context, index) => const SizedBox(height: 16),
                itemBuilder: (context, index) {
                  final group = groups[index];
                  final isQuick = group.typeTag.contains('Quick');

                  return Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(color: Colors.grey.shade200),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.03),
                          blurRadius: 8,
                          offset: const Offset(0, 2),
                        ),
                      ],
                    ),
                    clipBehavior: Clip.antiAlias,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // --- PROMO GROUP HEADER DISPLAY (TOP) ---
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 14,
                            vertical: 10,
                          ),
                          decoration: BoxDecoration(
                            color: accentColor.withOpacity(0.05),
                            border: Border(
                              bottom: BorderSide(color: Colors.grey.shade200),
                            ),
                          ),
                          child: Row(
                            children: [
                              // Promo Tag Badge
                              Container(
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 8,
                                  vertical: 4,
                                ),
                                decoration: BoxDecoration(
                                  color: isQuick
                                      ? Colors.amber.shade100
                                      : Colors.blue.shade100,
                                  borderRadius: BorderRadius.circular(6),
                                ),
                                child: Text(
                                  group.typeTag.toUpperCase(),
                                  style: TextStyle(
                                    fontSize: 10,
                                    fontWeight: FontWeight.w800,
                                    color: isQuick
                                        ? Colors.amber.shade900
                                        : Colors.blue.shade900,
                                  ),
                                ),
                              ),
                              const SizedBox(width: 10),

                              // Promo Name & ID Text Column
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      group.promoName,
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                      style: const TextStyle(
                                        fontSize: 14,
                                        fontWeight: FontWeight.bold,
                                        color: Color(0xFF111827),
                                      ),
                                    ),
                                    Text(
                                      'ID: ${group.promoId}',
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                      style: TextStyle(
                                        fontSize: 11,
                                        color: Colors.grey.shade600,
                                      ),
                                    ),
                                  ],
                                ),
                              ),

                              // Bonus Total Badge Top Right
                              Container(
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 10,
                                  vertical: 4,
                                ),
                                decoration: BoxDecoration(
                                  color: accentColor,
                                  borderRadius: BorderRadius.circular(20),
                                ),
                                child: Row(
                                  mainAxisSize: MainAxisSize.min,
                                  children: [
                                    const Icon(
                                      Icons.stars_rounded,
                                      size: 13,
                                      color: Colors.white,
                                    ),
                                    const SizedBox(width: 4),
                                    Text(
                                      'Bonus: ${group.bonusTotal}',
                                      style: const TextStyle(
                                        color: Colors.white,
                                        fontWeight: FontWeight.bold,
                                        fontSize: 11,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                        ),

                        // --- GROUP PRODUCTS LIST ---
                        ListView.separated(
                          physics: const NeverScrollableScrollPhysics(),
                          shrinkWrap: true,
                          padding: EdgeInsets.zero,
                          itemCount: group.products.length,
                          separatorBuilder: (context, idx) =>
                              Divider(height: 1, color: Colors.grey.shade100),
                          itemBuilder: (context, pIdx) {
                            final product = group.products[pIdx];

                            return ListTile(
                              contentPadding: const EdgeInsets.symmetric(
                                horizontal: 16,
                                vertical: 4,
                              ),
                              leading: CircleAvatar(
                                radius: 18,
                                backgroundColor: accentColor.withOpacity(0.08),
                                child: Icon(
                                  Icons.card_giftcard_rounded,
                                  color: accentColor,
                                  size: 18,
                                ),
                              ),
                              title: Text(
                                product.productName.toUpperCase(),
                                style: const TextStyle(
                                  fontWeight: FontWeight.w700,
                                  fontSize: 14,
                                  color: Color(0xFF1F2937),
                                ),
                              ),
                              subtitle: Padding(
                                padding: const EdgeInsets.only(top: 2.0),
                                child: Row(
                                  children: [
                                    Container(
                                      padding: const EdgeInsets.symmetric(
                                        horizontal: 6,
                                        vertical: 2,
                                      ),
                                      decoration: BoxDecoration(
                                        color: Colors.grey.shade100,
                                        borderRadius: BorderRadius.circular(4),
                                      ),
                                      child: Text(
                                        'Qty: ${product.qtyBonus}',
                                        style: const TextStyle(
                                          fontSize: 11,
                                          fontWeight: FontWeight.bold,
                                          color: Color(0xFF4B5563),
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ),

                            );
                          },
                        ),
                      ],
                    ),
                  );
                },
              ),
            ),
          SizedBox(height: mediaQuery.padding.bottom + 8),
        ],
      ),
    );
  }
}