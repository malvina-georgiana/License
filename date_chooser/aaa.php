<html>
<head>

<title>aaa</title>
<!-- 

	Copyright 2009 Itamar Arjuan
	jsDatePick is distributed under the terms of the GNU General Public License.
	
	****************************************************************************************

	Copy paste these 2 lines of code to every page you want the calendar to be available at
-->
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<!-- 
	OR if you want to use the calendar in a right-to-left website
	just use the other CSS file instead and don't forget to switch g_jsDatePickDirectionality variable to "rtl"!
	
	<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.css" />
-->
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<!-- 
	After you copied those 2 lines of code , make sure you take also the files into the same folder :-)
    Next step will be to set the appropriate statement to "start-up" the calendar on the needed HTML element.
    
    The first example of Javascript snippet is for the most basic use , as a popup calendar
    for a text field input.
-->
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%m-%Y"

		});

//		g_globalObject.setOnSelectedDelegate(function(){
//			var obj = g_globalObject.getSelectedDay();
//			alert("a date was just selected and the date is : " + obj.day + "/" + obj.month + "/" + obj.year);
//			document.getElementById("inputField").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
//		});

		new JsDatePick({
			useMode:2,
			target:"inputField1",
			dateFormat:"%d-%m-%Y"

		});

//		g_globalObject1.setOnSelectedDelegate(function(){
//			var obj1 = g_globalObject1.getSelectedDay();
//			alert("a date was just selected and the date is : " + obj1.day + "/" + obj1.month + "/" + obj1.year);
//			document.getElementById("inputField1").innerHTML = obj1.day + "/" + obj1.month + "/" + obj1.year;
//		});
	};


</script>

</head>
<body>
	<h2>JsDatePick's Javascript Calendar usage example</h2>
    
    Look at the comments on the HTML source to fully understand how this very simple example works.
<?php
echo "<form enctype='multipart/form-data' action='insert_contract.php' method='POST'>

	<input type='text' size='12' id='inputField' />
	<input type='text' size='12' id='inputField1' />";



//include "params.php";
//   $param_id_produs = $_GET['id'];
//   echo "<br/>";
//    echo "<form enctype='multipart/form-data' action='insert_contract.php' method='POST'>\n
//    	Nr contract:<br/>
//		<input type='text' name='nr_contract' size='50'><br/>
//		Beneficiar:<br/>
//		<input type='text' name='beneficiar' size='50'><br/>
//		Data inceput:<br/>
//		<input type='text' size='12 id='data_inceput' /><br/>
//		Data sfarsit:<br/>
//
//		<input type='text' size='12 id='inputField' /><br/>
//		<input type='submit' value='Adauga' /> </form>"; 

?>
    
    
</body>
</html>
