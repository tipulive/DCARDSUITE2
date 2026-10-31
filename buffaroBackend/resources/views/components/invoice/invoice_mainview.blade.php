<html style="width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"><head>
  
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>Invoice Data</title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <link rel="shortcut icon" type="image/png" href="https://stripo.email/assets/img/favicon.png"> 
  <style type="text/css">
  @media print {
body {-webkit-print-color-adjust: exact;}
}
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
	padding:0;
}
.ExternalClass {
	width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height:100%;
}
.es-button {
	mso-style-priority:100!important;
	text-decoration:none!important;
}
a[x-apple-data-detectors] {
	color:inherit!important;
	text-decoration:none!important;
	font-size:inherit!important;
	font-family:inherit!important;
	font-weight:inherit!important;
	line-height:inherit!important;
}
.es-desk-hidden {
	display:none;
	float:left;
	overflow:hidden;
	width:0;
	max-height:0;
	line-height:0;
	mso-hide:all;
}

 /*loader*/
 #cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

#cover-spin::after {
    content:'';
    display:block;
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
/*loader*/
</style> 
 </head> 
 <h1> 
 <button onclick="printDiv('printableArea')">Print this page</button>
<h1></h1>

 </h1>
 <body  style="width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
  
 <div id="cover-spin"></div>
 @if(Auth::user()->platform=='Admin'||Auth::user()->platform=='SuperAdmin')
    @include('Components.invoice.invoice_admin')
 @else
 @include('Components.invoice.invoice_client')
 @endif




  <script src="dashboard/vendor/jquery-3.2.1.min.js" ></script>
  <script>

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
 function changeimage(){
     $('#file').click();
 }
   function encodeImgtoBase64(element) {
 
      var file = element.files[0];
 
      var reader = new FileReader();
 
      reader.onloadend = function() {
 
        /*$("#convertImg").attr("href",reader.result);
 
        $("#convertImg").text(reader.result);*/
 
        $("#base64Img").attr("src", reader.result);
        console.log($("#base64Img").attr("src"));
 
      }
 
      reader.readAsDataURL(file);
 
    }
   
    function savechange(){//missing validation to remove php
      $('#cover-spin').show();
      var doc_id=$('#doc_id').val();
      var total_label=$('#total_label').text();
      var note_label=$('#note_label').html();
      var ref_label=$('#ref_label').text();
      var currency_label=$('#currency_label').text();
      var logo_success=$("#base64Img").attr("src");
      var paymentinfos=$('#paymentinfos').html();
      var footer_ads=$('#footers_ads').html();
      var footer_address=$('#footer_address').html();
      var invoice_label=$('#invoice_label').text();

    
      $.ajax({
			//url:"./create_doc",
			url:"./pay_saveinvoice",
			type:"post",
			data:{"_token": "{{ csrf_token() }}",doc_id:doc_id,invoice_label:invoice_label,total_label:total_label,note_label:note_label,
      ref_label:ref_label,currency_label:currency_label,logo_success:logo_success,paymentinfos:paymentinfos,footer_ads:footer_ads,footer_address:footer_address},
			success:function(data){
	//var message=data.message;
  // 
  if(data.created){
                      setTimeout(function(){
                       
          $('#cover-spin').hide();
        }, 10);
        
      
                    }
  // 
			
			}
			
		});
    }

function on_upload(){
  $('.formb_submit').click();
}


  </script>
</body>
</html>