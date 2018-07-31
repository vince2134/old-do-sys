{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{if $form.err_illegal_post.error != null}
    <li>{$form.err_illegal_post.error}<br>
{/if}
{if $form.err_claim.error != null}
    <li>{$form.err_claim.error}<br>
{/if}
{if $form.form_claim.error != null}
    <li>{$form.form_claim.error}<br>
{/if}
{if $form.form_bill_no.error != null}
    <li>{$form.form_bill_no.error}<br>
{/if}

{if $form.form_payin_day.error != null}
    <li>{$form.form_payin_day.error}<br>
{/if}
{if $form.form_trade.error != null}
    <li>{$form.form_trade.error}<br>
{/if}
{if $form.form_bank.error != null}
    <li>{$form.form_bank.error}<br>
{/if}
{if $form.form_limit_day.error != null}
    <li>{$form.form_limit_day.error}<br>
{/if}
{if $form.err_count.error != null}
    <li>{$form.err_count.error}<br>
{/if}
{foreach from=$form.form_amount item="item" key="key"}
    {if $item.error != null}
        <li>{$item.error}<br>
    {/if}
{/foreach}
{foreach from=$form.form_rebate item="item" key="key"}
    {if $item.error != null}
        <li>{$item.error}<br>
    {/if}
{/foreach}
</ul>
</span>

<span style="color:#000000;font:bold 16px;">
{$form.divide_msg.html}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{if $var.freeze_flg != true && $var.renew_flg != true}
<br>
{$form.402_button.html}　{$form.409_button.html}　{$form.405_button.html}
<br><br><br>
{/if}


<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="left">
        <td  style="font-weight: bold;" class="Title_Pink">
        {if $var.freeze_flg != true && $var.get_flg != true}{$form.form_claim_search.html}<font color="red">※</font></td>{else}
        請求先<font color="red">※</td>{/if}
        <td class="Value" colspan="3">{$form.form_claim.html}　{$var.claim_state_print}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">振込名義１</td>
        <td class="Value" colspan="3">{$form.form_pay_name.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">振込名義２</td>
        <td class="Value" colspan="3">{$form.form_account_name.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" width="100" style="font-weight: bold;">請求番号</td>
        <td class="Value" >{$form.form_bill_no.html}</td>
        <td class="Title_Pink" width="100" style="font-weight: bold;">請求額</td>
        <td class="Value" width="250">{$form.form_bill_amount.html}</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
    <tr align="left">
        <td class="Title_Pink" width="100" style="font-weight: bold;">入金日<font color="red">※</font></td>
        <td class="Value" colspan="3">{$form.form_payin_day.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">取引区分<font color="red">※</font></td>
        <td class="Value">{$form.form_trade.html}</td>
		{* 20090611 集金担当者の追加 *}
		<td class="Title_Pink" style="font-weight: bold;">集金担当者</td>
		<td class="Value">{$form.form_collect_staff.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">銀行</td>
        <td class="Value" colspan="3">{$form.form_bank.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">手形期日</td>
        <td class="Value" width="250">{$form.form_limit_day.html}</td>
        <td class="Title_Pink" width="100" style="font-weight: bold;">手形券面番号</td>
        <td class="Value" width="250">{$form.form_bill_paper_no.html}</td>
    </tr>
</table>
<table width=100%><tr>
<td align="right">
{if $var.freeze_flg == null && $var.renew_flg == null}
    {if $var.get_flg != true}
        {$form.divide_button.html}
    {/if}
    {$form.clear_button.html}
{/if}</td>
</tr></table>
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
{if $var.illegal_post_flg != true && $var.divide_null_flg != true}

{if $var.divide_flg == true || $var.freeze_flg == true || $var.get_flg == true}
<table width="100%">
    <tr>
        <td>
<span style="font-weight:bold;color:#0000ff">※入金額を０円で登録すると請求書や元帳に入金額０円で表示されます。<br>
表示させない場合は空で登録して下さい。</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink" width="30">No.</td>
        <td class="Title_Pink" width="200">得意先コード<br>得意先名</td>
        <td class="Title_Pink" width="90">請求額</td>
        <td class="Title_Pink" width="90">入金額</td>
        <td class="Title_Pink" width="90">手数料</td>
        <td class="Title_Pink" width="180">備考</td>
    </tr>
    {$var.html}
</table>
<br style="font-size: 4px;">

<A NAME="sum">
<table width="100%">
    {* 合計ボタン *}
    {if $var.freeze_flg != true && $var.renew_flg == null}
    <tr>
        <td align="right">{$form.sum_button.html}</td>
    </tr>
    {/if}
    {* 請求額・合計額 *}
    <tr>
        <td align="right">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">入金額合計</td>
                    <td class="Value" align="right" width="100">{$form.form_amount_total.html}</td>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">手数料合計</td>
                    <td class="Value" align="right" width="100">{$form.form_rebate_total.html}</td>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">合計</td>
                    <td class="Value" align="right" width="100">{$form.form_payin_total.html}</td>
                </tr>
            </table>
            <br style="font-size: 4px;">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">請求額</td>
                    <td class="Value" align="right" width="100">{$form.form_bill2_amount.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    {if $var.freeze_flg != true && $var.renew_flg == null}
    <tr height="15">
        <td colspan="3" align="right"><br>{$form.form_verify_btn.html}</td>
    </tr>    
    {elseif $var.divide_flg == true}
    <tr>
        <td colspan=3 align=right>{$form.hdn_ok_button.html}　{$form.back_button.html}</td>
    </tr>    
    {/if}
    {if $var.renew_flg == true && $var.get_flg != null}
    <tr>
        <td colspan=3 align=right>{$form.get_back_btn.html}</td>
    </tr>    
    {/if}
</table>
</A>

        </td>
    </tr>
</table>
{/if}

{/if}
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

