<?php 
    class Order{
        private $con;
        private $id;
        private $userId;
        private $payfastId;
        private $items;
        private $dateOrdered;
        private $isDeliveryScheduled;
        private $deliveryScheduledDate;
        private $isDelivered;
        private $dateDelivered;
        private $totalCost;
        private $deliveryCost;
        private $shippingAddress;
        private $recipientName;
        private $recipientNumber;
        private $mySqliData;

        public function __construct($con, $id, $userId){
            $this->con = $con;
            $this->id = $id;
            $this->userId = $userId;
            
            $query = mysqli_query($this->con, "SELECT * FROM orders WHERE id='$this->id' AND userId='$this->userId'");
            $this->mySqliData = mysqli_fetch_array($query);

            $this->payfastId = $this->mySqliData['payfastId'];
            $this->items = $this->mySqliData['items'];
            $this->dateOrdered = $this->mySqliData['dateOrdered'];
            $this->isDeliveryScheduled = $this->mySqliData['isDeliveryScheduled'];
            $this->deliveryScheduledDate = $this->mySqliData['deliveryScheduledDate'];
            $this->isDelivered = $this->mySqliData['isDelivered'];
            $this->dateDelivered = $this->mySqliData['dateDelivered'];
            $this->totalCost = $this->mySqliData['totalCost'];
            $this->deliveryCost = $this->mySqliData['deliveryCost'];
            $this->shippingAddress = $this->mySqliData['shippingAddress'];
            $this->recipientName = $this->mySqliData['recipientName'];
            $this->recipientNumber = $this->mySqliData['recipientNumber'];
        }
        public function getId(){
            return $this->id;
        }
        public function getUserId(){
            return $this->userId;
        }
        public function getItemsJSON(){
            return $this->items;
        }
        public function getTotalCost(){
            return $this->totalCost;
        }
        public function getDeliveryCost(){
            return $this->deliveryCost;
        }
        public function getShippingAddress(){
            return $this->shippingAddress;
        }
        public function getRecipientNumber(){
            return $this->recipientNumber;
        }
        public function getRecipientName(){
            return $this->recipientName;
        }
        public function getDateOrdered(){
            return $this->dateOrdered;
        }
        public function getDeliveryScheduledDate(){
            return $this->deliveryScheduledDate;
        }
        public function getDateDelivered(){
            return $this->dateDelivered;
        }
        public function isDeliveryScheduled(){
            if($this->isDeliveryScheduled == 0){
                return false;
            }else{
                return true;
            }
        }
        public function isDelivered(){
            if($this->isDelivered == 0){
                return false;
            }else{
                return true;
            }
        }
        public function getData(){
            return $this->mySqliData;
        }
    }
?>