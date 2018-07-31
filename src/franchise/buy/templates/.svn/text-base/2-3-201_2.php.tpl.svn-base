{$var.html_header}
{$var.form_potision}

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
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_designated_date.error != null}
        <li>{$form.form_designated_date.error}<br>
    {/if}
    {if $form.form_arrival_day.error != null}
        <li>{$form.form_arrival_day.error != null}<br>
    {/if}
    {if $form.form_buy_day.error != null}
        <li>{$form.form_buy_day.error != null}<br>
    {/if}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_ware.error != null}
        <li>{$form.form_ware.error}<br>
    {/if}
    {if $form.form_trade.error != null}
        <li>{$form.form_trade.error}<br>
    {/if}
    {if $form.form_buy_staff.error != null}
        <li>{$form.form_buy_staff.error}<br>
    {/if}
    {if $form.form_buy_no.error != null}
        <li>{$form.form_buy_no.error}<br>
    {/if}
    {if $form.form_direct.error != null}
        <li>{$form.form_direct.error}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $var.duplicate_msg != null}
        <li>{$var.duplicate_msg}<br>
    {/if}
    {if $var.claim_date_err != null}
        <li>{$var.claim_date_err}<br>
    {/if}
    </span>
{if $var.comp_flg != null}
{if $var.goods_twice != null}
<font color="red"><b>{$var.goods_twice}</b></font><br>
{/if}
<span style="font: bold;"><font size="+1">以下の内容で仕入ますか？</font></span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>


<table class="Data_Table" border="1">
<col width="90" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">伝票番号</td>
        <td class="Value">{$form.form_buy_no.html}</td>
        {if $var.freeze_flg != true && $var.buy_get_flg != true}
        <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
        {else}
        <td class="Title_Blue">仕入先<font color="#ff0000">※</font></td>
        {/if}
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Blue">発注番号</td>
        <td class="Value">{$form.form_order_no.html}　{$form.form_show_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">発注日</td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Blue">仕入日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_buy_day.html}</td>
        <td class="Title_Blue">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">入荷予定日</td>
        <td class="Value">{$form.form_arrival_hope_day.html}</td>
        <td class="Title_Blue">入荷日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_arrival_day.html}</td>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value" colspan="3">{$form.form_direct.html}</td>
        <td class="Title_Blue" >発注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_order_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">備考</td>
        <td class="Value" colspan="3">{$form.form_note.html}</td>
        <td class="Title_Blue" >仕入担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_buy_staff.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<font color="#ff0000"><b>{$var.warning}</b></font>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                </td>
            </tr>
            <tr>
                <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td valign="bottom"><font color="#ff0000"><b>{$var.message}</b></font></td>
        <td>
            <table class="List_Table" border="1" align="right" width="200">
                <tr>
                    <td class="Title_Blue" align="center" width="100"><b>当月御買上額</b></td>
                    <td class="Value" align="right">{$var.ap_balance}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

{$form.hidden}
<table class="List_Table" border="1" width="100%">
{*
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">現在庫数<br>発注数</td>
        <td class="Title_Blue">入数</td>
        <td class="Title_Blue">仕入入数</td>
        <td class="Title_Blue">仕入済数<br>仕入数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
        <td class="Title_Blue">発注残</td>
    {if $var.client_search_flg == true && $var.stock_search_flg == true && $var.freeze_flg != true && $var.comp_flg == null}
        <td class="Title_Add" width="50">行削除</td>
    {/if}
    </tr>
*}
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">現在庫数</td>
        <td class="Title_Blue">発注残</td>
        <td class="Title_Blue">ロット仕入</td>
        <td class="Title_Blue">ロット入数</td>
        <td class="Title_Blue">仕入数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
    {if $var.client_search_flg == true && $var.stock_search_flg == true && $var.freeze_flg != true && $var.comp_flg == null}
        <td class="Title_Add" width="50">行削除</td>
    {/if}
{$var.html}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        {if $var.client_search_flg == true && $var.stock_search_flg == true && $var.freeze_flg != true}
            <td>{$form.add_row_link.html}</td>
        {/if}
        <td align="right" width="100%">
            <table class="List_Table" border="1" style="font-weight: bold;">
                <tr>
                    <td class="Title_Blue" width="80" align="center">税抜金額</td>
                    <td class="Value" width="100" align="right">{$form.form_buy_money.html}</b></td>
                    <td class="Title_Blue" width="80" align="center">消費税</td>
                    <td class="Value" width="100" align="right">{$form.form_tax_money.html}</b></td>
                    <td class="Title_Blue" width="80" align="center">伝票合計</td>
                    <td class="Value" width="100" align="right">{$form.form_total_money.html}</b></td>
                </tr>
            </table>
        </td>
        {if $var.warning == null && $var.comp_flg != true}
        <td align="right">{$form.form_sum_button.html}</td>
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
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
		{* 登録確認画面判定 *} 
		{if $var.comp_flg == null}
			{* 以外 *} 
        	<td align="right">{$form.form_buy_button.html}</td>
		{else}
			{* 登録確認画面 *} 
			<td align="right">{$form.comp_button.html}　　{$form.return_button.html}</td>
		{/if}
    </tr>
</table>
        </td>
    </tr>
</table>

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
