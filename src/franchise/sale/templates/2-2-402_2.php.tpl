{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">


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

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<input type="button" value="得意先単位" onclick="javascript:location='2-2-402.php'">
<input type="button" value="銀行単位" style="color: #ff0000;" onclick="javascript:location='2-2-402_2.php'">
<br><br><br>


<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">銀行<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_bank_1.html}　<input type="submit" value="表　示"></td>
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
{* 1行目 *}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">請求番号<font color="#ff0000">※</font></td>
        <td class="Title_Pink">得意先<font color="#ff0000">※</font></td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font><br>手数料</td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <td class="Title_Pink">行削除</td>
    </tr>
    <tr class="Result1">
        <td align="">1</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result1">
        <td align="">2</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result1">
        <td align="">3</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result1">
        <td align="">4</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result1">
        <td align="">5</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="left"><input type="button" value="行追加"></td>
        <td align="right">
            <br>
            <table class="List_Table" border="1" width="">
            <col width="100" style="font-weight: bold;">
            <col>
            <col width="100" style="font-weight: bold;">
                <tr>
                    <td class="Title_Pink">入金合計</td>
                    <td class="Value" align="right"><input type="text" disabled></td>
                    <td class="Title_Pink">内手数料</td>
                    <td class="Value" align="right"><input type="text" disabled> <input type="button" value="合　計"></td>
                </tr>
            </table>
            <br>
        </td>
    </tr>
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><input type="button" value="入金確認画面へ"></td>
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
