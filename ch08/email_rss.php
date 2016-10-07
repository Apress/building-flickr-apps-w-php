<?php

// flickr user id
define('USER_ID', '26159919@N00');
// email address where updates will be sent to
define('EMAIL', '');
// your mail host
define('SMTP_MAIL_HOST', '');
// file where we track the last comment seen
define('CONFIG_FILE', '.lastFlickrComment');

// load id of the last entry we've seen from the file
if (file_exists(CONFIG_FILE)) {
  $lastSeen = file_get_contents(CONFIG_FILE);
} else {
  $lastSeen = '';
}

// construct a url to the user's feed
$url = rawurlencode(
  'http://www.flickr.com/recent_comments_feed.gne?format=atom_03&id='. USER_ID
);
$xml = simplexml_load_file($url);

// loop through all the entries and build an email body
$body = '';
foreach ($xml->entry as $entry) {
  // make sure we haven't seen this entry before
  if ($lastSeen == (string) $entry->id) {
    break;
  }

  // first step, strip out the HTML formatting, the comments are
  // now in the format "UserX has posted a comment:\n\nCommentBody\n\n"
  $post = strip_tags($entry->content);
  // drop every thing up to the colon
  $post = strstr($post, ":\n\n");
  // now, the drop the colon and two new lines we just matched
  $post = substr($post, 3);
  // remove any trailing characters
  $post = trim($post);
  // wrap any long lines
  $post = wordwrap($post);

  // put it all together
  $body .= "{$entry->title}:\n\"{$post}\" - {$entry->author->name}\n\n";
}

// if we've got any output, mail it off
if ($body) {
  // add a link to flickr's site, for good luck
  $body .= "See more: http://flickr.com/recent_activity.gne";

  // set up the mailing configuration ...
  ini_set('sendmail_from', EMAIL);
  ini_set('SMTP', SMTP_MAIL_HOST);
  // ... and send the mail
  $wasSent = mail(EMAIL, 'Flickr Updates', $body);

  // if the email sent, save the id of the newest entry so we know to skip
  // everything after it.
  if ($wasSent) {
    file_put_contents(CONFIG_FILE, (string) $xml->entry[0]->id);
  }
}

// you may want to uncomment the next line for testing
#print $body;

?>
