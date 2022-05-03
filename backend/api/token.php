<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function encodes a string using the uuencode algorithm. 
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
// Function to generate JSON Web Token.
function generateJWToken(){
    $JwtHeader = [
              'typ' => 'JWT',
              'alg' => 'HS256'
    ];
    // Returns the JSON representation of the header
    $header = json_encode($JwtHeader);
    //encodes the $header with base64.	
    $header = base64_encode($header);
    
    $CLIENT_KEY = "574e9065c2fa2718b8d8d354cc2a638e3652281e";
    $AUD_VALUE = "https://app.iformbuilder.com/exzact/api/oauth/token";
    $CLIENT_SECRET = "3faf649de26ac5b42ecaff96d9797a5f66a8af4b";
    $nowtime = time();
    $exptime = $nowtime + 599;

    // Payload
    $payload = "{
        \"iss\": \"$CLIENT_KEY\",
       \"aud\": \"$AUD_VALUE\",
      \"exp\": $exptime,
      \"iat\": $nowtime}";	
    $payload = base64url_encode($payload);
    
    // Signature key
    $signature = base64url_encode(hash_hmac('sha256',"$header.$payload",$CLIENT_SECRET, true));
    // assertion value
    $assertionValue = "$header.$payload.$signature";
    // Grant Type data
    $grant_type = "urn:ietf:params:oauth:grant-type:jwt-bearer";
    $grant_type = urlencode($grant_type);
    $postField= "grant_type=".$grant_type."&assertion=".$assertionValue;	
    // Curl Start
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $AUD_VALUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS,"$postField");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/x-www-form-urlencoded",
      "cache-control: no-cache"
    ));
    $response = curl_exec($ch);
    //$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    // Curl End
    curl_close($ch);
    $tokenArray = json_decode($response,true);
    // Value returned as acces token.
    return $token = $tokenArray['access_token'];
}

