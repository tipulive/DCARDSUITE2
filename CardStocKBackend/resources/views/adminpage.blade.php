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


@media screen and (max-width: 800px) {
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




@media screen and (max-width: 4800px) {
  .mytable {
    border: 0;
  }

  .mytable caption {
    font-size: 1.3em;
  }

  .mytable thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  .mytable tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }

  .mytable td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  .mytable td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }

  .mytable td:last-child {
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
     <div id="mySidenav" class="sidenav" >
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

            <div class="app-sidebar sidebar-shadow bg-vicious-stance sidebar-text-light">

<div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Report</li>
                            <li>
                                <a href="#View All Sales" onclick="return AllOpenSaleReport()">
                                    <i class="metismenu-icon pe-7s-graph2"></i> All Sales
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Profile</li>
                            <li>
                                <a href="#View All Sales" onclick="return UpdateProfileMenu()">
                                    <i class="metismenu-icon pe-7s-graph2"></i> Update
                                </a>
                            </li>
                        <li class="app-sidebar__heading">Users</li>
                            <li>
                                <a href="#View All Users" onclick="return ViewAllUsers()">
                                    <i class="metismenu-icon pe-7s-graph2"></i>View
                                </a>
                            </li>




                          <!--CardCode-->
                          <li class="app-sidebar__heading">Card</li>
                            <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>Card
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#View All Products" onclick="return CreateMultipleCardMenu()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Generate
                                        </a>
                                    </li>

                                    <li>
                                        <a  href="/ViewCard" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Print Card
                                        </a>
                                    </li>


                                    </ul>
                                    <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>items Safari
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Stock</li>

                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#View All Products" onclick="return CheckSafariStock()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Create Safari
                                        </a>
                                    </li>

                                    <li>
                                        <a  href="#Create Product" onclick="return ViewSafariStock('name',false)" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View
                                        </a>
                                    </li>
                                    <li>
                                        <a  href="#Create Product" onclick="return ProductSafariStock()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Products
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/ViewQrProduct" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Product Qr
                                        </a>
                                    </li>
                                    <!--Combine Create Safari and View Safari -->
                                   <!-- <li>
                                        <a  href="#Create Product" onclick="return ViewSafari()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Safari
                                        </a>
                                    </li>-->
                                    <!--here you can edit Products Price -->
                                    <!--Sell your Stock -->
                                    <!--<li>
                                        <a  href="#Create Product" onclick="return ViewSafari()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Products
                                        </a>
                                    </li>
                                    <li>
                                        <a  href="#Create Product" onclick="return ViewSafari()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Sell
                                        </a>
                                    </li>-->


                                    </ul>

                                    <li class="app-sidebar__heading">Promotion</li>
                            <li class="mm-active">
                                <a href="/promotion" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>Promotion
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>

                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#View All Products" onclick="return CreatePromotionEventMenu()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Create
                                        </a>
                                    </li>

                                    <li>
                                        <a  href="#Create Product" onclick="return ViewAllPromotionEvent()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View
                                        </a>
                                    </li>


                                    </ul>
                                    <!--Quick Bonus -->
                                    <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>Quick Bonus
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#Setup Bonus" onclick="return SetupQuickBonusMenu()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Setup Bonus
                                        </a>
                                    </li>

                                    <li>
                                        <a  href="#Create Product" onclick="return GetAllPromotionEvent()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View
                                        </a>
                                    </li>


                                    </ul>
                                    <!--Quick Bonus -->


                                    <!--CardCode-->
                            <!--Safarinew and Code-->

                                    <!--SafariCode-->
                                      <!--SafariCode-->
                              <!--   <li class="app-sidebar__heading">Safari</li>
                            <li class="mm-active">
                                <a href="#" aria-expanded="true">
                                    <i class="metismenu-icon pe-7s-rocket"></i>items Safari
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                                <ul class="mm-collapse mm-show" style="">
                                    <li>
                                        <a href="#View All Products" onclick="return CheckSafari()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>Create
                                        </a>
                                    </li>

                                    <li>
                                        <a  href="#Create Product" onclick="return ViewSafari()" aria-expanded="false">
                                            <i class="metismenu-icon"></i>View
                                        </a>
                                    </li>-->


                                    </ul>

                                    <!--SafariCode-->
                                <li class="app-sidebar__heading mylogout" style="color:rgb(195 211 88);" onclick="logout()">

                                Logout<i class="fa text-white fa-power-off  pr-1 pl-1"></i>

                                </li>
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
                    </div>

</div>

            <!--<li ><a href="#Search Product" onclick="return ViewSearchForm()">Create Facture</a></li>-->
           <!-- <li ><a href="#Display Order" onclick="return DisplayOrderData()">Display Order</a></li>-->
            <!--<li ><a href="#Create Contact" onclick="return CreateContactMenu()">Create Contact</a></li>-->

          </div>
        <!--navigation Mobile-->
</head>
<body>

<!--search form-->
<div class="container">

<!--form -->

<div class="modal fade bd-example-modal-lg viewOrder "   tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content ">

<div class="modal-header MyTitleModal" ></div>
      <!--Order Request table-->
<div class="ModalPassword">
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
</div>
                     <!--Order Request-->
      ...
    </div>
  </div>
</div>


<div class="main-card mb-3 card p-4">


<div class="MainbigTitle">



</div>
<div class="MainForm">



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
</div>


<!--search form-->
@include('components.Footerjs.footerjs')
@include('Search')

<script>

    //copy Link //




// Add click event listener to the button
//copyLinkBtn.addEventListener('click', copyLinkToClipboard);


// Function to copy the link to the clipboard
function onCopy() {
    const copyLinkBtn = document.getElementById('copy-link-btn');
  // Create a temporary input element
  const tempInput = document.createElement('input');

  // Set the input value to the current URL
  tempInput.value = $('.linkCopy').val();

  // Append the input element to the document body
  document.body.appendChild(tempInput);

  // Select the input field
  tempInput.select();

  // Copy the selected text to the clipboard
  document.execCommand('copy');

  // Remove the temporary input element
  document.body.removeChild(tempInput);

  // Change the button text temporarily
  copyLinkBtn.textContent = 'Link Copied!';

  // Reset the button text after 2 seconds

}

    //copy Link //
//search page



$(function() {
   // DisplayOrderData();
   //AllOpenSaleReport();
   $('.cover-spin').hide();
   //ViewSearchForm();

})
//CardCode
function CreateMultipleCardMenu(){
    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
    closeNav();
    $('.MainForm').html(`
    <h5 class="text-center">Generate Card</h5>
    <form class="formDataCreate" onsubmit="return CreateMultipleCard()">

<div class="form-group">
<label>Number <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="numberQr" required/>
</div>
<div class="form-group">

<button  class="btn btn-danger mycreateProduct" >Submit</button>
</div>


</form>
    `);




}
function CreateMultipleCard(){//Company
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");

   $.ajax({

url:`./api/CreateMultipleCard`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
data:$('.formDataCreate').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();

 //ViewAllProducts();

    alert("Card generated Successfully");
    $('.formDataCreate :input').val("");
    $('.mycreateProduct').val("Submit");

   // LoadSavedComeFrom();

}
else{
alert("Something is wrong please contact system Admin");
$('.cover-spin').hide();

}



},
error:function(data){
    console.log(data);
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}

var actionAccount="view";
function CreatePromotionEventMenu(){
    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
    closeNav();
    $('.MainForm').html(`
    <h5 class="text-center">Create Promotion</h5>

    <form class="formDataCreate" onsubmit="return CreatePromotionEvent()">

<div class="form-group">
<label> Promotion Name <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="promoName" required/>
</div>
<div class="form-group">

<div class="form-group">
<label>Reach<span class="text-danger">*</span></label>
<input type="text" class="form-control Promo_reach" name="reach" value="0" required onchange="return changePromoMsg()" onkeyup="changePromoMsg()"/>
</div>

<div class="form-group">
<label>Bonus<span class="text-danger">*</span></label>
<input type="text" class="form-control Promo_gain" name="gain" value="0" required onchange="return changePromoMsg()" onkeyup="changePromoMsg()"/>
</div>
<p><span class="text-danger">First text</span> <span class="text-primary">Reach</span> <span class="text-info">second Text</span> <span class="text-success">gain</span> <span class="text-dark">third Text</span></p>
<h6><h6 class="Promo_txtmsg text-danger">If you reach 0 i will give you 0</h6> <span class="reqclass"></span></h6>
<hr>
<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 1</label>
  <textarea class="form-control Promo_msg1" name="msg1" placeholder="Enter msg1" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">If you reach</textarea>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 2</label>
  <textarea class="form-control Promo_msg2" name="msg2" placeholder="Enter Comment" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">i will give you</textarea>
</div>
<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 2</label>
  <textarea class="form-control Promo_msg3" name="msg2" placeholder="Enter Comment" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">i will give you</textarea>
</div>
<div class="form-group d-none">
  <label for="exampleFormControlTextarea3">Message 3</label>
  <textarea class="form-control Promo_submit" name="promoMsg" placeholder="Enter Comment" rows="7" ></textarea>
</div>


<div class="form-group">
    <label for="">From Date-To</label>
    <input type="text" class="form-control" name="extended_date" id="extended_date">
    </div>

    <div class="form-group">
    <label for="">Choose Status</label>
<select id="Ultra" name="status"  class="form-control">
     <option value="on" selected>On</option>
     <option value="off">off</option>

</select>
</div>

<div class="form-group">

<button  class="btn btn-danger mycreateProduct" >Submit</button>
</div>


</form>
    `);


    flatpickr('#extended_date',{
    enableTime: true,
  mode: "range",
  minDate: "today",
    //dateFormat: "d-m-Y H:i:s",
    dateFormat: "Y-m-d H:i:s",
    time_24hr: true
    //defaultDate: [start_time, end_time]
});

}
function changePromoMsg(){
    var Promo_reach=$('.Promo_reach').val();
    var Promo_gain=$('.Promo_gain').val();
    var Promo_msg1=$('.Promo_msg1').val();
    var Promo_msg2=$('.Promo_msg2').val();
    var Promo_msg3=$('.Promo_msg3').val();
    $('.Promo_submit').val(`${Promo_msg1} ${Promo_reach} ${Promo_msg2} ${Promo_gain} ${Promo_msg3} `);
    $('.Promo_txtmsg').text(`${Promo_msg1} ${Promo_reach} ${Promo_msg2} ${Promo_gain} ${Promo_msg3}`);

}
function CreatePromotionEvent(){//Company
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");

   $.ajax({

url:`./api/CreatePromotionEvent`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
data:$('.formDataCreate').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();

 //ViewAllProducts();

    alert("Promotion Created Successfully");
    $('.formDataCreate :input').val("");
    $('.mycreateProduct').val("Submit");

   // LoadSavedComeFrom();

}
else{
alert("Something is wrong please contact system Admin");
$('.cover-spin').hide();

}



},
error:function(data){
    console.log(data);
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}

function ViewAllPromotionEvent(){
    $('.testModalOrder').modal('show');

    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/ViewAllPromotionEvent`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true


var resultData=data.result;


$('.MainbigTitle').html(`
<h5 class="text-center"> Safaris</h5>
`);
$('.MyRequest_table').html("");
getData=`


<table class="viewReqTable">
<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Name</th>
  <th scope="col">reach</th>
  <th scope="col">gain</th>
  <th scope="col">status</th>
  <th scope="col">started</th>
  <th scope="col">ended</th>
  <th scope="col">Actions</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
 <td data-label="#">${i+1}</td>
  <td data-label="Name">${resultData[i].promoName}</td>
  <td data-label="reach">${resultData[i].reach}</td>
  <td data-label="gain">${resultData[i].gain}</td>
  <td data-label="gain">${resultData[i].status}</td>
  <td data-label="start">${resultData[i].started_date}</td>
  <td data-label="start">${resultData[i].ended_date}</td>
  <td data-label="Actions"><button type="button" class="btn btn-dark" onclick="return ViewPromotion('${encodeURIComponent(JSON.stringify(resultData[i]))}')" >View</button>|<button type="button" class="btn btn-dark" onclick="return EditPromotion('${encodeURIComponent(JSON.stringify(resultData[i]))}')">Edit</button></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);



//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




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
function ViewPromotion(data)
{
    data=JSON.parse(decodeURIComponent(data));
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>View Promotion</strong></h5>`)
$('.ModalPassword').html(`

<ul class="list-group">
  <li class="list-group-item active">${data.promoName}</li>
  <li class="list-group-item text-danger">Status:${data.status}</li>
  <li class="list-group-item">Title:${data.promo_msg}</li>
  <li class="list-group-item">Reach:${data.reach}$</li>
  <li class="list-group-item">Gain:${data.gain}$</li>
  <li class="list-group-item">Started:${data.started_date}</li>
  <li class="list-group-item">Ended:${data.ended_date}</li>
  <li class="list-group-item">Created:${data.created_at}</li>
</ul>

`);
}
function EditPromotion(data){
    data=JSON.parse(decodeURIComponent(data));
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Promotion</strong></h5>`)
$('.ModalPassword').html(`
<form class="formDataCreate pl-2 pr-2" onsubmit="return EditPromotionEvent()">

<div class="form-group">
<label> Promotion Name <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="promoName" value="${data.promoName}" required/>
<input type="hidden" class="form-control" name="uid" value="${data.uid}" required/>
</div>
<div class="form-group">

<div class="form-group">
<label>Reach<span class="text-danger">*</span></label>
<input type="text" class="form-control Promo_reach" name="reach" value="${data.reach}" required onchange="return changePromoMsg()" onkeyup="changePromoMsg()"/>
</div>

<div class="form-group">
<label>Bonus<span class="text-danger">*</span></label>
<input type="text" class="form-control Promo_gain" name="gain" value="${data.gain}" required onchange="return changePromoMsg()" onkeyup="changePromoMsg()"/>
</div>
<p><span class="text-danger">First text</span> <span class="text-primary">Reach</span> <span class="text-info">second Text</span> <span class="text-success">gain</span> <span class="text-dark">third Text</span></p>
<h6><h6 class="Promo_txtmsg text-danger">If you reach 0 i will give you 0</h6> <span class="reqclass"></span></h6>
<hr>
<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 1</label>
  <textarea class="form-control Promo_msg1" name="msg1" placeholder="Enter msg1" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">If you reach</textarea>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 2</label>
  <textarea class="form-control Promo_msg2" name="msg2" placeholder="Enter Comment" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">i will give you</textarea>
</div>
<div class="form-group">
  <label for="exampleFormControlTextarea3">Message 2</label>
  <textarea class="form-control Promo_msg3" name="msg2" placeholder="Enter Comment" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">i will give you</textarea>
</div>
<div class="form-group d-none">
  <label for="exampleFormControlTextarea3">Message 3</label>
  <textarea class="form-control Promo_submit" name="promoMsg" placeholder="Enter Comment" rows="7" ></textarea>
</div>


<div class="form-group">
    <label for="">From Date-To</label>
    <input type="text" class="form-control" name="extended_date" id="extended_date">
    </div>

    <div class="form-group">
    <label for="">Choose Status</label>
<select id="Ultra" name="status"  class="form-control">
     <option value="on" selected>On</option>
     <option value="off">off</option>

</select>
</div>

<div class="form-group">

<button  class="btn btn-danger mycreateProduct" >Submit</button>
</div>


</form>

`);


flatpickr('#extended_date',{
    enableTime: true,
  mode: "range",
  minDate: "today",
    //dateFormat: "d-m-Y H:i:s",
    dateFormat: "Y-m-d H:i:s",
    time_24hr: true
    //defaultDate: [start_time, end_time]
});
$('#extended_date').val(`${data.started_date} to ${data.ended_date}`);
    return false;
}

function EditPromotionEvent(){//Company
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");

   $.ajax({

url:`./api/EditPromotionEvent`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
data:$('.formDataCreate').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();

 //ViewAllProducts();

    alert("Promotion Edited Successfully");
    $('.formDataCreate :input').val("");
    $('.mycreateProduct').val("Submit");

   // LoadSavedComeFrom();

}
else{
alert("Something is wrong please contact system Admin");
$('.cover-spin').hide();

}



},
error:function(data){
    console.log(data);
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}



//CardCode

//Quickie Bonus //

function SetupQuickBonusMenu(){

    $('.Gift').hide();
      $('.Money').show();
    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
    closeNav();
    $('.MainForm').html(`
    <h5 class="text-center">Setup Quick Bonus</h5>

    <form class="formDataCreate" onsubmit="return SetupQuickBonus()">

<div class="form-group right-inner-addon">
<label> Product Name <span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="autoCompleteQuickBonus(this)" name="productName" required/>
<span class="autocompleteIcon"><i class="fas fa-exclamation-triangle text-danger"></i></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>

<div class="form-group">
<label>Price<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodePriceClass" name="price" value="0" required />
</div>
<div class="form-group">
    <label for="">Choose Bonus Type</label>
<select id="Ultra" name="bonusType"  class="form-control" onchange="return CheckQuickBonus(this)">

     <option value="Money" selected>Money</option>
     <option value="Gift" >Gift</option>

</select>
</div>

<p class="text-danger">Bonus Calculator</p>
<div class="form-group">
<label>Qty <span class="text-danger">*</span></label>
<input type="text" class="form-control bonusQty" name="qty" value="0" required />
</div>

<div class="Money">


<div class="form-group">
<label>Bonus in USD<span class="text-danger">*</span></label>
<input type="text" class="form-control" value="0" required onchange="return BonusValueCalcul(this)" onkeyup="BonusValueCalcul(this)" placeholder="Enter Bonus you will give him for that Qty"/>
</div>

<div class="form-group">
<label>Bonus Value Per Pc in USD<span class="text-danger">*</span></label>
<input type="text" class="form-control bonusValue" name="bonusValue" value="0" required />
</div>

<div class="form-group">
<label>Minimum Price<span class="text-danger">*</span></label>
<input type="text" class="form-control " name="moneyMin" value="0" required />
</div>
</div>
<div class="Gift">
<div  class="form-group right-inner-addon">
<label>Gift Name<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeGiftClass"  autocomplete="off" onkeyup="autoCompleteGiftQuickBonus(this)" name="giftName" value="0" required />
<span class="autocompleteGiftIcon"><i class="fas fa-exclamation-triangle text-danger"></i></span>
</div>

<ul class="list-group  autoCompleteGiftTopItem">

</ul>


<div class="form-group">
<label>Stock Price<span class="text-danger">*</span></label>
<input type="text" class="form-control productGiftPriceClass" name="giftValues" value="0" required />
</div>

<div class="form-group">
<label>Bonus <span class="text-danger">*</span></label>
<input type="text" class="form-control" value="0" required onchange="return giftBonusValueCalcul(this)" onkeyup="giftBonusValueCalcul(this)" placeholder="Enter Bonus you will give him for that Qty"/>
</div>

<div class="form-group">
<label>Bonus Value Per Pc in USD<span class="text-danger">*</span></label>
<input type="text" class="form-control giftPerPcs" name="giftPerPcs" value="0" required />
</div>

<div class="form-group">
<label>Minimum Gift<span class="text-danger">*</span></label>
<input type="text" class="form-control " name="giftMin" value="0" required />
</div>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Description</label>
  <textarea class="form-control Promo_msg1" name="description" placeholder="Enter msg1" rows="2" onchange="return changePromoMsg()" onkeyup="changePromoMsg()">If you reach</textarea>
</div>


<div class="form-group">

<button  class="btn btn-danger mycreateProduct" >Submit</button>
</div>


</form>
    `);




}
function autoCompleteStock(thisdata)
{
    $('.autocompleteIcon').html(`<i class="fas fa-exclamation-triangle text-danger onclick="hidePopup()"></i>`);
    //
        if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/Products`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
    headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    productCode:thisdata.value,
    productName:"none",
    productQr:"none",
    isProductAction:"search",//product get Action(search,edit,view)
    LimitStart:1,  //page
    LimitEnd:10,
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){
     console.log(data);

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemStock('${btoa(data[i].productCode)}','${btoa(data[i].price)}')">
    ${data[i].productCode}=>${data[i].ProductName}${data[i].pcs} Pcs=>${data[i].tags}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);







}
else{
    isAvailable=true;

    $('.isProductExist').show();
    $('.isProductNotExist').show();
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}
function autoCompleteSpendPurpose(thisdata)
{
    $('.autocompleteIcon').html(`<i class="fas fa-exclamation-triangle text-danger onclick="hidePopup()"></i>`);
    //
        if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/searchSpendPurpose`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
    headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    purpose:thisdata.value,
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){
     console.log(data);

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemStock('${btoa(data[i].productCode)}','${btoa(data[i].price)}')">
    ${data[i].purpose}=>${data[i].amount}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);







}
else{
    isAvailable=true;
    $('.productCodePopup').val("productDataExistandCode");
    $('.isProductExist').hide();
    $('.isProductNotExist').show();
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}
function addItemQuickBonus(itemName,itemPrice){
    $('.productCodeClass').val(itemName);
    $('.productCodePriceClass').val(itemPrice);
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html(`<i class="fas fa-check text-success"></i>`);
}
function addItemStock(itemName,itemPrice){

console.log(data.safariuid);
    var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/IsProductExist`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
    headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
   "safariId":data.safariuid,
   "productCode":atob(itemName)
},
success:function(data){
if(data.status){//return data as true


alert("product is already exist in this safari");


}
else{

    $('.productCodeClass').val(atob(itemName));
    $('.productCodePriceClass').val(atob(itemPrice));
    $('.productCodePopup').val("productDataExistandCode");
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html(`<i class="fas fa-check text-success"></i>`);
    $('.isProductExist').hide();
    $('.isProductNotExist').hide();

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}


function autoCompleteGiftQuickBonus(thisdata)
{
    $('.autocompleteGiftIcon').html(`<i class="fas fa-exclamation-triangle text-danger">`);
        //
        if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`https://stock.appdev.live/api/viewSearchAllStock`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
data:{
    productCode:thisdata.value,
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteGiftTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){
     console.log(data);

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemGiftQuickBonus('${data[i].productCode}','${data[i].price}')">
    ${data[i].productCode}=>${data[i].tags}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteGiftTopItem').html(getdata);




}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}
function addItemGiftQuickBonus(itemName,itemPrice){
    $('.productCodeGiftClass').val(itemName);
    $('.productGiftPriceClass').val(itemPrice);
    $('.autoCompleteGiftTopItem').html("");
    $('.autoCompleteGiftTopItem').hide();
    $('.autocompleteGiftIcon').html(`<i class="fas fa-check text-success"></i>`);
}

function checkGiftMoney(thisData)
{
    if(thisData.value=='Gift')
    {
      $('.Gift').show();
      $('.Money').hide();
    }
    else{
    $('.Gift').hide();
      $('.Money').show();
    }

}
function CheckQuickBonus(thisData){
 console.log(thisData.value);


 checkGiftMoney(thisData);


    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/CheckQuickBonus`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    bonusType:thisData.value,
},

success:function(data){


if(data.status){//return data as true


var resultData=data.result;


$('.MainbigTitle').html(`
<h5 class="text-center"> Safaris</h5>
`);
$('.MyRequest_table').html("");

}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;


}

function BonusValueCalcul(thisData)
{
    var bonusQty=$('.bonusQty').val();//as reference qty
    $('.bonusValue').val(parseInt(thisData.value)/parseInt(bonusQty));


}
function giftBonusValueCalcul(thisData)
{
    var bonusQty=$('.bonusQty').val();
    $('.giftPerPcs').val(parseInt(thisData.value)/parseInt(bonusQty));

}

function SetupQuickBonus(){//Company
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");

   $.ajax({

url:`./api/SetupQuickBonus`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
    dataType: "json",
data:$('.formDataCreate').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();

 //ViewAllProducts();

    alert("Promotion Created Successfully");
    $('.formDataCreate :input').val("");
    $('.mycreateProduct').val("Submit");

   // LoadSavedComeFrom();

}
else{
alert("Something is wrong please contact system Admin");
$('.cover-spin').hide();

}



},
error:function(data){
    console.log(data);
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}
//Quickie Bonus //

/*New SafariStock Code */
function CheckSafariStock(){

closeNav();

/*  $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
$('.MainForm').html("");*/
SafariStockForm();
//$('.viewOrder').modal('show');
return false;
}

function LoadSafariStockAddItemBtnTemplate(data){

$('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseStockSafari('${data.safariuid}')">Close Safari</button></h5>
`);
$('.MyRequest_table').html("");
var getData=`
<hr>
<h6 class="text-center text-danger">${data.name}</h6>
<hr>

<div class="pb-2 ">
<button type="button" class="btn btn-danger" onclick="return spendButton('${btoa(JSON.stringify(data))}')">Spending</button>


<button type="button" class="btn btn-dark" onclick="return gainButton('${btoa(JSON.stringify(data))}')">Gain</button>


</div>
`;




$('.MainForm').html(getData);
}
function LoadSafariStockItemTemplate(data,safariName){
    //
console.log(data);
    /*var resultDataInterest=data.CalculateInterest;
    var resultData=data.ProductResult;
    var resultDataSpend=data.OtherSpend;*/


$('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseStockSafari('${data.safariuid}')">Close Safari</button></h5>

`);
$('.MyRequest_table').html("");



getData=`
<h6 class="text-center"><span class="text-primary">${atob(safariName)}</span></h6>
<h6 class="text-right ${(data.interest[0].buyout==null?"d-none":"")}"><span class="text-primary">Total Buyout:</span>${data.interest[0].buyout} $</h6>

<h6 class="text-right ${(data.interest[0].Soldout==null?"d-none":"")}"><span class="text-primary">Tot SoldOut Price:</span><span>${data.interest[0].Soldout} $</span></h6>
<h6 class="text-right"><hr></h6>
<h6 class="text-right ${(data.interest[0].interest==null?"d-none":"")}"><span class="text-danger">Profit</span>:<span >${data.interest[0].interest}</span></h6>
<div class="flex-center">


<div class="form-group">
<label>Safari Name:${atob(safariName)}</label>

</div>
<div class="form-group ${(data.interest[0].TotQty==null?"d-none":"")}">
<label title="Total Qty">Total Qty:${data.interest[0].TotQty}</label>

</div>

<div class="form-group  ${(data.interest[0].QtySoldOut==null?"d-none":"")}">
<label title="Total Qty SoldOUT">SoldOut:<span>${data.interest[0].QtySoldOut} </span></label>

</div>
<div class="form-group">
<label title="Total Qty LEFT">Qty Left:<span>${(data.interest[0].TotQty)-(data.interest[0].QtySoldOut)} </span></label>

</div>



</div>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormCalcItemSafariStock('${btoa(JSON.stringify(data))}','spendProduct')">Products</button>

<button type="button" class="btn btn-danger d-none" onclick="return FormAddItemSafariStockSpent('${btoa(JSON.stringify(data))}','spendSafari')">Others</button>
</div>
<div class="pb-2 d-none">
<button type="button" class="btn btn-danger" onclick="return spendButton('${btoa(JSON.stringify(data))}')">Spending</button>


<button type="button" class="btn btn-dark" onclick="return gainButton('${btoa(JSON.stringify(data))}')">Gain</button>


</div>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">By</button>
    <div class="dropdown-menu">
    <a class="dropdown-item" href="#SearchByCode" onclick="return chooseSearchStock('${chooseSearchStock}')">Code</a>
      <a class="dropdown-item" href="#SearchByName" onclick="return chooseSearchStock('${chooseSearchStock}')">name</a>
    </div>
  </div>

  <input type="text" class="form-control searchProductTable" aria-label="Text input with dropdown button" placeholder="Search by Code" onkeyup="return SeachProductStock('${safariName}','${data.safariuid}',this)">
</div>
`;
//console.log(data);

getData+=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col" >#</th>
<th scope="col">Name</th>
<th scope="col">Fact Price $</th>
<th scope="col">Init qty</th>
<th scope="col">Spending</th>
<th scope="col">SoldOut Qty</th>
<th scope="col">SoldOut $</th>
<th scope="col">updated_at</th>



</tr>
</thead >
<tbody >
`;
var resultData=data["result"];
console.log(resultData);
for(var i=0;i<resultData.length;i++){
var resultObject=resultData[i];
 getData+=`

 <tr >

  <td data-label="#" ><i class="fas fa-trash text-danger mylogout " title="Delete This Product in Safari" onclick="return deleteStockQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')"></i>  ${i+1}</td>
  <td data-label="Name">${resultData[i].productCode}</td>
  <td data-label="Fact Price $">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1" onchange="return  OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" onkeyup="return OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" contenteditable="true">${resultData[i].price}</span><span class="${"Price_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
  </td>
  <td data-label="Init qty">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1 test" onchange="return  OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" onkeyup="return OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" contenteditable="true">${resultData[i].totQty}</span><span class="${"Qty_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
 </td>
  <td data-label="Spending">${resultData[i].TotBuyAmount}</td>
  <td data-label="SoldOut Qty">${resultData[i].SoldOut}</td>
  <td data-label="SoldOut $">${resultData[i].TotSoldAmount}</td>
  <td data-label="updated_at">${resultData[i].updated_at}</td>



</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);



    //
}

function chooseSearchStock(optionsearch)
{
    if(optionsearch==="1")
    {
        chooseSearchStock=optionsearch;

        $(".searchProductTable").attr("placeholder", "Search By Code");

    }
    else{
        chooseSearchStock=optionsearch;

        $(".searchProductTable").attr("placeholder", "Search By Product Name");
    }
}
function SeachProductStock(safariName,safariId,thisData)
{
    console.log(safariId);
   var searchProductTable=$('.searchProductTable').val();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/displayCalculate`,
type:'get',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
"safariId":safariId,
"name":"Mbona",
"actionStatus":"Search",
"productSearch":thisData.value,
"isproductCode":(chooseSearchStock===1)?"true":"false"


},
success:function(data){
if(data.status){//return data as true
$('.cover-spin').hide();

 getData="";
var resultData=data["result"];
 for(var i=0;i<resultData.length;i++){
 var resultObject=resultData[i];
     getData+=`  <tr>
  <td data-label="#"><i class="fas fa-trash text-danger mylogout " title="Delete This Product in Safari" onclick="return deleteStockQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')"></i>  ${i+1}</td>
  <td data-label="Name">${resultData[i].productCode}</td>
  <td data-label="Fact Price $">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1" onchange="return  OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" onkeyup="return OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" contenteditable="true">${resultData[i].price}</span><span class="${"Price_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
  </td>
  <td data-label="Init qty">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1 test" onchange="return  OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" onkeyup="return OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this,'${safariName}')" contenteditable="true">${resultData[i].totQty}</span><span class="${"Qty_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
 </td>
  <td data-label="Spending">${resultData[i].TotBuyAmount}</td>
  <td data-label="SoldOut Qty">${resultData[i].SoldOut}</td>
  <td data-label="SoldOut $">${resultData[i].TotSoldAmount}</td>
  <td data-label="updated_at">${resultData[i].updated_at}</td>



</tr>`;

 }
 $('.viewReqTable tbody').html(getData);




}
else{
    $('.cover-spin').hide();
//alert("This Product has been used Please Contact System Admin if you want to edit this Quantity");

}



},
error:function(data){
     $('.cover-spin').hide();
}
});
}
function OnChangeInitQty(dataPass,thisdata,safari)
{



    var initQty=Number(thisdata.innerText);
    if (!(typeof(initQty) === "number" && initQty >= 0)) return null;
    console.log(dataPass);
    data=atob(dataPass);
    data=JSON.parse(data);
    console.log(data);
    var classData=(data["productCode"]).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '');
    console.log(classData);
    //classData=atob(classData);
   // classData="YWtheXVuZ2lybyBrYW5pbmkga2ljeWF5aSAoNTAgZHpuKQ==";

    $(`.${"Qty_"+classData}`).html(`<i class="fas fa-check text-success mylogout" onclick="return EditStockQty('${dataPass}','${btoa(initQty)}','${safari}')"></i>`);

}
function EditStockQty(dataPass,initQty,safari)
{
    dataV=atob(dataPass);
   dataV=JSON.parse(dataV);
    $('.cover-spin').show();

var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/EditStockQty`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
productCode:dataV["productCode"],
safariId:dataV["safariId"],
prevQty:dataV["totQty"],
qty:atob(initQty),


},
success:function(data){
if(data.status){//return data as true
$('.cover-spin').hide();

var safariId=btoa(dataV["safariId"]);

ViewItemSafariStock(safariId,safari);


}
else{
    $('.cover-spin').hide();
alert("This Product has been used Please Contact System Admin if you want to edit this Quantity");

}



},
error:function(data){
    $('.cover-spin').hide();
}
});
}
function deleteStockQty(dataPass,initQty,safari)
{
    dataV=atob(dataPass);
   dataV=JSON.parse(dataV);
    if(confirm(`Do you Want Delete ${dataV["ProductName"]} in this Safari?`))
    {

    $('.cover-spin').show();

var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/deleteStockQty`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
productCode:dataV["productCode"],
safariId:dataV["safariId"]



},
success:function(data){
if(data.status){//return data as true
$('.cover-spin').hide();

var safariId=btoa(dataV["safariId"]);

ViewItemSafariStock(safariId,safari);


}
else{
    $('.cover-spin').hide();
alert("This Product has been used Please Contact System Admin if you want to edit this Quantity");

}



},
error:function(data){
    $('.cover-spin').hide();
}
});
}
}
function OnChangeFactPrice(dataPass,thisdata,safari)
{
    var factPrice=Number(thisdata.innerText);
    if (!(typeof(factPrice) === "number" && factPrice >= 0)) return null;
    console.log(dataPass);
    data=atob(dataPass);
    data=JSON.parse(data);
    console.log(data);
    var classData=(data["productCode"]).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '');
    $(`.${"Price_"+classData}`).html(`<i class="fas fa-check text-success mylogout" onclick="return EditStockFactPrice('${dataPass}','${btoa(factPrice)}','${safari}')"></i>`);
}
function EditStockFactPrice(dataPass,factPrice,safari)
{
    dataV=atob(dataPass);
    dataV=JSON.parse(dataV);
    $('.cover-spin').show();

var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/EditStockFactPrice`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
productCode:dataV["productCode"],
safariId:dataV["safariId"],
price:atob(factPrice),


},
success:function(data){
if(data.status){//return data as true
$('.cover-spin').hide();

var safariId=btoa(dataV["safariId"]);

ViewItemSafariStock(safariId,safari);


}
else{
    $('.cover-spin').hide();
alert("This Product has been used Please Contact System Admin if you want to edit this Factory Price");

}



},
error:function(data){
    $('.cover-spin').hide();
}
});
}

function ViewEditItemSafariStock(id,uid,safariuid,qty,price,pcs,comment,name,SoldInterest){


$('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Item</strong></h5>`)
$('.ModalPassword').html(`

<form class="formEditItemSafariStock" onsubmit="return SafariStockEditItem()">
<div class="p-2">
<div class="form-group ">
<input type="hidden" class="form-control" name="id" value="${atob(id)}"/>
<input type="hidden" class="form-control" name="safariuid" value="${atob(safariuid)}"/>
<input type="hidden" class="form-control" name="name" value="${atob(name)}"/>
<input type="hidden" class="form-control" name="SoldInterest" value="${atob(SoldInterest)}"/>


</div>

<div class="form-group ">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="uid" onkeyup="SafariStockautoCompleteTopItem(this,'${btoa('product')}')" value="${atob(uid)}" required/>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" value="${atob(qty)}" required/>
</div>

<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" value="${atob(price)}" required/>
</div>

<div class="form-group ">
<label>pcs in 1BDS</label>
<input type="text" class="form-control" name="pcs" value="${atob(pcs)}" required/>
</div>

<div class="form-group">
<label for="exampleFormControlTextarea3">Enter Comment</label>
<textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7">${atob(comment)}</textarea>
</div>




<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`);
EmptyautoCompleteTopItem();
}
function OnChangeSoldIntStock(thisdata,id,uid,safariuid,qty,price,pcs,comment,name,SoldInterest){
   // $('.cover-spin').show();
  //console.log(thisdata.innerHTML);
  var solidData=Number(thisdata.innerHTML);
  if(isNaN(solidData)) {
  console.log("num is a number");
}
else{
    if(solidData=="")
    {
        console.log("empty");
    }
    else{
        //console.log(solidData);
        //
        var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariStockEditItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
    id:atob(id),
    uid:atob(uid),
    safariuid:atob(safariuid),
    qty:atob(qty),
    price:atob(price),
    pcs:atob(pcs),
    comment:atob(comment),
    name:atob(name),
    SoldInterest:solidData

},
success:function(data){
if(data.status){//return data as true
   // $('.cover-spin').hide();
    //console.log(`done $${CalculateDeclClass}`);
    $('.viewOrder').modal('hide');
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariId=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafari(safariId,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
        //
    }

}
return false;
}
function SafariStockEditItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariStockEditItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formEditItemSafari').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    //console.log(`done $${CalculateDeclClass}`);
    $('.viewOrder').modal('hide');
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariuid=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafari(safariuid,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}
function DeleteItemSafariStock(id,uid,name,profit,transpfees){
    if(confirm(`Do you Want Delete ${name} in this Safari?`))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeleteItemSafariStock`,//close Safari
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    id:id,
    uid:uid,
    profit:profit,
    transpfees:transpfees
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   CheckSafariStock();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;

    }

}
function FormCloseSafariStock(uid){
    if(confirm('Do you Want to Close this Safari?'))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminCloseSafariStock`,//close Safari
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   AllOpenSaleReport();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
    }

}
function SafariStockForm(){

    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Create Safari</strong></h5>`)
$('.ModalPassword').html(`
<form class="formSafariCreate" onsubmit="return formSafariStockCreate()">
<div class="p-2">
<div class="form-group ">
<label>Enter Name</label>
<input type="text" class="form-control" name="name" required/>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7"></textarea>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}

function formSafariStockCreate(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/CreateSafari`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formSafariCreate').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    ViewSafariStock('name',false);
    //LoadSafariStockItemTemplate(data);
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}

function gainButton(dataPass){

//show gainButtons
data=atob(dataPass);
    data=JSON.parse(data);
    console.log(data);
$('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseStockSafari('${data.safariuid}')">Close Safari</button></h5>
`);
$('.MyRequest_table').html("");
var getData=`
<hr>
<h4 class="text-center text-primary">Gaining </h4>
<h6 class="text-center text-danger">${data.name}</h6>
<hr>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormCalcItemSafariStock('${dataPass}','gainProduct')">Product</button>

<button type="button" class="btn btn-danger" onclick="return FormAddItemSafariStockSpent('${dataPass}','gainOthers')">Others</button>
</div>
`;




$('.MainForm').html(getData);
}
function spendButton(dataPass){
    data=atob(dataPass);
    data=JSON.parse(data);
//show spendButtons
$('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseStockSafari('${data.safariuid}')">Close Safari</button></h5>
`);
$('.MyRequest_table').html("");
var getData=`
<hr>
<h4 class="text-center text-danger">Spending </h4>
<h6 class="text-center text-danger">${data.name} </h6>

<hr>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormCalcItemSafariStock('${dataPass}','spendProduct')">Products</button>

<button type="button" class="btn btn-danger" onclick="return FormAddItemSafariStockSpent('${dataPass}','spendSafari')">Others</button>
</div>
`;




$('.MainForm').html(getData);

}
function FormCalcItemSafariStock(dataPass,status)
{
    data=atob(dataPass);
    data=JSON.parse(data);
    console.log(data);
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item ${data.name}</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemSafariStock" onsubmit="return SafariStockAddItem()">
<div class="p-2">

<div class="form-group d-none">
<label>Safari Name</label>
<input type="text" class="form-control" name="name" value="${data.name}"/>
<input type="hidden" class="form-control" name="uid" value="${data.safariuid}"/>
</div>
<div class="form-group ">

<input type="hidden" class="form-control" name="safariId" value="${data.safariuid}"/>

<input type="hidden" class="form-control" name="status" value="${status}"/>
<input type="hidden" class="form-control" name="typeData" value="spend"/>

</div>
<div class="form-group right-inner-addon">
<label>Search Product<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="autoCompleteStock(this)" name="productCode" placeholder="Enter Product Code" required/>
<span class="autocompleteIcon" onclick="hidePopup()"><i class="fas fa-exclamation-triangle text-danger" ></i></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group isProductExist">
<label>Product Name</label>
<input type="text" class="form-control productCodeClass productCodePopup" name="productName"  required/>
</div>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" value="0" />
</div>
<div class="form-group ">
<label>Factory Price</label>
<input type="text" class="form-control" name="fact_price" />
</div>

<div class="form-group isProductNotExist">
<label>Price</label>
<input type="text" class="form-control" name="price" />
</div>


<div class="form-group ComeFromLoader isProductNotExist">

</div>

<div class="form-group isProductNotExist">
<label>Pcs</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group isProductNotExist">
<label>tags</label>
<input type="text" class="form-control" name="tags" />
</div>
<div class="form-group d-none">
<label>Active</label>
<input type="text" class="form-control" name="active" value="on"/>
<input type="text" class="form-control" name="CommentStatus" value="Inserting Product"/>
</div>


<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="description" placeholder="Enter Comment" rows="7"></textarea>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
LoadSavedComeFrom();
    //

}
function hidePopup(){
    $('.productCodePopup').val("");
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html(`<i class="fas fa-check text-success"></i>`);
    $('.isProductExist').show();
    $('.isProductNotExist').show()
}

function FormAddItemSafariStockSpent(dataPass,status)
{
    data=atob(dataPass);
    data=JSON.parse(data);
    console.log(data);
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item ${data.name}</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemSafariStock" onsubmit="return SafariSpendAddItem()">
<div class="p-2">

<div class="form-group d-none">
<label>Safari Name</label>
<input type="text" class="form-control" name="safariName" value="${data.name}"/>
<input type="text" class="form-control" name="uid" value="${data.safariuid}"/>
</div>
<div class="form-group ">

<input type="hidden" class="form-control" name="safariId" value="${data.safariuid}"/>
<input type="hidden" class="form-control" name="options" value="spendSafari"/>



</div>
<div class="form-group right-inner-addon">
<label>Eter Purpose<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="autoCompleteSpendPurpose(this)" name="purpose" required/>
<span class="autocompleteIcon" onclick="hidePopup()"><i class="fas fa-exclamation-triangle text-danger" ></i></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>




<div class="form-group ">
<label>Price</label>
<input type="number" class="form-control" name="balance" required/>
</div>








<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="commentData" placeholder="Enter Comment" rows="7"></textarea>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)

    //

}
function FormCalcItemSafariStock2(dataPass,status){

$('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item ${atob(safariName)}</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemSafari" onsubmit="return SafariAddItem()">
<div class="p-2">
<div class="form-group ">


<input type="hidden" class="form-control" name="safariuid" value="${atob(safariuid)}"/>
<input type="hidden" class="form-control" name="name" value="${atob(safariName)}"/>
<input type="hidden" class="form-control" name="typeData" value="product"/>

</div>

<div class="form-group right-inner-addon">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="uid" onkeyup="SafariautoCompleteTopItem(this,'${btoa("product")}')" required/>
<span class="autocompleteIcon"></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" required/>
</div>
<div class="form-group ">
<label>Add Pcs in 1BDS</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" required/>
</div>


<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" placeholder="Enter Comment" rows="7"></textarea>
</div>


<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}


function EmptyautoCompleteTopItem(){
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html("");
}
function SafariautoCompleteTopItem(thisdata,typeData){
//

if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SafariStockItemSearch`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    ItemName:thisdata.value,
    typeData:atob(typeData)
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemDeclar('${data[i].uid}')">
    ${data[i].uid}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);
 $(`.autocompleteIcon`).html(`<i class="fa fa-times-circle text-danger" onclick="return EmptyautoCompleteTopItem()"></i>`);



}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
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
function addItemStockDeclar(itemName){
    $('.item_nameAdd').val(itemName);
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
}
function SafariStockAddItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/CreateStockProduct`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formAddItemSafariStock').serialize(),
success:function(data){
if(data.status){//return data as true
    console.log(data);
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
   // console.log(`done $${CalculateDeclClass}`);

    $('.formAddItemSafari .form-control').val("");
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariuid=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafariStock(safariuid,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    $('.cover-spin').hide();
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}



function AdminSafariStockCalculate(uid,plaque,transpfees,profit,totClass){
    var totalqty=$(`.${totClass}`).text();
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminSafariStockCalculate`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
    plaque:plaque,
    transpfees:transpfees,
    profit:profit,
    totalqty:totalqty
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    console.log(data.xdata);
    CheckSafari();
 //console.log(hashfunction);


}
else{
    alert("already updated");
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

function ViewSafariStock(name,searchVal){
    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/GetSafaris`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    searchOption:searchVal,
    name:name,
},

success:function(data){


if(data.status){//return data as true


var resultData=data.result;


$('.MainbigTitle').html(`
<h5 class="text-center"> Safaris</h5>

`);
$('.MyRequest_table').html("");
getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col">Comment</th>
<th scope="col">Created At</th>
<th scope="col">Action</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
  <td data-label="#">${i+1}</td>
  <td data-label="Name">${resultData[i].name}</td>
  <td data-label="Comment">${resultData[i].comment}</td>
  <td data-label="CreatedAt">${resultData[i].created_at}</td>
  <td data-label="Action"><i class="fas fa-eye text-primary mylogout" title="View Safari Items Load" onClick="return ViewItemSafariStock('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}')"></i> <i class="fas fa-edit text-primary mylogout" title="Edit this Safari" onClick="return ViewEditSafari('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}','${btoa(resultData[i].comment)}','${btoa(resultData[i].uidCreator)}','${btoa(resultData[i].subscriber)}')"></i> <i class="fas fa-trash text-dark mylogout " title="Delete This Safari" onClick="return DeleteSafari('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}','${btoa(resultData[i].comment)}','${btoa(resultData[i].uidCreator)}','${btoa(resultData[i].subscriber)}')"></i></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);



//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




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
function ProductSafariStock(){
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">  <strong>Dump Or Restore Product Quantity</strong></h5>`)
    $('.ModalPassword ').html(`
    <div class="card-body">
    <div class="form-group right-inner-addon ">
<label>Search Product<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="autoCompleteProductQty(this)" name="productCode" placeholder="Enter Product Code" required/>
<span class="autocompleteIcon" onclick="hidePopup()"><i class="fas fa-exclamation-triangle text-danger" ></i></span>
</div>


<div class="autoCompleteTopItemData"></div>



<div class="modal fade ModaldumpT" id="largeModal" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="largeModalLabel">Large Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="dumpRest">

</div>
      </div>
    </div>
  </div>
</div>

</div>
    `);
}
function autoCompleteProductQty(thisdata)
{
    $('.autocompleteIcon').html(`<i class="fas fa-exclamation-triangle text-danger onclick="hidePopup()"></i>`);
    //
        if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/Products`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
    headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    productCode:thisdata.value,
    productName:"none",
    productQr:"none",
    isProductAction:"search",//product get Action(search,edit,view)
    LimitStart:1,  //page
    LimitEnd:10,
},
success:function(data){
if(data.status){//return data as true

    //$('.autoCompleteTopItem').show();



var data=data.result;
 var getdata=`<ul class="list-group">`;
 for(var i=0;i<data.length;i++){
     console.log(data);
     var reqQty1=`reqQty_${[i]}`;
     var productClass1=`product_${[i]}`;

    getdata+=`
    <ul class="list-group ">
  <li class="list-group-item text-primary mb-2">
   <strong class="d-flex justify-content-between align-items-center">
   <span>${data[i].productCode}(${data[i].pcs}pcs)</span>

    <div>

  <button class="btn btn-sm btn-danger" onclick="return stockdumprestore('${i}','${'views_this_stock'}','${'none'}')">
   TotQty:<span class="totQty_${[i]}">${data[i].qty}</span>
  </button>
</div>
</strong>
    <ul class="list-group">
      <!-- Existing Answer -->
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          a) <span contenteditable="true" class="editable-dotline editable0_0 " onkeyup="return myupdateDataJob(this,'button0_0')">${truncScreen(data[i].ProductName)} (Qty Left:<span class="QtyLeft_${[i]}">${data[i].qty-data[i].qty_sold}</span>)</span>
        </span>
        <div>
          <button class="btn btn-sm btn-outline-success me-1 button0_0" onclick="return stockdumprestore('${i}','${'view_stock_lose_restore'}','${'Open'}')"><i class="fas fa-eye"></i> Deduct</button>
          <button class="btn btn-sm btn-outline-danger" onclick="return stockdumprestore('${i}','${'view_stock_lose_restore'}','${'restore'}')"><i class="fas fa-eye"></i> Restock</button>
        </div>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          b) <span contenteditable="true" class="editable-dotline editable0_0" onkeyup="return myupdateDataJob(this,'button0_0')">${data[i].tags}</span>
        </span>

      </li>

      <!-- Add New Answer -->
      <li class="list-group-item">
      <div class="relat">
        <div class="input-group">
          <input type="number" class="form-control ${reqQty1}" placeholder="Enter Qty to reduce or Restore Stock">
          <input type="hidden" class="form-control ${productClass1}" placeholder="New answer" value="${data[i].productCode}">
          <input type="hidden" class="form-control cQty_${i}" placeholder="New answer" value="${data[i].qty}">
          <button class="btn btn-sm btn-outline-primary me-1" onclick="return stoleRestore('${[i]}','1')">Deduct</button>
          <button class="btn btn-sm btn-outline-secondary" onclick="return stoleRestore('${[i]}','2')">Restock</button>
        </div>
        <i class="fas fa-comments text-danger d-flex justify-content-center mylogout" onclick="return showComment('${i}')"></i>
        <textarea  class="form-control commentDataForm commentData_${i}"  rows="4"></textarea>
        </div>
      </li>
    </ul>
  </li>
