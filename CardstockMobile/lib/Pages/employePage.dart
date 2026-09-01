import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../Utilconfig/HideShowState.dart';
import 'Card/AddCardPage.dart';
import 'Homepage.dart';
import 'SettingPage.dart';
import 'components/AccountScreen.dart';
import 'components/SalesPage.dart';

// 1. Controller to hold navigation index
class NavigationController extends GetxController {
  var selectedIndex = 0.obs;

  void changeIndex(int index) {
    selectedIndex.value = index;
  }
}

// 2. Nav bar driven by GetX state
class HomeNavigator extends StatelessWidget {
  const HomeNavigator({super.key});

  @override
  Widget build(BuildContext context) {
    final navController = Get.put(NavigationController());

    return Obx(() => BottomNavigationBar(
      currentIndex: navController.selectedIndex.value,
      type: BottomNavigationBarType.fixed,
      selectedItemColor: const Color(0xFF1A315E),
      unselectedItemColor: Colors.grey,
      selectedFontSize: 11,
      unselectedFontSize: 11,
      onTap: (index) {
        navController.changeIndex(index);
        Get.put(HideShowState()).setHomenavigator(index);

        if (index == 0) {
          Get.put(HideShowState()).isCameraVisible(true);
          Get.offAll(() => const Homepage());
        } else if (index == 1) {
          Get.to(() => const SalesPage());
        } else if (index == 2) {
          Get.to(() => const AccountScreen());
        } else if (index == 3) {
          Get.to(() => const AddCardPage());
        } else if (index == 4) {
          Get.put(HideShowState()).isCameraVisible(false);
          Get.to(() => const SettingPage());
        }
      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.add_card_outlined), label: 'Card'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    ));
  }
}