{$var.html_header}

<style TYPE="text/css">
<!--
.required {ldelim}
    font-weight: bold;
    color: #ff0000;
    {rdelim}
-->
</style>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{if $errors != null}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    {foreach from=$errors item=errors}
    <li>{$errors}</li><br>
    {/foreach}
    </ul>
</span>
{/if}

{* 確認メッセージ出力 *}
{$form.confirm_msg.html}
<br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="List_Table" border="1">
<col width="100px" style="font-weight: bold;">
<col width="500px">
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value">{$form.form_advance_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">入金日<span class="required">※</span></td>
        <td class="Value">{$form.form_pay_day.html}</td>
    </tr>
    <tr>
        {* 確認画面時・前受金確定済 *}
        {if $var.freeze_flg == true || $var.fix_flg == true}
        <td class="Title_Pink">得意先<span class="required">※</span></td>
        {* 上記以外 *}
        {else}
        <td class="Title_Pink">{$form.form_client_link.html}<span class="required">※</span></td>
        {/if}
        <td class="Value">{$form.form_client.html}　{$var.client_state_print}</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求先<span class="required">※</span></td>
        <td class="Value">{$form.form_claim.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">金額<span class="required">※</span></td>
        {* 確認画面時・前受金確定済 *}
        {if $var.freeze_flg == true || $var.fix_flg == true}
        {*<td class="Value">{$form.form_amount.html|number_format}</td>*}
        <td class="Value">{$form.form_amount.html}</td>
        {* 上記以外 *}
        {else}
        <td class="Value">{$form.form_amount.html}</td>
        {/if}
    </tr>
    <tr>
        <td class="Title_Pink">銀行</td>
        <td class="Value">{$form.form_bank.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">担当者</td>
        <td class="Value">{$form.form_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">備考</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table border="0" width="100%">
    <tr>
        {* 確認画面時 *}
        {if $var.freeze_flg == true}
        <td align="right">{$form.hdn_ok_button.html}　　{$form.back_button.html}</td>
        {* 前受金確定済 *}
        {elseif $var.fix_flg == true}
        <td align="right">{$form.back_button.html}</td>
        {* 上記以外 *}
        {else}
        <td><span class="required">※は必須入力です</span></td>
        <td align="right">{$form.confirm_button.html}</td>
        {/if}
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
