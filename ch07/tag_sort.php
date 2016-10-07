<?php
//tag_sort.php

define('API_CONFIG_FILE', '../authtoken.dat');

include_once 'Phlickr/Api.php';
include_once 'Phlickr/Photo.php';

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$photo_id = $_REQUEST['photoid'];
$script_filename = basename($_SERVER['SCRIPT_FILENAME']);

?>

<html>
  <head>
    <title>Accessing Tags</title>
  </head>
  
  <body>
    <form method='post' action='<?php echo $script_filename; ?>'>
      <p>enter a photo id: <input type='text' name='photoid' 
                                  value="<?php echo $photo_id; ?>"/></p>
      <input type='submit' value='find tags for this photo'/>
    </form>

    <?php
    if ($photo_id == NULL) {
      die(); 
    }

    try {
      $photo = new Phlickr_Photo($api, $photo_id);
      $tags = $photo->getTags();
  
      if (count($tags) == 0) {
        die("this photo doesn't have any tags");
      }
    ?>

    <br/>
    These are the tags for photo number <?php echo $photo_id; ?>:<br/>
  
    <?php
    foreach ($tags as $tag) {
      echo $tag."<br/>";
    }
    ?>
 
    <br/>
    Let's sort the tags<br/>

    <?php
      sort($tags);

      foreach ($tags as $tag) {
        echo $tag."<br/>";
      }
    ?>
    
    <br/>
    Now let's sort them backwards<br/>

    <?php
      rsort($tags);

      foreach ($tags as $tag) {
        echo $tag."<br/>";
      }

    } catch (Exception $e) {
      echo "That doesn't look like a valid photo id. Try again.";
    }
    ?>

  </body>
</html>
