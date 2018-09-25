<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$cadru_didactic_id = $_GET['cadru_didactic_id'];
	$an_universitar_id = $_GET['an_universitar_id'];
  	
  	$sql_grad = "DELETE FROM istoric_grad_didactic WHERE cadru_didactic_fk = ".$cadru_didactic_id." AND an_universitar_fk=".$an_universitar_id;
	//echo $sql_grad."</br>";
	//exit;
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql_grad)){
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