<?php
//sorted_set.php

$tags = $_REQUEST['tags'];

if ($tags != ''){

  // use the GetToken.php script to generate a config file.
  define('API_CONFIG_FILE', '../authtoken.dat');

  include_once 'Phlickr/Api.php';
  include_once 'Phlickr/AuthedPhotosetList.php';
  include_once 'Phlickr/PhotoList.php';
  include_once 'Phlickr/PhotoListIterator.php';
  include_once 'Phlickr/PhotoSorter.php';
  include_once 'Phlickr/PhotoSortStrategy/ByColor.php';
 
  // set up the api connection
  $api = Phlickr_Api::createFrom(API_CONFIG_FILE);
  if (! $api->isAuthValid()) { 
    die('invalid flickr logon');
  }
 
  $request = $api->createRequest(
    'flickr.photos.search',
    array(
      'tags' => $tags,
      'tag_mode' => 'all',
      'user_id' => $api->getUserId()
    )
  );
 
  $pl = new Phlickr_PhotoList($request, Phlickr_PhotoList::PER_PAGE_MAX);
  $count = $pl->getCount();
  
  if ($count == 0) {
    print "No photos could be found tagged with $tags.<br/>";
  } else {
    print "Found $count photos tagged with $tags...<br/>";
 
    // create a sorter that will uses the color sort strategy
    $strategy = new Phlickr_PhotoSortStrategy_ByColor($api->getCache());
    $sorter = new Phlickr_PhotoSorter($strategy);
 
    // use a photolist iterator so that all the pages are sorted
    // sorting the photos by color might take a while
    flush();
    $photos = $sorter->sort(new Phlickr_PhotoListIterator($pl));
    $photo_ids = Phlickr_PhotoSorter::idsFromPhotos($photos);
 
    // create the authed photoset list for the current user...
    $apsl = new Phlickr_AuthedPhotosetList($api);
    // .. and create a new photo set
    $id = $apsl->
      create($tags, 'photo set created from tags '.$tags, $photo_ids[0]);

    // wait a few seconds for the set to be created
    sleep(3);
 
    // now, create the photoset ojbect and add the photos
    $aps = new Phlickr_AuthedPhotoset($api, $id);
    $aps->editPhotos($photo_ids[0], $photo_ids);

    $url = $aps->buildUrl();
 ?>

    Created a photoset named '<?php echo $tags; ?>': <br/>
    <a href='<?php echo $url; ?>'><?php echo $url; ?></a><br/>

<?php
  }
} // closing the two if blocks
?>

<html>
  <head>
    <title>Create a sorted set</title>
  </head>
  
  <body>
    <form method='post' action='sorted_set.php'>
      <p>enter a list of tags <input type='text' name='tags'/></p>
      <input type='submit' value='submit'/>
    </form>

  </body>
</html>
