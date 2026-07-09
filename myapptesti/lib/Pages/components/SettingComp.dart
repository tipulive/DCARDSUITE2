


import '../../Query/StockQuery.dart';

import '../../Pages/components/ProductComp.dart';
import '../../Pages/components/SetAdminPaymentComp.dart';

import '../../Pages/SetEditCardNoPage.dart';
import '../../Pages/SetStockPage.dart';
import '../../Pages/SetWithdrawBonusPage.dart';
import '../../Query/AdminQuery.dart';
import '../../Query/TopupQuery.dart';
import '../../Utilconfig/HideShowState.dart';


import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';


import '../SetDeptPage.dart';
import '../SetOrderPage.dart';
import '../SetPage.dart';
import '../SetPaidDeptPage.dart';
import '../SetPartHistPage.dart';
import '../SetPartPage.dart';
import '../SetQuickBoHistPage.dart';
import '../SetRepayPage.dart';
import '../SetSalePage.dart';

import '../SetWithdrawBalancePage.dart';

import '../employePage.dart';
import '../components/SetSpendingComp.dart';
import '../components/SetAllSaleComp.dart';
import 'ContactComp.dart';
import '../../Utilconfig/language/language.dart';



class CountryModel {
  final String name;
  final String fName;
  final String flag;

  CountryModel({required this.name, required this.fName, required this.flag});
}
class SettingComp extends StatefulWidget {
  const SettingComp({super.key});

  @override
  State<SettingComp> createState() => _SettingCompState();
}

class _SettingCompState extends State<SettingComp> {

  bool showOveray=false;
  var balance="0";
  var bonus="0";
  Language langV=Language();
  var pageName="pageName";
  final List<CountryModel> countries = [
    CountryModel(name: 'English',fName:'English', flag: '🇺🇸'),

    CountryModel(name: 'French',fName:'France', flag: 'FR'),
    CountryModel(name: 'Kiswahili',fName:'Kiswahili',flag: '🇨🇩'),
    CountryModel(name: 'Kinyarwanda', fName:'Rwanda',flag: '🇷🇼'), // Rwanda

    // Add more countries as needed
  ];

