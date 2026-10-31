<div class="visible_div ">

<?php
$display_none="d-none";
if(Auth::guard('Admin')->check())
{
if(Auth::guard('Admin')->user()->platform==env('Standard'))
{
 $userid=Auth::guard('Admin')->user()->userid;
 $createria_request="where uid_provider='$userid'";
 $createria_neworder="where owner_uid='$userid'";

 $count_completeorders=DB::select("select count(id) as counter from completeorders where owner_uid='$userid'");
foreach($count_completeorders as $row)
{
    $count_complete_orders=$row->counter;
}
$count_orders=DB::select("select count(id) as counter from orders where owner_uid='$userid'");
foreach($count_orders as $rows)
{
    $count_pending_orders=$rows->counter;
}

$total_orders=$count_complete_orders+$count_pending_orders;



 
}
else if(Auth::guard('Admin')->user()->platform==env('isInactive'))
{
 $userid=Auth::guard('Admin')->user()->userid;
 $createria_request="where uid_provider='$userid'";
 $createria_neworder="where owner_uid='$userid'";

 $count_completeorders=DB::select("select count(id) as counter from completeorders where owner_uid='$userid'");
foreach($count_completeorders as $row)
{
    $count_complete_orders=$row->counter;
}
$count_orders=DB::select("select count(id) as counter from orders where owner_uid='$userid'");
foreach($count_orders as $rows)
{
    $count_pending_orders=$rows->counter;
}

$total_orders=$count_complete_orders+$count_pending_orders;



 
}
else if(Auth::guard('Admin')->user()->platform==env('Super'))
{
 $userid=Auth::guard('Admin')->user()->userid;
 $createria_request="";
 $createria_neworder="";

 $count_completeorders=DB::select("select count(id) as counter from completeorders");
foreach($count_completeorders as $row)
{
    $count_complete_orders=$row->counter;
}
$count_orders=DB::select("select count(id) as counter from orders");
foreach($count_orders as $rows)
{
    $count_pending_orders=$rows->counter;
}

$total_orders=$count_complete_orders+$count_pending_orders;



 
}
else
{
 $createria_request="";
 $createria_neworder="";

 
}



}
else if(Auth::check())
{
    $display_none="";
$userid=Auth::user()->userid;
$createria_request="where userid='$userid'";
$createria_neworder="where userid='$userid'";
$count_completeorders=DB::select("select count(id) as counter from completeorders where userid='$userid'");
foreach($count_completeorders as $row)
{
    $count_complete_orders=$row->counter;
}
$count_orders=DB::select("select count(id) as counter from orders where userid='$userid'");
foreach($count_orders as $rows)
{
    $count_pending_orders=$rows->counter;
}

$total_orders=$count_complete_orders+$count_pending_orders;
}

?>

    <!--Orders-->
    <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-midnight-bloom_med">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><i class="fas fa-shopping-bag"></i>  Completed Orders</div>
                                            <div class="widget-subheading"></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?php echo $count_complete_orders; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-arielle-smile_med">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><i class="fas fa-shopping-bag"></i>  Pending Orders</div>
                                            <div class="widget-subheading"></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?php echo $count_pending_orders; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-grow-early_med">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><i class="fas fa-shopping-bag"></i>  Total Received Orders</div>
                                            <div class="widget-subheading"></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?php echo $total_orders; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
    <!--Orders-->

<!--<div class="row  he-50 h-100 d-flex align-items-center justify-content-center">-->
<!--Ads code-->

<!--Ads code-->

               <!--History orders-->
           <div class="row">
           @include('components.Forms.Forms_Table_history_home')
  
           </div>
               <!--History orders-->



            </div>