<?php
    include("includes/config.php");
    include("includes/classes/User.php");
    ?>
<html >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
  <meta name="description" content="">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons-bold/mobirise-icons-bold.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <!--<link rel="stylesheet" href="assets/animatecss/animate.min.css">-->
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="css/custom-styles.css" type="text/css">
  <script src="assets/jquery/jquery-3.3.1.min.js"></script>
  
</head>
<body>

 <!-- Button trigger modal -->
 <button type="button" class="btn btn-primary" id="modal-trigger" data-toggle="modal" data-target="#modal-center" style="display: none;">
  </button>
  <!-- Modal -->
  <div class="modal fade" id="modal-center" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
      function showModal(title, body){
        $("#modal-title").html(title);
        $("#modal-body").html(body);
        $("#modal-trigger").click();
      }
  </script>

<section class="menu cid-rilqXGXpJv" once="menu" id="menu2-2" style="height: 73px; background-color: #fff !important;">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-toggleable-sm">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="index.php">
                        <img src="assets/images/logo2.png" style="height: 3.8rem;">
                    </a>
                </span>
                
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item">
                    <a class="nav-link link text-black display-4" href="<?php 
                        if(isset($_SESSION['userLoggedIn'])){
                            echo "account.php";
                        }else{
                            echo "login.php";
                        }
                    ?>">
                    <span class="mobi-mbri mobi-mbri-user mbr-iconfont mbr-iconfont-btn"></span><?php
                        if(isset($_SESSION['userLoggedIn'])){
                            echo "My Account";
                        }else{
                            echo "Log In";
                        }
                    ?></a>
                </li>
                <li class="nav-item" style="<?php 
                        if(!isset($_SESSION['userLoggedIn'])){
                            echo "display: none;";
                        }
                    ?>">
                    <a class="nav-link link text-black display-4" href="cart.php" aria-expanded="false">
                    <span class="mbrib-shopping-cart mbr-iconfont mbr-iconfont-btn"></span><span class="cart-header">My Cart (<?php 
                        if(isset($_SESSION['userLoggedIn'])){
                            $cartUser = new User($sqlConnection, $_SESSION['userLoggedIn']);
                            $cartItems = json_decode($cartUser->getCartIdsJSON());
                            $cartItemCount = 0;
                            foreach($cartItems as $item){
                                $cartItemCount++;
                            }
                            echo $cartItemCount;
                        }
                    ?>)</span></a>
                </li>
                <li class="nav-item" style="<?php 
                        if(!isset($_SESSION['userLoggedIn'])){
                            echo "display: none;";
                        }
                    ?>">
                    <a class="nav-link link text-black display-4" href="wishlist.php" aria-expanded="false">
                    <span class="mbrib-star mbr-iconfont mbr-iconfont-btn"></span>My Wishlist (<?php 
                        if(isset($_SESSION['userLoggedIn'])){
                            $wishlistUser = new User($sqlConnection, $_SESSION['userLoggedIn']);
                            $wishlistItems = json_decode($cartUser->getWishlistIdsJSON());
                            $wishlistItemCount = 0;
                            foreach($wishlistItems as $item){
                                $wishlistItemCount++;
                            }
                            echo $wishlistItemCount;
                        }
                    ?>)</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link link text-black dropdown-toggle display-4" aria-expanded="false" data-toggle="dropdown-submenu">Men</a>
                    <div class="dropdown-menu header-dropdown-menu">
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=clothing&s=men" aria-expanded="false">Clothing</a>
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=shoes&s=men" aria-expanded="false">Shoes</a>
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=accessories&s=all" aria-expanded="false">Accessories</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link link text-black dropdown-toggle display-4" aria-expanded="false" data-toggle="dropdown-submenu">Women</a>
                    <div class="dropdown-menu header-dropdown-menu">
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=clothing&s=women" aria-expanded="false">Clothing</a>
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=shoes&s=women" aria-expanded="false">Shoes</a>
                        <a class="text-black dropdown-item display-4" href="clothing.php?type=accessories&s=all" aria-expanded="false">Accessories</a>
                    </div>
                </li>
            </ul>
            <div class="navbar-buttons mbr-section-btn">
                <a class="btn btn-sm btn-black display-4" href="search.php">
                    <span class="mbrib-search mbr-iconfont mbr-iconfont-btn"></span>Search&nbsp;
                </a>
            </div>
        </div>
    </nav>
</section>