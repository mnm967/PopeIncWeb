<?php
    include("../config.php");
    include("../classes/User.php");

    if(isset($_POST['userId']) && isset($_POST['itemId'])){
        $userId = $_POST['userId'];
        $itemId = $_POST['itemId'];

        $user = new User($sqlConnection, $userId);
        $cartItems = json_decode($user->getCartIdsJSON(), true);
        /*if (($key = array_search($itemId, $cartItems)) !== false) {
            unset($cartItems[$key]);
        }*/
        for($i = 0; $i < count($cartItems); $i++){
            $item = $cartItems[$i];
            if($item['id'] == $itemId){
                unset($cartItems[$i]);
                break;
            }
        }
        $newItemsJSON = json_encode($cartItems);
        $query = mysqli_query($sqlConnection, "UPDATE users SET cartItemsJSON='$newItemsJSON' WHERE id='$userId'");
        echo 'true';
    }else{
        echo 'false';
    }
?>