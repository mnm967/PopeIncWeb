<?php
    include("../config.php");
    include("../classes/User.php");

    $_SESSION['address'] = $_POST['address'];
    $_SESSION['parcelPrice'] = $_POST['parcelPrice'];
    $_SESSION['totalCost'] = $_POST['totalCost'];
    $_SESSION['recipientName'] = $_POST['recipientName'];
    $_SESSION['recipientNumber'] = $_POST['recipientNumber'];

    echo 'true';

?>