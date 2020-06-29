<?php 
    include("includes/header.php");?>
<?php
    include("includes/classes/Constants.php");
    
    if(isset($_SESSION['userLoggedIn'])){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: login.php");
    }

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
    
    if(isset($_POST['detailsButton'])){
        $firstName = sanitizeName($_POST['firstname-form-details']);
        $lastName = sanitizeName($_POST['lastname-form-details']);
        $email = sanitizeEmail($_POST['email-form-details']);
        $currentEmail = $user->getEmail();
        $phoneNumber = sanitizePhoneNumber($_POST['phone-number-form-details']);
        $password = sanitizePassword($_POST['password-form-details']);
        $newPassword = null;
        $confirmNewPassword = null;
        if(trim($_POST['new-password-form-details']) != ""){
            $newPassword = sanitizePassword($_POST['new-password-form-details']);
            $confirmNewPassword = sanitizePassword($_POST['confirm-password-form-details']);
        }
    
        $updateSuccessful = $user->updateDetails($_SESSION['userLoggedIn'], $firstName, $lastName, $currentEmail, $email, $phoneNumber, $password, $newPassword, $confirmNewPassword);
    
        if($updateSuccessful){
            header("Location: account.php");
        }
    }
?>
<head>
  <title>My Details</title>
</head>
<section class="mbr-section form3 cid-rixMG5zlpO" id="form-details">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    UPDATE DETAILS</h2>
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                <form class="mbr-form" action="user-details.php" method="POST"> 
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <?php echo $user->getError(Constants::$firstNameLengthError); ?>
                            <label for="firstname-form-details">First Name*</label>
                            <input class="form-control" type="text" name="firstname-form-details" placeholder="First Name" id="firstname-form-details" value="<?php echo $user->getFirstName()?>" required>
                        </p>
                        <p>
                            <?php echo $user->getError(Constants::$lastNameLengthError); ?>
                            <label for="lastname-form-details">Last Name*</label>
                            <input class="form-control" type="text" name="lastname-form-details" placeholder="Last Name" id="lastname-form-details" value="<?php echo $user->getLastName()?>" required>
                        </p>
                        <p>
                            <?php echo $user->getError(Constants::$emailsDontMatchError); ?>
                            <?php echo $user->getError(Constants::$emailInvalidError); ?>
                            <?php echo $user->getError(Constants::$emailTaken); ?>
                            <label for="email-form-details">Email Address*</label>
                            <input class="form-control" type="email" name="email-form-details" placeholder="Email" id="email-form-details"value="<?php echo $user->getEmail()?>" required>
                        </p>
                        <p>
                            <?php echo $user->getError(Constants::$invalidPhoneNumberError); ?>
                            <label for="phone-number-form-details">Phone Number*</label>
                            <input class="form-control" type="text" name="phone-number-form-details" placeholder="Phone Number" id="phone-number-form-details"value="<?php echo $user->getPhoneNumber()?>" required>
                        </p>
                        <p>
                            <?php echo $user->getError(Constants::$passwordIncorrect); ?>
                            <label for="password-form-details">Current Password*</label>
                            <input class="form-control" type="password" name="password-form-details" placeholder="Current Password" id="password-form-details" required>
                        </p>
                        <p>
                            <?php echo $user->getError(Constants::$passwordsDontMatchError); ?>
                            <?php echo $user->getError(Constants::$passwordLengthError); ?>
                            <label for="new-password-form-details">New Password (Optional)</label>
                            <input class="form-control" type="password" name="new-password-form-details" placeholder="New Password" id="password-form-details">
                        </p>
                        <p>
                            <label for="confirm-password-form-details">Confirm Password (Optional)</label>
                            <input class="form-control" type="password" name="confirm-password-form-details" placeholder="Confirm New Password" id="confirm-password-form-details">
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button type="submit" name="detailsButton" class="btn btn-primary display-4">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include("includes/footer.php");?>