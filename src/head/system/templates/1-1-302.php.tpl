
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
{if $form.password.error != null}<li>{$form.password.error}<br>{/if}
{if $form.password_conf.error != null}<li>{$form.password_conf.error}<br>{/if}
<!-- ���ߤΥѥ������� -->
{if $var.error_msg != null}
    <li>{$var.error_msg}<br>
{/if}
</span><br>

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="140"><b>���ߤΥѥ����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.password_now.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="140"><b>�������ѥ����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.password.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="140"><b>�������ѥ����<font color="#ff0000">��</font><br>(��ǧ��)</b></td>
		<td class="Value">{$form.password_conf.html}</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align="left">
            <font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>
        </td>
		<td align="right">
			{$form.touroku.html}
		</td>
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
	

