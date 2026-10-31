<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Code</title>

  <style>

    /* Define print-specific styles */
    p{
    font-size: 10px;

    }
    @media print {
        .no-print {
            display: none !important; /* Ensure it's not printed */
        }
    }
    @media print {
    body {
      margin: 0;
    }
    p{
        font-size: 4px;
        white-space: nowrap;      /* Prevent text from wrapping */
    overflow: hidden;         /* Hide overflow content */
    text-overflow: ellipsis;  /* Show ellipsis (...) for overflow text */
    max-width: 200px;
    }
  }
  @media print {
    @page {
      /*size: portrait;*/
      margin:0;
      size: A4; /* Specify the paper size */
    n-up: 2;

    }
  }

  /*loader*/
 .cover-spin {
  position:fixed;
  width:100%;
  left:0;right:0;top:0;bottom:0;
  background-color: rgba(255,255,255,0.7);
  z-index:120000;

  }

  @-webkit-keyframes spin {
  from {-webkit-transform:rotate(0deg);}
  to {-webkit-transform:rotate(360deg);}
  }

  @keyframes spin {
  from {transform:rotate(0deg);}
  to {transform:rotate(360deg);}
  }
  .two_columns_75_25>.column1{
width: 100% !important;
  }
  .cover-spin::after {
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

    .body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      display: grid;
      grid-template-columns: repeat(8, 1fr); /* 4 columns in each row */
      /* grid-template-rows: repeat(16, 1fr); */ /* Remove this line */
      gap: 8px; /* Adjust this value if needed */
      justify-content: center;
      padding: 8px;
    }

    .grid-item {
      position: relative;
      width: 100%;


      /* padding-bottom: 100%; */ /* Maintain a square aspect ratio for the container */
      overflow: hidden;
      border: 1px solid #ccc;
      display: flex;
      flex-direction: column;
      align-items: center;
      page-break-inside: avoid; /* Prevent grid items from being split across pages */
    }

    .grid-item img {
      width: 100%;
      height: 50%; /* Adjust this value if needed */
      object-fit: cover;
    }

    .image-container {
      display: flex;
      width: 100%;
      height: 50%;
    }

    .image-container img {
      width: 100%;
      height: 100%;
      object-fit:cover;
    }

    .text-container {
      text-align: center;
    }

    .print-button {
      margin-top: 16px;
      padding: 8px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .divrelative{
        position: relative;
    }
    .divabsolute{
        position: absolute;
        bottom:0;
        left:0;
    }
    .printPart{
        display:flex;
        justify-content: center; /* Center horizontally */
    align-items: center;
    }
    .printPart span{
        color:red
    }

  </style>
</head>
<body>
  <!--form-->
  <h2>Upload an Image</h2>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form class="formupload" method="post" enctype="multipart/form-data">
    @csrf

    <input type="file" name="image" accept="image/*">
    <input type="text" name="productCode" value="nyota">
    <input type="text" name="fileNam" placeholder="">
    <input type="text" name="NumbVer" placeholder="number version caption">
    <input type="text" name="versionN" placeholder="version">
    <select option="" name="actionStatus">
        <option value="upload">upload</option>
        <option value="setDefault">setDefault</option>
        <option value="EditUpload">EditUpload</option>
    </select>
    @error('image')
        <div>{{ $message }}</div>
    @enderror
    <button type="submit">Upload</button>
</form>
  <!--form-->
 <!-- Print button -->
<div class="printPart no-print"></div>

 <button class="print-button hideBtn no-print" onclick="createQrProduct()">Sync Qr</button>
 <div class="cover-spin  no-print"></div>
 <div class="body">
  <!-- Repeat the following block for each grid item -->






  <!-- Repeat the above block for a total of 16 grid items -->


 </div>
 <!-- LazyLoad library (CDN) -->


 <script src="dashboard/vendor/jquery-3.2.1.min.js"></script>

 <script>
    // Listen for the form submission event
    $('.formupload').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        var Usertoken=localStorage.getItem("Usertoken");
        // Create a new FormData object from the form data
        var formData = new FormData(this);

        // Send the form data to the server using an AJAX request
        $.ajax({
           // url: '/api/upload', // Replace with the URL for your server-side script
            url: '/api/upload', // Replace with the URL for your server-side script
            method: 'POST',
            beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},
            data: formData,
            processData: false, // Prevent jQuery from processing the form data
            contentType: false, // Set the content type to false to send the form data as-is
            success: function(response) {
                // Handle the successful response from the server
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle the error response from the server
                console.error(error);
            }
        });
    });
</script>
  <script>

function uploadPicture(){//Company
    //$('.cover-spin').show();

       //
       var Usertoken=localStorage.getItem("Usertoken");

   $.ajax({

url:`./api/upload`,
type:'post',
/*beforeSend: function (xhr) {
xhr.setRequestHeader('Authorization', `Bearer ${Usertoken}`);
},*/
    dataType: "json",
data:$('.formupload').serialize(),
success:function(data){
if(data.status){//return data as true
    console.log(data);


}
else{


}



},
error:function(data){
    console.log(data);
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;

}

$(function(){
    PrintQrProduct();
    });

    function PrintQrProduct(){
        $('.printPart').html(`<span>Please Wait images are loading ...</span>`);
        var Usertoken = localStorage.getItem("Usertoken");

$.ajax({
    url: './api/PrintQrProduct',
    type: 'get',
    headers: {
        "Content-Type": "application/json;charset=UTF-8",
        "Authorization": `Bearer ${Usertoken}`
    },
    success: function(data) {
        if (data.status) {
            $('.cover-spin').hide();
            var resultData = data.result;
            var getData = '';

            for (var i = 0; i < resultData.length; i++) {
                getData += `
                    <div class="grid-item divrelative">
                        <div class="image-container">
                            <img  src="images/ProductsQr/${resultData[i].productCode}.png" alt="${resultData[i].productCode}">
                        </div>
                        <div class="image-container">
                            <img src="images/image2.jpg" alt="Image 2" >
                        </div>
                        <div class="text-container">
                            <p>${resultData[i].productCode}</p>
                            <p>${resultData[i].ProductName}</p>
                            <div class="divabsolute">
                                <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
                            </div>
                        </div>
                    </div>
                `;
            }

            // Inject HTML content into .body element
            $('.body').html(getData);

            // Check when all images have loaded
            var images = $('.body').find('img');
            var totalImages = images.length;
            var loadedImages = 0;

            images.on('load', function() {
                loadedImages++;
                if (loadedImages === totalImages) {
                    // All images have finished loading
                    console.log('All images have loaded.');
                    // Perform additional actions here
                    // For example, show a button to print the page
                    $('.printPart').html(` <button class="print-button no-print" onclick="printGrid()">Print All</button>`);
                }
            });

        } else {
            // Handle error or display message for unsuccessful response
            console.log('Error: Something went wrong.');
        }
    },
    error: function(data) {
        // Handle AJAX error
        console.log('Error: AJAX request failed.');
    }
});


}



    function createQrProduct(){
    var Usertoken=localStorage.getItem("Usertoken");
$('.cover-spin').show();
$.ajax({

url:`./api/createQrProduct`,

type:'get',
headers: {
    "Content-Type": "application/json;charset=UTF-8",
    "Authorization": `Bearer ${Usertoken}`
},

success:function(data){


if(data.status){//return data as true

    $('.cover-spin').hide();
    PrintQrProduct();



}
else{

//alert("something is Wong");
}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
return false;

}
    function printGrid() {
      window.print();
    }


  </script>
</body>
</html>
