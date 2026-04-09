import 'package:dio/dio.dart';
import 'dart:convert';
import 'dart:io';
import 'package:sqflite/sqflite.dart';
import '../Utilconfig/ConstantClassUtil.dart';
import '../models/User.dart';
import '../models/CardModel.dart';
import '../models/Syncoff.dart';
import '../models/Syncon.dart';
import 'package:get/get.dart';
import '../Query/AdminQuery.dart';
import '../DatabaseHelper.dart';
import '../models/Admin.dart';
import '../Utilconfig/AppInfo.dart';

class CardQuery extends GetxController {
  AdminQuery adminStatedata = Get.put(AdminQuery());
  //first Step is to save user state after scanning card
  var store = 8.obs;
  Map<String, dynamic> obj = {
    "name": "name",
    "id": 1,
    "result": [
      {"id": 10}
    ],
  }.obs;

  getDataOnline(CardModel cardData) async {
    try {
      var params = {
        "carduid": cardData.uid,

        //"options": [1,2,3],
      };

      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];
      var url = "${ConstantClassUtil.urlLink}/testGetData";
      var response = await Dio().get(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {
        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";
        // updateCardState(response.data);
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      return false;
    }
  }

  getNumberDetailCardOnline(Admin adminData) async {
    try {
      var params = {
        "Ccode": adminData.Ccode, //ccode
        "phone": adminData.phone,

        //"options": [1,2,3],
      };

      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];
      var url = "${ConstantClassUtil.urlLink}/GetNumberDetail";
      var response = await Dio().get(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {
        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";
        // updateCardState(response.data);
        return response;
      } else {
        //return null;
        //print(false);
      }
    } catch (e) {
      throw Exception('Failed to load API data');
      //return false;
      //return false;
    }
  }

  getDetailCardOnline(CardModel cardData) async {
    try {
      var params = {
        "carduid": cardData.uid,

        //"options": [1,2,3],
      };

      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];
      var url = "${ConstantClassUtil.urlLink}/GetCardDetail";
      var response = await Dio().get(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
        }),
        queryParameters: params,
      );
      if (response.statusCode == 200) {
        // return (response.data).length;
        //updateEventState(response.data);
        //return "hello";
        // updateCardState(response.data);
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      return false;
    }
  }

  createAssignCardEventOnline(CardModel cardData, Admin adminData) async {
    //create user and Assign

    try {
      var params = {
        "name": adminData.name,
        "email": adminData.email ?? 'none',
        "Ccode": adminData.Ccode,
        "phone": adminData.phone,
        "initCountry": adminData.initCountry,
        "country": adminData.country,
        "password": adminData.password ?? 'none',
        //"carduid":"TEALTD_7hEnj_1672352175",
        "carduid": cardData.uid,
        "app_vers": AppInfo.version,
        "actionStatus": adminData.status ?? 'none'

        //"uid":"kebineericMuna_1668935593",//userid

        //"options": [1,2,3],
      };
      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];

      var url = "${ConstantClassUtil.urlLink}/CreateUserAssign";
      var response = await Dio().post(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
      return e;
    }
  }

  editAssignCardEventOnline(CardModel cardData, Admin adminData) async {
    //create user and Assign

    try {
      var params = {
        "app_vers": AppInfo.version,
        "uid": cardData.uid,
        "name": adminData.name,
     // "email":"on756@gmailvdvd.com",
        "email": adminData.email ?? 'none',
        "Ccode": adminData.Ccode,
        "phone": adminData.phone,

        "initCountry": adminData.initCountry,
        "country": adminData.country,
        "password": adminData.password ?? 'none',
        "status": adminData.status, //card or user edit
        "carduid": cardData.uid

        //"uid":"kebineericMuna_1668935593",//userid

        //"options": [1,2,3],
      };
      print(params);
      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];

      var url = "${ConstantClassUtil.urlLink}/EditUserAssign";
      var response = await Dio().post(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
          // HttpHeaders.authorizationHeader:"Bearer 259|bR1wtUu26VkiGlY49AF9UVW0xsxaykI5wHNhiNl6"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
    }
  }

  deleteUserAssignCardEventOnline(CardModel cardData, Admin adminData) async {
    //create user and Assign

    try {
      var params = {
        "app_vers": AppInfo.version,
        "uid": adminData.uid

        //"uid":"kebineericMuna_1668935593",//userid

        //"options": [1,2,3],
      };
      String authToken = (adminStatedata.obj)["result"][0]["AuthToken"];

      var url = "${ConstantClassUtil.urlLink}/DeleteUserAssign";
      var response = await Dio().post(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authToken"
          // HttpHeaders.authorizationHeader:"Bearer 259|bR1wtUu26VkiGlY49AF9UVW0xsxaykI5wHNhiNl6"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
    }
  }

  assignCardEventOnline(CardModel cardData, Admin adminData) async {
    //when you were registered before by assign with u with new card

    try {
      var params = {
        "Ccode": "+250",
        "phone": "0782389359", //phone
        "carduid": cardData.uid
        //"options": [1,2,3],
      };
      String authtoken = (adminStatedata.obj)["result"][0]["AuthToken"];

      var url = "${ConstantClassUtil.urlLink}/AssignCard";
      var response = await Dio().post(
        url,
        options: Options(headers: {
          HttpHeaders.contentTypeHeader: "application/json",
          HttpHeaders.authorizationHeader: "Bearer $authtoken"
        }),
        data: jsonEncode(params),
      );
      if (response.statusCode == 200) {
        return response;
      } else {
        return false;
        //print(false);
      }
    } catch (e) {
      //return false;
    }
  }

  Future synCardUpdated(CardModel cardData, Syncon syncondata) async {
    //select *from table where SyncAdd="new"

    if (((await adminStatedata.auth()).length) > 0) {
      Database db = await DatabaseHelper.instance.database;

      int count = await db.rawUpdate(
          //here is to update status to On where there is status Default
          'UPDATE Syncon SET versionCount="${(syncondata.result)["remainUploaded"]}" WHERE tablename= ? and actionName=? ',
          ['cards', 'add']);

      if ((count) > 0) {
        var check = 0;
        for (var i = 0; i < ((syncondata.result).length); i++) {
          //print((await apiData())["products"][i]["title"])

          int count2 = await db.rawUpdate(
              //here is to update status to On where there is status Default
              'UPDATE cards SET Syncadd="uploaded" WHERE uid= ? ',
              ['${(syncondata.result)["result"][i]["uid"]}']);

          //return count2;
          check += count2;
        }
        if (check == (syncondata.result).length) {
          return "done";
        }
      }
    }
  }

  Future syncOffCardDownload(CardModel cardData, Syncoff syncoffdata) async {
    //not done
    if (((await adminStatedata.auth()).length) > 0) {
      Database db = await DatabaseHelper.instance.database;
      int t1 = 0;
      await db.transaction((txn) async {
        int id1 = await txn.rawInsert(
            'INSERT INTO cards(uid,uidCreator,subscriber,uidCreatorOnline,subscriberOnline,SyncAdd) VALUES("${cardData.uid}","${(adminStatedata.obj)["result"][0]["uid"]}","${(adminStatedata.obj)["result"][0]["subscriber"]}","${cardData.uidCreator}","${cardData.subscriber}","download")');

        t1 = id1;
      });
      if (t1 > 0) {
        int t2 = 0;
        await db.transaction((txn) async {
          int id2 = await txn.rawInsert(
              'INSERT OR REPLACE INTO Syncoff(uid,versionCount,subscriber,actionName,tableName) VALUES("${syncoffdata.uid}","${syncoffdata.VersionOnline}","${cardData.subscriber}","add","cards")');

          t2 = id2;
        });

        return t2;
      }
      // print(t1);
    }
  }

  syncOffCardAdd() async {
    //this is every time you will add new user

    //

    Database db = await DatabaseHelper.instance.database;

    //Add Process

    int t1 = 0;
    await db.transaction((txn) async {
      int id1 = await txn.rawInsert(
          'INSERT INTO cards(uid,uidCreator,subscriber) VALUES("uniqueID","kebineericMuna_1668935525","TEALTD")');

      t1 = id1;
    });

    if (t1 >= 1) {
      int t2 = 0;
      await db.transaction((txn) async {
        int id2 = await txn.rawInsert(
            'INSERT INTO Syncon(uid,versionCount,subscriber,actionName,tableName) VALUES("uniqueCard",1,"TEALTD","add","users")');

        t2 = id2;
      });
      return t2;
    }
  }

  Future addData(User userdata) async {
    if (((await adminStatedata.auth()).length) > 0) {
      Database db = await DatabaseHelper.instance.database;

      int t1 = 0;
      await db.transaction((txn) async {
        int id1 = await txn.rawInsert(
            'INSERT INTO users(uid,carduid,name,phone,email,photo_url,uidCreator,subscriber) VALUES("${userdata.uid}","${userdata.carduid}","${userdata.name}","${userdata.phone}","email","photo_url","${(adminStatedata.obj)["result"][0]["uid"]}","${(adminStatedata.obj)["result"][0]["subscriber"]}")');

        t1 = id1;
      });

      return t1;
    }
  }

  getCardSearch(CardModel cardData) async {
    //search User with uid and get userDetails here i will add my authentication Details here uid is card ui

    Database db = await DatabaseHelper.instance.database;
    List<Map> list = await db.rawQuery(
        "Select *from cards where SyncAdd='new' limit '${cardData.uid}'"); // here i will assign card.id with syncoff verisonCount
    if ((list.length) > 0) {
      //there is user associated with this Account
      // updateState();
      //updateCardState(list);
      return list;
    } else {
      return list.length;
    }
  }

  getCard(CardModel cardData) async {
    //search User with uid and get userDetails here i will add my authentication Details here uid is card ui

    Database db = await DatabaseHelper.instance.database;
    List<Map> list = await db
        .rawQuery("Select *from cards where uid='${cardData.uid}' limit 1");
    if ((list.isNotEmpty)) {
      //there is user associated with this Account
      // updateState();
      //updateCardState(list);
      return list;
    } else {
      return list.length;
    }
  }

  updateCardState(list) {
    //save user
    //store.value=7;
    obj = {"id": 4, "resultData": list};
    update();
  }

  getMyData() async {
    Database db = await DatabaseHelper.instance.database;
    List<Map> list = await db.rawQuery('select *from groceries');
    return list;
  }

  //
  Future<List<User>> getGroceries() async {
    Database db = await DatabaseHelper.instance.database;
    var groceries = await db.query('groceries', orderBy: 'name');
    List<User> userList = groceries.isNotEmpty
        ? groceries.map((c) => User.fromMap(c)).toList()
        : [];
    return userList;
  }

  Future<int> add(User userdata) async {
    Database db = await DatabaseHelper.instance.database;
    return await db.insert('groceries', userdata.toMap());
  }

  Future<List<User>> getData() async {
    Database db = await DatabaseHelper.instance.database;
    var groceries = await db.rawQuery('SELECT *FROM groceries');
    List<User> userList = groceries.isNotEmpty
        ? groceries.map((c) => User.fromMap(c)).toList()
        : [];
    return userList;
  }

  testdata(User userdata) async {
    Database db = await DatabaseHelper.instance.database;
    //await db.rawQuery('INSERT INTO groceries(name) VALUES("${Userdata.name}")');
    int t1 = 0;
    await db.transaction((txn) async {
      int id1 = await txn
          .rawInsert('INSERT INTO groceries(name) VALUES("${userdata.name}")');

      t1 = id1;
    });
    return t1;
  }
}