</ul>


    `;

 }
 getdata+=` </ul>`;
 $('.autoCompleteTopItemData').html(getdata);
 $(`.commentDataForm`).hide();








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

function showComment(indexData){
    $(`.commentDataForm`).hide();
    $(`.commentData_${indexData}`).show();

}
function truncScreen(str)
{
   // console.log(str);
    if (window.innerWidth <= 600) {
  //console.log("Mobile screen");
  return truncateString(str,5);
} else {
   return truncateString(str,20);
}
}
function truncateString(str, maxLength) {
  if (str.length <= maxLength) return str;
  return str.substring(0, maxLength) + '...';
}
function stoleRestore(indexData,Action,cQty)
{
var inputAction=(Action==="1")?'stocklose':"stockrestore";
var inputAction1=(Action==="1")?'Reduce':"Restore";

var reqQty1=parseInt($(`.reqQty_${indexData}`).val());
var QtyLeft=parseInt($(`.QtyLeft_${indexData}`).text());
var totQty=$(`.totQty_${indexData}`).text();
var cQty=$(`.cQty_${indexData}`).val();
var remain1=parseInt(cQty)-parseInt(reqQty1);
var remain2=parseInt(cQty)+parseInt(reqQty1);
var remaining=(Action==="1")?remain1:remain2;
var Qty_left=(Action==="1")?(QtyLeft-reqQty1):(QtyLeft+reqQty1);
var productClass1=$(`.product_${indexData}`).val();


if(!(Number.isNaN(reqQty1)))
{

    if(confirm(`Are you Sure you want to ${inputAction1}  ${reqQty1} Quantity of ${productClass1}? Qty will be ${remaining} `))
{
    if((Action==="1")&&(parseInt(cQty)<parseInt(reqQty1)))
    {
        //$(`.QtyLeft_${indexData}`).text(cQty-reqQty1);
       // $(`.totQty_${indexData}`).text(cQty-reqQty1);
      alert("Quantity you are requesting is greater than actual Quantity");
    }
    else{
        var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/Products`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        //"Authorization": `Bearer ${Usertoken}`
    },
    headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    productCode:productClass1,
    req_qty:`${reqQty1}`,
    productName:"none",
    productQr:"none",
    isProductAction:"stockloserestore",
    inputAction:inputAction,
    commentData:$(`.commentData_${indexData}`).val(),
    LimitStart:1,  //page
    LimitEnd:10,
},
success:function(data){
if(data.status){//return data as true
    $(`.totQty_${indexData}`).text(remaining);
    $(`.cQty_${indexData}`).val(remaining);
    $(`.QtyLeft_${indexData}`).text(Qty_left);

alert("Action executed Successfully");
//console.log("Action executed Successfully")





}
else{
//alert("Something Wrong");
console.log("Something Wrong")

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    }

}

}
else{
    alert("Requested Quantity must be Valid Number")
}

    return false;

}
function stockdumprestore(indexData,loadDumporRest,statusPost)
{

    var productClass1=$(`.product_${indexData}`).val();

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/Products`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
    productCode:productClass1,
    productName:"none",
    productQr:"none",
    isProductAction:loadDumporRest,//product get Action(search,edit,view)
    LimitStart:1,  //page
    LimitEnd:10,
    status:statusPost
},
success:function(data){
if(data.status){//return data as true

    $('.ModaldumpT').modal('show');
    window[loadDumporRest](data);






}
else{

    alert("No Result Found")


}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}
function views_this_stock(data){
    hidePopup();

    getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col" >#</th>
<th scope="col">Name</th>
<th scope="col">Fact Price $</th>
<th scope="col">Init qty</th>
<th scope="col">Spending</th>
<th scope="col">SoldOut Qty</th>
<th scope="col">SoldOut $</th>
<th scope="col">updated_at</th>



</tr>
</thead >
<tbody >
`;
var resultData=data["result"];
console.log(resultData);
for(var i=0;i<resultData.length;i++){
var resultObject=resultData[i];
 getData+=`

 <tr >

  <td data-label="#" ><i class="fas fa-trash text-danger mylogout " title="Delete This Product in Safari" onclick="return deleteStockQty('${btoa(JSON.stringify(resultObject))}',this)"></i>  ${i+1}</td>
  <td data-label="Name">${resultData[i].productCode}</td>
  <td data-label="Fact Price $">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1" onchange="return  OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this)" onkeyup="return OnChangeFactPrice('${btoa(JSON.stringify(resultObject))}',this)" contenteditable="true">${resultData[i].price}</span><span class="${"Price_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
  </td>
  <td data-label="Init qty">
  ${(resultData[i].status!='spendSafaris')?`<span class="Formchange" id="CustomPrice_Add_1 test" onchange="return  OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this)" onkeyup="return OnChangeInitQty('${btoa(JSON.stringify(resultObject))}',this)" contenteditable="true">${resultData[i].totQty}</span><span class="${"Qty_"+(resultData[i].productCode).replace(/[-!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~_.\s'`]/g, '')}"></span>`:'Spending'}
 </td>
  <td data-label="Spending">${resultData[i].TotBuyAmount}</td>
  <td data-label="SoldOut Qty">${resultData[i].SoldOut}</td>
  <td data-label="SoldOut $">${resultData[i].TotSoldAmount}</td>
  <td data-label="updated_at">${resultData[i].updated_at}</td>



</tr>`;

}
getData+=`
</tbody>
</table>`;
$('.dumpRest').html(getData);
}
function view_stock_lose_restore(data){
    console.log(data);

    hidePopup();

    getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col" >#</th>
<th scope="col">Name</th>
<th scope="col">Fact Price $</th>
<th scope="col">Init qty</th>
<th scope="col">created_at</th>



</tr>
</thead >
<tbody >
`;
var resultData=data["result"];
console.log(resultData);
for(var i=0;i<resultData.length;i++){
var resultObject=resultData[i];
 getData+=`

 <tr >


  <td data-label="Name">${i+1}</td>
  <td data-label="Name">${resultData[i].productCode}</td>
  <td data-label="SoldOut Qty">${resultData[i].price}</td>
  <td data-label="SoldOut $">${resultData[i].qty}</td>
  <td data-label="updated_at">${resultData[i].created_at}</td>



</tr>`;

}
getData+=`
</tbody>
</table>`;
$('.dumpRest').html(getData);
}

function ViewEditSafariStock(uid,name,comment,uidCreator,subscriber){
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Safari</strong></h5>`)
$('.ModalPassword').html(`
<form class="formSafariEdit" onsubmit="return SafariEdit()">
<div class="p-2">
<div class="form-group ">
<label>Name</label>
<input type="hidden" class="form-control" name="uid" value="${atob(uid)}" required/>
<input type="text" class="form-control" name="name" value="${atob(name)}" required/>
</div>

<div class="form-group ">
<label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7">${atob(comment)}</textarea>

</div>





<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}
function SafariStockEdit(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/EditSafari`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formSafariStockEdit').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    ViewSafariStock('name',false);
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
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

function ViewItemSafariStock(uid,name){

    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/displayCalculate`,
type:'get',
data: {
safariId:atob(uid),
name:atob(name),
actionStatus:"calculInterest",
productSearch:"t",
isproductCode:"false"
},
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true

LoadSafariStockItemTemplate(data,name);



}
else{
    LoadSafariStockAddItemBtnTemplate(data);
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



/*New SafariStock Code */

//SafariCode Javascript//
function CheckSafari(){

    closeNav();

  /*  $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
$('.MainForm').html("");*/
    SafariForm();
    //$('.viewOrder').modal('show');
    return false;
}
function LoadSafariAddItemBtnTemplate(data){
    $('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseSafari('${data.safariuid}')">Close Safari</button></h5>
`);
$('.MyRequest_table').html("");
var getData=`
<hr>
<h6 class="text-center text-danger">${data.name}</h6>
<hr>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormAddItemSafari('${btoa(data.safariuid)}','${btoa(data.name)}')">Add Product Item</button>

<button type="button" class="btn btn-primary" onclick="return FormAddItemSafariSpent('${btoa(data.safariuid)}','${btoa(data.name)}')">Add Spending</button>
</div>
`;




$('.MainForm').html(getData);
}

