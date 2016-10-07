<?php
//tag_switch.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/PhotoList.php';
require_once 'Phlickr/PhotoListIterator.php';
require_once 'Phlickr/AuthedPhoto.php';

// set up the api connection
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$mistaketag = 'performace';
$newtag = 'performance';
$userid =  $api->getUserId();

$request = $api->createRequest(
  'flickr.photos.search',
  array(
    'tags' => $mistaketag,
    'user_id' => $userid
  )
);

$pl = new Phlickr_PhotoList($request, Phlickr_PhotoList::PER_PAGE_MAX);
$pli = new Phlickr_PhotoListIterator($pl);

foreach ($pli->getPhotos() as $photo) {
  $authedphoto = new Phlickr_AuthedPhoto($api, $photo->getId());
  $tagarray = $authedphoto->getTags();
  print_r($tagarray);
  $key = array_search($mistaketag, $tagarray);
  $tagarray[$key] = $newtag;
  $authedphoto->setTags($tagarray);
  print_r ($authedphoto->getTags());
  flush();
}

?>
