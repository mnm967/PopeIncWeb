<?php
    include("../config.php");
    include("../classes/User.php");

    if(isset($_POST['userId']) && isset($_POST['itemId']) && isset($_POST['size'])){
        $userId = $_POST['userId'];
        $itemId = $_POST['itemId'];
        $size = $_POST['size'];

        $user = new User($sqlConnection, $userId);
        $cartItems = json_decode($user->getCartIdsJSON(), true);
        $jsonObject = array('id' => $itemId, 'size' => $size);
        array_push($cartItems, $jsonObject);
        //array_push($cartItems, "{'id':'$itemId','size':'$size'},");
        $newItemsJSON = json_encode($cartItems);
        //echo $newItemsJSON;
        $query = mysqli_query($sqlConnection, "UPDATE users SET cartItemsJSON='$newItemsJSON' WHERE id='$userId'");
        echo 'true';
    }else{
        echo 'false';
    }
?>