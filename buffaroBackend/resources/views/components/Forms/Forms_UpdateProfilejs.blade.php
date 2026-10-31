<div class="visible_div">

<form id="medecineupload" method="POST" action="{{ route('change_profile') }}">
{{ csrf_field() }}
<div class="form-group">
<label >First Name</label>
<input type="text" name="fname" id="fname" class="form-control fname" placeholder="Enter your First Name" >
</div>

<div class="form-group">
<label >Last Name</label>
<input type="text" name="lname" id="lname" class="form-control lname" placeholder="Enter your Last Name">
</div>
<div class="form-group">
<label >Email</label>
<input type="text" name="email" id="email" class="form-control email" placeholder="Enter Email">
</div>

<div class="form-group">
<label >Password</label>
<input type="password" name="password" id="password" class="form-control password" placeholder="Enter Email">
</div>


<div class="form-group">
<label >tel</label>
<input type="text" name="tel" id="tel" class="form-control tel" placeholder="Enter your Tel">
</div>


<div class="form-group input_form">
            <label>Your Full Address<span class="required"></span></label>
<input id="autocomplete" placeholder="Enter your Full address"
onFocus="geolocate()" type="text" class="form-control inputtype location_address phys_address"  name="phys_address">
</div>
<div class="form-group d-none">
<label >Latitude and Longitude</label>
<input type="text" name="lat" id="lat" class="form-control lat" placeholder="Enter your lat">
<input type="text" name="lng" id="lng" class="form-control lng" placeholder="Enter your lng">
</div>






<div class="form-group">
<button class="btn btn-primary">Update Profile</button>
</div>
</form>
</div>
