{$var.html_header}
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
{* エラーメッセージ出力 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{$var.err_msg}
</span>
<span style="color: #000000; font-weight: bold; line-height: 130%;">
{$var.ar_fin_msg}
{$var.bill_fin_msg}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table><tr><td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップＩＤ</td>
        <td class="Value">{$form.form_shop_id.html}</td>
        <td class="Title_Purple">クライアントＩＤ</td>
        <td class="Value">{$form.form_client_id.html}</td>
    </tr>
        <td class="Title_Purple">登録日</td>
        <td class="Value">{$form.form_monthly_close_day_this.html}</td>
        <td class="Title_Purple">売掛残高</td>
        <td class="Value">{$form.form_ar_balance.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">スタッフ名</td>
        <td class="Value">{$form.form_staff_name.html}</td>
        <td class="Title_Purple">請求初期設定</td>
        <td class="Value">{$form.form_bill_chk.html}</td>
    </tr>

</table>
{if $var.exit_flg != true}
{$var.btn_push}
{$form.exe_btn.html}
{/if}
<br>
</td></tr></table>
<br>
{$form.update_btn.html}
{$form.reset.html}
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
    {$form.hidden}
<table width="100%">
        <tr>
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

