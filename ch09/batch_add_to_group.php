<?php
//batch_add_to_group.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/PhotoList.php';
require_once 'Phlickr/PhotoListIterator.php';
include_once 'Phlickr/AuthedGroup.php';
 
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
    <title>Add Tagged Photos to A Group</title>
  </head>

  <body>
    <form method='get' action='<?php echo $script_filename; ?>'>
      <p>
        enter a comma-separated list of tags 
        <input type='text' name='tags' value='<?php echo $tags; ?>' /> 
        and enter the group id 
        <input type='text' name='groupid' value='<?php echo $group_id; ?>' />
      </p>

      <input type='submit' value='add photos to the group'/>
    </form>

    <?php
    if ($tags == '' or $group_id == '') {
      die('Please enter a tag or set of tags and a group id');
    }

    $request = $api->createRequest(
      'flickr.photos.search',
      array(
        'tags' => $tags,
        'tag_mode' => 'all',
        'user_id' => $api->getUserId()
        )
    );

    try {
      $pl = new Phlickr_PhotoList($request, Phlickr_PhotoList::PER_PAGE_MAX);
      $pli = new Phlickr_PhotoListIterator($pl);
      $ag = new Phlickr_AuthedGroup($api, $group_id);
    } catch (Exception $e) {
      die ('Error: '. $e->getMessage(). "<br />");
    }

    foreach ($pli->getPhotos() as $photo) {
      $photoid = $photo->getId();
      
      try {
        echo 'adding photo '. $photoid, "<br />"; 
        $ag->add($photoid);     
        flush();
      } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage(), "<br />";
        flush();
      }
    }
    ?>
  </body>
</html>
