<?php 
    class User{
        private $sqlConnection;
        private $id;
        private $errorArray;

        function __construct($sqlConnection, $id){
            $this->sqlConnection = $sqlConnection;
            $this->id = $id;
            $this->errorArray = array();
        }
        function getId(){
            return $this->id;
        }
        function getEmail(){
            $query = mysqli_query($this->sqlConnection, "SELECT email FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['email'];
        }
        function getFirstName(){
            $query = mysqli_query($this->sqlConnection, "SELECT firstName FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['firstName'];
        }
        function getPhoneNumber(){
            $query = mysqli_query($this->sqlConnection, "SELECT phoneNumber FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['phoneNumber'];
        }
        function getLastName(){
            $query = mysqli_query($this->sqlConnection, "SELECT lastName FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['lastName'];
        }
        function getName(){
            $query = mysqli_query($this->sqlConnection, "SELECT concat(firstName, ' ', lastName) as name FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }
        function getCartIdsJSON(){
            $query = mysqli_query($this->sqlConnection, "SELECT cartItemsJSON FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['cartItemsJSON'];
        }
        function getOrderIdsJSON(){
            $query = mysqli_query($this->sqlConnection, "SELECT orderIdsJSON FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['orderIdsJSON'];
        }
        function getWishlistIdsJSON(){
            $query = mysqli_query($this->sqlConnection, "SELECT wishlistIdsJSON FROM users WHERE id='$this->id'");
            $row = mysqli_fetch_array($query);
            return $row['wishlistIdsJSON'];
        }
        function isItemInCart($itemId){
            $cartItems = json_decode($this->getCartIdsJSON(), true);
            foreach($cartItems as $item){
                if($item['id'] == $itemId) return true;
            }
            return false;
        }
        function getItemCartSize($itemId){
            $cartItems = json_decode($this->getCartIdsJSON(), true);
            foreach($cartItems as $item){
                if($item['id'] == $itemId) return $item['size'];
            }
        }
        function isItemInWishlist($itemId){
            $wishlistItems = json_decode($this->getWishlistIdsJSON(), true);
            foreach($wishlistItems as $item){
                if($item == $itemId) return true;
            }
            return false;
        }
       
        public function updateDetails($userId, $firstName, $lastName, $currentEmail, $email, $phoneNumber, $password, $newPassword, $confirmNewPassword){
            $this->validateFirstName($firstName);
            $this->validateLastname($lastName);
            $this->validateEmails($email, $currentEmail);
            $this->validatePhoneNumber($phoneNumber);
            if($newPassword != null){
                $this->validatePasswords($newPassword, $confirmNewPassword);
            }
            if(empty($this->errorArray)){
                if($this->checkPassword($userId, $password) == false){
                    return false;
                }
                if($newPassword != null){
                    $newPassword = md5($newPassword);
                    $query = mysqli_query($this->sqlConnection, "UPDATE users SET firstName='$firstName', lastName='$lastName', phoneNumber='$phoneNumber', email='$email', password='$newPassword' WHERE id='$userId'");
                }else{
                    $query = mysqli_query($this->sqlConnection, "UPDATE users SET firstName='$firstName', lastName='$lastName', phoneNumber='$phoneNumber', email='$email' WHERE id='$userId'");
                }
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
        private function checkPassword($userId, $password){
            $password = md5($password);
            $result = mysqli_query($this->sqlConnection, "SELECT * FROM users WHERE id='$userId' AND password='$password'");
            if(mysqli_num_rows($result) != 1){
                array_push($this->errorArray, Constants::$passwordIncorrect);
                return false;
            }
            return true;
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
        private function validateEmails($email, $currentEmail){
            if($email == $currentEmail){
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