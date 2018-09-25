<?php
// Check if user is authorized != Throw out
	$AccessZone = 'eval';
	include $_SERVER['DOCUMENT_ROOT'].'/auth/authorize.php'; 
	include $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/templates/header.php';
	require $_SERVER['DOCUMENT_ROOT'].'/home/cercetare/connection/connection.php';
echo '	    <script src="'.$_SERVER['DOCUMENT_ROOT'].'/src/js/jquery-1.5.1.min.js"></script>';
?>
<script language="JavaScript">
function add_autor(){
document.getElementById();
var cloned = whatToClone.clone(true, true).get(0);
          ++cur_num;
          cloned.id = whatToClone.attr('id') + "_" + cur_num;                  // Change the div itself.

        $(cloned).find("*").each(function(index, element) {   // And all inner elements.
          if(element.id)
          {
              var matches = element.id.match(/(.+)_\d+/);
              if(matches && matches.length >= 2)            // Captures start at [1].
                  element.id = matches[1] + "_" + cur_num;
          }
          if(element.name)
          {
              var matches = element.name.match(/(.+)_\d+/);
              if(matches && matches.length >= 2)            // Captures start at [1].
                  element.name = matches[1] + "_" + cur_num;
          }
}
</script>
<?php
		echo "<table><tr><td><select onchange=","update_autori()","  name='index_autor_ULBS_0' id='index_autor_ULBS0'>
				<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>
				<option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option></select></td><td onClick='add_autor()'>+</td></tr></table>";
?>
 </body>
 </html>