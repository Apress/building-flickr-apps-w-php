<?php
//make_html.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Photo.php';

$savepath = '.';

$htmlfilename = 'photopage.html';

$photoid = '71738376';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die('invalid flickr logon');
}

$p = new Phlickr_Photo($api, $photoid);

$html = "<html>\r\n";
$html = $html."<br/>\n";
$html = $html."<h1>".$p->getTitle()."</h1>\r\n";
$html = $html."<img src=".$p->buildImgUrl()." />\r\n";
$html = $html."<h3>".$p->getDescription()."</h3>\r\n";
$html = $html."</html>\r\n";

$f = $savepath.$htmlfilename;
file_put_contents($f, $html);

?>

