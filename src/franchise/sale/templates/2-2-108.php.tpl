
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- ���ȳ��� --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

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
<font size="+0.5" color="#555555"><b>�ڸ�ͽ���</b></font>
<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Pink" width="100"><b>���ͽ����</b></td>
		<td class="Value" colspan="3">{$form.f_date_b1.html}</td>
	</tr>
    <tr>
        <td class="Title_Pink" width="120"><b>�����襳����</b></td>
        <td class="Value" width="200">{$form.form_client_cd1.html}-{$form.form_client_cd2.html}</td>
        <td class="Title_Pink" width="100"><b>������̾</b></td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
	<tr>
		<td class="Title_Pink" width="120"><b>���ô����</b></td>
		<td class="Value" colspan="3">{$form.form_staff_2.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" width="120"><b>������̾</b></td>
		<td class="Value" colspan="3">{$form.form_client_name.html}</td>
	</tr>
	

</table>
<table width='650'>
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
		<td class="Title_Pink" width=""><b>�����ֹ�</b></td>
		<td class="Title_Pink" width=""><b>���ͽ����</b></td>
		<td class="Title_Pink" width=""><b>�����襳����<br>������̾</b></td>
        <td class="Title_Pink" width=""><b>���ô����</b></td>
        <td class="Title_Pink" width=""><b>������</b></td>
		<td class="Title_Pink" width="150"><b>{$form.allcheck13.html}</b></td>
	</tr>
    {foreach from=$demo_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td align="left"><a href="2-2-106.php">{$demo_data[$i][0]}</a></td>
        <td align="right">{$demo_data[$i][1]}</td>
        <td align="left">{$demo_data[$i][2]}<br>{$demo_data[$i][3]}</td>
        <td align="left">{$demo_data[$i][4]}</td>
        <td align="left">{$demo_data[$i][5]}</td>
        <td align="center">{$form.check13.html}</td>
    </tr>
    {/foreach}
	<tr class="Result3">
		<td align="right"></td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="left"></td>
		<td align="right"></td>
		<td align="center">{$form.ikkatsu_teisei_he.html}</td>
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
