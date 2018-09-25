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

function verifica_titlu()
{/*TODO  poate trebuie verificat daca titlul e unic*/
}

function change_unic_autor(){ 
	if (document.getElementById("combo_autor_unic").value == 0){
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

function deletePaper(lucrare_id){
	var r=confirm("Sunteti sigur ca doriti sa stergeti lucrarea?");
	if (r==true)
	window.location.assign("delete_lucrare.php?lucrare_id="+lucrare_id);  
}

//TODO: dinamically populate indexes
function delete_hidden(){
	for (var i = 0; i<10; i++) {
		var indexid = "id" + i;
		var indexautorULBS = "index_autor_ULBS" + i;
		var numeautorULBS = "nume_autor_ULBS" + i;
		var indexide = "ide" + i;
		var indexautorextern = "index_autor_extern" + i;
		var numeautorextern = "nume_autor_extern" + i;
		if (document.getElementById(indexid).style.display == 'none'){
			var elem = document.getElementById(indexid);
			elem.parentNode.removeChild(elem);
		}
		if (document.getElementById(indexide).style.display == 'none'){
			var elem = document.getElementById(indexide);
			elem.parentNode.removeChild(elem);
		}
	}
}

function update_autori(){ 
	//id0 = id tr	//index_autor_ULBS0 = nr ordine in lista	//nume_autor_ULBS0 = nume autor 
	document.getElementById("nume_autori").value = "";
//	document.getElementById("lista_autori_ULBS").value =""; //	document.getElementById("lista_autori_externi").value="";	//var sel = document.getElementById('nume_autor_ULBS0');	//var selected = sel.options[sel.selectedIndex];	//var extra = selected.getAttribute('data');
	var arrayautori = new Array( );
	var arrayautoriULBS = new Array( );
	var arrayautoriexterni = new Array( );
	for (var i = 0; i<10; i++) {
		var indexid = "id" + i;
		var indexautorULBS = "index_autor_ULBS" + i;
		var numeautorULBS = "nume_autor_ULBS" + i;
		var indexide = "ide" + i;
		var indexautorextern = "index_autor_extern" + i;
		var numeautorextern = "nume_autor_extern" + i;

		if (document.getElementById(indexid).style.display != 'none'){
			arrayautori[document.getElementById(indexautorULBS).value] = 
			document.getElementById(numeautorULBS).options[document.getElementById(numeautorULBS).selectedIndex].getAttribute('data');
			arrayautoriULBS[document.getElementById(indexautorULBS).value] = document.getElementById(numeautorULBS).value;
		}
		if(document.getElementById(indexide).style.display != 'none' && document.getElementById(numeautorextern).value != ""){
			
		 	arrayautori[document.getElementById(indexautorextern).value] = document.getElementById(numeautorextern).value;
			arrayautoriexterni[document.getElementById(indexautorextern).value] = document.getElementById(numeautorextern).value;
		}
	}
//document.getElementById("lista_autori_ULBS").innerHTML = "ULBS: ";//document.getElementById("lista_autori_externi").innerHTML="EXTERNI: ";
	for (var i = 0; i<11; i++) {
		if (arrayautori[i] != undefined){
			if (document.getElementById("nume_autori").value == ""){
				document.getElementById("nume_autori").value = arrayautori[i];
//				if (arrayautoriULBS[i] != undefined){
//					document.getElementById("lista_autori_ULBS").innerHTML =  document.getElementById("lista_autori_ULBS").innerHTML + arrayautoriULBS[i] + "; ";
//				}
//					if (arrayautoriexterni[i] != undefined){
					//alert("externi: " + arrayautoriexterni[i].value);
//					document.getElementById("lista_autori_externi").innerHTML = document.getElementById("lista_autori_externi").innerHTML + arrayautoriexterni[i] + "; ";
//				}
			}
			else{
				document.getElementById("nume_autori").value = document.getElementById("nume_autori").value + ", " + arrayautori[i];
//				if (arrayautoriULBS[i] != undefined){
					//alert("ULBS: " + arrayautoriULBS[i].value);
//					document.getElementById("lista_autori_ULBS").innerHTML =  document.getElementById("lista_autori_ULBS").innerHTML + arrayautoriULBS[i] + "; ";
//				}
//				if (arrayautoriexterni[i] != undefined){
					//alert("externi: " + arrayautoriexterni[i].value);
//					document.getElementById("lista_autori_externi").innerHTML = document.getElementById("lista_autori_externi").innerHTML + arrayautoriexterni[i] + "; ";
	//			}
			}
		}
	}
}
</script>

<?php
$template_id = $_GET['template_id'];
//echo $template_id;
$an_universitar_id = $_GET['an'];
if(!isset($an_universitar_id)){
	$an_universitar_id = 1; 
}

//$sql = "SELECT as_template.template_denumire_completa FROM as_template WHERE as_template.template_id = ".$template_id;
$sql = "SELECT grupa_id, grupa_denumire, template_denumire_completa FROM as_grupa, as_template WHERE  grupa_id = grupa_fk AND template_id = ".$template_id;
$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
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
			$template_denumire = $row['template_denumire_completa'];
			$grupa_id = $row['grupa_id'];
			$grupa_denumire = $row['grupa_denumire'];
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
echo "<H2 CLASS='PageSubtitle'>".$template_denumire."</H2>";

//breadcrumbs
echo"<link rel=stylesheet href='/obj/src/menu.css'>
		<div id='navcontainer' align='center'>
		<ul><li><small><strong><a href='../'>Profil </a></strong></small></li>
			<li><small><strong>.:</strong></small></li>	
			<li><small><strong><a href='./'>cercetare universitară</a></strong></small></li>
			<li><small><strong>.:</strong></small></li>	
			<li><small><strong><a href='./grupa.php?grupa_id=".$grupa_id."'>".$grupa_denumire."</a></strong></small></li>
			<li><small><strong>.:</strong></small></li>	
			<li><small><strong><a href='./lucrare.php?template_id=".$template_id."' style='color:#FF0000'>".$template_denumire."</a>
			</strong></small></li>
			<li><small><strong>.:</strong></small></li>
			<li><small><strong><a href='#jump'>Salt la adăugare element nou</a></strong></small></li>
		</ul></div>";

//combobox an universitar
$sql = "SELECT an_universitar_id, an_universitar FROM an_universitar ORDER BY an_universitar";
//  echo $sql."</br>";
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
		echo "An universitar :&nbsp;&nbsp;<select name='an_universitar_selectat' id='combo_an_universitar_selectat' 
		onChange=\"change_an(".$template_id.", this.options[this.selectedIndex].value);\"style=\"width:260px;\">"; 
		while($row = mysql_fetch_assoc($result)){
			if($row['an_universitar_id'] == $an_universitar_id){
				echo "<option selected='yes' value='".$row['an_universitar_id']."'>".$row['an_universitar']."</option>";
			}
			else{
				echo "<option value='".$row['an_universitar_id']."'>".$row['an_universitar']."</option>";
			}
		}
	}
	else {
		die (mysql_error ());
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}
mysql_close($connect);
echo "</select></br> </br>";

//	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"2000\">";

$sql = "SELECT as_camp.camp_id, as_camp.denumire_coloana, as_legatura_template_camp.denumire_locala FROM as_legatura_template_camp, as_camp 
			WHERE as_camp.camp_id = as_legatura_template_camp.camp_fk AND as_legatura_template_camp.template_fk = ".$template_id;
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
		die ( mysql_error () );
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}
mysql_close($connect);


