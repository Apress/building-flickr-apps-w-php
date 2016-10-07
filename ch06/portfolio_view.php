<?php
//portfolio_view.php

$setid = '216005';

$filename = dirname($_SERVER["SCRIPT_FILENAME"])."/$setid.dat";
$dat = file_get_contents($filename);
$photos = unserialize($dat);

$num_photos = count($photos);
if ($num_photos > 15) {
  $num_photos = 15;
}

$path_array = explode("/", $_SERVER["PATH_INFO"]);
$mainPhotoId = $path_array[2];

if (($mainPhotoId == NULL )|| (!isset($mainPhotoId))) {
  $mainPhotoId = 0; 
}

if (($photos[$mainPhotoId][2] == NULL)) {
  $title = '&nbsp;';
}else{
  $title = $photos[$mainPhotoId][2];
}

$currentFile = $_SERVER["SCRIPT_NAME"];
$baseUrl = 'http://localhost'.$currentFile.'/'.$setid.'/';
$dirName = dirname($currentFile);
echo $currentFile."<br>";
echo dirname($_SERVER["PHP_SELF"]);
?>

<html>
  <head>
    <title>Portfolio View</title>
  </head>

  <body>
 
    <table width="1000" align="center">
      <tr valign="top">
        <td width="885" align="center" valign="top" >
          <table cellpadding="25" align="center">
            <tr align='center'>
              <td>
              </td>
            </tr>
          </table>
          <table cellpadding='0' cellspacing='0' width='100%'>
            <tr halign='middle' valign='center'>
              <td align='center' height='650'>
                <img src='<?php echo $dirName.'/'.$photos[$mainPhotoId][0]; ?>' ALT='*' />
              </td>
            </tr>
            <tr valign='top'>
              <td align='center' height='20'>
                <h3><?php echo $title; ?></h3>
              </td>
            </tr>
          </table>

          <table height='52'>
            <tr>

            <?php
            for ($i = 0; $i< $num_photos; $i++){
            ?>
              <td>
                <a href="<?php echo $baseUrl.$i; ?>">
                  <img border="0" height="30" width="30" src="<?php echo $dirName.'/'.$photos[$i][1]; ?>"> 
                </a>
              </td>
            <?php
            }
            ?>

            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
