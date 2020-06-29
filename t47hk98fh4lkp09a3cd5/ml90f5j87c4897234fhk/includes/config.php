<?php 
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Africa/Johannesburg");

    $sqlConnection = mysqli_connect("localhost", "root", "", "stylish");
    if(mysqli_connect_errno()){
        echo "Failed to Connect to Server: ".mysqli_connect_errno();
    }
?>