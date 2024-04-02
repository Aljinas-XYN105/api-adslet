<?php

function send_ooredoo_sms($sender_id, $phonenumber, $textmessage, $msg_type = 1){
    $customerID = "2369"; // for Ooredoo varification
    $userName = "NORTHPOINTAPI"; // for Ooredoo varification
    $password = "e7e@hoAr4fG"; // for Ooredoo varification
    if($msg_type == 1){ // Send English message
        $msgType = "Latin";
        $url = 'https://messaging.ooredoo.qa/bms/soap/Messenger.asmx/HTTP_SendSms';
    }else{ // Send Arabic messag
        $msgType = "ArabicWithLatinNumbers";
        $url = 'https://messaging.ooredoo.qa/bms/soap/Messenger.asmx/HTTP_SendSms';
    }
    $data = array(
        'customerID' => $customerID,
        'userName' => $userName,
        'userPassword' => $password,
        'originator' => $sender_id,
        'smsText' => $textmessage,
        'recipientPhone' => $phonenumber,
        'messageType' => $msgType,
        'defDate' => '',
        'blink' => 'false',
        'flash' => 'false',
        'Private' => 'false'
    );
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded'
    );
    $response = curlRequest($url, $data, $headers, 'GET');
    // Check for errors or handle the response
    if (isset($response['error'])) {
        echo "Error: " . $response['error'];
    } else {
        echo "Response: " . $response['response'];
    }
}

function curlRequest($url, $data = array(), $headers = array(), $method = 'GET') {
    // Append data to URL if method is GET
    if ($method == 'GET' && !empty($data)) {
        $url .= '?' . http_build_query($data);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    if ($method != 'GET') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return array('error' => $error);
    }
    $info = curl_getinfo($ch);
    curl_close($ch);
    return array(
        'response' => $response,
        'info' => $info
    );
}

function processXmlResponse($xml){
    if($xml === false){
        echo "Failed to load XML: ";
        foreach(libxml_get_errors() as $error) {
            echo "<br>", $error->message;
        }
    }else{
        // Extract values
        $to = (string) $xml->to;
        $from = (string) $xml->from;
        $heading = (string) $xml->heading;
        $body = (string) $xml->body;
        // Output extracted values
        echo "To: $to\n";
        echo "From: $from\n";
        echo "Heading: $heading\n";
        echo "Body: $body\n";
    }
}