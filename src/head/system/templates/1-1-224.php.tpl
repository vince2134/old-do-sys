
{$var.html_header}

<script language="javascript">
{$var.code_value} 
</script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
{*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
<form {$form.attributes}>
			{*+++++++++++++++ �إå��� begin +++++++++++++++*} {$var.page_header} {*--------------- �إå��� e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	

		{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
		<td valign="top">

			<table>
				<tr>
					<td>


<table width="450">
    <tr>
        <td align="right">
            {if $smarty.get.goods_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>
{* ���顼��å��������� *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_make_goods.error != null}
        <li>{$form.form_make_goods.error}<br>
    {/if}
    {if $var.goods_err != null}
        <li>{$var.goods_err}<br>
    {/if}
    {if $var.numerator_err != null}
        <li>{$var.numerator_err}<br>
    {/if}
    {if $var.numerator_numeric_err != null}
        <li>{$var.numerator_numeric_err}<br>
    {/if}
    {if $var.denominator_err != null}
        <li>{$var.denominator_err}<br>
    {/if}
    {if $var.denominator_numeric_err != null}
        <li>{$var.denominator_numeric_err}<br>
    {/if}
    {if $var.used_goods_err != null}
        <li>{$var.used_goods_err}<br>
    {/if}
    {if $var.used_make_goods_err != null}
        <li>{$var.used_make_goods_err}<br>
    {/if}
    {if $var.make_goods_flg_err != null}
        <li>{$var.make_goods_flg_err}<br>
    {/if}
    {if $var.goods_input_err != null}
        <li>{$var.goods_input_err != null}<br>
    {/if}
    </span>
<table class="Data_Table" border="1" width="450">

	<tr>
		<td class="Title_Purple" width="110"><b>{$form.form_goods_link.html}<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_make_goods.html}</td>
	</tr>

</table>
<table width="450">
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
	</tr>
</table>

<br>
{*--------------- ����ɽ���� e n d ---------------*}

					</td>
				</tr>

				<tr>
					<td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{**}
<font size="+0.5" color="#555555"><b>���������ơ�</b></font>
<table class="List_Table" border="1" width="650">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">���ʥ�����</td>
		<td class="Title_Purple">����̾</td>
		<td class="Title_Purple">���̡�ʬ��/ʬ���</td>
    {if $var.freeze_flg != true}
		<td class="Title_Purple"><b>��(<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true')">�ɲ�</a>)</b></td>
    {/if}
	</tr>
{$var.html}
{$form.hidden}

</table>
<table width="650">
	<tr>
		<td align="right">
			{$form.form_entry_button.html}����{$form.form_back_button.html}
		</td>
	</tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

					</td>
				</tr>
			</table>
		</td>
		{*--------------- ����ƥ���� e n d ---------------*}

	</tr>
</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
	

