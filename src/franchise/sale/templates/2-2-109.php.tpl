
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- ���ȳ��� --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			{* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
		</td>
	</tr>

	<tr align="center">
		<td valign="top">
		
			<table>
				<tr>
					<td>

{*-------------------- ����ɽ��1���� -------------------*}
<table  class="Data_Table" border="1" width="550" >

{*-	<tr>
		<td class="Title_Pink" width="175"><b>���ô����</b></td>
		<td class="Value">{$form.form_staff_1.html}</td>
	</tr>-*}
	<tr>
		<td class="Title_Pink" width="175"><b>������</b></td>
		<td class="Value">{$form.f_date_b1.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>���ô���ԥ�����</b></td>
		<td class="Value">{$form.f_code_g1.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>���ô���ԥ�����<br>(����޶��ڤ�)</b></td>
		<td class="Value">{$form.f_textx.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>�������ô���ԥ�����<br>(����޶��ڤ�)</b></td>
		<td class="Value">{$form.f_textx.html}</td>
	</tr>

</table>
<table width='550'>
	<tr>
		<td align='right'>
			{$form.hyouji.html}����{$form.kuria.html}
		</td>
	</tr>
</table>
{********************* ����ɽ��1��λ ********************}

					<br>
					</td>
				</tr>


				<tr>
					<td>

{*-------------------- ����ɽ��2���� -------------------*}
{$var.html_page}


<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Pink" width=""><b>No.</b></td>
		<td class="Title_Pink" width=""><b>���ô����</b></td>
		<td class="Title_Pink" width=""><b>������</b></td>
		<td class="Title_Pink" width=""><b>����</b></td>
		<td class="Title_Pink" width=""><b>�������������ǧɽ����</b></td>
		<td class="Title_Pink" width="150"><b>{$form.allcheck14.html}</b></td>
	</tr>

	{*1����*}
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">���ô��1</td>
		<td align="center"><a href="2-2-106.php">2005-06-01</a></td>
		<td align="right">3��</td>
		<td align="center">������</td>
		<td align="center">{$form.check14.html}</td>
	</tr>
	
	{*2����*}
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">���ô��2</td>
		<td align="center"><a href="2-2-106.php">2005-06-02</a></td>
		<td align="right">3��</td>
		<td align="center">������</td>
		<td align="center">{$form.check14.html}</td>
	</tr>
	
	{*3����*}
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">���ô��3</td>
		<td align="center"><a href="2-2-106.php">2005-06-02</a></td>
		<td align="right">3��</td>
		<td align="center">̤</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*4����*}
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">���ô��4</td>
		<td align="center"><a href="2-2-106.php">2005-06-04</a></td>
		<td align="right">3��</td>
		<td align="center">������</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*5����*}
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">���ô��1</td>
		<td align="center"><a href="2-2-106.php">2005-06-01</a></td>
		<td align="right">3��</td>
		<td align="center">̤</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*6����*}
	<tr class="Result2">
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right" colspan="2">{$form.delivery.html}</td>
	</tr>

</table>

{$var.html_page2}

{********************* ����ɽ��2��λ ********************}


					</td>
				</tr>
			</table>
		</td>
		{********************* ����ɽ����λ ********************}

	</tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}
	

