<div class="visible_div">
  

<div class="row">
    <div class="col-xl-6">
        <div class="main-card mb-3 card p-4">
            <!--My Form-->
            <form class="medecine_request"  >
{{ csrf_field() }}

<!--test-->

<!--test-->
<div class="error_message text-danger"></div>

<div class="form-group change_area d-none">
<label for="">Change area Around</label>
<select name="search_limit" class="medsearch_limit form-control" onchange="medsearch_limit(this)">
<option value="25">25Km</option>
<option value="50">50Km</option>
<option value="100">100Km</option>
</select>
</div>
<div class="form-group input_form change_area address_show d-none ">
            <label>Your Full Address<span class="required"></span></label>
<input id="autocomplete" placeholder="Enter your Full address"
onFocus="geolocate()" onchange="return change_address()" onblur="return change_address()" autocomplete="off" type="text" class="form-control inputtype location_address phys_address" placeholder="street number and Street Name" name="address">
</div>
<div class="form-group d-none">
<label >Latitude and Longitude</label>
<input type="text" name="lat" id="lat" class="form-control lat" placeholder="Enter your lat">
<input type="text" name="lng" id="lng" class="form-control lng" placeholder="Enter your lng">
</div>

<div class="form-group">
    <label for="">Search Your Medecine <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="search_medecine" autocomplete="off" onkeyup="return search_product(this)" >
<input type="hidden" class="form-control" id="nappi_code" name="product_id">
<div class="search_append">

</div>



</div>
<div class="form-group d-none">
<input type="text" class="form-control mymedecine" name="product_name">
</div>
<div class="med_append list-group ">



</div>


<div class="form-group">
<label for="">Order Options</label>
<select name="user_delivery_choice" class="form-control">
<option value="{{env('ORDER_OPTION1')}}">{{env('ORDER_OPTION1')}}</option>
<option value="{{env('ORDER_OPTION2')}}">{{env('ORDER_OPTION2')}}</option>
</select>
</div>
<div class="form-group">
<label >Contact no</label>
<input type="text" id="phone" name="phone" class="form-control tel" placeholder="Enter your Phone Number" readonly>
</div>
<div class="form-group">
<label >alternative contact no</label>
<input type="text" id="phone2" name="phone2" class="form-control" placeholder="Type another Phone number">
</div>


<div class="append_div d-none"></div>
<div class="form-group">
<label >Description</label>
<textarea name="description" id="description" cols="30" rows="10" class="form-control disable_newline" placeholder="Description"></textarea>
</div>


<div class="form-group">
<button class="btn btn-primary">Submit</button>
</div>
</form>
            <!--My Form-->
        </div>
    </div>

    <!--table-->
    <div class="col-xl-6">
    @include('components.Forms.Forms_Table_history')
  
                            </div>
    <!--table-->
</div>
</div>