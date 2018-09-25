<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';

$cadru_didactic_id = $_POST['cadru_didactic_id'];
//proceses ro_cv info
$ro_cv_file =  addslashes(fread(fopen($_FILES['ro_cv_file']['tmp_name'], "r"), $_FILES['ro_cv_file']['size'])); 
$ro_cv_file_name = addslashes(basename( $_FILES['ro_cv_file']['name']));
$ro_cv_file_size = $_FILES['ro_cv_file']['size'];
$ro_cv_file_type = $_FILES['ro_cv_file']['type'];
//proceses en_cv info
$en_cv_file = addslashes(fread(fopen($_FILES['en_cv_file']['tmp_name'], "r"), $_FILES['en_cv_file']['size'])); 
$en_cv_file_name = addslashes(basename( $_FILES['en_cv_file']['name']));
$en_cv_file_size = $_FILES["en_cv_file"]['size'];
$en_cv_file_type = $_FILES["en_cv_file"]['type'];

if ($_FILES["ro_cv_file"]["error"] > 0)
  {
  echo "Eroare citire curriculum vitae în limba română: " . $_FILES["ro_cv_file"]["error"] . "<br />";
  }
if ($_FILES["en_cv_file"]["error"] > 0)
  {
  echo "Eroare citire curriculum vitae în limba engleză: " . $_FILES["en_cv_file"]["error"] . "<br />";
  }  
else
  {
	  //echo $cadru_didactic_id;
	//echo "Upload: " . $_FILES["ro_cv_file"]["name"] . "<br />";
  //echo "Type: " . $_FILES["ro_cv_file"]["type"] . "<br />";
  //echo "Size: " . ($_FILES["ro_cv_file"]["size"] / 1024) . " Kb<br />";
  //echo "Stored in: " . $_FILES["ro_cv_file"]["tmp_name"];
  //exit;
  }

if ($ro_cv_file_name != '' || $en_cv_file_name !=''){
//adauga cv nou sau actualizeaza unul exitent

	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
	if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");	
		$sql_query_string = "INSERT INTO cv (cadru_didactic_fk, cv_en, cv_ro, cv_en_size, cv_ro_size) ". 
							"VALUES ('$cadru_didactic_id','$en_cv_file','$ro_cv_file', $en_cv_file_size, $ro_cv_file_size)".
							"ON DUPLICATE KEY UPDATE cv_en = '$en_cv_file', cv_ro = '$ro_cv_file', 
							cv_en_size = '$en_cv_file_size', cv_ro_size = '$ro_cv_file_size'";	
		if ($ro_cv_file_name == '' && $en_cv_file_name ==''){
			die('Nu a fost selectat nici un fi&#351;ier.');
		}
		if(!$result=MYSQL_QUERY($sql_query_string)) {
			//header("Location: ./index.php");
			die(mysql_error());
		}
		else {
			//if ($ro_cv_file != '') echo "<br /> Încărcarea ro_cv a reuşit. <br /> <br />";
			//if ($en_cv_file != '') echo "<br /> Încărcarea en_cv a reuşit. <br /> <br />";
			header("Location: ./index.php");
		}
	}
}
mysql_close($connect);
?>