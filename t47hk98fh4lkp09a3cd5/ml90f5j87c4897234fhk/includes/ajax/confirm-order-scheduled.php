<?php
    include("../config.php");

    $orderId = $_POST['orderId'];
    $date = date("Y-m-d");

    $query = mysqli_query($sqlConnection, "UPDATE orders SET isDeliveryScheduled='1', deliveryScheduledDate='$date'  WHERE id='$orderId'");
    echo 'true';
?>