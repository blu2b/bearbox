# simple request for telekom api to send a sms
# script is part of another script to alert via sms

<?php
	//save input arguments into variables
	$callee = $argv[1];
	$msg = $argv[2];

	//API Url
	$url = '$API_URL';

	//initiate cURL
	$ch = curl_init($url);

	//JSON data
	$jsonData = array (
  'messages' => array (
    'authentication' => array (
      'productToken' => '$PRODUCT_TOKEN',
    ),
    'msg' => array (
      0 => array (
        'body' => array (
          'type' => 'auto',
          'content' => $msg,
        ),
        'to' => array (
          0 => array (
            'number' => $callee,
          ),
        ),
        'from' => '$FROM',
        'allowedChannels' => array (
          0 => 'SMS',
        ),
      ),
    ),
  ),
);

	//Encode array into JSON
	$jsonDataEncoded = json_encode($jsonData);

	//Tell cURL that we want to send a POST request
	curl_setopt($ch, CURLOPT_POST,1);

	//Attach our encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

	//return transfer as string instead of printing it
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//define header
	$headers = array(
	'Content-Type: application/json'
);

	//Set the content type to application/jsonData
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	//Execute the request
	curl_exec($ch);

	curl_close($ch);
?>
