<?php /* Smarty version 2.6.9, created on 2006-01-26 11:04:42
         compiled from day_get.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['f_datetime']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['f_datetime']['error']; ?>
<br><?php endif; ?>
</span><br>
<font size="+1">��������顢��������A��D���Τɤν����׻�����ؿ�</font>
<table  class="Data_Table" border="1" width="450" >
	<tr>
		<td class="Title_Purple" width="110"><b>���������</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_datetime']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����������</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_datetime2']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['t_display']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��������ɽ��</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['next_date']['html']; ?>
</td>
	</tr>

</table>
<table width="450">
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>
����<?php echo $this->_tpl_vars['form']['reset']['html']; ?>

		</td>
	</tr>
</table>


<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
