<?php
 
// Dummy class definition.
class Photo {

  public $id = 0;
  public $title = '';
  public $URL = '';

  function showValues(){
    echo $this->id;
    echo $this->title;
    echo $this->URL;
  }

  function savePhoto() {
    // code to save the photo goes here 
  }
}

$p = new Photo(); 

$p->id = '5859628';
$p->title = 'This is a test photo';
$p->URL = 'http://photos3.flickr.com/5859628_64c58f62a3.jpg';
$p->savePhoto();

echo $p->id."<br/>"; 
echo $p->title."<br/>";
?>

<a href="<?php echo $p->URL; ?>"><?php echo $p->URL; ?></a><br/>

