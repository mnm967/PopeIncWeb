<?php 
    include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    include("includes/classes/Account.php");

    if(isset($_SESSION['userLoggedIn'])){
        header("Location: index.php");
    }
    
    $account = new Account($sqlConnection);

    function sanitizeUsername($text){
        $text = strip_tags($text);
        $text = str_replace(" ", "", $text);
        return $text;
    }
    function sanitizeString($text){
        $text = strip_tags($text);
        $text = str_replace(" ", "", $text);
        $text = ucfirst(strtolower($text));
        return $text;
    }
    function sanitizeName($text){
        $text = strip_tags($text);
        $text = ucwords(strtolower($text));
        return $text;
    }
    function sanitizeEmail($text){
        $text = strip_tags($text);
        $text = str_replace(" ", "", $text);
        return $text;
    }
    function sanitizePhoneNumber($text){
        $text = trim($text);
        $text = str_replace(" ", "", $text);
        return $text;
    }
    function sanitizePassword($text){
        $text = strip_tags($text);
        return $text;
    }
    if(isset($_POST['signupButton'])){
        $firstName = sanitizeName($_POST['firstname-form-signup']);
        $lastName = sanitizeName($_POST['lastname-form-signup']);
        $email = sanitizeEmail($_POST['email-form-signup']);
        $emailConfirm = sanitizeEmail($_POST['confirm-email-form-signup']);
        $phoneNumber = sanitizePhoneNumber($_POST['phone-number-form-signup']);
        $password = sanitizePassword($_POST['password-form-signup']);
        $passwordConfirm = sanitizePassword($_POST['confirm-password-form-signup']);
    
        $registerSuccessful = $account->register($firstName, $lastName, $email, $emailConfirm, $phoneNumber, $password, $passwordConfirm);
    
        if($registerSuccessful){
            $account->login($email, $password);
            $_SESSION['userLoggedIn'] = $account->getCurrentUserId();
            header("Location: index.php");
        }
    }
?>
<head>
  <title>Create an Account</title>
</head>

<section class="mbr-section form3 cid-rixMG5zlpO" id="form-signup">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    CREATE AN ACCOUNT</h2>
                
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                <form class="mbr-form" action="sign-up.php" method="POST"> 
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <?php echo $account->getError(Constants::$firstNameLengthError); ?>
                            <label for="firstname-form-signup">First Name*</label>
                            <input class="form-control" type="text" name="firstname-form-signup" placeholder="First Name" id="firstname-form-signup" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$lastNameLengthError); ?>
                            <label for="lastname-form-signup">Last Name*</label>
                            <input class="form-control" type="text" name="lastname-form-signup" placeholder="Last Name" id="lastname-form-signup" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$emailsDontMatchError); ?>
                            <?php echo $account->getError(Constants::$emailInvalidError); ?>
                            <?php echo $account->getError(Constants::$emailTaken); ?>
                            <label for="email-form-signup">Email Address*</label>
                            <input class="form-control" type="email" name="email-form-signup" placeholder="Email" id="email-form-signup" required>
                        </p>
                        <p>
                            <label for="confirm-email-form-signup">Confirm Email Address*</label>
                            <input class="form-control" type="email" name="confirm-email-form-signup" placeholder="Confirm Email" id="confirm-email-form-signup" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$invalidPhoneNumberError); ?>
                            <label for="phone-number-form-signup">Phone Number*</label>
                            <input class="form-control" type="text" name="phone-number-form-signup" placeholder="Phone Number" id="phone-number-form-signup" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constants::$passwordsDontMatchError); ?>
                            <?php echo $account->getError(Constants::$passwordLengthError); ?>
                            <label for="password-form-signup">Password*</label>
                            <input class="form-control" type="password" name="password-form-signup" placeholder="Password" id="password-form-signup" required>
                        </p>
                        <p>
                            <label for="confirm-password-form-signup">Confirm Password*</label>
                            <input class="form-control" type="password" name="confirm-password-form-signup" placeholder="Confirm Password" id="confirm-password-form-signup" required>
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button type="submit" name="signupButton" class="btn btn-primary display-4">SIGN UP</button>
                        </div>
                    </div>
                </form>
                    <p class="login-extra display-4">Already Have An Account? <a href="login.php" class="login-extra-link">Log In.</a></p>
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>