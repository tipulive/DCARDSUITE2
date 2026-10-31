!<!DOCTYPE html>
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <p class="text-danger">Test data</p>
        <button type="button" class="btn btn-lg btn-danger " onclick="return cbmCalculator()">CBM check</button>

        <button type="button" class="btn btn-lg btn-primary " onclick="return timeCounting()">cbm Calculator</button>
      <div class="cbm p-2"></div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title cbmTitle" id="exampleModalLabel ">test</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body cbmDetailsView p-2">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script >
            var arrCbm=[];
            //var arrData=[{"id":1,"productCode":"nyota","interest":30,"Totinterest":0,"qty":1,"percbm":"0.10","cbm":0,"Toteachcbm":0},{"id":2,"productCode":"meka","interest":10,"Totinterest":0,"qty":1,"percbm":"0.20","cbm":0,"Toteachcbm":0},{"id":3,"productCode":"bumba","interest":40,"Totinterest":0,"qty":1,"percbm":"0.60","cbm":0,"Toteachcbm":0},{"id":4,"productCode":"victoria","interest":40,"Totinterest":0,"qty":1,"percbm":"0.90","cbm":0,"Toteachcbm":0}];

            var dataCbm;
            var onselect=[];

            $(function(){
                testGetData();
            })


function testGetData()
{

   $.ajax({

url:`./api/cbmCalculator`,
type:'get',

data:{
    purpose:"test",
},
success:function(data){
if(data.status){//return data as true

    $('.autoCompleteTopItem').show();
    //arrData=data.result;

    dataCbm=data.result;


    //console.log(JSON.stringify(dataCbm));

cbmCalculator();








}
else{

}



},
error:function(data){
//alert("errors occured please retry this process again or contact system Admin");
//window.location.href = "./login";
}
});
    return false;
}

function cbmCalculator(){

    //console.log(dataCbm);

    var bm = JSON.parse(JSON.stringify(dataCbm));
    var randomSubset = getRandomSubset(bm);
   // var randomSubset = getRandomSubset([...dataCbm]); // Use spread operator to clone array
    //arrData.push(randomSubset);
   // console.log(randomSubset===0?"hello":randomSubset);
if(randomSubset===0){

}
else{
    /*var DataT={
        "uid":randomSubset.uid,
        "totQty":randomSubset.totQty,
        "data":randomSubset
    };
    arrCbm.push(DataT);*/
    arrCbm.sort((a, b) => b.Allinterest - a.Allinterest);
    var getData=`<ul class="list-group list-group-flush">`;


for(var i=0;i<arrCbm.length;i++){
//console.log(arrCbm[i].data.uid);
var myData=arrCbm[i];
    getData+=`
    <li class="list-group-item bg-danger text-white d-flex justify-content-between align-items-center ${arrCbm[i].uid}">${arrCbm[i].uid}
    <button class="btn btn-light btn-sm ml-auto"
    data-toggle="modal" data-target="#exampleModal"
    onclick="return cbmDetailsView('${btoa(JSON.stringify(myData))}')">Action</button>

    </li>
  <li class="list-group-item active">Interest:${arrCbm[i].Allinterest}</li>
  <li class="list-group-item">Total Qty:${arrCbm[i].totQty}</li>
  <li class="list-group-item">Number of Item:${arrCbm[i].dissplaySize}</li>
  <li class="list-group-item">Total CBM:${arrCbm[i].MyCbmTot}</li>

    `;
}
getData+=`</ul>`;
$('.cbm').html(getData);
    console.log(arrCbm);

}














}

