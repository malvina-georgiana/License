<?php
if (!function_exists("createThumbs")) {
function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
{
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      echo "Creating thumbnail for {$fname} <br />";

      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
    // continue only if this is a PNG image
    if ( strtolower($info['extension']) == 'png' ) 
    {
      echo "Creating thumbnail for {$fname} <br />";

      // load image and get image size
      $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
	// continue only if this is a GIF image
    if ( strtolower($info['extension']) == 'gif' ) 
    {
      echo "Creating thumbnail for {$fname} <br />";

      // load image and get image size
      $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new tempopary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
	if ( strtolower($info['extension']) == 'bmp' )
	{
		echo 'Creating thumbnail for '."{$fname}".' - <span style="color: #f00;">failed [incorrect format]</span><br />';
	}		
  }
  
  // close the directory
  closedir( $dir );
}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$name     = $_FILES['file']['name'];
	$tmpName  = $_FILES['file']['tmp_name'];
	$error    = $_FILES['file']['error'];
	$size     = $_FILES['file']['size'];
    $ext	  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
	
	echo '<b>Debug:</b><br><br>Name = '.$name.'<br>tmpName = '.$tmpName.'<br>error = '.$error.'<br>size = '.$size.'<br>ext = '.$ext.'<br>';
  
	switch ($error) {
		case UPLOAD_ERR_OK:
			$valid = true;
			//validate file extensions
			if ( !in_array($ext, array('jpg','jpeg','png','gif')) ) {
				$valid = false;
				$response = 'Invalid file extension.';
			}
			//validate file size
			if ( $size/1024/1024 > 2 ) {
				$valid = false;
				$response = 'File size is exceeding maximum allowed size.';
			}
			//upload file
			if ($valid) {
				$targetPath =  dirname( __FILE__ ) . DIRECTORY_SEPARATOR. 'profil' . DIRECTORY_SEPARATOR. $name;
				echo "Debug: ".$targetPath."<br>";
				move_uploaded_file($tmpName,$targetPath); 
				createThumbs("profil/","profil/",256);
				// header( 'Location: index.php' ) ;
				// exit;
			}
			break;
		case UPLOAD_ERR_INI_SIZE:
			$response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
			break;
		case UPLOAD_ERR_PARTIAL:
			$response = 'The uploaded file was only partially uploaded.';
			break;
		case UPLOAD_ERR_NO_FILE:
			$response = 'No file was uploaded.';
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
			break;
		default:
			$response = 'Unknown error';
		break;
	}
echo $response;
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="crop_style.css">
  <script type="text/javascript" src="../obj/script/jquery.js"></script>
  <script type="text/javascript" src="../obj/script/jquery-ui.js"></script>
  <script type="text/javascript">

    $(function() {
      $( "#crop_div" ).draggable({ containment: "parent" });
    });
   
    function crop()
    {
      var posi = document.getElementById('crop_div');
      document.getElementById("top").value=posi.offsetTop;
      document.getElementById("left").value=posi.offsetLeft;
      document.getElementById("right").value=posi.offsetWidth;
      document.getElementById("bottom").value=posi.offsetHeight;
      document.getElementById("ext").value='<?php echo $ext; ?>';
      document.getElementById("name").value='<?php echo substr($name,0,-4); ?>';
      return true;
    }

  </script>
</head>

<body>

<div id="crop_wrapper">
  <img src="profil/<?php echo $name; ?>">
  <div id="crop_div">
  </div>
</div>

<form method="post" action="do_crop.php" onsubmit="return crop();">
  <input type="hidden" value="" id="top" name="top">
  <input type="hidden" value="" id="left" name="left">
  <input type="hidden" value="" id="right" name="right">
  <input type="hidden" value="" id="bottom" name="bottom">
  <input type="hidden" value="" id="ext" name="ext">
  <input type="hidden" value="" id="name" name="name">
  <input type="submit" name="crop_image">
</form>

</body>
</html>