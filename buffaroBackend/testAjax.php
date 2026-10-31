<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AJAX jQuery POST Call</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function AdminEditDeclaration(){
    //$('.cover-spin').show();
    var settings = {
  "url": "https://kashmir.finalpolymathbackend.kashmir-shawl.com/test",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json"
  },
  "data": JSON.stringify({"uid":"UID_ca_1710152607","productCode":"umuceri","productExist":"false"}),
};

$.ajax(settings).done(function (response) {
  console.log(response);
});

return false;
}
</script>
</head>
<body>

<h1>AJAX jQuery POST Call Example</h1>
<form class="formDeclarationEdit" onsubmit="return AdminEditDeclaration()">
<div class="p-2">
<div class="form-group ">
<label>Plaque Number</label>
<input type="hidden" class="form-control" name="uid" value="${uid}" required/>
<input type="text" class="form-control" name="plaque" value="${plaque}" required/>
</div>

<div class="form-group ">
<label>Profit</label>
<input type="text" class="form-control" name="profit" value="${profit}" required/>
</div>

<div class="form-group ">
<label>Transport Fees</label>
<input type="text" class="form-control" name="transpfees" value="${transpfees}" required />
</div>

<div class="form-group ">
<label>Exchange Rate</label>
<input type="text" class="form-control" name="exchangerate" value="${exchangerate}" required/>
</div>



<div class="form-group">

<input type="submit" class="btn btn-danger"  value="submit" />
</div>
</div>
</form>

</body>
</html>
