<?php /* Smarty version 2.6.14, created on 2010-04-05 16:07:05
         compiled from 1-1-302.php.tpl */ ?>

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
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['password']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['password_conf']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password_conf']['error']; ?>
<br><?php endif; ?>
<!-- ���ߤΥѥ������� -->
<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
<?php endif; ?>
</span><br>

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="140"><b>���ߤΥѥ����<font color="#ff0000">��</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_now']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="140"><b>�������ѥ����<font color="#ff0000">��</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="140"><b>�������ѥ����<font color="#ff0000">��</font><br>(��ǧ��)</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_conf']['html']; ?>
</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align="left">
            <font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>
        </td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>

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

	
