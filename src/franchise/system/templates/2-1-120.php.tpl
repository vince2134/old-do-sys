
{$var.html_header}

<body bgcolor="#D8D0C8">

<form name="referer" method="post">
{*-------------------- ���ȳ��� ---------------------*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
<form {$form.attributes}>
			{*- ���̥����ȥ볫�� -*} {$var.page_header} {*- ���̥����ȥ뽪λ -*}
		</td>
	</tr>

	<tr align="center">
	

		{*--------------------- ����ɽ������ --------------------*}
		<td valign="top">

<table border="0">
		<tr>
			<td>


{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------------- ����ɽ��1���� --------------------*}
<font size="+0.5" color="#555555"><b>�ڥ����ӥ�/���ʰ��������</b></font>
<table class="List_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value">{$form.f_customer.code1.html}-{$form.f_customer.code2.html}</td>
        <td class="Title_Purple">������̾</td>
        <td class="Value">{$form.f_customer.name.html}
    </tr>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value">{$form.f_claim.code1.html}-{$form.f_claim.code2.html}</td>
        <td class="Title_Purple">������̾</td>
        <td class="Value">{$form.f_claim.name.html}
    </tr>
    <tr>
        <td class="Title_Purple">�����ӥ�</td>
        <td class="Value" colspan="3">{$form.form_serv.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Value">{$form.f_goods1.html}</td>
        <td class="Title_Purple">����̾</td>
        <td class="Value">{$form.t_goods1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�Ķ�ñ��</td>
        <td class="Value" colspan="3">{$form.f_code_c1.f_text9.html}������{$form.f_code_c1.f_text9.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ñ��</td>
        <td class="Value" colspan="3">{$form.f_code_c1.f_text9.html}������{$form.f_code_c1.f_text9.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ô����</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td>{$form.button.hyouji.html}��{$form.button.kuria.html}</td>
    </tr>
</table>


<br><br>
<table border="0" >
	<tr>
		<td width="50%" align="left">��<b>{$var.total_count}</b>�{$form.button.csv_button.html}</td>
	</tr>
</table>
<table class="List_Table" border="1" width="100%">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">���ͽ����</td>
		<td class="Title_Purple">������</td>
		<td class="Title_Purple">������</td>
		<td class="Title_Purple">�����ӥ�</td>
		<td class="Title_Purple">�����ƥ�</td>
		<td class="Title_Purple">�Ķȸ���</td>
		<td class="Title_Purple">���ñ��</td>
		<td class="Title_Purple">���ô����</td>
		<td class="Title_Purple">{$form.allcheck13.html}</td>
	</tr>

    {foreach from=$demo_data item=item key=i}
    {if $i IS even}
	<tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
		<td align="right">{$i+1}</td>
		<td align="left">{$demo_data[$i][0]}</td>
		<td align="left">{$demo_data[$i][1]}</td>
		<td align="left">{$demo_data[$i][2]}</td>
		<td align="left"><font color="blue"><b>{$demo_data[$i][3]}</b></font></td>
		<td align="left"><font color="blue"><b>{$demo_data[$i][4]}</b></font></td>
		<td align="right"><font color="blue"><b>{$demo_data[$i][5]}</b></font></td>
		<td align="right"><font color="blue"><b>{$demo_data[$i][6]}</b></font></td>
		<td align="left">{$demo_data[$i][7]}</td>
		<td align="center">{$form.check13.html}</td>
	</tr>
    {/foreach}	

    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{$form.ikkatsu_teisei_he.html}</td>
    </tr>

</table>
<br>
<table width="100%">
	<tr>
		<td align='right'>
			{$form.button.modoru.html}
		</td>
	</tr>
</table>


</td></tr>
</table>


{*-******************** ����ɽ��1��λ *******************-*}

					</td>
				</tr>

				<tr>
					<td>

{*--------------------- ����ɽ��2���� --------------------*}




{*-******************** ����ɽ��2��λ *******************-*}

					</td>
				</tr>
			</table>
		</td>
		{*-******************** ����ɽ����λ *******************-*}

	</tr>
</table>
{*-******************* ���Ƚ�λ ********************-*}

{$var.html_footer}
	

