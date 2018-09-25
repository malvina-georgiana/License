<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$lucrare_id = $_GET['lucrare_id'];
	
	
	$sql = "SELECT template_fk FROM as_lucrare WHERE lucrare_id = ".$lucrare_id;
    echo $sql."</br>";
     $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die($message);
        }

            while($row = mysql_fetch_assoc($result)){ 
				$template_id = $row[template_fk];
			}
			
      }
      else {
        die ( mysql_error () );
      }
    }
    else {
      trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
  	
  	$sql_lucrare = "DELETE FROM as_lucrare WHERE lucrare_id = ".$lucrare_id;
	$sql_citate = "DELETE FROM citari WHERE lucrare_fk = ".$lucrare_id;
	$sql_select_autori_externi = "SELECT autor_extern_fk FROM istoric_lucrari WHERE lucrare_fk = ".$lucrare_id;
	$sql_istoric_lucrari = "DELETE FROM istoric_lucrari WHERE lucrare_fk = ".$lucrare_id;
//echo $sql_lucrare."</br>";
//echo $sql_citate."</br>";
	//break;
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");
  
      if ( @mysql_query($sql_lucrare)  and @mysql_query($sql_citate) ){
		$result = mysql_query($sql_select_autori_externi);
          if (!$result) {
          die(mysql_error ());
        }
		else{
            while($row = mysql_fetch_assoc($result)){ 
				$sql_delete_autori_externi =  "DELETE FROM autor_extern WHERE id = ".$row[autor_extern_fk];
				if ( @mysql_query($sql_delete_autori_externi)){
					header("Location: ./lucrare.php?template_id=".$template_id);
				}
				else{
					die(mysql_error ());
					}
			}
		}
		   @mysql_query($sql_istoric_lucrari);
		  
		header("Location: ./lucrare.php?template_id=".$template_id);
		
      }
      else {
      	header("Location: ./lucrare.php?template_id=".$template_id);
	  	die ( mysql_error () );
      }
    }
    else {
      trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
?>