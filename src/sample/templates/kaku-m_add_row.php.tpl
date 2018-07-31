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
{if $var.input_err != null}
    <li>{$var.input_err}<br>
{/if}
{if $var.date_err != null}
    <li>{$var.date_err}<br>
{/if}
{if $var.trade_err != null}
    <li>{$var.trade_err}<br>
{/if}
{if $var.paymon_err != null}
    <li>{$var.paymon_err}<br>
{/if}
{if $var.payfee_err != null}
    <li>{$var.payfee_err}<br>
{/if}

</span>



{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

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
                <td class="Title_Blue" width="">No.</td>
                <td class="Title_Blue" width="300">仕入先<font color="red">※</font></td>
                <td class="Title_Blue" width="155">支払日<font color="red">※</font></td>
                <td class="Title_Blue" width="160">取引区分<font color="red">※</font></td>
                <td class="Title_Blue" width="160">振込銀行</td>
                <td class="Title_Blue" width="120">支払金額<font color="red">※</font></td>
                <td class="Title_Blue" width="120">手数料</td>
                <td class="Title_Blue" width="300">備考</td>
                <td class="Title_Blue" width="">行<br>
                （<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true');">追加</a>）</td>
        </tr>
        {$var.html}
        <tr class="Result2" style="font-weight: bold;">
                <td colspan=2>合計</td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">401,745</td>
                <td align="right">0</td>
                <td></td>
                <td></td>
        </tr>
</table>
        {$form.hidden}

<table width="100%">
        <tr>
                <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
                <td align="right">{$form.money4.html}</td>
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

