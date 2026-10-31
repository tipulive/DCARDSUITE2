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

<!--header-->
@include('components.header.header')
<!--header-->

</head>
<body>

<!--search form-->
<div class="container">
<!--form -->
<div class="main-card mb-3 card p-4">
            <!--My Form-->
            <form class="Form_AdminRegister" >

            <div class="container mt-5">

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card px-5 py-5" id="form1">
            <div class="success-data" v-else>
                    <div class="text-center d-flex flex-column"> <i class='bx bxs-badge-check'></i> <span class="text-center fs-1">Admin Register</span> </div>
                </div>
                <div class="form-data" v-if="!submitted">
                    <div class="forms-inputs mb-2"> <span>First Name</span>
                    <input autocomplete="off" type="text"  class="form-control" name="fname" placeholder="" required>
                        <div class="invalid-feedback">A valid email is required!</div>
                    </div>
                    <div class="forms-inputs mb-2"> <span>Last Name</span>
                    <input autocomplete="off" type="text"  class="form-control" name="lname" placeholder="" required>
                        <div class="invalid-feedback">Password must be 8 character!</div>
                    </div>

                    <div class="forms-inputs mb-2"> <span>Email or username</span>
                    <input autocomplete="off" type="text" name="email"  class="form-control" placeholder="" required>
                        <div class="invalid-feedback">A valid email is required!</div>
                    </div>
                    <div class="forms-inputs mb-4"> <span>Password</span>
                    <input autocomplete="off" type="password"  name="password" class="form-control" placeholder="" required>
                        <div class="invalid-feedback">Password must be 8 character!</div>
                    </div>


                    <div class="forms-inputs mb-2"> <span>Tel</span>
                    <input autocomplete="off" type="text" class="form-control" name="tel" placeholder="" required>
                        <div class="invalid-feedback">Password must be 8 character!</div>
                    </div>

                    <div class="mb-3"> <input type="submit"  class="btn btn-dark w-100" value="Register"> </div>
                </div>
                <div class="success-data d-none" v-else>
                    <div class="text-center d-flex flex-column"> <i class='bx bxs-badge-check'></i> <span class="text-center fs-1">You have been logged in <br> Successfully</span> </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
            <!--My Form-->
        </div>
<!--form -->
</div>

<!--search form-->
@include('components.Footerjs.footerjs')
<script>
$('.Form_AdminRegister').submit(function(e){

    $.ajax({

url:`./api/AdminRegisterEmail`,
type:'post',
data:$('.Form_AdminRegister').serialize(),
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


</body>
</html>
