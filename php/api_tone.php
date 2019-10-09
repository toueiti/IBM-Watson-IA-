<?php

require_once './lib/parsejson.php';
$ch = curl_init();
$param = [
    "text" => $_POST['text_in'],
];
curl_setopt($ch, CURLOPT_URL, 'https://gateway-lon.watsonplatform.net/tone-analyzer/api/v3/tone?version=2017-09-21');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
/* $post = array(
  'file' => '@' .realpath('tone.json')
  ); */
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . '{apikey}');//replace with your apikey

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$tab = tas_parse($result);
?>
<div class="row">
    <div class="col-sm-10 offset-1">
        <ul class="list-group">
            <li class="list-group-item active">
                Document
            </li>
            <?php foreach ($tab['doc'] as $item): ?>
                <li class="list-group-item">
                    <?= $item->tone_name ?>
                    <span class="badge badge-pill badge-info" style="float: right">
                        <?= number_percent($item->score) ?>
                    </span>
                </li> 
            <?php endforeach; ?>
        </ul>
        <ul class="list-group">
            <li class="list-group-item active">
                Sentences
            </li>
            <?php foreach ($tab['sentences'] as $item): ?>
                <li class="list-group-item">
                    <?= $item->text ?>
                    <ul>
                        <?php foreach ($item->tones as $elmt): ?>
                        <li>
                            <?= $elmt->tone_name ?>
                            <span class="badge badge-pill badge-info" style="float: right">
                                <?= number_percent($elmt->score) ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li> 
            <?php endforeach; ?>
        </ul>
    </div>
</div>

