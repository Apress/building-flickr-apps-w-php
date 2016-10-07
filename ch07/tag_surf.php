<?php
//tag_surf.php

$script_filename = basename($_REQUEST['SCRIPT_FILENAME']);
$searchtag = $_REQUEST["searchtag"];

?>

<html>
  <head>
    <title>Related Tags</title>
  </head>

  <body>

    <form method='get' action='<?php echo $script_filename; ?>'>
      <p>enter a tag <input type='text' name='searchtag' 
                            value='<?php echo $searchtag; ?>' /></p>
      <input type='submit' value='search for related tags'/>
    </form>

    <?php
    if ($searchtag != '') {
      define('API_CONFIG_FILE', '../authtoken.dat');

      require_once 'Phlickr/Api.php';

      // set up the api connection
      $api = Phlickr_Api::createFrom(API_CONFIG_FILE);

      if (! $api->isAuthValid()) {
        die("invalid flickr logon");
      }

      $request = $api->createRequest(
        'flickr.tags.getRelated',
        array('tag' => $searchtag)
      );

      $response = $request->execute();

      $xml = $response->xml->tags;
    ?>

    The tags related to <?php echo $searchtag; ?> are:<br/>

    <?php
      $tag_counter = 0;
      foreach ($xml->tag as $tag) {
    ?>

    <a href="<?php echo $script_filename; ?>?searchtag=<?php echo $tag; ?>"> 
      <?php echo $tag; ?></a>

      <?php
        flush();
        $tag_counter++;
      }
    
      if ($tag_counter == 0){
        print 'There are no related tags';	
      }
    }
    ?>

  </body>
</html>
