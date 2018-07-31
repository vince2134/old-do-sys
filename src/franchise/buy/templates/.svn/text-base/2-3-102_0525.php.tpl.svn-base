{$var.html_header}

<script language="javascript">
{$var.dialogue}
{$var.goods_search}
{$var.body_onload}
{$var.open_subwin}
</script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">


<table width="100%" height="90%" class="M_table">


    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>

    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

</form>
<form {$form.attributes}>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_designated_date.error != null}
        <li>{$form.form_designated_date.error}<br>
    {/if}
    {if $form.form_order_day.error != null}
        <li>{$form.form_order_day.error}<br>
    {/if}
    {if $form.form_hope_day.error != null}
        <li>{$form.form_hope_day.error}<br>
    {/if}
    {if $form.form_ware.error != null}
        <li>{$form.form_ware.error}<br>
    {/if}
    {if $form.form_trade.error != null}
        <li>{$form.form_trade.error}<br>
    {/if}
    {if $form.form_staff.error != null}
        <li>{$form.form_staff.error}<br>
    {/if}
    {if $form.form_note_my.error != null}
        <li>{$form.form_note_my.error}<br>
    {/if}
    {if $form.form_note_your.error != null}
        <li>{$form.form_note_your.error}<br>
    {/if}
    {if $form.form_direct.error != null}
        <li>{$form.form_direct.error}<br>
    {/if}
    {if $form.form_order_no.error != null}
        <li>{$form.form_order_no.error}<br>
    {/if}
    {if $form.form_buy_money.error != null}
        <li>{$form.form_buy_money.error}<br>
    {/if}
    </span>


<table>
    <tr>
        <td>
{*
<table class="Data_Table" border="1" width="700">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">発注番号</td>
        <td class="Value" colspan="3">{$form.form_order_no.html}</td>
    </tr>
    <tr>
        {if $var.freeze_flg == null}
            <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
        {else}
            <td class="Title_Blue">発注先<font color="#ff0000">※</font></td>
        {/if}
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value" colspan="3">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
    </tr>
    <tr>
        <td class="Title_Blue">発注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Blue">希望納期</td>
        <td class="Value">{$form.form_hope_day.html}</td>    </tr>
    <tr>
        <td class="Title_Blue">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value">{$form.form_direct.html}</td>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">取引区分</a><font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Blue">担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="3">{$form.form_note_my.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
*}

{*<table class="Data_Table" border="1">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">発注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        {if $var.freeze_flg == null}
            <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
        {else}
            <td class="Title_Blue">発注先<font color="#ff0000">※</font></td>
        {/if}
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">発注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Blue">希望納期</td>
        <td class="Value">{$form.form_hope_day.html}</td>    </tr>
    <tr>
        <td class="Title_Blue">運送業者</td>
        <td class="Value">{$form.form_trans.html}</td>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value">{$form.form_direct.html}</td>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">取引区分</a><font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Blue">担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="3">{$form.form_note_my.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
*}

<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">発注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        {if $var.freeze_flg == null}
            <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
        {else}
            <td class="Title_Blue">発注先<font color="#ff0000">※</font></td>
        {/if}
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Blue">発注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_order_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">取引区分</a><font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Blue">希望納期</td>
        <td class="Value">{$form.form_hope_day.html}</td>    </tr>
    </tr>
    <tr>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
        <td class="Title_Blue">直送先</td>
        <td class="Value" colspan="3">{$form.form_direct.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff.html}</td>
        <td class="Title_Blue">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="5">{$form.form_note_my.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold; color: #ff0000;">{$var.warning}</span>

        </td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>


<table width="100%">
    <tr>
        <td>

{$form.hidden}
<span style="font: bold; color: #ff0000;">{$var.message}</span>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">実棚数<br>(A)</td>
        <td class="Title_Blue">発注済数<br>(B)</td>
        <td class="Title_Blue">引当数<br>(C)</td>
        <td class="Title_Blue">出荷可能数<br>(A+B-C)</td>
        <td class="Title_Blue">発注数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
        {if $var.warning == null && $var.freeze_flg == null}
            <td class="Title_Add" width="50">行削除</td>
        {/if}
    </tr>
    {$var.html}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        {if $var.warning == null}
        	<td>{$form.form_add_row.html}</td>
    	{/if}
        <td>
            <table class="List_Table" border="1" align="right" style="font-weight: bold;">
                <tr>
                    <td class="Title_Blue" width="80" align="center">税抜金額</td>
                    <td class="Value" width="100" align="right">{$form.form_buy_money.html}</td>
                    <td class="Title_Blue" width="80" align="center">消費税</td>
                    <td class="Value" width="100" align="right">{$form.form_tax_money.html}</td>
                    <td class="Title_Blue" width="80" align="center">税込合計</td>
                    <td class="Value" width="100" align="right">{$form.form_total_money.html}</td>
                </tr>
            </table>
        </td>
        {if $var.warning == null}
        <td>{$form.form_sum_button.html}</td>
        {/if}
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
<A NAME="foot"></A>
<table width="100%">
    <tr>
		<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
		{* 登録確認画面判定 *} 
		{if $var.freeze_flg == null}
			{* 以外 *} 
        	<td align="right">{$form.form_order_button.html}</td>
		{else}
			{* 登録確認画面 *} 
			<td align="right">{$form.comp_button.html}　　{$form.order_button.html}　　{$form.return_button.html}</td>
		{/if}
    </tr>
</table>
        </td>
    </tr>
</table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>
{$var.html_footer}
