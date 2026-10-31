<!-- modal medium -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title mod_docname text-center" id="mediumModalLabel"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
            <form id="book_apointment">
            <div class="form-group classhide" style="display:none">
            <label for="">Choose date to submit Your <span class="mod_docname"></span> Document</label>
            {{ csrf_field() }}
            <input type="hidden" name="table_id" class="table_id">
            <input type="hidden" name="appl_id" class="appl_id">
            <input type="text" id="flatpickr" name="appointment" class="form-control">
            </div>
            <div class="av_comment"></div>
            </form>
						</div>
						<div class="modal-footer classhide" style="display:none">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" onclick="return book_docs_appointment()">Book Date</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end modal medium -->
             <!-- Verify Modal -->
<div class="modal fade" id="verifymodal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title mod_docname text-center" id="mediumModalLabel"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
            
						<div class="modal-body">
                       
            <form id="verify">
            <input type="hidden" class="actionverify">
            <input type="hidden" name="table_id" class="table_id">
            <input type="hidden" name="appl_id" class="appl_id">
            <div class="form-group">
            {{ csrf_field() }}
            <div class="verify text-center">
            
            </div>
            <div class="form-group">
            <label for="">choose Status</label>
           <select name="status_verified" class="form-control status_verified">
           
           </select>
            </div>
            <div class="form-group">
            <label for="">write some notes</label>
            <textarea name="comment" id="status_comment" cols="30" rows="5" class="form-control status_comment"></textarea>
            </div>
            
            </form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" onclick="return verify_document()">Submit</button>
						</div>
					</div>
				</div>
			</div>
		 <!-- Verify Modal -->
<script>

function show_document(){
    $.ajax({
//url:"./test_getformdata",
url:"./testgetname",//user get data
//type:"get",
type:"get",

success:function(data){
      console.log(data);
    var markup="";
    var invoicedisp="";
    for (var i=0;i<data.length;i++)
{

    markup+=`<li>
                            <a href="#Table_document" onclick="table_display('${data[i].doc_id}','${data[i].doc_name}')">${data[i].doc_name}</a>
                        </li>`;

                        invoicedisp+=`@if(Auth::user()->platform!='Standard')<li>
                            <a href="/invoicepayment?table_id=${data[i].doc_id}">${data[i].doc_name}</a>
                        </li>
                        @endif`;
        

    
    }
    $('.listdoc_display').html(markup);
    $('.listinvoice_display').html(invoicedisp);
  


}
});
}

/*table code and document display*/

//document display/
function table_display(doc_id,docname){
  //
  $('.maindiv').html("");


  $('.formdatas').first().show();
  $('.mainjs').html("");
  $('.docname').text(docname);
  $('.tableid').val(doc_id);

oTable = $('#table_template').DataTable({
            "processing": false,
            "serverSide": true,
                "destroy":true,
                "responsive": true,
                 ajax: {
        url:"{{route('tabledisplay_document') }}",
         type:"post",
          data:{
            "_token":'{{ csrf_token() }}',
            doc_id:doc_id,
              
             
         }
          
     },"columns": [
                {data: 'id', name: 'id'},
             {data: 'appl_id', name: 'appl_id'},
               
                {data: 'name', name: 'name'},
                {data: 'tel', name: 'tel'},
                {data: 'appointment', name: 'appointment'},
                {data: 'status', name: 'status'},
                {data: 'pay_status', name: 'pay_status'},
                {data: 'created_at', name: 'created_at'},
            
            
                  {data: 'action', name: 'action'},
                
                
        
        
     ],
        
        
                    
        });

        new $.fn.dataTable.FixedHeader( oTable );
//
}


/*table code and document display*/
/*track view Documents*/
function trackview(status,comment,pay_status,pay_comment,appl_id,created_at,name,tel,id_no,appointment,pay_name,price){
  $('.classhide').hide();
  var table_id=$('.tableid').val();
$('.table_id').val(table_id);
$('.appl_id').val(appl_id);
var docname=$('.docname').text();
$('.mod_docname').text(docname);
$('#mediumModal').modal('show');
$('.av_comment').html(`
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-docs-tab" data-toggle="tab" href="#nav-docs" role="tab" aria-controls="nav-docs" aria-selected="true">Status</a>

    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Details</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Others</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-docs" role="tabpanel" aria-labelledby="nav-docs-tab">
  
  <div class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1" style="color:white">Document Status:${status}</h5>
      <small>${created_at}</small>
    </div>
    <p "center" style="color:#fff" align="center" ><u>Comment:</u></p>
    <p class="mb-1">${comment}</p>
    
  </a>

  <a href="#" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Payment Status:${pay_status}</h5>
      <small>${created_at}</small>
    </div>
    <p "center"  align="center" ><u>Comment:</u></p>
    <p class="mb-1">${pay_comment}</p>
    
  </a>
 
</div>

  </div>
  
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  
  <ul class="list-group">
 
  <li class="list-group-item active">Name:${name}</li>
  
  <li class="list-group-item">Tel:${tel}</li>
  <li class="list-group-item">ID:${id_no}</li>
  <li class="list-group-item">Created:${created_at}</li>
</ul>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <ul class="list-group">
  <li class="list-group-item active">Applid:${appl_id}</li>
  <li class="list-group-item">Appointment:${appointment}</li>
  
  <li class="list-group-item">payment type:${pay_name}</li>
  <li class="list-group-item">price:${price}</li>
  
</ul>
  </div>


</div>
`);


}
/*track view Documents*/

