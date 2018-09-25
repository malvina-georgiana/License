<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	
include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
echo "Pagina de administrare.";
?>
<LINK REL=stylesheet HREF="//home/cercetare/obj/src/global.css">

<?php include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/footer.php'; ?>