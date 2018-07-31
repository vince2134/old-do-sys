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


<input type="button" value="請求先単位" style="color: #ff0000;" onclick="javascript:location='1-2-402.php'">
<input type="button" value="得意先単位" onclick="javascript:location='1-2-402_1.php'">
<input type="button" value="銀行単位" onclick="javascript:location='1-2-402_2.php'">
<input type="button" value="ワイドネット" onclick="javascript:location='1-2-402_3.php'">
<br><br><br>
<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Pink">請求番号<font color="#ff0000">※</font></td>
        <td class="Value"><input type="text" ></td>
    </tr>
    <tr>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.f_date_a1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.trade_payin_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">手形期日</td>
        <td class="Value">{$form.f_date_a2.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">手形券面番号</td>
        <td class="Value"><input type="text" size="20" maxlength="10"></td>
    </tr>
</table>
<table width="100%">
    <tr><td align="right"><input type="submit" value="得意先に振分"></td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
注)入金番号は得意先ごとに採番されます
<table width="100%">
    <tr>
        <td>

{* 1行目 *}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink" width="">No.</td>
        <td class="Title_Pink" width="150">得意先</td>
        <td class="Title_Pink" width="">入金日</td>
        <td class="Title_Pink" width="">銀行</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font></td>
        <td class="Title_Pink">手数料</td>
        <td class="Title_Pink">手形期日</td>
        <td class="Title_Pink">手形券面番号</td>
        <td class="Title_Pink">備考</td>
    </tr>
    <tr class="Result1">
        <td>1</td>
        <td >001058-0000<br>  かもんフードサ−ビス</td>
        <td align="center">2006-06-20</td>
        <td>みずほ銀行</td>
        <td>振込入金</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center">{$form.f_text20.html}</td>
    </tr>
    <tr class="Result1">
        <td>2</td>
        <td >001058-0001<br>  海ぶね/花果山</td>
        <td align="center">2006-06-20</td>
        <td>みずほ銀行</td>
        <td>振込入金</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center">{$form.f_text20.html}</td>
</table>
<table width="100%" border="0">
    <tr>
        <td colspan="2" align="right">
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
        <td align="right">{$form.money2.html}</td>
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
