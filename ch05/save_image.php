<?php
//save_image.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Photo.php';

//$photoid = '4285703';

$cmdarg = $_SERVER['argv'];
$photoid = $cmdarg[1];

$savedirectory = './images/';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die('invalid flickr logon');
}

$p = new Phlickr_Photo($api, $photoid);

$url = $p->buildImgUrl('o');

$imagefile = file_get_contents($url);

$localfile = $savedirectory.'myimage.jpg';
file_put_contents($localfile, $imagefile);

echo "file saved...";

?>
