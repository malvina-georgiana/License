<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$studii_id = $_GET['studii_id'];
  	
  	$sql_studii = "DELETE FROM istoric_studii WHERE studii_id = ".$studii_id;
//echo $sql_lucrare."</br>";
//echo $sql_citate."</br>";
	//break;
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql_studii)){
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