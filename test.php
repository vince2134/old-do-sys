<?php

$dblink = pg_connect("host=127.0.0.1 port=5433 dbname=amenity_demo_new");
print "dblink=$dblink";
exit;
if (!empty($_POST)) {
	print_r($_POST);
	exit;
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <META HTTP-EQUIV="Imagetoolbar" CONTENT="no">
    <title>���������</title>
    <base target="_self">
</head>
<script language="javascript" src="amenity.js">
</script>

<body bgcolor="#D8D0C8">
	<form  action="/test.php" method="post" name="dateForm" id="dateForm">
		<select size="5" style="width: 350;" name="pattern_select">
			<option value="353">��������ѥ���˥ƥ�</option>
			<option value="440">���£�</option>
		</select>		
		<input onclick="javascript:return Dialogue('��Ͽ���ޤ���','#')" name="new_button" value="�С�Ͽ" type="submit" />
	</form>
</body>
</html>