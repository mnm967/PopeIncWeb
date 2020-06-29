<?php
    include("../config.php");

    $orderId = $_POST['orderId'];
    $date = date("Y-m-d");

    $query = mysqli_query($sqlConnection, "UPDATE orders SET isDelivered='1', dateDelivered='$date'  WHERE id='$orderId'");
    echo 'true';
?>