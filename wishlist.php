<?php include("includes/header.php");?>
<?php include("includes/classes/Item.php");?>

<?php 
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: login.php");
    }
    $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    $userId = $user->getId();
    $wishlistItemsJSON = json_decode($wishlistUser->getWishlistIdsJSON(), true);
    $wishlistItems = array();
    foreach($wishlistItemsJSON as $itemId){
        $item = new Item($sqlConnection, $itemId);
        array_push($wishlistItems, $item);
    }
?>

<head>
  <title>My Wishlist</title>
</head>
<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 9px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    My Wishlist (<?php
                                $count = 0;
                                foreach($wishlistItems as $item){
                                    $count++;
                                }
                                echo $count;
                            ?>)</h2>
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
                foreach($wishlistItems as $item){
                    $id = $item->getId();
                    $brand = $item->getBrand();
                    $price = $item->getPrice();
                    $name = $item->getName();
                    $images = json_decode($item->getImagesJSON(), true);
                    $imageUrl = $images[0];

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
        $.post("includes/ajax/remove-from-wishlist.php", {userId: userId, itemId: itemId}, function(result){
            if(result == 'true'){
                location.reload();
            }else{
                //TODO Show Error
            }
        });
    }
    function removeAllItems(userId){
        $.post("includes/ajax/remove-all-from-wishlist.php", {userId: userId}, function(result){
            if(result == 'true'){
                location.reload();
            }else{
                //TODO Show Error
            }
        });
    }
</script>
<?php include("includes/footer.php");?>