<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$template_id = $_GET['template_id'];
	$lucrare_id = $_GET['lucrare_id'];
	
	$sql = "SELECT as_camp.camp_id, as_camp.denumire_coloana, as_legatura_template_camp.denumire_locala FROM as_legatura_template_camp, as_camp WHERE as_camp.camp_id = as_legatura_template_camp.camp_fk AND as_legatura_template_camp.template_fk = ".$template_id;
  // echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("1".$message);
        }
            $rows = mysql_num_rows($result);
            $i = 0;        
			$str_conditie = '';
			$str_campuri = '';
            while($row = mysql_fetch_assoc($result)){ 
				  $array_coduri_campuri[] = $row['camp_id'];
				  $array_denumiri_coloane[] = $row['denumire_coloana'];
				  if($i == 0){
					  $str_conditie = '(0, '.$row['camp_id'];
					  $str_campuri = $row['denumire_coloana'];
				  }
				  else{
					  $str_conditie = $str_conditie.', '.$row['camp_id'];
					  $str_campuri = $str_campuri.', '.$row['denumire_coloana'];
				  }
				  $i ++;
            }
			$str_conditie = $str_conditie.')';
      }
      else {
        die ( "2".mysql_error () );
      }
    }
    else {
      trigger_error ( "3".mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
	
		$str_valori = '';
		$i = 0;
		foreach ($array_denumiri_coloane as $index => $value) {
				//$array_valori[] = $_POST[$array_denumiri_coloane[$index]];
				if($i == 0){
					$str_valori ="'". $_POST[$array_denumiri_coloane[$index]] ."'";
				}
				else{
					$str_valori = $str_valori.", '".$_POST[$array_denumiri_coloane[$index]] ."'";					
				}
			$i ++;
		}
	
		$prim_autor = $_POST['prim_autor'];
		$an_universitar = $_POST['an_universitar'];
	
	$sql_dele = "DELETE FROM as_lucrare WHERE lucrare_id =".$lucrare_id;
	$sql_ins = "INSERT INTO as_lucrare(lucrare_id, cadru_didactic_fk, template_fk, an_universitar_fk, prim_autor, ".$str_campuri.") "
						." VALUES(".$lucrare_id.", ".$_SESSION['UserID']. ", ". $template_id.", ".$an_universitar.", ".$prim_autor.", ".$str_valori.")";

	
   //echo $sql."</br>";
   //exit;
   $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql_dele) && @mysql_query($sql_ins)){
		header("Location: ./lucrare.php?template_id=".$template_id);
      }
      else {
      	header("Location: ./lucrare.php?template_id=".$template_id);
        die ( "4".mysql_error () );
      }
    }
    else {
      trigger_error ( "5".mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
?>