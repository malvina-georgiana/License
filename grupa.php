<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
?>
<LINK REL=stylesheet HREF="//home/cercetare/obj/src/global.css">
<?php
	$grupa_id = $_GET['grupa_id'];
	//print "grupa_id = ".$grupa_id;
	
//	include "connection.php";
	//print "db = ".$database_cercetare;
	$sql = "SELECT * FROM as_grupa WHERE grupa_id = ".$grupa_id;
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
                  //print "<h1>".$row['grupa_descriere']."</h1>";
				  $grupa_descriere = $row['grupa_descriere'];
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
    mysql_close($connect);
	echo "<H2 CLASS='PageSubtitle'>".$grupa_denumire."</H2>";
	//<!--"breadcrumbs"-->
echo"
	<link rel=stylesheet href='/obj/src/menu.css'>
	<div id='navcontainer' align='center'>
	  <ul>
		<li><small><strong><a href='../'>Profil </a></strong></small></li>
		<li><small><strong>.:</strong></small></li>	
		<li><small><strong><a href='./'>cercetare universitară</a></strong></small></li>
		<li><small><strong>.:</strong></small></li>	
		<li><small><strong><a href='./grupa.php?grupa_id=".$grupa_id."' style='color:#FF0000'>".$grupa_denumire."</a></strong></small></li>
	</ul>
	</div>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>

	
	<br><br><br>
	
	<table border='0' cellpadding='0' cellspacing='0' align='center'>
	<tr>
<?php
echo "<th>".$grupa_descriere."</th>";
?>
    </tr>
	<tr></tr>
<?php
	$sql = "SELECT * FROM as_template WHERE grupa_fk = ".$grupa_id." AND activ = 1";
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
            //$i = 1;                                                        
            while($row = mysql_fetch_assoc($result)){ 
            	  echo "<tr> <td width='800'><a href='lucrare.php?template_id=".$row['template_id'] ."'>".$row['template_denumire_completa']."</a><br></td></tr>";
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
    
	echo "</table>";
       
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>