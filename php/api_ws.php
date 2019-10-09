<?php
require_once 'lib/parsejson.php';

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    die;
} else {
    $filename = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
}

$ch = curl_init();
$files = array(
    __DIR__ . '/uploads/' . $filename,
);
$postfields = array();

foreach ($files as $index => $file) {
    if (function_exists('curl_file_create')) { // For PHP 5.5+
        $file = curl_file_create($file);
    } else {
        $file = '@' . realpath($file);
    }
    $postfields["file_$index"] = $file;
}

$headers = array("Content-Type" => "multipart/form-data");
curl_setopt($ch, CURLOPT_URL, 'https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?version=2018-03-19');
curl_setopt($ch, CURLOPT_USERPWD, 'apikey' . ':' . '{apikey}');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

$tab = ws_parse($result);
curl_close($ch);
//curl -X POST -u "apikey:2XjUr82yI0EoKGgKDBLbePW1p65jcNgCJ2RhbQjQWlNk" -F "images_file=@hook.png" -F "threshold=0.6" -F "classifier_ids=default" "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?version=2018-03-19"
//curl -u "apikey:2XjUr82yI0EoKGgKDBLbePW1p65jcNgCJ2RhbQjQWlNk" "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify?url=https://watson-developer-cloud.github.io/doc-tutorial-downloads/visual-recognition/hook.png&version=2018-03-19&classifier_ids=default"
?>
<div class="row">
    <div class="col-sm-6 offset-1" style="padding-top: 30px">
        <img style="width: 100%;" src="php/uploads/<?= $filename ?>">
    </div>
    <div class="col-sm-5" style="padding-top: 30px">
        <ul class="list-group">
            <?php
            if ($tab != null) {
                foreach ($tab as $item):
                    ?>
                    <li class="list-group-item">
                        <?= $item->class ?>
                        <span class="badge badge-pill badge-info" style="float: right">
                            <?= number_percent($item->score) ?>
                        </span>
                    </li>
                    <?php
                endforeach;
            }
            ?>
        </ul>
    </div>
</div>