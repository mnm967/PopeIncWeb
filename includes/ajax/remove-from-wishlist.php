<?php
    include("../config.php");
    include("../classes/User.php");

    if(isset($_POST['userId']) && isset($_POST['itemId'])){
        $userId = $_POST['userId'];
        $itemId = $_POST['itemId'];

        $user = new User($sqlConnection, $userId);
        $wishlistItems = json_decode($user->getWishlistIdsJSON(), true);
        if (($key = array_search($itemId, $wishlistItems)) !== false) {
            unset($wishlistItems[$key]);
        }
        $newItemsJSON = json_encode($wishlistItems);
        $query = mysqli_query($sqlConnection, "UPDATE users SET wishlistIdsJSON='$newItemsJSON' WHERE id='$userId'");
        echo 'true';
    }else{
        echo 'false';
    }
?>