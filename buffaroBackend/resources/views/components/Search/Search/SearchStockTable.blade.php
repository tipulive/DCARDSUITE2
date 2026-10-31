$('.MainForm').html(`
    <h5 class="text-center mainTitle">
Stocks
<div class="form-group ">
<h6 class="text-center pt-1">Show From</h6>

<select class="form-control-sm catComeFrom" name="cat" onchange="ComeFromProduct()">



</select>

</div>



</h5>


<form class="Form_order">
            <!--My Form-->






<div class="form-group">

    <label for="">Search Your Product<span class="text-danger">*</span></label>
    <div class="input-group mb-3">
  <div class="input-group-prepend">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">By</button>
    <div class="dropdown-menu">
    <a class="dropdown-item" href="#SearchByCode" onclick="return chooseSearch('${choose1}','${ClassfieldName}')">Code</a>
      <a class="dropdown-item" href="#SearchByName" onclick="return chooseSearch('${choose2}','${ClassfieldName}')">name</a>
    </div>
  </div>

  <input type="text" class="form-control searchProductTable" aria-label="Text input with dropdown button" placeholder="Search by Code"  onkeyup="return searchProductTable(this)">
</div>






</div>
<!--search Form -->
</form>

    `);
