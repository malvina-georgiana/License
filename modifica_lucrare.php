<?php 
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
?>
<LINK REL=stylesheet HREF="//home/cercetare/obj/src/global.css">
<script language="JavaScript">

function change_an(template_id, an_universitar_id){  
  openURL("lucrare.php?template_id="+template_id+"&an="+an_universitar_id, 0);
}

function change_unic_autor(){ 
  	if (document.getElementById("combo_autor_unic").value == 0){
//	  document.getElementById("input_nr_autori"). = false;
		document.getElementById("label_nr_autori").style.display = 'block';
		document.getElementById("input_nr_autori").style.display = 'block';
  	}
  	if (document.getElementById("combo_autor_unic").value == 1){
	  	document.getElementById("input_nr_autori").value = 1;
	  	document.getElementById("label_nr_autori").style.display = 'none';
	  	document.getElementById("input_nr_autori").style.display = 'none';
  	}
}

function openURL(url, opt){
  if (opt == 0) // current window
    window.location = url;
  else if (opt == 1) // new window
    window.open(url);
  else if (opt == 2) // background window
    {window.open(url); self.focus();}
}

</script>

<?php
	$template_id = $_GET['template_id'];
	$lucrare_id = $_GET['lucrare_id'];
	$id_cont = $_SESSION['UserID'];
/*	$an_universitar_id = $_GET['an'];
	if(!isset($an_universitar_id)){
		$an_universitar_id = 1;
	}
*/
		$sql = "SELECT as_template.template_denumire_completa FROM as_template WHERE as_template.template_id = ".$template_id;
	    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
	//	echo "sql = ".$sql;
	if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("1".$message);
        }
            $rows = mysql_num_rows($result);
                                                                    
            while($row = mysql_fetch_assoc($result)){ 
                  //print "<h1>".$row['grupa_descriere']."</h1>";
				  $template_denumire = $row['template_denumire_completa'];
				 // print " pagina = ".$pagina;
            } 
      }
      else {
        die ( "2".mysql_error () );
      }
    }
    else {
      trigger_error ( "3".mysql_error(), E_USER_ERROR );
    }
    //mysql_close($connect);
	print "<H2 CLASS='PageSubtitle'>Modificare ".$template_denumire."</H2>";
	
//$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
$sql = "SELECT grupa_id, grupa_denumire, template_denumire_completa FROM as_grupa, as_template WHERE  grupa_id = grupa_fk AND template_id = ".$template_id;
//$connectr = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
//	echo "sql = ".$sql;
if ( $connect ){
  mysql_select_db($database_cercetare);
  @mysql_query("SET NAMES UTF8");

  if ( @mysql_query($sql)){
	$result = mysql_query ( $sql );
	$resultgrupa = mysql_query ( $sql );
	if (!$result) {
	  die($message);
	}
		$rows = mysql_num_rows($result);
																
		while($row = mysql_fetch_assoc($result)){ 
			  //print "<h1>".$row['grupa_descriere']."</h1>";
			  $template_denumire = $row['template_denumire_completa'];
			  $grupa_id = $row['grupa_id'];
			  $grupa_denumire = $row['grupa_denumire'];
			 // print " pagina = ".$pagina;
		} 
  }
  else {
	die ( mysql_error () );
  }
}
else {
  trigger_error ( mysql_error(), E_USER_ERROR );
}
//mysql_close($connectr);

echo"<link rel=stylesheet href='/obj/src/menu.css'>
	<div id='navcontainer' align='center'>
	  <ul>
		<li><small><strong><a href='../'>Profil </a></strong></small></li>
		<li><small><strong>.:</strong></small></li>	
		<li><small><strong><a href='./'>cercetare universitară</a></strong></small></li>
		<li><small><strong>.:</strong></small></li>	
		<li><small><strong><a href='./grupa.php?grupa_id=".$grupa_id."'>".$grupa_denumire."</a></strong></small></li>
		<li><small><strong>.:</strong></small></li>	
		<li><small><strong><a href='./lucrare.php?template_id=".$template_id."' style='color:#FF0000'>".$template_denumire."</a></strong></small></li>
	</ul></div>";	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>

	<br>

