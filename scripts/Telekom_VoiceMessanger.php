# simple request for telekom api to call a number and read a text
# script is part of another script to alert via voice message

<?php
	//save input arguments into variables
	$callee = $argv[1];
	$msg = $argv[2];

	//API Url
	$url = 'https://api.cmtelecom.com/voiceapi/v2/Notification';

	//initiate cURL
	$ch = curl_init($url);

	//JSON data
	$jsonData = array(
	'callee' => $callee,
	'caller' => '004917631122841',
	'prompt' => $msg,
	'prompt-type' => 'TTS',
	'voicemail-response' => 'Ignore',
	'max-replays' => 2,
	'auto-replay' => false,
	'replay-prompt' => "Drücke die 1 um die Nachricht zu wiederholen.",
	'voice' => array(
		'language' => 'de-DE',
		'gender' => 'female',
		'number' => 1,
		'volume' => 2
	)
	);
	//Encode array into JSON
	$jsonDataEncoded = json_encode($jsonData);

	//Tell cURL that we want to send a POST request
	curl_setopt($ch, CURLOPT_POST,1);

	//Attach our encoded JSOn string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

	//return transfer as string instead of printing it
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//define header
	$headers = array(
	'Content-Type: application/json',
	'X-CM-PRODUCTTOKEN: 7d8045b4-1592-4b88-9753-9cda5c0d9aaf'
	);

	//Set the content type to application/jsonData
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	//Execute the request
	curl_exec($ch);

	curl_close($ch);
?>
