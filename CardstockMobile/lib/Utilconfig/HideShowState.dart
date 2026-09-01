import 'package:get/get.dart';

class HideShowState extends GetxController{

  var isVisible=false.obs;
  var isCameraVisible=true.obs;
  var isNumberValid=false.obs;
  var isNumber=true.obs;
  var profVisible=false.obs;
  var defaultInterest=5.obs;
  var homenavigator=0.obs;
  var profilenavigator=0.obs;
  var currentTabIndex = 0.obs;

  //var delivery=0.obs;
  /*final delivery = [
    {
      "totalCount": "Unknown",
      "uid": "test"
    }
  ].obs;*/
  final dynamicList =[].obs;
  final delivery=[];
  int indexCountData=0;
  trackIndex(valData){
    indexCountData=valData;
    update();
  }


  isDelivery(valData)
  {


   delivery.clear();

    delivery.addAll(valData);
update();



  }
  void setCurrentTabIndex(int index) {
    currentTabIndex.value = index;
  }
  isHideDelivery(indexData,numb){
    for (int i = 0; i < delivery.length; i++) {
      delivery[i]["hideAddCart"] =0;
    }

    delivery[indexData]["hideAddCart"]=numb;
    update();
  }
  isChangeDelivery(indexData,valData,qty_product,){
    delivery[indexData]["${valData}"]="${qty_product}";

    update();
  }
  isHiden(valData){
    isVisible.value=valData;
  }
  isCameraHiden(valData){
    isCameraVisible.value=valData;
  }
  isValid(valData){
    isNumberValid.value=valData;
    update();
  }
  isNumberCorrect(valData){
    isNumber.value=valData;
  }
  isprofileVisible(valData){
    profVisible.value=valData;
  }
  setDefaultInterest(valData){
    defaultInterest.value=valData;
  }

  setHomenavigator(valData){
    homenavigator.value=valData;
  }
  setProfilenavigator(valData){
    profilenavigator.value=valData;
  }


}