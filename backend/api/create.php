<?php include_once('token.php');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$FormData = json_decode(file_get_contents("php://input"),true);

if(!empty($FormData)){
  
  $postFieldData = '{"fields":[{"element_name":"cf_message","value":"'.$FormData['cf_message'].'"},{"element_name":"cf_phone","value":"'.$FormData['cf_phone'].'"},{"element_name":"cf_email","value":"'.$FormData['cf_email'].'"},{"element_name":"cf_name","value":"'.$FormData['cf_name'].'"}]}';

  //generating a Token for access
  $JWToken = generateJWToken();

  $createRecordApiUrl = "https://app.iformbuilder.com/exzact/api/v60/profiles/504436/pages/3861796/records";

  $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $createRecordApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldData);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "cache-control: no-cache",
        "Authorization: Bearer $JWToken"
    )); 

    $response = curl_exec($ch); 
    
    curl_close($ch);

    $sucess = ['message' => "Data stored successfully!"];

    echo json_encode($sucess);
}



