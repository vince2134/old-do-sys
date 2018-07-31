<?php /* Smarty version 2.6.9, created on 2006-03-07 13:39:54
         compiled from menu_sample6.php.tpl */ ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=HTML_CHAR">
	<META HTTP-EQUIV="Imagetoolbar" CONTENT="no">
	<title>$html_title</title>
	<link rel="shortcut icon" href="../../image/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="../../css/global_ver6.css">
	<base target="_self">
</head>
<script language="javascript" src="../../js/amenity.js">
</script>

<body background="../../image/back_pink.png">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" align="center">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
		
	</tr>

	<tr align="center">
		<td valign="top"><div><a href='menu_sample1.php'><b>menu_sample1</a></div><br><div><a href='menu_sample6.php'><b>menu_sample2</a></div><br><div><a href='menu_sample7.php'>menu_sample3</a></div></b></td>
		<td width="100%" valign="top" lowspan="2">
			<!-- メニュー開始 --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- メニュー終了 -->
		</td>
	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
