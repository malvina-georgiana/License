<?php /*?>
TODO:verifica documentele pentru eventualele adaugiri necesare
posibil domenii/ departamente / profiluri neutilizate check it oout
de asemenea de urmarit imposibilitatea folosirii de diacritice!!!!!!!
over & out

<?php */?>
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
//
//actulizare date in cazul ca nu se gaseste id-ul cadrului didactic in baza de date a evaluarii
//
//DEBUG
//echo "entity:".$_SESSION['Entity']."<br/>";
//echo "dep:".$_SESSION['Department']."<br/>";


//echo ' Debug > '.$_SESSION['Username'].' : '.$_SESSION['UserID'];

$sql = "SELECT * FROM cercetatori WHERE  = '".$_SESSION['Username']."'";

//echo ' Debug> '.$sql;


$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

//echo ' Debug> '.$connect;	

if ( $connect ) {
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	// echo 'Debug> '.@mysql_query($sql);
 	if ( @mysql_query($sql)) {
		$result = mysql_query ( $sql );
		if (!$result) {
		  echo($message);
		}
		// echo 'Debug num row '.mysql_num_rows($result);
		if (mysql_num_rows($result) == 0) {
			$sql = "INSERT INTO cercetatori (, nume, prenume, mail, link_personal, vizibil, modificare)
					VALUES('".$_SESSION['Username']."' , '". $_SESSION['LastName']."', '".$_SESSION['FirstName']."','".$_SESSION['Username']."@ulbsibiu.ro','http://web.ulbsibiu.ro/".$_SESSION['Username']."/','nu','Creat: ".date('d-m-Y')." | ')";
			if ( !mysql_query($sql)) {
					echo mysql_error();
			}
			else
			{
				header("Location: ./index.php");	
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

//formular actualizare date personale
echo '<p>Aceast subsite permite completarea <b><a  style="color: #036;" href="view.php" title="Previzualizare">profilului de cercetător</a></b>.<br/><br/></p>'; 

$sql = "SELECT *, departament.id AS id_departament,cercetatori.id AS id_cercetator FROM cercetatori INNER JOIN departament ON departament.id=cercetatori.departament WHERE  = '".$_SESSION['Username']."'";
//echo 'Debug 1# '.$sql.'<br>';
$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

$sql_type_date = null; //=0;//insert; = 1;//update

if ( $connect ) {
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	if ( @mysql_query($sql_domenii)) {
		$result_domenii = mysql_query ( $sql_domenii );
	}
	//echo 'Debug 1# '.@mysql_query($sql).'<br>';
	if ( @mysql_query($sql)) {
		$result = mysql_query ( $sql );
		if (!$result) {
			echo mysql_error();
		}
		//echo 'Debug 2# '.mysql_num_rows($result).'<br>';
		if (mysql_num_rows($result) == 1) {
			$sql_type_date = 1;
			while($row = mysql_fetch_assoc($result)){ 
				  $id_cercetator = $row['id_cercetator'];
				  $modificare = $row['modificare']; 
				  $vizibil = $row['vizibil'];
            	  $titlu = $row['titlu'];
            	  $prenume = $row['prenume'];
             	  $nume = $row['nume'];
             	  $descriere = $row['descriere'];
				  $descriere64 = base64_decode($row['descriere']);
             	  $ = $row[''];
            	  $email = $row['mail'];
            	  $link_personal = $row['link_personal'];
				  
				  $id_departament = $row['id_departament'];
				  $departament = $row['denumire'];
            	  $centru = $row['centru'];				  
            	  $link_cercetare = $row['link_cercetare'];			  
            	  $expertiza = $row['expertiza'];
				  
            	  $centru_extern = $row['centru_extern'];	
				  
				//echo 'Debug inreg: '.$id_cercetator.' | '.$modificare.' | '.$vizibil.' | '.$titlu.' | '.$prenume.' | '.$nume.' | '.$.' | '.$email.' | '.$link_personal.' | '.$id_departament.' | '.$departament.' | '.$centru.' | '.$link_cercetare.' | '.$expertiza.' | '.$centru_extern;  
            } 	
		}
	}
	else {
		echo ( mysql_error () );
	}


echo '<form name="vizibil" id="button_visibility" action="vizibil.php" method="post"><div class="onoffswitch">
	<input type="hidden" name="id" value="'.$_SESSION['Username'].'">
	<input type="hidden" name="visibility" id="visibility" value="'.$vizibil.'">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ';
if($vizibil =='da'){
	echo ' checked';
}
    echo '><label class="onoffswitch-label" for="myonoffswitch">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div></form><span id="result">';
if($vizibil =='nu'){ echo '<span id="button-off">Profilul dumneavoastră nu este vizibil. Completați datele și făceți-l public!</span>';}
echo '</span>';

echo "<script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 1024) {
          val.value = val.value.substring(0, 1024);
		   $('#charNum').text(1024 - len);
		   $('#charNum').css( 'color','red' );
        } else {
          $('#charNum').text(1024 - len);
		   $('#charNum').css( 'color','grey' );
        }
      };
    </script>".'<form name="date_personale" action="update_date_personale.php" method="post"<h4>Date personale</h4>
			<input type="hidden" name="sql_type_date" value="1" />
			<input type="hidden" name="" value="'.$_SESSION['Username'].'" />
			<input type="hidden" name="modificare" value="'.date('d-m-Y').'" />
			<table><tr><td>Titlu:</td><td><input name="titlu" placeholder="Prof. univ. dr. / Conf. univ. dr. / Lect. univ. dr. / Șef lucr. dr. / Asist. univ. dr. / Asist. univ. drd." value="'.$titlu.'" /><br/> </td></tr>
			<tr><td>Prenume:</td><td><input name="prenume" value="'.$prenume.'" /><br/> </td></tr>
				<tr><td>Nume:</td><td><input name="nume" value="'.$nume.'" /><br/></td></tr>
				<tr><td>Email:</td><td><input name="email" value="'.$email.'" /><br/></td></tr>
				<tr><td>Descriere (max. 1024):<br><div style="font-size: 0.7em;" id="charNum"></div></td><td><textarea maxlength="1024" rows="15" cols="93" name="descriere" placeholder="Scrieți o scurtă descriere despre dumneavoastră ca cercetător ori descrieți activitatea dumneavoastră de cercetare." onkeyup="countChar(this)">'.$descriere64.'</textarea></td></tr>
				<tr><td>Departament:</td>
					<td><select name="departament"><option value="">- Selectați departamentul -</option>\n';
					$sql_departament = "SELECT * from departament ORDER BY id";
					if ( @mysql_query($sql_departament)) {
							$result_departament = mysql_query ( $sql_departament );
						}
					while($row_departament = mysql_fetch_assoc($result_departament)){ 
						if($row_departament['denumire'] == $departament){
							echo "<option value='".$row_departament['id']."' selected='yes'>".$row_departament['denumire']."</option>\n";
						}
						else{
							echo "<option value='".$row_departament['id']."'>".$row_departament['denumire']."</option>\n";
						}
					}
					echo"</select>
					</td>
				</tr>
				<tr><td>Centrul de cercetare al ULBS:</td>
					<td><select name='centru'>
					<option value=''>- Selectați centrul de cercetare -</option>\n";
					$sql_centru = "SELECT * from centru ORDER BY denumire";
					if ( @mysql_query($sql_centru)) {
							$result_centru = mysql_query ( $sql_centru );
						}
					while($row_centru = mysql_fetch_assoc($result_centru)){ 
						if($row_centru['id'] == $centru){
							echo "<option value='".$row_centru['id']."' selected='yes'>".$row_centru['denumire']."</option>\n";
						}
						else{
							echo "<option value='".$row_centru['id']."'>".$row_centru['denumire']."</option>\n";
						}
					}
					echo'</select></td>
				</tr>
				<tr><td>Link pagină personală:</td>
					<td><input name="link_personal" placeholder="http://www.pagina-mea.eu" value="'.$link_personal.'"></td>
				</tr>
				<tr><td colspan="2" style="text-align: right;"><input type="submit" value="Actualizare date" /></td></tr>
			</table>
			</form>
			
			<form class="well" action="avatar/index.php" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="file">Select a file to upload</label>
				    <input type="file" name="file">
				    <p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 1 MB is allowed.</p>
				  </div>
				  <input type="submit" class="btn btn-lg btn-primary" value="Upload">
				</form>';

}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}

//formular actualizare domenii expertiza

echo '<h4>Domenii de cercetare și interes</h4><div class="expertize">';

$sql_expertize = "SELECT expertiza.id AS id_expertiza, domeniu_expertiza.id AS id_domeniu,expertiza.cercetator AS cercetator, domeniu_expertiza.denumire AS domeniu FROM domeniu_expertiza INNER JOIN expertiza ON expertiza.domeniu=domeniu_expertiza.id WHERE expertiza.cercetator = '".$id_cercetator."' ORDER BY domeniu;";
//Debug echo $sql_expertize ;
$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

$sql_type_phd = null; //=0;//insert; = 1;//update


if ( $connect ) {
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	if ( @mysql_query($sql_expertize)) {
		$result_domenii = mysql_query ( $sql_expertize );
		if(!$result_domenii){ echo mysql_error();}
	}
	
		if (mysql_num_rows($result_domenii) >= 1) {
			$sql_type_phd = 1;
			while($row = mysql_fetch_assoc($result_domenii)){ 
            	  $id_expertiza = $row['id_expertiza'];
				  $id_cercetator = $row['cercetator'];
            	  $domeniu = $row['domeniu'];
            	  $id_domeniu = $row['id_domeniu'];
				  echo '<form class="row" name="delete-expertiza-'.$id_domeniu.'" action="expertize.php" method="POST" title="Șterge domeniul">
				  <input type="hidden" name="cercetator" value="'.$id_cercetator.'" />'.$domeniu.' 
				  <input type="hidden" name="id" value="'.$id_expertiza.'" /><input class="delete-expertiza inline submit25" type="submit" name="del_expertiza" value="X" /></form>';
            } 	
		}
	else {
		echo ( mysql_error () );
	
	}
}
else {
	trigger_error ( mysql_error(), E_USER_ERROR );
}



echo '<form name="expertiza" action="expertize.php" method="POST">
		<input type="hidden" name="cercetator" value="'.$id_cercetator.'" />
		<input class="submit200" type="submit" name="add_expertize" value="Adăugare domenii" />
	</form>';


//formular actualizare centre expertiza externe


echo '<h4>Centre de cercetare externe</h4><div class="centre">';

$sql_centre_ext = "SELECT centru_extern.*,cercetatori_centru.id AS id_inreg  FROM cercetatori_centru INNER JOIN centru_extern WHERE cercetatori_centru.centru=centru_extern.id AND cercetatori_centru.cercetator='".$id_cercetator."';";
/* Debug */ //echo $sql_centre_ext ;

$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

$sql_type_phd = null; //=0;//insert; = 1;//update

if ( $connect )
{
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");
	if ( @mysql_query($sql_centre_ext))
		{
			$result_centre_ext = mysql_query ( $sql_centre_ext );
			if(!$result_centre_ext)
			{
				 echo mysql_error();
			}
			else
			{
				/* Debug */ //echo 'if(!$result_centre_ext)- else' ;

				if (mysql_num_rows($result_centre_ext) >= 1)
					{
						/* Debug */ //echo 'if (mysql_num_rows($result_centre_ext) >= 1)' ;

						$sql_type_phd = 1;
						while($row = mysql_fetch_assoc($result_centre_ext))
							{ 
							  $id_centru_ext = $row['id'];
							  $denumire_centru_ext = $row['denumire'];
							  $link_centru_ext = $row['link'];
							  $universitate_centru_ext = $row['universitate'];
							  $short_centru_ext = $row['short'];
							  $id_inreg_centru_ext = $row['id_inreg'];
							  
							  echo $denumire_centru_ext.' <form class="row" name="edit-centru-'.$id_centru_ext.'" action="expertize.php" title="Editare informații centru" method="POST">
							  <input type="hidden" name="cercetator" value="'.$id_cercetator.'" />
							  <input type="hidden" name="id_inreg" value="'.$id_centru_ext.'" /> 
							  <input class="button-inline delete-expertiza" type="submit" name="edit_centru" value="!" /></form>';
							  
							  echo '<form class="row" name="delete-centru-'.$id_inreg_centru_ext.'" action="expertize.php" title="Eliminare afiliere centru" method="POST">
							  <input type="hidden" name="cercetator" value="'.$id_cercetator.'" />
							  <input type="hidden" name="id_inreg" value="'.$id_inreg_centru_ext.'" /> 
							  <input class="button-inline delete-expertiza submit200" type="submit" name="del_centru_ext" value="X" /></form><br>';
							} 	
					}
				else 
					{
						/* Debug */ //echo 'if (mysql_num_rows($result_centre_ext) >= 1) - false' ;
						 echo mysql_error();
					}
			}
		}
}
else 
	{
	trigger_error ( mysql_error(), E_USER_ERROR );
	}


echo '<form name="expertiza" action="expertize.php" method="POST">
		<input type="hidden" name="cercetator" value="'.$id_cercetator.'" />
		<input class="submit200" type="submit" name="add_centre" value="Adăugare centru" />
	</form>';

mysql_close($connect);

?>
</td>
</tr>
</tbody>
</table>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>