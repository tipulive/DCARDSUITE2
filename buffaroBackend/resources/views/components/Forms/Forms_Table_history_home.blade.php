<div class="col-xl-6">
 <!--new orders-->
   <!--Recent Orders-->
   <div class="main-card mb-3 card">

                         
           
<div class="card-body card-body-myform"><h5 class="card-title">Orders placed</h5>

<table class=" table table-xs table_green table-bordered ">

<tr>
<!--<th></th>-->
<th >#</th>
<th >No</th>
<th >OrderId</th>

<th >Created At</th>
<th >Action</th>
</tr>
<?php 


$chatrequest=DB::select("select *from chatrequests $createria_request  GROUP by uid order by id  desc limit 30");
//$chatrequest=DB::select("select *from chatrequests $createria_request order by id  desc limit 100");
$i=1;
foreach($chatrequest as $row)
{
?>
<tr class="item-row">
<td  title="#"><?php echo $i; ?></td>
<td  title="No"><?php echo $row->id; ?></td>
<td  title="OrderId"><?php echo $row->uid; ?></td>

<td title="Created At"><?php echo $row->created_at; ?></td>
<td title="Action">
<a href="#" onclick="return table_view_placed_order('<?php echo $row->uid; ?>','<?php echo $row->userid; ?>','<?php echo $row->user_delivery_choice; ?>','<?php echo $row->name; ?>','<?php echo base64_encode($row->user_message); ?>','<?php echo $row->phone; ?>','<?php echo $row->phone2; ?>','<?php echo $row->product_id; ?>','<?php echo base64_encode($row->product_name); ?>','<?php echo $row->client_notification; ?>','<?php echo $row->uid_provider; ?>','<?php echo $row->delivering_time; ?>','<?php echo base64_encode($row->uid_message); ?>','<?php echo $row->uid_notification; ?>','<?php echo $row->pharmacie_name; ?>','<?php echo $row->pharmacie_location; ?>','<?php echo base64_encode($row->img_url); ?>','<?php echo $row->pricing; ?>','<?php echo $row->pricing_delivery; ?>','<?php echo $row->total_pricing; ?>','<?php echo $row->pay_mode; ?>','<?php echo $row->address; ?>','<?php echo base64_encode($row->description); ?>','<?php echo $row->status; ?>','<?php echo $row->created_at; ?>')"  data-toggle="tooltip" title="View This Order "><i class="fas fa-eye text-white"></i></a>  |
<a href="#" onclick="return Reject_this_order('<?php echo $row->uid; ?>','<?php echo $row->userid; ?>','<?php echo $row->uid_provider; ?>','<?php echo $row->pricing; ?>','<?php echo $row->pricing_delivery; ?>','<?php echo $row->pay_mode; ?>','<?php echo base64_encode($row->uid_message); ?>','<?php echo base64_encode($row->img_url); ?>','<?php echo base64_encode($row->description); ?>','<?php echo $row->product_id; ?>','<?php echo $row->phone; ?>','<?php echo $row->phone2; ?>','<?php echo base64_encode($row->product_name); ?>','<?php echo base64_encode($row->delivering_time); ?>','<?php echo $row->total_pricing; ?>','<?php echo base64_encode($row->address); ?>','<?php echo base64_encode($row->user_delivery_choice); ?>')"  data-toggle="tooltip" title="Cancel This Order"><i class="fas fa-trash text-danger"></i></a>

</td>
</tr>

<?php
$i++;
}

?>



</table>





</div>
</div>
 <!--new orders-->


</div>
<div class="col-xl-6">
         <!--Rejected orders-->
         <div class="main-card mb-3 card">
                                    <div class="card-body card-body-myform "><h5 class="card-title">Rejected Orders</h5>
                                        <table class="table table-xs table_blue table_rejected">
           
                                        <tr>
      <!--<th></th>-->
      <th >#</th>
      <th >OrderId</th>
      <th >Total</th>
      <th >Created At</th>
    </tr>
    <?php 
  
  
    $chatrequest=DB::select("select uid,total_pricing,created_at from reject_requests $createria_request GROUP by uid order by id desc limit 5");
    $i=1;
foreach($chatrequest as $row)
{
    ?>
    <tr class="item-row">
    <td  title="#"><?php echo $i; ?></td>
    <td  title="OrderId"><?php echo $row->uid; ?></td>
    <td  title="Total">R <?php echo $row->total_pricing=='none'?0:$row->total_pricing; ?></td>
    <td title="Created At"><?php echo $row->created_at; ?></td>
    </tr>

<?php
$i++;
}

?>
           
           
                                    </table>
                                    </div>
                                </div>
                                <!--Rejected orders-->
</div>
