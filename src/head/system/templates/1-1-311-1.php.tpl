
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
<table width='750'>
	<tr>
		<td align="left"><font size="+0.5"><b>�����ѥ��������Ͽ���ޤ�����</b></font>��������{$form.back_button.html}��������{$form.preview_button.html}</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
</table>
<font size="+0.5"><b>�ѥ�����̾���ѥ�����<br>���������˼��Ҿ�������Ϥ��Ƥ�������<br>�����˥����Ȥ����ꤷ�Ʋ��������ʥ����Ȥ����ѥ�����Ƕ��̤Ǥ�����</b></font>
<table class='List_Table' border='1' width='720' height="360">
	<tr>
		<td class='Value' valign='middle'>
	   		<table align="center" valign="middle" border="0" width="740" height="350" background="../../../image/saling.png">
			<tr>
				<td valign="top" width="520" height="1" align="right" colspan="3">
					<img src="../../../image/company-rogo_small.png"><br>
				</td>
			</tr>
			<tr>
				<td valign="top" width="520" align="right" colspan="2">
				</td>
				<td valign="top" align="left" height="190">
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo1}</font><br>
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo2}</font><br>
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo3}</font><br>
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo4}</font><br>
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo5}</font><br>
					<font color='#ff0000' size = '1'>��</font>��<font size = '1'>{$var.s_memo6}</font><br>
				</font>                            
				</td>
			</tr>
			<tr>
				<td rowspan="2">
					<font color='#ff0000'>����</font>
				</td>
				<td height="10">
				</td>
			</tr>
			<tr>
				<td width="300" align="left">
					{$form.s_memo7.html}
				</td>
			</tr>
		</td>
	</tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->

</table>
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
	

