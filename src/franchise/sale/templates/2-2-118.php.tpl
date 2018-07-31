{$var.html_header}

<script language="javascript">
{$var.html_js}
</script>

{* 顧客先が選択判定 *}
{if ($var.comp_flg == null && $var.renew_flg != "true" && $var.done_flg != "true" && $var.slip_del_flg != true && $var.buy_err_mess == null)}
    {if $var.client_id != null && $smarty.session.group_kind == "2"}
    {* 選択された場合、巡回日選択関数呼出し *}
    <body onLoad="tegaki_daiko_checked(); ad_offset_radio_disable();">

    {else}
    {* FCの場合は倉庫名のセットだけ *}
    <body onLoad="ware_name.innerHTML = document.dateForm.elements['hdn_ware_name'].value; ad_offset_radio_disable();">
    {/if}

{else}
    {* 選択されていない *}
    <body >
{/if}

{* {$var.form_potision} *}

<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    {if $var.done_flg == true}
    	<tr align="center" valign="top" height="160">
	{else}
		<tr align="center" valign="top">
	{/if}
        <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{if $var.slip_del_flg == true}
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li>伝票が削除されているため、変更できません。<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right">{$form.ok_button.html}</td>
        </tr>
    </table>
{elseif $var.buy_err_mess != null}
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li>{$var.buy_err_mess}の仕入が本部で日次更新されているため、変更できません。<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right">{$form.ok_button.html}</td>
        </tr>
    </table>
{elseif $var.done_flg == true}
            <table>
                <tr>
                    <td>

    <span style="font: bold;"><font size="+1">予定手書伝票の作成が完了しました。<br><br>
    </font></span>
    <table>
        <tr>
{*
            <td align="left">{$form.ok_button.html}</td><td align="left">{$form.ok_slip_button.html}</td>
        </tr>
        <tr>
            <td align="left">{$form.slip_bill_button.html}</td><td align="left">{$form.ok_slip_bill_button.html}　　　　{$form.return_edit_button.html}</td>
*}
{* 伝票発行ボタンがあったとき
            <td align="left">{$form.ok_button.html}　{$form.ok_slip_button.html}　{$form.slip_copy_button.html}</td>
        </tr>
    </table>
    <table width="400">
        <tr><td colspan="3" width="100%" height="70" align="right" valign="bottom">{$form.return_edit_button.html}</td></tr>
*}
            <td align="left">{$form.ok_button.html}　{$form.slip_copy_button.html}　　　　　　{$form.return_edit_button.html}</td>
        </tr>
    </table>
{else}
<fieldset>
<legend>
    <span style="font: bold 15px; color: #555555;">【伝票番号】： {$form.form_sale_no.html} </span>
