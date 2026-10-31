<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Dashboard.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">

<!--Menu Css-->
<style>
.Scroll {
  height:200px;
  overflow-y: scroll;
}
span.Formchange {
    /* width: 200px; */
    padding-top: 10px;
    padding-left: 2px;
    padding-right: 5px;
    outline: 0;
    border-bottom: 2px dashed #e0e0e0;
    /* border-width: 0 0 20px; */
    border-color: blue;
}
.Count_table{
    display: none;
}
/*loader*/
.cover-spin {
  position:fixed;
  width:100%;
  left:0;right:0;top:0;bottom:0;
  background-color: rgba(255,255,255,0.7);
  z-index:120000;

  }

  @-webkit-keyframes spin {
  from {-webkit-transform:rotate(0deg);}
  to {-webkit-transform:rotate(360deg);}
  }

  @keyframes spin {
  from {transform:rotate(0deg);}
  to {transform:rotate(360deg);}
  }
  .two_columns_75_25>.column1{
width: 100% !important;
  }
  .cover-spin::after {
  content:'';
  display:block;
  position:absolute;
  left:48%;top:40%;
  width:40px;height:40px;
  border-style:solid;
  border-color:black;
  border-top-color:transparent;
  border-width: 4px;
  border-radius:50%;
  -webkit-animation: spin .8s linear infinite;
  animation: spin .8s linear infinite;
  }
  /*loader*/
/*Navigation Menu */

.sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color:#0b1419f5;

        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
      }

      .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.06em;
        color:#fff8f8c7;
        display: block;
        transition: 0.3s;
      }



      .sidenav a:hover {
        color: #f1f1f1;
      }

      .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
      }
      @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
      }
      @media only screen and (max-width : 785px) {
            .mob-logo,.sidenav{
                display: block !important;
            }
          .mob-logo{
              position: absolute;
              top: 5px;
              left:20px;
              z-index: 999999;
          }
            .logo.mymoblogo {
        position: absolute;
        top: 5px;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    ul.menu-ul-center{
        display: none;
    }

        }
    /*navigation*/

</style>
<!--Menu Css-->
<!--style table -->
<style>

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}


@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }

  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  table td:last-child {
    border-bottom: 0;
  }
}














/* general styling */


</style>
<!--style table -->
<!--header-->
@include('components.header.header')
<!--header-->
<!--navigation Mobile-->
<div class="cover-spin"></div>
<span  style="font-size:30px;cursor:pointer" onclick="openNav()" class="mob-logo text-dark">&#9776; </span>
     <div id="mySidenav" class="sidenav">



            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


<div class="app-sidebar sidebar-shadow bg-vicious-stance sidebar-text-light">

<div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Facture</li>
                            <li>
                                <a href="#Search Product" onclick="return create_order()">
                                    <i class="metismenu-icon pe-7s-graph2"></i>Create
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Profile</li>
                            <li>
                                <a href="#View All Sales" onclick="return UpdateProfileMenu()">
                                    <i class="metismenu-icon pe-7s-graph2"></i> Update
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Stocks</li>
                            <li>
                                <a href="#View All Products" onclick="return ViewAllProducts()">
                                    <i class="metismenu-icon pe-7s-graph2"></i>View
                                </a>
                            </li>

                            <li class="app-sidebar__heading">Sales</li>
                            <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>Report
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#Report" onclick="return UserReport()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View 1
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#Report" onclick="return ViewSecondSalesReport()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View 2
                                        </a>
                                    </li>

                                    </li>

                                </ul>
                            </li>

                         <!--   <li class="app-sidebar__heading">Menu</li>
                            <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>Dashboards
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="index.html" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Analytics
                                        </a>
                                    </li>
                                    <li>
                                        <a href="dashboards-commerce.html" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Commerce
                                        </a>
                                    </li>
                                    <li>
                                        <a href="dashboards-sales.html" aria-expanded="false">
                                            <i class="metismenu-icon">
                                            </i>Sales
                                        </a>
                                    </li>
                                    <li class="mm-active">
                                        <a href="#" aria-expanded="true">
                                            <i class="metismenu-icon"></i> Minimal
                                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                        </a>
                                        <ul class="mm-collapse mm-show" style="">
                                            <li>
                                                <a href="dashboards-minimal-1.html">
                                                    <i class="metismenu-icon"></i>Variation 1
                                                </a>
                                            </li>
                                            <li>
                                                <a href="dashboards-minimal-2.html">
                                                    <i class="metismenu-icon"></i>Variation 2
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="dashboards-crm.html" aria-expanded="false">
                                            <i class="metismenu-icon"></i> CRM
                                        </a>
                                    </li>
                                </ul>
                            </li>-->


                        </ul>
                        <li class="app-sidebar__heading mylogout" style="color:rgb(195 211 88);" onclick="logout()">

