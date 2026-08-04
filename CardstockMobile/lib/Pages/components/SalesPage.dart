import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../Query/StockQuery.dart';
import '../../models/Topups.dart';
import '../Homepage.dart';
// Ensure you import your StockQuery controller path properly here
// import 'path_to_your_stock_query.dart';

class SalesPage extends StatefulWidget {
  const SalesPage({super.key});

  @override
  State<SalesPage> createState() => _SalesPageState();
}

class _SalesPageState extends State<SalesPage> {
  // Highlight Analytics/Sales index in the Bottom Bar
  int _selectedIndex = 3;
  final TextEditingController _searchController = TextEditingController();

  // GetX Controller instance
  final StockQuery _stockQuery = Get.find<StockQuery>();

  // State Management Variables
  bool _isLoading = true;
  List<dynamic> _rawStockPayList = [];
  List<dynamic> _filteredStockPayList = [];
  // Place this inside your _SalesPageState class or as a helper list
  final List<Color> _accentColors = [
    const Color(0xFF1A315E), // Deep Navy
    Colors.teal.shade500,
    Colors.purple.shade500,
    Colors.amber.shade700,
    Colors.indigo.shade500,
    Colors.pink.shade400,    // Standard Flutter alternative to Rose
    Colors.green.shade600,   // Standard Flutter alternative to Emerald
    Colors.cyan.shade600,
    Colors.deepOrange.shade400,
    Colors.blue.shade600,
  ];

  @override
  void initState() {
    super.initState();
    _fetchStockPayData();
    _searchController.addListener(_onSearchChanged);
  }

  @override
  void dispose() {
    _searchController.removeListener(_onSearchChanged);
    _searchController.dispose();
    super.dispose();
  }

  // Fetch API Data from StockQuery Controller
  Future<void> _fetchStockPayData() async {
    setState(() => _isLoading = true);

    try {
      // Topups parameter passed as needed by your controller
      final response = await _stockQuery.viewReqStockPay(Topups());

      if (response != null && response.data != null) {
        // Adjust key according to API response wrapper (e.g., response.data["result"] or response.data)
        final List<dynamic> data = response.data is List
            ? response.data
            : (response.data["result"] ?? response.data["data"] ?? []);

        setState(() {
          _rawStockPayList = data;
          _filteredStockPayList = data;
          _isLoading = false;
        });
      } else {
        setState(() => _isLoading = false);
      }
    } catch (e) {
      debugPrint("Error fetching stock pay details: $e");
      setState(() => _isLoading = false);
    }
  }

  // Live Client-Side Search Filter
  void _onSearchChanged() {
    final query = _searchController.text.toLowerCase().trim();
    if (query.isEmpty) {
      setState(() => _filteredStockPayList = _rawStockPayList);
    } else {
      setState(() {
        _filteredStockPayList = _rawStockPayList.where((item) {
          final uid = (item['uid'] ?? '').toString().toLowerCase();
          final payer = (item['payer'] ?? '').toString().toLowerCase();
          final receiver = (item['OwnerAmount'] ?? '').toString().toLowerCase();
          final purpose = (item['purpose'] ?? '').toString().toLowerCase();
          final status = (item['status'] ?? item['payment_status'] ?? '').toString().toLowerCase();
          return uid.contains(query) ||
              payer.contains(query) ||
              receiver.contains(query) ||
              purpose.contains(query) ||
              status.contains(query);
        }).toList();
      });
    }
  }

