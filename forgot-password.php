<?php include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    include("includes/classes/ForgottenAccount.php");

    if($_SESSION['userLoggedIn']){
        header("Location: index.php");
    }
    
    $account = new ForgottenAccount($sqlConnection);

    if(isset($_POST['reset-button'])){
        $email = $_POST['email-form-reset'];
        $email = strip_tags($email);
        $account->sendToken($email);
    }
?>
<head>
  <title>Forgotten Password</title>
</head>
<section class="mbr-section form3 cid-rixMG5zlpO" id="form-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    FORGOT YOUR PASSWORD?</h2>
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                <form class="mbr-form" action="forgot-password.php" method="POST"> 
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <?php echo $account->getError(Constants::$emailNotFound); ?>
                            <?php echo $account->getError(Constants::$emailInvalidError); ?>
                            <?php echo $account->getSuccess(Constants::$tokenSent); ?>
                            <label for="email-form-reset">Email Address</label>
                            <input class="form-control" type="email" name="email-form-reset" placeholder="Email" id="email-form-reset" required>
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button type="submit" name="reset-button" class="btn btn-primary display-4">SEND RESET TOKEN</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>