<?php

// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
	if ( $connect ){
		mysql_select_db($database_cercetare);
	}
if ($tip == "ro") {

	$query = "SELECT cv_ro, cv_ro_size FROM cv where cadru_didactic_fk='".$cadru_didactic_id."'";

	if(!	$result = MYSQL_QUERY($query)) {

		die(mysql_error());

	}

	else {

		$cv_ro = MYSQL_RESULT($result,0,"cv_ro");

		$cv_ro_size = MYSQL_RESULT($result,0,"cv_ro_size");

		$cv_ro_file_name = urldecode("cv_ro.pdf");

		header('Content-Type: application/octet-stream');

		header('Content-Length: '.$cv_ro_size);

		header('Content-Disposition: attachment; filename="'.$cv_ro_file_name.'"');

		header('Content-Transfer-Encoding: binary');

		print $cv_ro;

	}

}

if ($tip == "en") {

	$query = "SELECT cv_en, cv_en_size FROM cv where cadru_didactic_fk='".$cadru_didactic_id."'";

	if(!	$result = MYSQL_QUERY($query)) {

		die(mysql_error());

	}

	else {

		$cv_en = MYSQL_RESULT($result,0,"cv_en");

		$cv_en_size = MYSQL_RESULT($result,0,"cv_en_size");

		$cv_en_file_name = urldecode("cv_en.pdf");

		header('Content-Type: application/octet-stream');

		header('Content-Length: '.$cv_en_size);

		header('Content-Disposition: attachment; filename="'.$cv_en_file_name.'"');

		header('Content-Transfer-Encoding: binary');

		print $cv_en;

	}

}
mysql_close($connect);
?> 