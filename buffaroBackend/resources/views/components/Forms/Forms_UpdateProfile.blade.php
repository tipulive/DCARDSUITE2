<div class="visible_div">

<div class="row">
    
    <!--<div class="col-md-4"></div>-->
    <div class="col-md-6">

    <div class="main-card mb-3 card pl-4 pr-4 ">
    <h3 class="card-title pt-4">Profile</h3> 
    <div class="divider mt-0"></div>
<form class="change_profile" autocomplete="off">
{{ csrf_field() }}
@if(Auth::check())
<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >First Name <span class="text-danger">*</span></label>
<input type="text" name="fname" id="fname" class="form-control fname" placeholder="Enter your First Name" required>
</div>
</div>
<div class="col-md-6">

<div class="form-group">
<label >Last Name <span class="text-danger">*</span></label>
<input type="text" name="lname" id="lname" class="form-control lname" placeholder="Enter your Last Name" required>
</div>

</div>

</div>

<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Email <span class="text-danger">*</span></label>
<input type="email" name="email" id="email" class="form-control email" placeholder="Enter Email " required>
</div>
</div>
<div class="col-md-6">

<div class="form-group">
<label >Password <span class="text-danger">*</span></label>
<input type="password" name="password" id="password" class="form-control password" placeholder="Enter Password" >
</div>
</div>
</div>


<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Contact No <span class="text-danger">*</span></label>
<input type="text" name="tel" id="tel" class="form-control tel" placeholder="Enter your Tel" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label >Date of birth <span class="text-danger">*</span></label>
<input type="text" name="dob" id="dob" class="form-control dob" placeholder="DOB">
</div>
</div>
</div>





<div class="form-group input_form">
            <label>Your Full Address <span class="text-danger">*</span><span class="required"></span></label>
<input id="autocomplete" placeholder="Enter your Full address"
onFocus="geolocate()" type="text" class="form-control inputtype location_address phys_address" autocomplete="off"  name="phys_address" placeholder="street number and Street Name">
</div>
<div class="form-group d-none">
<label >Latitude and Longitude</label>
<input type="text" name="lat" id="lat" class="form-control lat" placeholder="Enter your lat">
<input type="text" name="lng" id="lng" class="form-control lng" placeholder="Enter your lng">
</div>



<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Gender <span class="text-danger">*</span>: <span ><strong class="text-danger 	mgender_pro"></strong></span></label>
<select name="gender" id="gender" class="form-control" onchange="return choose_gender(this)">
<option value="male">Male</option>
<option value="female">Female</option>
</select>

</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label >ID Number <span class="text-danger">*</span></label>
<input type="text" name="id_number" id="id_number" class="form-control id_number" placeholder="Enter your Id Nuber" required>
</div>
</div>

</div>

<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Title <span class="text-danger">*</span>: <span ><strong class="text-danger 	mtitle_pro"></strong></span></label>
<select name="title" id="mytitle" class="form-control "  onchange="return choose_title(this)">
<option value="Mr">Mr</option>
<option value="Ms">Ms</option>

</select>
</div>
<div class="form-group divtitle_others d-none">
<input type="text" class="form-control title_others" Placeholder="Enter Other Title">
</div>
</div>
<div class="col-md-6">

<div class="form-group">
<label for="">Marital Status <span class="text-danger">*</span>:<span ><strong class="text-danger mart_status"></strong></span></label>
<select name="marital_status" id="marital_status" class="form-control" onchange="return choose_marital_status(this)">
<option value="single">single</option>
<option value="Married">Married</option>
<option value="Divorce">Divorce</option>

</select>
</div>

<div class="form-group divmarital_others d-none">
<input type="text" class="form-control marital_others" Placeholder="Enter Other Marital Status">
</div>

</div>

</div>






