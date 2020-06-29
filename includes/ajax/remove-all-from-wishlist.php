<?php
    include("../config.php");
    include("../classes/User.php");

    if(isset($_POST['userId'])){
        $userId = $_POST['userId'];

        $query = mysqli_query($sqlConnection, "UPDATE users SET wishlistIdsJSON='[]' WHERE id='$userId'");
        echo 'true';
    }else{
        echo 'false';
    }
?>