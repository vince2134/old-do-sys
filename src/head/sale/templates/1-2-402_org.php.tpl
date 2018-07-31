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
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">入金データ取込</td>
        <td class="Value" colspan="3"><input type="file">　{$form.busy.html}
        </td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行</td>
        <td class="Value" colspan="3">{$form.form_bank_1.html}　　{$form.collective.html}
        </td>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
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
        <td class="Title_Pink">行<br>（<a href="#" title="入力欄を一行追加します">追加</a>）</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td align="right">1</td>
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
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    {* 2行目 *}
    <tr class="Result1">
        <td align="right">2</td>
        <td align="center">{$form.f_date_a3.html}</td>
        <td>{$form.trade_payin_2.html}</td>
        <td>{$form.form_bank_2.html}</td>
        <td>{$form.f_claim2.html}（<a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim2[code1]','f_claim2[code2]','t_claim2'),500,450);">検索</a>）<br>{$form.t_claim2.html}</td>
        <td align="right">100,000</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a4.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    {* 3行目 *}
    <tr class="Result1">
        <td align="right">3</td>
        <td align="center">{$form.f_date_a5.html}</td>
        <td>{$form.trade_payin_3.html}</td>
        <td>{$form.form_bank_3.html}</td>
        <td>{$form.f_claim3.html}（<a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim3[code1]','f_claim3[code2]','t_claim3'),500,450);">検索</a>）<br>{$form.t_claim3.html}</td>
        <td align="right">33,915</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a6.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    {* 4行目 *}
    <tr class="Result1">
        <td align="right">4</td>
        <td align="center">{$form.f_date_a7.html}</td>
        <td>{$form.trade_payin_4.html}</td>
        <td>{$form.form_bank_4.html}</td>
        <td>{$form.f_claim4.html}（<a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim4[code1]','f_claim4[code2]','t_claim4'),500,450);">検索</a>）<br>{$form.t_claim4.html}</td>
        <td align="right">33,915</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a8.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>    
    {* 5行目 *}
    <tr class="Result1">
        <td align="right">5</td>
        <td align="center">{$form.f_date_a9.html}</td>
        <td>{$form.trade_payin_5.html}</td>
        <td>{$form.form_bank_5.html}</td>
        <td>{$form.f_claim5.html}（<a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim5[code1]','f_claim5[code2]','t_claim5'),500,450);">検索</a>）<br>{$form.t_claim5.html}</td>
        <td align="right">100,000</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a10.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    <tr class="Result2" align="center" style="font-weight: bold;">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">401,745</td>
        <td align="right">269,575</td>
        <td align="right">1,050</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>

<table width="100%">
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
