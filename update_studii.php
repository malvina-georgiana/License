<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$sql_type_studii = $_GET['sql_type_studii'];
	$cadru_didactic_id = $_GET['cadru_didactic_id'];
	$tip_studii = $_GET['tip_studii'];
    $domeniu = $_GET['domeniu'];
    $specializare = $_GET['specializare'];
	$an_absolvire = $_GET['an_absolvire'];





	//add
//	if ($sql_type_studii == 0){
		$sql = "INSERT INTO istoric_studii (cadru_didactic_fk, program_fk, domeniu, specializare, an_absolvire)
				VALUES  ('".$cadru_didactic_id."', '".$tip_studii."', '".$domeniu."', '".$specializare."', '".$an_absolvire."')";
//	}
	//update
//	if ($sql_type_studii == 1){
	//	$sql = 	"UPDATE cadru_didactic SET 
		//		prenume='".$prenume."', nume='".$nume."', email='".$email."', adresa='".$adresa."', facultate_fk='"
			//	.$facultate_id."', departament_fk='".$departament_id."', telefon_mobil='".$telefon_mobil."', telefon_birou='"
				//.$telefon_birou."' WHERE cadru_didactic_id='".$cadru_didactic_id."'";
//	}
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