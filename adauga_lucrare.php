<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	$template_id = $_GET['template_id'];
	
	$sql = "SELECT as_camp.camp_id, as_camp.denumire_coloana, as_legatura_template_camp.denumire_locala FROM as_legatura_template_camp, as_camp WHERE as_camp.camp_id = as_legatura_template_camp.camp_fk AND as_legatura_template_camp.template_fk = ".$template_id;
  // echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die($message);
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
        die ( mysql_error () );
      }
    }
    else {
      trigger_error ( mysql_error(), E_USER_ERROR );
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
		
		
	
	if (isset($_POST['doi'])){
		$doi = $_POST['doi'];
		$sql = "INSERT INTO as_lucrare(cadru_didactic_fk, template_fk, an_universitar_fk, prim_autor,  ".$str_campuri.") "
 			." VALUES(".$_SESSION['UserID']. ", ". $template_id.", ".$an_universitar.", ".$prim_autor.", ".$str_valori.")";
	}
	if (!isset($_POST['prim_autor'])){
		$sql = "INSERT INTO as_lucrare(cadru_didactic_fk, template_fk, an_universitar_fk, ".$str_campuri.") "
 			." VALUES(".$_SESSION['UserID']. ", ". $template_id.", ".$an_universitar.", ".$str_valori.")";
	}
	
	else{
		$sql = "INSERT INTO as_lucrare(cadru_didactic_fk, template_fk, an_universitar_fk, prim_autor, ".$str_campuri.") "
  			." VALUES(".$_SESSION['UserID']. ", ". $template_id.", ".$an_universitar.", ".$prim_autor.", ".$str_valori.")";
	}

//debug incarcare info lucrari
   echo $sql."</br>";
 
   $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
		mysql_select_db($database_cercetare);
      	@mysql_query("SET NAMES UTF8");

      	if ( @mysql_query($sql)){
			$id_lucrare  = mysql_insert_id();
			
			for ($i=0; $i<11; $i++){
				if (isset($_POST['index_autor_ULBS'.$i]) && isset($_POST['nume_autor_ULBS'.$i]) && $_POST['index_autor_ULBS'.$i] != "-1"){
					$sql = "INSERT INTO istoric_lucrari (lucrare_fk, cadru_didactic_fk, index_ordine) 
					VALUES(".$id_lucrare.", ".$_POST['nume_autor_ULBS'.$i].", ".$_POST['index_autor_ULBS'.$i].")";
					@mysql_query($sql);
//					echo $_POST['index_autor_ULBS'.$i]," - ", $_POST['nume_autor_ULBS'.$i];
				}
				if (isset($_POST['index_autor_extern'.$i]) && isset($_POST['nume_autor_extern' .$i]) && $_POST['index_autor_extern' .$i] !="-1"){
					$sql = "INSERT INTO autor_extern SET nume_autor = '".$_POST['nume_autor_extern' .$i]."'";
					if ( @mysql_query($sql)){
						$id_autor_extern  = mysql_insert_id();
						}
					else{ die ( mysql_error () ); exit;}
					

					
					$sql = "INSERT INTO istoric_lucrari (lucrare_fk, autor_extern_fk, index_ordine)
					 VALUES(".$id_lucrare.", ".$id_autor_extern.", ".$_POST['index_autor_extern'.$i].")";
					 @mysql_query($sql);
//					echo $_POST['index_autor_extern'.$i]," - ", $_POST['nume_autor_extern'.$i];
				}
			}
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