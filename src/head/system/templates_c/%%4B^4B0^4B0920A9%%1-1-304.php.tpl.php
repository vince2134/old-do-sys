<?php /* Smarty version 2.6.14, created on 2010-04-05 16:09:10
         compiled from 1-1-304.php.tpl */ ?>

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
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['error_fax_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['error_fax_msg']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['var']['error_tel_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['error_tel_msg']; ?>
<br><?php endif; ?></span><br>
<font size="+0.5"><b>※�，�FAX番号、�△謀渡暖峭罎鯑�力してください</b></font><br>
<font size="+0.5"><b>※��〜�┐縫灰瓮鵐箸鯑�力してください</b></font>
<table class='List_Table' border='0' width='740' height='1085' background="../../../image/order.png">
<tr>
	<td valign="bottom" height='135'>
		<table width='550' align="right">
		<tr><td>
		<font color='#ff0000'>
		�� <?php echo $this->_tpl_vars['form']['o_memo1']['html']; ?>
<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top">
		<table width='680' align="right">
		<tr><td>
		<font color='#ff0000'>
		�� <?php echo $this->_tpl_vars['form']['o_memo2']['html']; ?>
<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top" height='370'>
		<table width='450'>
		<tr><td>
		<font color='#ff0000'>
		�� <?php echo $this->_tpl_vars['form']['o_memo3']['html']; ?>
<br>
		�� <?php echo $this->_tpl_vars['form']['o_memo4']['html']; ?>
<br>
		�� <?php echo $this->_tpl_vars['form']['o_memo5']['html']; ?>
<br>
		�� <?php echo $this->_tpl_vars['form']['o_memo6']['html']; ?>
<br>
		�� <?php echo $this->_tpl_vars['form']['o_memo7']['html']; ?>
<br>
		�� <?php echo $this->_tpl_vars['form']['o_memo8']['html']; ?>
<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
</table>
	</td>
</tr>

<table width='740'>
	<tr>
		<td align="right"><?php echo $this->_tpl_vars['form']['new_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['order_button']['html']; ?>
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

	


	