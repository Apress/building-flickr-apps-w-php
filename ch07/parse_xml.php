<?php
// parse_xml.php

$url = 'http://flickr.com/services/feeds/photos_public.gne?ids=26159919@N00,41258641@N00';
$feed = simplexml_load_file(rawurlencode($url));
?>

<html>
  <head>
    <title>Parsing an XML file</title>
  </head>

  <body>
    <h1><?php echo $feed->title; ?></h1>
    

    <?php
    foreach ($feed->entry as $entry) {
    ?>

    <a href="<?php echo $entry->link['href']; ?>">
      <?php echo $entry->title; ?></a><br/>
  
    <?php
    }
    ?>
  </body>
</html>
