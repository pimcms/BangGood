<?php

    if(!class_exists("Order")){
        include("../model/Cart/Order.php");
    }


    $title = "Current Orders | BangGood";

    include("header.php");
    include("nevigation.php");

    $orders = getAllOrders();
    
    $ord = $orders[0];
    echo $ord->getOrderProductCount();

?>


<div class="ads-grid col-md-12 col-xs-12" style="margin-bottom: 10px; margin-top: 10px;">
    <div class="container-fluid">
        <h3 class="tittle-w3l text-center col-md-12 col-xs-12">
            <span>C</span>urrent
            <span>O</span>rders</h3>
    </div>

    <div class="container" style="background: ;"></div>

</div>

<?php
$counter = 0;
foreach ($orders as $order) {
    $counter += 1;
    ?>
    <div style="margin:50px;">
    <div style="width:98%; box-shadow:-1px 1px 1px 1px Gray;" class="table-responsive">
        <table class="table table-striped table-bordered" data-page-length='10'>
            <tr style="border-bottom:1px;">
                <H5 style="font-size:medium; margin:10px; margin-top:20px;">Order ID. : <?php echo $order->order_id; ?> </H5>
            </tr>
            <tr>
                <td>
                    <div class="text-center">  <?php echo $counter; ?>
                    </div>
                </td>

                <td style="width:200px;"><b>Buyer : </b><?php echo $order->name; ?><br />
                    <span style="color:Gray; font-size:x-small;">Number Of Items : <?php echo $order->getOrderProductCount() ?>
                        <!--<% Response.Write(readerProduct["Type"].ToString()); %>--></span><br />
                    <span style="color:Gray; font-size:x-small;">Price : <?php echo $order->getTotalPriceOfProducts() ?>
                        <!--<% Response.Write(readerProduct["Type"].ToString()); %>--></span>
                </td>

                <td style="min-width:200px;"><b>Payment Staus : </b><?php echo $order->payment_status; ?><hr/>
                <b>Contact Number : </b><?php echo $order->contact_num; ?><hr/><b>Order Staus :</b> <?php echo $order->order_status; ?>
                </td>

                <td>
                    <div class="text-center">
                        <b>Address</b>
                        <hr style="margin:2px;">
                        <p><?php echo " line 1 "; ?></p>
                        <hr style="margin:2px;">
                        <p><?php echo " line 1 "; ?></p>
                        <hr style="margin:2px;">
                        <p><?php echo " line 1 "; ?></p>
                        <hr style="margin:2px;">
                        <p><?php echo " line 1 "; ?></p>
                    </div>
                   
                </td>

                <td>
                    <div class="text-center" style="height: 100%;">
                        <button type="button" class="btn btn-primary" style="width:100%; max-width:150px; " >Track Order</button><br />
                        <?php if($order->order_status == "Need Approval") { ?>
                            <button type="button" class="btn btn-success" id="<?php echo $order->order_id; ?>" onClick="approveOrder(this);" style="margin-top:10px;width:100%;max-width:150px;">Approve</button><br />
                        
                        <button type="button" class="btn btn-danger" style="margin-top:10px; width:100%; max-width:150px;" id="<?php echo $order->order_id; ?>" onClick="disapproveOrder(this);" >Reject</button>
                        <?php } ?>
                    </div>
                </td>

            </tr>


        </table>
    </div>
</div>
<?php } ?>



<?php
include("footer.php"); ?>

<script type="text/javascript">

    function approveOrder(btn){
       
        $.ajax({
                url: "../ajax/approve_order.php",
                method: "POST",
                data: {
                    action : "approve_order",
                    order_id : btn.id
                },
                success: function (data) {
                    alert(data);
                    //alert("Order Is Approved...!!!");
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                    alert("There is an error with AJAX!");
                }
            });

        btn.remove();
    } 

    
    function disapproveOrder(btn){
       
       $.ajax({
               url: "../ajax/disapprove_order.php",
               method: "POST",
               data: {
                   action : "disapprove_order",
                   order_id : btn.id
               },
               success: function (data) {
                   alert(data);
                   //alert("Order Is Approved...!!!");
               },
               error: function (errorThrown) {
                   alert(errorThrown);
                   alert("There is an error with AJAX!");
               }
           });

       btn.remove();
   } 
</script>