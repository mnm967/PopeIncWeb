<?php include("includes/header.php");?>
<?php 
    include("includes/classes/Item.php");
    if(isset($_GET['id'])){
        $itemId = $_GET['id'];
    }else{
        header("Location: index.php");
    }
    $existsQuery = mysqli_query($sqlConnection, "SELECT images FROM items WHERE id='$itemId'");
    if(mysqli_num_rows($existsQuery ) == 0){
        header("Location: index.php");
    }
    $item = new Item($sqlConnection, $itemId);
    $isItemInCart = false;
    $isItemInWishlist = false;
    $itemAvailable = $item->isAvailable();
    if(isset($_SESSION['userLoggedIn'])){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
        $userId = $user->getId();
        $isItemInCart = $user->isItemInCart($itemId);
        $isItemInWishlist = $user->isItemInWishlist($itemId);
    }
    if($item->getType() == 0){
        $sizesJSON = $item->getAvilableClothesSizesJSON();
    }else if($item->getType() == 1){
        $sizesJSON = $item->getAvailableShoeSizesJSON();
    }else{
        $sizesJSON = null;
    }
?>
<head>
  <title><?php echo $item->getName() ?></title>
</head>

<section class="features11 cid-riZn1v8Hhj item-details-section" id="features11-13"> <div class="container" style="padding: 0;">   
        <div class="col-md-12">
            <div class="media-container-row">
                <div class="mbr-figure m-auto justify-content-center item-img-holder">
                    <div id="image-carousel" class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            <?php
                                $images = json_decode($item->getImagesJSON(), true);
                                foreach($images as $link){
                                    $i = array_search($link, $images);
                                    if($i == 0){
                                        echo "<div class='carousel-item active'>
                                            <img src='$link' alt='Item-Image' class='d-block'>
                                        </div>";
                                    }else{
                                        echo "<div class='carousel-item'>
                                            <img src='$link' alt='Item-Image' class='d-block'>
                                        </div>";
                                    }
                                }
                            ?>
                        </div>
                        <a href="#image-carousel" class="carousel-control-prev" role="button" data-slide="prev">
                            <div style="background-color: black; padding: 16px;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </div>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a href="#image-carousel" class="carousel-control-next" role="button" data-slide="next">
                            <div style="background-color: black; padding: 16px;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </div>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class=" align-left aside-content item-details-text" style="width: 100%;">
                    <h2 class="mbr-title pt-2 mbr-fonts-style display-2">
                        <?php echo $item->getBrand()?>
                    </h2>
                    <div class="mbr-section-text">
                        <p class="mbr-text mb-5 pt-3 mbr-light mbr-fonts-style display-5">
                            <?php echo $item->getName()?><br>
                            <?php echo "R" . $item->getPrice()?>
                        </p>
                    </div>

                    <div class="block-content">
                        <div class="item-details">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="card-title mbr-fonts-style display-6 item-details-header">
                                        Details
                                    </h4>
                                </div>
                            </div>                

                            <div class="card-box item-details">
                                <p class="block-text mbr-fonts-style display-7 item-details">
                                    <?php echo $item->getDescription()?> <br><br>
                                    <?php
                                       $data = json_decode($item->getAdditionalInfoJSON(), true);
                                       $sports = array();
                                       foreach ($data as $item) {
                                           echo ucfirst($item['name']) ." - ". ucfirst($item['detail']) ."<br>";
                                       }
                                    ?> <br>
                                </p>
                                <div class="row sizes justify-content-center" style="<?php if($sizesJSON == null) echo 'display: none';?>">
                                    <h4 class="card-title mbr-fonts-style display-6">
                                        Available Sizes:
                                    </h4>
                                    <div class="size-btn-holder">
                                        <?php
                                            if($sizesJSON != null){
                                                $itemSizes = json_decode($sizesJSON, true);
                                                foreach ($itemSizes as $size){
                                                    if($itemSizes[0] == $size){
                                                        echo "<button onclick=\"selectSize('$size')\" class='btn btn-size btn-size-selected transition-hover display-4 btn-size-$size' id='size-selected'>$size</button>";
                                                    }else{
                                                        echo "<button onclick=\"selectSize('$size')\" class='btn btn-size btn-size-unselected transition-hover display-4 btn-size-$size'>$size</button>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="item-button mbr-section-btn <?php if(isset($_SESSION['userLoggedIn'])) echo 'col-12 col-lg-6 col-md-6 col-sm-6';?>" style="<?php if(!isset($_SESSION['userLoggedIn'])) echo 'width: 100%';?>">
                                    <a class="btn btn-sm <?php if(isset($_SESSION['userLoggedIn'])){
                                            if($isItemInCart){
                                                echo 'btn-remove';
                                            }else{
                                                echo 'btn-black';
                                            }
                                        }else{
                                            echo 'btn-black';
                                        }?> display-5" href="<?php 
                                        if(isset($_SESSION['userLoggedIn'])){
                                            if(!$isItemInCart){
                                                if($itemAvailable){
                                                    echo 'javascript:AddItemToCart('.$userId.','.$itemId.');';
                                                }else{
                                                    echo "javascript:showModal('Item Unavailable','There is currently no stock available for this item.')";
                                                }
                                            }
                                            else{
                                                echo 'javascript:RemoveItemFromCart('.$userId.','.$itemId.');';
                                            }
                                        }else{
                                            echo 'login.php';
                                        }?>">
                                        <?php if(isset($_SESSION['userLoggedIn'])){
                                            if($isItemInCart){
                                                echo 'Remove from Cart';
                                            }else{
                                                if($itemAvailable){
                                                    echo 'Add to Cart';
                                                }else{
                                                    echo 'Stock Unavailable';
                                                }
                                            }
                                        }else{
                                            echo 'Log In to Order';
                                        }?></a></div>
                                <div class="item-button mbr-section-btn col-12 col-lg-6 col-md-6 col-sm-6" style="<?php if(!isset($_SESSION['userLoggedIn'])) echo 'display:none';?>">
                                    <a class="btn btn-sm <?php if(isset($_SESSION['userLoggedIn'])){
                                            if($isItemInWishlist){
                                                echo 'btn-remove';
                                            }else{
                                                echo 'btn-black';
                                            }
                                        }else{
                                            echo 'btn-black';
                                        }?> display-5" href="<?php 
                                        if(isset($_SESSION['userLoggedIn'])){
                                            if(!$isItemInWishlist){
                                                echo 'javascript:AddItemToWishlist('.$userId.','.$itemId.');';
                                            }else{
                                                echo 'javascript:RemoveItemFromWishlist('.$userId.','.$itemId.');';
                                            }
                                        }else{
                                            echo 'login.php';
                                        }?>">
                                        <?php if(isset($_SESSION['userLoggedIn'])){
                                            if($isItemInWishlist){
                                                echo 'Remove from Wishlist';
                                            }else{
                                                echo 'Add to Wishlist';
                                            }
                                        }else{
                                            echo 'Add to Wishlist';
                                        }?></a></div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>          
</section>
<script>
    function selectSize(size){
        var btnClass = ".btn-size-"+size;
        $(".btn-size").removeClass("btn-size-selected");
        $(".btn-size").attr("id" , "");
        $(".btn-size").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "size-selected");
        var isLoggedIn = <?php echo isset($_SESSION['userLoggedIn']);?>;
        if(isLoggedIn){
            var size = $("#size-selected").html();
            var userId = <?php echo $userId?>;
            var itemId = <?php echo $itemId?>;
            $.post("includes/ajax/change-cart-size.php", {userId: userId, itemId: itemId, size: size}, function(result){
                if(result == 'true'){
                    //location.reload();
                }else{
                    //TODO Show Error
                }
            });
        }
    }
    function defaultSize(size){
        var btnClass = ".btn-size-"+size;
        $(".btn-size").removeClass("btn-size-selected");
        $(".btn-size").attr("id" , "");
        $(".btn-size").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "size-selected");
    }
    function AddItemToCart(userId, itemId){
        var size = $("#size-selected").html();
        $.post("includes/ajax/add-to-cart.php", {userId: userId, itemId: itemId, size: size}, function(result){
            location.reload();
        });
    }
    function AddItemToWishlist(userId, itemId){
        $.post("includes/ajax/add-to-wishlist.php", {userId: userId, itemId: itemId}, function(result){
            location.reload();
        });
    }
    function RemoveItemFromCart(userId, itemId){
        $.post("includes/ajax/remove-from-cart.php", {userId: userId, itemId: itemId}, function(result){
            location.reload();
        });
    }
    function RemoveItemFromWishlist(userId, itemId){
        $.post("includes/ajax/remove-from-wishlist.php", {userId: userId, itemId: itemId}, function(result){
            location.reload();
        });
    }
</script>
<?php 
    if($isItemInCart){
        $itemCartSize = $user->getItemCartSize($itemId);
        echo "<script type='text/javascript'>".
            "defaultSize('$itemCartSize');".
            "</script>";
    }
?>
<?php include("includes/footer.php");?>