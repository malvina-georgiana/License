<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
//	include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	
	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

	if ( $connect ){
//interogare
	$sql_autori = "SELECT cadru_didactic_id, CONCAT(nume, ' ',prenume) AS nume_complet FROM cadru_didactic";

	mysql_select_db($database_cercetare);
    @mysql_query("SET NAMES UTF8");
	
    $arWrapper = array();        	
	
	if ( @mysql_query($sql_autori)){
		$result_autori = mysql_query ( $sql_autori );
		$rows = mysql_num_rows($result_autori);
//echo $rows;
		if (!$result_autori) {
		  die($message);
		}
		while($row = mysql_fetch_assoc($result_autori)){ 
			$autori[$row['cadru_didactic_id']] = $row['nume_complet'];
			//$citare_id[] = $row['citare_id'];			
		}
				echo "1";
		foreach ($autori as $key =>$value){
		//$autori_keys = $key;
        $arWrapper[$key]['id'] = $key;
        $arWrapper[$key]['nume'] = $value; 
		echo "1";
		}
	}
	else {
		die ( "Error2".mysql_error () );
	  }
	}
else {
	trigger_error ( "Error3".mysql_error(), E_USER_ERROR );
}



print json_encode($arWrapper);
	
mysql_close($connect);
	
	
?>