function LoadSafariItemTemplate(data){
    //

    var resultDataInterest=data.CalculateInterest;
    var resultData=data.ProductResult;
    var resultDataSpend=data.OtherSpend;


$('.MainbigTitle').html(`
<h5 class="text-center d-none"> <button type="button" class="btn btn-danger" onclick="return FormCloseSafari('${data.safariuid}')">Close Safari</button></h5>
`);
$('.MyRequest_table').html("");

getSpending=`
<hr>
<h6 class="text-center text-danger">Spending Table</h6>
<hr>
<table class="viewReqTable mytable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col" title="Price of All Qty Before any other spend">Price A</th>

<th scope="col">Comment</th>
<th scope="col">Created at</th>


</tr>
</thead>
<tbody>
`;
for(var i=0;i<resultDataSpend.length;i++){

getSpending+=`

<tr>
 <td data-label="#">${i+1}</td>
 <td data-label="Name">${resultDataSpend[i].name}</td>
 <td data-label="Price A" title="Price of All Qty Before any other spend">${resultDataSpend[i].price}</td>

 <td data-label="comment" >${resultDataSpend[i].comment}</td>
 <td data-label="created_at" >${resultDataSpend[i].created_at}</td>



</tr>`;

}
getSpending+=`
</tbody>
</table>`;

getData=`
<h6 class="text-center"><span class="text-primary">${data.name}</span></h6>
<h6 class="text-right"><span class="text-primary">Total Product:</span>${resultDataInterest.TotalBuyProduct} $</h6>

<h6 class="text-right"><span class="text-primary">Tot Sold Price:</span><span>${resultDataInterest.TotalSoldProduct} $</span></h6>
<h6 class="text-right"><hr></h6>
<h6 class="text-right"><span class="text-danger">Profit</span>:<span >${resultDataInterest.interest}</span></h6>
<div class="flex-center">


<div class="form-group">
<label>Safari Name:${data.name}</label>

</div>
<div class="form-group">
<label title="Total Qty of product">Total Qty:${data.TotalQtyProduct}</label>

</div>

<div class="form-group">
<label title="Total Of Price of Other Spending">Total Price:<span>${data.TotalPriceOtherSpend} $</span></label>

</div>



</div>

<div class="pb-2">

<button type="button" class="btn btn-primary" onclick="return FormAddItemSafariSpent('${btoa(data.safariuid)}','${btoa(data.name)}')">Add Spending</button>
</div>

${getSpending}

<hr>
<h6 class="text-center text-danger">Product Table</h6>
<hr>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormAddItemSafari('${btoa(data.safariuid)}','${btoa(data.name)}')">Add Product Item</button>
</div>
<table class="viewReqTable mytable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col">Qty</th>
<th scope="col" title="Price of All Qty Before any other spend">Price A</th>
<th scope="col">PCS</th>
<th scope="col" title="Price per 1 pieces after any other spend">Price 1PC</th>
<th scope="col" title="Price per 1 Bds after any other spend">Price 1Bds</th>
<th scope="col" title="Price Per Qty after any other spend">Price SumQty</th>

<th scope="col" title="Price That Will Add After Spend">Price A</th>
<th scope="col" title="Add Margin Interest on Sold">Sold Int</th>
<th scope="col" title="Sold Price Per Piece">Sold Price 1PC</th>
<th scope="col" title="Sold Price Per 1BDS">Sold Price 1BDS</th>
<th scope="col" title="Sold Price Per Qty of BDS">Sold Price Qty</th>
<th scope="col">Comment</th>
<th scope="col">Created at</th>






<th scope="col">Action</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
  <td data-label="#">${i+1}</td>
  <td data-label="Items">${resultData[i].uid}</td>
  <td data-label="Qty">${resultData[i].qty}</td>
  <td data-label="Price A" title="Price of All Qty Before any other spend">${resultData[i].price}</td>
  <td data-label="PCS">${resultData[i].pcs}</td>
  <td data-label="Price 1PC" title="Price per 1 pieces after any other spend" class="text-primary">${resultData[i].pricePerPiece}</td>
  <td data-label="Price 1Bds" title="Price per 1 Bds after any other spend" class="text-primary">${resultData[i].ProductPriceOneQty}</td>
  <td data-label="Price ${resultData[i].qty}Bds" title="Price per ${resultData[i].qty} Bds after any other spend">${resultData[i].ProductPriceNumberQty}</td>

  <td data-label="Price A" title="Price That Will Add After Spend">${resultData[i].PriceToAdd}</td>
  <td data-label="Sold Int" title="Add Margin Interest on Sold"><span class="Formchange" id="CustomPrice_Add_1" onchange="return  OnChangeSoldInt(this,'${btoa(resultData[i].id)}','${btoa(resultData[i].uid)}','${btoa(resultData[i].safariuid)}','${btoa(resultData[i].qty)}','${btoa(resultData[i].price)}','${btoa(resultData[i].pcs)}','${btoa(resultData[i].comment)}','${btoa(data.name)}','${btoa(resultData[i].SoldInterestOneQty)}')" onkeyup="return OnChangeSoldInt(this,'${btoa(resultData[i].id)}','${btoa(resultData[i].uid)}','${btoa(resultData[i].safariuid)}','${btoa(resultData[i].qty)}','${btoa(resultData[i].price)}','${btoa(resultData[i].pcs)}','${btoa(resultData[i].comment)}','${btoa(data.name)}','${btoa(resultData[i].SoldInterest)}')" contenteditable="true">${resultData[i].SoldInterestOneQty}</span></td>
  <td data-label="Sold Price 1PC" title="Sold Price Per Piece" class="text-danger">${resultData[i].SoldPricePerPiece}</td>
  <td data-label="Sold Price 1BDS" title="Sold Price Per 1BDS" class="text-danger">${resultData[i].SoldPriceOneQty}</td>
  <td data-label="Sold Price${resultData[i].qty} Qty" title="Sold Price Per ${resultData[i].qty} Qty of BDS">${resultData[i].SoldPriceNumberQty}</td>
  <td data-label="comment" >${resultData[i].comment}</td>
  <td data-label="created_at" >${resultData[i].created_at}</td>


  <td data-label="Action"><i class="fas fa-edit text-primary mylogout" title="Edit this Items" onClick="return ViewEditItemSafari('${btoa(resultData[i].id)}','${btoa(resultData[i].uid)}','${btoa(resultData[i].safariuid)}','${btoa(resultData[i].qty)}','${btoa(resultData[i].price)}','${btoa(resultData[i].pcs)}','${btoa(resultData[i].comment)}','${btoa(data.name)}','${btoa(resultData[i].SoldInterestOneQty)}')"></i> <i class="fas fa-trash text-dark mylogout " title="Delete This Item" onClick="return DeleteItemSafari('${resultData[i].id}','${resultData[i].uid}','${resultData[i].name}','${data.profit}','${data.transpfees}')"></i></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);


    //
}
function ViewEditItemSafari(id,uid,safariuid,qty,price,pcs,comment,name,SoldInterest){


    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Item</strong></h5>`)
