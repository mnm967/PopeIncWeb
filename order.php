<?php include("includes/header.php");?>
<?php include("includes/classes/Item.php");?>
<?php include("includes/classes/Order.php");?>
<?php
    /*$user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    $userId = $user->getId();
    $dateOrdered = date("Y-m-d");
    $address = "441 Race Rd, Lakefield, Benoni, 1501";
    $totalCost = 899;
    $deliveryCost = 157;
    $recipientName = "Carol Danvers";
    $recipientNumber = "34553444";
    $items = $user->getCartIdsJSON();
    $query = mysqli_query($sqlConnection, "INSERT INTO orders VALUES ('', '$userId', '50000', '$items', '$dateOrdered', '0', '', '0', '', '$totalCost', '$deliveryCost', '$address', '$recipientName', '$recipientNumber')");
    echo $query;*/
    if(isset($_GET['id'])){
        $orderId = $_GET['id'];
    }else{
        header("Location: user-orders.php");
    }
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: login.php");
    }
    $userId = $_SESSION['userLoggedIn'];
    $user = new User($sqlConnection, $userId);
    $existsCheck = mysqli_query($sqlConnection, "SELECT * FROM orders WHERE id='$orderId' AND userId='$userId'");
    if(mysqli_num_rows($existsCheck) == 0){
        header("Location: user_orders.php");
    }else{
        $order = new Order($sqlConnection, $orderId, $userId);
    }
?>
<head>
  <title>Order #<?php echo $orderId; ?></title>
</head>
<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 32px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title">
            <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    Order #<?php echo $orderId; ?>
            </h2>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-6">
                Cost: R<?php echo $order->getTotalCost() - $order->getDeliveryCost(); ?>
            </h3> 
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-6">
                Delivery Cost: R<?php echo $order->getDeliveryCost(); ?>
            </h3> 
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-6" style="font-weight: 500;">
                Total Cost: R<?php echo $order->getTotalCost(); ?>
            </h3> 
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4" style="margin-top: 24px;">
                Recipient Name: <?php echo $order->getRecipientName(); ?>
            </h3>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4">
                Recipient Phone Number: <?php echo $order->getRecipientNumber(); ?>
            </h3>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4">
                Shipping Address: <?php echo $order->getShippingAddress(); ?>
            </h3>
            </div>
        </div>
    </div>
</section>
<section class="items-container cid-riDn13Ln0F" id="services1-x" style="padding: 32px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class='col-12 col-md-4 col-lg-2 col-sm-4' style="padding: 8px 0;">
                <div class="holder justify-content-center ">
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" style="font-weight: 500;">
                        Order Received
                    </h3> 
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <?php echo $order->getDateOrdered(); ?>
                    </h3>
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <img src="assets/images/icons8-checkmark.svg" class="align-center" style="width: 100px">
                    </h3>
                </div>
            </div>

            <div class='col-12 col-md-4 col-lg-2 col-sm-4' style="padding: 8px 0;">
                <div class="holder justify-content-center ">
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" style="font-weight: 500;">
                        Delivery Placed
                    </h3> 
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <?php 
                            if($order->isDeliveryScheduled()){
                                echo $order->getDeliveryScheduledDate();
                            }else{
                                echo "Pending";
                            }
                        ?>
                    </h3>
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <img src="<?php 
                            if($order->isDeliveryScheduled()){
                                echo "assets/images/icons8-checkmark.svg";
                            }else{
                                echo "assets/images/icons8-more-filled-100.png";
                            }
                        ?>" class="align-center" style="width: 100px">
                    </h3>
                </div>
            </div>

            <div class='col-12 col-md-4 col-lg-2 col-sm-4' style="padding: 8px 0;">
                <div class="holder justify-content-center ">
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" style="font-weight: 500;">
                        Parcel Delivered
                    </h3> 
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <?php 
                            if($order->isDelivered()){
                                echo $order->getDateDelivered();
                            }else{
                                echo "Pending";
                            }
                        ?>
                    </h3>
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <img src="<?php 
                            if($order->isDelivered()){
                                echo "assets/images/icons8-checkmark.svg";
                            }else{
                                echo "assets/images/icons8-more-filled-100.png";
                            }
                        ?>" class="align-center" style="width: 100px">
                    </h3>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 32px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title">
            <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    Items:
            </h2>
            </div>
        </div>
    </div>
</section>
<section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container">
        <div class="row justify-content-center">
            <?php
                $orderedItemsJSON = json_decode($order->getItemsJSON(), true);
                $orderedItems = array();
                foreach($orderedItemsJSON as $itemId){
                    $oItem = new Item($sqlConnection, $itemId['id']);
                    array_push($orderedItems, $oItem);
                } 
                foreach($orderedItems as $item){
                    $id = $item->getId();
                    $brand = $item->getBrand();
                    $price = $item->getPrice();
                    $name = $item->getName();
                    $images = json_decode($item->getImagesJSON(), true);
                    $imageUrl = $images[0];
                    $size = '';
                    foreach($orderedItemsJSON as $jItem){
                        if($jItem['id'] == $id){
                            $size = $jItem['size'];
                        }
                    }

                    echo "<div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                    <div class='card-wrapper'>
                            <div class='card-img'>
                                <img src='$imageUrl' alt='$name'>
                            </div>
                        <div class='card-box pb-md-5'>
                            <h4 class='item-card-title mbr-fonts-style display-7'>
                                $brand
                            </h4>
                            <span class='item-card-text mbr-text mbr-fonts-style display-7'>
                                $name
                            </span>
                            <div class='mbr-section-btn align-center' >
                                <button class='btn btn-item-unclickable display-4' style='cursor: default; background-color: #55666b !important; border-color: #55666b !important;'>
                                    <span style='color: #fff'>R$price<span>
                                </button>
                            </div>
                            <div class='mbr-section-btn align-center' >
                                <button class='btn btn-item-unclickable display-4' style='cursor: default; background-color: #55666b !important; border-color: #55666b !important;'>
                                    <span style='color: #fff'>Size: $size<span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>";
                }
            ?>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>