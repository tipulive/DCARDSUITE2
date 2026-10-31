<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Code</title>

  <style>

    /* Define print-specific styles */
    @media print {
        .no-print {
            display: none !important; /* Ensure it's not printed */
        }
    }
    @media print {
    body {
      margin: 0;
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
  </style>
</head>
<body>
 <!-- Print button -->
 <button class="print-button no-print" onclick="printGrid()">Print</button>

 <div class="body">
  <!-- Repeat the following block for each grid item -->
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>

  <div class="grid-item divrelative">
    <div class="image-container">

      <img src="image1.png" alt="Image 2">

    </div>
    <div class="image-container">

<img src="image2.png" alt="Image 2">

</div>
    <div class="text-container ">
      <p>Text for Image 1</p>

     <div class="divabsolute">
     <input type="checkbox" id="myCheckbox" name="myCheckbox" value="myValue" class="no-print">
     </div>
    </div>
  </div>
  <!-- Repeat the above block for a total of 16 grid items -->


 </div>

  <script>
    function printGrid() {
      window.print();
    }
  </script>
</body>
</html>
