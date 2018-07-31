{$var.html_header}

<script language="javascript">
{$var.js}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
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
    {foreach from=$goods_err item=item key=i}
        {if $goods_err[$i] != null}
        <li>{$goods_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$price_num_err item=item key=i}
        {if $price_num_err[$i] != null}
        <li>{$price_num_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$num_err item=item key=i}
        {if $num_err[$i] != null}
        <li>{$num_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$price_err item=item key=i}
        {if $price_err[$i] != null}
        <li>{$price_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$duplicate_goods_err item=item key=i}
        <li>{$duplicate_goods_err[$i]}<br>
    {/foreach}
    </ul>
    </span>

{if $var.freeze_flg != null}
    {if $var.goods_twice != null}
        <font color="red"><b>{$var.goods_twice}</b></font><br>
    {/if} 
      <span style="font: bold;"><font size="+1">以下の内容で発注しますか？</font></span><br>
{/if}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
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
        <td class="Title_Blue">発注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
*}


{*
{if $var.update_flg == true}
<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">発信日</td>
        <td class="VALUE">{$form.form_send_date.html}</td>
    </tr>
</table>
<br>
{/if}
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

        {if $var.head_flg == 't'}
            <td class="Value" colspan="3">{$form.form_client.html}</td>
        {else}
            <td class="Value">{$form.form_client.html}</td>
            <td class="Title_Blue">発注日<font color="#ff0000">※</font></td>
            <td class="Value">{$form.form_order_day.html}</td>
        {/if}

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
        <td class="Title_Blue">発注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff.html}</td>
        <td class="Title_Blue">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="5">{$form.form_note_your.html}</td>
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
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
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
        <td class="Title_Blue">ロット仕入</td>
        <td class="Title_Blue">ロット数</td>
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

{if $var.warning == null}
<table width="100%">
    <tr>
        	<td>{$form.form_add_row.html}</td>
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
        <td>{$form.form_sum_button.html}</td>
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
{/if}
        </td>
    </tr>
</table>
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
