import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'package:dstockapp/Pages/components/AccountScreen.dart';
import 'package:dstockapp/Pages/components/SalesPage.dart';
import '../../Card/AddCardPage.dart';
import '../../Homepage.dart';
import '../../SettingPage.dart';
import '../../../Utilconfig/HideShowState.dart';

class HomeNavigator extends StatelessWidget {
  final int currentIndex;

  const HomeNavigator({
    super.key,
    this.currentIndex = 0,
  });

  @override
  Widget build(BuildContext context) {
    return BottomNavigationBar(
      currentIndex: currentIndex,
      type: BottomNavigationBarType.fixed,
      selectedItemColor: const Color(0xFF1A315E),
      unselectedItemColor: Colors.grey,
      selectedFontSize: 11,
      unselectedFontSize: 11,
      onTap: (index) {
        if (index == currentIndex) return; // Do nothing if already on this tab

        Get.put(HideShowState()).setHomenavigator(index);

        if (index == 0) {
          Get.put(HideShowState()).isCameraVisible(true);
          Get.offAll(() => const Homepage());
        } else if (index == 1) {
          Get.off(() => const SalesPage());
        } else if (index == 2) {
          Get.off(() => const AccountScreen());
        } else if (index == 3) {
          Get.off(() => const AddCardPage());
        } else if (index == 4) {
          Get.put(HideShowState()).isCameraVisible(false);
          Get.off(() => const SettingPage());
        }


      },
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
        BottomNavigationBarItem(icon: Icon(Icons.account_circle), label: 'Account'),
        BottomNavigationBarItem(icon: Icon(Icons.add_card_outlined), label: 'Card'),
        BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
      ],
    );
  }
}