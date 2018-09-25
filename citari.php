<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
?>
<LINK REL=stylesheet HREF="//home/cercetare/obj/src/global.css">
<H2 CLASS="PageSubtitle">Citări</H2>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script language="JavaScript">

function deleteCitare(lucrare_id, template_id, citare_id)
{
var r=confirm("Sunteţi sigur că doriţi să ştergeţi citarea?");
if (r==true)
 window.location.assign("citari.php?lucrare_id=" + lucrare_id + "&template_id=" + template_id + "&link_id=" + citare_id);
}

function goBack()
  {
  window.history.back()
  }
  
</script>
</head>
<body>
<?php

$lucrare_id = $_GET['lucrare_id'];
$template_id = $_GET['template_id'];
$link = $_GET['link'];
$link_id = $_GET['link_id'];

// echo $lucrare_id."<br/>";
 //echo $template_id;
$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

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


//adauga link
if (isset($_GET['link'])){
//	echo "linkul: ".$link;
	if ( $connect ){
	    mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");

		$sql_adauga_link = "INSERT INTO citari (lucrare_fk, link) VALUES (".$lucrare_id.", '".$link."')";
		//echo  "query".$sql_adauga_link."<br/>";
		//break;
		if ( @mysql_query($sql_adauga_link)){
			header("Location: ./citari.php?lucrare_id=".$lucrare_id."&template_id=".$template_id);
		}
		else {
			header("Location: ./citari.php?lucrare_id=".$lucrare_id."&template_id=".$template_id);
			die ( "Error1".mysql_error () );
		}
	}
}

//sterge link
if (isset($_GET['link_id'])){
//	echo "linkul: ".$link_id;
	if ( $connect ){
	    mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");

		$sql_sterge_link = "DELETE FROM citari WHERE citare_id = ".$link_id;
		//echo  "query".$sql_adauga_link."<br/>";
		//break;
		if ( @mysql_query($sql_sterge_link)){
			header("Location: ./citari.php?lucrare_id=".$lucrare_id."&template_id=".$template_id);
		}
		else {
			header("Location: ./citari.php?lucrare_id=".$lucrare_id."&template_id=".$template_id);
			die ( "Error1".mysql_error () );
		}
	}
}

if ( $connect ){
//interogari
	$sql_titlu_lucrare = "SELECT titlu FROM as_lucrare WHERE lucrare_id =".$lucrare_id;
	$sql_titulatura ="SELECT denumire_locala FROM as_legatura_template_camp WHERE template_fk = ".$template_id." AND camp_fk = 1";
	$sql_citate = "SELECT citare_id, link FROM citari WHERE lucrare_fk =".$lucrare_id;

	mysql_select_db($database_cercetare);
    @mysql_query("SET NAMES UTF8");
		
	if ( @mysql_query($sql_titlu_lucrare) and @mysql_query($sql_titulatura) and @mysql_query($sql_citate)){
		$result_titlu_lucrare = mysql_query ( $sql_titlu_lucrare );
		$result_titulatura = mysql_query ( $sql_titulatura );
		$result_citate = mysql_query ( $sql_citate );
		$rows = mysql_num_rows($result_citate);

		if (!$result_titlu_lucrare and !$result_titulatura) {
		  die($message);
		}
		while($row = mysql_fetch_assoc($result_titlu_lucrare)){ 
			$titlu_lucrare = $row['titlu'];
		}
		while($row = mysql_fetch_assoc($result_titulatura)){ 
			$titulatura = $row['denumire_locala'];
		}	
		while($row = mysql_fetch_assoc($result_citate)){ 
			$citate[$row['citare_id']] = $row['link'];
			//$citare_id[] = $row['citare_id'];			
		}
		foreach (array_keys($citate) as $key){
		$citate_keys = $key;
		}
	}
	else {
		die ( "Error2".mysql_error () );
	  }
	}
else {
	trigger_error ( "Error3".mysql_error(), E_USER_ERROR );
}
mysql_close($connect);
//echo "titulatura:".$titulatura;
print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
	print "<tr>";
		print "<td>"; 
		print $titulatura.":";
		print "</td>";

		print "<td colspan='2'>";
		print $titlu_lucrare;
		print "</td>";
	print "</tr>";
	print "<tr>";
		print "<td rowspan='".$rows."'>"; 
		print "Citari:";
		print "</td>";

		foreach ($citate as $key=>$value) {
			print "<td>";
			//print $value;
			print "<a href='".$value."'>".$value."</a> ";
			print "</td>";
			//print "<td> &nbsp<a href='citari.php?lucrare_id=".$lucrare_id."&template_id=".$template_id."&link_id=".$key."'>Şterge</a>&nbsp </td>";
			print "<td> &nbsp;<a href='' onclick='deleteCitare($lucrare_id,$template_id,$key)'>Şterge</a>&nbsp; </td>";
			print "</tr>";
		}
print "</table>";

print "<H2 CLASS='PageSubtitle'>Adaugă citare:</H2>";
print "<br/>";

echo "<form name='input' action='citari.php' method='get'>
		<input type='hidden' name='lucrare_id' value='".$lucrare_id."' />
		<input type='hidden' name='template_id' value='".$template_id."' />
		Adresa web la care se găseşte citarea: <input type='text' name='link' size=100 /><br />
		<input type='submit' value='Adaugă' />
		<input type='button' value='Terminat' onclick='goBack()' />
	</form> ";

?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>
