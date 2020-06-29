<?php include("../../includes/admin-header.php");?>
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
?>
<head>
  <title>Admin Account</title>
</head>
<section class="mbr-section cid-rixMG5zlpO" style="padding-top: 32px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    Admin: <?php echo $user->getName();?>
                </h2>
            </div>
        </div>
        <div class="row account-items-holder justify-content-center">
            <div class="cards-holder row">
                <a href="admin-view-orders.php" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="../../assets/images/icons8-cardboard-box-100.png" alt="Orders" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">View Orders</h4>
                    </div>
                </a>
                <a href="admin-clothing.php?type=clothing&s=men" class="card-link-holder">
                    <div class="account-card transition-hover">
                        <img src="../../assets/images/icons8-shopping-cart-100.png" alt="Items" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">View Clothing</h4>
                    </div>
                </a>
                <a href="javascript:logOut()" class="card-link-holder">
                    <div class="account-logout-card account-card transition-hover" onclick="logOut()">
                        <img src="../../assets/images/icons8-exit-100.png" alt="Log Out" class="card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">Log Out</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<script>
    function logOut(){
        $.post('../../includes/ajax/log-out-ajax.php', function(data){
            window.location.href = "admin-login.php";   
        });
    }
</script>
<?php include("../../includes/admin-footer.php");?>