{$var.html_header}
<script>
{$var.js}
</script>
<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
    <ul style="margin-left: 16px;">
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
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>{$var.goods_twice}<br>
    </span>
    {/if}
    <span style="font: bold;"><font size="+1">以下の内容で仕入ますか？</font></span><br>
{/if}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>
<table>
    <tr>
        <td>{$form.form_fc_button.html}　{$form.form_client_button.html}</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">伝票番号</td>
        <td class="Value">{$form.form_buy_no.html}</td>
        <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
        <td class="Value" >{$form.form_client.html}　{$var.client_state_print}</td>
        <td class="Title_Blue">発注番号</td>
		<td class="Value">{$form.form_order_no.html}　{$form.form_show_button.html}</td>
    </tr>
    <tr>
		<td class="Title_Blue" width="100"><b>発注日</b></td>
		<td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Blue"><b>入荷日<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_arrival_day.html}</td>
		<td class="Title_Blue"><b>取引区分<font color="red">※</font></b></td>
		<td class="Value">{$form.form_trade.html}</td>
    </tr>
    <tr>
		<td class="Title_Blue" width="100"><b>入荷予定日</b></td>
		<td class="Value">{$form.form_arrival_hope_day.html}</td>
        <td class="Title_Blue">仕入日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_buy_day.html}</td>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value" colspan="3">{$form.form_direct.html}</td>
		<td class="Title_Blue" ><b>発注担当者</b></td>
		<td class="Value">{$form.form_order_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">備考</td>
        <td class="Value" colspan="3">{$form.form_note.html}</td>
		<td class="Title_Blue" ><b>仕入担当者<font color="red">※</font></b></td>
		<td class="Value">{$form.form_buy_staff.html}</td>
    </tr>
</table>
        </td>   
    </tr>   
    <tr>    
        <td>    
{if $smarty.post.form_buy_button == null}
<font color="#ff0000"><b>{$var.warning}</b></font>
{/if}
        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="250">
    <tr align="center" style="font-weight: bold;">
        <td width="120" class="Title_Blue">当月御買上額</td>
        <td class="Value" align="right">{$var.ap_balance}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
{$form.hidden}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
{*
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">現在庫数<br>発注数</td>
        <td class="Title_Blue">入数</td>
        <td class="Title_Blue">仕入入数</td>
        <td class="Title_Blue">仕入済数<br>仕入数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
        <td class="Title_Blue">発注残</td>
*}
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">現在庫数</td>
        <td class="Title_Blue">発注残</td>
        <td class="Title_Blue">ロット仕入</td>
        <td class="Title_Blue">ロット入数</td>
        <td class="Title_Blue">仕入数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
    {if $var.select_flg == true  && $var.freeze_flg != true && $var.order_flg != true}
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
        {if $var.select_flg == true}
            <td>{$form.form_add_row_button.html}</td>
        <td>    
            <table class="List_Table" border="1" align="right">
                <tr>    
                    <td class="Title_Blue" width="80" align="center"><b>税抜金額</b></td> 
                    <td class="Value" width="100" align="right">{$form.form_buy_money.html}</td>
                    <td class="Title_Blue" width="80" align="center"><b>消費税</b></td> 
                    <td class="Value" width="100" align="right">{$form.form_tax_money.html}</td>
                    <td class="Title_Blue" width="80" align="center"><b>税込合計</b></td> 
                    <td class="Value" width="100" align="right">{$form.form_total_money.html}</td>
                </tr>   
            </table>
        </td>   
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
        <td>{if $smarty.post.form_buy_button == null}<font color="#ff0000"><b>※は必須入力です</b></font>{/if}</td>
        <td align="right">{$form.form_buy_button.html}　{$form.form_comp_button.html}　{$form.form_slip_comp_button.html}　{$form.form_back_button.html}</td>
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
