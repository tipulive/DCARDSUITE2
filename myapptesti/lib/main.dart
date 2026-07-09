import 'dart:convert';
import 'dart:io';


import 'package:dio/dio.dart';
//import 'package:firebase_core/firebase_core.dart';

import 'package:flutter/material.dart';
import 'package:wakelock_plus/wakelock_plus.dart' show WakelockPlus;
import 'Pages/routes.dart';
import 'Utilconfig/ConstantClassUtil.dart';


import 'package:get/get.dart';


import 'Query/AdminQuery.dart';

//import 'api/firebaseApi.dart';
//import 'firebase_options.dart';



void main() async{
  /*this will make apps not going to sleep Mode*/

  WidgetsFlutterBinding.ensureInitialized();

  /*await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
 await FirebaseApi().initialize();*/

  WakelockPlus.enable();
  //i may add  Wakelock.disable(); // to make apps to go on sleep mode
  /*this will make apps not going to sleep Mode*/
  runApp(const MyApp());

}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {

    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Demo',
      initialRoute: '/',
      getPages: AppRoutes.routes,
      theme: ThemeData(
        // This is the theme of your application.
        //
        // Try running your application with "flutter run". You'll see the
        // application has a blue toolbar. Then, without quitting the app, try
        // changing the primarySwatch below to Colors.green and then invoke
        // "hot reload" (press "r" in the console where you ran "flutter run",
        // or simply save your changes to "hot reload" in a Flutter IDE).
        // Notice that the counter didn't reset back to zero; the application
        // is not restarted.
        //primarySwatch: Colors.blue,


      ),
      home: const MyHomePage(title: 'Demo Project'),
    );
  }
}


class MyHomePage extends StatefulWidget {

  const MyHomePage({super.key, required this.title});

  // This widget is the home page of your application. It is stateful, meaning
  // that it has a State object (defined below) that contains fields that affect
  // how it looks.

  // This class is the configuration for the state. It holds the values (in this
  // case the title) provided by the parent (in this case the App widget) and
  // used by the build method of the State. Fields in a Widget subclass are
  // always marked "final".

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();

}

class _MyHomePageState extends State<MyHomePage> {

  //AdminQuery adminStatedata=Get.put(AdminQuery());













  @override
  Widget build(BuildContext context)
  {


    //final UserQuery getdata = Get.find();

    //yourFunction();
    //ConnectivityResult connectivity;
    //return checkAuth();
    return Scaffold(
      body:  Center(
          child:Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Text(ConstantClassUtil.appVers),
              const Text("Welcome TO Our Shop"),
              Container(
                decoration: BoxDecoration(
                  color: Colors.white, // set background color
                  borderRadius: BorderRadius.circular(10.0), // set border radius if needed
                ),
                child: Image.asset(
                  'images/shop.png', // path to the image asset
                  width: 200, // set the width of the image
                  height: 200, // set how the image should fit inside the container
                ),
              ),
            ],
          )
      ),
    );



  }
  @override
  void initState()
  {
    super.initState();
    //getapi();
    checkAuth();
  }
  @override
  void dispose() {
    //WidgetsFlutterBinding.ensureInitialized();
    checkAuth();
    super.dispose();
  }

  checkAuth() async{
    await Future.delayed(const Duration(seconds: 3));
    if(await Get.put(AdminQuery()).auth()==0)//no data in localDb
        {
      //i will add full screen pics with delay

      Get.toNamed('/Login');
    }
    else{
      //i will add full screen pics with delay
      //print(await Get.put(AdminQuery()).obj["result"][0]["name"]);

      Get.toNamed('/home');
      //print(await Get.put(AdminQuery()).logout());

    }
    // print(await Get.put(AdminQuery()).obj);
    //Get.toNamed('/Login');




  }

  Future<bool> checkInternet() async {
    try {

      var response = await Dio().get('https://google.com/');
      if (response.statusCode == 200) {
        return true;
        //print(true);
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      return false;
      //print(false);
    }
  }
  apiPostData(apiData) async{
    try {

      var params =  {
        "item": "itemx",
        "onlineData":apiData,
        //"options": [1,2,3],
      };


      var url='http://10.0.2.2:8000/api/testPostData';
      var response = await Dio().post(url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {

        return response.data;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      return false;
      //print(false);
    }
  }
  apiGetData() async{
    try {
      // var url='https://dummyjson.com/products';
      var url='http://10.0.2.2:8000/api/testGetData';
      var response = await Dio().get(url);
      if (response.statusCode == 200) {

        return response.data;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      return false;
      //print(false);
    }
  }
  deleteData(String text) {
    //print(text);
  }

  insertData(String text) async{

  }
/* void _onQRViewCreated(QRViewController controller)
  {
    this.controller=controller;
    controller.scannedDataStream.listen((scanData) {
      setState((){
        result=scanData;
      });
    });
  }
  @override
 void dispose(){
    controller?.dispose();
    super.dispose();
  }*/





}