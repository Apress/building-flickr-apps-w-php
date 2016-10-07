<?php
//tag_search_page.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/PhotoList.php';
require_once 'Phlickr/PhotoListIterator.php';

// set up the api connection
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$script_filename = basename($_REQUEST['SCRIPT_FILENAME']);
$tags = $_REQUEST["tags"];
?>

<html>
  <head>
    <title>East West Wing Chug Kung Fu Association Photo Tag Search</title>
  </head>

  <body>
    <div align="center">
      <h2>East West Wing Chug Kung Fu Association Photo Tag Search</h2>

      <form method='get' action='<?php echo $script_filename; ?>'>
        <p>Enter tags to search for, separated by commas 
          <input type='text' name='tags' value='<?php echo $tags; ?>' />
        </p>
        <input type='submit' value='Find Photos'/>
      </form>
      <p>
        <?php
        $tags = $_REQUEST['tags'];
        $tags = $tags.", ewwckfpool";

        $request = $api->createRequest(
          'flickr.photos.search',
          array(
            'tags' => $tags,
            'tag_mode' => 'all'
          )
        );

        $pl = new Phlickr_PhotoList($request, Phlickr_PhotoList::PER_PAGE_MAX);
        $pli = new Phlickr_PhotoListIterator($pl);

        foreach ($pli->getPhotos() as $photo) {
          $photoid = $photo->getId();
        ?>

        <a href="<?php echo $photo->buildImgURL('o'); ?>">
          <img src="<?php echo $photo->buildImgURL('s'); ?>"/></a>

        <?php
          flush();
        }
        ?>
      </p>
    </div>
  </body>
</html>
