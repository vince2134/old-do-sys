{$var.html_header}

<script language="javascript">
{$var.js_sheet}
</script>

<body bgcolor="#D8D0C8" {if $var.verify_flg != true && $var.verify_only_flg != true && $var.group_kind == "2"}onLoad="Staff_Select(); Act_Select();"{/if}>
<form {$form.attributes}>
{$form.hidden}

</script>

<table width="100%" height="90%" class="M_table">


    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>

    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_illegal_verify.error != null}
    <li>{$form.err_illegal_verify.error}<br>
{/if}
{if $form.form_payin_date.error != null}
    <li>{$form.form_payin_date.error}<br>
{/if}
{if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
{/if}
{if $form.form_collect_staff.error != null}
    <li>{$form.form_collect_staff.error}<br>
{/if}
{if $form.form_act_client.error != null}
    <li>{$form.form_act_client.error}<br>
{/if}
{if $form.form_claim_select.error != null}
    <li>{$form.form_claim_select.error}<br>
{/if}
{if $form.form_bill_no.error != null}
    <li>{$form.form_bill_no.error}<br>
{/if}
{if $form.err_noway_forms.error != null}
    <li>{$form.err_noway_forms.error}<br>
{/if}
{if $form.err_plural_rebate.error != null}
    <li>{$form.err_plural_rebate.error}<br>
{/if}
{if $form.err_act_trade.error != null}
    <li>{$form.err_act_trade.error}<br>
{/if}
{foreach from=$form.err_trade1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_amount1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_amount2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_bank1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_bank2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date3 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{if $var.duplicate_err_msg != null}
    <li>{$var.duplicate_err_msg}<br>
{/if}
{if $var.just_daily_update_flg == true}
    <li>日次更新処理が行われているため、変更できません。<br>
{/if}
</ul>
</span>

{* 得意先が親子関係時のメッセージ *}
{if $var.filiation_flg == true}
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">注）親子関係のある得意先が選択されています。<br></span>
{/if}

{* 登録確認メッセージ *}
{if $var.verify_flg == true && $var.verify_only_flg != true && $var.just_daily_update_flg != true}
    <span style="font: bold 16px;">以下の内容で入金しますか？</span><br><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

{if $var.verify_flg != true && $var.verify_only_flg != true}
<br>
{$form.form_trans_client_btn.html}　{$form.form_trans_bank_btn.html}　{$form.405_button.html}
<br><br><br>
{/if}

<table class="List_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col width="220">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">入金番号</td>
        <td class="Value">{$form.form_payin_no.html}</style></td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_payin_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" valign="bottom">
            {if $var.verify_flg != true && $var.verify_only_flg != true}<a href="#" onClick="return Open_SubWin('../dialog/2-0-402.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">得意先</a>{else}得意先{/if}<font color="#ff0000">※</font><br><br style="font-size: 8px;">銀行<br>支店<br>口座</td>
        <td class="Value" colspan="3">{$form.form_client.html}　{$var.client_state_print}<br><br style="font-size: 5px;">{$form.form_c_bank.html}<br>{$form.form_c_b_bank.html}<br>{$form.form_c_account.html}<br></td>
    </tr>
    <tr>
        <td class="Title_Pink">集金担当者</td>
        <td class="Value"{if $var.group_kind != "2"} colspan="3"{/if}>{$form.form_collect_staff.html}</td>
        {if $var.group_kind == "2"}
        <td class="Title_Pink">
            {if $var.verify_flg != true && $var.verify_only_flg != true}
{*
            <a href="#" onClick="return Open_SubWin('../dialog/2-0-251.php',Array('form_act_client[cd1]','form_act_client[cd2]','form_act_client[name]','act_client_search_flg'),500,450,5,'daiko');">代行店集金</a>
*}
            <div id="link_str"></div>
            {else}
            代行店集金
            {/if}
        </td>
        <td class="Value">{$form.form_act_client.html}</td>
        {/if}
    <tr>
        <td class="Title_Pink" valign="bottom">請求先<span style="color: #ff0000;">※</span><br><br style="font-size: 8px;">振込名義1<br>振込名義2</td>
        <td class="Value">{$form.form_claim_select.html}<br><br style="font-size: 5px;"><div id="pay_account_name">{$var.pay_account_name}</div></td>
        <td class="Title_Pink">請求番号<br>請求額</td>
        <td class="Value">{$form.billbill.html}<div id="bill_no_amount">{$var.bill_no_amount}</div></td>
    </tr>
</table>

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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font></td>
        <td class="Title_Pink">銀行<br>支店<br>口座番号</td>
        <td class="Title_Pink">手形期日</td>
        <td class="Title_Pink">手形券面番号</td>
        <td class="Title_Pink">備考</td>
        {if $var.verify_flg != true && $var.verify_only_flg != true}<td class="Title_Add">行削除</td>{/if}
    </tr>
    {$var.html}
</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td><A NAME="foot">{$form.form_add_row_btn.html}</A></td>
        {if $var.verify_flg != true && $var.verify_only_flg != true}
        <td align="right"><A NAME="sum">{$form.form_calc_btn.html}</A></td>
        {/if}
    </tr>
    <tr align="right">
        <td colspan="2">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">入金合計</td>
                    <td class="Value" align="right" width="100">{$form.form_amount_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">手数料合計</td>
                    <td class="Value" align="right" width="100">{$form.form_rebate_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">合計</td>
                    <td class="Value" align="right" width="100">{$form.form_payin_total.html}</td>
                </tr>
            </table>
            <br style="font-size: 4px;">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">請求額</td>
                    <td class="Value" align="right" width="100"><div id="bill_amount">{$var.bill_amount}</div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            {if $var.verify_flg != true && $var.verify_only_flg != true}<font color="#ff0000"><b>※は必須入力です</b></font>{/if}
        </td>
        <td colspan="2" align="right">
            {* 入力画面 *}
            {if $var.verify_flg != true && $var.verify_only_flg != true}
            {$form.form_verify_btn.html}
            {* 入力後の確認画面 *}
            {elseif $var.verify_flg == true && $var.verify_only_flg != true}
            {$form.hdn_form_ok_btn.html}　{$form.form_return_btn.html}
            {* 日次更新後または売上IDがあるデータの確認画面 *}
            {elseif $var.verify_flg != true && $var.verify_only_flg == true}
            {$form.form_return_btn.html}
            {/if}
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
