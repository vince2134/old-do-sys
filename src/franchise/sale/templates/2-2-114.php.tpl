
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}
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
<table width='550'>
	<tr>
        <td align="center">
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        {if $var.check_err != null}<li>{$var.check_err}<br>{/if}
        {if $var.duplicate_err != null}<li>{$var.duplicate_err}<br>{/if}
</span>
        </td>
    </tr>
    <tr>
		<td align='center'>
			{$form.form_hdn_submit.html}����{$form.form_close_button.html}
		</td>
	</tr>
</table>

					</td>
				</tr>
			</table>
		</td>
		{********************* ����ɽ����λ ********************}

	</tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}