//lucrari existente
echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
//	echo $array_denumiri_campuri;
echo "<tr>";
foreach ($array_denumiri_campuri as $index => $value) {
	echo "<td width = \"200\" align =\"center\">".$array_denumiri_campuri[$index]."</td>";
}
echo "<td> &nbspPrim autor&nbsp </td> 
			<td> &nbspCitări&nbsp </td>
			
			<td> &nbspŞterge&nbsp </td>
			</tr>";
//<td> &nbspModifică&nbsp </td>
if(isset($an_universitar_id)){
	$sql = "SELECT IF(prim_autor = 1, 'DA', 'NU') AS prim_autor, lucrare_id, ".$str_campuri." FROM as_lucrare, as_template 
			WHERE as_lucrare.template_fk = as_template.template_id AND as_lucrare.cadru_didactic_fk = ".$_SESSION['UserID'].
	" AND as_template.template_id = ".$template_id;
}
if(isset($_GET['an'])){
	$sql = "SELECT IF(prim_autor = 1, 'DA', 'NU') AS prim_autor, lucrare_id, ".$str_campuri." FROM as_lucrare, as_template 
			WHERE as_lucrare.template_fk = as_template.template_id AND as_lucrare.cadru_didactic_fk = ".$_SESSION['UserID'].
	" AND as_template.template_id = ".$template_id." AND as_lucrare.an_universitar_fk = ".$an_universitar_id;	
}

