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
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">出力形式</td>
        <td class="Value" colspan="3">{$form.f_r_output.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引年月<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.f_date_c1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">ショップコード</td>
        <td class="Value">{$form.f_code_a1.html}</td>
        <td class="Title_Pink">ショップ名</td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.hyouji16.html}　　{$form.kuria.html}</td>
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

<span style="font: bold 15px; color: #555555;">【取引年月：2006-01】</span><br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">ショップ名</td>
        <td class="Title_Pink">レンタル先</td>
        <td class="Title_Pink">商品名</td>
        <td class="Title_Pink">レンタル料</td>
        <td class="Title_Pink">レンタル数</td>
        <td class="Title_Pink">レンタル額</td>
        <td class="Title_Pink">備考</td>
    </tr>
    <tr class="Result1">
        <td align="right" rowspan="11">1</td>
        <td rowspan="11">FC1</td>
        <td align="center" rowspan="4">得意先A</td>
        <td>商品A</td>
        <td align="right">100</td>
        <td align="right">1</td>
        <td align="right">100</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品B</td>
        <td align="right">200</td>
        <td align="right">2</td>
        <td align="right">400</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品C</td>
        <td align="right">300</td>
        <td align="right">3</td>
        <td align="right">900</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品D</td>
        <td align="right">400</td>
        <td align="right">4</td>
        <td align="right">1,600</td>
        <td align="right"></td>
    </tr>
    <tr class="Result2" style="font-weight: bold;">
        <td>小計</td>
        <td>4種類</td>
        <td align="right">1,000</td>
        <td align="right">10</td>
        <td align="right">3,000</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td align="center" rowspan="5">得意先B</td>
        <td>商品A</td>
        <td align="right">500</td>
        <td align="right">5</td>
        <td align="right">2,500</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品C</td>
        <td align="right">600</td>
        <td align="right">6</td>
        <td align="right">3,600</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品F</td>
        <td align="right">700</td>
        <td align="right">7</td>
        <td align="right">4,900</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品G</td>
        <td align="right">800</td>
        <td align="right">8</td>
        <td align="right">6,400</td>
        <td align="right"></td>
    </tr>
    <tr class="Result1">
        <td>商品J</td>
        <td align="right">900</td>
        <td align="right">9</td>
        <td align="right">8,100</td>
        <td align="right"></td>
    </tr>
    <tr class="Result2" style="font-weight: bold;">
        <td>小計</td>
        <td>5種類</td>
        <td align="right">3,500</td>
        <td align="right">35</td>
        <td align="right">25,500</td>
        <td align="right"></td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</td>
        <td>10社</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">4,500</td>
        <td align="right">45</td>
        <td align="right">28,500</td>
        <td align="right"></td>
    </tr>
</table>
{$var.html_page2}

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
