import 'package:flutter/material.dart';
import 'package:get/get.dart';
//this is to manipulate list of text to know each one this is reusable one
class TextListController extends GetxController {
  // A Map to store controllers using the Unique ID (uidOwner) as the key
  final Map<String, TextEditingController> _controllers = {};
  List<dynamic> users = [];
  List<dynamic> deptHist = [];
  List<dynamic> deptDetailHist = [];
  List<dynamic> paidHist = [];
   bool dialog=false;
  RxMap<String, bool> btnHideMap = <String, bool>{}.obs;

  // This helper gets (or creates) a controller for a specific UID
  TextEditingController getController(String uid) {
    if (!_controllers.containsKey(uid)) {
      _controllers[uid] = TextEditingController();
    }
    return _controllers[uid]!;
  }
  void openDialog() {
    dialog = true;
    update();
  }

  void closeDialog() {
    dialog = false;
    update();
  }
  void setUsers(List<dynamic> newUsers) {
    users = newUsers;
    update(); // refresh UI
  }
  void setDeptHist(List<dynamic> newDeptHist) {
    deptHist = newDeptHist;
    update(); // refresh UI
  }
  void setDeptDetailHist(List<dynamic> newDeptDetailHist) {
    deptDetailHist = newDeptDetailHist;
    update(); // refresh UI
  }

  void setPaidtHist(List<dynamic> newPaidHist) {
    paidHist = newPaidHist;
    update(); // refresh UI
  }
  @override
  void onClose() {
    // Clean up all controllers when this screen is destroyed
    for (var c in _controllers.values) {
      c.dispose();
    }
    _controllers.clear();
    super.onClose();
  }
}