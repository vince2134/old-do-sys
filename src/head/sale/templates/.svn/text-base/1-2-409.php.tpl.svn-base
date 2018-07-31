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
{if $form.err_illegal_verify.error != null}
    <li>{$form.err_illegal_verify.error}<br>
{/if}
{if $form.err_noway_forms.error != null}
    <li>{$form.err_noway_forms.error}<br>
{/if}
{foreach from=$form.err_claim1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_claim2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date6 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date3 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date4 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date5 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_trade key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_bank key=j item=err_form}
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
{foreach from=$form.err_rebate key=j item=err_form}
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
</ul>
</span>

{* 得意先が親子関係時のメッセージ *} 
{foreach from=$var.filiation_flg key=j item=err_flg}
{if $err_flg == 1}
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">注）{$j+1}行目　親子関係のある請求先が選択されています。<br></span>
{/if}
{/foreach}

{* 登録確認メッセージ *} 
{if $var.verify_flg == true}
    <span style="font: bold 16px;">以下の内容で入金しますか？</span><br><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

{if $var.verify_flg != true}
<br>
{$form.form_trans_client_btn.html}　{$form.form_trans_bank_btn.html}
<br><br><br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">入金日</td>
        <td class="Value">{$form.form_payin_date_clt_set.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value">{$form.form_trade_clt_set.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行</td>
        <td class="Value">{$form.form_bank_clt_set.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table>
    <tr>
        <td>{$form.form_clt_set_btn.html}</td>
    </tr>
</table>
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
<table width="100%">
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">請求先コード<br>請求先名<font color="#ff0000">※</font><br>振込名義1<br>振込名義2</td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">銀行<font color="#ff0000">{*※*}</font><br>支店<font color="#ff0000">{*※*}</font><br>口座番号<font color="#ff0000">{*※*}</font></td>
        <td class="Title_Pink">請求番号</td>
        <td class="Title_Pink">請求額</td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font><br>手数料</td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        {if $var.verify_flg != true}<td class="Title_Add">行削除</td>{/if}
    </tr>
    {$var.html}
</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td align="left"><A NAME="foot">{$form.form_add_row_btn.html}</A></td>
        {if $var.verify_flg != true}
        <td align="right">{$form.form_calc_btn.html}</td>
        {/if}
    </tr>
    <tr>
        <td colspan="2" align="right">
            <table class="List_Table" border="1">
            <col width="80" align="center" style="font-weight: bold;">
            <col>
            <col width="80" align="center" style="font-weight: bold;">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">入金額合計</td>
                    <td class="Value" align="right" width="100">{$form.form_amount_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">手数料合計</td>
                    <td class="Value" align="right" width="100">{$form.form_rebate_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">合計</td>
                    <td class="Value" align="right" width="100">{$form.form_payin_total.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            {if $var.verify_flg != true}<font color="#ff0000"><b>※は必須入力です</b></font>{/if}
        </td>
        <td colspan="2" align="right">
            {* 入力画面 *}
            {if $var.verify_flg != true}
            {$form.form_verify_btn.html}
            {* 入力後の確認画面 *}
            {elseif $var.verify_flg == true}
            {$form.hdn_form_ok_btn.html}　{$form.form_return_btn.html}
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