  // Opens the improved multi-product breakdown bottom sheet
  void _showSalesDetailsBottomSheet({
    required String orderNumber,
    required String uid,
    required String receiver,
    required String clientName,
    required String status,
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
                        'Status: ${status.toUpperCase()} • UID: $uid • Receiver: $receiver',
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
                      '\$$totalAmount',
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
              child: products.isEmpty
                  ? Center(
                child: Padding(
                  padding: const EdgeInsets.all(20.0),
                  child: Text(
                    "No product items listed.",
                    style: TextStyle(color: Colors.grey.shade600, fontSize: 13),
                  ),
                ),
              )
                  : ListView.separated(
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
          decoration: const InputDecoration(
            hintText: 'Search by status, name, UID, receiver, or payer...',
            hintStyle: TextStyle(color: Colors.grey, fontSize: 13),
            prefixIcon: Icon(Icons.search, color: Colors.grey, size: 20),
            border: InputBorder.none,
            contentPadding: EdgeInsets.symmetric(vertical: 14),
          ),
          style: const TextStyle(fontSize: 14),
        ),
      ),
    );
  }

  // Sales List Section Powered by StockQuery API
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
                'Recent Request Transfer',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A315E),
                ),
              ),
              TextButton(
                onPressed: _fetchStockPayData,
                style: TextButton.styleFrom(
                  padding: EdgeInsets.zero,
                  minimumSize: Size.zero,
                  tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                ),
                child: Text(
                  'Refresh',
                  style: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.w600,
                    color: Colors.blue.shade700,
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),

          // Loading & Data State Handling
          if (_isLoading)
            const Center(
              child: Padding(
                padding: EdgeInsets.symmetric(vertical: 30),
                child: CircularProgressIndicator(color: Color(0xFF1A315E)),
              ),
            )
          else if (_filteredStockPayList.isEmpty)
            Container(
              width: double.infinity,
              padding: const EdgeInsets.all(24),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
              ),
              child: const Center(
                child: Text(
                  'No stock transfers found.',
                  style: TextStyle(color: Colors.grey, fontSize: 13),
                ),
              ),
            )
          else
            ListView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              itemCount: _filteredStockPayList.length,
              itemBuilder: (context, index) {
                final item = _filteredStockPayList[index];

                final String uid = item['uid'] ?? 'N/A';
                final String receiver = item['OwnerAmount'] ?? 'N/A';
                final String amount = item['amount'] ?? '0';
                final String purpose = item['purpose'] ?? 'Stock Transfer';
                final String createdAt = item['created_at'] ?? 'N/A';
                final String payer = item['payer'] ?? 'Unknown Payer';
               // final String status = item['status'] ?? item['payment_status'] ?? 'Pending';
                String status ="Pending";

                // 🎨 Get a distinct color per card based on its UID or index
                final Color itemColor = _accentColors[uid.hashCode.abs() % _accentColors.length];
                return _buildSalesItemCard(
                  salesName: purpose,
                  uid: uid,
                  receiver: receiver,
                  paymentStatus: status,
                  amount: '\$$amount',
                  byName: payer,
                  dateCaptured: createdAt,
                  accentColor: itemColor, // Pass color here
                  isHighValue: (double.tryParse(amount) ?? 0) >= 500,
                  products: (item['products'] as List<dynamic>?)
                      ?.map((e) => Map<String, dynamic>.from(e))
                      .toList() ??
                      [],
                  onPrintPayment: () {
                    // TODO: Add confirm & print action handler here
                  },
                );
              },
            ),
        ],
      ),
    );
  }

  // Modernized Individual Sales Card Widget
  Widget _buildSalesItemCard({
    required String salesName,
    required String uid,
    required String receiver,
    required String paymentStatus,
    required String amount,
    required String byName,
    required String dateCaptured,
    required Color accentColor,
    required List<Map<String, dynamic>> products,
    bool isHighValue = false,
    VoidCallback? onPrintPayment,
  }) {
    // Dynamic Status Color Switch (PENDING = Orange)
    final String cleanStatus = paymentStatus.toUpperCase();

    Color statusBgColor;
    Color statusTextColor;

    if (cleanStatus == 'PAID' || cleanStatus == 'COMPLETED' || cleanStatus == 'SUCCESS') {
      statusBgColor = Colors.green.shade50;
      statusTextColor = Colors.green.shade700;
    } else if (cleanStatus == 'FAILED' || cleanStatus == 'CANCELLED') {
      statusBgColor = Colors.red.shade50;
      statusTextColor = Colors.red.shade700;
    } else {
      // Default / PENDING -> High contrast Orange Badge
      statusBgColor = Colors.orange.shade100;
      statusTextColor = Colors.deepOrange.shade800;
    }

    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 3),
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
                color:accentColor,
              ),

              // Core Information Fields
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 14.0, vertical: 12.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Left Side: Orange PENDING Status (on top of UID) & Sales Name
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Payment Status Badge (Top-Left)
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                  decoration: BoxDecoration(
                                    color: statusBgColor,
                                    borderRadius: BorderRadius.circular(4),
                                  ),
                                  child: Text(
                                    cleanStatus,
                                    style: TextStyle(
                                      fontSize: 8,
                                      fontWeight: FontWeight.bold,
                                      color: statusTextColor,
                                    ),
                                  ),
                                ),
                                const SizedBox(height: 4),

                                // UID Directly Below Status
                                Text(
                                  'UID: $uid',
                                  style: TextStyle(
                                    fontSize: 10,
                                    fontWeight: FontWeight.bold,
                                    color: Colors.blue.shade800,
                                    letterSpacing: 0.3,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                                const SizedBox(height: 2),

                                // Sales Name Purpose
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
                          const SizedBox(width: 8),

                          // Amount
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
                      const SizedBox(height: 10),

                      // Secondary Metadata Footer
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            'Payer: $byName',
                            style: TextStyle(fontSize: 10, color: Colors.grey.shade600),
                          ),
                          Text(
                            dateCaptured,
                            style: TextStyle(fontSize: 10, color: Colors.grey.shade600),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),

              // Vertical Separator
              VerticalDivider(
                width: 1,
                thickness: 1,
                color: Colors.grey.shade200,
              ),

              // Right-Side Action Icons Column with Receiver Right On Top
              Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  // Receiver badge positioned directly above right icons
                  Container(
                    margin: const EdgeInsets.only(top: 6, left: 4, right: 4),
                    padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                    decoration: BoxDecoration(
                      color: const Color(0xFF1A315E).withOpacity(0.08),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Receiver: $receiver',
                      style: const TextStyle(
                        fontSize: 8,
                        fontWeight: FontWeight.bold,
                        color: Color(0xFF1A315E),
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),

                  // Actions Group
                  Column(
                    children: [
                      // Print Action
                      Tooltip(
                        message: 'Confirm Payment & Print',
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: onPrintPayment,
                            child: Padding(
                              padding: const EdgeInsets.symmetric(horizontal: 12.0, vertical: 6.0),
                              child: Icon(
                                Icons.print_outlined,
                                size: 18,
                                color: Colors.teal.shade700,
                              ),
                            ),
                          ),
                        ),
                      ),

                      // Horizontal separator between action icons
                      Container(
                        width: 20,
                        height: 1,
                        color: Colors.grey.shade200,
                      ),

                      // View Details Action
                      Tooltip(
                        message: 'View Details',
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: () => _showSalesDetailsBottomSheet(
                              orderNumber: uid,
                              uid: uid,
                              receiver: receiver,
                              status: paymentStatus,
                              clientName: byName,
                              products: products,
                              shippingFee: "0",
                              totalAmount: amount.replaceAll('\$', ''),
                            ),
                            child: const Padding(
                              padding: EdgeInsets.symmetric(horizontal: 12.0, vertical: 6.0),
                              child: Icon(
                                Icons.visibility_outlined,
                                size: 18,
                                color: Color(0xFF1A315E),
                              ),
                            ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 4),
                    ],
                  ),
                ],
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