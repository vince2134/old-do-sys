{$var.html_header}

<script language="javascript">
<!--
{$html.js}
-->
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *}
{if $errors != null}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    {foreach from=$errors item=errors}
    <li>{$errors}</li><br>
    {/foreach}
    </ul>
</span>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>{$html.html_page}</td>
    </tr>
    <tr>
        <td>

<table class="List_Table" width="100%" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_payin_day"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_input_day"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_staff"}</td>
        <td class="Title_Pink">金額</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_name"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_name"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_deposit_kind"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_account_no"}<br>
        </td>
        <td class="Title_Pink">削除</td>
        <td class="Title_Pink">{$form.form_fix_all.html}</td>
    </tr>
    {$html.html_l}
    <tr class="Result3">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"{if $var.sum_amount < 0} style="color: #ff0000;"{/if}>{$var.sum_amount|number_format}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">{$form.form_fix_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>{$html.html_page2}</td>
    </tr>
</table>

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
