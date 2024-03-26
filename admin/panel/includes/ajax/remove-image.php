<?php
    include("../config.php");

    $itemId = $_POST['itemId'];
    $img = $_POST['img'];

    $query = mysqli_query($sqlConnection, "SELECT images FROM items WHERE id='$itemId'");
    $row = mysqli_fetch_array($query);
    $images = json_decode($row['images'], true);

    for($i = 0; $i < count($images); $i++){
        if($images[$i] == $img){
            unset($images[$i]);
        }
    }

    $newJSON = json_encode($images);
    $newQuery = mysqli_query($sqlConnection, "UPDATE items SET images='$newJSON'  WHERE id='$itemId'");
    echo 'true';
?>