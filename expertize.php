<?php 
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
?>

<LINK REL=stylesheet HREF="//home/cercetare/obj/src/global.css">


<table width="100%" border="0" align="left" cellpadding="20" cellspacing="0">
<tbody>
<tr valign="top">
<td width="100%" bgcolor="#FFFFFF">

<h1 align="left" class="red" style="font-size:22px class=" red"=""><span class="red" style="font-size:22px;">Profil Cercetător</span></h1>
<!--"breadcrumbs"-->
<link rel=stylesheet href="/obj/src/menu.css">
<div id="navcontainer" align="center">
  <ul>
    <li><small><strong><a href="../">Profil </a></strong></small></li>
    <li><small><strong><a href="./"  style="color:#FF0000">Profil Cercetător</a></strong></small></li>
</ul>
</div>
<?php
	if(isset($_POST[add_expertize]) && $_POST[add_expertize]=='Adăugare domenii')
{
		
		$cercetator = $_POST['cercetator'];
		
		echo '<h4>Domenii de cercetare și interes</h4><div class="expertize">';

$sql_expertize = "SELECT * FROM domeniu_expertiza ORDER BY denumire;";

$sql_expertiza = "SELECT domeniu FROM expertiza WHERE cercetator='".$cercetator."';";

$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

if ( $connect ){
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	
	if ( @mysql_query($sql_expertiza)) {
		$result_domeniu = mysql_query($sql_expertiza);
		if(!$result_domeniu){ echo mysql_error();}
	}
	//DEBUG echo 'Expertize: ';
	$i=1;
	while($row = mysql_fetch_assoc($result_domeniu)){ 
            	//Debug echo $row['domeniu'].', ';
				 $expert[$i]=$row['domeniu'];
				 $i++;
	}
    //DEBUG echo "<br>";

	if ( @mysql_query($sql_expertize)) {
		$result_domenii = mysql_query ( $sql_expertize );
		if(!$result_domenii){ echo mysql_error();}
	}
		if (mysql_num_rows($result_domenii) >= 1) {
			$sql_rows = 0;
			while($row = mysql_fetch_assoc($result_domenii)){ 
            	  $id_expertiza = $row['id'];
            	  $domeniu = $row['denumire'];
				  
				  echo '<form class="row';
				  if(in_array($id_expertiza,$expert)){ echo ' check'; }
				  echo '" name="add-expertiza-'.$id_expertiza.'" action="expertize.php" title="Adaugă domeniul" method="POST">
				  <input type="hidden" name="cercetator" value="'.$cercetator.'" />
				  <input type="hidden" name="domeniu" value="'.$id_expertiza.'" />
				  <input class="expertiza" type="submit" name="add_expertiza" value="'.$domeniu.'" /></form>'; 
				  $sql_rows++;
            }
			echo '<form class="row add-button" name="add-expertiza" action="expertize.php" method="POST">
				  <input type="hidden" name="cercetator" value="'.$cercetator.'" />
				  <input type="hidden" name="id" value="'.($sql_rows+1).'" />
				  <input style="width: 78%;" class="inline"  name="domeniu" type="text" placeholder="Domeniu nou" />
				  <input style="width: 20%;" class="expertiza inline" type="submit" name="add_expertiza_nou" value="Add" />
				  </form>';
		}
	else {
		echo ( mysql_error () );
	
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}

}
/* Adaugare domeniu in lista personala de domenii de cercetare*/
	if(isset($_POST['add_expertiza']))
{
		$cercetator = $_POST['cercetator'];
		$domeniu = $_POST['domeniu'];
		$sql_add_expertiza = "INSERT INTO expertiza (cercetator,domeniu) VALUES ('".$cercetator."','".$domeniu."');";
		
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		if ( @mysql_query($sql_add_expertiza) ){
			header("Location: ./index.php");
		}
	}
}
/* Adaugare domenii in lista globala de domenii de cercetare.
	Autorul este memorat si ii este atribuit domeniul de cercetare in mod automat.
*/	
	if(isset($_POST['add_expertiza_nou']) &&$_POST['add_expertiza_nou']=='Add')
{
		$cercetator = $_POST['cercetator'];
		$domeniu = $_POST['domeniu'];
		$id_domeniu = $_POST['id'];
		
		$sql_add_expertiza_nou= "INSERT INTO domeniu_expertiza (denumire,autor) VALUES ('".$domeniu."','".$cercetator."');";
		
		$sql_add_expertiza = "INSERT INTO expertiza (cercetator,domeniu) VALUES ('".$cercetator."','".$id_domeniu."');";
		
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
		if ( @mysql_query($sql_add_expertiza_nou) ){
		
		if ( @mysql_query($sql_add_expertiza) ){
			header("Location: ./index.php");
		}
		}
	}
}

