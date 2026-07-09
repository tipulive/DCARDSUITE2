
import 'package:dstockapp/Pages/components/AccountScreen.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../Card/AddCardPage.dart';
import '../../Homepage.dart';
import '../../SettingPage.dart';
import '../../../Utilconfig/HideShowState.dart';



class HomeNavigator extends StatelessWidget {
  const HomeNavigator({super.key});

  @override
  Widget build(BuildContext context) {
    //final myindex = Get.arguments??0;
    int _selectedIndex = 0;


      return BottomNavigationBar(
        currentIndex: _selectedIndex,
        type: BottomNavigationBarType.fixed,
        selectedItemColor: const Color(0xFF1A315E),
        unselectedItemColor: Colors.grey,
        selectedFontSize: 11,
        unselectedFontSize: 11,
        onTap: (index) {
          Get.put(HideShowState()).setHomenavigator(index);
          if(index==0)
          {


            Get.put(HideShowState()).isCameraVisible(true);
            Get.to(() => const Homepage());


          }
          if(index==1)
          {


            Get.to(() =>const AddCardPage(),arguments:1);
          }
          if(index==2)
          {
            Get.to(() =>const AccountScreen(),arguments:1);
          }
          if(index==3)
          {
            Get.put(HideShowState()).isCameraVisible(false);

            Get.to(() =>const SettingPage(),arguments:1);
          }
        },
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home_outlined), label: 'Home'),
         // BottomNavigationBarItem(icon: Icon(Icons.payment_outlined), label: 'Payments'),
          BottomNavigationBarItem(icon: Icon(Icons.add_card_outlined), label: 'Card'),
          BottomNavigationBarItem(icon: Icon(Icons.account_circle), label: 'Account'),

          BottomNavigationBarItem(icon: Icon(Icons.settings_outlined), label: 'Settings'),
        ],
      );

  }
}


