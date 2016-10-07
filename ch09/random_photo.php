<?php
//random_photo.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Group.php';
include_once 'Phlickr/PhotoListIterator.php';

$script_filename= basename($_REQUEST['SCRIPT_FILENAME']);

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$group = new Phlickr_Group($api, '14157979@N00');
$photolist = $group->getPhotoList();
  
// iterate over all the pages
$iterator = new Phlickr_PhotoListIterator($photolist);
$photos = $iterator->getPhotos();

$randomnumber = rand(1,count($photos)); 
?>

<html>
  <head>
    <title>Random Photo</title>
    <meta http-equiv="Refresh" content="10; url=<?php echo $script_filename; ?>"/>
  </head>

  <body style="vertical-align:middle; text-align:center">
    <img src="<?php echo $photos[$randomnumber]->buildImgUrl('-'); ?>"
         alt="A random image"/>
  </body>
</html>