function cbmDetailsView(dataPass){
    dataCrypt=atob(dataPass);
    dataCrypt=JSON.parse(dataCrypt);
    data=dataCrypt.data;
    console.log(dataCrypt.uid);

    $(`.${onselect[0]}`).removeClass('bg-warning');
    $(`.${onselect[0]}`).addClass('bg-danger');
    onselect[0]=dataCrypt.uid;
    $(`.${dataCrypt.uid}`).removeClass('bg-danger');
    $(`.${dataCrypt.uid}`).addClass('bg-warning');
    /*$(``).removeClass('info');
    onselect[0]=dataCrypt.uid;
    $(selector).addClass(className);*/



    $('.cbmTitle').html(`<p>UID:${dataCrypt.uid}</p>`);
    var getData=`<ul class="list-group list-group-flush">`;


for(var i=0;i<data.length;i++){
    getData+=`
    <li class="list-group-item bg-success text-white d-flex justify-content-between align-items-center">#${i+1}

    </li>
  <li class="list-group-item active">Product Name:${data[i].productCode}</li>
  <li class="list-group-item">Total Qty:${data[i].qty}</li>
  <li class="list-group-item">Total Interest:${data[i].Totinterest}</li>
  <li class="list-group-item">interest per 1 unit:${data[i].interest}</li>
  <li class="list-group-item">cbm per 1 unit:${data[i].percbm}</li>
  <li class="list-group-item">Total cbm:${data[i].cbm}</li>


    `;
}
getData+=`</ul>`;
$('.cbmDetailsView').html(getData);
return false;



}

function timeCounting(){
    // Ensure a fresh interval without overlapping data issues
    let intervalId = setInterval(function () {
        cbmCalculator();
    }, 1000);

    // Optional: Clear interval after some time or condition
    setTimeout(function () {
        clearInterval(intervalId); // Stop after some time
        console.log('Interval cleared');
    }, 10000);

}



function getRandomSubset(arr) {
    // Create a copy of the array to avoid modifying the original array

    let copy = arr.slice();
    let subset = [];
    var totQty=0;
    var Allinterest=0;
    var MyCbmTot=0;
    //console.log(arrData);
    // Randomly decide the size of the subset
    let subsetSize = Math.floor(Math.random() * (arr.length + 1));
    //console.log(subsetSize);
    /*let cbmN=72/subsetSize;
    let arrs=[10,12,20,30];*/
    let arrs = generateRandomArray(subsetSize);

    // Randomly select elements for the subset
    for (let i = 0; i < subsetSize; i++) {
        if (subsetSize != 0) {
            let randomIndex = Math.floor(Math.random() * copy.length);
            let selectedElement = copy[randomIndex];

            // Change the cbm value of the selected element
            //selectedElement.cbm = selectedElement.cbm +cbmN; // For example,
            //selectedElement.cbm =CbmN;
            selectedElement.cbm=arrs[i];
            selectedElement.qty=Math.round(arrs[i]/selectedElement.percbm);
             selectedElement.Totinterest=selectedElement.interest*selectedElement.qty;
             selectedElement.Toteachcbm=selectedElement.qty*selectedElement.percbm;
             totQty+=selectedElement.qty;

             Allinterest+=selectedElement.Totinterest;
             MyCbmTot+=selectedElement.Toteachcbm;



            //double the cbm value

            subset.push(selectedElement);
            copy.splice(randomIndex, 1); // Remove the selected element from the copy
        }
    }
    subset["uid"]=Date.now();
    subset["totQty"]=totQty;
    subset["Allinterest"]=Allinterest;
    subset["MyCbmTot"]=MyCbmTot;
    subset["dissplaySize"]=subsetSize;

    if(subset["Allinterest"]>0)
    {
        var DataT={
        "uid":subset["uid"],
        "totQty":subset["totQty"],
        "Allinterest":subset["Allinterest"],
        "dissplaySize":subset["dissplaySize"],
        "MyCbmTot":subset["MyCbmTot"],

        "data":subset
    };
        const exists = arrCbm.some(item => item.uid === DataT.uid);

    if (!exists) {
        arrCbm.push(DataT);
       // console.log('Item added:', newItem);
    } else {
        console.log('UID already exists:', newItem.uid);
    }

    //arrCbm.push(DataT);
    }


   // console.log(`test fn ${subset}`);

    if (subsetSize != 0) {
        return subset;
    } else {
        return 0;
    }
}
function generateRandomArray(size) {
    let total = 72;
    let array = [];

    // Generate random numbers for all elements except the last
    for (let i = 0; i < size - 1; i++) {
        let randomNum = Math.floor(Math.random() * (total - (size - i - 1))) + 1;
        array.push(randomNum);
        total -= randomNum;
    }

    // Add the remaining total as the last element
    array.push(total);

    return array;
}





        </script>
    </body>
</html>
