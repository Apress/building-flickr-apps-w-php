<?php
//user_tags.php

define('API_CONFIG_FILE', '../authtoken.dat');

require_once 'Phlickr/Api.php';
require_once 'Phlickr/User.php';

// set up the api connection

$api = Phlickr_Api::createFrom(API_CONFIG_FILE);

if (! $api->isAuthValid()) {
  die("invalid flickr logon");
}

$username = $_REQUEST['username'];
$script_filename = basename($_REQUEST['SCRIPT_FILENAME']);
?>

<html>
  <head>
    <title>Accessing Tags</title>
  </head>

  <body>

    <form method='post' action='<?php echo $script_filename; ?>'>
      <p>enter a flickr username: <input type='text' name='username' 
                                         value="<?php echo $username; ?>"/></p>
      <input type='submit' value='find tags for this user'/>
    </form>

    <?php
    if ($username != '') {
      $u = Phlickr_User::findByUsername($api, $username);

      $usertags = $u->getTags();
      $populartags = $u->getPopularTags('5');
    ?>

    All of this user's tags are:<br/>

    <?php
      foreach ($usertags as $tag) {
        print $tag.' ';
        flush();	
      }
    ?>

    <br/><br/>
    The most popular tags are:<br/>

    <?php
      foreach ($populartags as $tag) {
        print $tag.' ';
        flush();
      }
    }
    ?>
  </body>
</html>
