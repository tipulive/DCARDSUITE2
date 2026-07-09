import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../Card/AddCardPage.dart';
import '../Homepage.dart';

class PaymentsPage extends StatefulWidget {
  const PaymentsPage({super.key});

  @override
  State<PaymentsPage> createState() => _PaymentsPageState();
}

class _PaymentsPageState extends State<PaymentsPage> {
  int _selectedIndex = 1; // Highlight 'Payments' tab
  final TextEditingController _searchController = TextEditingController();

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          // Background Header matching layout style
          Container(
            height: 240,
            color: const Color(0xFF1A315E),
          ),

          SafeArea(
            child: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const SizedBox(height: 10),
                  _buildHeaderSection(),
                  const SizedBox(height: 15),
                  _buildTotalPaymentCard(),
                  const SizedBox(height: 16),
                  _buildSearchField(),
                  const SizedBox(height: 16),
                  _buildPaymentActionsGrid(),
                  const SizedBox(height: 16),
                  _buildPaymentHistorySection(),
                  const SizedBox(height: 30),
                ],
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: _buildBottomNavigationBar(),
    );
  }

  // Header Section
  Widget _buildHeaderSection() {
    return const Padding(
      padding: EdgeInsets.symmetric(horizontal: 20.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Manage Your',
            style: TextStyle(color: Colors.white70, fontSize: 14),
          ),
          SizedBox(height: 4),
          Text(
            'Payments',
            style: TextStyle(
              color: Colors.white,
              fontSize: 26,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  // Total Payment Summary Card
  Widget _buildTotalPaymentCard() {
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
      child: const Column(
        children: [
          Text(
            'TOTAL PAYMENTS (THIS MONTH)',
            style: TextStyle(
              color: Colors.grey,
              fontSize: 12,
              fontWeight: FontWeight.w600,
              letterSpacing: 0.5,
            ),
          ),
          SizedBox(height: 8),
          Text(
            '\$3,412.80',
            style: TextStyle(
              color: Color(0xFF1A315E),
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  // Search Payments Input Row
  Widget _buildSearchField() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.02),
              blurRadius: 5,
              offset: const Offset(0, 2),
            )
          ],
        ),
        child: TextField(
          controller: _searchController,
          decoration: InputDecoration(
            hintText: 'Search payments, bills, or utilities...',
            hintStyle: const TextStyle(color: Colors.grey, fontSize: 13),
            prefixIcon: const Icon(Icons.search, color: Colors.grey, size: 20),
            border: InputBorder.none,
            contentPadding: const EdgeInsets.symmetric(vertical: 14),
          ),
          style: const TextStyle(fontSize: 14),
        ),
      ),
    );
  }

  // Quick Action Utilities
  Widget _buildPaymentActionsGrid() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'Quick Actions',
                style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1A315E)),
              ),
              GestureDetector(
                onTap: () => Get.to(() => const AddCardPage()),
                child: Text(
                  '+ Add Card',
                  style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.blue.shade700),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: 4,
            childAspectRatio: 0.85,
            children: [
              _buildActionButton(Icons.swap_horiz, 'Transfer', Colors.blue.shade50, Colors.blue),
              _buildActionButton(Icons.receipt_long, 'Bills', Colors.orange.shade50, Colors.orange),
              _buildActionButton(Icons.phone_android, 'Mobile', Colors.purple.shade50, Colors.purple),
              _buildActionButton(Icons.qr_code_scanner, 'Scan QR', Colors.teal.shade50, Colors.teal),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildActionButton(IconData icon, String label, Color bgColor, Color iconColor) {
    return Column(
      children: [
        CircleAvatar(
          radius: 24,
          backgroundColor: bgColor,
          child: Icon(icon, color: iconColor, size: 22),
        ),
        const SizedBox(height: 8),
        Text(
          label,
          style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w500, color: Colors.black87),
          textAlign: TextAlign.center,
        ),
      ],
    );
  }

  // Payment History Section
  Widget _buildPaymentHistorySection() {
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
            'Payment History',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.bold,
              color: Color(0xFF1A315E),
            ),
          ),
          const SizedBox(height: 12),
          _buildHistoryItem(
            title: 'Electric Utility Bill',
            category: 'Utilities',
            date: 'Oct 24, 2023',
            amount: '-\$112.40',
            status: 'Completed',
            statusColor: Colors.green,
          ),
          const Divider(),
          _buildHistoryItem(
            title: 'Creative Cloud Plan',
            category: 'Subscriptions',
            date: 'Oct 22, 2023',
            amount: '-\$54.99',
            status: 'Completed',
            statusColor: Colors.green,
          ),
          const Divider(),
          _buildHistoryItem(
            title: 'Water District AutoPay',
            category: 'Utilities',
            date: 'Oct 18, 2023',
            amount: '-\$42.15',
            status: 'Pending',
            statusColor: Colors.orange,
          ),
        ],
      ),
    );
  }

  Widget _buildHistoryItem({
    required String title,
    required String category,
    required String date,
    required String amount,
    required String status,
    required Color statusColor,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
                ),
                const SizedBox(height: 2),
                Row(
                  children: [
                    Text(
                      '$category • $date',
                      style: const TextStyle(fontSize: 10, color: Colors.grey),
                    ),
                    const SizedBox(width: 6),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 5, vertical: 1),
                      decoration: BoxDecoration(
                        color: statusColor.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(4),
                      ),
                      child: Text(
                        status,
                        style: TextStyle(color: statusColor, fontSize: 8, fontWeight: FontWeight.bold),
                      ),
                    )
                  ],
                ),
              ],
            ),
          ),
          Text(
            amount,
            style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: Colors.black87),
          ),
        ],
      ),
    );
  }

  // Bottom Navigation Bar
  Widget _buildBottomNavigationBar() {
    return BottomNavigationBar(
      currentIndex: _selectedIndex,
      type: BottomNavigationBarType.fixed,
      selectedItemColor: const Color(0xFF1A315E),
      unselectedItemColor: Colors.grey,
      selectedFontSize: 11,
      unselectedFontSize: 11,
      onTap: (index) {
        if (index == 0) {
          Get.off(() => const Homepage());
        }
        if (index == 2) {
          Get.back();
        }
        setState(() {
          _selectedIndex = index;
        });
      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle_outlined), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.analytics_outlined), label: 'Analytics'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    );
  }
}