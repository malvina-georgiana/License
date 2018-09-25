<?php
// Check if user is authorized != Throw out
  	
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	
	$disciplina_id = $_GET['disciplina_id'];
	//echo $disciplina_id ;
	//echo "dasdsa";
	//exit;
  	
  	$sql_disciplina = "DELETE FROM istoric_discipline WHERE istoric_discipline_id = ".$disciplina_id;
	//echo $sql_disciplina."</br>";
	//exit;
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql_disciplina)){
		header("Location: ./index.php");
		
      }
      else {
      	header("Location: ./index.php");
	  	//die ( mysql_error () );
      }
    }
    else {
      trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
?>