Settings<i class="fa text-white fa-cog  pr-1 pl-1"></i>

</li>
                        <li class="app-sidebar__heading mylogout" style="color:rgb(195 211 88);" onclick="logout()">

                                Logout<i class="fa text-white fa-power-off  pr-1 pl-1"></i>

                                </li>
                    </div>

</div>



          </div>
        <!--navigation Mobile-->
</head>
<body>

<!--search form-->
<div class="container">
<!--form -->
<div class="main-card mb-3 card p-4">
<div class="MainbigTitle">



</div>

<div class="MainForm">



</div>


<!--Modal table-->

<div class="modal fade bd-example-modal-lg viewOrder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

<div class="modal-header MyTitleModal"></div>
      <!--Order Request table-->

<div class="ModalProductList p-2 Scroll"></div>

    <table class="viewReqTable">

<thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Code</th>
    <th scope="col">qty</th>
    <th scope="col">pcs</th>
    <th scope="col">dz</th>

  </tr>
</thead>
<tbody>


</tbody>
</table>

                     <!--Order Request-->
      ...
    </div>
  </div>
</div>

<!--Modal table-->

<div class="Count_table">
<h6 class="text-center orderIdDsp"></h6>
<div class="float-left pt-2 pb-2">
<button type="button" class="btn btn-lg btn-danger" onclick="return DisplayOrderData()">Back</button>
</div>

</div>

            <!--Order Request table-->
            <div class="OrderDspTable">
            <table class="MyRequest_table">


  <tbody>


  </tbody>
</table>
</div>
                       <!--Order Request-->
        </div>
<!--form -->
</div>
</body>

<!--search form-->
@include('components.Footerjs.footerjs')
@include('Search')

<script>
//search page