  String? selectedCountry;


  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        ListView(


          children: [

            Center(
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Text(Get.put(AdminQuery()).obj["result"][0]["name"],
                  style:GoogleFonts.bebasNeue(fontSize:20),
                ),
              ),
            ),

            divLine(),
            /*GestureDetector(
                onTap: (){
                  dispatchOrder();
                },
                child: detailsProfile("${langV.languageV[(Get.put(StockQuery()).lang)][pageName]["title"]}",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,dispatchOrder)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  changeLanguage();
                },
                child: detailsProfile("Language",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,changeLanguage)),//Last Time Purchase
            const SizedBox(height:5,),*/
            GestureDetector(
                onTap: (){
                  dispatchOrder();
                },
                child: detailsProfile("Dispatch Orders",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,dispatchOrder)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  sales();
                },
                child: detailsProfile("Sales",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,sales)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  allSales();
                },
                child: detailsProfile("All Sales",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,allSales)),
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  spending();
                },
                child: detailsProfile("Spendings",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,spending)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  contactFunc();
                },
                child: detailsProfile("Contacts",Icons.account_balance,"",0xbfebf1ef,"textright",Icons.arrow_forward,"200\$",0xffffffff,contactFunc)),

            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  dept();
                },
                child: detailsProfile("Dept",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,dept)),//Last Time Purchase
       //Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  adminPayment();
                },
                child: detailsProfile("Admin Payment",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,adminPayment)),
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  product();
                },
                child: detailsProfile("Products",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,product)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  repay();
                },
                child: detailsProfile("Repay",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,repay)),


            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  employe();
                },
                child: detailsProfile("Employee",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,employe)),//Last Time Purchase
            const SizedBox(height:5,),

            GestureDetector(
                onTap: (){
                  viewStock();
                },
                child: detailsProfile("Stocks",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,viewStock)),//Last Time Purchase
            const SizedBox(height:5,),

            GestureDetector(
                onTap: (){
                  partHistfunc();
                },
                child: detailsProfile("Participate History",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,partHistfunc)),//Last Time Purchase
            const SizedBox(height:5,),

            GestureDetector(
                onTap: (){
                  partfunc();
                },
                child: detailsProfile("Participate",Icons.calendar_month_outlined,"",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,partfunc)),//Last Time Purchase
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  quickBoHistfunc();
                },
                child: detailsProfile("QuickBonus",Icons.paid,"",0xbfebf1ef,"textright",Icons.arrow_forward,"200\$",0xffffffff,quickBoHistfunc)),
            const SizedBox(height:5,),

            GestureDetector(
                onTap: (){
                  editCardfunc();
                },
                child: detailsProfile("Edit Card",Icons.account_balance,"",0xbfebf1ef,"textright",Icons.arrow_forward,"200\$",0xffffffff,editCardfunc)),

            const SizedBox(height:5,),
            GestureDetector(
              onTap: (){
                withdrawBalanceFunc();
              },
                child: detailsProfile('WithDraw Balance',Icons.payments_rounded,"$balance\$",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,withdrawBalanceFunc)),
            const SizedBox(height:5,),
            GestureDetector(
                onTap: (){
                  withdrawBonusFunc();
                },
                child: detailsProfile("Bonus History",Icons.redeem,"$bonus\$",0xffffffff,"textright",Icons.arrow_forward,"200\$",0xffffffff,withdrawBonusFunc)),
            const SizedBox(height:5,),
            GestureDetector(
                onTap: () {
                  Get.dialog(
                    AlertDialog(
                      title: const Text('Confirmation'),
                      content: const Text('Do you Want to Logout?'),
                      actions: [
                        ElevatedButton(
                          style: ElevatedButton.styleFrom(

                            //primary: Colors.grey[300],
                            backgroundColor: const Color(0xff9a1c55),
                            elevation:0,
                          ),
                          onPressed: () async{
                            await Get.put(AdminQuery()).logout();

                            Get.toNamed('/Login');
                          },
                          child: const Text('Yes',style: TextStyle(
                            color: Colors.white
                          ),),
                        ),
                        ElevatedButton(
                          onPressed: () {
                            Get.back(); // close the alert dialog
                          },
                          child: const Text('Close'),
                        ),
                      ],
                    ),
                  );

                },
                child: detailsProfile("Logout",Icons.account_balance,"",0xbfebf1ef,"textright",Icons.power,"200\$",0xffffffff,logout)),








          ],
        ),
        if(showOveray)
          Positioned.fill(
            child: Center(
              child: Container(
                alignment: Alignment.center,
                color: Colors.white70,
                child: const CircularProgressIndicator(),
              ),
            ),
          ),
      ],
    );
  }


  @override
  void initState()
  {
    super.initState();
    //getapi();
    selectedCountry='English';
    langV.getLanguage();
    //getLanguage();
    scrolldata();

  }


  @override
  void dispose() {

    super.dispose();
  }

  changeLangWidget() async{
    Get.dialog(
      AlertDialog(
        title: const Text('Change Language'),
        content:DropdownButtonHideUnderline(
          child: DropdownButton<String>(
            value:selectedCountry,
            onChanged: (newValue) {

             //print(newValue);
              setState(() {
                selectedCountry=newValue!;
                langV.saveData(newValue);
              });
            },
            items:countries.map((country) {
              return DropdownMenuItem<String>(
                value: country.name,
                child: Row(
                  children: <Widget>[
                    Text(country.flag),
                    const SizedBox(width: 15),
                    Text(country.name),
                  ],
                ),
              );
            }).toList(),
          ),
        ),
        actions: [

          ElevatedButton(
            onPressed: () {
              Get.back(); // close the alert dialog
            },
            child: const Text('Close'),
          ),
        ],
      ),
    );
  }
  changeLanguage() async{

    changeLangWidget();
 /* String valueData="french";
  setState(() {
     langV.saveData(valueData);

  });*/




  }
  scrolldata()async
  {
    if(showOveray) return;
    showOveray=true;

    var resul=(await TopupQuery().getCompanyRecord()).data;

    if(resul["status"])
    {
      setState(() {
        showOveray=false;
        balance=resul["result"][0]["balance"];
        bonus=resul["result"][0]["bonus"];


      });
    }

    else{

      setState(() {
        showOveray=false;
        balance="0";
        bonus="0";


      });
    }

  }


}



Widget divLine(){
  return Container(
    margin: const EdgeInsets.all(8),
    child: Row(

      children: [
        Expanded(
          child: ClipRRect(
            borderRadius: BorderRadius.circular(8),
            child: Container(


                constraints: const BoxConstraints(maxWidth: 200,maxHeight: 5),
                //color: Color.fromRGBO(13,44,64, 0.4),
                color: Colors.white70
            ),
          ),
        ),
        const SizedBox(width: 100,),
        Expanded(
          child: ClipRRect(
            borderRadius: BorderRadius.circular(8),
            child: Container(


                constraints: const BoxConstraints(maxWidth: 200,maxHeight: 5),
                //color: Color.fromRGBO(13,44,64, 0.4),
                color: Colors.white70
            ),
          ),
        )
      ],
    ),
  );
}

