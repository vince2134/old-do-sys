
{$var.html_header}
<script>
{$var.js}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*--------------------- 外枠開始 ----------------------*}
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
{*---------------------- 画面表示1開始 ---------------------*}
			{*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}{$var.page_header}{*--------------- ヘッダ類 e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	


		{*-------------------- 画面表示開始 -------------------*}
		<td valign="top">

			<table>
				<tr>
					<td>


{$form.hidden}
<table border="0" width="100%">
<tr>
	<font size="+0.5" color="#555555"><b>【商品名】： {$var.goods_name} </b></font>
</tr>
<tr>
	<font size="+0.5" color="#555555"><b>【略　記】： {$var.goods_cname} </b></font>
</tr>
<tr>
    <td>
    {if $var.warning != null}
    <font color="blue"><b>{$var.warning}
    </b></font>
    {/if}
    </td>
</tr>
{* エラーメッセージ出力 *}
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
{*---------------------メッセージ出力-------------------*}
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
		<td class="Title_Purple" rowspan="2">単価項目</td>
		<td class="Title_Purple" rowspan="2">現在単価</td>
		<td class="Title_Purple" colspan="2">改訂単価</td>
		<td class="Title_Purple" rowspan="2">改訂日</td>
	</tr>

	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">指定</td>
		<td class="Title_Purple">標準価格の％</td>
	</tr>

    {*1行目*}
    {foreach from=$form.form_price key=i item=item name=price}
    {if $i > 0 && $i != 2 && $i != 3}
        {if $i == 1}
        <tr class="Result2">
        {else}
        <tr class="Result1">
        {/if}
            <td class="Title_Purple" align="left">{$form.form_price[$i].label}{if $required_flg[$i] == true}<font color="#ff0000">※</font>{/if}</td>
            <td align="right">{$form.form_price[$i].html}</a></td>
            <td align="center">{$form.form_rprice[$i].html}</td>
            <td align="center">
            {if $i>1}{$form.form_cost_rate[$i].html} %{/if}</td>
            <td align="center">{$form.form_cday[$i].html}</td>
        </tr>
    {/if}
    {/foreach} 
    {*付加*} 
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[0].label}{if $required_flg[0] == true}<font color="#ff0000">※</font>{/if}</td>
        <td align="right">{$form.form_price[0].html}</a></td>
        <td align="center">{$form.form_rprice[0].html}</td>
        <td align="center"></td>
        <td align="center">{$form.form_cday[0].html}</td>
    </tr>
    {*レンタル単価*}
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[3].label}{if $required_flg[3] == true}<font color="#ff0000">※</font>{/if}</td>
        <td align="right">{$form.form_price[3].html}</a></td>
        <td align="center">{$form.form_rprice[3].html}</td>
        <td align="center">{$form.form_cost_rate[3].html} %</td>
        <td align="center">{$form.form_cday[3].html}</td>
    {*レンタル原価*}
    <tr class="Result2">
        <td class="Title_Purple" align="left">{$form.form_price[2].label}{if $required_flg[2] == true }<font color="#ff0000">※</font>{/if}</td>
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
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        {/if}
		<td align="right">
			{$form.form_entry_button.html}　{$form.form_back_button.html}
		</td>
	</tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

					</td>
				</tr>

				<tr>
					<td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}

<font size="+0.5" color="#555555"><b>【改訂履歴】</b></font>
{$var.html_page}
<table class="List_Table" border="1" width="610">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">改訂日</td>
		<td class="Title_Purple">単価項目</td>
		<td class="Title_Purple">改訂前単価</td>
		<td class="Title_Purple">改訂後単価</td>
		<td class="Title_Purple">単価改定者</td>
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
{*--------------- 画面表示２ e n d ---------------*}

					</td>
				</tr>
			</table>
		</td>
		{*--------------- コンテンツ部 e n d ---------------*}

	</tr>
</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
	

