<?php
//print_rss.php

require ('magpierss/rss_fetch.inc');
$rss = fetch_rss('http://flickr.com/groups_feed.gne?id=34427469792@N01&format=atom');
print_r ($rss);
?>