Widget detailsProfile(iconText,icon,iconDescr,listBackground,iconrightText,iconright,iconDescrRight,listBackgroundRight,Function myfunct){


  return ClipRRect(
    //borderRadius: BorderRadius.circular(32),
    child: Container(
      padding: const EdgeInsets.all(8),
      //margin: const EdgeInsets.all(8),
      margin: const EdgeInsets.fromLTRB(8,0,8,0),
      width: 400,
      height: 50,
      //color:Color(0xffffffff),
      color:Color(listBackground),

      child: Row(

        children: [
          Container(
            width: 30,
            height: 30,
            decoration: BoxDecoration(

              shape: BoxShape.circle,
              border: Border.all(color: Colors.yellow,width: 1.5),



            ),
            child: Icon(
              icon,color:
            Colors.amber,size: 22,),

          ),
          const SizedBox(width:3,),

          Text(iconText+":",style:GoogleFonts.pacifico(fontSize:15,color: Colors.teal,fontWeight: FontWeight.w700)),
          const SizedBox(width:5,),
          Expanded(
            child: Container(
              padding: const EdgeInsets.only(top: 3.9),
              child: Text(iconDescr,style:GoogleFonts.pacifico(fontSize: 15)),
            ),
          ),

          Expanded(//right
            child: Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [

                GestureDetector(
                    onTap: () {
                      // This function will be called when the icon is tapped.
                      myfunct();
                    },
                    child: Icon(iconright,color:
                    Colors.teal,size: 22,)
                ),

              ],
            ),
          ),
        ],
      ),
    ),
  );
}

dispatchOrder() async{

  Get.to(() =>const SetOrderPage());

}

sales()async{

  Get.to(() =>const SetSalePage());

}
allSales() async{

  Get.to(() =>SetPage(dynamicMethod: () {
    return  const SetAllSaleComp();
  }),arguments:{
    "title":"All Sales",
  });

}
spending() async{

  Get.to(() =>SetPage(dynamicMethod: () {
    return  const SetSpendingComp();
  }),arguments:{
    "title":"Spending",
  });

}
adminPayment() async{

  Get.to(() => SetPage(dynamicMethod: () {
    return const SetAdminPaymentComp();
  }),arguments:{
    "title":"Admin Payment",
  });

}
dept() async{

  Get.to(() =>const SetDeptPage());

}
paidDept() async{

  Get.to(() =>const SetPaidDeptPage());

}
repay() async{

  Get.to(() =>const SetRepayPage());

}
employe() async{

  Get.to(() =>const employePage());

}
product() async{

  Get.to(() =>SetPage(dynamicMethod: () {
    return  const ProductComp();
  }),arguments:{
    "title":"Products",
  });

}

viewStock() async{

  Get.to(() =>const SetStockPage());

}
partfunc() async{

  Get.to(() =>const SetPartPage());


}
partHistfunc() async{
  //(await Get.put(ParticipatedQuery()).getCountParticipateEventOnline(Participated(uidUser:"${(Get.put(CardQuery()).obj)["resultData"]["UserDetail"]["uid"]??'none'}")));

  Get.to(() =>const SetPartHistPage());


}
quickBoHistfunc() async{
  //(await Get.put(TopupQuery()).GetBalanceHist(Topups(uid:"${(Get.put(CardQuery()).obj)["resultData"]["UserDetail"]["uid"]??'none'}")));
  Get.to(() =>const SetQuickBoHistPage());

}
contactFunc() async{
  Get.to(() =>SetPage(dynamicMethod: () {
    return  const ContactComp();
  }),arguments:{
    "title":"Contacts",
  });
}
editCardfunc() async{
  Get.to(() =>const SetEditCardNoPage());
}

logout() async{
  Get.dialog(
    AlertDialog(
      title: const Text('Confirmation'),
      content: const Text('Do you Want to Logout?'),
      actions: [
        ElevatedButton(
          style: ElevatedButton.styleFrom(

            //primary: Colors.grey[300],
            backgroundColor: const Color(0xff9a1c55),
            elevation:0,
          ),
          onPressed: () async{
            //Get.put(HideShowState()).setHomenavigator(0);
            Get.put(HideShowState()).setHomenavigator(0);
            await Get.put(AdminQuery()).logout();

            Get.toNamed('/Login');
          },
          child: const Text('Yes'),
        ),
        ElevatedButton(
          onPressed: () {
            Get.back(); // close the alert dialog
          },
          child: const Text('Close'),
        ),
      ],
    ),
  );
}

withdrawBonusFunc(){
  Get.to(() =>const SetWithdrawBonusPage());
}
withdrawBalanceFunc(){
  Get.to(() =>const SetWithdrawBalancePage());
}