</legend>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">

    {* 伝票番号が重複した *}
{*
    {if $var.duplicate_err != null}
        <li>{$var.duplicate_err}<br>
    {/if}
*}
    {* 集計日報IDが重複した *}
{*
    {if $var.daily_slip_error != null}
        <li>{$var.daily_slip_error}<br>
    {/if}
*}
    {* 伝票が売上確定がされているため、変更できません。 *}
    {if $var.slip_renew_mess != null}
        <li>{$var.slip_renew_mess}<br>
    {/if}
    {* 予定巡回日 *}
    {if $form.form_delivery_day.error != null}
        <li>{$form.form_delivery_day.error}<br>
    {/if}
    {* 順路 *}
    {if $form.form_route_load.error != null}
        <li>{$form.form_route_load.error}<br>
    {/if}
    {* 請求日 *}
    {if $form.form_request_day.error != null}
        <li>{$form.form_request_day.error}<br>
    {/if}
    {* 請求日が前回より先かチェック *}
    {if $var.error_msg16 != null}
        <li>{$var.error_msg16}<br>
    {/if}
    {* 得意先 *}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {* 出荷倉庫 *}
    {if $form.form_ware_select.error != null}
        <li>{$form.form_ware_select.error}<br>
    {/if}
    {* 取引区分 *}
    {if $form.trade_aord.error != null}
        <li>{$form.trade_aord.error}<br>
    {/if}
    {* 訂正理由 *}
    {if $form.form_reason.error != null}
        <li>{$form.form_reason.error}<br>
    {/if}
    {* 売上担当者 *}
{*
    {if $form.form_ac_staff_select.error != null}
        <li>{$form.form_ac_staff_select.error}<br>
    {/if}
*}
    {* 巡回担当者未入力 *}
    {if $form.form_c_staff_id1.error != null}
        <li>{$form.form_c_staff_id1.error}<br>
    {/if}
    {if $form.form_c_staff_id2.error != null}
        <li>{$form.form_c_staff_id2.error}<br>
    {/if}
    {if $form.form_c_staff_id3.error != null}
        <li>{$form.form_c_staff_id3.error}<br>
    {/if}
    {if $form.form_c_staff_id4.error != null}
        <li>{$form.form_c_staff_id4.error}<br>
    {/if}
    {* 売上率未入力 *}
    {if $form.form_sale_rate1.error != null && $form.form_c_staff_id1.error == null}
        <li>{$form.form_sale_rate1.error}<br>
    {/if}
    {if $form.form_sale_rate2.error != null}
        <li>{$form.form_sale_rate2.error}<br>
    {/if}
    {if $form.form_sale_rate3.error != null}
        <li>{$form.form_sale_rate3.error}<br>
    {/if}
    {if $form.form_sale_rate4.error != null}
        <li>{$form.form_sale_rate4.error}<br>
    {/if}

    {* 売上率の合計が100%か *}
    {if $var.error_msg != null}
        <li>{$var.error_msg}<br>
    {/if}
    {* 巡回担当者が重複 *}
    {if $var.error_msg2 != null}
        <li>{$var.error_msg2}<br>
    {/if}
    {* 売上率が０以上の数値か *}
    {foreach key=i from=$error_loop_num3 item=items}
        {if $error_msg10[$i] != null}
            <li>{$error_msg10[$i]}<br>
        {/if}
    {/foreach}

    {* 委託先 *}
    {if $form.form_daiko.error != null}
        <li>{$form.form_daiko.error}<br>
    {/if}
    {* 備考*}
    {if $form.form_note.error != null}
        <li>{$form.form_note.error}<br>
    {/if}
    {* 前受相殺額合計が現在の前受金残高より大きい *}
    {if $form.form_ad_offset_total.error != null}
        <li>{$form.form_ad_offset_total.error}<br>
    {/if}
    {* 代行委託料 *}
{*
    {if $form.form_daiko_price.error != null}
        <li>{$form.form_daiko_price.error}<br>
    {/if}
*}
    {if $form.act_div[0].error != null}
        <li>{$form.act_div[0].error}<br>
    {/if}
    {if $form.act_request_rate.error != null}
        <li>{$form.act_request_rate.error}<br>
    {/if}
    {if $form.act_request_price.error != null}
        <li>{$form.act_request_price.error}<br>
    {/if}

    {* 口座単価（得意先） *}
    {if $form.intro_ac_price.error != null}
        <li>{$form.intro_ac_price.error}<br>
    {/if}

    {* 口座率（得意先） *}
    {if $form.intro_ac_rate.error != null}
        <li>{$form.intro_ac_rate.error}<br>
    {/if}

    {* 口座料(固定金額) *}
    {if $form.form_account_price[1].error != null}
        <li>{$form.form_account_price[1].error}<br>
    {/if}
    {if $form.form_account_price[2].error != null}
        <li>{$form.form_account_price[2].error}<br>
    {/if}
    {if $form.form_account_price[3].error != null}
        <li>{$form.form_account_price[3].error}<br>
    {/if}
    {if $form.form_account_price[4].error != null}
        <li>{$form.form_account_price[4].error}<br>
    {/if}
    {if $form.form_account_price[5].error != null}
        <li>{$form.form_account_price[5].error}<br>
    {/if}

    {* 口座料(率) *}
    {if $form.form_account_rate[1].error != null}
        <li>{$form.form_account_rate[1].error}<br>
    {/if}
    {if $form.form_account_rate[2].error != null}
        <li>{$form.form_account_rate[2].error}<br>
    {/if}
    {if $form.form_account_rate[3].error != null}
        <li>{$form.form_account_rate[3].error}<br>
    {/if}
    {if $form.form_account_rate[4].error != null}
        <li>{$form.form_account_rate[4].error}<br>
    {/if}
    {if $form.form_account_rate[5].error != null}
        <li>{$form.form_account_rate[5].error}<br>
    {/if}

    {* サービス・アイテム入力判定 *}
    {if $var.error_msg3 != null}
        <li>{$var.error_msg3}<br>
    {/if}

    {* サービス印字がある場合、サービスIDがあるか判定 *}
    {if $error_msg4[1] != null}
        <li>{$error_msg4[1]}<br>
    {/if}
    {if $error_msg4[2] != null}
        <li>{$error_msg4[2]}<br>
    {/if}
    {if $error_msg4[3] != null}
        <li>{$error_msg4[3]}<br>
    {/if}
    {if $error_msg4[4] != null}
        <li>{$error_msg4[4]}<br>
    {/if}
    {if $error_msg4[5] != null}
        <li>{$error_msg4[5]}<br>
    {/if}

    {* アイテム印字がある場合、アイテムIDがあるか判定 *}
    {if $error_msg5[1] != null}
        <li>{$error_msg5[1]}<br>
    {/if}
    {if $error_msg5[2] != null}
        <li>{$error_msg5[2]}<br>
    {/if}
    {if $error_msg5[3] != null}
        <li>{$error_msg5[3]}<br>
    {/if}
    {if $error_msg5[4] != null}
        <li>{$error_msg5[4]}<br>
    {/if}
    {if $error_msg5[5] != null}
        <li>{$error_msg5[5]}<br>
    {/if}

    {* 販売区分 *}
    {if $form.form_divide[1].error != null}
        <li>{$form.form_divide[1].error}<br>
    {/if}
    {if $form.form_divide[2].error != null}
        <li>{$form.form_divide[2].error}<br>
    {/if}
    {if $form.form_divide[3].error != null}
        <li>{$form.form_divide[3].error}<br>
    {/if}
    {if $form.form_divide[4].error != null}
        <li>{$form.form_divide[4].error}<br>
    {/if}
    {if $form.form_divide[5].error != null}
        <li>{$form.form_divide[5].error}<br>
    {/if}

    {* サービス印字・一式フラグ *}
    {if $form.form_print_flg1[1].error != null}
        <li>{$form.form_print_flg1[1].error}<br>
    {/if}
    {if $form.form_print_flg1[2].error != null}
        <li>{$form.form_print_flg1[2].error}<br>
    {/if}
    {if $form.form_print_flg1[3].error != null}
        <li>{$form.form_print_flg1[3].error}<br>
    {/if}
    {if $form.form_print_flg1[4].error != null}
        <li>{$form.form_print_flg1[4].error}<br>
    {/if}
    {if $form.form_print_flg1[5].error != null}
        <li>{$form.form_print_flg1[5].error}<br>
    {/if}

    {* サービス印字・アイテム印字 *}
    {if $form.form_print_flg2[1].error != null}
        <li>{$form.form_print_flg2[1].error}<br>
    {/if}
    {if $form.form_print_flg2[2].error != null}
        <li>{$form.form_print_flg2[2].error}<br>
    {/if}
    {if $form.form_print_flg2[3].error != null}
        <li>{$form.form_print_flg2[3].error}<br>
    {/if}
    {if $form.form_print_flg2[4].error != null}
        <li>{$form.form_print_flg2[4].error}<br>
    {/if}
    {if $form.form_print_flg2[5].error != null}
        <li>{$form.form_print_flg2[5].error}<br>
    {/if}

    {* 本体印字・本体ID *}
    {if $form.form_print_flg3[1].error != null}
        <li>{$form.form_print_flg3[1].error}<br>
    {/if}
    {if $form.form_print_flg3[2].error != null}
        <li>{$form.form_print_flg3[2].error}<br>
    {/if}
    {if $form.form_print_flg3[3].error != null}
        <li>{$form.form_print_flg3[3].error}<br>
    {/if}
    {if $form.form_print_flg3[4].error != null}
        <li>{$form.form_print_flg3[4].error}<br>
    {/if}
    {if $form.form_print_flg3[5].error != null}
        <li>{$form.form_print_flg3[5].error}<br>
    {/if}

    {* アイテムコード*}
    {foreach key=i from=$error_loop_num1 item=items}
        {if $form.form_goods_cd1[$i].error != null}
            <li>{$form.form_goods_cd1[$i].error}<br>
        {/if}
        {if $form.form_goods_cd3[$i].error != null}
            <li>{$form.form_goods_cd3[$i].error}<br>
        {/if}
        {if $form.form_goods_cd2[$i].error != null}
            <li>{$form.form_goods_cd2[$i].error}<br>
        {/if}
    {/foreach}

    {* 数量・一式*}
    {if $form.form_goods_num1[1].error != null}
        <li>{$form.form_goods_num1[1].error}<br>
    {/if}
    {if $form.form_goods_num1[2].error != null}
        <li>{$form.form_goods_num1[2].error}<br>
    {/if}
    {if $form.form_goods_num1[3].error != null}
        <li>{$form.form_goods_num1[3].error}<br>
    {/if}
    {if $form.form_goods_num1[4].error != null}
        <li>{$form.form_goods_num1[4].error}<br>
    {/if}
    {if $form.form_goods_num1[5].error != null}
        <li>{$form.form_goods_num1[5].error}<br>
    {/if}

    {* 本体数量 *}
    {if $form.form_goods_num2[1].error != null}
        <li>{$form.form_goods_num2[1].error}<br>
    {/if}
    {if $form.form_goods_num2[2].error != null}
        <li>{$form.form_goods_num2[2].error}<br>
    {/if}
    {if $form.form_goods_num2[3].error != null}
        <li>{$form.form_goods_num2[3].error}<br>
    {/if}
    {if $form.form_goods_num2[4].error != null}
        <li>{$form.form_goods_num2[4].error}<br>
    {/if}
    {if $form.form_goods_num2[5].error != null}
        <li>{$form.form_goods_num2[5].error}<br>
    {/if}

    {* 消耗品数量 *}
    {if $form.form_goods_num3[1].error != null}
        <li>{$form.form_goods_num3[1].error}<br>
    {/if}
    {if $form.form_goods_num3[2].error != null}
        <li>{$form.form_goods_num3[2].error}<br>
    {/if}
    {if $form.form_goods_num3[3].error != null}
        <li>{$form.form_goods_num3[3].error}<br>
    {/if}
    {if $form.form_goods_num3[4].error != null}
        <li>{$form.form_goods_num3[4].error}<br>
    {/if}
    {if $form.form_goods_num3[5].error != null}
        <li>{$form.form_goods_num3[5].error}<br>
    {/if}

    {* 営業原価 *}
    {if $form.form_trade_price[1].error != null}
        <li>{$form.form_trade_price[1].error}<br>
    {/if}
    {if $form.form_trade_price[2].error != null}
        <li>{$form.form_trade_price[2].error}<br>
    {/if}
    {if $form.form_trade_price[3].error != null}
        <li>{$form.form_trade_price[3].error}<br>
    {/if}
    {if $form.form_trade_price[4].error != null}
        <li>{$form.form_trade_price[4].error}<br>
    {/if}
    {if $form.form_trade_price[5].error != null}
        <li>{$form.form_trade_price[5].error}<br>
    {/if}

    {* 売上単価 *}
    {if $form.form_sale_price[1].error != null}
        <li>{$form.form_sale_price[1].error}<br>
    {/if}
    {if $form.form_sale_price[2].error != null}
        <li>{$form.form_sale_price[2].error}<br>
    {/if}
    {if $form.form_sale_price[3].error != null}
        <li>{$form.form_sale_price[3].error}<br>
    {/if}
    {if $form.form_sale_price[4].error != null}
        <li>{$form.form_sale_price[4].error}<br>
    {/if}
    {if $form.form_sale_price[5].error != null}
        <li>{$form.form_sale_price[5].error}<br>
    {/if}

    {* サービス・商品 *}
    {if $form.form_serv[1].error != null}
        <li>{$form.form_serv[1].error}<br>
    {/if}
    {if $form.form_serv[2].error != null}
        <li>{$form.form_serv[2].error}<br>
    {/if}
    {if $form.form_serv[3].error != null}
        <li>{$form.form_serv[3].error}<br>
    {/if}
    {if $form.form_serv[4].error != null}
        <li>{$form.form_serv[4].error}<br>
    {/if}
    {if $form.form_serv[5].error != null}
        <li>{$form.form_serv[5].error}<br>
    {/if}

    {* 本体・数量 *}
    {if $form.error_goods_num2[1].error != null}
        <li>{$form.error_goods_num2[1].error}<br>
    {/if}
    {if $form.error_goods_num2[2].error != null}
        <li>{$form.error_goods_num2[2].error}<br>
    {/if}
    {if $form.error_goods_num2[3].error != null}
        <li>{$form.error_goods_num2[3].error}<br>
    {/if}
    {if $form.error_goods_num2[4].error != null}
        <li>{$form.error_goods_num2[4].error}<br>
    {/if}
    {if $form.error_goods_num2[5].error != null}
        <li>{$form.error_goods_num2[5].error}<br>
    {/if}

    {* 消耗品・数量 *}
    {if $form.error_goods_num3[1].error != null}
        <li>{$form.error_goods_num3[1].error}<br>
    {/if}
    {if $form.error_goods_num3[2].error != null}
        <li>{$form.error_goods_num3[2].error}<br>
    {/if}
    {if $form.error_goods_num3[3].error != null}
        <li>{$form.error_goods_num3[3].error}<br>
    {/if}
    {if $form.error_goods_num3[4].error != null}
        <li>{$form.error_goods_num3[4].error}<br>
    {/if}
    {if $form.error_goods_num3[5].error != null}
        <li>{$form.error_goods_num3[5].error}<br>
    {/if}

    {* 商品名必須 *}
    {foreach key=i from=$error_loop_num1 item=items}
        {* アイテム正式 *}
        {if $form.official_goods_name[$i].error != null}
            <li>{$form.official_goods_name[$i].error}<br>
        {/if}
        {* アイテム略称 *}
        {if $form.form_goods_name1[$i].error != null}
            <li>{$form.form_goods_name1[$i].error}<br>
        {/if}
        {* 消耗品 *}
        {if $form.form_goods_name3[$i].error != null}
            <li>{$form.form_goods_name3[$i].error}<br>
        {/if}
        {* 本体商品 *}
        {if $form.form_goods_name2[$i].error != null}
            <li>{$form.form_goods_name2[$i].error}<br>
        {/if}
    {/foreach}

    {* 前受金 *}
    {foreach key=i from=$error_loop_num1 item=items}
        {if $form.form_ad_offset_amount[$i].error != null}
            <li>{$form.form_ad_offset_amount[$i].error}<br>
        {/if}
    {/foreach}

    </ul>
    </span>

    <!-- フリーズ画面判定 -->
    {if $var.comp_flg != null}
        <span style="font: bold;"><font size="+1">以下の内容で予定手書伝票を作成しますか？</font></span><br>
    {/if}

