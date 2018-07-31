<?php /* Smarty version 2.6.14, created on 2010-04-05 16:07:05
         compiled from 1-1-302.php.tpl */ ?>

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
<?php if ($this->_tpl_vars['form']['password']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['password_conf']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password_conf']['error']; ?>
<br><?php endif; ?>
<!-- 現在のパスワード比較 -->
<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
<?php endif; ?>
</span><br>

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="140"><b>現在のパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_now']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font><br>(確認用)</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_conf']['html']; ?>
</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align="left">
            <font color="#ff0000"><b>※は必須入力です</b></font>
        </td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>

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

	
