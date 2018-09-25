<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://yui.yahooapis.com/3.7.2/build/yui/yui-min.js"></script>

<script>
  Y.one('#ac-input').plug(Y.Plugin.AutoComplete, {
    resultHighlighter: 'nume',
    source: 'http://www.ulbsibiu.ro//home/cercetare/autori.php?q={query}&callback={callback}'
  });
</script>



</head>

<body>


<div id="demo" class="yui3-skin-sam"> <!-- You need this skin class -->
  <label for="ac-input">Search:</label><br>
  <input id="ac-input" type="text">
</div>

</body>
</html>