import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'components/BottomNavigator/HomeNavigator.dart';
import 'components/SetDeptComp.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';


class SetDeptPage extends StatelessWidget {
  const SetDeptPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(

      appBar: PreferredSize(
        preferredSize: Size.fromHeight(27.0), // customize toolbar height
        child:AppBar(
          backgroundColor: Colors.transparent, // set the background color to transparent
          elevation: 0, // remove the shadow
          leading: IconButton(
            icon: Icon(Icons.arrow_back,color: Colors.black,),
            onPressed: () {
              Get.back();
              //Get.toNamed('settings');
            },
          ),
          title: Center(child:  Text("Dept",style:GoogleFonts.pacifico(fontSize:15,color: Colors.teal,fontWeight: FontWeight.w700)),
          ),
        ),
      ),


      body:SetDeptComp(),
      bottomNavigationBar:const HomeNavigator(currentIndex: 4,),



    );

  }
}
