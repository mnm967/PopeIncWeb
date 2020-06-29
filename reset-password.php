<?php include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    include("includes/classes/ForgottenAccount.php");

    if($_SESSION['userLoggedIn']){
        header("Location: index.php");
    }

    if(isset($_GET['token'])){
        $token = $_GET['token'];
    }else{
        header("Location: index.php");
    }

    $query = mysqli_query($this->sqlConnection, "SELECT forgottenPasswordTimestamp FROM users WHERE forgottenPasswordToken='$token'");
    if(mysqli_num_rows($query) < 1){
        header("Location: index.php");
    }
    $row = mysqli_fetch_array($query);
    $forgottenPasswordTimestamp = $row['forgottenPasswordTimestamp'];
    
    $account = new ForgottenAccount($sqlConnection);

    function sanitizePassword($text){
        $text = strip_tags($text);
        return $text;
    }
    $tokenExpired = false;
    if(time() - $forgottenPasswordTimestamp >= 7200000){
        $tokenExpired = true;
    }
    if(isset($_POST['reset-button'])){
        $password = $_POST['password-form-reset'];
        $confirmPassword = $_POST['confirm-password-form-reset'];
        $password = sanitizePassword($password);
        $confirmPassword = sanitizePassword($confirmPassword);
        $changeSuccessful = $account->resetPassword($token, $password, $confirmPassword); 
        if($changeSuccessful){
            header("Location: login.php");
        }
    }
?>
<head>
  <title>Reset Password</title>
</head>
<section class="mbr-section cid-rixMG5zlpO" style="padding-top: 32px" style="<?php if(!$tokenExpired) echo'display: none;'?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    Your reset token has expired.
                </h2>
            </div>
        </div>
        <div class="row account-items-holder justify-content-center">
        <div style="padding-top: 32px">
                <div class="holder justify-content-center ">
                    <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                        <img src="assets/images/icons8-delete-filled.svg" class="align-center" style="width: 200px">
                    </h3>
                    <a class="btn btn-sm btn-black display-5" style="margin-top: 72px;" href="forgot-password.php">Request New Token</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mbr-section form3 cid-rixMG5zlpO" style="<?php if($tokenExpired) echo'display: none;'?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    NEW PASSWORD:</h2>
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                <form class="mbr-form" action="forgot-password.php" method="POST"> 
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <?php echo $account->getError(Constants::$passwordsDontMatchError); ?>
                            <?php echo $account->getError(Constants::$passwordLengthError); ?>
                            <label for="password-form-reset">Password*</label>
                            <input class="form-control" type="password" name="password-form-reset" placeholder="Password" id="password-form-reset" required>
                        </p>
                        <p>
                            <label for="confirm-password-form-reset">Confirm Password*</label>
                            <input class="form-control" type="password" name="confirm-password-form-reset" placeholder="Confirm Password" id="confirm-password-form-reset" required>
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button type="submit" name="reset-button" class="btn btn-primary display-4">CHANGE PASSWORD</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>