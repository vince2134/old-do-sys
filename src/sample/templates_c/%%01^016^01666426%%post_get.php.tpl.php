<?php /* Smarty version 2.6.9, created on 2006-03-13 16:44:47
         compiled from post_get.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- ��˥塼���� --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- ��˥塼��λ -->
		</td>
		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->

<table  class="Data_Table" border="1" width="450">
<col width="130">
<col width="235">
<col width="130">

	<tr>
		<td class="Title_Purple"><b>͹���ֹ�<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['auto_input']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>����1<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����2</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����(�եꥬ��)</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
	</tr>
	
</table>
<!--******************** ����ɽ��1��λ *******************-->

					<br>
					</td>
				</tr>

			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
