
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border="0">
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->
{* ��Ͽ���ѹ���λ��å��������� *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>
{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_fax_msg != null}<li>{$var.error_fax_msg}<br>{/if}
{if $var.error_tel_msg != null}<li>{$var.error_tel_msg}<br>{/if}</span><br>
<font size="+0.5"><b>������FAX�ֹ桢���������ֹ�����Ϥ��Ƥ�������</b></font><br>
<font size="+0.5"><b>���������˥����Ȥ����Ϥ��Ƥ�������</b></font>
<table class='List_Table' border='0' width='740' height='1085' background="../../../image/order.png">
<tr>
	<td valign="bottom" height='135'>
		<table width='550' align="right">
		<tr><td>
		<font color='#ff0000'>
		�� {$form.o_memo1.html}<br>
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
		�� {$form.o_memo2.html}<br>
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
		�� {$form.o_memo3.html}<br>
		�� {$form.o_memo4.html}<br>
		�� {$form.o_memo5.html}<br>
		�� {$form.o_memo6.html}<br>
		�� {$form.o_memo7.html}<br>
		�� {$form.o_memo8.html}<br>
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
		<td align="right">{$form.new_button.html}����{$form.order_button.html}</td>
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

{$var.html_footer}
	


	
