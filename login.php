<?php include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    include("includes/classes/Account.php");
    
    if(isset($_SESSION['userLoggedIn'])){
        header("Location: index.php");
    }
    
    $account = new Account($sqlConnection);

    if(isset($_POST['login-button'])){
        $email = $_POST['email-form-login'];
        $password = $_POST['password-form-login'];
    
        $loginSuccessful = $account->login($email, $password);
    
        if($loginSuccessful){
            $_SESSION['userLoggedIn'] = $account->getCurrentUserId();
            header("Location: index.php");
        }
    }
?>
<head>
  <title>Log In</title>
</head>
<section class="mbr-section form3 cid-rixMG5zlpO" id="form-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    LOG IN</h2>
                
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                <form class="mbr-form" action="login.php" method="POST"> 
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <?php echo $account->getError(Constants::$loginFailed); ?>
                            <label for="email-form-login">Email Address</label>
                            <input class="form-control" type="email" name="email-form-login" placeholder="Email" id="email-form-login" required>
                        </p>
                        <p>
                            <label for="password-form-login">Password</label>
                            <input class="form-control" type="password" name="password-form-login" placeholder="Password" id="password-form-login" required>
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button type="submit" name="login-button" class="btn btn-primary display-4">LOG IN</button>
                        </div>
                    </div>
                </form>
                
                    <a href="forgot-password.php" class="login-extra login-extra-link display-4">Forgot your Password?</a>
                    <p class="login-extra display-4">Don't Have an Account? <a href="sign-up.php" class="login-extra-link">Sign Up.</a></p>
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>