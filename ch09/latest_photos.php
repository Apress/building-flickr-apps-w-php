<?php
//latest_photos.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/AuthedGroup.php';
include_once 'Phlickr/Photo.php';
include_once 'magpierss/rss_fetch.inc';
	
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$ag = new Phlickr_AuthedGroup($api, '78064184@N00');
$photo_atom = fetch_rss($ag->buildPhotoFeedUrl("atom"));
?>

<html>
  <head>
    <title>Latest Group Images</title>
  </head>

  <body>
    <h2>Latest Group Images</h2>

    <?php
    foreach ($photo_atom->items as $item) {
      $patharray = explode('/', $item['link']);
      $photo_id = $patharray[5];
      $photo = new Phlickr_Photo ($api,  $photo_id);
    ?>

    <a href="<?php echo $item['link']; ?>">
      <img src="<?php echo $photo->buildImgUrl('s'); ?>" 
           alt="<?php echo $item['title']; ?>" />
    <?php
    }
    ?>
  </body>
</html>
