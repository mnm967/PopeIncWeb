<?php 
    class ForgottenAccount{
        private $sqlConnection;
        private $errorArray;
        private $successArray;
        public $currentUserId = -1;
        public function __construct($sqlConnection){
            $this->sqlConnection = $sqlConnection;
            $this->errorArray = array();
            $this->successArray = array();
        }
        public function getCurrentUserId(){
            return $this->currentUserId;
        }
        public function sendToken($email){
            $this->checkEmail($email);
            if(empty($this->errorArray)){
                $timestamp = time();
                $permitted_chars = "0123456789abcdefghijklmnopqrstuvwxyz";
                $token = substr(str_shuffle($permitted_chars), 0, 20);
                $query = mysqli_query($this->sqlConnection, "UPDATE users SET forgottenPasswordToken='$token', forgottenPasswordTimestamp='$timestamp' WHERE email='$email'");
                
                $to = $email;
                $subject = "Pope.inc Password Reset";
                $message = "Click on the following link to Reset your Passaword: https://127.0.0.1/ClothingStore/password-reset.php?token=$token";
                $headers = "From: noreply@popeinc.co.za";
                
                if(mail($to, $subject, $message, $headers)){
                    array_push($this->successArray, Constants::$tokenSent);
                    return true;
                }else{
                    array_push($this->errorArray, Constants::$emailNotSent);
                    return false;
                }
            }else{
                return false;
            }
        }
        public function resetPassword($token, $password, $passwordConfirm){
            $this->validatePasswords($password, $passwordConfirm);
            if(empty($this->errorArray)){
                $query = mysqli_query($this->sqlConnection, "UPDATE users SET forgottenPasswordToken='', forgottenPasswordTimestamp='', password='$password' WHERE forgottenPasswordToken='$token'");
                return true;
            }else{
                return false;
            }
        }
        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }
        public function getSuccess($success){
            if(!in_array($success, $this->successArray)){
                $success = "";
            }
            return "<span class='successMessage'>$success</span>";
        }
        private function validatePasswords($password, $password2){
            if($password != $password2){
                array_push($this->errorArray, Constants::$passwordsDontMatchError);
                return;
            }
            if(strlen($password) > 30 || strlen($password) < 5){
                array_push($this->errorArray, Constants::$passwordLengthError);
                return;
            }
        }
        private function checkEmail($email){
            if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
                array_push($this->errorArray, Constants::$emailInvalidError);
                return;
            }
            $existsCheck = mysqli_query($this->sqlConnection, "SELECT email FROM users WHERE email='$email'");
            if(mysqli_num_rows($existsCheck) == 0){
                array_push($this->errorArray, Constants::$emailNotFound);
                return;
            }
        }
    }
?>