<?php
    include("../config.php");
    include("../classes/User.php");

    if(isset($_POST['userId']) && isset($_POST['itemId']) && isset($_POST['size'])){
        $userId = $_POST['userId'];
        $itemId = $_POST['itemId'];
        $size = $_POST['size'];

        $user = new User($sqlConnection, $userId);
        $cartItems = json_decode($user->getCartIdsJSON(), true);
        for($i = 0; $i < count($cartItems); $i++){
            $item = $cartItems[$i];
            if($item['id'] == $itemId){
                $cartItems[$i]['size'] = $size;
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