$('.ModalPassword').html(`

<form class="formEditItemSafari" onsubmit="return SafariEditItem()">
<div class="p-2">
<div class="form-group ">
<input type="hidden" class="form-control" name="id" value="${atob(id)}"/>
<input type="hidden" class="form-control" name="safariuid" value="${atob(safariuid)}"/>
<input type="hidden" class="form-control" name="name" value="${atob(name)}"/>
<input type="hidden" class="form-control" name="SoldInterest" value="${atob(SoldInterest)}"/>


</div>

<div class="form-group ">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="uid" onkeyup="SafariautoCompleteTopItem(this,'${btoa('product')}')" value="${atob(uid)}" required/>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" value="${atob(qty)}" required/>
</div>

<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" value="${atob(price)}" required/>
</div>

<div class="form-group ">
<label>pcs in 1BDS</label>
<input type="text" class="form-control" name="pcs" value="${atob(pcs)}" required/>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7">${atob(comment)}</textarea>
</div>




<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`);
EmptyautoCompleteTopItem();
}
function OnChangeSoldInt(thisdata,id,uid,safariuid,qty,price,pcs,comment,name,SoldInterest){
   // $('.cover-spin').show();
  //console.log(thisdata.innerHTML);
  var solidData=Number(thisdata.innerHTML);
  if(isNaN(solidData)) {
  console.log("num is a number");
}
else{
    if(solidData=="")
    {
        console.log("empty");
    }
    else{
        //console.log(solidData);
        //
        var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariEditItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
//dataType: "json",
data:{
    id:atob(id),
    uid:atob(uid),
    safariuid:atob(safariuid),
    qty:atob(qty),
    price:atob(price),
    pcs:atob(pcs),
    comment:atob(comment),
    name:atob(name),
    SoldInterest:solidData

},
success:function(data){
if(data.status){//return data as true
   // $('.cover-spin').hide();
    //console.log(`done $${CalculateDeclClass}`);
    $('.viewOrder').modal('hide');
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariId=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafari(safariId,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
        //
    }

}
return false;
}
function SafariEditItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariEditItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formEditItemSafari').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    //console.log(`done $${CalculateDeclClass}`);
    $('.viewOrder').modal('hide');
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariuid=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafari(safariuid,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}
function DeleteItemSafari(id,uid,name,profit,transpfees){
    if(confirm(`Do you Want Delete ${name} in this Safari?`))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeleteItemSafari`,//close Safari
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    id:id,
    uid:uid,
    profit:profit,
    transpfees:transpfees
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   CheckSafari();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;

    }

}
function FormCloseSafari(uid){
    if(confirm('Do you Want to Close this Safari?'))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminCloseSafari`,//close Safari
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   AllOpenSaleReport();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
    }

}
function SafariForm(){

    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center"> <strong>Create Safari</strong></h5>`)
$('.ModalPassword').html(`
<form class="formSafariCreate" onsubmit="return formSafariCreate()">
<div class="p-2">
<div class="form-group ">
<label>Enter Name</label>
<input type="text" class="form-control" name="name" required/>
</div>

<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7"></textarea>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}

function formSafariCreate(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariCreate`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formSafariCreate').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    LoadSafariItemTemplate(data);
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}


function FormAddItemSafariSpent(safariuid,safariName)
{

    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item ${atob(safariName)}</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemSafari" onsubmit="return SafariAddItem()">
<div class="p-2">
<div class="form-group ">

<input type="hidden" class="form-control" name="safariuid" value="${atob(safariuid)}"/>
<input type="hidden" class="form-control" name="name" value="${atob(safariName)}"/>
<input type="hidden" class="form-control" name="typeData" value="spend"/>

</div>

<div class="form-group right-inner-addon">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="uid" onkeyup="SafariautoCompleteTopItem(this,'${btoa('spend')}')" required/>
<span class="autocompleteIcon"></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group d-none">
<label>qty</label>
<input type="number" class="form-control" name="qty" value="0" />
</div>


<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" required/>
</div>


<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7"></textarea>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
    //

}
function FormAddItemSafari(safariuid,safariName){

$('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item ${atob(safariName)}</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemSafari" onsubmit="return SafariAddItem()">
<div class="p-2">
<div class="form-group ">


<input type="hidden" class="form-control" name="safariuid" value="${atob(safariuid)}"/>
<input type="hidden" class="form-control" name="name" value="${atob(safariName)}"/>
<input type="hidden" class="form-control" name="typeData" value="product"/>

</div>

<div class="form-group right-inner-addon">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="uid" onkeyup="SafariautoCompleteTopItem(this,'${btoa("product")}')" required/>
<span class="autocompleteIcon"></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" required/>
</div>
<div class="form-group ">
<label>Add Pcs in 1BDS</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" required/>
</div>


<div class="form-group">
  <label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" placeholder="Enter Comment" rows="7"></textarea>
</div>


<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}


function EmptyautoCompleteTopItem(){
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html("");
}
function SafariautoCompleteTopItem(thisdata,typeData){
//

if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SafariItemSearch`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
data:{
    ItemName:thisdata.value,
    typeData:atob(typeData)
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemDeclar('${data[i].uid}')">
    ${data[i].uid}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);
 $(`.autocompleteIcon`).html(`<i class="fa fa-times-circle text-danger" onclick="return EmptyautoCompleteTopItem()"></i>`);



}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
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
function addItemDeclar(itemName){
    $('.item_nameAdd').val(itemName);
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
}
function SafariAddItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariAddItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formAddItemSafari').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    console.log(`done $${CalculateDeclClass}`);

    $('.formAddItemSafari .form-control').val("");
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariuid=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafari(safariuid,safariName);
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}

function SafariSpendAddItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/addSpending`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formAddItemSafariStock').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    console.log(`done $${CalculateDeclClass}`);

    $('.formAddItemSafariStock .form-control').val("");
    //var item_nameAdd=$('.item_nameAdd').val();
    var safariuid=btoa(data.safariuid);
    var safariName=btoa(data.safariName);
    ViewItemSafariStock(safariuid,safariName);

    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}



function AdminSafariCalculate(uid,plaque,transpfees,profit,totClass){
    var totalqty=$(`.${totClass}`).text();
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminSafariCalculate`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
    plaque:plaque,
    transpfees:transpfees,
    profit:profit,
    totalqty:totalqty
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    console.log(data.xdata);
    CheckSafari();
 //console.log(hashfunction);


}
else{
    alert("already updated");
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

function ViewSafari(){
    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/SafariGetAll`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true


var resultData=data.result;


$('.MainbigTitle').html(`
<h5 class="text-center"> Safaris</h5>
`);
$('.MyRequest_table').html("");
getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col">Comment</th>
<th scope="col">Created At</th>
<th scope="col">Action</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
  <td data-label="#">${i+1}</td>
  <td data-label="Name">${resultData[i].name}</td>
  <td data-label="Comment">${resultData[i].comment}</td>
  <td data-label="CreatedAt">${resultData[i].created_at}</td>
  <td data-label="Action"><i class="fas fa-eye text-primary mylogout" title="View Safari Items Load" onClick="return ViewItemSafari('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}')"></i> <i class="fas fa-edit text-primary mylogout" title="Edit this Safari" onClick="return ViewEditSafari('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}','${btoa(resultData[i].comment)}','${btoa(resultData[i].uidCreator)}','${btoa(resultData[i].subscriber)}')"></i> <i class="fas fa-trash text-dark mylogout " title="Delete This Safari" onClick="return DeleteSafari('${btoa(resultData[i].uid)}','${btoa(resultData[i].name)}','${btoa(resultData[i].comment)}','${btoa(resultData[i].uidCreator)}','${btoa(resultData[i].subscriber)}')"></i></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);



//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




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
function ViewEditSafari(uid,name,comment,uidCreator,subscriber){
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Safari</strong></h5>`)
$('.ModalPassword').html(`
<form class="formSafariStockEdit" onsubmit="return SafariStockEdit()">
<div class="p-2">
<div class="form-group ">
<label>Name</label>
<input type="hidden" class="form-control" name="uid" value="${atob(uid)}" required/>
<input type="text" class="form-control" name="name" value="${atob(name)}" required/>
</div>

<div class="form-group ">
<label for="exampleFormControlTextarea3">Enter Comment</label>
  <textarea class="form-control" name="comment" placeholder="Enter Comment" rows="7">${atob(comment)}</textarea>

</div>





<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}
function SafariEdit(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/SafariEdit`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formSafariEdit').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    ViewSafari();
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
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
function DeleteSafari(uid,name,comment,uidCreator,subscriber){
    if(confirm(`Do you Want to Delete this Safari ${atob(name)}`))
    {

        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/DeleteSafariStock`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:atob(uid),
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    ViewSafariStock('name',false);
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong contact Admins ");
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
}
function ViewItemSafari(uid,name){

    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/SafariCalculate`,
type:'get',
data: {
safariuid:atob(uid),
name:atob(name)
},
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true

LoadSafariItemTemplate(data);



}
else{
    LoadSafariAddItemBtnTemplate(data);
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

//End SafariCode Javascript//


//Declaration


function CheckDeclaration(){
    closeNav();

    var Usertoken=localStorage.getItem("Usertoken");

    $.ajax({

url:`./api/AdminCheckDeclaration`,
type:'get',
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },

success:function(data){


if(data.status){//return data as true

    LoadDeclarationItemTemplate(data);



}
else{
    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
$('.MainForm').html("");
    DeclarationForm();

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}
function LoadDeclarationItemTemplate(data){
    //
    var resultData=data.result;

var totClass=data.plaque+'_'+data.uid;
var totAmountDec="amount"+data.plaque+'_'+data.uid;
var totAll="all"+data.plaque+'_'+data.uid;
CalculateDeclClass="calc"+data.plaque+'_'+data.uid;
$('.MainbigTitle').html(`
<h5 class="text-center"> <button type="button" class="btn btn-danger" onclick="return FormCloseDeclaration('${data.uid}')">Close Declaration</button></h5>
`);
$('.MyRequest_table').html("");
getData=`

<h6 class="text-right"><span class="text-primary">Transport:</span>${data.transpfees}</h6>
<h6 class="text-right"><span class="text-primary">Profit:</span>${data.profit}</h6>
<h6 class="text-right"><span class="text-primary">Tot Price:</span><span class="${totAmountDec}"></span></h6>
<h6 class="text-right"><hr></h6>
<h6 class="text-right"><span class="text-danger">Total ALL</span>:<span class="${totAll}"></span></h6>
<div class="flex-center">


<div class="form-group">
<label>Plaque:${data.plaque}</label>

</div>
<div class="form-group">
<label>Exchange:${data.exchangerate}</label>

</div>

<div class="form-group">
<label>TotalQty:<span class="${totClass}"></span></label>

</div>



</div>
<button type="button" class="d-none btn btn-dark  ${CalculateDeclClass} " onclick="return AdminDeclarationCalculate('${data.uid}','${data.plaque}','${data.transpfees}','${data.profit}','${totClass}')">Calculate</button>
<div class="pb-2">
<button type="button" class="btn btn-dark" onclick="return FormAddItemDeclaration('${data.uid}','${data.plaque}','${data.transpfees}','${data.profit}','${totClass}')">Add Item</button>
<button type="button" class="btn btn-primary" onclick="return ResultExcel('${data.uid}','${data.plaque}','${data.exchangerate}')">Result</button>
</div>
<table class="viewReqTable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col">Qty</th>
<th scope="col">Price</th>
<th scope="col">Total</th>
<th scope="col">Action</th>

</tr>
</thead>
<tbody>
`;
var qtyTotalDec = 0;
var TotalPriceDec=0;
for(var i=0;i<resultData.length;i++){
qtyTotalDec+=parseInt(resultData[i].qty);
TotalPriceDec+=parseFloat(resultData[i].price);
 getData+=`

 <tr>
  <td data-label="#">${i+1}</td>
  <td data-label="Items">${resultData[i].name}</td>
  <td data-label="Qty">${resultData[i].qty}</td>
  <td data-label="Price">${resultData[i].price}</td>
  <td data-label="Total">${resultData[i].total}</td>
  <td data-label="Action"><i class="fas fa-edit text-primary mylogout" title="Edit this Items" onClick="return ViewEditItemDeclaration('${resultData[i].id}','${resultData[i].uid}','${resultData[i].name}','${resultData[i].qty}','${resultData[i].price}','${data.profit}','${data.transpfees}')"></i> <i class="fas fa-trash text-dark mylogout " title="Delete This Item" onClick="return DeleteItemDeclaration('${resultData[i].id}','${resultData[i].uid}','${resultData[i].name}','${data.profit}','${data.transpfees}')"></i></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);

$(`.${totClass}`).text(qtyTotalDec);
$(`.${totAmountDec}`).text(TotalPriceDec);
$(`.${totAll}`).text(TotalPriceDec+parseFloat(data.profit)+parseFloat(data.transpfees));

//console.log(hashfunction);
//TableDisplayOrderTemplate(data)


    //
}
function ViewEditItemDeclaration(id,uid,name,qty,price,profit,transpfees){


    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Item</strong></h5>`)
$('.ModalPassword').html(`

<form class="formEditItemDeclaration" onsubmit="return AdminDeclarationEditItem()">
<div class="p-2">
<div class="form-group ">
<input type="hidden" class="form-control" name="id" value="${id}"/>
<input type="hidden" class="form-control" name="uid" value="${uid}"/>

<input type="hidden" class="form-control" name="transpfees" value="${transpfees}" />
<input type="hidden" class="form-control" name="profit" value="${profit}" />

</div>

<div class="form-group ">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="name" onkeyup="autoCompleteTopItem(this)" value="${name}" required/>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" value="${qty}" required/>
</div>

<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" value="${price}" required/>
</div>





<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`);
EmptyautoCompleteTopItem();
}
function AdminDeclarationEditItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeclarationEditItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formEditItemDeclaration').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    //console.log(`done $${CalculateDeclClass}`);
    $('.viewOrder').modal('hide');
    //var item_nameAdd=$('.item_nameAdd').val();
    CheckDeclaration();
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}
function DeleteItemDeclaration(id,uid,name,profit,transpfees){
    if(confirm(`Do you Want Delete ${name} in this Declaration?`))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeleteItemDeclaration`,//close Declaration
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    id:id,
    uid:uid,
    profit:profit,
    transpfees:transpfees
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   CheckDeclaration();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;

    }

}
function FormCloseDeclaration(uid){
    if(confirm('Do you Want to Close this Declaration?'))
    {
        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminCloseDeclaration`,//close Declaration
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();

   alert("Close Query Submitted Successfully")
   AllOpenSaleReport();

}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
    }

}
function DeclarationForm(){

    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Create Declaration</strong></h5>`)
$('.ModalPassword').html(`
<form class="formDeclarationCreate" onsubmit="return formDeclarationCreate()">
<div class="p-2">
<div class="form-group ">
<label>Enter Plaque Number</label>
<input type="text" class="form-control" name="plaque" required/>
</div>

<div class="form-group ">
<label>Enter Profit</label>
<input type="number" class="form-control" name="profit" required/>
</div>

<div class="form-group ">
<label>Enter Transport Fees</label>
<input type="text" class="form-control" name="transpfees" required/>
</div>

<div class="form-group ">
<label>Enter Exchange Rate</label>
<input type="num" class="form-control" name="exchangerate" required/>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}

function formDeclarationCreate(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeclarationCreate`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formDeclarationCreate').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    CheckDeclaration();
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}


function ResultExcel(uid,plaque,exchangerate)
{

   //
   $('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/ResultExcel`,
type:'get',

//dataType: "json",
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data: {
    uid:uid,
    plaque:plaque,
    exchangerate:exchangerate
},
success:function(data){
    console.log(data);

    if(data.status){//return data as true

$('.cover-spin').hide();
//console.log(data);
window.location.href = `./api/ExportCsv?uid=${uid}&uidLink=${data.uidLink}&TokenLink=${data.TokenLink}&plaque=${plaque}&exchangerate=${exchangerate}`;

/*var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'myfile.pdf';
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);*/

//alert("Successfully created");
//var data=data.result[0];
//var data=;
//console.log(hashfunction);



}
else{

    alert("alert something wrong please contact system Admin");
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
function FormAddItemDeclaration(uid,plaque,transpfees,profit,totClass){

$('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Item</strong></h5>`)
$('.ModalPassword').html(`

<form class="formAddItemDeclaration" onsubmit="return AdminDeclarationAddItem()">
<div class="p-2">
<div class="form-group ">

<input type="hidden" class="form-control" name="uid" value="${uid}"/>
<input type="hidden" class="form-control" name="plaque" value="${plaque}" />
<input type="hidden" class="form-control" name="transpfees" value="${transpfees}" />
<input type="hidden" class="form-control" name="profit" value="${profit}" />
<input type="hidden" class="form-control" name="totalqty" value="${totClass}" />
</div>

<div class="form-group right-inner-addon">
<label>Item Name</label>
<input type="text" class="form-control item_nameAdd" autocomplete="off" name="name" onkeyup="autoCompleteTopItem(this)" required/>
<span class="autocompleteIcon"></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group ">
<label>qty</label>
<input type="number" class="form-control" name="qty" required/>
</div>

<div class="form-group ">
<label>price</label>
<input type="text" class="form-control" name="price" required/>
</div>





<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}


function EmptyautoCompleteTopItem(){
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
    $('.autocompleteIcon').html("");
}
function autoCompleteTopItem(thisdata){
//

if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/AdminSearchDeclarationItem`,
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

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemDeclar('${data[i].name}')">
    ${data[i].name}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);
 $(`.autocompleteIcon`).html(`<i class="fa fa-times-circle text-danger" onclick="return EmptyautoCompleteTopItem()"></i>`);



}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
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
function addItemDeclar(itemName){
    $('.item_nameAdd').val(itemName);
    $('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();
}
function AdminDeclarationAddItem(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeclarationAddItem`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formAddItemDeclaration').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    $('.viewOrder').modal('hide');
    console.log(`done $${CalculateDeclClass}`);

    $('.formAddItemDeclaration .form-control').val("");
    //var item_nameAdd=$('.item_nameAdd').val();
    CheckDeclaration();
    //$(`.${CalculateDeclClass}`).click();
    //alert(` Item ${item_nameAdd} added `);
    /*$('.MainForm').html(`
    <h5 class="text-center">Order List</h5>
    `);*/
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;
}



function AdminDeclarationCalculate(uid,plaque,transpfees,profit,totClass){
    var totalqty=$(`.${totClass}`).text();
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeclarationCalculate`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
    plaque:plaque,
    transpfees:transpfees,
    profit:profit,
    totalqty:totalqty
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    console.log(data.xdata);
    CheckDeclaration();
 //console.log(hashfunction);


}
else{
    alert("already updated");
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

function ViewDeclaration(){
    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/AdminDeclarationLoad`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true


var resultData=data.result;


$('.MainbigTitle').html(`
<h5 class="text-center"> Declarations</h5>
`);
$('.MyRequest_table').html("");
getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Plaque</th>
<th scope="col">Profit</th>
<th scope="col">Transport</th>
<th scope="col">Exchange Rate</th>
<th scope="col">Status</th>
<th scope="col">Created At</th>
<th scope="col">Action</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
  <td data-label="#">${i+1}</td>
  <td data-label="Plaque">${resultData[i].plaque}</td>
  <td data-label="Profit">${resultData[i].profit}</td>
  <td data-label="Transport">${resultData[i].transpfees}</td>
  <td data-label="Exchange Rate">${resultData[i].exchangerate}</td>
  <td data-label="Status">${resultData[i].closeallstatus!='open'?'Close':resultData[i].closeallstatus}</td>
  <td data-label="CreatedAt">${resultData[i].created_at}</td>
  <td data-label="Action"><i class="fas fa-eye text-primary mylogout" title="View Declaration Items Load" onClick="return ViewItemDeclaration('${resultData[i].uid}','${resultData[i].plaque}','${resultData[i].exchangerate}','${resultData[i].profit}','${resultData[i].transpfees}')"></i> <i class="fas fa-edit text-primary mylogout" title="Edit this Declaration" onClick="return ViewEditDeclaration('${resultData[i].uid}','${resultData[i].plaque}','${resultData[i].profit}','${resultData[i].transpfees}','${resultData[i].exchangerate}')"></i> <i class="fas fa-trash text-dark mylogout " title="Delete This Declaration" onClick="return DeleteDeclaration('${resultData[i].uid}','${resultData[i].plaque}')"></i></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.MainForm').html(getData);



//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




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
function ViewEditDeclaration(uid,plaque,profit,transpfees,exchangerate){
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Edit Declaration</strong></h5>`)
$('.ModalPassword').html(`
<form class="formDeclarationEdit" onsubmit="return AdminEditDeclaration()">
<div class="p-2">
<div class="form-group ">
<label>Plaque Number</label>
<input type="hidden" class="form-control" name="uid" value="${uid}" required/>
<input type="text" class="form-control" name="plaque" value="${plaque}" required/>
</div>

<div class="form-group ">
<label>Profit</label>
<input type="text" class="form-control" name="profit" value="${profit}" required/>
</div>

<div class="form-group ">
<label>Transport Fees</label>
<input type="text" class="form-control" name="transpfees" value="${transpfees}" required />
</div>

<div class="form-group ">
<label>Exchange Rate</label>
<input type="text" class="form-control" name="exchangerate" value="${exchangerate}" required/>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

`)
}
function AdminEditDeclaration(){
    $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminEditDeclaration`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:$('.formDeclarationEdit').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    ViewDeclaration();
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
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
function DeleteDeclaration(uid,plaque){
    if(confirm(`Do you Want to Delete this Declaration that has this Plaque ${plaque}`))
    {

        $('.cover-spin').show();
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminDeleteDeclaration`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
dataType: "json",
data:{
    uid:uid,
},
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').hide();
    ViewDeclaration();
 //console.log(hashfunction);


}
else{
    alert("something Went Wrong ");
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
}
function ViewItemDeclaration(uid,plaque,exchangerate,profit,transpfees){

    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/AdminItemDeclarationLoad`,
type:'get',
data: {
uid:uid,
plaque:plaque,
exchangerate:exchangerate,
profit:profit,
transpfees:transpfees
},
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true

LoadDeclarationItemTemplate(data);



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
//Declaration
function checkPlatform(platform){
    if(platform==='{{env('PLATFORM3')}}')
   {
    window.location.href ="user";
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


function  UserAddInvoice(userid,name){
    //ViewSearchForm();
    MyUserid=userid;
    Myname=name;

    create_order();

    $('.MainbigTitle').html(`
<h5 class="text-center mainTitle">Acc:(<strong>${name}</strong>)</h5>

`);

    $('.useridAccount').val(userid);



}
function AdminClosedSales(){
    if(confirm('Are you Sure you want to Close This Sales?'))
    {
        //

        $('.cover-spin').show();

//
var Usertoken=localStorage.getItem("Usertoken");
//console.log(OrderId);
//search products
$.ajax({

url:`./api/AdminClosedSales`,
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
$('.MainbigTitle').html(`
<div class="alert alert-primary" role="alert">
Query Submitted Successfully
</div>
`);


}
else{
    alert("Password is incorrect please try again");
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

}
function AdminAddPassword(userid,name) {

    $('.viewOrder').modal('show');

    $('.MyTitleModal').html(`<h5 class="text-center">Close  <strong>${name}</strong></h5>`)
    $('.ModalPassword').html(`
    <form class="formData" >
<div class="p-2">
<div class="form-group ">
<label>Enter Your Password</label>
<input type="password" class="form-control" name="password" />
<input type="hidden" class="form-control" name="userid" value="${userid}"/>
</div>

<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return AdminClosedSales('${userid}','${name}')" value="submit" />
</div>
</div>
</form>

    `)

    //$('.cover-spin').show();

}
function  ReportChoice(thisdata,userid,name)
{
    if(thisdata.value=='1')
    {
        console.log(thisdata.value);
        UserReport(userid,name);
    }
    else{
        console.log(thisdata.value);
        ViewSecondSalesReport(userid,name);
    }
    return false;
}

function ViewSecondSalesReport(userid,name){

    MyUserid=userid;
    Myname=name;
    $('.MyRequest_table').html("");
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
userid:userid,
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
    var datatobrr=data[i].ProductConcat.split(',');
    var getDetail="";
    for(var u=0;u<datatobrr.length;u++)
    {
        getDetail+=`
<li class="list-group-item">${u+1} ${parantesis} ${datatobrr[u]}</li>
`;
   }

   var TrueSubmitIcon=`<i  class="fas fa-pen text-success mylogout" title="Edit Permission Orders" onclick="return EditPermissionOrder('${data[i].uid}','${trueV}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var FalseSubmitIcon=`<i  class="fas fas fa-ban text-danger mylogout" title="Edit Permission Orders" onclick="return EditPermissionOrder('${data[i].uid}','${falseV}','${data[i].qty}','${data[i].total_order}')"></i>`;
   var permissionChange=data[i].permission===trueV?TrueSubmitIcon:FalseSubmitIcon;
    getdata+=`

<ul class="list-group pt-1 ">

  <li class="list-group-item bg-dark text-white">No # ${data[i].uid} ${permissionChange} <span class="float-center"></span><span class=" float-right"><span class="text-success">(${data[i].qty}) Total</span>=$${data[i].total_order}</span></li>
  ${getDetail}
</ul>
<hr/>
    `;

 }
 $('.MainbigTitle').html(`

 <h5 class="text-center mainTitle">
 ${name}
 <div class="pt-1">
<button type="button" class="btn btn-danger" onclick="return AdminAddPassword('${userid}','${name}')">Close Sales</button>
</div>
<div class="pt-1">
<select id="Ultra" onchange="return ReportChoice(this,'${userid}','${name}')" class="form-control-sm">
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

function EditPermissionOrder(OrderId,permission,qty,totalOrder) {//qty:number of qty in this facture to be edited,totalOrder:is total amount of that facture,this will be saved on history edit
    var permissionValue=permission===trueV?falseV:trueV;

    if(confirm(`Do you want to change permission of ${OrderId} to:${permissionValue}?`))
    {
//
var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


$.ajax({

url:`./api/AdminEditPermissionOrder`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
OrderId:OrderId,
permissionValue:permissionValue,
qty:qty,
totalOrder:totalOrder,
PrevQueryData:`"{

    "OrderId":"${OrderId}",
    "PrevPermission":"${permission}"


}"`,

},
success:function(data){
if(data.status){//return data as true

    alert("Permission has been changed");

    ViewSecondSalesReport(MyUserid,Myname);


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

function ComeFromallsale(){
    countryComeFrom=$('.catComeFrom option:selected').val();

    AllOpenSaleReport();


}
function  AllOpenSaleReport(){
    closeNav();
    $('.MyRequest_table').html("");


    $('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminAllOpenReport`,
type:'get',
data:{
countryComeFrom:countryComeFrom
},
headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },


success:function(data){

    platform=data.platform;
    userProfileName=data.name;

   // console.log(data);
if(checkPlatform(platform))
{
//
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
<li class="list-group-item">${i+1} ${parantesis} ${data[i].qty} ${data[i].productCode}= ${data[i].all_total}</li>

`;



}


getData+=`</ul>`;
$('.MainbigTitle').html(`
<h5 class="text-center mainTitle">
Report All Sales
<div class="form-group ">
<h6 class="text-center pt-1">Show From</h6>

<select class="form-control-sm catComeFrom" name="cat" onchange="ComeFromallsale()">

</select>

</div>



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
    if(platform==='{{env('PLATFORM1')}}')
    {
$('.MyRequest_table').html("");
$('.MainForm').html("No data Found");
$('.cover-spin').hide();
    }
    else{
        alert("Something Wrong With Your Account Please Contact System Admin");
    logout();
    }


}
//
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

function  UserReport(userid,name){
    $('.MyRequest_table').html("");
   // MyUserid=userid;

   MyUserid=userid;
    Myname=name;
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
userid:userid,
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
<li class="list-group-item">${i+1} ${parantesis}  ${data[i].qty} ${data[i].productCode}= ${data[i].all_total}</li>

`;



}
getData+=`</ul>`;
$('.MainbigTitle').html(`
<h5 class="text-center mainTitle">
Acc:(<strong>${name}</strong>)
<div class="pt-1">
<button type="button" class="btn btn-danger" onclick="return AdminAddPassword('${userid}','${name}')">Close Sales</button>
</div>
<div class="pt-1">
<select id="Ultra" class="form-control-sm" onchange="return ReportChoice(this,'${userid}','${name}')">
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
$('.MainForm').html(`
<h6 class="text-center">No Sales Found on this Acc:<strong>${name}</trong></h6>
`);
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
    UserReport(MyUserid,Myname);

}
function ViewAllUsers(){

closeNav();
$('.MainbigTitle').html(`
<h5 class="text-center mainTitle">Users</h5>
<div class="text-right UserBtnTotal"></div>
`);
$('.MainForm').html("");

//
$('.cover-spin').show();
var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminViewUsers`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){

//active1 ni owner of company
if(data.status){//return data as true
$('.cover-spin').hide();
var myuid=data.myuid;
var myStatus=data.myStatus;
//console.log(data.result);
var checkMystatus=(myStatus.indexOf('2'))!=-1?'d-none':'';
var data=data.result;


getData=`

<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Name</th>
  <th scope="col">Company</th>
  <th scope="col" class="${checkMystatus}">Status</th>
  <th scope="col">Created</th>
  <th scope="col" class="${checkMystatus}">Actions</th>
</tr>
</thead>
`;

for(var i=0;i<data.length;i++){
//it means that on receiv show Dispatch else show Received
var banIcon=`  <i class="fas fa-ban text-danger btn" onclick="changePlatform('${data[i].name}','${data[i].uid}','${data[i].status}','${data[i].subscriber}')"></i>`;
var checkIcon=`<i class="fas fa-check text-success btn" onclick="changePlatform('${data[i].name}','${data[i].uid}','${data[i].status}','${data[i].subscriber}')"></i>`;
var myStatusCut=(data[i].status).slice(0,-1);
var platformcheck=myStatusCut==='active'?checkIcon:banIcon;
var checkHide=myuid===data[i].uid?'d-none':'';
var myStatusCut2=((data[i].status).slice(-1))==='1'?'Creator':'Admin';
 getData+=` <tr class="${checkHide}">
  <td data-label="#">${i+1}</td>
  <td data-label="Name" onclick="return addExistingUser('${data[i].name}','${data[i].uid}','${data[i].status}','${data[i].subscriber}','${data[i].CompanyName}')">${data[i].name}</td>
  <td data-label="Company" onclick="return addNewSubscriber('${data[i].name}','${data[i].uid}','${data[i].status}','${data[i].subscriber}','${data[i].CompanyName}')">${data[i].CompanyName}</td>
  <td data-label="Status"class="${checkMystatus}">${myStatusCut2}</td>
  <td data-label="Created_at">${data[i].created_at}</td>
  <td data-label="Actions" class="${checkMystatus}">${platformcheck}</td>

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

function miniAccount(uidOwner){


var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/miniAccount`,
type:'post',
beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
data: {
     app_vers: '{{env('APP_VERS')}}',
     uidOwner:uidOwner,
     optionCase:actionAccount
 },
success:function(data){


if(data.status){//return data as true


var resultData=data.result;



getData=`


<table class="viewReqTable">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Name</th>
<th scope="col">Company</th>
<th scope="col">Actions</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

getData+=`

<tr>
<td data-label="#">${i+1}</td>
<td data-label="Name">${resultData[i].name}</td>
<td data-label="Company">${resultData[i].CompanyName}</td>
<td data-label="Actions"><button type="button" class="btn btn-dark" onclick="return addExisting('${encodeURIComponent(JSON.stringify(resultData[i]))}')" >View</button>|<button type="button" class="btn btn-dark" onclick="return EditPromotion('${encodeURIComponent(JSON.stringify(resultData[i]))}')">Edit</button></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.miniAccount').html(getData);



//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




}
else{

//$('.MyRequest_table').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;

}

function userSubscriber(){


    var Usertoken=localStorage.getItem("Usertoken");

$.ajax({

url:`./api/AdminViewUsers`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data: { app_vers: '{{env('APP_VERS')}}' },
success:function(data){


if(data.status){//return data as true


var resultData=data.result;

viewAdminViews(resultData);




//console.log(hashfunction);
//TableDisplayOrderTemplate(data)




}
else{

//$('.MyRequest_table').html("");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;

}
function showUser(){
    console.log("hello");
    $('.ModaldumpT').modal('show');
    userSubscriber();
}
function viewAdminViews(resultData)
{
    $('.dumpTitle').html(`
<h5 class="text-center"> Choose Users</h5>
`);

getData=`


<table class="viewReqTable">
<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Name</th>
  <th scope="col">Company</th>
  <th scope="col">Actions</th>

</tr>
</thead>
<tbody>
`;

for(var i=0;i<resultData.length;i++){

 getData+=`

 <tr>
 <td data-label="#">${i+1}</td>
  <td data-label="Name">${resultData[i].name}</td>
  <td data-label="Company">${resultData[i].CompanyName}</td>
  <td data-label="Actions"><button type="button" class="btn btn-dark" onclick="return addExisting('${encodeURIComponent(JSON.stringify(resultData[i]))}')" >Take Over</button></td>


</tr>`;

}
getData+=`
</tbody>
</table>`;

$('.dumpRest').html(getData);
}
function searchUserAdmin(thisData)
{

}
function searchThisAdmin(thisData) //switch
{

}
function addExistingUser(name,ThisUserid,userStatus,subscriber,CompanyName){
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">  <strong>Add Existing User</strong></h5>`)
    $('.ModalPassword ').html(`
    <div class="card-body">
    <div class="form-group right-inner-addon ">
    <input type="submit" class="btn btn-danger" onclick="return showUser()" value="submit" />
<label>Search Product<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="searchThisAdmin(this)" name="productCode" placeholder="Enter Product Code" required/>
<span class="autocompleteIcon" onclick="hidePopup()"><i class="fas fa-exclamation-triangle text-danger" ></i></span>
</div>


<div class="autoCompleteTopItemData miniAccount"></div>



<div class="modal fade ModaldumpT" id="largeModal" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title dumpTitle" id="largeModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div >
      <div class="form-group right-inner-addon ">
      <label>Search Product<span class="text-danger">*</span></label>
<input type="text" class="form-control productCodeClass"  autocomplete="off" onkeyup="searchUserAdmin(this)" name="productCode" placeholder="Enter Product Code" required/>
<span class="autocompleteIcon" onclick="hidePopup()"><i class="fas fa-exclamation-triangle text-danger" ></i></span>
</div>
<div class="dumpRest"></div>
</div>
      </div>
    </div>
  </div>
</div>

</div>
    `);
    miniAccount(ThisUserid);
}
function addNewSubscriber(name,ThisUserid,userStatus,subscriber,CompanyName){

}
function changePlatform(name,ThisUserid,userStatus,subscriber) {
    var indUserStatus=userStatus.slice(-1);
    userStatus=userStatus.slice(0,-1);
    var checkAct=userStatus==='active'?'to be Inactive':'to be Active';
 var checkPlatformSubmit=userStatus==='active'?`inactive${indUserStatus}`:`active${indUserStatus}`;
    if(confirm(`Do you Want ${name}  ${checkAct} `))
    {
//
var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


$.ajax({

url:`./api/AdminChangePlatform`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
data:{
userid:ThisUserid,
status:checkPlatformSubmit,
subscriber:subscriber
},
success:function(data){
if(data.status){//return data as true

    ViewAllUsers();


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
function EmpytyAdjustDisplay(){
    $('.adjustqtyDisplay').html("");
}
function adjustqty(thisdata,qty){

    if(thisdata.value=="") return EmpytyAdjustDisplay();

if(!isNaN(thisdata.value))
{

        $('.adjustqtyDisplay').html(
        `<strong class="text-success">=>Stock</strong>:<strong class="text-danger">${parseFloat(thisdata.value)+parseFloat(qty)}</strong>`
    );




}
else{
    $('.adjustqtyDisplay').html(
        `<strong class="text-success">=>Please Type numeric value</strong>`
    );
}


}

function AdjustThisProduct() {//Admin
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/AdjustProduct`,
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
 $('.viewOrder').modal('hide');
    alert("Product Adjusted Successfully");
    ViewAllProductWithEdit();

}
else{
    $('.cover-spin').hide();
    alert(data.result);

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}

function EditThisProduct() {//Admin
    $('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");
    //console.log(OrderId);
   //search products
   $.ajax({

url:`./api/EditProduct`,
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

 $('.viewOrder').modal('hide');
    alert("Product Edited Successfully");
    ViewAllProductWithEdit();

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
function AdminChangeAdjustProduct(id,productCode,price,qty,total,tags,created_at,cat){
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">Adjust <strong>${atob(productCode)}</strong></h5>`);
    $('.ModalPassword').html(`
  <div class="p-2">
    <form class="formData"  enctype="multipart/form-data">
<div class="form-group d-none">
<label>Common Name</label>
<input type="text" class="form-control" name="tags"  value="${atob(tags)}"/>
</div>

<div class="form-group d-none">
<label>Come From</label>
<div class="form-group ComeFromLoader">

</div>
<input type="hidden" class="form-control catName" name="catName" />

</div>
<div class="form-group d-none">
<input type="hidden" class="form-control " name="prevPrice" value="${price}"/>
<input type="hidden" class="form-control " name="prevQty" value="${qty}"/>
<textarea class="form-control" name="PrevQueryData">
{
    "id":"${id}",
    "productCode":"${atob(productCode)}",
    "price":"${price}",
    "qty":"${qty}",
    "tags":"${atob(tags)}",
    "cat":"${cat}",
    "created_at":${created_at},
}

</textarea>
</div>
<div class="form-group d-none">
<label>Product Code</label>
<input type="text" class="form-control" name="productCode" value="${atob(productCode)}"/>
<input type="hidden" class="form-control" name="id" value="${id}" />
</div>
<div class="form-group d-none">
<label>Image</label>
<input type="file" class="form-control" change="imagechange(this)" name="files[]" />
</div>
<div class="form-group d-none">
<label>From</label>
<input type="text" class="form-control"  />
</div>
<div class="form-group">
<label>Price (Current Price:${price})</label>
<input type="text" class="form-control" value="${price}"name="price"/>
</div>
<div class="form-group">
<label>qty (Current Qty:${qty})<span class="adjustqtyDisplay"></span></label>
<input type="text" class="form-control adjustqty" name="qty" placeholder="Enter Adjust Qty" onkeyup="adjustqty(this,'${qty}')"  autocomplete="off"/>

</div>
<div class="form-group d-none">
<label>Pieces</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group d-none">
<label>Factories Price</label>
<input type="text" class="form-control" name="fact_price" />
</div>


<div class="form-group d-none">
<label>active</label>
<input type="text" class="form-control" name="active" />
</div>

<div class="form-group d-none">
<label>Description</label>
<input type="text" class="form-control" name="description" />
</div>
<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return AdjustThisProduct()" value="submit" />
</div>


</form>
</div>
    `);
   // $('.MyRequest_table').html("");
   datacomeFrom(cat);

}
function AdminChangeProduct(id,productCode,price,qty,total,tags,created_at,cat){
    $('.viewOrder').modal('show');
    $('.MyTitleModal').html(`<h5 class="text-center">Edit <strong>${atob(productCode)}</strong></h5>`);
    $('.ModalPassword').html(`
  <div class="p-2">
    <form class="formData"  enctype="multipart/form-data">
<div class="form-group">
<label>Common Name</label>
<input type="text" class="form-control" name="tags"  value="${atob(tags)}"/>
</div>

<div class="form-group">
<label>Come From</label>
<div class="form-group ComeFromLoader">

</div>
<input type="hidden" class="form-control catName" name="catName" />

</div>
<div class="form-group d-none">
<textarea class="form-control" name="PrevQueryData">
{
    "id":"${id}",
    "productCode":"${atob(productCode)}",
    "price":"${price}",
    "qty":"${qty}",
    "tags":"${atob(tags)}",
    "cat":"${cat}",
    "created_at":${created_at},
}

</textarea>
</div>
<div class="form-group d-none">
<label>Product Code</label>
<input type="text" class="form-control" name="productCode" value="${atob(productCode)}"/>
<input type="hidden" class="form-control" name="id" value="${id}" />
</div>
<div class="form-group d-none">
<label>Image</label>
<input type="file" class="form-control" change="imagechange(this)" name="files[]" />
</div>
<div class="form-group d-none">
<label>From</label>
<input type="text" class="form-control"  />
</div>
<div class="form-group">
<label>Price</label>
<input type="text" class="form-control" value="${price}"name="price"/>
</div>
<div class="form-group">
<label>qty</label>
<input type="text" class="form-control"  value="${qty}" name="qty" />
</div>
<div class="form-group d-none">
<label>Pieces</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group d-none">
<label>Factories Price</label>
<input type="text" class="form-control" name="fact_price" />
</div>


<div class="form-group d-none">
<label>active</label>
<input type="text" class="form-control" name="active" />
</div>

<div class="form-group d-none">
<label>Description</label>
<input type="text" class="form-control" name="description" />
</div>
<div class="form-group">

<input type="submit" class="btn btn-danger" onclick="return EditThisProduct()" value="submit" />
</div>


</form>
</div>
    `);
   // $('.MyRequest_table').html("");
   datacomeFrom(cat);

}
function SearchDateChange(thisdata)
{
    console.log(thisdata.value);
    //
    var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/searchPreviousRecord`,
type:'get',
data: {
    SearchDate:thisdata.value
},
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true
$('.cover-spin').hide();
//var data=data.result[0];
//var data=;
//console.log(hashfunction);
var data=data.result;


getData=`

<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Code</th>
  <th scope="col">Name</th>
  <th scope="col">Price</th>
  <th scope="col">Qty</th>

  <th scope="col">Status</th>
  <th scope="col">From</th>
  <th scope="col">Created</th>
  <th scope="col">Action</th>
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

  <td data-label="Status">${data[i].actionName}</td>
  <td data-label="From">${data[i].catName}</td>
  <td data-label="Created_at">${data[i].created_at}</td>
  <td data-label="Action">
<div class="d-none d-lg-block">
  <span ><i class="fas fa-adjust text-danger mylogout" title="Adjust Product" onclick="return AdminChangeAdjustProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')"></i></span> | <span><i  class="fas fa-edit text-success mylogout" title="Edit Product" onclick="return AdminChangeProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')"></i></span>
</div>
<div class="d-md-none">
  <span ><button class="btn btn-danger mylogout" title="Adjust Product" onclick="return AdminChangeAdjustProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')">Adjust</button></span> | <span><button class="btn btn-dark mylogout" title="Edit Product" onclick="return AdminChangeProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')">Edit</button></span>
</div>
  </td>

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
async function datacomeFrom(cat){
    let mydata=await LoadSettingComeFrom();
    var data=mydata.result;

    getData=`<select class="form-control catComeFrom" name="cat" id="box1" onchange="CatComeChange()">`;

for(var i=0;i<data.length;i++){
    getData+=`<option value="${data[i].id}">${data[i].comeFrom}</option>`;
}


getData+=`</select>`;


    $('.ComeFromLoader').html(getData);

   $(`.catComeFrom option[value="${cat}"]`).attr("selected",true);
   var sel = document.getElementById("box1");
var catName= sel.options[sel.selectedIndex].text;
    //console.log(text);
   $('.catName').val(catName) ;
}
function CatComeChange(){
   // var catName=$('.catComeFrom option:selected').text();
   var sel = document.getElementById("box1");
var catName= sel.options[sel.selectedIndex].text;
    //console.log(text);
   $('.catName').val(catName) ;
}

function ComeFromProductEdit(){
    countryComeFrom=$('.catComeFrom option:selected').val();
    ViewAllProductWithEdit();
}
function ViewAllProductWithEdit(){
    var chooseSearchBy="1";
    var ClassfieldName="searchProductEditTable";

closeNav();

$('.MainbigTitle').html(`

<h5 class="text-center mainTitle">
Stocks
<div class="form-group ">
<h6 class="text-center pt-1">Show From</h6>

<select class="form-control-sm catComeFrom" name="cat" onchange="ComeFromProductEdit()">


</select>

</div>



</h5>


`);

/*$('.SearchDate').flatpickr(
    {

    dateFormat: "Y-m-d ",
}
);*/

selectComeFrom();

$('.MainForm').html(`


<form class="Form_order">
            <!--My Form-->






<div class="form-group">

    <label for="">Search Your Product<span class="text-danger">*</span></label>
    <div class="input-group mb-3">
  <div class="input-group-prepend">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">By</button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#SearchByCode" onclick="return chooseSearch('${choose1}','${ClassfieldName}')">Code</a>
      <a class="dropdown-item" href="#SearchByName" onclick="return chooseSearch('${choose2}','${ClassfieldName}')">name</a>
      <a class="dropdown-item" href="#SearchByDate" onclick="return chooseSearchDate('${ClassfieldName}')">Date</a>
    </div>
  </div>

  <input type="text" class="form-control searchProductEditTable" aria-label="Text input with dropdown button" placeholder="Search by Code" onkeyup="return searchProductEditTable(this)">
</div>






</div>
<!--search Form -->
</form>


`);
//
$('.cover-spin').show();



var Usertoken=localStorage.getItem("Usertoken");
$.ajax({

url:`./api/AdminViewAllProduct`,
type:'get',
data: {
    countryComeFrom:countryComeFrom
},
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true
$('.cover-spin').hide();
//var data=data.result[0];
//var data=;
//console.log(hashfunction);
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
  <th scope="col">Action</th>
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
  <td data-label="Action">
<div class="d-none d-lg-block">
  <span ><i class="fas fa-adjust text-danger mylogout" title="Adjust Product" onclick="return AdminChangeAdjustProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')"></i></span> | <span><i  class="fas fa-edit text-success mylogout" title="Edit Product" onclick="return AdminChangeProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')"></i></span>
</div>
<div class="d-md-none">
  <span ><button class="btn btn-danger mylogout" title="Adjust Product" onclick="return AdminChangeAdjustProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')">Adjust</button></span> | <span><button class="btn btn-dark mylogout" title="Edit Product" onclick="return AdminChangeProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}','${data[i].cat}')">Edit</button></span>
</div>
  </td>

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

function searchProductEditTable(thisdata){
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
//var data=data.result[0];
//var data=;
//console.log(hashfunction);
var data=data.result;


getData=`

<thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Code</th>
  <th scope="col">Name</th>
  <th scope="col">Price</th>
  <th scope="col">Qty</th>
  <th scope="col">Total</th>
  <th scope="col">Qty Left</th>
  <th scope="col">Created</th>
  <th scope="col">Action</th>
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
  <td data-label="Total">${data[i].total}</td>
  <td data-label="Qty_left">${parseInt(data[i].qty)-parseInt(data[i].qty_sold)}</td>
  <td data-label="Created_at">${data[i].created_at}</td>
  <td data-label="Action"><span class="d-none d-md-block"><i class="fas fa-adjust text-danger mylogout" title="Adjust Product" onclick="return AdminChangeAdjustProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}')"></i></span> | <span><i  class="fas fa-edit text-success mylogout" title="Edit Product" onclick="return AdminChangeProduct('${data[i].id}','${btoa(data[i].productCode)}','${data[i].price}','${data[i].qty}','${data[i].total}','${btoa(data[i].tags)}','${data[i].created_at}')"></i></span></td>

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


function autoCompleteTopProductName(thisdata)
{
    //
    if(thisdata.value=="") return EmptyautoCompleteTopItem();
//

var Usertoken=localStorage.getItem("Usertoken");
   //search products
   $.ajax({

url:`./api/SearchByProduct`,
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

    $('.autoCompleteTopItem').show();

var data=data.result;
 var getdata="";
 for(var i=0;i<data.length;i++){

    getdata+=`
    <li class="list-group-item d-flex justify-content-between align-items-center mylogout myhover" onclick="return addItemDeclar('${data[i].name}')">
    ${data[i].productCode}=>${data[i].tags}
    <span class="badge "></span>
  </li>
    `;

 }

 $('.autoCompleteTopItem').html(getdata);
 $(`.autocompleteIcon`).html(`<i class="fa fa-times-circle text-danger" onclick="return EmptyautoCompleteTopItem()"></i>`);



}
else{
    /*$('.autoCompleteTopItem').html("");
    $('.autoCompleteTopItem').hide();*/
    EmptyautoCompleteTopItem();
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


function CreateProductMenu(){
    $('.MainbigTitle').html("");
$('.MyRequest_table').html("");
    closeNav();
    $('.MainForm').html(`
    <h5 class="text-center">ONGERAMO IBISHYA</h5>
    <form class="formDataCreate" onsubmit="return CreateProduct()">
<div class="form-group right-inner-addon">
<label>Product Code <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="productCode" autocomplete="off" onkeyup="autoCompleteTopProductName(this)" required/>
<span class="autocompleteIcon"></span>
</div>
<ul class="list-group  autoCompleteTopItem">

</ul>
<div class="form-group">
<label>Common Name</label>
<input type="text" class="form-control" name="tags" />
</div>
<div class="form-group d-none">
<label>Image</label>
<input type="file" class="form-control" change="imagechange(this)" name="files[]" />
</div>
<div class="form-group ComeFromLoader">

</div>
<div class="form-group">
<label>Price <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="price" required/>
</div>
<div class="form-group">
<label>qty <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="qty" required/>
</div>
<div class="form-group d-none">
<label>Pieces</label>
<input type="text" class="form-control" name="pcs" />
</div>
<div class="form-group d-none">
<label>Factories Price</label>
<input type="text" class="form-control" name="fact_price" />
</div>


<div class="form-group d-none">
<label>active</label>
<input type="text" class="form-control" name="active" />
</div>

<div class="form-group d-none">
<label>Description</label>
<input type="text" class="form-control" name="description" />
</div>
<div class="form-group">

<button  class="btn btn-danger mycreateProduct" >Submit</button>
</div>


</form>
    `);


    LoadSavedComeFrom();

}
function ResetSettingComeFrom(){

    //var catComeFrom=$('.catComeFrom').val();
    //console.log(catComeFrom);
    localStorage.removeItem("comeFromSaved");
    LoadSavedComeFrom();
}
function SaveSettingComeFrom(){
var catComeFrom=$('.catComeFrom').val();
var catComeFromText=$('.catComeFrom option:selected').text();
localStorage.setItem('comeFromSaved',catComeFrom);
alert(`${catComeFromText} Saved as Default`);
//LoadSavedComeFrom();

$(`.catComeFrom option[value="${catComeFrom}"]`).attr("selected",true);

}
async function LoadSavedComeFrom(){
    var comeFromSaved=localStorage.getItem("comeFromSaved");

    if(comeFromSaved)
    {
       /* $('.ComeFromLoader').html(`
    <label>From</label>
<span><i class="fas fa-undo text-danger mylogout"  title="Reset this Setting" onClick="return ResetSettingComeFrom()"></i> <i class="fas fa-cog text-dark mylogout" title="Setting" onClick="return SettingComeFrom()"></i></span>
<select class="form-control catComeFrom" name="cat" >
<option value="${comeFromSaved}">${comeFromSaved}</option>
</select>

    `);*/

    await LoadComeFrom();

    $(`.catComeFrom option[value="${comeFromSaved}"]`).attr("selected",true);
    }
    else{
        LoadComeFrom();
    }

    var sel = document.getElementById("box1");
var catName= sel.options[sel.selectedIndex].text;
    //console.log(text);
   $('.catName').val(catName) ;
}
function SettingComeFrom(){
    $('.viewOrder').modal('show');

$('.MyTitleModal').html(`<h5 class="text-center">  <strong>Settings</strong></h5>`)
$('.ModalPassword').html(`
<div class="pl-1 pr-1 pt-1">
<div class="input-group mb-3">
  <input type="text" class="form-control settingComeFromAddClass" placeholder="Enter From Country" aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button">Add</button>
  </div>
</div>

<ul class="list-group SettingComeFromLoad">



</ul>
</div>

`);
DispSettingComeFrom();
}
function DispSettingComeFrom(){
    //
    var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();


$.ajax({

url:`./api/AdminProductComeFrom`,
type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},
success:function(data){
if(data.status){//return data as true
    var data=data.result;
    getData=``;

for(var i=0;i<data.length;i++){
    getData+=`
    <li class="list-group-item d-flex justify-content-between align-items-center">
    ${data[i].comeFrom}
    <span class="badge "><i class="fas fa-check text-success"></i>|<i class="fas fa-check text-success"></i></span>
  </li>
    `;
}



    $('.SettingComeFromLoad').html(getData);


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
function AdminAddComeFrom(){
    //settingComeFromAddClass
}


async function LoadComeFrom(){
    let mydata=await LoadSettingComeFrom();
    var data=mydata.result;

    getData=`<label>From</label>
<span><i class="fas fa-save text-success mylogout" title="Save this Setting" onClick="return SaveSettingComeFrom()"></i> <i class="fas fa-cog text-dark mylogout d-none" title="Setting" onClick="return SettingComeFrom()"></i></span>
<input type="hidden" class="form-control catName" name="catName" />
<select class="form-control catComeFrom" name="cat"  id="box1" onchange="CatComeChange()">`;

for(var i=0;i<data.length;i++){
    getData+=`<option value="${data[i].id}">${data[i].comeFrom}</option>`;
}


getData+=`</select>`;


    $('.ComeFromLoader').html(getData);
    //

   // data=comeFromTableArr;
    //

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
data:$('.formDataCreate').serialize(),
success:function(data){
if(data.status){//return data as true

    //localStorage.setItem('Usertoken',data.token);
 //console.log(hashfunction);
 $('.cover-spin').hide();

 //ViewAllProducts();

    alert("Product Created Successfully");
    $('.formDataCreate :input').val("");
    $('.mycreateProduct').val("Submit");

    LoadSavedComeFrom();

}
else{
alert("Product Code exists already,Please add New Product Code");
$('.cover-spin').hide();

}



},
error:function(data){
    console.log(data);
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




</body>
</html>
