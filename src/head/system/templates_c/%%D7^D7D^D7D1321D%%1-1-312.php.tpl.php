<?php /* Smarty version 2.6.14, created on 2010-04-05 16:09:12
         compiled from 1-1-312.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border="0">
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['d_memo3']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['d_memo3']['error']; ?>
<br><?php endif; ?>
</span>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
<font size="+0.5"><b>�����˽�������Ϥ��Ƥ�������<br>������TEL��FAX�����Ϥ��Ʋ�����<br>�����˥������Ϥ��Ƥ�������</b></font>
<table class='List_Table' border='1' width='720' height="450">
	<tr>
	<td class='Value' valign='middle'>
    <table align="center" valign="middle" border="0" width="740" height="350" background="../../../image/delivery.png">
	<tr>
	<td valign="bottom" height="110" width="720" align="right" colspan="2"><font color='#ff0000'>
	����<?php echo $this->_tpl_vars['form']['d_memo1']['html']; ?>
<br>
	����<?php echo $this->_tpl_vars['form']['d_memo2']['html']; ?>
<br>
	</font>
	</td>
	</tr>
	<tr><td><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr>
    <td><font color='#ff0000'>����</font></td>
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
����<?php echo $this->_tpl_vars['form']['deli_button']['html']; ?>
</td>
	</tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->

					<br>
					</td>
				</tr>
					</td>
				</tr>
			</table>
		</td>
<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
