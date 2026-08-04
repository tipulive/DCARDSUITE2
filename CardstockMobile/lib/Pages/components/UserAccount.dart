import 'package:flutter/material.dart';
import 'package:get/get.dart';

/// Call this method anywhere in your app: `RewardsBottomSheet.show();`
class RewardsBottomSheet {
  static void show() {
    Get.bottomSheet(
      Container(
        height: Get.height * 0.85,
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
        ),
        child: DefaultTabController(
          length: 2,
          child: Column(
            children: [
              // 1. Drag Handle
              const SizedBox(height: 12),
              Container(
                width: 40,
                height: 4,
                decoration: BoxDecoration(
                  color: Colors.grey[300],
                  borderRadius: BorderRadius.circular(2),
                ),
              ),

              // 2. Header Title & Close Button
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 8),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    const Text(
                      'Rewards & History',
                      style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                    ),
                    IconButton(
                      icon: const Icon(Icons.close),
                      onPressed: () => Get.back(),
                    ),
                  ],
                ),
              ),

              // 3. Primary Navigation (Offers vs History)
              const TabBar(
                labelColor: Colors.blueAccent,
                unselectedLabelColor: Colors.grey,
                indicatorColor: Colors.blueAccent,
                tabs: [
                  Tab(text: 'Active Offers'),
                  Tab(text: 'History'),
                ],
              ),

              // 4. Tab Views
              const Expanded(
                child: TabBarView(
                  children: [
                    ActiveOffersView(),
                    HistoryView(),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      // enterCurve parameter removed here
    );
  }
}

// ============================================================================
// 1. ACTIVE OFFERS (Bonus & Promotions)
// ============================================================================
class ActiveOffersView extends StatelessWidget {
  const ActiveOffersView({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.all(16),
      children: [
        const Text(
          'Available Bonuses',
          style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Colors.grey),
        ),
        const SizedBox(height: 8),
        _buildOfferCard(
          title: 'Welcome Deposit Match',
          subtitle: '100% bonus up to \$50',
          badgeText: 'BONUS',
          badgeColor: Colors.purple,
          buttonText: 'Claim',
          icon: Icons.card_giftcard,
        ),
        const SizedBox(height: 16),
        const Text(
          'Active Promotions',
          style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Colors.grey),
        ),
        const SizedBox(height: 8),
        _buildOfferCard(
          title: 'Weekend Cashback',
          subtitle: '10% return on net losses',
          badgeText: 'PROMO',
          badgeColor: Colors.orange,
          buttonText: 'Opt In',
          icon: Icons.local_offer_outlined,
        ),
      ],
    );
  }

  Widget _buildOfferCard({
    required String title,
    required String subtitle,
    required String badgeText,
    required Color badgeColor,
    required String buttonText,
    required IconData icon,
  }) {
    return Card(
      elevation: 0,
      color: Colors.grey[50],
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(16),
        side: BorderSide(color: Colors.grey.shade200),
      ),
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Row(
          children: [
            CircleAvatar(
              radius: 20,
              backgroundColor: badgeColor.withOpacity(0.1),
              child: Icon(icon, color: badgeColor, size: 20),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                    decoration: BoxDecoration(
                      color: badgeColor.withOpacity(0.15),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      badgeText,
                      style: TextStyle(color: badgeColor, fontSize: 10, fontWeight: FontWeight.bold),
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(title, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14)),
                  Text(subtitle, style: TextStyle(color: Colors.grey[600], fontSize: 12)),
                ],
              ),
            ),
            ElevatedButton(
              onPressed: () {},
              style: ElevatedButton.styleFrom(
                elevation: 0,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
              ),
              child: Text(buttonText),
            ),
          ],
        ),
      ),
    );
  }
}

// ============================================================================
// 2. HISTORY TAB (Withdraw, Bonus, Promotions)
// ============================================================================
class HistoryView extends StatelessWidget {
  const HistoryView({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Column(
        children: [
          Container(
            height: 40,
            margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            decoration: BoxDecoration(
              color: Colors.grey[200],
              borderRadius: BorderRadius.circular(10),
            ),
            child: const TabBar(
              indicatorSize: TabBarIndicatorSize.tab,
              indicator: BoxDecoration(
                borderRadius: BorderRadius.all(Radius.circular(10)),
                color: Colors.white,
              ),
              labelColor: Colors.black,
              unselectedLabelColor: Colors.grey,
              tabs: [
                Tab(text: 'Active'),
                Tab(text: 'Bonuses'),
                Tab(text: 'Withdrawal'),
              ],
            ),
          ),
          Expanded(
            child: TabBarView(
              children: [
                // Withdrawal History
                _buildHistoryList([
                  _HistoryItem('Bank Transfer', '-\$150.00', 'Jul 28, 2026', 'Completed', Colors.green),
                  _HistoryItem('PayPal Withdrawal', '-\$50.00', 'Jul 15, 2026', 'Pending', Colors.orange),
                ]),
                // Bonus History
                _buildHistoryList([
                  _HistoryItem('Sign-up Bonus', '+\$20.00', 'Jul 01, 2026', 'Claimed', Colors.blue),
                  _HistoryItem('Deposit Match', '+\$50.00', 'Jun 12, 2026', 'Expired', Colors.grey),
                ]),
                // Promotion History
                _buildHistoryList([
                  _HistoryItem('Summer Spins Promo', '10 Free Spins', 'Jul 20, 2026', 'Used', Colors.purple),
                  _HistoryItem('VIP Cashback', '+\$12.50', 'Jun 30, 2026', 'Completed', Colors.green),
                ]),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHistoryList(List<_HistoryItem> items) {
    return ListView.separated(
      padding: const EdgeInsets.all(16),
      itemCount: items.length,
      separatorBuilder: (_, __) => const Divider(height: 1),
      itemBuilder: (context, index) {
        final item = items[index];
        return ListTile(
          dense: true,
          contentPadding: EdgeInsets.zero,
          title: Text(item.title, style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
          subtitle: Text(item.date, style: const TextStyle(fontSize: 11)),
          trailing: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Text(item.amount, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
              Text(
                item.status,
                style: TextStyle(color: item.statusColor, fontSize: 10, fontWeight: FontWeight.bold),
              ),
            ],
          ),
        );
      },
    );
  }
}

class _HistoryItem {
  final String title, amount, date, status;
  final Color statusColor;

  _HistoryItem(this.title, this.amount, this.date, this.status, this.statusColor);
}