<?php 
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/platforma/functions/functions.php';
?>


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
    <li><small><strong><a href="./" style="color:#FF0000">Profil Cercetător</a></strong></small></li>
</ul>
</div>

  <div id="topbar"><a href="index.php">Back</a></div>
  <div id="w">
    <div id="content">
      <h1>Cercetători</h1>
      <p>Căutați un cercetător, un domeniu de cercetare ori un centru de cercetare.</a></p>
      
      <div id="searchfield">
        <form>
			<input type="text" name="nume" class="biginput" id="autocomplete-name" placeholder="Nume Cercetător">
			<input type="text" name="expertiza" class="biginput" id="autocomplete-domains" placeholder="Domeniu de cercetare">
			<input type="text" name="centru" class="biginput" id="autocomplete-centers" placeholder="Centru de cercetare ULBS">
		</form>
      </div><!-- @end #searchfield -->
      
      <div id="outputbox">
        <p id="outputcontent">Debug:</p>
      </div>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
 <form id="cercetator" action="" method="POST">
 <input type="hidden" name="cercetator" value="cercetator">
 </form> 
 <form id="domeniu" action="" method="POST">
 <input type="hidden" name="domeniu" value="domeniu">
 </form> 
 <form id="centru" action="" method="POST">
 <input type="hidden" name="centru" value="centru">
 </form> 
  <div id="results">
  <style>
    #result td { color: #344C7C; padding: 5px 10px; border: 1px solid;}
  	#result .title-table { background: #344C7C; font-weight: bold;}
    #result .title-table td {color: white; font-size: 1.3em;}
  </style>
  <table style="width: 100%;" id="result">
  	<tr class="title-table">
  		<td>Nume</td>
  		<td>Domenii de cercetare</td>
  		<td>Centru de cercetare</td>
    </tr>
 <?php 
 /* Cercetator */
if(isset($_POST['cercetator']))
{
	$sql_cercetatori = "SELECT * FROM cercetatori WHERE  LIKE '%".$_POST['cercetator']."%' ORDER BY nume;";
	//echo '<br>Debug: '.$sql_cercetatori.'<br>';
	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

	if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
	
		if ( @mysql_query($sql_cercetatori)) {
			$result_cercetatori = mysql_query ( $sql_cercetatori );
			if(!$result_cercetatori){ echo mysql_error();}
		}
			if (mysql_num_rows($result_cercetatori) >= 1) {
				
				while($row = mysql_fetch_assoc($result_cercetatori)){ 
					  $id_cercetator = $row[''];
					  $prenume = $row['prenume'];
					  $nume = $row['nume'];
					  $centru = $row['centru'];
					  $vizibil = $row['vizibil'];
					  if($centru!='1' && $vizibil=='da'){
					  
					  echo '<tr>
			<td>'.$prenume.' '.$nume.'</td>
			<td>';
			$val=expertize($id_cercetator);
			$nr=count($val);
			for($i=0;$i<$nr;$i++)
			{
			$x = expertiza_domeniu($val[$i]);
			echo '<a href="?domeniu='.$val[$i].'">'.$x[0].'</a>';
			if($i<($nr-1))
			{
				echo ', ';}
			}
			echo '</td>
			<td>';
			$val=cen_nume($id_cercetator);
			
					echo '<a href="?centru='.$centru.'">'.$val[0].'</a></td>
				</tr>';	
					  }
			}
			}
		else {
			echo ( mysql_error () );
		
		}
	}
	else {
		trigger_error ( mysql_error(), E_USER_ERROR );
	}
  	
   }
   
