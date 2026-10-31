@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

<style>
.iti{
    width: 100%;
}
</style>

<div class="d-lg-flex half">
<a href="/" class="text-decoration-none"><div class="position-absolute pt-2 pl-2">
      <a href="/" class="btn-sm btn-block btn-dark text-white icon-rotate-left text-decoration-none pl-3 pr-3"></a>

     </div></a>
    <div class="bg order-1 order-md-2 d-none d-md-block" style="background-image: url({{ asset('images/bg_1og2test.jpg') }});"></div>
    <div class="contents order-2 order-md-1">

      <div class="container pt-4 pt-md-0">
        <div class="row align-items-top align-items-md-center  justify-content-center">
          <div class="col-md-7">
            <h3 class="text-center">Register User Under <strong>{{$user[0]->CompanyName}}</strong></h3>
            <p class="mb-4 d-none">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            <form action="#" class="Form_UserRegister">
            <div class="form-group first d-none">
                <label for="username">Company Name</label>
                <input type="hidden" value="inactive2" name="status"/>
                <input autocomplete="off" type="text"  class="form-control" name="CompanyName" value="{{$user[0]->CompanyName}}" required>
              </div>
              <div class="form-group last mb-3 d-none">
                <label for="password">Subscriber</label>
                <input autocomplete="off" type="text" class="form-control"   name="subscriber" placeholder="" required value="{{$user[0]->subscriber}}">
              </div>
              <div class="form-group first">
                <label for="username">Name</label>
                <input autocomplete="off" type="text"  class="form-control" name="name" placeholder="Name" required>
              </div>

              <div class="form-group first">
                <label for="username">Email <span class="text-danger emailError"></span></label>
                <input type="text" name="email"  class="form-control" placeholder="Email" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input autocomplete="off" type="password"  name="password" class="form-control" placeholder="Password" required>
              </div>

              <div class="form-group last mb-3 ">
                <label for="password">Tel <span class="text-danger phoneError"></span></label>
                <input autocomplete="off" type="text" class="form-control"  id="phone" name=""  required>
              </div>

              <div class="form-group last mb-3 d-none">
                <label for="password">Phone Number</label>
                <input autocomplete="off" type="text" class="form-control"  id="phoneNumber" name="PhoneNumber"  required>
              </div>

              <div class="form-group last mb-3 d-none">
                <label for="password">UId</label>
                <input autocomplete="off" type="text" class="form-control"   name="uid" placeholder="" required value="{{$user[0]->uid}}">
              </div>



              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0 d-none"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked d-none"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="adminlogin" class="forgot-pass">Login</a></span>
              </div>

              <input type="submit" value="Register" class="btn btn-block btn-primary btnsbmt" >

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script>
$(function() {
    $('.cover-spin').hide();
})

$('.Form_UserRegister').submit(function(e){
    e.preventDefault();

    $('.cover-spin').show();
$.ajax({

    url:"{{ url('api/CreateCompany') }}",
type:'post',
data:$('.Form_UserRegister').serialize(),
success:function(data){
if(data.status){//return data as true


     alert("You have Successfully Registered");

     var webLink = window.location;
var protocol=webLink.protocol;
var websiteName=(webLink.hostname==='localhost')?webLink.host:window.location.hostname;
window.location.href = `${protocol}//${websiteName}/adminlogin`;
     console.log(data);


}
else{
    $('.cover-spin').hide();
    var email=0;
    var phone=0;
    for(var i=0;i<(data.result).length;i++){
        email=(data.result[i]["email"]===data.email)?email+1:0;
        phone=(data.result[i]["PhoneNumber"]===data.phone)?phone+1:0;
    }

    (email>0)?$('.emailError').text("email exist please add another email"):$('.emailError').text("");
    (phone>0)?$('.phoneError').text("phone exist please add another phone Number"):$('.phoneError').text("");

    //alert("something Went Wrong please use different email");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});

return false;

});

</script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#phone");
  //var iti = intlTelInput(input);

  var iti= window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",

    initialCountry:"CD",
    separateDialCode:true,

  });
  input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
  //iti.setNumber("+44 7733 123 456");//this is to add number
$('#phoneNumber').val(iti.getNumber());
(iti.isValidNumber())?$('.phoneError').text(""):$('.phoneError').text("phone is not Valid");
(iti.isValidNumber())?$('.btnsbmt').show():$('.btnsbmt').hide();
  console.log(iti.getNumber());//this is to get number
  console.log(iti.isValidNumber()); //this is to check if number is valid
});
input.addEventListener("keyup", function() {
  // do something with iti.getSelectedCountryData()
  $('#phoneNumber').val(iti.getNumber());
  (iti.isValidNumber())?$('.phoneError').text(""):$('.phoneError').text("phone is not Valid");
(iti.isValidNumber())?$('.btnsbmt').show():$('.btnsbmt').hide();
  console.log(iti.getNumber());
  console.log(iti.getSelectedCountryData());
  console.log(iti.getSelectedCountryData()["name"]);
  console.log(iti.getSelectedCountryData()["dialCode"]);
  console.log(iti.getSelectedCountryData()["iso2"]);//initial
  console.log(iti.isValidNumber());
  //console.log(iti.getNumberType());
  //.iti { width: 100%; };
});
</script>

@endsection
