<?php
//create_photoset.php

// for the sake of simplicity, we will start with a known photo ID...
// this could be the ID number of any photo in "your photos"
$samplePhotoId = '96728489';

// use the GetToken.php script to generate a config file
define('API_CONFIG_FILE', '../authtoken.dat');

// require the needed Phlickr libraries
require_once 'Phlickr/Api.php';
require_once 'Phlickr/AuthedPhotosetList.php';

// set up the api connection
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);

if (! $api->isAuthValid()) {
    die("invalid flickr logon");
}

// get the list of photosets in your account
$photosetlist = new Phlickr_AuthedPhotosetList($api);

// get the id of the newly created photoset
$newphotosetId = $photosetlist->create('the set title', 'the caption', $samplePhotoId);

// let's make an object out of the new photoset
$authedPhotoset = new Phlickr_AuthedPhotoset($api, $newphotosetId);

// now let's change the title and description
$authedPhotoset->
  setMeta('this is a better title', 'and this is a better description');

// the URL of the photoset
$url = $authedPhotoset->buildUrl();
?>

<html>
  <head>
    <title>Photoset Basics</title>
  </head>
  
  <body>
    <p>
      The new photoset id is: <?php echo $newphotosetId; ?><br/>

      The new photoset can be found at: 
      <a href="<?php echo $url; ?>"><?php echo $url; ?></a><br/>
    </p>
  </body>
</html>