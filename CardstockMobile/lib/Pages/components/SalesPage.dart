import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../Homepage.dart';

class SalesPage extends StatefulWidget {
  const SalesPage({super.key});

  @override
  State<SalesPage> createState() => _SalesPageState();
}

class _SalesPageState extends State<SalesPage> {
  // Highlight Analytics/Sales index in the Bottom Bar
  int _selectedIndex = 3;
  final TextEditingController _searchController = TextEditingController();

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }
  // Opens the improved multi-product breakdown bottom sheet
  void _showSalesDetailsBottomSheet({
    required String orderNumber,
    required String uid,
    required String clientName,
    required List<Map<String, dynamic>> products,
    required String shippingFee,
    required String totalAmount,
  }) {
    Get.bottomSheet(
      Container(
        constraints: BoxConstraints(
          maxHeight: Get.height * 0.85,
        ),
        padding: const EdgeInsets.fromLTRB(24, 16, 24, 24),
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.only(
            topLeft: Radius.circular(24),
            topRight: Radius.circular(24),
          ),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Top Handlebar Decorator
            Center(
              child: Container(
                width: 40,
                height: 4,
                decoration: BoxDecoration(
                  color: Colors.grey.shade300,
                  borderRadius: BorderRadius.circular(10),
                ),
              ),
            ),
            const SizedBox(height: 16),

            // Client Name & Grand Total Highlight at the Top
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        clientName,
                        style: const TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF1A315E),
                        ),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 2),
                      Text(
                        'Order $orderNumber • UID: $uid',
                        style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      ),
                    ],
                  ),
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    const Text(
                      'GRAND TOTAL',
                      style: TextStyle(
                        fontSize: 9,
                        fontWeight: FontWeight.bold,
                        color: Colors.grey,
                        letterSpacing: 0.5,
                      ),
                    ),
                    Text(
                      totalAmount,
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                        color: Colors.green,
                      ),
                    ),
                  ],
                ),
              ],
            ),
            const Divider(height: 24, thickness: 1),

            // Scrollable List of Multiple Products
            Flexible(
              child: ListView.separated(
                shrinkWrap: true,
                physics: const BouncingScrollPhysics(),
                itemCount: products.length,
                separatorBuilder: (context, index) => const Divider(height: 20, thickness: 0.5),
                itemBuilder: (context, index) {
                  final item = products[index];
                  return Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      CircleAvatar(
                        radius: 10,
                        backgroundColor: const Color(0xFF1A315E).withOpacity(0.1),
                        child: Text(
                          '${index + 1}',
                          style: const TextStyle(fontSize: 10, color: Color(0xFF1A315E), fontWeight: FontWeight.bold),
                        ),
                      ),
                      const SizedBox(width: 12),

                      // Product Details & Delivery Tracking Status
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              item['name'] ?? '',
                              style: const TextStyle(
                                fontSize: 13,
                                fontWeight: FontWeight.w600,
                                color: Colors.black87,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              'Price: ${item['price']}  •  Qty: ${item['qty']} pcs',
                              style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                            ),
                            const SizedBox(height: 4),

                            // Delivery Tracking Accent Label
                            Container(
                              padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                              decoration: BoxDecoration(
                                color: Colors.teal.shade50,
                                borderRadius: BorderRadius.circular(4),
                              ),
                              child: Text(
                                'Delivered: ${item['delivered']} of ${item['qty']} items',
                                style: TextStyle(
                                  fontSize: 10,
                                  color: Colors.teal.shade700,
                                  fontWeight: FontWeight.w600,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(width: 12),

                      // Row Total
                      Text(
                        item['itemTotal'] ?? '',
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                          color: Colors.black87,
                        ),
                      ),
                    ],
                  );
                },
              ),
            ),

            const Divider(height: 24, thickness: 0.5),

            // Base Fees Summary Footer Section
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Shipping & Logistics:',
                  style: TextStyle(fontSize: 12, fontWeight: FontWeight.w500, color: Colors.grey.shade600),
                ),
                Text(
                  shippingFee,
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.black87),
                ),
              ],
            ),
            const SizedBox(height: 8),
          ],
        ),
      ),
      isScrollControlled: true,
    );
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
                  _buildTotalSalesCard(),
                  const SizedBox(height: 16),
                  _buildSearchField(),
                  const SizedBox(height: 20),
                  _buildSalesListSection(),
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
            'Performance Dashboard',
            style: TextStyle(color: Colors.white70, fontSize: 14),
          ),
          SizedBox(height: 4),
          Text(
            'Sales Ledger',
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

  // Total Sales Summary Card
  Widget _buildTotalSalesCard() {
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
            'TOTAL GROSS SALES (THIS MONTH)',
            style: TextStyle(
              color: Colors.grey,
              fontSize: 12,
              fontWeight: FontWeight.w600,
              letterSpacing: 0.5,
            ),
          ),
          SizedBox(height: 8),
          Text(
            '\$48,920.15',
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

  // Search Input Field
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
            hintText: 'Search by sales name, UID, or agent...',
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

  // Cleaned Up Sales List Section
  Widget _buildSalesListSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'Recent Sales Records',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),
              Text(
                'See All',
                style: TextStyle(
                  fontSize: 11,
                  fontWeight: FontWeight.w600,
                  color: Colors.blue.shade700,
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          _buildSalesItemCard(
            salesName: 'Enterprise Server Migration License',
            uid: 'SLS-98421-X',
            amount: '\$12,500.00',
            byName: 'Sarah Jenkins',
            dateCaptured: 'July 01, 2026 • 14:32',
            isHighValue: true,
            products: [
              {
                'name': 'Enterprise Server License Upgrade',
                'price': '\$2,500.00',
                'qty': '5',
                'delivered': '5', // Fully delivered
                'itemTotal': '\$12,500.00',
              },
              {
                'name': 'SaaS Cloud Architecture Seats',
                'price': '\$616.66',
                'qty': '3',
                'delivered': '1', // Partially delivered
                'itemTotal': '\$1,850.00',
              }
            ],
          ),
          _buildSalesItemCard(
            salesName: 'SaaS Business Premium Package',
            uid: 'SLS-23841-A',
            amount: '\$1,850.00',
            byName: 'Alex Rivera',
            dateCaptured: 'June 29, 2026 • 09:15',
            products: [
              {
                'name': 'Enterprise Server License Upgrade',
                'price': '\$2,500.00',
                'qty': '5',
                'delivered': '5', // Fully delivered
                'itemTotal': '\$12,500.00',
              },
              {
                'name': 'SaaS Cloud Architecture Seats',
                'price': '\$616.66',
                'qty': '3',
                'delivered': '1', // Partially delivered
                'itemTotal': '\$1,850.00',
              }
            ],
          ),
          _buildSalesItemCard(
            salesName: 'Hardware Fleet Upgrade (Tier 2)',
            uid: 'SLS-77412-B',
            amount: '\$6,420.00',
            byName: 'Sarah Jenkins',
            dateCaptured: 'June 28, 2026 • 16:45',
            products: [
              {
                'name': 'Enterprise Server License Upgrade',
                'price': '\$2,500.00',
                'qty': '5',
                'delivered': '5', // Fully delivered
                'itemTotal': '\$12,500.00',
              },
              {
                'name': 'SaaS Cloud Architecture Seats',
                'price': '\$616.66',
                'qty': '3',
                'delivered': '1', // Partially delivered
                'itemTotal': '\$1,850.00',
              }
            ],
          ),
        ],
      ),
    );
  }

  // Modernized Individual Sales Card Widget
  Widget _buildSalesItemCard({
    required String salesName,
    required String uid,
    required String amount,
    required String byName,
    required String dateCaptured,
    required List<Map<String, dynamic>> products,
    bool isHighValue = false,
  }) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.015),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: IntrinsicHeight(
          child: Row(
            children: [
              // Dynamic Visual Accent Stripe
              Container(
                width: 4,
                color: isHighValue ? const Color(0xFF1A315E) : Colors.teal.shade400,
              ),

              // Core Information Fields
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 14.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  uid,
                                  style: TextStyle(
                                    fontSize: 10,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.blue.shade800,
                                    letterSpacing: 0.5,
                                  ),
                                ),
                                const SizedBox(height: 2),
                                Text(
                                  salesName,
                                  style: const TextStyle(
                                    fontSize: 13,
                                    fontWeight: FontWeight.w600,
                                    color: Colors.black87,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(width: 12),
                          Text(
                            amount,
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF1A315E),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 8),

                      // Secondary Metadata Footer
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            'Agent: $byName',
                            style: const TextStyle(fontSize: 10, color: Colors.grey),
                          ),
                          Text(
                            dateCaptured,
                            style: const TextStyle(fontSize: 10, color: Colors.grey),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),

              // Minimalist Tap Target to View Details
              Material(
                color: Colors.transparent,
                child: InkWell(
                    onTap: () => _showSalesDetailsBottomSheet(
                      //orderNumber: orderNumber,
                      orderNumber: "test",
                      uid: uid,
                      //clientName: clientName,
                      clientName: "ClientName",
                      //products: products,
                      products: products,
                      //shippingFee: shippingFee,
                      shippingFee: "400",
                      totalAmount: amount,
                    ),
                  child: Container(
                    padding: const EdgeInsets.symmetric(horizontal: 14),
                    child: const Icon(
                      Icons.arrow_forward_ios_rounded,
                      size: 14,
                      color: Colors.grey,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
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
        setState(() {
          _selectedIndex = index;
        });
      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle_outlined), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.analytics), label: 'Analytics'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    );
  }
}