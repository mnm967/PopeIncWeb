<?php include("includes/header.php");?>
<?php include("includes/classes/Order.php");?>
<?php
    if(isset($_SESSION['userLoggedIn'])){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: login.php");
    }
    $ordersJSON = json_decode($user->getOrderIdsJSON(), true);
    $orders = array();
    foreach($ordersJSON as $id){
        $mOrder = new Order($sqlConnection, $id, $user->getId());
        array_push($orders, $mOrder);
    }
    array_reverse($orders);
?>
<head>
  <title>My Orders</title>
</head>
<section class="mbr-section cid-rixMG5zlpO" style="padding-top: 32px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    My Orders
                </h2>
            </div>
        </div>
        <div class="row account-items-holder justify-content-center">
            <div class="cards-holder row" style="width: 100%;">
            <?php
                foreach($orders as $order){
                    $id = $order->getId();
                    if($order->isDelivered()){
                        $status = "Parcel Delivered";
                        $date = $order->getDateDelivered();
                    }else if($order->isDeliveryScheduled()){
                        $status = "Delivery Placed";
                        $date = $order->getDeliveryScheduledDate();
                    }else{
                        $status = "Order Placed";
                        $date = $order->getDateOrdered();
                    }
                    echo "<a href='order.php?id=$id' class='card-link-holder' style='width: 100%'>
                                <div class='account-card transition-hover'>
                                    <h4 class='card-title display-5 pb-2 mbr-fonts-style' style='display: block; width: 100%;'>Orders #$id</h4>
                                    <h4 class='card-title display-4 pb-2 mbr-fonts-style' style='display: block; width: 100%; font-weight: 400;'>Status: $status</h4>
                                    <h4 class='card-title display-4 pb-2 mbr-fonts-style' style='display: block; width: 100%;'>$date</h4>
                                </div>
                            </a>";
                }
            ?>
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>