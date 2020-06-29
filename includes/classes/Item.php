<?php 
    class Item{
        private $con;
        private $id;
        private $name;
        private $description;
        private $brand;
        private $price;
        private $gender;
        private $type;
        private $images;
        private $additionalInfoJSON;
        private $availableClothingSizes;
        private $availableShoeSizes;
        private $isAvailable;
        private $mySqliData;

        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
            
            $query = mysqli_query($this->con, "SELECT * FROM items WHERE id='$this->id'");
            $this->mySqliData = mysqli_fetch_array($query);

            $this->name = $this->mySqliData['name'];
            $this->brand = $this->mySqliData['brand'];
            $this->description = $this->mySqliData['description'];
            $this->images = $this->mySqliData['images'];
            $this->gender = $this->mySqliData['gender'];
            $this->type = $this->mySqliData['type'];
            $this->price = $this->mySqliData['price'];
            $this->additionalInfoJSON = $this->mySqliData['additionalInfoJSON'];
            $this->availableClothingSizes = $this->mySqliData['availableClothesSizes'];
            $this->availableShoeSizes = $this->mySqliData['availableShoeSizes'];
            $this->isAvailable = $this->mySqliData['isAvailable'];
        }
        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function getBrand(){
            return $this->brand;
        }
        public function getDescription(){
            return $this->description;
        }
        public function getImagesJSON(){
            return $this->images;
        }
        public function getPrice(){
            return $this->price;
        }
        public function getGender(){
            return $this->gender;
        }
        public function getType(){
            return $this->type;
        }
        public function isAvailable(){
            if($this->isAvailable == 0){
                return false;
            }else{
                return true;
            }
        }
        public function getAdditionalInfoJSON(){
            return $this->additionalInfoJSON;
        }
        public function getAvilableClothesSizesJSON(){
            return $this->availableClothingSizes;
        }
        public function getAvailableShoeSizesJSON(){
            return $this->availableShoeSizes;
        }
        public function getData(){
            return $this->mySqliData;
        }
    }
?>