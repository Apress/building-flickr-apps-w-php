<?php
//feed_page.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/AuthedGroup.php';
require_once 'magpierss/rss_fetch.inc';
	
$api = Phlickr_Api::createFrom(API_CONFIG_FILE);
if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$ag = new Phlickr_AuthedGroup($api, '34427469792@N01');
$groupfeed = $ag->buildDiscussFeedUrl("atom");

$discuss_atom = fetch_rss($groupfeed);

$feed = $discuss_atom->channel;
?>

<html>
  <head>
    <title>Group Feed Example</title>
    <style type="text/css" media="all">
      @import "feed.css";
    </style>
  </head>

  <body>
    <a href="<?php echo $feed['link']; ?>">
      <h1><?php echo $feed['title']; ?></h1>
    </a>

    <p><?php echo $feed['subtitle']; ?></p>

    <h2>Recent Topics</h2>

    <?php
    foreach ($discuss_atom->items as $item){
      if (substr($item['title'], 0, 5) != 'Reply') {
    ?>

    <p class="new">New Topic: 
      <a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a>
    </p>

    <div class="topic"><?php echo $item['atom_content']; ?></div>

    <?php
      }
    }
    ?>

    <h2>Recent Replies to Previous Topics</h2>

    <?php
    foreach ($discuss_atom->items as $item) {
      if (substr($item['title'], 0, 5) == 'Reply') {
    ?>

    <p class="new">New Reply: 
      <a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a>
    </p>

    <div class="topic"><?php echo $item['atom_content']; ?></div><br/>

    <?php
      }
    }	
    ?>
  </body>
</html>