@elseif(Auth::guard('Admin')->check())
<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Pharmacy name <span class="text-danger">*</span></label>
<input type="hidden" class="updated_at" name="updated_at">
<input type="text" name="name" id="name" class="form-control name" placeholder="Enter your Pharmacy name" required>
</div>
</div>
<div class="col-md-6">

<div class="form-group">
<label >pharmacy contact no <span class="text-danger">*</span></label>
<input type="text" name="tel" id="tel"  class="form-control fname" placeholder="Enter your pharmacy contact no" required>
</div>

</div>

</div>

<div class="form-group">
<label >Physical address <span class="text-danger">*</span></label>
<input id="autocomplete" placeholder="Enter your Physical address"
onFocus="geolocate()" type="text" class="form-control inputtype location_address phys_address" autocomplete="off" name="phys_address" placeholder="street number and Street Name" required>
</div>
<div class="form-group d-none">
<label >Latitude and Longitude <span class="text-danger">*</span></label>
<input type="text" name="lat" id="lat" class="form-control lat" placeholder="Enter your lat">
<input type="text" name="lng" id="lng" class="form-control lng" placeholder="Enter your lng">
</div>
<div class="form-group">
<label >Postal address</label>
<input type="text" name="postal_address" id="postal_address" class="form-control postal_address" placeholder="Enter your Postal address" required>
</div>

<div class="form-row">
<div class="col-md-6">

<div class="form-group">
<label >Email <span class="text-danger">*</span></label>
<input type="email" name="email" id="email" class="form-control email" placeholder="Enter Email" required>
</div>

</div>
<div class="col-md-6">
<div class="form-group">
<label >Password <span class="text-danger">*</span></label>
<input type="password" name="password" id="password" class="form-control password" placeholder="Enter Email">
</div>
</div>

</div>


<div class="form-row">
<div class="col-md-6">

<div class="form-group">
<label >Pharmacy Y-number <span class="text-danger">*</span></label>
<input type="text" name="y_number" id="y_number" class="form-control y_number" placeholder="Enter your Pharmacy Y-number" required>
</div>
</div>
<div class="col-md-6">

<div class="form-group">
<label >Pharmacist Name <span class="text-danger">*</span></label>
<input type="text" name="fname" id="fname" class="form-control fname" placeholder="Enter your Pharmacist Name" required>
</div>
</div>

</div>

<div class="form-row">
<div class="col-md-6">
<div class="form-group">
<label >Pharmacist Surname <span class="text-danger">*</span></label>
<input type="text" name="lname" id="lname" class="form-control lname" placeholder="Enter your Pharmacist Surname" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label >Pharmacist alternative no <span class="text-danger">*</span></label>
<input type="text" name="alternative_no" id="alternative_no" class="form-control alternative_no" placeholder="Enter your Pharmacist alternative no" required>
</div>
</div>

</div>


<div class="form-group">
<label >Pharmacist P-number <span class="text-danger">*</span></label>
<input type="text" name="p_number" id="p_number" class="form-control p_number" placeholder="Enter your Pharmacist P-number" required>
</div>




@endif





<div class="form-group">
<button class="btn btn-primary">Update Profile</button>
</div>

</form>








