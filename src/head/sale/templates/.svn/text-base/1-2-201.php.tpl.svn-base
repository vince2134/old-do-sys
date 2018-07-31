{$var.html_header}
{$var.form_potision}

<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
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
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}<br>
{/if}
{if $form.form_claim_day.error != null}
    <li>{$form.form_claim_day.error}<br>
{/if}
{if $form.form_ware_select.error != null}
    <li>{$form.form_ware_select.error}<br>
{/if}
{if $form.trade_sale_select.error != null}
    <li>{$form.trade_sale_select.error}<br>
{/if}
{if $form.form_staff_select.error != null}
    <li>{$form.form_staff_select.error}<br>
{/if}
{if $form.form_cstaff_select.error != null}
    <li>{$form.form_cstaff_select.error}<br>
{/if}
{if $form.form_trans_select.error != null}
    <li>{$form.form_trans_select.error}<br>
{/if}
{if $var.goods_error0 != null}
    <li>{$var.goods_error0}<br>
{/if}
{if $var.duplicate_err != null}
    <li>{$var.duplicate_err}<br>
{/if}
{if $var.aord_id_err != null}
    <li>{$var.aord_id_err}<br>
{/if}
{if $form.form_note.error != null}
    <li>{$form.form_note.error}<br>
{/if}
{foreach from=$goods_error1 key=i item=item}
{if $goods_error1[$i] != null}
    <li>{$goods_error1[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error2 key=i item=item}
{if $goods_error2[$i] != null}
    <li>{$goods_error2[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error3 key=i item=item}
{if $goods_error3[$i] != null}
    <li>{$goods_error3[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error4 key=i item=item}
{if $goods_error4 != null}
    <li>{$goods_error4[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error5 key=i item=item}
{if $goods_error5[$i] != null}
    <li>{$goods_error5[$i]}<br>
{/if}
{/foreach}
{foreach from=$duplicate_goods_err key=i item=item}
    <li>{$duplicate_goods_err[$i]}<br>
{/foreach}
{if $form.form_sale_money.error != null}
    <li>{$form.form_sale_money.error}<br>
{/if}

</ul>
</span>

<!-- フリーズ画面判定 -->
{if $var.comp_flg != null}
	<span style="font: bold;"><font size="+1">以下の内容で売上ますか？</font></span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="980">
    <tr>
        <td>

{*
<table class="Data_Table" border="1" width="650">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" >{$form.form_sale_no.html}</td>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_ord_no.html}　{$form.form_show_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">
        {* 受注照会、受注残からの遷移判定 *} 
{*        {if $var.aord_id == null || }
            <a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">得意先</a>
        {else}
            得意先
        {/if}
        <font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日</td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value">{$form.form_arrival_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">売上計上日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_sale_day.html}</td>
        <td class="Title_Pink">請求日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_claim_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value">{$form.form_direct_select.html}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" >{$form.trade_sale_select.html}</td>
        <td class="Title_Pink">担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">備考</td>
        <td class="Value" colspan="3">{$form.form_note.html}</td>
    </tr>
</table>
<br>
*}

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" >{$form.form_sale_no.html}</td>
        <td class="Title_Pink">
        {* 受注照会、受注残からの遷移orフリーズ画面判定 *} 
        {if $var.aord_id == null && $var.comp_flg == null}
            <a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,7,1);">得意先</a>
        {else}
            得意先
        {/if}
        <font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_client.html}　{$var.client_state_print}</td>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_ord_no.html}　{$form.form_show_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日</td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Pink">売上計上日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_sale_day.html}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value">{$form.form_arrival_day.html}</td>
        <td class="Title_Pink">請求日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_claim_day.html}</td>
        <td class="Title_Pink">受注担当者</td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" >{$form.trade_sale_select.html}</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">売上担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_cstaff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value" colspan="5">{$form.form_direct_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">メモ</td>
        <td class="Value" colspan="5">{$form.form_note.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
{if $smarty.post.form_sale_btn.html == null}
{if $var.warning != null}<font color="#ff0000"><b>{$var.warning}</b></font><br>{/if}
{/if}
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
{$form.hidden}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<font color="#ff0000">※</font><br>商品名</td>
        {if $var.aord_id != null}
            <td class="Title_Pink">受注数</td>
        {/if}
		<td class="Title_Pink">現在庫数</td>
        <td class="Title_Pink">出荷数<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
        {* 受注照会、受注残から遷移では無いか、得意先が選択された場合追加リンク表示 *} 
        {if $var.warning == null && $var.aord_id == null && $var.comp_flg == null}
            <td class="Title_Add" width="50">行削除</td>
        {/if}
        {$var.html}
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<A NAME="foot"></A>
{if $var.warning == null}
<table width="100%">
    <tr>
    {if $var.warning == null && $var.comp_flg == null}
        <td>{$form.add_row_link.html}</td>
    <td align="right">
    {else}
    <td align="right" colspan="2">
    {/if}
        <table class="List_Table" border="1" width="650">
            <tr>
                <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
                <td class="Value" align="right">{$form.form_sale_total.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
                <td class="Value" align="right">{$form.form_sale_tax.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>税込合計</b></td>
                <td class="Value" align="right">{$form.form_sale_money.html}</td>
            </tr>
        </table>
    </td>
    {if $var.warning == null && $var.comp_flg == null}
    <td align="right">{$form.form_sum_btn.html}</td>
    {/if}
    </tr>
    <tr>
        <td>{if $smarty.post.form_sale_btn.html == null}<font color="#ff0000"><b>※は必須入力です</b></font></td>{/if}
    	{* 登録確認画面判定 *} 
		{if $var.comp_flg == null}
			{* 以外 *} 
        	<td align="right" colspan="2">{$form.form_sale_btn.html}</td>
		{else}
			{* 登録確認画面 *} 
			<td align="right" colspan="2">{$form.comp_button.html}　　{$form.return_button.html}</td>
		{/if}
	</tr>
</table>
{/if}
        </td>
    </tr>
    <tr>
        <td>

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
