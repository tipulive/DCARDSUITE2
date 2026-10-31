@extends('layouts.app')
@section('content')
<div class="d-lg-flex half">
    <div class="bg order-1 order-md-2 d-none d-md-block" style="background-image: url('images/bg_20.jpg');"></div>
    <div class="contents order-2 order-md-1">

    <div class="container pt-4 pt-md-0">
        <div class="row align-items-top align-items-md-center  justify-content-center">
          <div class="col-md-7">

            <h3 class="text-center pt-2">Welcome to <strong>WareHouse</strong></h3>
            <p class="mb-4 d-none">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            <img src="images/home.png" class="img-fluid pb-2 d-sm-none"/>




              <div class="row">
                <div class="col">
                  <a href="userlogin"  class="text-decoration-none"><input type="submit" value="User" class="btn btn-block btn-danger"></a>
                </div>
                <div class="col">
                <a href="adminlogin" class="text-decoration-none"><input type="submit" value="Admin" class="btn btn-block btn-primary"></a>
                </div>
              </div>



          </div>
        </div>
      </div>
    </div>


  </div>

 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
 <script src="dashboard/vendor/jquery-3.2.1.min.js"></script>

<script>
$(function() {
  $('.cover-spin').hide();
})


</script>
@endsection