<?php
//	print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"2000\">";
	$sql = "SELECT as_camp.camp_id, as_camp.denumire_coloana, as_legatura_template_camp.denumire_locala FROM as_legatura_template_camp, as_camp WHERE as_camp.camp_id = as_legatura_template_camp.camp_fk AND as_legatura_template_camp.template_fk = ".$template_id;
  // echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("4".$message);
        }
            $rows = mysql_num_rows($result);
            $i = 0;        
			$str_conditie = '';
			$str_campuri = '';
            while($row = mysql_fetch_assoc($result)){ 
				  $array_coduri_campuri[] = $row['camp_id'];
				  $array_denumiri_campuri[] = $row['denumire_locala'];
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
        die ("5". mysql_error () );
      }
    }
    else {
      trigger_error ("6". mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
	
	$sql = "SELECT prim_autor AS prim_autor, an_universitar_fk, ".$str_campuri." FROM as_lucrare, as_template 
			WHERE as_lucrare.template_fk = as_template.template_id 
			AND as_lucrare.cadru_didactic_fk = ".$id_cont." 
			AND as_template.template_id = ".$template_id." 
			AND as_lucrare.lucrare_id = ".$lucrare_id;
    //echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("7".$message);
        }
            $rows = mysql_num_rows($result);
            while($row = mysql_fetch_assoc($result)){ 
		//		$array_final[] = array('prim_autor' => $row['prim_autor']);
		//		$array_final[] = array('an_universitar_fk' => $row['an_universitar_fk']);
				$array_final['prim_autor'] = $row['prim_autor'];
				$array_final['an_universitar_fk'] = $row['an_universitar_fk'];
	 			foreach ($array_denumiri_coloane as $index => $value) {
					$array_final[$array_denumiri_coloane[$index]] = $row[$array_denumiri_coloane[$index]];
				}//foreach
			 }//while
      }
      else {//if($mysql_query)
        die ("8". mysql_error () );
      }
    }//if($connect
    else {
      trigger_error ( "9".mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
	//echo "array_final = ".$array_final;
	//exit;
//	foreach ($array_final as $index => $value) {
//			echo "index = ".$index." value = ".$value."</br>";
//	}
//	exit;
	print "<br><br><br>";

	print "<form enctype='multipart/form-data' action='modifica.php?template_id=".$template_id."&lucrare_id=".$lucrare_id."' method='post' name='FormModificaLucrare'>";
    	print "<H2 CLASS='PageSubtitle'>Modifică lucrare:</H2>";
		print "<br>";
	print "<table border='0' cellpadding='0' cellspacing='0' align='left'>";
		
	$sql = "SELECT an_universitar_id, an_universitar FROM an_universitar ORDER BY an_universitar";
    //  echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");
  
      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("10".$message);
        }
        $rows = mysql_num_rows($result);  
		echo "<tr><td>An universitar :</td><td><select name='an_universitar' id='combo_an_universitar' style='width:260px;'>";
		while($row = mysql_fetch_assoc($result)){
			if($array_final['an_universitar_fk'] == $row['an_universitar_id']){
				echo "<option selected='yes' value='".$row['an_universitar_id']."'>".$row['an_universitar']."</option>";
			}
			else{
				echo "<option value='".$row['an_universitar_id']."'>".$row['an_universitar']."</option>";				
			}
 		 }
		 echo "</td></tr>";
	  }
	   else {
		  die ("11".mysql_error ());
	  }
	}
	else {
	 trigger_error ( "12".mysql_error(), E_USER_ERROR );
	}
	mysql_close($connect);
	print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			
	$sql = "SELECT as_legatura_template_camp.denumire_locala AS denumire, as_camp.denumire_coloana AS denumire_coloana
			FROM as_camp, as_legatura_template_camp WHERE as_legatura_template_camp.camp_fk = as_camp.camp_id
			AND as_legatura_template_camp.template_fk = ".$template_id;
 //   echo $sql."</br>";
    $connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
      mysql_select_db($database_cercetare);
      @mysql_query("SET NAMES UTF8");

      if ( @mysql_query($sql)){
        $result = mysql_query ( $sql );
        if (!$result) {
          die("13".$message);
        }
            $rows = mysql_num_rows($result);
            //$i = 1;                                                        
            while($row = mysql_fetch_assoc($result)){
				//echo $row['denumire_coloana']."<br />";
//  -= pentru ISI / ERA =-	
				if($row['denumire_coloana'] == 'isi_era'){
					echo "<tr>
						<td>ISI / ERA :</td><td><select name='isi_era' id='combo_ISI_ERA' style='width:260px;'>";
					
					if ($array_final[$row['denumire_coloana']] == 'ERA'){
						echo" <option value='ERA' selected = 'yes'>ERA</option>";
					}
					else{
						echo" <option value='ERA'>ERA</option>";
					}
					
					if ($array_final[$row['denumire_coloana']] == 'ISI'){
						echo" <option value='ISI' selected = 'yes'>ISI</option>";
					}
					else{
						echo" <option value='ISI'>ISI</option>";
					}
					if ($array_final[$row['denumire_coloana']] == 'ISI&ERA'){
						echo" <option value='ISI&ERA' selected = 'yes'>ISI&ERA</option>";
					}
					else{
						echo" <option value='ISI&ERA'>ISI&ERA</option>";
					}						
					echo"</select></td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
				}
//  -= pentru contracte DIRECTOR/MEMBRU =-	
				if($row['denumire_coloana'] == 'membru'){
					echo "<tr>
						<td>Funcţia :</td><td><select name='membru' id='combo_functie' style='width:260px;'>";
					
					if ($array_final[$row['denumire_coloana']] == 'membru'){
						echo"<option value='director'>director</option>
	  						 <option value='membru' selected = 'yes'>membru</option>
							 </select></td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
					}
					else{
						echo"<option value='director' selected = 'yes'>director</option>
							 <option value='membru'>membru</option>
							 </select></td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
					}
				}
				elseif($row['denumire_coloana'] == 'nr_autori'){
					echo "<tr>
						<td>Autor unic:</td><td><select name='autor_unic' id='combo_autor_unic' 
						onChange=\"change_unic_autor()\"; style='width:260px;'>
						<option value='1'>Da</option>
						<option value='0'>Nu</option>
						</td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>
						<tr>
						<td id='label_nr_autori' size='40' style='display:none'>Număr autori:</td>
						<td><input name='nr_autori' id='input_nr_autori' type='text' size='40' value='1' style='display:none' /></td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
				}
		
		
		
		
//  -= pentru restul lumii =-				
				else{
					echo "<tr> 
						<td width='300'>" . $row['denumire'] . " :</td>
						<td width='400'><input name='".$row['denumire_coloana']."' type='text' value='".$array_final[$row['denumire_coloana']]."'size='40' /></td> 
						</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
				}
			} 
      }
      else {
        die ( "14".mysql_error () );
      }
    }
    else {
      trigger_error ( mysql_error(), E_USER_ERROR );
    }
    mysql_close($connect);
	
	if($array_final['prim_autor'] == 0 ){
	    echo "<tr><td>Prim autor :</td><td><select name='prim_autor' id='combo_prim_autor' style='width:260px;'>
			<option selected = 'selected' value='0'>Nu</option>
			<option value='1'>Da</option></td></tr>";
	}
	if($grupa_id == 5){
	}
	else{
		echo "<tr><td>Prim autor :</td><td><select name='prim_autor' id='combo_prim_autor' style='width:260px;'>
			<option value='0'>Nu</option>
			<option selected = 'selected' value='1'>Da</option></td></tr>";
	}
	echo "</tr>
		 <tr>
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td>
		 </tr> 
		 <tr>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;<input name='modifica_lucrare' type='submit' align='right' value='Modifică' /></td>
		  </tr>
		  <tr>
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td>
		  </tr> 
		 </table>
		 </form>";   
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php';?>
 </body>
</html>


