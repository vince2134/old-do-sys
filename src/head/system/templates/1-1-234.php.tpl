
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


{$form.hidden}
<!---------------------- ����ɽ��1���� --------------------->
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_bstruct_cd.error == null && $form.form_bstruct_name.error == null}
        <li>{$var.message}<br><br>
    {/if}
    </span>
     {* ���顼��å��������� *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_bstruct_cd.error != null}
        <li>{$form.form_bstruct_cd.error}<br>
    {/if}
    {if $form.form_bstruct_name.error != null}
        <li>{$form.form_bstruct_name.error}<br>
    {/if}
    </span> 

<table class="Data_Table" border="1" width="450">

	<tr>
		<td class="Title_Purple" width="100"><b>���֥�����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_bstruct_cd.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>����̾<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_bstruct_name.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>����</b></td>
		<td class="Value">{$form.form_bstruct_note.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>��ǧ</b></td>
		<td class="Value">{$form.form_accept.html}</td>
	</tr>
</table>
<table width='450'>
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
		<td align="right">
			{$form.form_entry_button.html}����{$form.form_clear_button.html}
		</td>
	</tr>
</table>
<br>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->

<table>
	<tr>
		<td width="50%" align="left">��<b>{$var.total_count}</b>�{$form.form_csv_button.html}</td>
	</tr>
</table>


<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>���֥�����</b></td>
		<td class="Title_Purple" width=""><b>����̾</b></td>
		<td class="Title_Purple" width=""><b>����</b></td>
		<td class="Title_Purple" width=""><b>��ǧ</b></td>
	</tr>

    {foreach from=$page_data key=i item=item}
	<tr class="Result1">
		<td align="right">{$i+1}</td>
		<td align="left">{$item[0]}</td>
		<td align="left"><a href="?bstruct_id={$item[1]}">{$item[2]}</a></td>
		<td align="left">{$item[3]}</td>
        {if $item[4] == '1'}
		    <td align="center">��</td>
        {else}
            <td align="center"><font color="red">��</font></td>
        {/if}
	</tr>
    {/foreach}
	
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
	