//echo $sql."</br>";
//exit;
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

		echo "<tr>";
		while($row = mysql_fetch_assoc($result)){ 
			
			foreach ($array_denumiri_coloane as $index => $value) {
				echo "<td style=\"word-wrap: break-word; width: 200px;\">",$row[$array_denumiri_coloane[$index]],"</td>";	
			}
			echo "<td> &nbsp",$row[prim_autor],"&nbsp</td>",
			"<td> &nbsp<a href='citari.php?lucrare_id=",$row['lucrare_id'],"&template_id=",$template_id,"'>Citări</a>&nbsp </td>",
			"<td> &nbsp<a href='' onclick='deletePaper(".$row['lucrare_id'].")'>Şterge</a>&nbsp </td>",
			"</tr>"; 
//	"<td> &nbsp<a href='modifica_lucrare.php?template_id=",$template_id,"&lucrare_id=",$row['lucrare_id'],"'>Modifică</a>&nbsp</td>",			
			
		}
		echo "</table><br><br>";
	}
	else {
		die ( mysql_error () );
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}
mysql_close($connect);	
?>

<?php
//-= ADAUGA LUCRARE =-
echo "<A NAME='jump'></A>";
echo "<form enctype='multipart/form-data' action='adauga_lucrare.php?template_id=",$template_id,"' method='post' name='FormAdaugaLucrare' id='FormAdaugaLucrare' onsubmit=\"delete_hidden()\">";
echo "<H2 CLASS='PageSubtitle'>Adaugă ".$template_denumire.":</H2>";
echo "<br>";
echo "<table border='0' cellpadding='0' cellspacing='0' align='left'>";



