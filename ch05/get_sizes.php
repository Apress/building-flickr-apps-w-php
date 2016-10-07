<?php
//get_sizes.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Photo.php';

$photoid = '19481086';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die('invalid flickr logon');
}

$p = new Phlickr_Photo($api, $photoid);

$sizes = $p->getSizes();
$rawtags = $p->getRawTags();
$tags = $p->getTags();

echo "The results of the getSizes() method are...\r\n";
print_r ( $p->getSizes());

echo "The results of the getRawTags() method are...\r\n";
print_r ($p->getRawTags());

echo "The results of the getTags() method are...\r\n";
print_r ($p->getTags());
?>
