import 'dart:ui' as ui;

import 'package:flutter/material.dart';

/// A product to display inside the promo badge.
class PromoProduct {
  final String id;
  final IconData icon;
  final String name;
  final String oldPrice;
  final String label; // e.g. "FREE"

  const PromoProduct({
    required this.id,
    required this.icon,
    required this.name,
    required this.oldPrice,
    this.label = 'FREE',
  });
}

/// A floating, expandable promo badge that shows a list of free products.
/// Tapping the badge toggles expansion; claim buttons work independently.
class PromoBadge extends StatefulWidget {
  final List<PromoProduct> products;
  final void Function(String id)? onClaim;
  final VoidCallback? onClaimAll;
  final Gradient backgroundGradient;
  final double collapsedWidth;
  final double collapsedHeight;
  final double expandedWidth;
  final double expandedHeight;
  final Duration animationDuration;
  final Curve animationCurve;
  final bool autoExpand;

  const PromoBadge({
    super.key,
    required this.products,
    this.onClaim,
    this.onClaimAll,
    this.backgroundGradient = const LinearGradient(
      colors: [Color(0xFFF97316), Color(0xFFDC2626)],
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
    ),
    this.collapsedWidth = 54.0,
    this.collapsedHeight = 54.0,
    this.expandedWidth = 320.0,
    this.expandedHeight = 260.0,
    this.animationDuration = const Duration(milliseconds: 550),
    this.animationCurve = Curves.easeOutBack,
    this.autoExpand = true,
  });

  @override
  State<PromoBadge> createState() => _PromoBadgeState();
}