$sql = "SELECT an_universitar_id, an_universitar FROM an_universitar ORDER BY an_universitar";
//  echo $sql."</br>";
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
		echo "<tr><td>An universitar :</td><td><select name='an_universitar' id='combo_an_universitar' style='width:265px;'>";
		while($row = mysql_fetch_assoc($result)){
			echo "<option value='",$row['an_universitar_id'],"'>",$row['an_universitar'],"</option>";
		}
		echo "</td></tr>";
	}
	else {
		die (mysql_error ());
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}
mysql_close($connect);
echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";


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
			die($message);
		}
		$rows = mysql_num_rows($result);
		while($row = mysql_fetch_assoc($result)){ 
			
			//-= creez combobox pentru articole ISI ERA =-
			if($row['denumire_coloana'] == 'isi_era'){
				echo "<tr>
						<td>ISI / ERA :</td><td><select name='isi_era' id='combo_ISI_ERA' style='width:265px;'>
						<option value='ERA'>ERA</option>
						<option value='ISI'>ISI</option>
						<option value='ISI&ERA'>ISI & ERA</option>
						</td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
			}
			
			//-= creez combobox pentru AUTOR UNIC =-
			elseif($row['denumire_coloana'] == 'nr_autori'){
				echo "<tr>
						<td>Autor unic:</td><td><select name='autor_unic' id='combo_autor_unic' 
						onChange=\"change_unic_autor()\"; style='width:265px;'>
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
			
			//-= pun valoare default pentru editura "Editura ULBS" =-
			elseif($row['denumire_coloana'] == 'editura'){
				echo "<tr>",
				"<td width='300'>", $row['denumire'], " :</td>",
				"<td width='400'><input name='" , $row['denumire_coloana'] , "' type='text' size='40' value='Editura ULBS'/></td>",
				"</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			}
			
			//-= creez combobox pentru FUNCTIE IN CADRUL CONTRACTELOR  =-
			elseif($row['denumire_coloana'] == 'membru'){
				echo "<tr>
						<td>Funcţia:</td><td><select name='membru' id='combo_membru'>
						<option value='director'>director</option>
						<option value='membru'>membru</option>
						</td>
						</tr>
						<tr>
						<td>&nbsp;</td><td>&nbsp;</td>
						</tr>";
			}
			elseif($row['denumire_coloana'] == 'titlu'){
				echo "<tr>",
				"<td width='300'>", $row['denumire'], " :</td>",
				"<td width='400'><input name='" , $row['denumire_coloana'] , "' type='text' size='100' /></td>",
				"</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			}
			elseif($row['denumire_coloana'] == 'nume_autori'){
				echo "<tr>",
				"<td width='300'>", $row['denumire'], " :</td>",
				"<td width='400'><input name='" , $row['denumire_coloana'] , "' id='" , $row['denumire_coloana'] , "' type='text' size='100'/></td>",
				"</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			}
			else{
				echo "<tr>",
				"<td width='300'>", $row['denumire'], " :</td>",
				"<td width='400'><input name='" , $row['denumire_coloana'] , "' type='text' size='40' /></td>",
				"</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
			}
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

if($template_id == 11){	//daca tine de doctorat
	echo "<tr>
				<td>&nbsp;</td><input type='hidden' name='prim_autor' id='combo_prim_autor' value='0'><td></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>";
}
if($template_id == 20){	//daca tine de invited speaker
	echo "<tr>
				<td>&nbsp;</td><input type='hidden' name='prim_autor' id='combo_prim_autor' value='1'><td></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>";
}
if($grupa_id == 5){
}
else { 
	echo "<tr>
					<td>Prim autor :</td>
					<td><select name='prim_autor' id='combo_prim_autor' style='width:265px;'>
					<option selected='yes' value='1'>Da</option>
					<option value='0'>Nu</option></td>
				</tr>
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td>
				</tr>";
}
//	if($grupa_id == 2){
//			echo "<tr>
//					<td>Autor unic:</td><td><select name='unic_autor' id='combo_unic_autor' style='width:265px;'>
//					<option selected='yes' value='0'>Nu</option><option value='1'>Da</option></td>
//				</tr>
//				<tr>
//					<td>&nbsp;</td><td>&nbsp;</td>
//				</tr>";	
//	}

if($grupa_id == 1 or $grupa_id == 2 or $grupa_id == 4){
	
	$sql = "SELECT cadru_didactic_id, nume, prenume FROM cadru_didactic ORDER BY nume";
	//  echo $sql."</br>";
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
			
			//selectarea autorilor din ULBS
			echo "<tr name='id0' id='id0'>
			
			<td>ID / Nume autor din ULBS:</td><td>
			<table>
				<tr><td><select onchange=","update_autori()"," name='index_autor_ULBS0' id='index_autor_ULBS0'>
			<option value='-1'> </option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>
			<option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select>";	
			echo "<select onchange=","update_autori()"," name='nume_autor_ULBS0' id='nume_autor_ULBS0'>";
			echo "<option value='-1' data=''>Alege&#539;i un autor</option>";
			while($row = mysql_fetch_assoc($result)){
				echo "<option value='",$row['cadru_didactic_id'],"' data='",$row['nume']," ",$row['prenume'],"'>",$row['nume']," ",$row['prenume'],"</option>";
			}
			echo '</select></td><td onclick="document.getElementById(',"'id1'",').style.display=',"''",';update_autori();" align="left" style="cursor:default;">+</td></tr> </table></td></tr>';
		}
		else {
			die (mysql_error ());
		}
	}
	else {
		trigger_error ( mysql_error(), E_USER_ERROR );
	}

	for ($i=1; $i<=9; $i++){
		mysql_data_seek($result, 0);
		echo "<tr name='id",$i,"' id='id",$i,"' style='display:none'>
				<td >ID / Nume autor din ULBS:</td><td>
				<table><tr><td><select onchange=","update_autori()","  name='index_autor_ULBS",$i,"' id='index_autor_ULBS",$i,"'>
				<option value='-1'> </option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>
				<option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select>";	
		echo "<select onchange=","update_autori()","  name='nume_autor_ULBS",$i,"' id='nume_autor_ULBS",$i,"'>";
		echo "<option value='-1' data=''>Alege&#539;i un autor</option>";
		while($row = mysql_fetch_assoc($result)){
			echo "<option value='",$row['cadru_didactic_id'],"'data='",$row['nume']," ",$row['prenume'],"'>",$row['nume']," ",$row['prenume'],"</option>";
		}

		if ($i < 9){
			echo '</select></td><td onclick="document.getElementById(\'id', $i,'\').style.display=',"'none'",';update_autori();" align="left" style="cursor:default;">-</td>
				  <td onclick="document.getElementById(\'id', $i + 1,'\').style.display=',"''",';update_autori();" align="left" style="cursor:default;">+</td></tr> </table></td></tr>';
		}
		else{
			echo '</select></td><td onclick="document.getElementById(\'id', $i,'\').style.display=',"'none'",';update_autori();" align="left" style="cursor:default;">-</td><td></td></tr> </table></td></tr>';

			}
	}
	mysql_close($connect);


			//selectarea autorilor EXTERNI ULBS

	echo "<tr name='ide0' id='ide0'>
			<td>ID / Nume autor extern:</td><td>
			<table>
				<tr><td><select onchange=","update_autori()"," name='index_autor_extern0' id='index_autor_extern0'>
				<option value='-1'> </option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>
			<option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select>";	
	echo "<input onkeyup=","update_autori()"," name='nume_autor_extern0' id='nume_autor_extern0' type='text' size='50'>";
			//</td> <td id= "id0" onclick="document.getElementById(',"'id10'",').style.display=',"'none'",';"align="left" >-</td> 
	echo '<td onclick="document.getElementById(',"'ide1'",').style.display=',"''",';update_autori();" align="left" style="cursor:default;">+</td></tr> </table></td></tr>';

	for ($i=1; $i<=9; $i++){
		echo "<tr name='ide",$i,"' id='ide",$i,"' style='display:none'>
				<td >ID / Nume autor extern:</td><td>
				<table><tr><td><select onchange=","update_autori()"," name='index_autor_extern",$i,"' id='index_autor_extern",$i,"'>
				<option value='-1'> </option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>
				<option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select>";	
		echo "<input  onkeyup=","update_autori()"," name='nume_autor_extern",$i,"' id='nume_autor_extern",$i,"' type='text' size='50'/>";
				
		if ($i < 9){
			echo '</td><td onclick="document.getElementById(\'ide', $i,'\').style.display=',"'none'",';update_autori();" align="left" style="cursor:default;">-</td>
				  <td onclick="document.getElementById(\'ide', $i + 1,'\').style.display=',"''",';update_autori();" align="left" style="cursor:default;">+</td></tr> </table></td></tr>';
		}
		else{
			echo '</td><td onclick="document.getElementById(\'ide', $i,'\').style.display=',"'none'",';update_autori();" align="left" style="cursor:default;">-</td><td></td></tr> </table></td></tr>';
		}
	}

echo "<tr><td>&nbsp;</td>
		<td>&nbsp;<input name='adauga_lucrare' type='submit' align='right' value='Adaugă' /></td></tr>
		<tr>	<tr><td colspan='2'><h4 class='red'> Notă: Numele autorilor se completează automat în momentul selectării din comboboxuri a autorilor din cadrul ULBS şi/sau scrierea numelui autorilor din afara ULBS în textboxurile de mai sus şi după selectarea ordinii în care trebuie să apară autorii!</h4></td></tr>
		</table>		
	</form>";   

}			
//SUBMIT DATE
else{
echo "<tr><td>&nbsp;</td>
		<td>&nbsp;<input name='adauga_lucrare' type='submit' align='right' value='Adaugă' /></td></tr>
		<tr><td>&nbsp;</td></tr>
		</table>		
	</form>";   
}

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>