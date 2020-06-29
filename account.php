<?php include("includes/header.php");?>
<?php
    if(isset($_SESSION['userLoggedIn'])){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: login.php");
    }
?>
<head>
  <title>My Account</title>
</head>
<section class="mbr-section cid-rixMG5zlpO" style="padding-top: 32px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    <?php echo $user->getName();?>
                </h2>
            </div>
        </div>
        <div class="row account-items-holder justify-content-center">
            <div class="cards-holder row">
                <a href="orders.php" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="assets/images/icons8-cardboard-box-100.png" alt="My Orders" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">My Orders</h4>
                    </div>
                </a>
                <a href="cart.php" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="assets/images/icons8-shopping-cart-100.png" alt="My Cart" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">My Cart</h4>
                    </div>
                </a>
                <a href="user-details.php" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="assets/images/icons8-contacts-100.png" alt="Personal Details" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">Personal Details</h4>
                    </div>
                </a>
                <a href="wishlist.php" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="assets/images/icons8-star-filled-100.png" alt="Wish List" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">My Wish List</h4>
                    </div>
                </a>
                <a href="javascript:logOut()" class="card-link-holder">
                    <div class="account-logout-card account-card transition-hover" onclick="logOut()">
                        <img src="assets/images/icons8-exit-100.png" alt="Log Out" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">Log Out</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<script>
    function logOut(){
        $.post('includes/ajax/log-out-ajax.php', function(data){
            window.location.href = "index.php";   
        });
    }
</script>
<?php include("includes/footer.php");?>