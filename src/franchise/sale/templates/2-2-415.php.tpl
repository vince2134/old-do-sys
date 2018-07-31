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
        <td>

<table class="Table_Search" border="1" width="400">
    <col width=" 80px" style="font-weight: bold;">
    <tr>
        <td class="Title_Pink">{$form.form_client_link.html}<span class="required">※</span></td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">集計期間<span class="required">※</span></td>
        <td class="Value">{$form.form_count_day.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><span class="required">※は必須入力です</span></td>
        <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
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
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>全<b>{$var.total_count}</b>件</td>
    </tr>
    <tr>
        <td>

<table class="List_Table" width="100%" border="1">
    <col span="5">
    <col span="3" width="90px">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">日付</td>
        <td class="Title_Pink">伝票番号</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">商品名</td>
        <td class="Title_Pink">前受金</td>
        <td class="Title_Pink">前受相殺額</td>
        <td class="Title_Pink">前受金残高</td>
    </tr>
    {$html.html_l}
    {$html.html_g}
</table>

        </td>
    </tr>
    <tr>
        <td>全<b>{$var.total_count}</b>件</td>
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
