<script>
 function profile_clearnotification(){
     var not_counter=$('.not_counter').text();

     if(not_counter!='')
     {
        $.ajax({

url:`./profile_clearnotification`,
type:'get',
success:function(data){
if(data.status){//return data as true
   $('.not_counter').text('');
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
     else{
         console.log("no notification");
     }

 }
function admin_changestatus(userid,name,status,table_name){


$('.formdatasubmit_append').html(`<div class="form-goup">
<input type="text" value="${userid}" name="userid" class="form-control">
</div>
<div class="form-goup">
<input type="text" value="${status}" name="status" class="form-control">
</div>
<div class="form-goup">
<input type="text" value="${table_name}" name="table_name" class="form-control">
</div>
<div class="form-goup">
<input type="text" value="${table_name}" name="comment" class="form-control">
</div>
`);

    //
   /* $('.modal_footerappend').html(`
    <button type="button" class="btn btn-danger" onclick="return reject_btn()">Reject</button>
    `);*/

    //
    if(confirm(`Are you sure you want to change ${name} to be ${status}`))
    {
        adminstatus_submit();
    }

}
function tablepaid_membership(id,userid,name)
{

    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("Extends");
    $('.formdatasubmit_append').html(`
    <div class="form-group">
    <label for="">Pharmacy Name</label>
    <input type="text" class="form-control" name="name" value="${name}" readonly>
    <input type="hidden" class="form-control" name="clientid" value="${userid}" readonly>
    </div>
    <div class="form-group">
    <label for="">Extend From Date-To</label>
    <input type="text" class="form-control" name="extended_date" id="extended_date">
    </div>

    <div class="form-group">
    <label for="">Price</label>
    <input type="text" class="form-control" name="Price" placeholder="Enter Price" required>
    </div>
    <div class="form-group">
    <button class="btn btn-primary" onclick="return adminpayment_extension()">Submit</button>
    </div>
    `);


/*var start_time=available_date.split('to')[0];
var end_time=available_date.split('to')[1];*/

flatpickr('#extended_date',{
    enableTime: true,
  mode: "range",
  minDate: "today",
    dateFormat: "Y-m-d H:i:s",
    time_24hr: true
    //defaultDate: [start_time, end_time]
});
}

function table_report_users(uid,reported_uid,reported_table,table_name)
{
    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("Complaints Forms");

    $('.formdatasubmit_append').html(`
    <div class="form-group">
    <label for="">Order ID</label>
    <input type="text" name="uid" class="form-control" readonly value="${uid}">
    <input type="hidden" name="reported_uid" class="form-control" readonly value="${reported_uid}">
    <input type="hidden" name="report_table" class="form-control" readonly value="${reported_table}">
    <input type="hidden" name="table_name" class="form-control" readonly value="${table_name}">
    </div>
    <div class="form-group">
    <label for="">Description</label>
    <textarea name="desc"  class="form-control" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
    <button class="btn btn-primary" onclick="return submit_complain()">Submit</button>
    </div>
    `);
}
function submit_complain(){
//
$.ajax({

url:`./report_orders`,
type:'post',
data:$('#formdatasubmit').serialize(),
success:function(data){
if(data.status){//return data as true

     alert("query has executed successfuly");
     //console.log(hashfunction);
    mainmethod[hashfunction]();

}
else{
    if(data.error==='3')
    {
        alert("You have already complain to this Order");
    }

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
function table_clientview_order(uid,owner_uid,accepted_request,delivery_price,total_price,phone1,phone2,product_uid,product_name,price,qty,name,pay_mode,address,status,client_msg,created_at,updated_at,type_order,prescr_imgurl,owner_msg)
{
    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("View order");

var product_decrypt=atob(product_name);
   var myproduct_nameparse=product_decrypt==='none'?'':JSON.parse(product_decrypt);
      var myproduct="";
      for(var i=0; i<myproduct_nameparse.length;i++)
      {
        myproduct+=`<div class="form-group">

  <label for="">Medicine Name</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].med_name}" readonly>
  </div>

  <label for="">Qty</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].qty}" readonly>
  </div>

  <label for="">Price</label>
  <input type="text" class="form-control" name="pricing" value="${myproduct_nameparse[i].price}" readonly>
  </div>

  `
      }

      var prescrImg=`<div class="form-group">
      <a href="#" class="btn btn-primary " onclick="return view_image('${prescr_imgurl}')">View Image</a>
<img src="upload/${prescr_imgurl}" class="img-fluid d-none myimage" alt="Responsive image">


      </div>`;
      myproduct=product_decrypt==='none'?prescrImg:myproduct;
$('.formdatasubmit_append').html(`
<div class="form-group">
    <label for="">Order ID</label>
    <input type="text" class="form-control" name="order_id" value="${uid}" readonly>
</div>
${myproduct}
<div class="form-group">
    <label for="">Delivery Cost</label>
    <input type="text" class="form-control" name="delivery_price" value="${delivery_price}" readonly>
</div>
<div class="form-group">
    <label for="">Total</label>
    <input type="text" class="form-control" name="total_price" value="${total_price}" readonly>
</div>
<div class="form-group">
    <label for="">Order Confirmed</label>
    <input type="text" class="form-control" name="accepted_request" value="${accepted_request}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Owner ID</label>
    <input type="text" class="form-control" name="owner_id" value="${owner_uid}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Client Name</label>
    <input type="text" class="form-control" name="client_name" value="${name}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Comment</label>
    <textarea name="" id="" cols="30" rows="5" class="form-control" readonly>${client_msg}</textarea>

</div>
<div class="form-group">
    <label for="">Payment Option</label>
    <input type="text" class="form-control" name="pay_mode" value="${pay_mode}" readonly>
</div>
<div class="form-group">
    <label for="">Status</label>
    <input type="text" class="form-control" name="status" value="${status}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Client Tel 1</label>
    <input type="text" class="form-control" name="phone1" value="${phone1}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Client Tel 2</label>
    <input type="text" class="form-control" name="phone2" value="${phone2}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Product ID</label>
    <input type="text" class="form-control" name="product_uid" value="${product_uid}" readonly>
</div>


<div class="form-group">
    <label for="">Created At</label>
    <input type="text" class="form-control" name="created_at" value="${created_at}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Quantity</label>
    <input type="text" class="form-control" name="qty" value="${qty}" readonly>
</div>



<div class="form-group d-none">
    <label for="">Type of Order</label>
    <input type="text" class="form-control" name="type_order" value="${type_order}" readonly>
</div>
<div class="form-group d-none">
    <label for="">View Image</label>
    <input type="text" class="form-control" name="accepted_request" value="${prescr_imgurl}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Pharmacy Message</label>
    <input type="text" class="form-control" name="owner_msg" value="${owner_msg}" readonly>
</div>

`);
}
function table_pharmacyview_order(uid,owner_uid,accepted_request,delivery_price,total_price,phone1,phone2,product_uid,product_name,price,qty,name,pay_mode,address,status,client_msg,created_at,updated_at,type_order,prescr_imgurl,owner_msg)
{
    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("View order");
var product_decrypt=atob(product_name);
   //var myproduct_nameparse=JSON.parse(product_decrypt);
   var myproduct_nameparse=product_decrypt==='none'?'':JSON.parse(product_decrypt);
      var myproduct="";
      for(var i=0; i<myproduct_nameparse.length;i++)
      {
        myproduct+=`<div class="form-group">

  <label for="">Medicine Name</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].med_name}" readonly>
  </div>

  <label for="">Qty</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].qty}" readonly>
  </div>

  <label for="">Price</label>
  <input type="text" class="form-control" name="pricing" value="${myproduct_nameparse[i].price}" readonly>
  </div>

  `
      }

      var prescrImg=`<div class="form-group">
      <a href="#" class="btn btn-primary " onclick="return view_image('${prescr_imgurl}')">View Image</a>
<img src="upload/${prescr_imgurl}" class="img-fluid d-none myimage" alt="Responsive image">


      </div>`;
      myproduct=product_decrypt==='none'?prescrImg:myproduct;

$('.formdatasubmit_append').html(`
<div class="form-group">
    <label for="">Order ID</label>
    <input type="text" class="form-control" name="order_id" value="${uid}" readonly>
</div>
${myproduct}
<div class="form-group">
    <label for="">Delivery Cost</label>
    <input type="text" class="form-control" name="delivery_price" value="${delivery_price}" readonly>
</div>
<div class="form-group">
    <label for="">Total</label>
    <input type="text" class="form-control" name="total_price" value="${total_price}" readonly>
</div>
<div class="form-group">
    <label for="">Order Confirmed</label>
    <input type="text" class="form-control" name="accepted_request" value="${accepted_request}" readonly>
</div>


<div class="form-group">
    <label for="">Client Name</label>
    <input type="text" class="form-control" name="client_name" value="${name}" readonly>
</div>
<div class="form-group">
    <label for="">Comment</label>
    <textarea name="" id="" cols="30" rows="5" class="form-control" readonly>${client_msg}</textarea>

</div>
<div class="form-group">
    <label for="">Payment Option</label>
    <input type="text" class="form-control" name="pay_mode" value="${pay_mode}" readonly>
</div>
<div class="form-group">
    <label for="">Status</label>
    <input type="text" class="form-control" name="status" value="${status}" readonly>
</div>
<div class="form-group">
    <label for="">Contact no</label>
    <input type="text" class="form-control" name="phone1" value="${phone1}" readonly>
</div>
<div class="form-group">
    <label for="">alternative contact no</label>
    <input type="text" class="form-control" name="phone2" value="${phone2}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Product ID</label>
    <input type="text" class="form-control" name="product_uid" value="${product_uid}" readonly>
</div>


<div class="form-group">
    <label for="">Created At</label>
    <input type="text" class="form-control" name="created_at" value="${created_at}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Quantity</label>
    <input type="text" class="form-control" name="qty" value="${qty}" readonly>
</div>



<div class="form-group d-none">
    <label for="">Type of Order</label>
    <input type="text" class="form-control" name="type_order" value="${type_order}" readonly>
</div>
<div class="form-group d-none">
    <label for="">View Image</label>
    <input type="text" class="form-control" name="accepted_request" value="${prescr_imgurl}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Pharmacy Message</label>
    <input type="text" class="form-control" name="owner_msg" value="${owner_msg}" readonly>
</div>

`);
}
function table_superview_order(uid,owner_uid,accepted_request,delivery_price,total_price,phone1,phone2,product_uid,product_name,price,qty,name,pay_mode,fname,lname,address,status,client_msg,created_at,updated_at,type_order,prescr_imgurl,owner_msg)
{
    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("View order");


var product_decrypt=atob(product_name);
   var myproduct_nameparse=JSON.parse(product_decrypt);
      var myproduct="";
      for(var i=0; i<myproduct_nameparse.length;i++)
      {
        myproduct+=`<div class="form-group">

  <label for="">Medicine Name</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].med_name}" readonly>
  </div>

  <label for="">Qty</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].qty}" readonly>
  </div>

  <label for="">Price</label>
  <input type="text" class="form-control" name="pricing" value="${myproduct_nameparse[i].price}" readonly>
  </div>

  `
      }


$('.formdatasubmit_append').html(`
<div class="form-group">
    <label for="">Order ID</label>
    <input type="text" class="form-control" name="order_id" value="${uid}" readonly>
</div>
${myproduct}
<div class="form-group">
    <label for="">Delivery Cost</label>
    <input type="text" class="form-control" name="delivery_price" value="${delivery_price}" readonly>
</div>
<div class="form-group">
    <label for="">Total</label>
    <input type="text" class="form-control" name="total_price" value="${total_price}" readonly>
</div>
<div class="form-group">
    <label for="">Order Confirmed</label>
    <input type="text" class="form-control" name="accepted_request" value="${accepted_request}" readonly>
</div>
<div class="form-group">
    <label for="">Pharmacy ID</label>
    <input type="text" class="form-control" name="owner_id" value="${owner_uid}" readonly>
</div>

<div class="form-group">
    <label for="">Client Name</label>
    <input type="text" class="form-control" name="client_name" value="${name}" readonly>
</div>
<div class="form-group">
    <label for="">Client Comment</label>
    <textarea name="" id="" cols="30" rows="5" class="form-control" readonly>${client_msg}</textarea>

</div>
<div class="form-group">
    <label for="">Payment Option</label>
    <input type="text" class="form-control" name="pay_mode" value="${pay_mode}" readonly>
</div>
<div class="form-group">
    <label for="">Status</label>
    <input type="text" class="form-control" name="status" value="${status}" readonly>
</div>
<div class="form-group">
    <label for="">Client Contact no</label>
    <input type="text" class="form-control" name="phone1" value="${phone1}" readonly>
</div>
<div class="form-group">
    <label for="">Client alternative contact no</label>
    <input type="text" class="form-control" name="phone2" value="${phone2}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Product ID</label>
    <input type="text" class="form-control" name="product_uid" value="${product_uid}" readonly>
</div>


<div class="form-group">
    <label for="">Created At</label>
    <input type="text" class="form-control" name="created_at" value="${created_at}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Quantity</label>
    <input type="text" class="form-control" name="qty" value="${qty}" readonly>
</div>



<div class="form-group d-none">
    <label for="">Type of Order</label>
    <input type="text" class="form-control" name="type_order" value="${type_order}" readonly>
</div>
<div class="form-group d-none">
    <label for="">View Image</label>
    <input type="text" class="form-control" name="accepted_request" value="${prescr_imgurl}" readonly>
</div>
<div class="form-group">
    <label for="">Pharmacy Comment</label>
    <input type="text" class="form-control" name="owner_msg" value="${owner_msg}" readonly>
</div>

`);
}
function adminpayment_extension()
{
    //
    $.ajax({

url:`./adminpayment_extension`,
type:'post',
data:$('#formdatasubmit').serialize(),
success:function(data){
if(data.status){//return data as true

     alert("query has executed successfuly");
     //console.log(hashfunction);
    mainmethod[hashfunction]();

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
function adminstatus_submit()
{
    //
    $.ajax({

url:`./admin_changestatus`,
type:'post',
data:$('#formdatasubmit').serialize(),
success:function(data){
if(data.status){//return data as true

     alert("query has executed successfuly");
     //console.log(hashfunction);
    mainmethod[hashfunction]();

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

//profile update
$('.change_profile').submit(function(e){
//
$('.limiter').append(`<div class="cover-spin"></div>`);
var check_location=$('.change_profile  .lat').val();
console.log(check_location);
if(check_location!='')
{
    console.log("done");
$.ajax({

url:`./change_profile`,
type:'post',
data:$('.change_profile').serialize(),
success:function(data){
if(data.status){//return data as true
    //alert("status updated");
    $('.cover-spin').remove();
    Swal.fire({
  title: '',
  text: "You Profile has been updated",
  icon: 'success',


}).then((result) => {
  //console.log("true");
  window.location.href="./profile";
  //dynamic_menu('Forms_Home');
})

    //console.log(data);
    //alert("Seat has booked check on your email for more infos");




}
else{
    $('.cover-spin').remove();
    //alert(data.errors);
    if(data.error==='1')
    {
        alert("please you are unauthorized user");
    }
    else{
        var dataerror=data.error;
   // console.log(data.error);

   var myerrors=Object.values(dataerror);
   var arr_error="";
   for(var i=0;i<myerrors.length;i++)
   {
      // console.log(myerrors[i][0]);
      arr_error+=myerrors[i][0]+"\n";

   }
alert('errors \n'+arr_error);

    }




}




},
error:function(data){
//alert(data.statusText);
}

//
});
}
else{
    alert("Address is invalid,Please type on this format: Street address, City, Country");
    $('.cover-spin').remove();
}

//
e.preventDefault();
});


//

//medecine submit//
//profile update

//medecine submit//
$('.medecine_request').submit(function(e){
//
$('.limiter').append(`<div class="cover-spin"></div>`);
if(arr.length>0)
{

    //
    $.ajax({

url:`./medecine_request`,
type:'post',
data:$('.medecine_request').serialize(),
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').remove();
   //alert("status updated");
   Swal.fire({
  title: '',
  text: "successfuly Submitted expect a response soon",
  icon: 'success',


}).then((result) => {
 // console.log("true");

 //get_chatrequest();
 window.location.href="./profile";
})
    //alert("Seat has booked check on your email for more infos");




}
else{

}



},
error:function(data){
//alert(data.statusText);
alert("please check if your Address is Correct or change address");
$('.cover-spin').remove();
}

//
});
    //
}
else{
    $('.cover-spin').remove();
    alert("Please Add Medicine");
}
e.preventDefault();
//
});

$('.upload_require_request').submit(function(e){
    $('.limiter').append(`<div class="cover-spin"></div>`);
    var formData = new FormData(this);
//
$.ajax({

url:`./upload_require_request`,
type:'post',
data:formData,
cache:false,
contentType: false,
processData: false,
success:function(data){
if(data.status){//return data as true
    $('.cover-spin').remove();
    //console.log(data);
    //alert("Seat has booked check on your email for more infos");

    //alert("status updated");
    Swal.fire({
  title: '',
  text: "successfuly Submitted expect a response soon",
  icon: 'success',


}).then((result) => {
 // console.log("true");
 $('.cover-spin').remove();

 //get_chatrequest();
 window.location.href="./profile";
})


}
else{

}



},
error:function(data){
//alert(data.statusText);
alert("please check if your Address is Correct or change address");
$('.cover-spin').remove();
}

//
});
//
e.preventDefault();
});


//

//medecine submit//

var detect_key=0;
           $('.location_address').click(function(){
               console.log("clicked");
               if(detect_key==0)
               {
           $('.location_address').val("");
           detect_key=1;
               }
           });
function choose_marital_status(thisdata)
{
if(thisdata.value==='others')
{
    $('#marital_status').attr("name","none");
$('.marital_others').attr("name","marital_status");
$('.divmarital_others').removeClass('d-none');
}
else{
    $('#marital_others').attr("name","marital_status");
$('.marital_others').attr("name","none");
$('.divmarital_others').addClass('d-none');
$('.mart_status').text(thisdata.value);
}
}

 function table_boost_user_rating(id,userid,isboosted)//or reset
 {
     console.log(isboosted);
   var ismessage=isboosted==='text-warning'?'Are you sure you want to Boost This user Rating?':'Are you sure you want to Reset This user Rating?';
    if(confirm(ismessage))
    {
        $.ajax({

      url:'./table_boost_user_rating',
      type:"post",
     data:{
    userid:userid,
   "_token":'{{ csrf_token() }}',
     },
      success:function(data)
      {


  if(data.status)
  {


      mainmethod[hashfunction]();



  }






      }
    });
    }
    return false;

 }

 function table_reset_user_rating(id,userid)
 {
    if(confirm("Are you sure you want to Reset This user Rating?"))
    {
        $.ajax({

      url:'./table_reset_user_rating',
      type:"post",
     data:{
    userid:userid,
   "_token":'{{ csrf_token() }}',
     },
      success:function(data)
      {


  if(data.status)
  {


      mainmethod[hashfunction]();



  }






      }
    });
    }
    return false;

 }
function received_orders(id,uid,reported_uid,reported_table,table_name){
    Swal.fire({


  html:
    `<div class="container">
    <h3 class="text-center text-danger"><strong><u>Rate</u></strong></h3>

    <div class="myrating-wrapper div_center">
    <input type="hidden" class="id_rating" value="${id}">
<input type="hidden" class="userid_rating" value="${reported_uid}">
<input type="hidden" class="user_rating">
            <span class="fa fa-star ratingclass myrating myrating_1" onclick="return rating(1)"></span>
            <span class="fa fa-star ratingclass myrating myrating_2" onclick="return rating(2)"></span>
            <span class="fa fa-star ratingclass myrating myrating_3" onclick="return rating(3)"></span>
            <span class="fa fa-star ratingclass myrating myrating_4" onclick="return rating(4)"></span>
            <span class="fa fa-star ratingclass myrating myrating_5" onclick="return rating(5)"></span>
        </div>
    </div>`,
  showCloseButton: true,

  focusConfirm: false,

  //allowOutsideClick: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Submit!',
  confirmButtonAriaLabel: 'Thumbs up, Submit!',

}).then((result) => {
    if(result.isConfirmed) {

//Swal.fire('Saved!', '', 'success')
//Swal.isVisible()

if($('.user_rating').val()!='')
      {
        received_order();
      }
      else{
        alert("Please rate before submit");
      }

} else if (result.isDenied) {
Swal.fire('Changes are not saved', '', 'info')
}
})

$('.swal2-confirm').hide();
}
function rating(number)
{
    //$('.user_rating').val(number*1);
    $('.user_rating').val(number*20);
    $('.myrating').removeClass('rating_back');
    for(var i=0;i<=number;i++)
{
    var rating_more="myrating_"+i;
    $('.'+rating_more).addClass('rating_back');
}
$('.swal2-confirm').show();

}
function received_order(){
    var id=$('.id_rating').val();
    var userid=$('.userid_rating').val();
    var rating=$('.user_rating').val();
    $.ajax({

      url:'./received_order',
      type:"post",
     data:{
    id:id,
    userid:userid,
    rating:rating,
    "_token":'{{ csrf_token() }}',
     },
      success:function(data)
      {


  if(data.status)
  {


      mainmethod[hashfunction]();
      //window.location.href="./profile#Forms_updateProfile";


  }






      }
    });
}
function Reject_this_order(uid,userid,uid_provider,pricing,pricing_delivery,pay_mode,ui_message,img_url,description,product_id,phone,phone2,product_name,delivering_time,total_pricing,address,user_delivery_choice){
    if(confirm("Are you sure you want to Cancel This order"))//this will cancel all orders associated with this
    {
        $('.limiter').append(`<div class="cover-spin"></div>`);
if(check_platform==='{{env('Client')}}')
{
    client_reject_order(uid,uid_provider);
}
else{
    admin_reject_order(uid,userid);
}
    }
    return false;
}
function client_reject_order(uid,uid_provider){
    //
    $.ajax({

url:`./request_reject_order`,
type:'post',
data:{
    uid:uid,
    uid_provider:uid_provider,
   "_token":'{{ csrf_token() }}',
     },
success:function(data){
if(data.status){//return data as true
  $('.cover-spin').remove();
     //alert("query has executed successfuly");
     Swal.fire({
  title: '',
  text: "Order Cancelled",
  icon: 'success',


}).then((result) => {

  window.location.href="./profile";
  console.log("true");
})


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
function admin_reject_order(uid,userid){
//
$.ajax({

url:`./request_reject_order`,
type:'post',
data:{
    uid:uid,
    mydata_userid:userid,
   "_token":'{{ csrf_token() }}',
     },
success:function(data){
if(data.status){//return data as true
  $('.cover-spin').remove();
     //alert("query has executed successfuly");
     Swal.fire({
  title: '',
  text: "Order Cancelled",
  icon: 'success',


}).then((result) => {

  window.location.href="./profile";
  console.log("true");
})


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

function table_view_placed_order(uid,userid,user_delivery_choice,name,user_message,phone,phone2,product_id,product_name,client_notification,uid_provider,delivering_time,uid_message,uid_notification,pharmacie_name,pharmacie_location,img_url,pricing,pricing_delivery,total_pricing,pay_mode,address,description,status,created_at)
{
    //
    $('#modal_formdatasubmit').modal("show");
    $('.formdata_title').text("View order");
    var show_hideimg=atob(img_url)==='none'?'d-none':'';



var product_decrypt=atob(product_name);
   var myproduct_nameparse=product_decrypt==='none'?'':JSON.parse(product_decrypt);
      var myproduct="";
      for(var i=0; i<myproduct_nameparse.length;i++)
      {
        myproduct+=`<div class="form-group">

  <label for="">Medicine Name</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].med_name}" readonly>
  </div>

  <div class="form-group">
  <label for="">Qty</label>
  <input type="text" class="form-control" value="${myproduct_nameparse[i].qty}" readonly>
  </div>
  <div class="form-group d-none">
  <label for="" class="d-none">Price</label>
  <input type="text" class="form-control d-none" name="pricing" value="${myproduct_nameparse[i].price}" readonly>
  </div>

  `
      }

      var price_prescr=`
      <div class="form-group d-none">
      <label for="">Price</label>
<input type="text" class="form-control mypricing_request" name="pricing" onkeyup="return keyadd_pricing('none',this)"  required>
</div>`;
      myproduct=product_decrypt==='none'?price_prescr:myproduct;

$('.formdatasubmit_append').html(`
<div class="form-group">
    <label for="">Order ID</label>
    <input type="text" class="form-control" name="order_id" value="${uid}" readonly>
</div>
${myproduct}
<div class="form-group d-none">
    <label for="">Delivery Cost</label>
    <input type="text" class="form-control" name="delivery_price" value="${pricing_delivery}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Total</label>
    <input type="text" class="form-control" name="total_price" value="${total_pricing}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Order Confirmed</label>
    <input type="text" class="form-control" name="accepted_request" value="$accepted_request}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Owner ID</label>
    <input type="text" class="form-control" name="owner_id" value="${userid}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Client Name</label>
    <input type="text" class="form-control" name="client_name" value="${name}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Comment</label>
    <textarea name="" id="" cols="30" rows="5" class="form-control" readonly>${user_message}</textarea>

</div>
<div class="form-group d-none">
    <label for="">Payment Option</label>
    <input type="text" class="form-control" name="pay_mode" value="${pay_mode}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Status</label>
    <input type="text" class="form-control" name="status" value="status" readonly>
</div>
<div class="form-group">
    <label for="">Name</label>
    <input type="text" class="form-control" name="phone1" value="${name}" readonly>
</div>
<div class="form-group">
    <label for="">Address</label>
    <input type="text" class="form-control" name="phone1" value="${address}" readonly>
</div>
<div class="form-group">
    <label for="">Contact no</label>
    <input type="text" class="form-control" name="phone1" value="${phone}" readonly>
</div>
<div class="form-group">
    <label for="">alternative contact no</label>
    <input type="text" class="form-control" name="phone2" value="${phone2}" readonly>
</div>
<div class="form-group d-none">
    <label for="">Product ID</label>
    <input type="text" class="form-control" name="product_uid" value="${product_id}" readonly>
</div>


<div class="form-group">
    <label for="">Created At</label>
    <input type="text" class="form-control" name="created_at" value="${created_at}" readonly>
</div>

<div class="form-group d-none">
    <label for="">Quantity</label>
    <input type="text" class="form-control" name="qty" value="${qty}" readonly>
</div>



<div class="form-group">
    <label for="">Type of Order</label>
    <input type="text" class="form-control" name="type_order" value="${user_delivery_choice}" readonly>
</div>
<a href="#" class="btn btn-primary ${show_hideimg}" onclick="return view_image('${atob(img_url)}')">View Image</a>
<img src="upload/${atob(img_url)==='none'?'1.jpg':atob(img_url)}" class="img-fluid d-none myimage" alt="Responsive image">
<div class="form-group d-none">
    <label for="">View Image</label>
    <input type="text" class="form-control" name="accepted_request" value="${img_url}" readonly>
</div>
<div class="form-group">
    <label for="">Message</label>
    <input type="text" class="form-control" name="owner_msg" value="${atob(description)}" readonly>
</div>

`);
   //
}
function choose_title(thisdata)
{
if(thisdata.value==='others')
{
    $('#mytitle').attr("name","none");
$('.title_others').attr("name","title");
$('.divtitle_others').removeClass('d-none');
}
else{
    $('#mytitle').attr("name","title");
$('.title_others').attr("name","none");
$('.divtitle_others').addClass('d-none');
$('.mtitle_pro').text(thisdata.value);
}
}
function choose_gender(thisdata)
{
if(thisdata.value==='others')
{
    $('#mytitle').attr("name","none");
$('.title_others').attr("name","title");
$('.divtitle_others').removeClass('d-none');
}
else{
    $('#mytitle').attr("name","title");
//$('.gender_others').attr("name","none");
//$('.gender_others').addClass('d-none');
$('.mgender_pro').text(thisdata.value);
}
}
</script>
