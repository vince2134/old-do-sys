<?php /* Smarty version 2.6.14, created on 2010-04-05 15:46:39
         compiled from 1-2-209.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['d_memo3']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['d_memo3']['error']; ?>
<br><?php endif; ?>
</span>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
<table class='List_Table' border='1' width='720' height="450">
	<tr>
	<td class='Value' valign='middle'>
    <table align="center" valign="middle" border="0" width="740" height="350" background="../../../image/delivery.png">
	<tr>
	<td valign="bottom" height="110" width="720" align="right" colspan="2">
	<?php echo $this->_tpl_vars['form']['d_memo1']['html']; ?>
<br>
	<?php echo $this->_tpl_vars['form']['d_memo2']['html']; ?>
<br>
	</td>
	</tr>
	<tr><td><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr>
    <td><font color='#ff0000'>　</font></td>
	<tr>
		<td width="365" valign="top" align="center">
		<?php echo $this->_tpl_vars['form']['d_memo3']['html']; ?>

		</td>
	</tr>
		</td>
	</tr>
</table>
</table>
<table width='740'>
	<tr>
		<td align="right"><?php echo $this->_tpl_vars['form']['new_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['deli_button']['html']; ?>
</td>
	</tr>
</table>
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>
					</td>
				</tr>
			</table>
		</td>
<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