{* エラーがなくて、伝票合計（税込）より前受相殺額合計が大きい場合、警告 *}
{* rev.1.3 予定巡回日2ヶ月以上離れている警告追加 *}
{* {if $var.error_flg != true && $var.ad_total_warn_mess != null} *}
{if $var.error_flg != true && ($var.ad_total_warn_mess != null || $var.warn_lump_change != null)}
<br>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
	{if $var.ad_total_warn_mess != null}
	{$var.ad_total_warn_mess}<br>
	{/if}
	{if $var.warn_lump_change != null}
	{$var.warn_lump_change}<br>
	{/if}
	{$form.form_lump_change_warn.html}<br><br>
	</font>
    </td></tr>
</table>
<br>
{/if}

    {*--------------- メッセージ類 e n d ---------------*}

    {*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
    <table>
        <tr>
            <td>

    <!-- 直営判定 -->
    {if $smarty.session.group_kind == "2" && $var.client_id != NULL}
    <table class="Data_Table" border="1" width="400">
        <tr>
            <td class="Title_Purple" align="center" width="92"><b>代行区分</b></td>
            <td class="Value" width="308">{$form.daiko_check.html}</td>
        </tr>
    </table>
    <br>
    {/if}

<table class="List_Table" border="1">
    <tr align="center">
        <td class="Title_Pink" width=""><b>予定巡回日<font color="red">※</font></b></td>
        <td class="Title_Pink" width=""><b>順路<font color="red">※</font></b></td>
        <td class="Title_Pink" nowrap><b>
        {* フリーズ画面判定 *} 
        {* {if $var.aord_id == null && $var.comp_flg == null && $var.renew_flg != "true"} *}
        {if $var.comp_flg == null && $var.renew_flg != "true"}
            <a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">得意先</a><font color="#ff0000">※</font></td>
        {else}
            得意先<font color="#ff0000">※</font></b></td>
        {/if}
        <td class="Title_Pink" width=""><b>取引区分<font color="red">※</font></b></td>
        <td class="Title_Pink" width=""><b>請求日<font color="red">※</font></b></td>
        <td class="Title_Pink" width=""><b>請求先</b></td>
        <td class="Title_Pink" width=""><b>巡回担当チーム</b></td>
    </tr>

    <tr class="Result1">
        <td align="center" width="150">{$form.form_delivery_day.html}</td>
        <td align="left">{$form.form_route_load.html}</td>
        <td align="left" width="" nowrap>{$form.form_client.cd1.html}&nbsp;-&nbsp;{$form.form_client.cd2.html}　{$var.client_state_print}<br>{$form.form_client.name.html}</td>
        {* <td align="left">{$form.trade_sale_select.html}</td> *}
        <td align="left">{$form.trade_aord.html}</td>
        <td align="center" width="150">{$form.form_request_day.html}</td>
        <td align="left" width="180">{$form.form_claim.html}</td>
        {* <td align="left">{$form.form_ac_staff_select.html}</td> *}
        <td align="left">
            <table >
                <tr>
                    <td><font color="#555555">
                        メイン1<b><font color="#ff0000">※</font></b> {$form.form_c_staff_id1.html}　売上{$form.form_sale_rate1.html}％<br>
                        サブ2　 <b>　</b>{$form.form_c_staff_id2.html}　売上{$form.form_sale_rate2.html}％<br>
                        サブ3　 <b>　</b>{$form.form_c_staff_id3.html}　売上{$form.form_sale_rate3.html}％<br>
                        サブ4　 <b>　</b>{$form.form_c_staff_id4.html}　売上{$form.form_sale_rate4.html}％<br>
                    </font></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>直送先</b></td>
        <td class="Value" width="185" colspan="6">{$form.form_direct_select.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>紹介口座先</b></td>
        <td class="Value" width="185" colspan="3"><nobr>{$var.ac_name}</nobr></td>
        <td class="Title_Purple" width="110"><b>{$form.intro_ac_div[1].label}</b></td>
        <td class="Value" width="185" colspan="2">
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                {if $var.ac_name == "無し"}
                <tr><td>{$form.intro_ac_div[3].html}</td></tr>
                {else}
                <tr><td>{$form.intro_ac_div[0].html}{$form.intro_ac_price.html}円</td><td>　{$form.intro_ac_div[3].html}</td></tr>
                <tr><td>{$form.intro_ac_div[1].html}{$form.intro_ac_rate.html}％</td><td></td></tr>
                <tr><td>{$form.intro_ac_div[2].html}</td><td></td></tr>
                {/if}
            </table>
        </td>
    </tr>

    {if $smarty.session.group_kind == "2" && $var.client_id != NULL}
    <tr>
        <td class="Title_Pink" nowrap><b>
        {* {if $var.aord_id == null && $var.comp_flg == null && $var.renew_flg != "true"} *}
        {if $var.comp_flg == null && $var.renew_flg != "true"}
            {$form.form_daiko_link.html}
        {else}
            {$form.form_daiko_link.label}
        {/if}
        </b></td>
        <td class="Value" colspan="3">{$form.form_daiko.cd1.html}&nbsp;-&nbsp;{$form.form_daiko.cd2.html}<br>{$form.form_daiko.name.html}</td>
        <td class="Title_Pink" nowrap><b>代行委託料</b></td>
        <td class="Value" colspan="2">
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <tr><td>{$form.act_div[0].html}{$form.act_request_price.html}円</td><td>　{$form.act_div[2].html}</td></tr>
                <tr><td>{$form.act_div[1].html}{$form.act_request_rate.html}％</td><td></td></tr>
            </table>
        </td>
    </tr>
    {/if}

    <tr class="Result1">
        <td class="Title_Pink"><b>備考</b></td>
        {* {if $var.new_entry == "true"} *}
        {if $var.aord_id == null}
        <td class="Value" colspan="6">{$form.form_note.html}</td>
        {else}
        <td class="Value" colspan="3">{$form.form_note.html}</td>
        <td class="Title_Pink" ><b>訂正理由<font color="red">※</font></b></td>
        <td class="Value" colspan="2">{$form.form_reason.html}</td>
        {/if}
    </tr>

    <tr class="Result1">
        <td class="Title_Pink"><b>税抜合計<br>消費税</b></td>
        <td class="Value" colspan="3" align="right">{$form.form_sale_total.html}<br>{$form.form_sale_tax.html}</td>
        <td class="Title_Pink" ><b>伝票合計</b></td>
        <td class="Value" colspan="2" align="right">{$form.form_sale_money.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Pink">
            <table width="100%" cellspacing="0" cellpadding="0"><tr>
                <td class="Title_Pink"><b>前受金残高</b></td>
                {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
                <td align="right">{$form.form_ad_sum_btn.html}</td>
                {/if}
            </tr></table>
        </td>
        <td class="Value" colspan="3" align="right">{$form.form_ad_rest_price.html}</td>
        <td class="Title_Pink" ><b>前受相殺額合計</b></td>
        <td class="Value" colspan="2" align="right">{$form.form_ad_offset_total.html}</td>
    </tr>

</table>

    <table width="100%">
        <tr><td>
    {if $var.warning != null}<font color="#ff0000"><b>{$var.warning}</b></font>{/if}
        </td><td align="right">
    {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
        {$form.form_sum_btn.html}
    {/if}
        </td></tr>
    </table>

            </td>
        </tr>
    </table>

            </td>
        </tr>
        <tr>
            <td>

<A NAME="hand">

<table border="0" width="985">
    <tr>
    {* <td align="left"><font size="+0.5" color="#555555"><b>【商品出荷倉庫：{$form.form_ware_select.html}&nbsp;】</b></font></td> *}
    <td align="left"><font size="+0.5" color="#555555"><b>【商品出荷倉庫：{if $var.comp_flg == null}<span id="ware_name">{else}{$smarty.post.hdn_ware_name}{/if}</span>&nbsp;】</b></font></td>
    <td align="left" width="922"><b><font color="blue">
        <li>前受相殺額以外は税抜金額を登録してください。
        <li>「サービス名」「アイテム」にチェックを付けると伝票に印字されます
    </font></b></td>
    </tr>
</table>

    {*--------------- 画面表示１ e n d ---------------*}


    {*+++++++++++++++ 画面表示２ begin +++++++++++++++*}

    <table class="Data_Table" border="1" width="950">
        {* ヘッダ部 *}
        <tr>
            <td class="Title_Purple" rowspan="2"><b>販売区分<font color="#ff0000">※</font></b></td>
            <td class="Title_Purple" rowspan="2"><b>サービス名</b></td>
            <td class="Title_Purple" rowspan="2"><b>アイテム</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <td class="Title_Purple" colspan="2"><b>金額</b></td>
            <td class="Title_Purple" rowspan="2"><b>消耗品</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <td class="Title_Purple" rowspan="2"><b>本体商品</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <!-- ＦＣ側の代行判定 -->
            {if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
                <!-- 通常or直営 -->
                <td class="Title_Purple" rowspan="2"><b>口座料<br>(商品単位)</b></td>
            {else}
                <!-- FC側の代行は口座料なし -->
            {/if}
            <td class="Title_Purple" rowspan="2"><b>前受相殺額</b></td>
            {* <td class="Title_Purple" rowspan="2"><b>内訳</b></td> *}
            {* フリーズ画面ではクリアは出さない *}
            {if $var.freeze_flg != true}
            <td class="Title_Purple" rowspan="2"><b>クリア</b></td>
            {/if}
        </tr>

        <tr>
            <td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></b></td>
            <td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
        </tr>


        {* データ部 *}
        {foreach key=i from=$loop_num item=items}
        {* 2009-09-18 hashimoto-y *}
        {if $toSmarty_discount_flg[$i] === 't'}
            <tr class="Value" style="color: red">
        {else}
            <tr>
        {/if}
            {* 販売区分 *}
            <td class="Value" align="center">{$form.form_divide[$i].html}</td>

            {* サービス *}
            <td class="Value">{$form.form_print_flg1[$i].html}<br>{$form.form_serv[$i].html}</td>

            {* アイテム *}
            <td class="Value">
                {$form.form_goods_cd1[$i].html}{if $var.freeze_flg == false}({$form.form_search1[$i].html}){/if}{$form.form_print_flg2[$i].html}<br>
                {$form.official_goods_name[$i].html}<br>
                {$form.form_goods_name1[$i].html}
            </td>
            {* 一式・数量 *}
            {* 2009-09-18 hashimoto-y *}
            {if $toSmarty_discount_flg[$i] === 't'}
                <td class="Value" align="right">一式{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
            {else}
                <td class="Value" align="right"><font color=#555555>一式</font>{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
            {/if}
            {* 原価、売上 *}
            <td class="Value" align="right">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
            <td class="Value" align="right">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>

            {* 消耗品 *}
            <td class="Value">{$form.form_goods_cd3[$i].html}{if $var.freeze_flg == false}({$form.form_search3[$i].html}){/if}<br>{$form.form_goods_name3[$i].html}</td>
            <td class="Value" align="right">{$form.form_goods_num3[$i].html}</td>

            {* 本体商品 *}
            <td class="Value">{$form.form_goods_cd2[$i].html}{if $var.freeze_flg == false}({$form.form_search2[$i].html}){/if}<br>{$form.form_goods_name2[$i].html}</td>
            <td class="Value" align="right">{$form.form_goods_num2[$i].html}</td>

            {* 紹介料 *}
            <td class="Value">
                <table height="20">
                    {* 2009-09-18 hashimoto-y *}
                    {if $toSmarty_discount_flg[$i] === 't'}
                    <tr style="color: red">
                        <td>{$form.form_aprice_div[$i].html}</td>
                        <td>
                            {$form.form_br.html}<br>
                            {$form.form_account_price[$i].html}円<br>
                            {$form.form_account_rate[$i].html}%
                        </td>
                    {else}
                    <tr>
                        <td><font color="#555555">{$form.form_aprice_div[$i].html}</font></td>
                        <td><font color="#555555">
                            {$form.form_br.html}<br>
                            {$form.form_account_price[$i].html}円<br>
                            {$form.form_account_rate[$i].html}%
                        </font></td>
                    {/if}
                    </tr>
                </table>
            </td>

            {* 前受相殺額 *}
            <td class="Value">
                {* 2009-09-18 hashimoto-y *}
                {if $toSmarty_discount_flg[$i] === 't'}
                    <table cellspacing="0" cellpadding="0">
                        <tr style="color: red"><td>{$form.form_ad_offset_radio[$i][1].html}</td><td></td></tr>
                        <tr style="color: red">
                            <td>{$form.form_ad_offset_radio[$i][2].html}</td>
                            <td>{$form.form_ad_offset_amount[$i].html}</td>
                        </tr>
                    </table>
                {else}
                    <table cellspacing="0" cellpadding="0">
                        <tr><td><font color="#555555">{$form.form_ad_offset_radio[$i][1].html}</font></td><td></td></tr>
                        <tr>
                            <td><font color="#555555">{$form.form_ad_offset_radio[$i][2].html}</font></td>
                            <td><font color="#555555">{$form.form_ad_offset_amount[$i].html}</font></td>
                        </tr>
                    </table>
                {/if}
            </td>

            {if $var.freeze_flg != true}
            <td class="Value" align="center">{$form.clear_line[$i].html}</td>
            {/if}
        </tr>
    {/foreach}

    </table>

            </td>
        </tr>
    </table>

{*
    {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
    <table width="100%">
        <tr><td align="right" colspan="3">{$form.form_sum_btn.html}</td></tr>
    </table>
    {/if}
*}

</fieldset>
{/if}

<A NAME="foot"></A>
{* エラー時、完了画面以外は※を表示 *}
{if $var.slip_del_flg != true && $var.buy_err_mess == null && $var.done_flg != true}
    <table width="100%">
        <tr>
            <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        </tr>
        <tr>
            {* 登録確認画面判定 *} 
            {if $var.renew_flg == "true"}
                {* 日次更新済とかの明細画面 *}
                {* <td align="right" colspan="2">{$form.return_button.html}</td> *}
            {elseif $var.client_id != null && $var.comp_flg == null}
                {* 以外 *} 
                {* <td align="right" colspan="2">{$form.form_sale_btn.html}{if $var.new_entry == "false"}　{$form.form_back_button.html}{/if}</td> *}
				{* rev.1.3 予定巡回日2ヶ月警告の場合、確認画面へボタンを表示しない *}
                <td align="right" colspan="2">
					{if $var.warn_lump_change == null}{$form.form_sale_btn.html}{/if}
					{if $var.new_entry == "false"}　{$form.form_back_button.html}{/if}
				</td>
            {elseif $var.client_id != null && $var.comp_flg == true}
                {* 登録確認画面 *} 
                <td align="right" colspan="2">{$form.comp_button.html}　　{$form.history_back.html}</td>
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
