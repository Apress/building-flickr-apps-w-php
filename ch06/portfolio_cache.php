<?php
//portfolio_cache.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php'; 
include_once 'Phlickr/Photoset.php'; 

$serverpath = dirname($_SERVER["SCRIPT_FILENAME"]).'/';
$webpath = '';

$set = '216005';

$cache_arraypi = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $cache_arraypi->isAuthValid()) {
  die("invalid flickr logon");
}

$ps = new Phlickr_Photoset($cache_arraypi, $set);
$psl = $ps->getPhotoList();
$photos = $psl->getPhotos();

$cache_array = array();
$i = 0;

echo "Creating cache file and downloading images...<br/>";
foreach ($photos as $photo){	
  if ($i<15) {
    $url1 = $photo->buildImgUrl('-');
    $url2 = $photo->buildImgUrl('s');

    $pu1 = parse_url($url1);
    $pu2 = parse_url($url2);

    $url1_path = $pu1['path'];
    $url2_path = $pu2['path'];

    $pi1 = pathinfo($url1_path);
    $pi2 = pathinfo($url2_path);

    $filename1 = $pi1['basename'];
    $filename2 = $pi2['basename'];

    $cache_array[$i][0] = $webpath.$filename1;
    $cache_array[$i][1] = $webpath.$filename2;
    $cache_array[$i][2] = $photo->getTitle();

    $img1 = file_get_contents($url1);
    $img2 = file_get_contents($url2);

    file_put_contents($serverpath.$filename1, $img1); 
    file_put_contents($serverpath.$filename2, $img2);
    echo "Saved ".$serverpath.$filename1."<br/>";
    flush();
  }

  $i++;
}

$dat = serialize($cache_array);
file_put_contents($serverpath."$set.dat", $dat);
echo "Cache file created and stored at $serverpath<br/>";
?>
