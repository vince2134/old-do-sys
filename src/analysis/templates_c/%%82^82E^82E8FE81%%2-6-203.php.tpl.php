<?php /* Smarty version 2.6.14, created on 2010-05-17 15:39:04
         compiled from 2-6-203.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
<table  class="Data_Table" border="1" width="450" >

	<tr>
		<td class="Title_Gray" width="100"><b>�оݷ�</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_donw_month']['html']; ?>
</td>
	</tr>

</table>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->

<table width="450">
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['form_btn_down']['html']; ?>

		</td>
	</tr>
</table>
<!--******************** ����ɽ��2��λ *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