/*schedule*/
function schedule(pay_status,appl_id){
   if(pay_status=="paid")
   {
     //
     $('#mediumModal').modal('show');
     $('.classhide').show();
   //$('.modal-backdrop').remove();
   //$('.show').removeClass('modal-backdrop');
var table_id=$('.tableid').val();
$('.table_id').val(table_id);
$('.appl_id').val(appl_id);
var docname=$('.docname').text();
$('.mod_docname').text(docname);

//console.log(docname);

   $.ajax({
//url:"./test_getformdata",
url:"./get_documentdate",//user get data
//type:"get",
type:"get",
data:{
  table_id:table_id
},
success:function(data){
  $('.av_comment').text(data[0].av_comment);
   var available_date=data[0].available_date;
  /*var start_time="2020-04-25";
var end_time="2020-04-29";*/

 var start_time=available_date.split('to')[0];
var end_time=available_date.split('to')[1];
//var example = flatpickr('#flatpickr');
flatpickr('#flatpickr',{
    enable: [
        {
            from:start_time,
            to:end_time
        }
    ]
});

}
});

     //
   }
   else{
     alert("sorry you can not be able to set Appointment check your payment Status or contact system Admin");
   }
   
 
}
/*schedule*/

/*book documents appointment */
function book_docs_appointment(){
  $('#cover-spin').show();
  var table_id=$('.tableid').val();
    var table_name=$('.docname').text();
  $.ajax({
//url:"./test_getformdata",
url:"./book_docs_appointment",//user get data
//type:"get",
type:"post",
data:$('#book_apointment').serialize(),
success:function(data){
  
  //
  if(data.created){
    table_display(`${table_id}`,`${table_name}`);
                      setTimeout(function(){
                       
          $('#cover-spin').hide();
        }, 10);
        
      
                    }
  //

}
});
}
/*book documents appointment */
/*verify document and verify paid */
function verify_document(){
  $('#cover-spin').show();
    var table_id=$('.tableid').val();
    var table_name=$('.docname').text();
  var action_verify=$('.actionverify').val();
  $.ajax({
//url:"./test_getformdata",
url:`./${action_verify}`,//user get data
//type:"get",
type:"post",
data:$('#verify').serialize(),
success:function(data){
   //
   if(data.created){
                      setTimeout(function(){
                       
          $('#cover-spin').hide();
        }, 10);
        
      
                    }
  //
    table_display(`${table_id}`,`${table_name}`);
}
});
}
function view_verifydocument(id,comment,name,appl_id){
  //$('#cover-spin').show();
    var table_id=$('.tableid').val();
    var table_name=$('.docname').text();
  $('.table_id').val(table_id);
  $('.admintable_id').val(table_id);
  
  $.ajax({
//url:"./test_getformdata",
url:"./verify_viewdocument",//user get data
//type:"get",
type:"post",
data:{
  '_token':'{{ csrf_token() }}',
  table_id:table_id,id:id},
success:function(data){
  //
/*if(data.created){
                      setTimeout(function(){
                       
          $('#cover-spin').hide();
        }, 10);
        
      
                    }*/
//
    $('#verifymodal').modal('show');

    $('.mod_docname').text(`Verify Documents of ${name}`);
    $('.appl_id').val(appl_id);
  $('.verify').html(data);
  $('#status_comment').text(comment);
  $('.actionverify').val("verify_document");
  $('.status_verified').html(`
  <option selected disabled>select status</option>
  <option>rejected</option>
  <option>verified</option>
  
  `);
 
},
error:function(data){
alert("errors occured please retry this process again or contact system Admin");
window.location.href = "./login";
}
});

}
function view_verifypayment(id,comment,name,file_name,appl_id){
 
  

    var table_id=$('.tableid').val();
  $('.table_id').val(table_id);

  $('.admintable_id').val(table_id);
  $('.appl_id').val(appl_id);
 
  $('#verifymodal').modal('show');
    $('.mod_docname').text(`Verify Payment of ${name}`);
  $('.verify').html(`
  <img src="/upload/${file_name}" alt="" class="responsive">
  `);
  $('#status_comment').text(comment);
  $('.actionverify').val("verify_payment");
  $('.status_verified').html(`
  <option selected disabled>select status</option>
  <option>paid</option>
  <option>unpaid</option>
  `);

}
/*verify document and verify paid */
</script>