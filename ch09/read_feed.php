<?php
//read_feed.php

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

echo 'Group Title:'.$feed['title']."<br />";
echo 'Group Link:'.$feed['link']."<br />";

echo "<br />";
echo 'Group Description:'.strip_tags($feed['subtitle'])."<br />";
echo "<br />";

foreach ($discuss_atom->items as $feeditem) {
  echo ' Feed Item--->'.$feeditem['title']."<br />";	
}
?>
