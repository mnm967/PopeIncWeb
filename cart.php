<?php include("includes/header.php");?>
<?php include("includes/classes/Item.php");?>

<?php 
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: login.php");
    }
    $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    $userId = $user->getId();
    $cartItemsJSON = json_decode($cartUser->getCartIdsJSON(), true);
    $cartItems = array();
    $removedItemNames = array();    
    $cartItemsCurrent = json_decode($user->getCartIdsJSON(), true);
    foreach($cartItemsJSON as $itemId){
        $item = new Item($sqlConnection, $itemId['id']);
        $itemAvailable = $item->isAvailable();
        if(!$itemAvailable){
            array_push($removedItemNames, $item->getName());
        }else{
            array_push($cartItems, $item);
        }
    } 
    $nameString = null;
    if(count($removedItemNames) != 0){
        $updatedItems = array();
        foreach($cartItems as $mItem){
            $mId = $mItem->getId();
            $size = $user->getItemCartSize($mId);
            $jsonObject = array('id' => $mId, 'size' => $size);
            array_push($updatedItems, $jsonObject);
        }
        $newItemsJSON = json_encode($updatedItems);
        $query = mysqli_query($sqlConnection, "UPDATE users SET cartItemsJSON='$newItemsJSON' WHERE id='$userId'");
        $nameString = "*".$removedItemNames[0];
        if(count($removedItemNames) > 1){
            for($i = 1; $i < count($removedItemNames); $i++){
                $nameString .= "<br>*".$removedItemNames[$i];
            }
        }
        $newCount = count($cartItems);
        //echo $nameString;
        echo "<script type='text/javascript'>".
            "$('.cart-header').html('My Cart ($newCount)');".
            "</script>";
    }
?>

<head>
  <title>My Cart</title>
</head>
<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 9px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    My Cart (<?php
                                $count = 0;
                                foreach($cartItems as $item){
                                    $count++;
                                }
                                echo $count;
                            ?>)</h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7" style="<?php if($nameString == null) echo 'display: none;';?>">
                The following items have automatically been removed from your cart because there is no stock available for them:<br><?php
                        if($nameString != null) echo $nameString;
                    ?>
                </h3>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-6" style="font-weight: 500;">
                    Subtotal: R<?php
                        $total = 0; 
                        foreach($cartItems as $item){
                            $total += $item->getPrice();
                        }
                        echo $total;
                    ?>
                </h3> 
                <div class="mbr-section-btn align-center" >
                    <a href="checkout.php" class="btn btn-checkout transition-hover display-4" style="<?php if($count == 0) echo 'display: none;'?>">
                        Proceed to Checkout
                    </a>
                </div>
                <div class="mbr-section-btn align-center" >
                    <button onclick="removeAllItems('<?php echo $userId?>')" class="btn btn-remove transition-hover display-4">
                        Remove All
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container">
        <div class="row justify-content-center">
            <?php
                foreach($cartItems as $item){
                    $id = $item->getId();
                    $brand = $item->getBrand();
                    $price = $item->getPrice();
                    $name = $item->getName();
                    $images = json_decode($item->getImagesJSON(), true);
                    $imageUrl = $images[0];
                    $size = '';
                    foreach($cartItemsJSON as $jItem){
                        if($jItem['id'] == $id){
                            $size = $jItem['size'];
                        }
                    }

                    echo "<div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                    <div class='card-wrapper'>
                        <a href='item.php?id=$id'>
                            <div class='card-img'>
                                <img src='$imageUrl' alt='$name'>
                            </div>
                        </a>
                        <div class='card-box pb-md-5'>
                            <h4 class='item-card-title mbr-fonts-style display-7'>
                                $brand
                            </h4>
                            <span class='item-card-text mbr-text mbr-fonts-style display-7'>
                                $name
                            </span>
                            <div class='mbr-section-btn align-center' >
                                <a href='item.php?id=$id' class='btn btn-warning-outline display-4'>
                                    R$price
                                </a>
                            </div>
                            <div class='mbr-section-btn align-center' >
                                <button class='btn btn-item-unclickable display-4' style='cursor: default; background-color: #55666b !important; border-color: #55666b !important;'>
                                    <span style='color: #fff'>Size: $size<span>
                                </button>
                            </div>
                            <div class='mbr-section-btn align-center' >
                                <button onclick='removeItem($userId, $id)' class='btn btn-remove transition-hover display-4'>
                                    Remove
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
    function removeItem(userId, itemId){
        $.post("includes/ajax/remove-from-cart.php", {userId: userId, itemId: itemId}, function(result){
            if(result == 'true'){
                location.reload();
            }else{
                //TODO Show Error
            }
        });
    }
    function removeAllItems(userId){
        $.post("includes/ajax/remove-all-from-cart.php", {userId: userId}, function(result){
            if(result == 'true'){
                location.reload();
            }else{
                //TODO Show Error
            }
        });
    }
</script>
<?php include("includes/footer.php");?>