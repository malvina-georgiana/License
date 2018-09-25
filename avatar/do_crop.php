<?php
if(isset($_POST['crop_image']))
{
  $y1=$_POST['top'];
  $x1=$_POST['left'];
  $w=$_POST['right'];
  $h=$_POST['bottom'];
  $image="profil/".$_POST['name'].".".$_POST['ext'];
echo '<b>Debug:</b><br><br>Name = '.$name.'<br>ext = '.$ext.'<br>';

  list( $width,$height ) = getimagesize( $image );
  $newwidth = 256;
  $newheight = 360;

  $thumb = imagecreatetruecolor( $newwidth, $newheight );
  /* JPEG */
  if($_POST['ext']=='jpg' || $_POST['ext']=='JPG'){
 	 $source = imagecreatefromjpeg($image);
  }
  /* // */

  //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  $newheight = 360*($height/$width);
  imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  /* JPEG */
  if($_POST['ext']=='jpg' || $_POST['ext']=='JPG'){
	imagejpeg($thumb,$image,1000); 
    $im = imagecreatefromjpeg($image);
  }
  /* // */
  $dest = imagecreatetruecolor($w,$h);
	
  imagecopyresampled($dest,$im,0,0,$x1,$y1,$w,$h,$w,$h);
  /* JPEG */
  if($_POST['ext']=='jpg' || $_POST['ext']=='JPG'){ 
  	imagejpeg($dest,"profil/".$name.'_small.'.$ext, 1000);
  }
  /* // */
  echo '<br><img src="profil/'.$name.'.'.$ext.'"/><br>';
  echo '<br><img src="profil/'.$name.'_small.'.$ext.'"/><br>';
}
?>