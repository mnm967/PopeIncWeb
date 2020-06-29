<?php 
class Constants{
    public static $usernameLengthError = "Your username must be between 5 and 25 characters";
    public static $usernameTaken = "This Username already exists";
    public static $firstNameLengthError = "Your First Name must be between 2 and 25 characters";
    public static $lastNameLengthError = "Your Last Name must be between 2 and 25 characters";
    public static $emailsDontMatchError = "Your Emails don't match";
    public static $emailInvalidError = "Email is invalid";
    public static $emailTaken = "This Email is already in use";
    public static $invalidPhoneNumberError = "You entered an invalid Phone Number";
    public static $passwordsDontMatchError = "Your Passwords don't match";
    public static $passwordLengthError = "Your Password must be between 5 and 30 characters";

    public static $loginFailed = "Your Email or Password is incorrect";

    public static $mensClothingDescription = "The most stylish clothing for Men.";
    public static $mensShoesDescription = "The most stylish shoes for Men.";
    public static $womensClothingDescription = "The most stylish clothing for Women.";
    public static $womensShoesDescription = "The most stylish shoes for Women.";
    public static $accessoriesDescription = "The most stylish accessories for Everyone.";

    public static $emailNotFound = "This email does not exist in our database.";
    public static $tokenSent = "We've sent a reset token to your email which will expire in 2 hours.";
    public static $emailNotSent = "Unfortunately we were unable to send your Reset Token. Please try again later.";

    public static $passwordIncorrect = "You have entered the incorrect password.";
}
?>