/* Domeniu de cercetare */
if((isset($_POST['domeniu']) || isset($_GET['domeniu'] ))&& !isset($_POST['cercetator'])&& !isset($_POST['centru']) && !isset($_GET['centru']))
{
	if(isset($_POST['domeniu']))
	{
		$domeniu=$_POST['domeniu'];
		}
		else{
		$domeniu=$_GET['domeniu'];
		}
		
	$sql_domeniu = "SELECT *,cercetatori.id AS id_cercetator FROM cercetatori INNER JOIN expertiza ON expertiza.cercetator=cercetatori.id WHERE expertiza.domeniu='".$domeniu."' ORDER BY ;";
	//echo '<br>Debug: '.$sql_domeniu.'<br>';

	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

	if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
	
		if ( @mysql_query($sql_domeniu)) {
			$result_domeniu = mysql_query ( $sql_domeniu );
			if(!$result_domeniu){ echo mysql_error();}
		}
			if (mysql_num_rows($result_domeniu) >= 1) {
				
				while($row = mysql_fetch_assoc($result_domeniu)){ 
					  $id_cercetator = $row[''];
					  $prenume = $row['prenume'];
					  $nume = $row['nume'];
					  $centru = $row['centru'];
					  $vizibil = $row['vizibil'];
					  if($centru!='1' && $vizibil=='da'){
					  
					  echo '<tr>
			<td>'.$prenume.' '.$nume.'</td>
			<td>';
			$val=expertize($id_cercetator);
			$nr=count($val);
			for($i=0;$i<$nr;$i++)
			{
			$x = expertiza_domeniu($val[$i]);
			echo '<a href="?domeniu='.$val[$i].'">'.$x[0].'</a>';
			if($i<($nr-1))
			{echo ', ';}
			}
			echo '</td>
			<td>';
			$val=cen_nume($id_cercetator);
			
					echo '<a href="?centru='.$centru.'">'.$val[0].'</a></td>
				</tr>';
					  
				}
				}
			}
		else {
			echo ( mysql_error () );
		
		}
	}
	else {
		trigger_error ( mysql_error(), E_USER_ERROR );
	}
  	
   }
   
/* Centru de cercetare */
if((isset($_POST['centru']) || isset($_GET['centru'] ))&& !isset($_POST['cercetator'])&& !isset($_POST['domeniu']) && !isset($_GET['domeniu']))
{
	if(isset($_POST['centru']))
	{
		$centru=$_POST['centru'];
		}
		else{
		$centru=$_GET['centru'];
		}
		
	$sql_centru = "SELECT *,cercetatori.id AS id_cercetator FROM cercetatori WHERE cercetatori.centru='".$centru."' ORDER BY ;";
	//echo '<br>Debug: '.$sql_centru.'<br>';

	$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

	if ( $connect ){
		mysql_select_db($database_cercetare);
		@mysql_query("SET NAMES UTF8");
		
	
		if ( @mysql_query($sql_centru)) {
			$result_centru = mysql_query ( $sql_centru );
			if(!$result_centru){ echo mysql_error();}
		}
			if (mysql_num_rows($result_centru) >= 1) {
				
				while($row = mysql_fetch_assoc($result_centru)){ 
					  $id_cercetator = $row[''];
					  $prenume = $row['prenume'];
					  $nume = $row['nume'];
					  $centru = $row['centru'];
					  $vizibil = $row['vizibil'];
					  if($centru!='1' && $vizibil=='da'){
					  
					  echo '<tr>
			<td>'.$prenume.' '.$nume.'</td>
			<td>';
			$val=expertize($id_cercetator);
			$nr=count($val);
			for($i=0;$i<$nr;$i++)
			{
			$x = expertiza_domeniu($val[$i]);
			echo '<a href="?domeniu='.$val[$i].'">'.$x[0].'</a>';
			if($i<($nr-1))
			{echo ', ';}
			}
			echo '</td>
			<td>';
			$val=cen_nume($id_cercetator);
			
					echo '<a href="?centru='.$centru.'">'.$val[0].'</a></td>
				</tr>';	
					  
				}
				}
			}
		else {
			echo ( mysql_error () );
		
		}
	}
	else {
		trigger_error ( mysql_error(), E_USER_ERROR );
	}
  	
   }


 ?>    
  </table>
  </div>
  
</td>
</tr>
</tbody>
</table>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>