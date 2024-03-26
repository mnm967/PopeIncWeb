<?php 
    header('HTTP/1.0 200 OK');
?>
<?php
    include("includes/config.php");
    include("includes/classes/User.php");
    include("includes/classes/Item.php");

    define( 'SANDBOX_MODE', true );
    $pfHost = SANDBOX_MODE ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
    // Posted variables from ITN
    $pfData = $_POST;

    // Strip any slashes in data
    foreach($pfData as $key => $val){
        $pfData[$key] = stripslashes( $val );
    }
    $pfParamString = "";
    foreach($pfData as $key => $val){
        if($key != 'signature'){
            $pfParamString .= $key .'='. urlencode( $val ) .'&';
        }
    }
    // Remove the last '&' from the parameter string
    $pfParamString = substr($pfParamString, 0, -1);
    $pfTempParamString = $pfParamString;
    // Passphrase stored in website database
    $passPhrase = '';

    if(!empty($passPhrase)){
        $pfTempParamString .= '&passphrase='.urlencode( $passPhrase );
    }
    $signature = md5($pfTempParamString);
    if($signature!=$pfData['signature']){
        die('Invalid Signature');
    }

    $validHosts = array(
        'www.payfast.co.za',
        'sandbox.payfast.co.za',
        'w1w.payfast.co.za',
        'w2w.payfast.co.za',
    );
    $validIps = array();
    foreach($validHosts as $pfHostname){
        $ips = gethostbynamel($pfHostname);
        if( $ips !== false ){
            $validIps = array_merge( $validIps, $ips );
        }
    }
    
    // Remove duplicates
    $validIps = array_unique( $validIps );
    
    if(!in_array($_SERVER['REMOTE_ADDR'], $validIps)){
        die('Source IP not Valid');
    }

    $url = 'https://'. $pfHost .'/eng/query/validate';

    $ch = curl_init();

    // Set cURL options - Use curl_setopt for greater PHP compatibility
    // Base settings
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );      
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );

    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $pfParamString );

    $response = curl_exec( $ch );
    curl_close( $ch );

    $lines = explode( "\r\n", $response );
    $verifyResult = trim( $lines[0] );

    if( strcasecmp($verifyResult, 'VALID') != 0 ){
        die('Data not valid');
    }

    $pfData = array('pf_payment_id' => '1234', 'payment_status' => 'COMPLETE');
    $pfPaymentId = $pfData['pf_payment_id'];

    $userId = $_SESSION['userLoggedIn'];
    $existsCheck = mysqli_query($sqlConnection, "SELECT id FROM orders WHERE payfastId='$pfPaymentId' AND userId='$userId'");
    if(mysqli_num_rows($existsCheck) != 0){
        die('Payment Already Processed');
    }
    if($pfData['payment_status'] == 'COMPLETE'){
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
        $dateOrdered = date("Y-m-d");
        $address = $_SESSION['address'];
        $totalCost = $_SESSION['totalCost'];
        $deliveryCost = $_SESSION['parcelPrice'];
        $recipientName = $_SESSION['recipientName'];
        $recipientNumber = $_SESSION['recipientNumber'];
        $items = $user->getCartIdsJSON();

        $query = mysqli_query($sqlConnection, "INSERT INTO orders VALUES ('', '$userId', '$pfPaymentId', '$items', '$dateOrdered', '0', '', '0', '', '$totalCost', '$deliveryCost', '$address', '$recipientName', '$recipientNumber')");
        $userQuery = mysqli_query($sqlConnection, "UPDATE users SET cartItemsJSON='[]' WHERE id='$userId'");
    }else{
        // If unknown status, do nothing (which is the safest course of action)
    }
?>