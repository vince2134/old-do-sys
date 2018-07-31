<?php /* Smarty version 2.6.14, created on 2010-05-17 15:39:04
         compiled from 2-6-203.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

			<table border="0">
				<tr>
					<td>


<!---------------------- 画面表示1開始 --------------------->
<table  class="Data_Table" border="1" width="450" >

	<tr>
		<td class="Title_Gray" width="100"><b>対象月</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_donw_month']['html']; ?>
</td>
	</tr>

</table>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table width="450">
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['form_btn_down']['html']; ?>

		</td>
	</tr>
</table>
<!--******************** 画面表示2終了 *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
