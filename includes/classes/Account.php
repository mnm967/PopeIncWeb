<?php 
    class Account{
        private $sqlConnection;
        private $errorArray;
        public $currentUserId = -1;
        public function __construct($sqlConnection){
            $this->sqlConnection = $sqlConnection;
            $this->errorArray = array();
        }
        public function getCurrentUserId(){
            return $this->currentUserId;
        }
        public function login($email, $password){
            $password = md5($password);

            $result = mysqli_query($this->sqlConnection, "SELECT * FROM users WHERE email='$email' AND password='$password'");
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result);
                $this->currentUserId = $row['id'];
                return true;
            }else{
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }
        public function adminLogin($email, $password){
            $password = md5($password);

            $result = mysqli_query($this->sqlConnection, "SELECT * FROM users WHERE email='$email' AND password='$password' AND id='3'");
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result);
                $this->currentUserId = $row['id'];
                return true;
            }else{
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }
        public function register($firstName, $lastName, $email, $emailConfirm, $phoneNumber, $password, $passwordConfirm){
            $this->validateFirstName($firstName);
            $this->validateLastname($lastName);
            $this->validateEmails($email, $emailConfirm);
            $this->validatePhoneNumber($phoneNumber);
            $this->validatePasswords($password, $passwordConfirm);

            if(empty($this->errorArray)){
                if($this->insertUser($firstName, $lastName, $email, $phoneNumber, $password)){
                    $query = mysqli_query($this->sqlConnection, "SELECT * FROM users WHERE email='$email' AND password='$password'");
                    $row = mysqli_fetch_array($query); 
                    $this->currentUserId = $row['id'];
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        private function insertUser($firstName, $lastName, $email, $phoneNumber, $password){
            $encryptedPassword = md5($password);
            $date = date("Y-m-d");

            $result = mysqli_query($this->sqlConnection, "INSERT INTO users VALUES ('', '$firstName', '$lastName', '$email', '$phoneNumber','$encryptedPassword', '$date', '[]', '[]', '[]', '', '')");
            return $result;
        }
        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }
        private function validateFirstName($firstName){
            if(strlen($firstName) > 25 || strlen($firstName) < 2){
                array_push($this->errorArray, Constants::$firstNameLengthError);
                return;
            }
        }
        private function validateLastname($lastName){
            if(strlen($lastName) > 25 || strlen($lastName) < 2){
                array_push($this->errorArray, Constants::$lastNameLengthError);
                return;
            }
        }
        private function validateEmails($email, $email2){
            if($email != $email2){
                array_push($this->errorArray, Constants::$emailsDontMatchError);
                return;
            }
            if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
                array_push($this->errorArray, Constants::$emailInvalidError);
                return;
            }
            $existsCheck = mysqli_query($this->sqlConnection, "SELECT email FROM users WHERE email='$email'");
            if(mysqli_num_rows($existsCheck) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }
        private function validatePhoneNumber($phoneNumber){
            if(preg_match('/^[0-9]{10}+$/', $phoneNumber) == false){
                array_push($this->errorArray, Constants::$invalidPhoneNumberError);
            }
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
    }
?>