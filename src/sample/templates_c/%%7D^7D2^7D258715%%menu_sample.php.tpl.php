<?php /* Smarty version 2.6.9, created on 2006-03-07 09:23:58
         compiled from menu_sample.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_gray.png">
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
		<td valign="top"><div><a href='menu_sample1'><b>menu_sample1</a></div><br><div><a href='menu_sample2'><b>menu_sample2</a></div><br><div><a href='menu_sample3'>menu_sample3</a></div><br><div><a href='menu_sample4'>menu_sample4</a></div><br><div><a href='menu_sample5'>menu_sample5</b></a></div></td>
		<td width="100%" valign="top" lowspan="2">
			<!-- メニュー開始 --> <?php echo $this->_tpl_vars['var']['page_menu1']; ?>
 <!-- メニュー終了 -->
		</td>
	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
