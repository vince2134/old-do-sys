
{$var.html_header}
<script language="javascript">
{$var.html_java}
</script>
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post" enctype="multipart/form-data" action="#">
<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- ��˥塼���� --> {$var.page_menu} <!-- ��˥塼��λ -->
		</td>

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border="0"  width="100%">
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->
<table border="0" width=850>
<col width="650">
<col width="200">
<tr>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>���ʥ�����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_goods.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>����̾<font color="#ff0000">��</font></b></td>
		<td class="Value" width="">{$form.f_text30.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>ά��</b></td>
		<td class="Value">{$form.f_text30.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>°����ʬ<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio31.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b><a href="javascript:Sub_Window_Open('district.php')">�Ͷ�ʬ</a><font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_district.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b><a href="javascript:Sub_Window_Open('product.php')">���ʶ�ʬ</a><font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_product.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple" width="130"><b>ñ��</b></td>
		<td class="Value">{$form.f_text5.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>����</b></td>
		<td class="Value">{$form.f_text4.html}</td>
	</tr>
</table>
</td>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>�������<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio28.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="131"><b>�߸˴���<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio36.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>�߸˸¤���</b></td>
		<td class="Value">{$form.f_check.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="131"><b>ȯ����</b></td>
		<td class="Value">{$form.f_text9.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>ȯ��ñ�̿�</b></td>
		<td class="Value">{$form.f_text4.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>�꡼�ɥ�����</b></td>
		<td class="Value">{$form.f_text2.html}��</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="131"><b>��̾�ѹ�<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio33.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>���Ƕ�ʬ<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio32.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>�����ƥ�<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.f_radio16.html}</td>
	</tr>
</table>
<br>
</td>
</tr>
<tr>
<td>
<table class="Data_Table" border="1" width="450">

	<tr align="center">
		<td class="Title_Purple" width="130"><b>{$form.button.update.html}</b></td>
		<td class="Title_Purple" width="" width="130"><b>ñ��</b></td>
	</tr>


	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>����ñ��</b></td>
		<td align="center">{$form.f_code_c1.html}</td>
	</tr>
	

	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>ɸ��ñ��</b></td>
		<td align="center">{$form.f_code_c2.html}</td>
	</tr>
	

	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>����åײ���</b></td>
		<td align="center">{$form.f_code_c3.html}</td>
	</tr>

	
	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>����Ź����</b></td>
		<td align="center">{$form.f_code_c4.html}</td>
	</tr>


	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>����Ź����</b></td>
		<td align="center">{$form.f_code_c5.html}</td>
	</tr>

	
	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>ľ�Ĳ���</b></td>
		<td align="center">{$form.f_code_c6.html}</td>
	</tr>
</table>
</td>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>�ǿ������</b></td>
		<td class="Value">2005-04-01</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>�ǿ�������</b></td>
		<td class="Value">2005-04-02</td>
	</tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="450" align="left">
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
	</tr>
</table>
</td>
<td>
<table width="450" align="right">
	<tr>
		<td align="right">
			{$form.button.touroku.html}����{$form.button.modoru.html}
		</td>
	</tr>
</table>
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

{$var.html_footer}
	

