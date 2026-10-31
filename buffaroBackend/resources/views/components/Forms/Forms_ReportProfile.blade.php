<form  method="POST" action="{{ route('report_profile') }}">
{{ csrf_field() }}


<div class="form-group">
<label >Name:<span id="report_name"></span></label>
<input type="hidden" id="reported_uid" name="reported_uid" class="form-control" placeholder="Enter your Last Name">
</div>
<div class="form-group">
<label >Description</label>
<textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Description"></textarea>
</div>





<div class="form-group">
<button class="btn btn-primary">Submit</button>
</div>
</form>