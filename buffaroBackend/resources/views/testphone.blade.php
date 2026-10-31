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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <input type="text" name="phone" id="phone" placeholder="Enter phone number"/>

        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#phone");
  //var iti = intlTelInput(input);

  var iti= window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",

    initialCountry:"CD",
    separateDialCode:true,

  });
  input.addEventListener("countrychange", function() {
  // do something with iti.getSelectedCountryData()
  iti.setNumber("+44 7733 123 456");//this is to add number

  console.log(iti.getNumber());//this is to get number
  console.log(iti.isValidNumber()); //this is to check if number is valid
});
input.addEventListener("keyup", function() {
  // do something with iti.getSelectedCountryData()
  console.log(iti.getNumber());
  console.log(iti.getSelectedCountryData());
  console.log(iti.getSelectedCountryData()["name"]);
  console.log(iti.getSelectedCountryData()["dialCode"]);
  console.log(iti.getSelectedCountryData()["iso2"]);//initial
  console.log(iti.isValidNumber());
  //console.log(iti.getNumberType());
  //.iti { width: 100%; };
});
</script>
    </body>
</html>
