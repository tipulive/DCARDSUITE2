@extends('layouts.app')
@section('content')

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
            <h3 class="text-center">Admin <strong>Register</strong></h3>
            <p class="mb-4 d-none">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            <form action="#" class="Form_UserRegister">
              <div class="form-group first">
                <label for="username">Name</label>
                <input autocomplete="off" type="text"  class="form-control" name="name" placeholder="Name" required>
              </div>

              <div class="form-group first">
                <label for="username">Email or username</label>
                <input type="text" name="email"  class="form-control" placeholder="Email" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input autocomplete="off" type="password"  name="password" class="form-control" placeholder="Password" required>
              </div>

              <div class="form-group last mb-3 d-none">
                <label for="password">Tel</label>
                <input autocomplete="off" type="text" class="form-control"  id="phone" value="07878" placeholder="" required>
              </div>

              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0 d-none"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked d-none"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="adminlogin" class="forgot-pass">Login</a></span>
              </div>

              <input type="submit" value="Register" class="btn btn-block btn-primary" >

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

    url:`./api/AdminRegisterEmail`,
type:'post',
data:$('.Form_UserRegister').serialize(),
success:function(data){
if(data.status){//return data as true


     alert("You have Successfully Registered");
     //console.log(hashfunction);
     window.location.href = "adminlogin";

}
else{
    alert("something Went Wrong please use different email");
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


@endsection