/* Eliminare domeniu de cercetare din lista personala */
if(isset($_POST['del_expertiza']) && $_POST['del_expertiza']=='X')
{
		$cercetator = $_POST['cercetator'];
		$id_domeniu = $_POST['id'];
		
		$sql_elim_domeniu = "DELETE FROM expertiza WHERE cercetator = '".$cercetator."' AND id='".$id_domeniu."';";
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect )
	{
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
		if ( @mysql_query($sql_elim_domeniu) ){
			header("Location: ./index.php");
			}
	}
}

/* Adaugare centre de cercetare externe */
if(isset($_POST['add_centre']) && $_POST['add_centre']=='Adăugare centru')
{
	echo '<h4>Centre externe de cercetare</h4>';
	
	$cercetator = $_POST['cercetator'];
	
	$sql_centre = "SELECT * FROM centru_extern ORDER BY short;";

	$sql_centru = "SELECT centru FROM cercetatori_centru WHERE cercetator='".$cercetator."';";

	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

if ( $connect )
{
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	
	if ( @mysql_query($sql_centru))
	{
		$result_centru = mysql_query($sql_centru);
		if(!$result_centru){ echo mysql_error();}
	}
	/* DEBUG   echo 'Centre: ';*/
	$i=1;
	while($row = mysql_fetch_assoc($result_centru))
	{ 
        /* DEBUG  echo $row['centru'].', ';*/ 
		$expert[$i]=$row['centru'];
		$i++;
	}
    /* DEBUG  echo "<br>";*/ 



	if ( @mysql_query($sql_centre)) {
		$result_centre = mysql_query ( $sql_centre );
		if(!$result_centre){ echo mysql_error();}
	}
		if (mysql_num_rows($result_centre) >= 1)
		{
			$sql_rows = 0;
			while($row = mysql_fetch_assoc($result_centre))
			{ 
            	  $id_centru = $row['id'];
            	  $denumire = $row['denumire'];
            	  $link = $row['link'];
            	  $universitate = $row['universitate'];
            	  $short = $row['short'];
				  
				  echo '<form class="row';
				  if(in_array($id_centru,$expert)){ echo ' check'; }
				  echo '" name="add-centru-'.$id_expertiza.'" action="expertize.php" method="POST">
				  <input type="hidden" name="cercetator" value="'.$cercetator.'" />
				  <input type="hidden" name="centru" value="'.$id_centru.'" />
				  <input class="expertiza" type="submit" name="add_centru" value="'.strtoupper($short).'" />'.$denumire.'</form>'; 
				  $sql_rows++;
            }
			echo '<hr><br><form class="row add-button" name="add-centru" action="expertize.php" method="POST">
			<input type="hidden" name="cercetator" value="'.$cercetator.'" />
			<input type="hidden" name="id" value="'.($sql_rows+1).'" />
			<table style="width: 100%;"><tr>
			<td class="input400"><input class="inline"  name="short" type="text" placeholder="Acronimul centrului de cercetare" /></td>
			<td class="input400"><input class="inline"  name="universitate" type="text" placeholder="Universitatea de care apartine" /></td></tr>
			<tr><td class="input400"><input class="inline"  name="denumire" type="text" placeholder="Centru extern nou" /></td>
			 <td class="input400"><input class="inline"  name="link" type="text" placeholder="http://www.adresa-centrului.cc" /></td>
			<tr><td class="input400" colspan="2"><input class="expertiza inline" type="submit" name="add_centru_nou" value="Add" /></td></tr>
			</table>
				  </form>';
		}
		else 
		{
			echo ( mysql_error () );
		}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}
}
/* Add centru nou global */
if(isset($_POST['add_centru_nou']) && $_POST['add_centru_nou']=='Add')
	{
		$short = $_POST['short'];
		$universitate = $_POST['universitate'];
		$denumire = $_POST['denumire'];
		$link = $_POST['link'];
		$autor = $_POST['cercetator'];
		$id_centru = $_POST['id'];
		
		/* DEBUG */ echo $short.' '.$universitate.' '.$denumire.' '.$link.' '.$autor.' '.$id_centru.'<br>';
		
		$sql_add_centru_nou= "INSERT INTO centru_extern (denumire,link,universitate,short,autor) VALUES ('".$denumire."','".$link."','".$universitate."','".strtoupper($short)."','".$autor."');";
		/* DEBUG */ echo $sql_add_centru_nou.'<br>';
		
		$sql_add_centru = "INSERT INTO cercetatori_centru (cercetator,centru) VALUES ('".$cercetator."','".$id_centru."');";
		/* DEBUG */ echo $sql_add_centru.'<br>';
		
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect )
	{
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
		if ( @mysql_query($sql_add_centru_nou) )
		{
			if ( @mysql_query($sql_add_centru) )
				{
					header("Location: ./index.php");
				}
		}
	}
	
}
/* Add centru */
if(isset($_POST['add_centru']) && $_POST['add_centru']!='')
	{
		$cercetator = $_POST['cercetator'];
		$id_centru = $_POST['centru'];
		
		/* DEBUG  echo $cercetator.' '.$id_centru.'<br>';*/
				
		$sql_add_centru = "INSERT INTO cercetatori_centru (cercetator,centru) VALUES ('".$cercetator."','".$id_centru."');";
		/* DEBUG */ echo $sql_add_centru.'<br>';
		
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect )
	{
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
			if ( @mysql_query($sql_add_centru) )
				{
					header("Location: ./index.php");
				}
	}
	
}
/* Del centru */
if(isset($_POST['del_centru_ext']) && $_POST['del_centru_ext']=='X')
	{
		$cercetator = $_POST['cercetator'];
		$id_centru = $_POST['id_inreg'];
		
		/* DEBUG*/  echo $cercetator.' '.$id_centru.'<br>';
				
		$sql_elim_centru = "DELETE FROM cercetatori_centru WHERE cercetator = '".$cercetator."' AND id='".$id_centru."';";
		/* DEBUG*/  echo $sql_elim_centru;
		$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect )
	{
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
		if ( @mysql_query($sql_elim_centru) ){
			header("Location: ./index.php");
			}
	}
	
}
/* Edit centru extern */
if(isset($_POST['edit_centru']) and $_POST['edit_centru']=="!")
{	
	$id = $_POST["id_inreg"];
	$autor = $_POST["cercetator"];
	$sql_select_centru = "SELECT * FROM centru_extern where id='".$id."'";
	/* DEBUG  echo $sql_select_centru; */
	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

if ( $connect )
{
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	
	if ( @mysql_query($sql_select_centru)) {
		$result_centru = mysql_query ( $sql_select_centru );
		if(!$result_centru){ echo mysql_error();}
	}
		if (mysql_num_rows($result_centru) == 1)
		{
			while($row = mysql_fetch_assoc($result_centru))
			{ 
            	  $denumire = $row['denumire'];
            	  $link = $row['link'];
            	  $universitate = $row['universitate'];
            	  $short = $row['short'];
				  
			
	echo '<h4>Centru extern de cercetare: '.$short.'</h4>';
	echo '<form class="row add-button" name="add-centru" action="expertize.php" method="POST">
			<input type="hidden" name="autor" value="'.$autor.'" />
			<input type="hidden" name="id" value="'.$id.'" />
			<table style="width: 100%;"><tr>
			<td class="input400"><input class="inline"  name="short" type="text" placeholder="Acronimul centrului cu majuscule" value="'.$short.'" /></td>
			<td class="input400"><input class="inline"  name="universitate" type="text" placeholder="Universitatea de care apartine"  value="'.$universitate.'"/></td></tr>
			<tr><td class="input400"><input class="inline"  name="denumire" type="text" placeholder="Centru extern nou"  value="'.$denumire.'"/></td>
			 <td class="input400"><input class="inline"  name="link" type="text" placeholder="http://www.adresa-centrului.cc"  value="'.$link.'"/></td>
			<tr><td class="input400" colspan="2"><input class="expertiza inline" type="submit" name="modify_centru" value="Salvare" /></td></tr>
			</table>
			</form>';	
			}
		}
	}
}
/* Memorare modificari centru extern */
if(isset($_POST['modify_centru']) && $_POST['modify_centru']=='Salvare')
{
	$id = $_POST['id'];
	$autor = $_POST['autor'];
	$denumire = $_POST['denumire'];
	$link = $_POST['link'];
	$universitate = $_POST['universitate'];
	$short = $_POST['short'];
	
	$sql_save_modi = "UPDATE centru_extern SET denumire='".$denumire."', link='".$link."', universitate='".$universitate."', short='".strtoupper($short)."', autor='".$autor."' WHERE id='".$id."'";
	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);
    if ( $connect )
	{
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
		if ( @mysql_query($sql_save_modi) ){
			header("Location: ./index.php");
			}
	}
	
}

?>
</td>
</tr>
</tbody>
</table>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>