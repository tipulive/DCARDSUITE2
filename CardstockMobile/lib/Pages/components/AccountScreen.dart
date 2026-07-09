import 'package:dstockapp/Pages/components/PaymentsPage.dart';
import 'package:dstockapp/Pages/components/SalesPage.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../Query/account_controller.dart';
import '../Homepage.dart';
 // Make sure to import your new controller

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Banking App Layout',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF1A315E),
          surface: const Color(0xFFF5F7FA),
        ),
        useMaterial3: true,
      ),
      home: const AccountScreen(),
    );
  }
}

class AccountScreen extends StatefulWidget {
  const AccountScreen({super.key});

  @override
  State<AccountScreen> createState() => _AccountScreenState();
}

class _AccountScreenState extends State<AccountScreen> {
  int _selectedIndex = 2;

  // Initialize and inject our performance-optimized controller
  final AccountController controller = Get.put(AccountController());

  void _showFeatureSnackbar(String title, String message) {
    Get.snackbar(
      title,
      message,
      snackPosition: SnackPosition.BOTTOM,
      backgroundColor: const Color(0xFF1A315E).withOpacity(0.9),
      colorText: Colors.white,
      margin: const EdgeInsets.all(15),
      duration: const Duration(seconds: 2),
      icon: const Icon(Icons.info_outline, color: Colors.white),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: 240,
            color: const Color(0xFF1A315E),
          ),
          SafeArea(
            child: RefreshIndicator(
              onRefresh: () => controller.fetchCompanyRecord(), // Drag to refresh capability
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const SizedBox(height: 10),
                    _buildHeaderProfile(),
                    const SizedBox(height: 15),
                    _buildBalanceCard(),
                    const SizedBox(height: 16),
                    _buildFeatureGrid(),
                    const SizedBox(height: 16),
                    _buildQuickStatsSection(),
                    const SizedBox(height: 16),
                    _buildRecentTransactionsSection(),
                    const SizedBox(height: 30),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: _buildBottomNavigationBar(),
    );
  }

  Widget _buildHeaderProfile() {
    return const Padding(
      padding: EdgeInsets.symmetric(horizontal: 20.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Hey Sarah!',
                style: TextStyle(color: Colors.white70, fontSize: 14),
              ),
              SizedBox(height: 4),
              Text(
                'My Account',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 26,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ],
          ),
          CircleAvatar(
            radius: 20,
            backgroundColor: Colors.white24,
            child: Icon(Icons.person, color: Colors.white),
          ),
        ],
      ),
    );
  }

  // Reactive Total Balance Card
  Widget _buildBalanceCard() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          )
        ],
      ),
      padding: const EdgeInsets.all(20),
      child: Column(
        children: [
          const Text(
            'TOTAL BALANCE',
            style: TextStyle(
              color: Colors.grey,
              fontSize: 12,
              fontWeight: FontWeight.w600,
              letterSpacing: 0.5,
            ),
          ),
          const SizedBox(height: 8),
          Obx(() => Text(
            controller.totalBalance.value,
            style: const TextStyle(
              color: Color(0xFF1A315E),
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          )),
        ],
      ),
    );
  }

  // Reactive Feature Grid
  Widget _buildFeatureGrid() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Obx(() => GridView.count(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        crossAxisCount: 2,
        crossAxisSpacing: 12,
        mainAxisSpacing: 12,
        childAspectRatio: 1.8,
        children: [
          _buildGridCard(
            icon: Icons.account_balance_wallet,
            iconColor: Colors.blue,
            title: 'AMOUNT',
            subtitle: 'Available Funds',
            value: controller.amount.value,
            onTap: () => _showFeatureSnackbar('Available Funds', 'Your current spendable amount is ${controller.amount.value}'),
          ),
          _buildGridCard(
            icon: Icons.card_giftcard,
            iconColor: Colors.teal,
            title: 'BONUS',
            subtitle: 'Rewards Balance',
            value: controller.bonus.value,
            onTap: () => _showFeatureSnackbar('Rewards Balance', 'You have earned ${controller.bonus.value}!'),
          ),
          _buildGridCard(
            icon: Icons.pie_chart,
            iconColor: Colors.blue,
            title: 'SPENDING',
            subtitle: 'Monthly Summary',
            value: controller.spending.value,
            onTap: () => _showFeatureSnackbar('Monthly Spending', 'Total spent this month: ${controller.spending.value}'),
          ),
          _buildGridCard(
            icon: Icons.arrow_forward,
            iconColor: Colors.blue,
            title: 'TRANSFER',
            subtitle: 'Move Money',
            value: '',
            isActionOnly: true,
            onTap: () => _showFeatureSnackbar('Transfer Funds', 'Opening money transfer portal setup against total account valuation: ${controller.totalBalance.value}'),
          ),
          _buildGridCard(
            icon: Icons.atm,
            iconColor: Colors.blue,
            title: 'WITHDRAW',
            subtitle: 'Cash Out',
            value: controller.withdraw.value,
            onTap: () => _showFeatureSnackbar('Withdrawal Limit', 'Remaining withdrawal room: ${controller.withdraw.value}'),
          ),
          _buildGridCard(
            icon: Icons.local_offer,
            iconColor: Colors.green,
            title: 'QTY SPENT',
            subtitle: 'Total Items This Month',
            value: controller.qtySpent.value,
            onTap: () => _showFeatureSnackbar('Items Count', 'You made ${controller.qtySpent.value} purchases this cycle.'),
          ),
        ],
      )),
    );
  }

  Widget _buildGridCard({
    required IconData icon,
    required Color iconColor,
    required String title,
    required String subtitle,
    required String value,
    required VoidCallback onTap,
    bool isActionOnly = false,
  }) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(14),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.02),
            blurRadius: 5,
            offset: const Offset(0, 2),
          )
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          borderRadius: BorderRadius.circular(14),
          onTap: onTap,
          child: Padding(
            padding: const EdgeInsets.all(12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  children: [
                    Icon(icon, color: iconColor, size: 20),
                    const SizedBox(width: 6),
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1A315E),
                      ),
                    ),
                  ],
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      subtitle,
                      style: const TextStyle(fontSize: 10, color: Colors.grey),
                    ),
                    if (!isActionOnly) ...[
                      const SizedBox(height: 2),
                      Text(
                        value,
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                          color: Colors.black87,
                        ),
                      ),
                    ]
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildQuickStatsSection() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Quick Stats',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.bold,
              color: Color(0xFF1A315E),
            ),
          ),
          const SizedBox(height: 16),
          Row(
            crossAxisAlignment: CrossAxisAlignment.end,
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              _buildBar(15, Colors.grey.shade300),
              _buildBar(30, Colors.blue),
              _buildBar(10, Colors.grey.shade300),
              _buildBar(45, const Color(0xFF1A315E)),
              _buildBar(20, Colors.grey.shade300),
              _buildBar(35, Colors.teal),
              _buildBar(15, Colors.grey.shade300),
              _buildBar(25, Colors.grey.shade300),
            ],
          )
        ],
      ),
    );
  }

  Widget _buildBar(double height, Color color) {
    return Container(
      height: height,
      width: 10,
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(4),
      ),
    );
  }

  Widget _buildRecentTransactionsSection() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Recent Transactions',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.bold,
              color: Color(0xFF1A315E),
            ),
          ),
          const SizedBox(height: 10),
          _buildTransactionItem(
            icon: Icons.home,
            iconBg: Colors.blue.shade50,
            iconColor: Colors.blue,
            title: 'Rent Payment',
            date: 'Oct 13, 2023',
            amount: '-\$1,280.50',
          ),
          const Divider(),
          _buildTransactionItem(
            icon: Icons.shopping_basket,
            iconBg: Colors.teal.shade50,
            iconColor: Colors.teal,
            title: 'Grocery Store',
            date: 'Oct 11, 2023',
            amount: '-\$20.00',
          ),
          const Divider(),
          _buildTransactionItem(
            icon: Icons.coffee,
            iconBg: Colors.orange.shade50,
            iconColor: Colors.orange,
            title: 'Coffee Shop',
            date: 'Oct 10, 2023',
            amount: '-\$5.30',
          ),
        ],
      ),
    );
  }

  Widget _buildTransactionItem({
    required IconData icon,
    required Color iconBg,
    required Color iconColor,
    required String title,
    required String date,
    required String amount,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Row(
        children: [
          CircleAvatar(
            backgroundColor: iconBg,
            radius: 18,
            child: Icon(icon, color: iconColor, size: 18),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
                ),
                Text(
                  date,
                  style: const TextStyle(fontSize: 10, color: Colors.grey),
                ),
              ],
            ),
          ),
          Text(
            amount,
            style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
          ),
        ],
      ),
    );
  }

  Widget _buildBottomNavigationBar() {
    return BottomNavigationBar(
      currentIndex: _selectedIndex,
      type: BottomNavigationBarType.fixed,
      selectedItemColor: const Color(0xFF1A315E),
      unselectedItemColor: Colors.grey,
      selectedFontSize: 11,
      unselectedFontSize: 11,
      onTap: (index) {
        setState(() {
          _selectedIndex = index;
        });
        if (index == 0) Get.to(() => const Homepage());
        if (index == 1) Get.to(() => const PaymentsPage());
        if (index == 3) Get.to(() => const SalesPage());
      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.analytics_outlined), label: 'Analytics'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    );
  }
}