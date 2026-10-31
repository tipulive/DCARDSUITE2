<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive 16-Row Grid</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 16px;
    }

    td {
      border: 1px solid #ccc;
      padding: 16px;
      text-align: center;
      vertical-align: middle;
    }

    img {
      max-width: 100%;
      height: auto;
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
  </style>
</head>
<body>
  <table>
    <tr>
      <td>
        <img src="images/image1.png" alt="Image 1">
        <p>Text for Image 1</p>
      </td>
      <td>
        <img src="images/image2.png" alt="Image 2">
        <p>Text for Image 2</p>
      </td>
      <td>
        <img src="images/image1.png" alt="Image 3">
        <p>Text for Image 3</p>
      </td>
      <td>
        <img src="images/image2.png" alt="Image 4">
        <p>Text for Image 4</p>
      </td>
    </tr>
    <tr>
      <td>
        <img src="images/image1.png" alt="Image 5">
        <p>Text for Image 5</p>
      </td>
      <td>
        <img src="images/image2.png" alt="Image 6">
        <p>Text for Image 6</p>
      </td>
      <td>
        <img src="images/image1.png" alt="Image 7">
        <p>Text for Image 7</p>
      </td>
      <td>
        <img src="images/image2.png" alt="Image 8">
        <p>Text for Image 8</p>
      </td>
    </tr>
    <!-- Repeat the above pattern for each row -->
  </table>


</body>
</html>
