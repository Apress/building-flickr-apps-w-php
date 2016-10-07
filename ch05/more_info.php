<?php
//more_info.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/AuthedPhoto.php';

$photoid = '96728489'; //make sure you pick a photo that you own

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);

if (! $api->isAuthValid()) {
  die('invalid flickr logon');
}

$p = new Phlickr_AuthedPhoto($api, $photoid);

$original_title = $p->getTitle();
$original_description = $p->getDescription();
$original_posted_time = $p->getPostedDate();
$original_taken_time = $p->getTakenDate();
$original_tags = $p->getTags();

$p->setMeta('This is the new Title', 'This is the new Description');
$p->setPosted(mktime (11,1,55,1,3,03));
$p->setTaken(mktime (13,11,21,1,4,03));
$p->setTags(array('specialphoto','cameraphone', 'testphotos'));

$new_title = $p->getTitle();
$new_description = $p->getDescription();
$new_posted_time = $p->getPostedDate();
$new_taken_time = $p->getTakenDate();
$new_tags = $p->getTags();
?>

<html>
  <head>
    <title>Setting and Getting Photo Info</title>
  </head>
  
  <body>
    <p>
      The original title was: <?php echo $original_title; ?><br/>
      The new title is: <?php echo $new_title; ?><br/>
      The original description was: <?php echo $original_description; ?><br/>
      The new decription is: <?php echo $new_description; ?><br/>
      The original time taken was: <?php echo $original_taken_time; ?><br/>
      The new time taken is: <?php echo $new_taken_time; ?><br/>
      The original time posted was: <?php echo $original_posted_time; ?><br/>
      The new time posted is: <?php echo $new_posted_time; ?><br/>
      The original tags were:<br/>
      <pre>
        <?php echo print_r ($original_tags); ?>
      </pre><br/>
      The new tags are:<br/>
      <pre>
        <?php echo print_r ($new_tags); ?>
      </pre>
    </p>
  </body>
</html>
