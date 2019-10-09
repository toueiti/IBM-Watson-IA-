<?php

$downloadFile = fopen('audio/out.wav', 'w');
$ch = curl_init();
$text_in = $_POST['text_in'];
$param = ["text"=>$text_in];
curl_setopt($ch, CURLOPT_URL, 'https://gateway-wdc.watsonplatform.net/text-to-speech/api/v1/synthesize');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . 'qgTkVgyxv-QGuvjy4Z1fO3LlKBhfaRwBX8BmL7A0nNph');

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: audio/wav';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FILE, $downloadFile);
// Follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);
fclose($downloadFile);
?>

<audio controls>
  <source src="php/audio/out.wav" type="audio/wav">
Your browser does not support the audio element.
</audio>

