<?php
require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
if($_POST['visibility']=='da'){ $vizibil= "nu";}
if($_POST['visibility']=='nu'){ $vizibil= "da";}
$= $_POST['id'];

$connect = @mysql_connect($host_cercetare.":".$port_cercetare, $user_cercetare, $pass_cercetare);

$sql_type_date = null; //=0;//insert; = 1;//update

if ( $connect ) {
	mysql_select_db($database_cercetare);
	@mysql_query("SET NAMES UTF8");

if( mysql_query('UPDATE cercetatori SET vizibil="'.$vizibil.'", modificare="Modificat: '.date('d-m-Y').'" WHERE ="'.$.'";') ){
	if($vizibil=='da'){
		echo 'Profilul este public!';}
		else
		{ echo '<span id="button-off">Profilul a fost dezactivat!</span>';}
	}
	else
	{
		echo "Eroare! ";
	}
}
?>