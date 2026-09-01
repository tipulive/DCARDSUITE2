import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'components/BottomNavigator/HomeNavigator.dart';

import 'package:get/get.dart';


class SetPage extends StatelessWidget {
  const SetPage({Key? key,required this.dynamicMethod,}) : super(key: key);
  final  Function() dynamicMethod;





  @override
  Widget build(BuildContext context) {
   // String argument = Get.arguments as String;
   // Map<String, dynamic> arguments = Get.arguments as Map<String, dynamic>;



    return Scaffold(

      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(27.0), // customize toolbar height
        child: AppBar(
          backgroundColor: Colors.transparent, // set the background color to transparent
          elevation: 0, // remove the shadow
          leading: IconButton(
            icon: const Icon(Icons.arrow_back,color: Colors.black,),
            onPressed: () {
              Get.back();
              //Get.toNamed('settings');
            },
          ),
          title: Center(child:  Text("All Sales",style:GoogleFonts.pacifico(fontSize:15,color: Colors.teal,fontWeight: FontWeight.w700)),
          ),
        ),
      ),


      body:dynamicMethod(),
        bottomNavigationBar:const HomeNavigator(currentIndex: 4,),



    );

  }
}
