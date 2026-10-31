<script>

var trueV='true';
var falseV='false';
var orderId="";
var total_amount="0";
var custom_total="0";
var remain_custom_total="0";
var custom_another_currency="FC";
var custom_currency="0";
var return_paid="0";
var dollarPaid="0";
var toUsd="0";
var inputDataDollar="0";
var image_list=[];
var preview_list=[];
var MyUserid="none";
var chooseSearchBy="1";
var choose1=1;
var choose2=2;

var Myname="none";
var parantesis=")";
var platform="";
var userProfileName="";
var CalculateDeclClass="";
var countryComeFrom="all";
 var chooseSearchStock=1;

function LoadSettingComeFrom(){

var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


return $.ajax({

url:`./api/AdminProductComeFrom`,
type:'get',
headers: {
"Content-Type": "application/json;charset=UTF-8",
"Authorization": `Bearer ${Usertoken}`
},
success:function(data){
if(data.status){//return data as true




$('.cover-spin').hide();


}
else{

$('.cover-spin').hide();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});


}
async function selectComeFrom(){
    let mydata=await LoadSettingComeFrom();

    var data=mydata.result;
    getData=`<option value="all">All</option>`;
    for(var i=0;i<data.length;i++){
    getData+=`<option value="${data[i].id}">${data[i].comeFrom}</option>`;
}
$(`.catComeFrom`).html(getData);

    $(`.catComeFrom option[value="${countryComeFrom}"]`).attr("selected",true);
}
function resetSettingMenu(){//when i go to another Menu just reset all settings
    countryComeFrom="all";
}
function ComeFromProduct(){
    countryComeFrom=$('.catComeFrom option:selected').val();
    ViewAllProducts();
}
function ViewAllProducts(){
    var chooseSearchBy="1";
    var ClassfieldName="searchProductTable";
$('.MainbigTitle').html("");

    closeNav();
    @include('components.Search.Search.SearchStockTable')
    selectComeFrom();
//
$('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminViewAllProduct`,
type:'get',
data:{countryComeFrom:countryComeFrom},

headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },

success:function(data){


if(data.status){//return data as true
    $('.cover-spin').hide();
    var data=data.result;

    getData=`

 <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Code</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Qty</th>

      <th scope="col">Qty Left</th>
      <th scope="col">From</th>
      <th scope="col">Created</th>
    </tr>
  </thead>
 `;

 for(var i=0;i<data.length;i++){
    //it means that on receiv show Dispatch else show Received
    tags=data[i].tags===null?'N/A':data[i].tags;
     getData+=` <tr>
      <td data-label="#">${i+1}</td>
      <td data-label="Code">${data[i].productCode}</td>
      <td data-label="Name">${tags}</td>
      <td data-label="Price">${data[i].price}</td>
      <td data-label="qty">${data[i].qty}</td>

      <td data-label="Qty_left">${parseInt(data[i].qty)-parseInt(data[i].qty_sold)}</td>
      <td data-label="From">${data[i].catName}</td>
      <td data-label="Created_at">${data[i].created_at}</td>

    </tr>`;

 }
 $('.MyRequest_table').html(getData);

}
else{
$('.MyRequest_table').html("");
$('.cover-spin').hide();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;

}
function UpdateProfileMenu(){

    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
closeNav();
    var Usertoken=localStorage.getItem("Usertoken");

//
$.ajax({

url:`./api/view`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
success:function(data){
if(data.result){//return data as true

//var websiteName = window.location.hostname;
var webLink = window.location;
var protocol=webLink.protocol;
var websiteName=(webLink.hostname==='localhost')?webLink.host:window.location.hostname;

    $('.MainForm').html(`

<div class="input-group mb-3">
<input type="text" class="form-control linkCopy" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" value="${protocol}//${websiteName}/${data.response.link}">
<div class="input-group-append" >
<button class="btn btn-outline-secondary" id="copy-link-btn" type="button" onclick="return onCopy()">Copy</button>
</div>
</div>
<h5 class="text-center">Update Profile</h5>

<form class="formData"  enctype="multipart/form-data">
<div class="form-group">
<label>Name</label>
<input type="text" class="form-control" name="name" value="${data.response.name}"/>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" class="form-control" name="password" />
</div>

<div class="form-group">
<label>CompanyName</label>
<input type="text" class="form-control" name="name" value="${data.response.companyName}" disabled/>
</div>
<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return update_profile()" value="submit" />
</div>


</form>
`);




}
else{

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});





}
function update_profile(){
//
$('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/update`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formData').serialize(),
/*headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },*/
success:function(data){



    if(data.status)
    {
        userProfileName=data.userProfileName;
        console.log(data.userProfileName);
//
$('.cover-spin').hide();
alert("profile updated successfully");

    }
    else{
        $('.cover-spin').hide();
    }
    //console.log(platform);




},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
}
//

function logout(){
    var Usertoken=localStorage.getItem("Usertoken");

    //
    $.ajax({

url:`./api/logout`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
success:function(data){
if(data.status){//return data as true

   /* if(platform==='Super')
   {
    window.location.href="adminlogin";
   }
   else{
    window.location.href="userlogin";
   }*/
   window.location.href="/";
//console.log("logout");




}
else{
    $('.search_append').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//

    //
}

function EmptyautoCompleteFacture(){
    $('.autoCompleteFacture').html("");
    $('.autoCompleteFacture').hide();
    $('.autocompleteFactureIcon').html("");
}

function autoCompleteFacture(thisdata){
//

if(thisdata.value=="") return EmptyautoCompleteFacture();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SearchFacture`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    ItemName:thisdata.value,
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteFacture').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" >
    ${data[i].uid}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteFacture').html(getdata);
 //$(`.autocompleteIcon`).html(`<i class="fa fa-times-circle text-danger" onclick="return EmptyautoCompleteTopItem()"></i>`);
 $(`.autocompleteFactureIcon`).html(`<i class="fa fa-times-circle text-danger mylogout" onclick="return EmptyautoCompleteFacture()"></i>`);



}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    //$(`.autocompleteFactureIcon`).html(`<i class="fa fa-times-circle text-danger mylogout" onclick="return EmptyautoCompleteFacture()"></i>`);
    EmptyautoCompleteFacture();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
//
}

function createFucture(){
    //$('.MyRequest_table').html("");
//$(".MainbigTitle").html("");
closeNav();
    $('.MainForm').html(`
<div class="form-group d-none">
<input type="hidden" class="form-control useridAccount" name="userid" placeholder="Enter Order Ref">
<label for="">Enter Ref</label>
<input type="text" class="form-control "  placeholder="Enter Order Ref">



</div>



<div class="input-group mb-3 pt-3">
  <input type="text" class="form-control ref" name="ref" placeholder="Enter Fact No" aria-label="Recipient's username" aria-describedby="basic-addon2" onkeyup="autoCompleteFacture(this)">

  <div class="prelative">
        <span class="autocompleteFactureIcon"></span>
    </div>
  <ul class="list-group  autoCompleteFacture">

</ul>
  <div class="input-group-append">
  <button class="btn btn-outline-dark" type="button" onclick="return create_order()">Create Facture</button>
  </div>



</div>

`);

}
function create_order(){
//
$('.MyRequest_table').html("");
$(".MainbigTitle").html("");
/*$(".MainForm").html("");*/
var ref=$('.ref').val();
//var useridAccount=$('.useridAccount').val();
var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/CreateOrder`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
uid:ref,
userid:MyUserid,
},
/*headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },*/
success:function(data){

    platform=data.platform;
    userProfileName=data.name;
    console.log(data);
    if(checkPlatform(platform))
    {
//
if(data.result==='none')
    {
        $('.cover-spin').hide();
//Display create Orders

createFucture();


    }
    else if(data.status==='1'){
        alert("Order Exist,please Create new One");
    }
    else if(data.status==='2'){
        //console.log(data.myresult[0]);
        if(confirm(`You Can not Create ${Myname} Order,Please Submit First ${data.myresult[0].name} Order` ))
        {
            UserAddInvoice(data.myresult[0].userid,data.myresult[0].name);
        }

    }
  else{


        ViewSearchForm();
        $('.orderId').html(`
    Order Id:${data.result}<span class="text-danger" onclick="return DeleteOrder('${data.result}')"><i class="fas fa-trash"></i>
</span>
    <input type="text" class="form-control d-none" id="OrderId" value="${data.result}">
    `);
    orderId=data.result;


    }
//
    }
    else{

    }
    //console.log(platform);




},
error:function(data){
    alert("Something Wrong With Your Account Please Contact System Admin");
    logout();
    //alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
}
//
function ViewSearchForm(){
    closeNav();
    var choose1=1;
    var choose2=2;
    var ClassfieldName="SearchProduct";
    $('.MainForm').html(`



    <h5 class="text-center mainTitle"></h5>
    <div class="main-card mb-3 card p-4">
<form class="Form_order">
            <!--My Form-->
            <div class="AccountTitle"></div>
            <div class="float-right">
            <h6 class="text-danger total_amount"></h6>
            <h6 class="text-danger Custom_total_amount"></h6>
            </div>
<h5 class="title text-center orderId"></h5>
<div class="form-group d-none">
<label for="">Enter Client name</label>
<input type="text" class="form-control SearchByContactName"  onkeyup="return  SearchByContactName(this)">
<ul class="list-group SearchByContactName_append"></ul>
<input type="hidden" name="clientId" class="form-control clientId" >

</div>

<div class="form-group d-none">
<input type="hidden" class="form-control useridAccount" name="userid" value="${MyUserid}" placeholder="Enter Order Ref">
<label for="">Enter Ref</label>
<input type="text" class="form-control "  placeholder="Enter Order Ref">


</div>



<div class="input-group mb-3 d-none">
  <input type="text" class="form-control ref" name="ref" placeholder="Enter Fact No" aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append">

    <button class="btn btn-outline-dark" type="button" onclick="return create_order()">Create Facture</button>
  </div>
</div>


<div class="form-group">

    <label for="">Search Your Product<span class="text-danger">*</span></label>
    <div class="input-group mb-3 ">
  <div class="input-group-prepend">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Seach By</button>
    <div class="dropdown-menu">
    <a class="dropdown-item" href="#SearchByCode" onclick="return chooseSearch('${choose1}','${ClassfieldName}')">Code</a>
      <a class="dropdown-item" href="#SearchByName" onclick="return chooseSearch('${choose2}','${ClassfieldName}')">name</a>
    </div>
  </div>

  <input type="text" class="form-control SearchProduct" placeholder="Search by Code" aria-label="Text input with dropdown button"  onkeyup="return searchProduct(this)">
</div>
<input type="hidden" class="form-control"  onkeyup="return searchProduct(this)">
<input type="hidden" class="form-control" id="nappi_code" name="product_id">

<div class="container mt-1 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-12 search_append">



        </div>
    </div>
</div>

<div class=" mt-1 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-12 display_order">



        </div>
    </div>
</div>

<div class="float-right d-none">
<div class="list-group" id="myList" role="tablist">
  <a class="list-group-item list-group-item-action bg-primary  text-white" data-toggle="list" href="#home" role="tab"><span class="Custom_total_amount"></span>

  </a>
  <a class="list-group-item list-group-item-action bg-primary text-white" data-toggle="list" href="#home" role="tab">Remain:<span class="remain_custom_total"></span>

  </a>
  <a class="list-group-item list-group-item-action" data-toggle="list" href="#profile" role="tab">
  Paye $:<input type="text" id="paye_dollar" class="form-control" value="1" placeholder="" name="custom_paid_dollars" onchange="return payeDollar(this)" onkeyup="return payeDollar(this)"></a>
  <a class="list-group-item list-group-item-action" data-toggle="list" href="#messages" role="tab">
  Paye FCS=$<span class="toUsd"></span>:<input type="text" id="paye_otherCurrency" name="custom_another_currency" class="form-control" value="1" placeholder="" onchange="return payeOtherCurrency(this)" onkeyup="return payeOtherCurrency(this)"></a>
  <input type="hidden" value="FC" name="custom_currency">
  </a>
  <a class="list-group-item list-group-item-action" data-toggle="list" href="#messages" role="tab">
  Paye Back:$<span class="payback"></span>
  <input type="hidden" class="payback" name="return_paid" value="0"/>
  </a>
  <a class="list-group-item list-group-item-action" data-toggle="list" href="#settings" role="tab">
  <button class="btn btn-success btn-sm" type="button" onclick="return SubmitOrder();">Submit Order</button>
  </a>
</div>
</div><br>

</div>
<!--search Form -->
</form>
            <!--My Form-->
        </div>
    `);
    display_order();
}

function checkNoCompleteOrder(){

}

function display_order(){
//
$('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/DisplayAddedOrder`,
type:'get',
data:{
userid:MyUserid,
},
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    total_amount=data.total[0].total;
    custom_total=data.total[0].custom_total;


    $('.total_amount').html(`

    <input type="hidden" name="total" value="${total_amount}"/>
    `);
    $('.Custom_total_amount').html(`
    <span>Total:${custom_total}</span>
    <input type="hidden" name="custom_total" value="${custom_total}"/>

    `);
    $('.orderId').html(`
    Order Id:${data.orderId}
    <input type="text" class="form-control d-none" name="uid" id="OrderId" value="${data.orderId}">
    `);
    var totalColi=0;
    var data=data.result;
 var getdata=`<h6 class="text-center">Order List</h6>
 <ul class="list-group pt-3 displayViewAll">
<li class="list-group-item bg-dark text-white">ORDER LIST <span class=" float-right"><span class="text-success">Qty:</span><span class="totalqtycoli"></span></span></li>
 `;
 for(var i=0;i<data.length;i++){
    var trackInput=`disp_${data[i].id}`;
var add_qtyId=`qty_${trackInput}`;
var addCustom_priceId=`CustomPrice_${trackInput}`;
var addCustom_total=`CustomTotal_${trackInput}`;
totalColi+=parseInt(data[i].qty);
    getdata+=`
    <li class="list-group-item"><span>${i+1}${parantesis}</span>  <span class="Formchange" id="${add_qtyId}"
  contenteditable="true" onchange="return EditProduct('${data[i].productCode}','${data[i].price}','${trackInput}')"
  onkeyup="return EditProduct('${data[i].productCode}','${data[i].price}','${trackInput}')">${data[i].qty}</span> ${data[i].productCode} X <span id="${addCustom_priceId}" onchange="return EditProduct('${data[i].productCode}','${data[i].price}','${trackInput}')" onkeyup="return EditProduct('${data[i].productCode}','${data[i].price}','${trackInput}')">${data[i].price}</span>=$<span id="${addCustom_total}">${data[i].custom_total}</span>  <span class="btn btn-danger btn-sm float-right" type="button" onclick="return DeleteAddedProduct('${data[i].productCode}','${data[i].price}','${trackInput}');"><i class="fas fa-trash"></i></span></li>

    `;

 }
 getdata+=`
 </ul>
 <div class="text-center">
    <div class="form-group pt-1">
 <button class="btn btn-success btn-lg " type="button" onclick="return SubmitOrder();">Submit Order</button>
 </div>
</div>`;

 $('.display_order').html(getdata);
 $('.totalqtycoli').text(totalColi);



}
else{
    $('.cover-spin').hide();
    $('.display_order').html("");
    total_amount=0;
    custom_total=0;

    $('.total_amount').html("");
$('.Custom_total_amount').html("");

$('.orderId').html(`
    Order Id:${orderId}<span class="text-danger" onclick="return DeleteOrder('${orderId}')"><i class="fas fa-trash"></i>
</span>
    <input type="text" class="form-control d-none" name="uid" id="OrderId" value="${orderId}">
`);

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;
//
}

function chooseSearchDate(classfieldName)
{

    $(`.${classfieldName}`).addClass('SearchDate');
    $(`.${classfieldName}`).attr("placeholder",`Enter Search By Date`);
    $(`.${classfieldName}`).removeAttr("onkeyup",`searchProductEditTable(this)`);
    $(`.${classfieldName}`).attr("onchange",`return SearchDateChange(this)`);

    $('.SearchDate').flatpickr(
    {

    dateFormat: "Y-m-d ",
}
);

}
function chooseSearch(thisdata,classfieldName)
{

    $(`.${classfieldName}`).val("");
    $('.SearchDate').flatpickr( //disable open calendar
    {

        altInput: true, clickOpens: false
}
);
    $(`.${classfieldName}`).removeClass('flatpickr-input');
    $(`.${classfieldName}`).removeAttr("readonly",'readonly');
    $(`.${classfieldName}`).attr("onkeyup",`return searchProductEditTable(this)`);
    $(`.${classfieldName}`).removeAttr("onchange",`SearchDateChange(this)`);

    //flatpickr-input
    chooseSearchBy=thisdata;
    $searchType=thisdata==='1'?'Code':'Name';
    $(`.${classfieldName}`).attr("placeholder",`Enter Search By ${$searchType}`);


    //console.log(thisdata);
}
function searchProduct(thisdata){

if(orderId!=""){
    GetProduct(thisdata);
}
else{
    GetProduct(thisdata);
    create_order();
}
}

function emptySearchAppend(){
    $('.search_append').html("");
}
function GetProduct(thisdata){
if(thisdata.value=="") return emptySearchAppend();
//

searchProd=chooseSearchBy==='1'?'SearchByProduct':'SearchByTags';//first is search by code second by tags
console.log(chooseSearchBy);
var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/${searchProd}`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    productCode:thisdata.value,
},
success:function(data){
if(data.status){//return data as true



var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){
     var trackInput=`Add_${data[i].id}`;
var add_qtyId=`qty_${trackInput}`;
var addCustom_priceId=`CustomPrice_${trackInput}`;
var addCustom_total=`CustomTotal_${trackInput}`;
var DisCommonName=chooseSearchBy==='1'?'':`<li class="list-group-item bg-dark text-white" aria-current="true">
${data[i].tags}
  </li>`;
    getdata+=`
    <ul class="list-group">
    ${DisCommonName}
  <li class="list-group-item bg-primary text-white" aria-current="true">
  Qty-Left:${parseInt(data[i].qty)-parseInt(data[i].qty_sold)}
  <button class="btn btn-success btn-sm float-right" type="button" onclick="return addProduct('${data[i].productCode}','${data[i].price}','${trackInput}');">Add item</button>
  </li>

  <li class="list-group-item"><span class="Formchange" id="${add_qtyId}"
  contenteditable="true" onchange="return EditSearchProduct('${data[i].productCode}','${data[i].price}','${trackInput}')"
  onkeyup="return EditSearchProduct('${data[i].productCode}','${data[i].price}','${trackInput}')">1</span> ${data[i].productCode} <span class="text-danger">X</span> <span id="${addCustom_priceId}" onchange="return EditSearchProduct('${data[i].productCode}','${data[i].price}','${trackInput}')" onkeyup="return EditSearchProduct('${data[i].productCode}','${data[i].price}','${trackInput}')">${data[i].price}</span> <i class="fas fa-caret-down mylogout text-danger"  onclick="return ChoosePriceProduct('${data[i].productCode}','${data[i].price}','${trackInput}')"></i>=$<span id="${addCustom_total}">${parseInt(data[i].price)}</span></li>

</ul>
<hr>
    `;

 }

 $('.search_append').html(getdata);



}
else{
    $('.search_append').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
}
function ViewContactId(clientId,clientName)
{
    $('.clientId').val(clientId);
    $('.SearchByContactName').val(clientName);
    $('.SearchByContactName_append').html("");
}

function SearchByContactName(thisdata){
if(thisdata.value=="") return $('.SearchByContactName_append').html("");
//
var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SearchByContactName`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    contactName:thisdata.value,
},
success:function(data){
if(data.status){//return data as true



var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item" onclick="return ViewContactId('${data[i].ContactId}','${data[i].name}')">${data[i].name}</li>
    `;

 }

 $('.SearchByContactName_append').html(getdata);



}
else{
    $('.SearchByContactName_append').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
}

function check_price_qty(add_qtyValue,addCustom_priceValue,price){
    if(add_qtyValue!='' && addCustom_priceValue!='' && (parseInt(addCustom_priceValue)>=parseInt(price)))
    {
        return true;
    }
    else{
        return false;
    }
}
function ChoosePriceProduct(productCode,price,trackInput)
{
   $('.cover-spin').show();
    $('.viewReqTable').hide();
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">  <strong>${productCode} Price List</strong></h5> `);

    var Usertoken=localStorage.getItem("Usertoken");
    $.ajax({

url:`./api/searchPreviousPrice`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    productCode:productCode,

},
success:function(data){
if(data.status){//return data as true
    var data=data.result;
 var getdata=`
 <div class="ResultList"></div>
 <div class="form-check"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="${trackInput}" value="${price}" onclick="ChangePrice('${productCode}',this,'${trackInput}')" >
  <label class="form-check-label text-danger" for="inlineRadio1">${price}</label> </div>`;
 for(var i=0;i<data.length;i++){
    var pricehide=price==data[i].price?'hidden':'radio';
    var Vlhide=price==data[i].price?'d-none':'';
    getdata+=`<div class="form-check"><input class="form-check-input" type="${pricehide}" name="inlineRadioOptions" id="${trackInput}" value="${data[i].price}" onclick="ChangePrice('${productCode}',this,'${trackInput}')">
  <label class="form-check-label ${Vlhide}" for="inlineRadio1">${data[i].price}</label> </div>`;



 }


$('.ModalProductList').html(getdata);

var add_qtyValue=$(`#qty_${trackInput}`).text();
var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();
 $('.ResultList').html(`<strong class="d-flex justify-content-center">${add_qtyValue}    <span class="text-danger">X</span>    ${addCustom_priceValue} = ${parseInt(add_qtyValue)*parseInt(addCustom_priceValue)}</strong><hr>`);
 $('.cover-spin').hide();

}
else{
//
$('.cover-spin').hide();
$('.ModalProductList').html(`Sorry Price List of ${productCode} Is empty`);
//

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
}
function ChangePrice(productCode,thisdata,trackInput)
{
console.log(thisdata.value);



var add_qtyValue=$(`#qty_${trackInput}`).text();
var addCustom_priceValue=thisdata.value;
$(`#CustomPrice_${trackInput}`).text(thisdata.value);
if(add_qtyValue<1)return $(`#qty_${trackInput}`).text("");

if(check_price_qty(add_qtyValue,addCustom_priceValue,thisdata.value))
{

    $(`#CustomTotal_${trackInput}`).text(parseInt(add_qtyValue)*parseInt(addCustom_priceValue));
$('.ResultList').html(`<strong class="d-flex justify-content-center">${add_qtyValue}    <span class="text-danger">X</span>    ${addCustom_priceValue} = ${parseInt(add_qtyValue)*parseInt(addCustom_priceValue)}</strong><hr>`);

}

return false;

}
function EditSearchProduct(productCode,price,trackInput)
{
    console.log(`product code:${productCode},price:${price},track=${trackInput}`);

    var add_qtyValue=$(`#qty_${trackInput}`).text();
    var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();
    if(add_qtyValue<1)return $(`#qty_${trackInput}`).text("");

    if(check_price_qty(add_qtyValue,addCustom_priceValue,price))
    {

        $(`#CustomTotal_${trackInput}`).text(parseInt(add_qtyValue)*parseInt(addCustom_priceValue));
    }

return false;
}
function addProduct(productCode,price,trackInput){
    var OrderId=$('#OrderId').val();
    var add_qtyValue=$(`#qty_${trackInput}`).text();
    var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();

    var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
  // if(check_price_qty(add_qtyValue,addCustom_priceValue,price))
   if(check_price_qty(add_qtyValue,addCustom_priceValue,addCustom_priceValue))
    {
        $.ajax({

url:`./api/AddOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:OrderId,
    productCode:productCode,
    //price:price,
    price:addCustom_priceValue,
    userid:MyUserid,
    qty:add_qtyValue,
    custom_price:addCustom_priceValue,
},
success:function(data){
if(data.status){//return data as true

display_order();
$('.search_append').html("");


}
else{
//
if(confirm(`${productCode} exist,Are you sure you want to add ${add_qtyValue} more ?`))
    {
        forceAddProduct(productCode,price,trackInput);
        //EditProduct(productCode,price,trackInput);
    }
//

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    }
    else{
        alert("please fill quantity and price");
    }

    return false;



}
function forceAddProduct(productCode,price,trackInput){
//

var OrderId=$('#OrderId').val();
    var add_qtyValue=$(`#qty_${trackInput}`).text();
    var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();

var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/ForceAddedOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:OrderId,
    productCode:productCode,
    price:price,
    qty:add_qtyValue,
    userid:MyUserid,
    custom_price:addCustom_priceValue,
},
success:function(data){
if(data.status){//return data as true

display_order();

$('.search_append').html("");

}
else{


}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
//

}

function EditProduct(productCode,price,trackInput)
{
    //
    var OrderId=$('#OrderId').val();
    var add_qtyValue=$(`#qty_${trackInput}`).text();
    var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();

    if(add_qtyValue<1)return $(`#qty_${trackInput}`).text("");
    if(addCustom_priceValue<price) return 0;
    if(check_price_qty(add_qtyValue,addCustom_priceValue,price))
    {
        console.log("done");
        var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/EditAddedOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:OrderId,
    productCode:productCode,
    price:price,
    qty:add_qtyValue,
    userid:MyUserid,
    custom_price:addCustom_priceValue,
},
success:function(data){
if(data.status){//return data as true

display_order();



}
else{

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    }

    return false;
    //
}


function DeleteAddedProduct(productCode,price,trackInput)
{
    //
    if(confirm(`Are you Sure you want to delete this ${productCode}`))
    {
        var OrderId=$('#OrderId').val();
    var add_qtyValue=$(`#qty_${trackInput}`).text();
    var addCustom_priceValue=$(`#CustomPrice_${trackInput}`).text();

    var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/DeleteAddedOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:OrderId,
    productCode:productCode,
    price:price,
    qty:add_qtyValue,
    userid:MyUserid,
    custom_price:addCustom_priceValue,
},
success:function(data){
if(data.status){//return data as true

display_order();

$('.search_append').html("");

}
else{

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    }

    return false;
    //
}

function DeleteOrder(OrderId){
    if(confirm(`Are you Sure you want to delete this order ${OrderId} `))
    {
      //
    var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/DeleteOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:OrderId,
    userid:MyUserid,

},
success:function(data){
if(data.status){//return data as true

    alert(`Order ${orderId} Successfully Deleted`);
    createFucture();



}
else{

    alert(`Order ${orderId} Successfully Deleted`);
    display_order();

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
      //
    }
    return false;

}



function payeDollar(thisdata)
{
    inputDataDollar = thisdata.value;
    PayeOperation();


}
function payeOtherCurrency(thisdata){//here not done
    var otherToUsd=2000;//fcs;

    if(thisdata.value !="")
    {
        toUsd=(parseInt(thisdata.value)/parseInt(otherToUsd)).toFixed(2);
        $('.toUsd').text(toUsd);
        PayeOperation();




    }
    else{
        $('.toUsd').text(0);
    }

}
function PayeOperation(){

    if(inputDataDollar !="")
    {
        dollarPaid=parseFloat(inputDataDollar)+parseFloat(toUsd);
        //console.log(dollarPaid);
        if(dollarPaid>=custom_total)
        {

            return_paid=(dollarPaid-custom_total).toFixed(2);;
            remain_custom_total=0;
            $(".remain_custom_total").text(`$${remain_custom_total}`);
            $(".payback").text(`$${return_paid}`);


        }
        else{
            remain_custom_total=(custom_total-dollarPaid).toFixed(2);
            $(".remain_custom_total").text(`$${remain_custom_total}`);
            $(".payback").text(0);

        }

    }
    else{
        inputDataDollar="0";
        $(".remain_custom_total").text(`$${custom_total}`);
    }
}

function SubmitOrder(){//note this is a better way to send post request

    if(confirm(`Are you sure you want to Submit this Order?`))
    {
$('.cover-spin').show();
        //
        var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/RequestOrder`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
//data:$('.Form_order').serialize()+"&userid=" + MyUserid,
data:$('.Form_order').serialize(),
success:function(data){
if(data.status){//return data as true

    $('.cover-spin').hide();
    $('.MainForm').html(`
    <div class="alert alert-primary" role="alert">
  Order Submitted Successfully
</div>
    `);


    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);


}
else{

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
        //
    }
    //

}

function checkUser(){
    if(MyUserid==='none')
    {
        ViewSecondSalesReport();
    }
    else{
        ViewSecondSalesReport(MyUserid,Myname);
    }
}
function searchSaleFacture(thisdata)
{
//
if(thisdata.value=="") return checkUser();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/UserSearchSecondSaleReport`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
    data: {
userid:MyUserid,
factureNo:thisdata.value,
    },
success:function(data){


if(data.status){//return data as true


//var data=data.result[0];
//var data=;
//console.log(hashfunction);
var data=data.result;
var TotalReport=0;
console.log(data);
 var getdata=``;

 for(var i=0;i<data.length;i++){
    TotalReport+=data[i].total_order;
    var dataToArr=data[i].ProductConcat.split(',');
    var getDetail="";
    for(var u=0;u<dataToArr.length;u++)
    {
        getDetail+=`
<li class="list-group-item">${u+1} ${parantesis} ${dataToArr[u]}</li>
`;
   }
   //Users
   var editsubmitBtn=`<i  class="fas fa-edit text-success mylogout" title="Edit Submitted Orders" onclick="return EditSubmittedOrder('${data[i].uid}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var permissionUser=data[i].permission===trueV?editsubmitBtn:'';

   //Admin

   var TrueSubmitIcon=`<i  class="fas fa-pen text-success mylogout" title="Edit Permission Orders" onclick="return EditPermissionOrder('${data[i].uid}','${trueV}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var FalseSubmitIcon=`<i  class="fas fas fa-ban text-danger mylogout" title="Edit Permission Orders" onclick="return EditPermissionOrder('${data[i].uid}','${falseV}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var permissionChange=data[i].permission===trueV?TrueSubmitIcon:FalseSubmitIcon;

   var permissionDisp=platform==='{{env('PLATFORM1')}}'?permissionChange:permissionUser;

   getdata+=`

<ul class="list-group pt-1 ">

  <li class="list-group-item bg-dark text-white">No # ${data[i].uid} ${permissionDisp}<span class=" float-right"><span class="text-success">(${data[i].qty}) Total</span>=$${data[i].total_order}</span></li>
  ${getDetail}
</ul>
<hr/>
    `;

 }



$('.MainForm').html(getdata);


}
else{
$('.MyRequest_table').html("");
$('.cover-spin').hide();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;
//
}

function searchProductTable(thisdata){
//
if(thisdata.value=="") return $('.search_append').html("");
//

searchProd=chooseSearchBy==='1'?'SearchByProduct':'SearchByTags';//first is search by code second by tags
console.log(chooseSearchBy);
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/${searchProd}`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    productCode:thisdata.value,
},
success:function(data){
    if(data.status){//return data as true
    $('.cover-spin').hide();
    var data=data.result;

    getData=`

 <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Code</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Qty</th>

      <th scope="col">Qty Left</th>
      <th scope="col">Created</th>
    </tr>
  </thead>
 `;

 for(var i=0;i<data.length;i++){
    //it means that on receiv show Dispatch else show Received
    tags=data[i].tags===null?'N/A':data[i].tags;
     getData+=` <tr>
      <td data-label="#">${i+1}</td>
      <td data-label="Code">${data[i].productCode}</td>
      <td data-label="Name">${tags}</td>
      <td data-label="Price">${data[i].price}</td>
      <td data-label="qty">${data[i].qty}</td>

      <td data-label="Qty_left">${parseInt(data[i].qty)-parseInt(data[i].qty_sold)}</td>
      <td data-label="Created_at">${data[i].created_at}</td>

    </tr>`;

 }
 $('.MyRequest_table').html(getData);

}
else{
$('.MyRequest_table').html("");
$('.cover-spin').hide();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
//
}

//seachpage

</script>
<script>
        function openNav() {
          document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
        }
        </script>
