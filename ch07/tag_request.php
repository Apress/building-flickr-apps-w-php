<?php
//tag_request.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/PhotoList.php';
require_once 'Phlickr/PhotoListIterator.php';

// set up the api connection
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$tags = 'dance, performance';
$tagmode = 'all';
$userid =  $api->getUserId();
$sort = 'interestingness-desc';
$date3monthsago = date("Y-m-d G:i:s", strtotime("-3 months"));
$date20monthsago = date("Y-m-d G:i:s", strtotime("-20 months"));

$request = $api->createRequest(
  'flickr.photos.search',
  array(
    'tags' => $tags,
    'tag_mode' => $tagmode,
    'user_id' => $userid,
    'min_taken_date' => $date20monthsago, 
    'max_taken_date' => $date3monthsago,
    'sort' => $sort
  )
);

$pl = new Phlickr_PhotoList($request, Phlickr_PhotoList::PER_PAGE_MAX);
$pli = new Phlickr_PhotoListIterator($pl);
?>

<html>
  <head>
    <title>Searching Tags</title>
  </head>

  <body>
    <?php
    foreach ($pli->getPhotos() as $photo) {
    ?>
    
    title: <?php echo $photo->getTitle(); ?><br/>
    photo id: <a href="<?php echo $photo->buildUrl(); ?>">
      <?php echo $photo->getId(); ?></a><br/>

    <img src="<?php echo $photo->buildImgUrl('m'); ?>"/><br/><br/>

    <?php
    }
    ?>
  </body>
</html>
