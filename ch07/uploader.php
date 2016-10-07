<?php
//uploader.php

define('API_CONFIG_FILE', '../authtoken.dat');
define('UPLOAD_DIRECTORY', '.');
define('PHOTO_EXTENSION', '.jpg');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/Uploader.php';
require_once 'Phlickr/AuthedPhoto.php';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$uploader = new Phlickr_Uploader($api);
$di = new DirectoryIterator(UPLOAD_DIRECTORY);

$additionaltags = getAdditionalTags();
$datetaken = directoryForDates();

foreach($di as $item) {
  // only files with the given extension...

  if ($item->isFile()) {
    if (substr(strtolower($item), - strlen(PHOTO_EXTENSION)) 
	===  strtolower(PHOTO_EXTENSION)) {
      print "Uploading $item...\r\n";

      $title = str_replace('_', ' ', rtrim(strtolower($item), '.jpg'));
      $phototags = $additionaltags.' '.$title;
      $new_photo_id = $uploader->upload($item->getPathname(), $title, '', $phototags);


      if ($datetaken){
        $ap = new Phlickr_AuthedPhoto($api, $new_photo_id);
        $ap->setTaken($datetaken);		
      }
    
      $photo_ids[] = $new_photo_id;
    }
  }
}

if (count($photo_ids)) {
  printf("\r\nAll done! If you care to make some changes:\r\n%s", 
         $uploader->buildEditUrl($photo_ids));
}

function getAdditionalTags() {

  print 'List of additional tags, seperated by spaces, if any: ';
  // trim any whitespace
  $tags = trim(fgets(STDIN));

  if ($tags) {
    print "The photos will be tagged with '" . $tags . "'.\r\n\r\n";
  } else {
    print "The photos will not have any additional tags.\r\n\r\n";
  }
  return $tags;
}

function directoryForDates() {

  $dirbasename = basename(UPLOAD_DIRECTORY);

  print "Use directory info as date taken? Currently: $dirbasename (y/N): ";

  $datetaken = date("Y-m-d G:i:s", strtotime(str_replace('_', ' ', $dirbasename)));

  $reply = trim(fgets(STDIN));

  if ($reply == 'y') {
    print "Date taken will be set to '" . $datetaken. "'.\r\n\r\n";
    return $datetaken;
  } else {
    print "Photos will set to current time tagged with the current time.\r\n\r\n";
  }
}

?>
