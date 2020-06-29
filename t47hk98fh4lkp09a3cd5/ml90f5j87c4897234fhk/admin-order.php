<?php include("../../includes/admin-header.php");?>
<?php include("../../includes/classes/Item.php");?>
<?php include("../../includes/classes/Order.php");?>
<?php
    if(isset($_SESSION['userLoggedIn'])){
        if($_SESSION['userLoggedIn'] ==  AdminConstants::$adminId){
        }else{
            header("Location: admin-login.php");
        }
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: admin-login.php");
    }
    if(isset($_GET['id'])){
        $orderId = $_GET['id'];
    }else{
        header("Location: admin-view-orders.php");
    }
    $userId = $_SESSION['userLoggedIn'];
    $user = new User($sqlConnection, $userId);
    $query = mysqli_query($sqlConnection, "SELECT * FROM orders WHERE id='$orderId'");
    if(mysqli_num_rows($query) == 0){
        header("Location: admin-view-orders.php");
    }else{
        $row = mysqli_fetch_array($query);
        $orderUser = new User($sqlConnection, $row['userId']);
        $order = new Order($sqlConnection, $orderId, $row['userId']);
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
                User Name: <?php echo $orderUser->getName(); ?>
            </h3>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4">
                User Email: <?php echo $orderUser->getEmail(); ?>
            </h3>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4">
                User Phone Number: <?php echo $orderUser->getPhoneNumber(); ?>
            </h3>
            <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-4">
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
        <h2 class="align-center pb-3 mbr-fonts-style display-6" style="<?php if($order->isDelivered()) echo 'display: none'?>">
            Click Image to Confirm:
        </h2>
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
                        <img src="../../assets/images/icons8-checkmark.svg" class="align-center" style="width: 100px">
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
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" onclick="<?php 
                            if(!$order->isDeliveryScheduled()){
                                echo "confirmOrderScheduled($orderId)";
                            }?>" style="cursor: pointer;">
                        <img src="<?php 
                            if($order->isDeliveryScheduled()){
                                echo "../../assets/images/icons8-checkmark.svg";
                            }else{
                                echo "../../assets/images/icons8-more-filled-100.png";
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
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" onclick="<?php 
                            if(!$order->isDelivered() && $order->isDeliveryScheduled()){
                                echo "confirmOrderDelivered($orderId)";
                            }?>" style="<?php 
                            if(!$order->isDelivered()  && $order->isDeliveryScheduled()){
                                echo "cursor: pointer;";
                            }else{
                                echo "cursor: default;";
                            }?>">
                        <img src="<?php
                            if($order->isDelivered()){
                                echo "../../assets/images/icons8-checkmark.svg";
                            }else{
                                echo "../../assets/images/icons8-more-filled-100.png";
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
                                <img src='../../$imageUrl' alt='$name'>
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
<script>
    function confirmOrderScheduled(orderId){
        $.post("includes/ajax/confirm-order-scheduled.php", {orderId: orderId}, function(result){
            location.reload();
        });
    }
    function confirmOrderDelivered(orderId){
        $.post("includes/ajax/confirm-order-delivered.php", {orderId: orderId}, function(result){
            location.reload();
        });
    }
</script>
<?php include("../../includes/admin-footer.php");?>