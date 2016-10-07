<?php
//show_photo.php 

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php'; 
include_once 'Phlickr/Photo.php';

$photoid = '19481086';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die('invalid flickr logon'); 
}

$p = new Phlickr_Photo($api, $photoid);
?>

<html>
  <head>
    <title>Display a Photo</title>
  </head>
  
  <body>
    <br />
    <h1 align="center"><?php echo $p->getTitle(); ?></h1>
    <p align="center"><img src="<?php echo $p->buildImgUrl('-'); ?>" /></p>
  </body>
</html>
