<?php
//tag_photos_in_a_group.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Group.php';
include_once 'Phlickr/PhotoListIterator.php';

 
// set up the api connection
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$script_filename = basename($_REQUEST['SCRIPT_FILENAME']);
$tags = $_REQUEST["tags"];
$group_id = $_REQUEST["groupid"];
?>

<html>
  <head>
    <title>Add Tags to all the photos in a Group</title>
  </head>
  
  <body>
    <form method='get' action='<?php echo $script_filename; ?>'>
      <p>enter a comma-separated list of tags 
        <input type='text' name='tags' value='<?php echo $tags; ?>' /> 
        and enter the group id 
        <input type='text' name='groupid' value='<?php echo $group_id; ?>' />
      </p>
      <input type='submit' value='Add a tag or tags to every photo in the group'/>
    </form>

    <?php
    if ($tags == '' or $group_id == '') {
      die('Please enter a tag or set of tags and a group id');
    }

    $group = new Phlickr_Group($api, $group_id);
    $photolist = $group->getPhotoList();

    $iterator = new Phlickr_PhotoListIterator($photolist);

    foreach ($iterator->getPhotos() as $photo) {
      $photo->addTags(explode( ',', $tags));
      echo "<br />";
      echo "adding tags to photo #".$photo->getId()."<br />";
      echo "the new tags are: <br />";
      foreach ($photo->getTags() as $tag) {
        echo $tag. "<br />";
      }		
    }
    ?>
  </body>
</html>
