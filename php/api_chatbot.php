<?php

require_once './lib/parsejson.php';

$param = [
    "input" => [
        "text" => $_POST['text_in'],
    ]
];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://gateway-wdc.watsonplatform.net/assistant/api/v1/workspaces/{workspace_id}/message?version=2019-02-28');//replace with your workspace_id
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . '{apikey}');

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$rep = bot_parse($result);
echo $rep;