</div>

    </div>
    <div class="col-md-6">
    <!--Audio Settings-->
    <div class="main-card mb-3 card">
  
 
                                    <div class="card-body"><h4 class="card-title">Audio Notification Settings</h4>
                                    <div class="divider"></div>
                                    <h5 class="card-title">Your Volume</h5>
                                        
                                       
  <div class="form-group">
    
    <input type="range" class="custom-range" id="myaudio_volume" min="0" max="100" value="0" oninput="return audio_adjust_volume(this)">
  </div>

 

                                        <div class="form-group">
                                            <button class="btn myaudio_btn" onclick="return muted_myaudio()"><i class="fas fa-volume-mute"></i></button>
                                        </div>
                                        <h5 class="card-title">Upload your file</h5>

                                        <div class="form-group">
                                            <input type="file" onchange="return get_audiodata(this)" accept=".mp3,.ogg">
                                        </div>
                                        <div class="preview_audio"></div>
                                        <div class="divider"></div>
                                        <button class="btn btn-danger" onclick="return preview_audio()">Preview</button>
                                        <button class="btn btn-danger" onclick="return save_audiofile()">Save Settings</button>
   
                                     
                                    </div>
                                </div>
    <!--Audio Settings-->

    @if(Auth::guard('Admin')->check())
    @if((Auth::guard('Admin')->user()->platform==env('Standard')))
    <!--Rating Display-->
    <div class="main-card mb-3 card Standard d-none">
  
 
                                    <div class="card-body"><h4 class="card-title">Rating <span class="text-danger">{{round((Auth::guard('Admin')->user()->rating*5)/(Auth::guard('Admin')->user()->total_rating=='0'?5:Auth::guard('Admin')->user()->total_rating))." /"."5"}}</span>
                                    
<div class="myrating-wrapper ">

<span class="fa fa-star ratingclass  myrating_1 rating_back">
</span><span class="fa fa-star ratingclass  myrating_1 rating_back">
</span><span class="fa fa-star ratingclass  myrating_1 rating_back"></span>
<span class="fa fa-star ratingclass  myrating_1 rating_back"></span>
<span class="fa fa-star ratingclass  myrating_1 rating_back"></span> 
</div>
                                    
                                    </h4>
                                    <div class="divider"></div>
                                    
                          <div class="row">
                          <div class="col-md-6 pb-2">
                          <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center active_med">
    Complaint Rating
    
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Number of Users who rate
    <span class="badge badge-primary badge-pill">{{Auth::guard('Admin')->user()->complain_rating}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Value
    <span class="badge badge-primary badge-pill">{{Auth::guard('Admin')->user()->complain_rating*env('COMPLAIN_RATING')."/".(Auth::guard('Admin')->user()->complain_rating*100)}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Total
    <span class="badge badge-primary badge-pill">{{(Auth::guard('Admin')->user()->complain_rating*100)}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Average
    <span class="badge badge-primary badge-pill">{{((Auth::guard('Admin')->user()->complain_rating*env('COMPLAIN_RATING'))*5)/(Auth::guard('Admin')->user()->complain_rating=='0'?100:Auth::guard('Admin')->user()->complain_rating*100)}}</span>
  </li>
</ul>
                          </div>
                          <div class="col-md-6">
                          
                          <ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center active_med">
    Receiver Rating
    
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Number of Users who rate
    <span class="badge badge-primary badge-pill">{{Auth::guard('Admin')->user()->received_rating}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Value
    <span class="badge badge-primary badge-pill">{{Auth::guard('Admin')->user()->rating-(Auth::guard('Admin')->user()->complain_rating*env('COMPLAIN_RATING'))."/".(Auth::guard('Admin')->user()->total_rating-(Auth::guard('Admin')->user()->complain_rating*100))}}</span>
  </li>

  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Total
    <span class="badge badge-primary badge-pill">{{(Auth::guard('Admin')->user()->total_rating-(Auth::guard('Admin')->user()->complain_rating*100))}}</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Rating Average
    <span class="badge badge-primary badge-pill">{{number_format( sprintf( '%.2f', ((Auth::guard('Admin')->user()->rating-(Auth::guard('Admin')->user()->complain_rating*env('COMPLAIN_RATING')))*5)/((Auth::guard('Admin')->user()->total_rating=='0'?5:Auth::guard('Admin')->user()->total_rating)-(Auth::guard('Admin')->user()->complain_rating*100))), 2, '.', '' )}}</span>
  </li>
</ul>

                          </div>
                          </div>              
                                       
   

 

                                      
                                     
                                    </div>
                                </div>
    <!--Rating Display-->
    @endif
    @endif
    </div>
</div>
</div>