$(function() {
   // DisplayOrderData();

   create_order();



})
function checkPlatform(platform){

    if(platform==='{{env('PLATFORM1')}}')
   {
    window.location.href ="admin";
   }
   else{
       return true;
   }

}
function TableDisplayOrderTemplate(data){

 //console.log(hashfunction);
 getData=`

 <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">OrderId</th>
      <th scope="col">Total</th>
      <th scope="col">status</th>
      <th scope="col">Created_at</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
 `;

 for(var i=0;i<data.length;i++){
     ReceivedBtn=`<button type="button" class="btn btn-dark" onclick="return ReceivedOrder('${data[i].uid}')">Received?</button>`;
     DispatchBtn=`<button type="button" class="btn btn-success" onclick="return ViewDispatchOrder('${data[i].uid}')">Dispatch</button>`;
     ReceivedIcon=`<i class="fas fa-check text-success"></i>`;
     BtnDisplayCheck=data[i].status!='Request'?DispatchBtn:ReceivedBtn;//it means that on receiv show Dispatch else show Received
     getData+=` <tr>
      <td data-label="#">${i+1}</td>
      <td data-label="OrderId">${data[i].uid}</td>
      <td data-label="Total">${data[i].custom_total}</td>
      <td data-label="Status">${data[i].status=='Received'?ReceivedIcon:data[i].status}</td>
      <td data-label="Created_at">${data[i].created_at}</td>
      <td data-label="Action">${BtnDisplayCheck}| <button type="button" class="btn btn-primary" onclick="return View_order('${data[i].uid}')">View</button></td>
    </tr>`;

 }
 $('.MyRequest_table').html(getData);
}
function DisplayOrderData(){
    closeNav();

    $('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);
    $('.Count_table').css("display", "none");
    $('.OrderDspTable').css("display", "block");
    $.ajax({

url:`./api/ViewOrderRequest`,
type:'get',

success:function(data){


if(data.status){//return data as true

    var data=data.result;
 //console.log(hashfunction);
 TableDisplayOrderTemplate(data)




}
else{
    $('.MyRequest_table').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}

function ReceivedOrder(OrderId) {
    if(confirm('Have you received this order?'))
    {
//
var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


$.ajax({

url:`./api/AdminReceivedOrder`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
uid:OrderId,
},
success:function(data){
if(data.status){//return data as true

DisplayOrderData();


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
//
    }


    return false;
//
}
function dispatch(myid){


}


function View_order(orderid){
//
var Usertoken=localStorage.getItem("Usertoken");
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">Order ID#:${orderid}</h5>`)
    $('.cover-spin').show();

    $.ajax({

url:`./api/viewOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:orderid,
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    var data=data.result;
 //console.log(hashfunction);
 getData="";

 for(var i=0;i<data.length;i++){
     getData+=` <tr>
      <td data-label="#">${i+1}</td>
      <td data-label="OrderId">${data[i].productCode}</td>
      <td data-label="Qty">${data[i].qty}</td>
      <td data-label="PCS">${data[i].pcs}</td>
      <td data-label="dz">${(data[i].pcs/12).toFixed(2)}</td>

    </tr>`;

 }
 $('.viewReqTable tbody').html(getData);





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
    return false;
//
}

function ViewDispatchOrder(orderid){
    $('.MainForm').html(``);
    $('.Count_table').css("display", "block");
    //$('.OrderDspTable').css("display","none");
    $('.orderIdDsp').text(`Order ID #:${orderid}`);
    $('.cover-spin').show();
//
var Usertoken=localStorage.getItem("Usertoken");
   // $('.viewOrder').modal('show');


    $.ajax({

url:`./api/viewOrder`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    uid:orderid,
},
success:function(data){
if(data.status){//return data as true

    $('.cover-spin').hide();
    var data=data.result;
 //console.log(hashfunction);
 getData=`
 <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Item</th>
    <th scope="col">pcs</th>
    <th scope="col">qty</th>
    <th scope="col">qty(Count)</th>
    <th scope="col">qty(Left)</th>
    <th scope="col">Action</th>
</tr>
</thead>
 `;

 for(var i=0;i<data.length;i++){
    var trackInput=`Count_${data[i].id}`;
    var qtyCountID=`qty_${trackInput}`;
    var inputQty=` <input type="number" class="form-control ${qtyCountID}" value="${data[i].qty_count}" >`;
    var btnCount=`<button type="button" class="btn btn-dark" onclick="return Approved('${qtyCountID}','${data[i].uid}','${data[i].productCode}','${data[i].price}','${data[i].custom_price}')">Count</button>`;
    var checkIcon=`<i class="fas fa-check text-success"></i>`;
    var checkQtyToQtyCount=data[i].qty==data[i].qty_count?checkIcon:btnCount;
     getData+=` <tr>
      <td data-label="#">${i+1}</td>
      <td data-label="Item">${data[i].productCode}</td>
      <td data-label="pcs">${data[i].pcs}</td>
      <td data-label="qty">${data[i].qty}</td>

      <td data-label="qty(Count)">${data[i].qty_count}
     ${data[i].qty==data[i].qty_count?'':inputQty}
      </td>
      <td data-label="qty(Left)">${data[i].qty-data[i].qty_count==0?'0'+checkIcon:data[i].qty-data[i].qty_count}</td>
      <td data-label="Action">${checkQtyToQtyCount}</td>

    </tr>`;

 }
 $('.MyRequest_table').html(getData);





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
    return false;
//
}
function Approved(qtyCountID,OrderId,productCode,price,custom_price) {//count


    $('.cover-spin').show();

var qty_countValue=$(`.${qtyCountID}`).val();

var Usertoken=localStorage.getItem("Usertoken");
//console.log(OrderId);
//search products
$.ajax({

url:`./api/AdminApprovedCount`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
uid:OrderId,
productCode:productCode,
price:price,
qty_count:qty_countValue,
custom_price:custom_price,
},
success:function(data){

if(data.status){//return data as true

   ViewDispatchOrder(OrderId);

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
return true;

}

function ViewApprovedOrder() {//count
    closeNav();
    $('.MainForm').html(`
    <h5 class="text-center">Approved Order</h5>
    `);


    $('.cover-spin').show();

var Usertoken=localStorage.getItem("Usertoken");
//console.log(OrderId);
//search products
$.ajax({

url:`./api/ViewOrderApproved`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
success:function(data){


if(data.status){//return data as true
    var data=data.result;
 TableDisplayOrderTemplate(data);


 $('.cover-spin').hide();


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

function TrackdOrderForm(){
    closeNav();
    $('.MyRequest_table').html("");

    $('.MainForm').html(`
    <h5 class="text-center">Track Your Order</h5>
<div class="form-inline">
  <input class="form-control mr-sm-2 trackId" type="search" placeholder="Enter OrderID" aria-label="Search">
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="return TrackdOrder()">Search</button>
</div>

    `);

    return false;
}

function TrackdOrder(){

    var OrderId=$('.trackId').val();
var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();
//console.log(OrderId);
//search products
$.ajax({

url:`./api/TrackOrder`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
uid:OrderId,

},
success:function(data){

if(data.status){//return data as true
    $('.cover-spin').hide();
    var data=data.result;
 //console.log(hashfunction);
 TableDisplayOrderTemplate(data);



}
else{
    $('.MyRequest_table').html(`
    <h5 class="text-center">Order Id Not Found</h5>
    `);

    $('.cover-spin').hide();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return true;
}

function  ReportChoice(thisdata)
{
    if(thisdata.value=='1')
    {
        console.log(thisdata.value);
        UserReport();
    }
    else{
        console.log(thisdata.value);
        ViewSecondSalesReport();
    }
    return false;
}

function EditSubmittedOrder(OrderId,qty,totalOrder) {//qty:number of qty in this facture to be edited,totalOrder:is total amount of that facture,this will be saved on history edit
    if(confirm(`Do you want to Edit this order No:${OrderId}?`))
    {
//
var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


$.ajax({

url:`./api/UserEditOrder`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
OrderId:OrderId,
qty:qty,
totalOrder:totalOrder,
PrevQueryData:"Here it is tableName+FactureNo",
},
success:function(data){
if(data.status){//return data as true

    create_order();


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
//
    }


    return false;
//
}
function ViewSecondSalesReport(){
    closeNav();
    $('.MyRequest_table').html("");
$(".MainbigTitle").html("");
$(".MainForm").html("");
//
$('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/UserSecondSaleReport`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
    data: {
userid:"none",
    },
success:function(data){


if(data.status){//return data as true
    $('.cover-spin').hide();
//var data=data.result[0];
//var data=;
//console.log(hashfunction);
var data=data.result;
var TotalReport=0;
var TotalNo=0;
var TotalQty=0;
console.log(data);
 var getdata=``;

 for(var i=0;i<data.length;i++){
    TotalReport+=parseFloat(data[i].total_order);
    TotalNo=data.length;
    TotalQty+=parseFloat(data[i].qty);
    var dataToArr=data[i].ProductConcat.split(',');
    var getDetail="";
    for(var u=0;u<dataToArr.length;u++)
    {
        getDetail+=`
<li class="list-group-item">${u+1} ${parantesis} ${dataToArr[u]}</li>
`;
   }
   var editsubmitBtn=`<i  class="fas fa-edit text-success mylogout" title="Edit Submitted Orders" onclick="return EditSubmittedOrder('${data[i].uid}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var permissionDisp=data[i].permission===trueV?editsubmitBtn:'';
    getdata+=`

<ul class="list-group pt-1 ">

  <li class="list-group-item bg-dark text-white">No # ${data[i].uid} ${permissionDisp}<span class="float-center"></span><span class=" float-right"><span class="text-success">(${data[i].qty}) Total</span>=$${data[i].total_order}</span></li>
  ${getDetail}
</ul>
<hr/>
    `;

 }
 $('.MainbigTitle').html(`

 <h5 class="text-center mainTitle">


<div class="pt-1">
<select id="Ultra" onchange="return ReportChoice(this)" class="form-control-sm">
     <option value="2">Report View 2</option>
     <option value="1">Report View 1</option>

</select>
</div>
 </h5>

 <h6 class="text-right"><span class="text-danger">Total</span>:$${TotalReport}</h6>
<h6 class="text-right"><span class="text-primary">Qty</span>:${TotalQty}</h6>
<h6 class="text-right"><span class="text-success">Facture</span>:${TotalNo}</h6>

${@include('components.Search.Search.SearchFactureNo')}

`);


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



}
function  UserReport(){
    closeNav();
    $('.MyRequest_table').html("");
//$(".MainbigTitle").html("");
//$(".MainForm").html("");
    //MyUserid=userid;
    //$('.MainForm').html("");
    /*$('.mainTitle').html(`${name}

    <div class="pt-1">
<button type="button" class="btn btn-danger" onclick="return AdminAddPassword('${userid}','${name}')">Close Sales</button>
</div>
<div>
<select id="Ultra" onchange="return ReportChoice(this,'${userid}','${name}')">
     <option value="1">Report1</option>
     <option value="2">Report2</option>

</select>
</div>
    `);*/

    //
    $('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/UserSaleReport`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
    data: {
userid:'none',
countryComeFrom:countryComeFrom
    },

success:function(data){


if(data.status){//return data as true
    $('.cover-spin').hide();
//var data=data.result[0];
//var data=;
//console.log(hashfunction);
var data=data.result;
var MyallTotal=0;
var totalColi=0;

var getData=`
<ul class="list-group pt-3 displayViewAll">
<li class="list-group-item bg-dark text-white">LIST YIBYAFASHWE <span class=" float-right"><span class="text-success">Qty:</span><span class="totalqtycoli"></span></span></li>

`;

for(var i=0;i<data.length;i++){
//it means that on receiv show Dispatch else show Received
MyallTotal+=parseFloat(data[i].all_total);
totalColi+=parseFloat(data[i].qty);
 getData+=`
<li class="list-group-item">${i+1})  ${data[i].qty} ${data[i].productCode}= ${data[i].all_total}</li>

`;



}
getData+=`</ul>`;
$('.MainbigTitle').html(`
<h5 class="text-center mainTitle">
${name}

<div class="pt-1">
<select id="Ultra" class="form-control-sm" onchange="return ReportChoice(this)">
     <option value="1">Report View 1</option>
     <option value="2">Report View 2</option>

</select>
</div>

<div class="form-group">
<h6>Search From</h6>
<select class="form-control-sm catComeFrom" name="cat" onchange="ComeFromaUserSale()">

</select>
<div>

</h5>
<div class="text-right UserBtnTotal"><h6 class="text-right">Total:${MyallTotal}</h6></div>

    `);

    selectComeFrom();

$('.MainForm').html(getData);
$('.totalqtycoli').text(totalColi);

//$('.MyRequest_table').html(getData);
//console.log(MyallTotal);
/*$('.UserBtnTotal').html(`

<h6 class="text-right">Total:${MyallTotal}</h6>
`);*/


}
else{
$('.MyRequest_table').html("");
$('.MainForm').html("No data Found");
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

function ComeFromaUserSale(){
    countryComeFrom=$('.catComeFrom option:selected').val();
    UserReport();

}

function CreateProductMenu(){

    $('.MainForm').html(`
    <h5 class="text-center">Create A products</h5>
    <form class="formData"  enctype="multipart/form-data">
<div class="form-group">
<label>Product Code</label>
<input type="text" class="form-control" name="productCode" />
</div>
<div class="form-group">
<label>Image</label>
<input type="file" class="form-control" change="imagechange(this)" name="files[]" />
</div>
<div class="form-group">
<label>From</label>
<input type="text" class="form-control" name="cat" />
</div>
<div class="form-group">
<label>Price</label>
<input type="text" class="form-control" name="price"/>
</div>
<div class="form-group">
<label>qty</label>
<input type="text" class="form-control" name="qty" />
</div>
<div class="form-group">
<label>Pieces</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group">
<label>Factories Price</label>
<input type="text" class="form-control" name="fact_price" />
</div>

<div class="form-group">
<label>tags</label>
<input type="text" class="form-control" name="tags" />
</div>
<div class="form-group">
<label>active</label>
<input type="text" class="form-control" name="active" />
</div>

<div class="form-group">
<label>Description</label>
<input type="text" class="form-control" name="description" />
</div>
<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return CreateProduct()" value="submit" />
</div>


</form>
    `);

}
function SearchUserByName(thisdata) {

   //
if(thisdata.value=="") return $('.searchUser_Append').html("");

//
var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SearchUserByName`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    name:thisdata.value,
},
success:function(data){
if(data.status){//return data as true



var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item" onclick="return ViewUserName('${data[i].userid}','${data[i].name}','${data[i].tel}','${data[i].email}','${data[i].country}')">${data[i].name}</li>
    `;

 }

 $('.searchUser_Append').html(getdata);



}
else{
    $('.searchUser_Append').html("");
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

function ViewUserName(userid,name,tel,email,country){
    $('.SearchUserByName').val(name);
    $('.searchUser_Append').html("");

    $('.formContactAppend').html(`
    <div class="form-group">
<label>Image</label>
<input type="hidden" value="${userid}" class="form-control" name="ContactID" />
</div>
<div class="form-group">
<label>Phone</label>
<input type="text" value="${tel}" class="form-control" name="tel" />
</div>
<div class="form-group">
<label>Email</label>
<input type="text" class="form-control" value="${email}" name="email" />
<input type="hidden" class="form-control" value="1" name="password" />

</div>
<div class="form-group">
<label>Other Phone</label>
<input type="text" class="form-control" name="otherPhone" placeholder="Enter another phone number" />
</div>
<div class="form-group">
<label>address</label>
<input type="text" class="form-control" value="${country}" name="address" />
</div>
<div class="form-group">
<label>comment</label>
<input type="text" class="form-control" name="comment" />
</div>
    `);
}

function CreateContactMenu(){
    closeNav();

$('.MainForm').html(`
<h5 class="text-center">Create Contact</h5>
<form class="formData">
<div class="form-group">
<label>Enter Name</label>
<input type="text" class="form-control SearchUserByName"  name="name"  onkeyup="return SearchUserByName(this)"/>
</div>
<ul class="list-group searchUser_Append">

</ul>
<div class="formContactAppend">

<div class="form-group">
<label>Image</label>
<input type="hidden"  class="form-control" name="ContactID" />
</div>
<div class="form-group">
<label>Phone</label>
<input type="text"  class="form-control" name="tel" />
</div>
<div class="form-group">
<label>Email</label>
<input type="text" class="form-control"  name="email" />
<input type="hidden" class="form-control"  name="password" value="1" />
</div>
<div class="form-group">
<label>Other Phone</label>
<input type="text" class="form-control" name="otherPhone" placeholder="Enter another phone number" />
</div>
<div class="form-group">
<label>address</label>
<input type="text" class="form-control"  name="address" />
</div>
<div class="form-group">
<label>comment</label>
<input type="text" class="form-control" name="comment" />
</div>

</div>

<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return CreateContact()" value="submit" />
</div>


</form>
`);

}
function imagechange(event){
/*for(let i=0;i<this.$refs.files.files.length;i++)
{
  this.images.push(this.$refs.files.files[i]);
  console.log(this.images);
}*/

//

 var input = event.target;
      var count = input.files.length;
     // var count = 1;
      var index = 0;
      if (input.files) {
        while(count --) {
          var reader = new FileReader();
          reader.onload = (e) => {
            this.preview_list.push(e.target.result);

          }
          this.image_list.push(input.files[index]);

          reader.readAsDataURL(input.files[index]);
          index ++;
        }
	}
//
console.log(image_list);
      }
function CreateProduct() {//Admin
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/CreateProduct`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
data:$('.formData').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();
    $('.MainForm').html(`
    <div class="alert alert-primary" role="alert">
  Product Created Successfully
</div>
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
    return false;

}

function CreateContact() {//Admin
    $('.cover-spin').show();
//
var Usertoken=localStorage.getItem("Usertoken");
//console.log(OrderId);
//search products
$.ajax({

url:`./api/CreateContact`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formData').serialize(),
success:function(data){
if(data.status){//return data as true

//localStorage.setItem('Usertoken',data.token);
//console.log(hashfunction);
$('.cover-spin').hide();
    $('.MainForm').html(`
    <div class="alert alert-primary" role="alert">
  Contact Created Successfully
</div>
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
return false;

}
</script>





</html>
