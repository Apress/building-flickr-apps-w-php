<?php
//photolog_view.php

$photolog_set_id = '1205215';
$pageurl = $_SERVER["SCRIPT_NAME"].'/';
$flickr_username = "goodlux";

$key = 0;

$path_array = explode("/",$_SERVER["PATH_INFO"]);
$mainPhotoId = $path_array[1];

$filename = dirname($_SERVER["SCRIPT_FILENAME"]).'/'."$photolog_set_id.dat";
$cache = file_get_contents($filename);

$photos = unserialize($cache);
$num_photos = count($photos);

if (($mainPhotoId == NULL)|| (!isset($mainPhotoId))) {
  $mainPhotoId = $photos[0][3];
}

while ($photos[$key][3] != $mainPhotoId) {
  $key++;
}

if (($photos[$key][1] == NULL)) {
  $title = 'Click to view';
} else {
  $title = $photos[$key][1];
}

$photodate = date( "l, M jS Y" ,$photos[$key][2]);

$now_url = $pageurl.$photos[$key-1][3].'/';
$then_url = $pageurl.$photos[$key+1][3].'/';

if ($key <= 4) {
  $then5_url = $pageurl.$photos[$key+5][3].'/';
  $now5_url = $pageurl.$photos[0][3].'/';
} elseif ($key >= $num_photos-5) {
  $then5_url = $pageurl.$photos[$num_photos-1][3].'/';
  $now5_url = $pageurl.$photos[$key-5][3].'/';
} else {
  $then5_url = $pageurl.$photos[$key+5][3].'/';
  $now5_url = $pageurl.$photos[$key-5][3].'/';
}
?>

<html>
  <head>
    <title>Photolog Viewer</title>
  </head>
  
  <body>
    <div align='center'>

      <table>
        <tr valign='bottom' height='25'>
          <td align='center'>
            <h3><?php echo $photodate; ?></h3>
          </td>
        </tr>
        <tr>
          <td>
            <table>

              <?php
              if ($photos[$key-1][3] == '') { //newest photo
              ?>
              <tr valign='top' align='center'>
                <td align='right' width='30'>
                  <a href='<?php echo $then5_url; ?>' title='rewind'>&#60;&#60;</a>
                </td>
                <td align='right' width='42'>
                  <a href='<?php echo $then_url; ?>' title='previous photo'>&#60;then</a>
                </td>
                <td width='520' align='center'>
                  <img class='main' src='<?php echo $photos[$key][0]; ?>' ALT='*' />
                </td>
                <td align='left' width='38'/>
                <td width='30'/>
              </tr>

              <?php
              } elseif ($photos[$key+1][3] == '') { //oldest photo
              ?>
              <tr valign='top'>
                <td align='right' width='30'/>
                <td align='right' width='42'/>
                <td width='520' align='center'>
                  <img class='main' src='<?php echo $photos[$key][0]; ?>' ALT='*' />
                </td>
                <td width='38' align='left'>
                  <a href='<?php echo $now_url; ?>' title='next photo'>now&#62;</a>
                </td>
                <td align='left' width='30'>
                  <a href='<?php echo $now5_url; ?>' title='fastforward'>&#62;&#62;</a>
                </td>
              </tr>

              <?php 
              } else { //everything else
              ?>
              <tr  valign='top'>
                <td align='right' width='30'>
                  <a href='<?php echo $then5_url; ?>' title='rewind'>&#60;&#60;</a>
                </td>
                <td align='right' width='42'>
                  <a href='<?php echo $then_url; ?>' title='previous photo'>&#60;then</a>
                </td>
                <td width='520' align='center'>
                  <img class='main' src='<?php echo $photos[$key][0]; ?>' ALT='*' />
                </td>
                <td align='left' width='38'>
                  <a href='<?php echo $now_url; ?>' title='next photo'>now&#62;</a>
                </td>
                <td align='left' width='30'>
                  <a href='<?php echo $now5_url; ?>' title='fastforward'>&#62;&#62;</a>
                </td>
              </tr>
              
              <?php
              } // close the if block

              // create a URL
              $url = 'http://www.flickr.com/photos/'
	        .$flickr_username.'/'.$photos[$key][3];
              ?>

            </table>
          </td>
        </tr>
      </table>

      <table>
        <tr valign='top'>
          <td align='center'  height='20'>
            <a href='<?php echo $url; ?>'><?php echo $title; ?></a>
          </td>
        </tr>
      </table>

    </div>
  </body>
</html>
