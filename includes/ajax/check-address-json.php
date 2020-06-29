<?php

        $streetNumber = $_POST['streetNumber'];
        $streetName = $_POST['streetName'];
        $suburb = $_POST['suburb'];
        $city = $_POST['city'];
        $postCode = $_POST['postCode'];
        $state = $_POST['state'];
        $country = $_POST['country'];

        $fullAddress = "$streetNumber%20$streetName,%20$suburb,%20$city,%20$postCode,%20$state,%20$country";
        $fullAddress = str_replace(" ", "%20", $fullAddress);

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            "http"=>array(
                "header" =>"User-Agent: Mozilla/5.0 (Windows;U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13"
            )
        );

        $q_array = array(
            'WeightInKg' => '30',
            'FullAddress' => $fullAddress,
            'api_key' => '72ccc083093d345462d98f9dfd1589d3',
        );
        $query = http_build_query($q_array);
        $city = str_replace(" ", "%20", $city);
        $url = "https://api.fastway.org/v4/psc/lookup/PTG/".$city."/".$postCode."?".$query;
        //$url = "https://api.fastway.org/v4/psc/lookup/PTG/$suburb/$postCode?WeightInKg=30&amp;FullAddress=$fullAddress&amp;api_key=72ccc083093d345462d98f9dfd1589d3";
        //$url = "https://api.fastway.org/v4/psc/listrfs?CountryCode=24&api_key=72ccc083093d345462d98f9dfd1589d3";
        $url = html_entity_decode($url);
        $contents = file_get_contents($url, false, stream_context_create($arrContextOptions));

        if($contents !== false){
            echo $contents;
        }else{
            echo null;
        }
?>