<?php include_once('token.php');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');
header('Content-type: application/json');
$JWToken = generateJWToken();
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://app.iformbuilder.com/exzact/api/v60/profiles/504436/pages/3861796/records?fields=cf_name,cf_email,cf_phone,cf_message",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $JWToken"
    ),
));

$response = curl_exec($curl);

echo $response;
