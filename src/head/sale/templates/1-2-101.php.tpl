{$var.html_header}
{$var.form_potision}

{* rev.1.2 単価×出荷数合計のJavaScript *}
<script language="javascript">
{$var.html_js}
</script>


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
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_order_no.error != null}
    <li>{$form.form_order_no.error}<br>
{/if}
{if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
{/if}
{if $form.form_designated_date.error != null}
    <li>{$form.form_designated_date.error}<br>
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}<br>
{/if}
{if $form.form_hope_day.error != null}
    <li>{$form.form_hope_day.error}<br>
{/if}
{if $form.form_arr_day.error != null}
    <li>{$form.form_arr_day.error}<br>
{/if}
{if $form.form_ware_select.error != null}
    <li>{$form.form_ware_select.error}<br>
{/if}
{if $form.trade_aord_select.error != null}
    <li>{$form.trade_aord_select.error}<br>
{/if}
{if $form.form_staff_select.error != null}
    <li>{$form.form_staff_select.error}<br>
{/if}
{if $form.form_trans_select.error != null}
    <li>{$form.form_trans_select.error}<br>
{/if}
{if $form.form_note_client.error != null}
    <li>{$form.form_note_client.error}<br>
{/if}
{if $form.form_note_head.error != null}
    <li>{$form.form_note_head.error}<br>
{/if}
{if $form.form_sale_num.error != null}
    <li>{$form.form_sale_num.error}<br>
{/if}
{if $goods_error0 != null}
    <li>{$goods_error0}<br>
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
{if $var.duplicate_err != null}
    <li>{$var.duplicate_err}<br>
{/if}
{foreach from=$duplicate_goods_err key=i item=item}
    <li>{$duplicate_goods_err[$i]}<br>
{/foreach}

{* rev.1.2 分納時出荷予定日、出荷数 *}
{if $var.forward_day_err != null}
    <li>{$var.forward_day_err}<br>
{/if}
{if $var.forward_num_err != null}
    <li>{$var.forward_num_err}<br>
{/if}


</span>

<!-- フリーズ画面判定 -->
{if $var.comp_flg != null}
	<span style="font: bold;"><font size="+1">以下の内容で受注しますか？</font></span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">
		{* フリーズ画面判定 *} 
        {if $var.comp_flg == null && $var.check_flg != true && $smarty.get.aord_id == null}
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,6,1);">得意先</a>
		{else}
            得意先
        {/if}
		<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">出荷可能数</td>
        <td class="Value">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Pink">受注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value">{$form.form_arr_day.html}</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">希望納期</td>
        <td class="Value">{$form.form_hope_day.html}</td>
		{* rev.1.3 直送先テキスト入力 *}
        {* <td class="Title_Pink">直送先</td> *}
        <td class="Title_Pink">
		{* フリーズ画面判定 *} 
        {if $var.comp_flg != true}
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-260.php',Array('form_direct_text[cd]','form_direct_text[name]','form_direct_text[claim]','hdn_direct_search_flg'),500,450,'1-3-207',1);">直送先</a>
		{else}
            直送先
        {/if}
		</td>
        {* <td class="Value">{$form.form_direct_select.html}</td> *}
        <td class="Value">{$form.form_direct_text.cd.html}&nbsp;{$form.form_direct_text.name.html}&nbsp;&nbsp;請求先：{$form.form_direct_text.claim.html}</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.trade_aord_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="5">{$form.form_note_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="5">{$form.form_note_head.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

{if $var.warning != null}<font color="#ff0000"><b>{$var.warning}</b></font>{/if}

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
    <tr class="Result1" align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<font color="#ff0000">※</font><br>商品名<font color="#ff0000">※</font></td>
        <td class="Title_Pink">実棚数<br>(A)</td>
        <td class="Title_Pink">発注済数<br>(B)</td>
        <td class="Title_Pink">引当数<br>(C)</td>
        <td class="Title_Pink">出荷可能数<br>(A+B-C)</td>
		{if $var.edit_flg == "true"}
	        <td class="Title_Pink">受注数<font color="#ff0000">※</font></td>
		{/if}
        <td class="Title_Pink">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
		{if $var.edit_flg != "true"}
	        <td class="Title_Pink">出荷回数<font color="#ff0000">※</font></td>
    	    <td class="Title_Pink">分納時出荷予定日<font color="#ff0000">※</font></td>
        	<td class="Title_Pink">出荷数<font color="#ff0000">※</font></td>
		{/if}
{*
    {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
    {if $var.warning == null && $var.comp_flg == null}
        <td class="Title_Add" width="50">行削除</td>
    {/if}
    </tr>
    {$var.html}
</table>

<table width="100%">
    <tr>
{*チェック処理無効
        {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
        {if $var.warning == null && $var.comp_flg == null}
            <td>{$form.add_row_link.html}</td>
        {/if}
        <td align="right">
            <table class="List_Table" border="1" width="600">
                <tr>
                    <td class="Title_Pink" width="80" align="center"><b>税抜金額</b></td>
                    <td class="Value" align="right">{$form.form_sale_total.html}</td>
                    <td class="Title_Pink" width="80" align="center"><b>消費税</b></td>
                    <td class="Value" align="right">{$form.form_sale_tax.html}</td>
                    <td class="Title_Pink" width="80" align="center"><b>税込合計</b></td>
                    <td class="Value" align="right">{$form.form_sale_money.html}</td>
                </tr>
            </table>
        </td>
{*チェック処理無効
        {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
        {if $var.warning == null && $var.comp_flg == null}
            <td>{$form.form_sum_button.html}</td>
        {/if}
    </tr>
</table>

<A NAME="foot"></A>
<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
		{* 登録確認画面判定 *} 
		{if $var.comp_flg == null}
			<td align="right" colspan="2">
			{* 遷移元判定 *}
{*チェック処理無効
			{if $var.check_flg == true}
*}
				{* 受注照会から遷移 *}
{*
				{$form.complete.html}　　{$form.return_button.html}
			{else}
*}
				{* 受注残から遷移or初期表示 *}
				{$form.order.html}
{*チェック処理無効
			{/if}
*}
        	</td>
		{else}
			{* 登録確認画面 *} 
			<td align="right" colspan="2">{$form.comp_button.html}　　{$form.return_button.html}</td>
		{/if}
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
