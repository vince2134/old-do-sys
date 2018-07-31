{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

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

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">入金番号</td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">請求先<font color="#ff0000">※</font></td>
        <td class="Title_Pink">請求額</td>
        <td class="Title_Pink">入金額<font color="#ff0000">※</font></td>
        <td class="Title_Pink">手数料</td>
        <td class="Title_Pink">差異</td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td>10000001</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td>{$form.form_bank_1.html}</td>
        <td>{$form.f_claim1.html}（<a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim1[code1]','f_claim1[code2]','t_claim1'),500,450);">検索</a>）<br>{$form.t_claim1.html}</td>
        <td align="right">100,000</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a2.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.f_change1.html}　　{$form.modoru.html}</td>
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
