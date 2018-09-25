<?php

// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	
	$sql_type_phd = $_GET['sql_type_phd'];
	$cadru_didactic_id = $_GET['cadru_didactic_id'];
	$denumire_teza = $_GET['denumire_teza'];
	$conducator = $_GET['conducator'];
	$domeniu = $_GET['domeniu'];
	$an = $_GET['an_sustinere'];
	
	//add
	if ($sql_type_phd == 0){
		$sql = "INSERT INTO doctorat (denumire_teza, conducator, domeniu_doctorat_fk, an, cadru_didactic_fk)
				VALUES  ('".$denumire_teza ."', '".$conducator ."', '".$domeniu."', '".$an ."', '".$cadru_didactic_id."')";
		//echo $sql;
		//exit;
	}
	//update
	if ($sql_type_phd == 1){
		$sql = 	"UPDATE doctorat SET 
				denumire_teza ='".$denumire_teza ."', conducator ='".$conducator ."',domeniu_doctorat_fk ='".$domeniu ."', an ='".$an ."'
				WHERE cadru_didactic_fk = ".$cadru_didactic_id;
		//echo $sql;
		//exit;
	}

   $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		if ( @mysql_query($sql) ){
			header("Location: ./index.php");
		}
		else {
			header("Location: ./index.php");
			die ( mysql_error () );
		}
    }
    else {
		trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
?>