<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$=$_POST[""];
	$modificare=$_POST["modificare"];
	$titlu=$_POST["titlu"];
	$prenume = $_POST['prenume'];
    $nume = $_POST['nume'];
    $email = $_POST['email'];
    $descriere = $_POST['descriere'];
    $descriere64 = base64_encode($_POST['descriere']);
	$departament = $_POST['departament'];
	$centru = $_POST['centru'];
	$link_personal = $_POST['link_personal'];
	$sql_type_date = $_POST['sql_type_date'];

	//add
	if ($sql_type_date == 0){
		$sql = "INSERT INTO cercetatori (, modificare, titlu, prenume, nume, mail, departament, centru, link_personal)
				VALUES  ('".$."', '".$modificare."', '".$titlu."', '".$prenume."', '".$nume."', '".$email."', '".$departament."', '".$centru."', '".$link_personal."');";
			//DEBUG	echo $sql.'<br>';
	}
	//update
	if ($sql_type_date == 1){
		$sql = 	"UPDATE cercetatori SET modificare='".$modificare."', titlu='".$titlu."', prenume='".$prenume."', nume='".$nume."', mail='".$email."', descriere='".$descriere64."', departament='".$departament."', centru='".$centru."', link_personal='".$link_personal."' WHERE ='".$."'";
	}
	/* DEBUG 	echo $sql.'<br>';*/
   $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		if ( @mysql_query($sql) ){
			header("Location: ./index.php");
		}
		else {
			//header("Location: ./index.php");
			//die ( mysql_error () );
			echo ( mysql_error () );
		}
    }
    else {
		trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
?>