class _PromoBadgeState extends State<PromoBadge>
    with SingleTickerProviderStateMixin {
  bool _expanded = false;
  final Map<String, bool> _claimed = {};

  late AnimationController _animationController;

  @override
  void initState() {
    super.initState();
    _animationController = AnimationController(
      vsync: this,
      duration: widget.animationDuration,
    );

    for (var product in widget.products) {
      _claimed[product.id] = false;
    }

    if (widget.autoExpand) {
      Future.delayed(const Duration(milliseconds: 800), () {
        if (mounted) {
          setState(() {
            _expanded = true;
            _animationController.forward();
          });
        }
      });
    }
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  void _toggleExpanded() {
    setState(() {
      _expanded = !_expanded;
      if (_expanded) {
        _animationController.forward();
      } else {
        _animationController.reverse();
      }
    });
  }

  void _handleClaim(String id) {
    if (_claimed[id] == true) return;
    setState(() {
      _claimed[id] = true;
    });
    widget.onClaim?.call(id);

    Future.delayed(const Duration(milliseconds: 2500), () {
      if (mounted) {
        setState(() {
          _claimed[id] = false;
        });
      }
    });
  }

  void _handleClaimAll() {
    bool anyUnclaimed = widget.products.any((p) => _claimed[p.id] == false);
    if (!anyUnclaimed) return;

    for (var product in widget.products) {
      _claimed[product.id] = true;
    }
    setState(() {});
    widget.onClaimAll?.call();

    Future.delayed(const Duration(milliseconds: 3000), () {
      if (mounted) {
        for (var product in widget.products) {
          _claimed[product.id] = false;
        }
        setState(() {});
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final currentWidth = Tween<double>(
      begin: widget.collapsedWidth,
      end: widget.expandedWidth,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: widget.animationCurve,
    ));

    final currentHeight = Tween<double>(
      begin: widget.collapsedHeight,
      end: widget.expandedHeight,
    ).animate(CurvedAnimation(
      parent: _animationController,
      curve: widget.animationCurve,
    ));

    return AnimatedBuilder(
      animation: _animationController,
      builder: (context, child) {
        return GestureDetector(
          onTap: _toggleExpanded,
          child: Container(
            width: currentWidth.value,
            height: currentHeight.value,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.only(
                topLeft: Radius.circular(_expanded ? 24 : 40),
                bottomLeft: Radius.circular(_expanded ? 24 : 40),
              ),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(_expanded ? 0.25 : 0.15),
                  blurRadius: _expanded ? 56 : 28,
                  offset: const Offset(0, 8),
                ),
              ],
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.only(
                topLeft: Radius.circular(_expanded ? 24 : 40),
                bottomLeft: Radius.circular(_expanded ? 24 : 40),
              ),
              child: BackdropFilter(
                filter: _expanded
                    ? ui.ImageFilter.blur(sigmaX: 16, sigmaY: 16)
                    : ui.ImageFilter.blur(sigmaX: 0, sigmaY: 0),
                child: Container(
                  decoration: BoxDecoration(
                    gradient: widget.backgroundGradient,
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(_expanded ? 24 : 40),
                      bottomLeft: Radius.circular(_expanded ? 24 : 40),
                    ),
                    border: _expanded
                        ? Border(
                      top: BorderSide(
                          color: Colors.white.withOpacity(0.2)),
                      bottom: BorderSide(
                          color: Colors.white.withOpacity(0.2)),
                      left: BorderSide(
                          color: Colors.white.withOpacity(0.2)),
                    )
                        : null,
                  ),
                  child: Stack(
                    children: [
                      // Shine overlay
                      Positioned.fill(
                        child: IgnorePointer(
                          child: Container(
                            decoration: BoxDecoration(
                              gradient: LinearGradient(
                                begin: Alignment.topLeft,
                                end: Alignment.bottomRight,
                                colors: [
                                  Colors.white.withOpacity(0.08),
                                  Colors.transparent,
                                ],
                              ),
                              borderRadius: BorderRadius.only(
                                topLeft:
                                Radius.circular(_expanded ? 24 : 40),
                                bottomLeft:
                                Radius.circular(_expanded ? 24 : 40),
                              ),
                            ),
                          ),
                        ),
                      ),

                      // Main content
                      ClipRect(
                        child: Padding(
                          padding: EdgeInsets.symmetric(
                            horizontal: _expanded ? 12 : 6,
                            vertical: _expanded ? 12 : 0,
                          ),
                          child: Row(
                            mainAxisSize: MainAxisSize.max,
                            crossAxisAlignment: _expanded
                                ? CrossAxisAlignment.start
                                : CrossAxisAlignment.center,
                            children: [
                              // 1. Gift Icon / Tab (Fixed width: 36px)
                              SizedBox(
                                width: 36,
                                height: 36,
                                child: Center(
                                  child: Container(
                                    width: 36,
                                    height: 36,
                                    decoration: BoxDecoration(
                                      shape: BoxShape.circle,
                                      color: Colors.white.withOpacity(0.2),
                                    ),
                                    child: Stack(
                                      alignment: Alignment.center,
                                      clipBehavior: Clip.none,
                                      children: [
                                        if (!_expanded)
                                          OverflowBox(
                                            maxWidth: 36,
                                            maxHeight: 36,
                                            child: Container(
                                              width: 36,
                                              height: 36,
                                              decoration: BoxDecoration(
                                                shape: BoxShape.circle,
                                                border: Border.all(
                                                  color: Colors.white.withOpacity(0.25),
                                                  width: 2,
                                                ),
                                              ),
                                              child: TweenAnimationBuilder<double>(
                                                tween: Tween<double>(begin: 1, end: 1.25),
                                                duration: const Duration(seconds: 2),
                                                builder: (context, value, child) {
                                                  return Transform.scale(
                                                    scale: value,
                                                    child: child,
                                                  );
                                                },
                                                child: Container(
                                                  decoration: const BoxDecoration(
                                                    shape: BoxShape.circle,
                                                  ),
                                                ),
                                              ),
                                            ),
                                          ),
                                        const Icon(
                                          Icons.card_giftcard,
                                          color: Colors.white,
                                          size: 18,
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                              ),

                              if (_expanded) ...[
                                const SizedBox(width: 8),

                                // 2. Expanded content area takes strictly remaining width
                                Expanded(
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      // Header
                                      const Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            '🎁 Today\'s Freebies',
                                            maxLines: 1,
                                            overflow: TextOverflow.ellipsis,
                                            style: TextStyle(
                                              color: Colors.white,
                                              fontSize: 13,
                                              fontWeight: FontWeight.bold,
                                              shadows: [
                                                Shadow(
                                                  offset: Offset(0, 1),
                                                  blurRadius: 4,
                                                  color: Colors.black26,
                                                ),
                                              ],
                                            ),
                                          ),
                                          SizedBox(height: 2),

                                          // FIXED: Replaced Row + Flexible with a RichText / TextSpan or simple Row with Expanded
                                          Row(
                                            children: [
                                              Icon(
                                                Icons.bolt_outlined,
                                                color: Colors.white,
                                                size: 10,
                                              ),
                                              SizedBox(width: 2),
                                              Expanded(
                                                child: Text(
                                                  'Limited time — claim now',
                                                  maxLines: 1,
                                                  overflow: TextOverflow.ellipsis,
                                                  style: TextStyle(
                                                    color: Colors.white70,
                                                    fontSize: 10,
                                                    fontWeight: FontWeight.w500,
                                                  ),
                                                ),
                                              ),
                                            ],
                                          ),
                                        ],
                                      ),
                                      const SizedBox(height: 6),

                                      // Product list
                                      Expanded(
                                        child: ListView.builder(
                                          padding: EdgeInsets.zero,
                                          itemCount: widget.products.length,
                                          itemBuilder: (context, index) {
                                            final product = widget.products[index];
                                            final isClaimed = _claimed[product.id] ?? false;
                                            return _buildProductItem(product, isClaimed);
                                          },
                                        ),
                                      ),

                                      // Claim All Button
                                      Align(
                                        alignment: Alignment.centerRight,
                                        child: GestureDetector(
                                          onTap: _handleClaimAll,
                                          child: Container(
                                            // Constrain maximum width of the button so it can never force an overflow
                                            constraints: const BoxConstraints(maxWidth: 140),
                                            padding: const EdgeInsets.symmetric(
                                              horizontal: 10,
                                              vertical: 4,
                                            ),
                                            decoration: BoxDecoration(
                                              color: Colors.white.withOpacity(0.2),
                                              borderRadius: BorderRadius.circular(30),
                                            ),
                                            child: const Row(
                                              mainAxisSize: MainAxisSize.max,
                                              children: [
                                                Icon(
                                                  Icons.card_giftcard,
                                                  color: Colors.white,
                                                  size: 10,
                                                ),
                                                SizedBox(width: 4),
                                                Expanded(
                                                  child: Text(
                                                    'Claim All Free',
                                                    maxLines: 1,
                                                    overflow: TextOverflow.ellipsis,
                                                    style: TextStyle(
                                                      color: Colors.white,
                                                      fontSize: 10,
                                                      fontWeight: FontWeight.bold,
                                                      letterSpacing: 0.2,
                                                    ),
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
                              ],
                            ],
                          ),
                        ),
                      ),

                      // Close button (only when expanded)
                      if (_expanded)
                        Positioned(
                          top: 6,
                          right: 6,
                          child: GestureDetector(
                            onTap: () {
                              if (_expanded) _toggleExpanded();
                            },
                            child: Container(
                              width: 22,
                              height: 22,
                              decoration: BoxDecoration(
                                shape: BoxShape.circle,
                                color: Colors.white.withOpacity(0.2),
                              ),
                              child: const Icon(
                                Icons.close,
                                color: Colors.white,
                                size: 12,
                              ),
                            ),
                          ),
                        ),

                      // Handle indicator on right edge
                      if (!_expanded)
                        Positioned(
                          right: -2,
                          top: 0,
                          bottom: 0,
                          child: Center(
                            child: Container(
                              width: 4,
                              height: 28,
                              decoration: BoxDecoration(
                                color: Colors.white.withOpacity(0.25),
                                borderRadius: BorderRadius.circular(4),
                              ),
                            ),
                          ),
                        ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        );
      },
    );
  }

  Widget _buildProductItem(PromoProduct product, bool isClaimed) {
    return Container(
      margin: const EdgeInsets.only(bottom: 4),
      padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 5),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.08),
        borderRadius: BorderRadius.circular(10),
      ),
      child: Row(
        children: [
          // Icon container
          Container(
            width: 24,
            height: 24,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.12),
              borderRadius: BorderRadius.circular(6),
            ),
            child: Icon(
              product.icon,
              color: Colors.white,
              size: 12,
            ),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.max,
              children: [
                Text(
                  product.name,
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 11,
                    fontWeight: FontWeight.w600,
                  ),
                  overflow: TextOverflow.ellipsis,
                  maxLines: 1,
                ),
                // Price row – make both children flexible
                Row(
                  children: [
                    Expanded( // FIX: oldPrice can now shrink
                      child: Text(
                        product.oldPrice,
                        style: TextStyle(
                          color: Colors.white.withOpacity(0.4),
                          fontSize: 9,
                          decoration: TextDecoration.lineThrough,
                        ),
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                    const SizedBox(width: 4),
                    Flexible( // label remains flexible
                      child: Container(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 5, vertical: 0),
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.2),
                          borderRadius: BorderRadius.circular(20),
                        ),
                        child: Text(
                          product.label,
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 8,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          //const SizedBox(width: 4),
          // Claim button – make it flexible so it never pushes the row
          const Spacer(),
          ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 140),// FIX: button width is now constrained
            child: GestureDetector(
              onTap: () => _handleClaim(product.id),
              child: AnimatedContainer(
                duration: const Duration(milliseconds: 200),
                padding:
                const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                decoration: BoxDecoration(
                  color: isClaimed
                      ? const Color(0xFF10B981)
                      : Colors.white.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  isClaimed ? '✓ Got it' : 'Claim',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 9,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}