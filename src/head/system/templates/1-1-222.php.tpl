
{$var.html_header}
<script>
{$var.js}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*--------------------- ���ȳ��� ----------------------*}
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
{*---------------------- ����ɽ��1���� ---------------------*}
			{*+++++++++++++++ �إå��� begin +++++++++++++++*}{$var.page_header}{*--------------- �إå��� e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	


		{*-------------------- ����ɽ������ -------------------*}
		<td valign="top">

			<table>
				<tr>
					<td>


{$form.hidden}
<table border="0" width="100%">
<tr>
	<font size="+0.5" color="#555555"><b>�ھ���̾�ۡ� {$var.goods_name} </b></font>
</tr>
<tr>
	<font size="+0.5" color="#555555"><b>��ά�����ۡ� {$var.goods_cname} </b></font>
</tr>
<tr>
    <td>
    {if $var.warning != null}
    <font color="blue"><b>{$var.warning}
    </b></font>
    {/if}
    </td>
</tr>
{* ���顼��å��������� *}
{*
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">

    {foreach from=$form.form_price key=i item=item}
    {if $form.form_price[$i].error != null}
        <li>{$form.form_price[$i].error}<br>
    {/if}
    {/foreach}
    {if $var.price_err != null}
        <li>{$var.price_err}<br>
    {/if}
    {if $var.rprice_err != null}
        <li>{$var.rprice_err}<br>
    {/if}
    {if $var.cday_err != null}
        <li>{$var.cday_err}<br>
    {/if}
    {if $var.cday_rprice_err != null}
        <li>{$var.cday_rprice_err}<br>
    {/if}
    </span>
*}
{*---------------------��å���������-------------------*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
</span>


</table>

<table class="Data_Table" border="1" width="610">
<col width="130" style="font-weight: bold;">
<col width="130">
<col width="130">
<col width="100">
<col width="150">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple" rowspan="2">ñ������</td>
		<td class="Title_Purple" rowspan="2">����ñ��</td>
		<td class="Title_Purple" colspan="2">����ñ��</td>
		<td class="Title_Purple" rowspan="2">������</td>
	</tr>

	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">����</td>
		<td class="Title_Purple">ɸ����ʤΡ�</td>
	</tr>

    {*1����*}
    {foreach from=$form.form_price key=i item=item name=price}
    {if $i > 0 && $i != 2 && $i != 3}
        {if $i == 1}
        <tr class="Result2">
        {else}
        <tr class="Result1">
        {/if}
            <td class="Title_Purple" align="left">{$form.form_price[$i].label}{if $required_flg[$i] == true}<font color="#ff0000">��</font>{/if}</td>
            <td align="right">{$form.form_price[$i].html}</a></td>
            <td align="center">{$form.form_rprice[$i].html}</td>
            <td align="center">
            {if $i>1}{$form.form_cost_rate[$i].html} %{/if}</td>
            <td align="center">{$form.form_cday[$i].html}</td>
        </tr>
    {/if}
    {/foreach} 
    {*�ղ�*} 
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[0].label}{if $required_flg[0] == true}<font color="#ff0000">��</font>{/if}</td>
        <td align="right">{$form.form_price[0].html}</a></td>
        <td align="center">{$form.form_rprice[0].html}</td>
        <td align="center"></td>
        <td align="center">{$form.form_cday[0].html}</td>
    </tr>
    {*��󥿥�ñ��*}
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[3].label}{if $required_flg[3] == true}<font color="#ff0000">��</font>{/if}</td>
        <td align="right">{$form.form_price[3].html}</a></td>
        <td align="center">{$form.form_rprice[3].html}</td>
        <td align="center">{$form.form_cost_rate[3].html} %</td>
        <td align="center">{$form.form_cday[3].html}</td>
    {*��󥿥븶��*}
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[2].label}{if $required_flg[2] == true }<font color="#ff0000">��</font>{/if}</td>
        <td align="right">{$form.form_price[2].html}</a></td>
        <td align="center">{$form.form_rprice[2].html}</td>
        <td align="center">{$form.form_cost_rate[2].html} %</td>
        <td align="center">{$form.form_cday[2].html}</td>
    </tr>
</table>

<table width="610">
	<tr>
        {if $var.new_flg == true}
        <td align="left">
            <b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
        </td>
        {/if}
		<td align="right">
			{$form.form_entry_button.html}��{$form.form_back_button.html}
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

<font size="+0.5" color="#555555"><b>�ڲ��������</b></font>
{$var.html_page}
<table class="List_Table" border="1" width="610">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">������</td>
		<td class="Title_Purple">ñ������</td>
		<td class="Title_Purple">������ñ��</td>
		<td class="Title_Purple">������ñ��</td>
		<td class="Title_Purple">ñ�������</td>
	</tr>
    {foreach key = i from=$show_data item=items}
	<tr class="Result1">
                {foreach key=j from=$items item=item}
                {if $j == 0}
		<td align="center">{$item}</td>
                {elseif $j == 1}
		<td align="left">{$item}</td>
                {elseif $j> 1}
		<td align="left">{$item}</td>
                {/if}
                {/foreach}
	</tr>
	{/foreach}
	
</table>

{$var.html_page2}
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
	

