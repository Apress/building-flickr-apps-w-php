<?php
//photo_info.php 

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Photo.php';

$photoid = '19481086';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die('invalid flickr logon');
}

$p= new Phlickr_Photo($api, $photoid);
?>

<html>
  <head>
    <title>Photo Info</title>
  </head>
  
  <body>
    <p>
      <img src="<?php echo $p->buildImgUrl('m'); ?> " /><br/>
      Some quick facts about this photo:<br/>
      photo id: <?php echo $p->getId(); ?><br/>
      photo title: <?php echo $p->getTitle(); ?><br/>
      photo description: <?php echo $p->getDescription(); ?><br/>
      this photo was uploaded by user id: <?php echo $p->getUserId(); ?><br/>
      you can find the flickr photo page for this image at: 
        <?php echo $p->buildUrl(); ?><br/>
      you can find just the image file at: <?php echo $p->buildImgUrl(); ?><br/>
      this photo was taken on: <?php echo $p->getTakenDate(); ?><br/>
      the timestamp when taken was: <?php echo $p->getTakenTimestamp(); ?><br/>
      the granularity of the taken timestamp is: 
        <?php echo $p->getTakenGranularity(); ?><br/>
      this photo was posted on: <?php echo $p->getPostedDate(); ?><br/>
      the timestamp when posted was: <?php echo $p->getPostedTimestamp(); ?><br/>
      this photo secret is: <?php echo $p->getSecret(); ?><br/>
      this photo is hosted on flickr server number: 
        <?php echo $p->getServer(); ?><br/>
      can this photo be seen by family?: <?php echo $p->isForFamily(); ?><br/>
      can this photo be seen by friends?: <?php echo $p->isForFriends(); ?><br/>
      can this photo be seen by everyone?: <?php echo $p->isForPublic(); ?><br/>
      photo sizes: <?php echo $p->getSizes(); ?><br/>
      raw tags: <?php echo $p->getRawTags(); ?><br/>
      regular tags: <?php echo $p->getTags(); ?><br/>
    </p>
  </body>
</html>
