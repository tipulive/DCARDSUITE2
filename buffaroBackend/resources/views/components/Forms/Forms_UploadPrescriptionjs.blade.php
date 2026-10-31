<div class="visible_div">
<form  method="POST" action="{{ route('upload_require_request') }}"  enctype="multipart/form-data">
{{ csrf_field() }}
<div class="error_message text-danger"></div>
<div class="form-group input_form">
            <label>Your Full Address<span class="required"></span></label>
<input id="autocomplete" placeholder="Enter your Full address"
onFocus="geolocate()" onchange="return change_address()" onblur="return change_address()" type="text" class="form-control inputtype location_address phys_address"  name="address">
</div>
<div class="form-group">
<label >Latitude and Longitude</label>
<input type="text" name="lat" id="lat" class="form-control lat" placeholder="Enter your lat">
<input type="text" name="lng" id="lng" class="form-control lng" placeholder="Enter your lng">
</div>
<div class="form-group">
<label >Phone</label>
<input type="text" id="phone" name="phone" class="form-control tel" placeholder="Enter your Phone Number">
</div>
<div class="form-group">
<label >another Phone number</label>
<input type="text" id="phone2" name="phone2" class="form-control" placeholder="Type another Phone number">
</div>


<div class="form-group">
<label >Uploaad Prescription</span></label>
<input type="file"  name="file" class="form-control" required>
</div>
<div class="form-group">
<label >Description</label>
<textarea name="description" id="description" cols="30" rows="10" class="form-control disable_newline" placeholder="Description"></textarea>
</div>

<div class="append_div"></div>



<div class="form-group">
<button class="btn btn-primary">Submit</button>
</div>
</form>
</div>
