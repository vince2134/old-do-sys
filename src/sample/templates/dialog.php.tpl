
{$var.html_header}

<body background="../../image/back_pink.png" onLoad="return Link_Switch('test_dialog.php',450,200)">
<form name="dateForm" method="post">

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

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

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- ����ɽ��1���� --------------------->

<table  class="Data_Table" border="1" width="650" >
<col width="100">
<col width="225">
<col width="100">
<col width="225">
	<tr>
		<td class="Title_Pink" width="100"><b>�����ֹ�</b></td>
		<td class="Value" colspan="3">
			{$form.f_text_auto.html}
		</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="100"><b>������<font color="red">��</font></b></td>
		<td class="Value">{$form.f_date_a1.html}</td>
		<td class="Title_Pink" width="100"><b>��˾Ǽ��</b></td>
		<td class="Value">{$form.f_date_a2.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink"><b><a href="javascript:Sub_Window_Open('customer.php')">������</a><font color="red">��</font></b></td>
		<td class="Value" colspan="3">{$form.f_customer.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('direct.php')">ľ����</a></b></td>
		<td class="Value" colspan="3">{$form.f_direct.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('warehouse.php')">�в��Ҹ�</a><font color="red">��</font></b></td>
		<td class="Value" colspan="3">{$form.f_warehouse.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('forwarding.php')">�����ȼ�<br>(���꡼�����)</a></b></td>
		<td class="Value" colspan="3">{$form.f_forwarding.html}��</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('dealing.php')">�����ʬ</a><font color="red">��</font></b></td>
		<td class="Value" colspan="3">{$form.f_dealing.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('charge.php')">ô����</a><font color="red">��</font></b></td>
		<td class="Value" colspan="3">{$form.f_charge.html}��</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b>�̿���<br>�������谸��</b></td>
		<td class="Value" colspan="3">{$form.f_textarea.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b>�̿���<br>����������</b></td>
		<td class="Value" colspan="3">{$form.f_textarea.html}</td>
	</tr>
</table>
<br>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->

<table class="List_Table" border="1" width="100%">
	<tr class="Result1" align="center">
		<td class="Title_Pink" width=""><b>NO</b></td>
		<td class="Title_Pink" width=""><b>���ʥ�����<font color="red">��</font><br>����̾<font color="red">��</font></b></td>
		<td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
		<td class="Title_Pink" width="90"><b>ñ��</b></td>
		<td class="Title_Pink" width=""><b>����ñ��<font color="red">��</font><br>���ñ��<font color="red">��</font></b></td>
		<td class="Title_Pink" width=""><b>�������<font color="red">��</font><br>�����<font color="red">��</font></b></td>
		<td class="Title_Pink" width=""><b>{$form.allcheck19.html}</b></td>
		<td class="Title_Pink" width=""><b>�ԡ�<a href="#" title="����������ɲä��ޤ���">�ɲ�</a>��</b></td>
	</tr>

	<!--1����-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">{$form.f_goods1.html}��<a href="javascript:Sub_Window_Open('goods1.php','goods1')">����</a>��<br>{$form.t_goods1.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">��</td>
		<td align="center">{$form.f_code_c1.html}<br>{$form.f_code_c2.html}</td>
		<td align="center">{$form.f_code_c3.html}<br>{$form.f_code_c4.html}</td>
		<td align="center">{$form.check19.html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
	</tr>
	
	<!--2����-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">{$form.f_goods2.html}��<a href="javascript:Sub_Window_Open('goods1.php','goods2')">����</a>��<br>{$form.t_goods2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">��</td>
		<td align="center">{$form.f_code_c5.html}<br>{$form.f_code_c6.html}</td>
		<td align="center">{$form.f_code_c7.html}<br>{$form.f_code_c8.html}</td>
		<td align="center">{$form.check19.html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
	</tr>
	
	<!--3����-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">{$form.f_goods3.html}��<a href="javascript:Sub_Window_Open('goods1.php','goods3')">����</a>��<br>{$form.t_goods3.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">��</td>
		<td align="center">{$form.f_code_c9.html}<br>{$form.f_code_c10.html}</td>
		<td align="center">{$form.f_code_c11.html}<br>{$form.f_code_c12.html}</td>
		<td align="center">{$form.check19.html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
	</tr>

	<!--4����-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">{$form.f_goods4.html}��<a href="javascript:Sub_Window_Open('goods1.php','goods4')">����</a>��<br>{$form.t_goods4.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">��</td>
		<td align="center">{$form.f_code_c13.html}<br>{$form.f_code_c14.html}</td>
		<td align="center">{$form.f_code_c15.html}<br>{$form.f_code_c16.html}</td>
		<td align="center">{$form.check19.html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
	</tr>

	<tr class="Result2" align="center">
		<td align="left"><b>���</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>3,000.00<br>3,750.00</b></td>
		<td></td>
		<td></td>
	</tr>

</table>

<table width="100%">
	<tr>
		<td align="left">
			<b><font color="red">����ɬ�����ϤǤ�</font></b>
		</td>
		<td align="right">{$form.button.order.html}����{$form.button.complete.html}</td>
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

{$var.html_footer}
	
