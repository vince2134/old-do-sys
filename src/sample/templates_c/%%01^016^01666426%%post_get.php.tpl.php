<?php /* Smarty version 2.6.9, created on 2006-03-13 16:44:47
         compiled from post_get.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- メニュー開始 --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- メニュー終了 -->
		</td>
		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->

<table  class="Data_Table" border="1" width="450">
<col width="130">
<col width="235">
<col width="130">

	<tr>
		<td class="Title_Purple"><b>郵便番号<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['auto_input']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>住所1<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>住所2</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>住所(フリガナ)</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
	</tr>
	
</table>
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>

			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
