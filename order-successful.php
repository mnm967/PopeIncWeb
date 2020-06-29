<?php include("includes/header.php");?>
<?php include("includes/classes/Order.php");?>
<?php
    if(isset($_SESSION['userLoggedIn'])){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: login.php");
    }
?>
<head>
  <title>Order Successful</title>
</head>
<section class="mbr-section cid-rixMG5zlpO" style="padding-top: 32px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    Your order has been successfully placed.
                </h2>
            </div>
        </div>
        <div class="row account-items-holder justify-content-center">
        <div style="padding-top: 32px">
                <div class="holder justify-content-center ">
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <img src="assets/images/icons8-checkmark.svg" class="align-center" style="width: 200px">
                    </h3>
                    <a class="btn btn-sm btn-black display-5" style="margin-top: 72px;" href="user-orders.php">View My Orders</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>