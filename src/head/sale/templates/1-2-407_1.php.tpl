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
<input type="button" value="自動引落データ作成" onclick="javascript:location='1-2-309.php'">
<input type="button" value="振替結果アップロード" onclick="javascript:location='1-2-407.php'">
<input type="button" value="振替結果照会" style="color: #ff0000;" onclick="javascript:location='1-2-407_1.php'">
<br><br><br>
<br>
<table class="List_Table" border="1" width="700">
<col width="120" style="font-weight: bold;">
<col width="" >
<col width="120" style="font-weight: bold;">
    <tr align="left">
        <td class="Title_Pink">引落日</td>
        <td class="Value" colspan="3">{$form.f_date_a1.html}　〜　{$form.f_date_a1.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink">請求先コード</td>
        <td class="Value">{$form.f_claim1.html}</td>
        <td class="Title_Pink">請求先名</td>
        <td class="Value"><input type="text"></td>
    </tr>
    <tr align="left">
        <td class="Title_Pink">振替結果</td>
        <td class="Value">
        <select>
          <option value="0"></option>
          <option value="0">振替済</option>
          <option value="1">資金不足</option>
          <option value="2">預金取引なし</option>
          <option value="3">預金者の都合による振替停止</option>
          <option value="4">預金口座振替依頼書なし</option>
          <option value="8">委託者の都合による振替停止</option>
          <option value="9">その他・エラー</option>
        </select>
        </td>
        <td class="Title_Pink">入金状況</td>
        <td class="Value">
        <input type="radio" value="" checked>指定なし
        <input type="radio" value="">入金済
        <input type="radio" value="">未入金
        </td>
    </tr>
</table>
<table width="700">
    <tr>
        <td align="right"><input type="button" value="表　示">　<input type="button" value="クリア"></td>
    </tr>
</table>
<br><br><br>
<table class="List_Table" border="1" width="100%">
<col width="">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Pink" rowspan="2">No.</td>
        <td class="Title_Pink" rowspan="2">引落日</td>
        <td class="Title_Pink" rowspan="2">請求番号</td>
        <td class="Title_Pink" rowspan="2">請求先</td>
        <td class="Title_Pink" colspan="2">引落</td>
        <td class="Title_Pink" colspan="2">振込</td>
        <td class="Title_Pink" rowspan="2">引落金額</td>
        <td class="Title_Pink" rowspan="2">振替結果</td>
        <td class="Title_Pink" rowspan="2">入金済</td>
        <td class="Title_Pink" rowspan="2"><input type="checkbox">入金</td>
    </tr>
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">支店</td>
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">支店</td>
    </tr>
    <tr class="Result1">
        <td class="Value" align="center">1</td>
        <td class="Value" align="center">2006-06-27</td>
        <td class="Value" align="left">00000002</td>
        <td class="Value" align="left">000016-0000<br>アルプス</td>
        <td class="Value" align="left">0001<br>みずほ銀行</td>
        <td class="Value" align="left">357<br>横浜支店</td>
        <td class="Value" align="left">0001<br>みずほ銀行</td>
        <td class="Value" align="left">357<br>横浜支店</td>
        <td class="Value" align="right">10,000</td>
        <td class="Value" align="left">振替済</td>
        <td class="Value" align="center">○</td>
        <td class="Value" align="center"></td>
    </tr>
    <tr class="Result2">
        <td class="Value" align="center">2</td>
        <td class="Value" align="center">2006-06-27</td>
        <td class="Value" align="left">00000001</td>
        <td class="Value" align="left">000017-0000<br>安藤ｽﾎﾟｰﾂ星川店</td>
        <td class="Value" align="left">9900<br>郵便局</td>
        <td class="Value" align="left"><br></td>
        <td class="Value" align="left">0001<br>みずほ銀行</td>
        <td class="Value" align="left">357<br>横浜支店</td>
        <td class="Value" align="right">10,000</td>
        <td class="Value" align="left" width="110">振替済</td>
        <td class="Value" align="center"></td>
        <td class="Value" align="center"><input type="checkbox"></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="right"><input type="button" value="入金入力へ" onclick="javascript:location='1-2-407_2.php'"></td>
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
