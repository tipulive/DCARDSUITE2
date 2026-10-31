<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
  <style>
  /* CSS for styling the credit card */
.credit-card {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  padding: 20px;
  width: 300px;
}

.card-logo img {
  height: 30px;
  width: auto;
}

.card-number {
  font-size: 18px;
  font-weight: bold;
  margin-top: 10px;
}

.card-holder {
  font-size: 14px;
  margin-top: 10px;
}

.card-expiry {
  font-size: 14px;
  margin-top: 10px;
}

  </style>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<!-- HTML for the credit card -->
<div class="credit-card">
  <div class="card-logo">
    <img src="https://www.example.com/logo.png" alt="Card logo">
  </div>
  <div class="card-number">
    **** **** **** 1234
  </div>
  <div class="card-holder">
    John Doe
  </div>
  <div class="card-expiry">
    01/23
  </div>
</div>
<div id="screen-to-record"></div>
<button onclick="myFunction()">Click me</button>

<!-- Add the "screen-to-record" element to the page -->
<div id="screen-to-record"></div>

<script>
  // Start by getting a reference to the screen that you want to record
  const screen = document.getElementById('screen-to-record');

  // Set up the MediaRecorder to record the screen
  const mediaRecorder = new MediaRecorder(screen.captureStream());

  // Start recording
  mediaRecorder.start();

  // Stop recording after 10 seconds
  setTimeout(() => {
    mediaRecorder.stop();
  }, 10000);

  // Handle the recorded data
  mediaRecorder.ondataavailable = (event) => {
    // Create a download link for the recorded data
    const downloadLink = document.createElement('a');
    downloadLink.download = 'recording.webm';
    downloadLink.href = URL.createObjectURL(new Blob([event.data], { type: 'video/webm' }));

    // Append the download link to the page
    document.body.appendChild(downloadLink);

    // Click the download link to start the download
    downloadLink.click();
  };
</script>

    </body>
</html>
