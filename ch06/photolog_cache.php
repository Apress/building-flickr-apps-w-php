<?php
//photolog_cache.php

define('API_CONFIG_FILE', '../authtoken.dat'); 

$serverpath = dirname($_SERVER["SCRIPT_FILENAME"]).'/';

$set = '1205215';

include_once  'Phlickr/Api.php'; 
include_once  'Phlickr/Photoset.php'; 

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);

if (! $api->isAuthValid()) { 
  die("invalid flickr logon"); 
}

$ps = new Phlickr_Photoset($api, $set);

$psl = $ps->getPhotoList();

$photos = $psl->getPhotos();

$cache_array = array();
$i = 0;

echo "Creating cache file...<br/>";

foreach ($photos as $photo){

  $cache_array[$i][0] = $photo->buildImgUrl('-');	
  $cache_array[$i][1] = $photo->getTitle();
  $cache_array[$i][2] = $photo->getTakenTimestamp();
  $cache_array[$i][3] = $photo->getId();
  echo 'Caching information for '.$cache_array[$i][0]."<br/>";
  flush();
  $i++;
  
}
	
$dat = serialize($cache_array);
$f = file_put_contents("$serverpath$set.dat", $dat);
echo 'Cache file created and stored at '.$serverpath."<br/>";

?>
