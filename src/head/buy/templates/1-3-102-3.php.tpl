{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="600">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value" colspan="3">7 日後までの発注済数と引当数を考慮する</td>
    </tr>
    <tr>
        <td class="Title_Blue">発注番号</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Blue">発注日</td>
        <td class="Value"></td>
        <td class="Title_Blue">希望納期</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Blue">入荷予定日</td>
        <td class="Value"></td>
        <td class="Title_Blue">運送業者</td>
        <td class="Value">{$form.form_trans_check.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入先</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value"></td>
        <td class="Title_Blue">仕入倉庫</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Blue">取引区分</td>
        <td class="Value"></td>
        <td class="Title_Blue">担当者</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（仕入先宛）</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Blue">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="3"></td>
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
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<br>商品名</td>
        <td class="Title_Blue">実棚数<br>(A)</td>
        <td class="Title_Blue">発注済数<br>(B)</td>
        <td class="Title_Blue">引当数<br>(C)</td>
        <td class="Title_Blue">出荷可能数<br>(A+B-C)</td>
        <td class="Title_Blue">発注数</td>
        <td class="Title_Blue">仕入単価</td>
        <td class="Title_Blue">仕入金額</td>
        <td class="Title_Blue">入荷予定日</td>
        <td class="Title_Blue">発注完了数</td>
        <td class="Title_Blue">理由</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>00000001<br>商品1</td>
        <td align="right">80</td>
        <td align="right">5</td>
        <td align="right">20</td>
        <td align="right">65</td>
        <td align="right">10</td>
        <td align="right">1,200.00</td>
        <td align="right">12,000.00</td>
        <td align="center">2005-04-01</td>
        <td align="right">7</td>
        <td align="center">理由1</td>
    </tr>
    {* 2行目 *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>00000002<br>商品2</td>
        <td align="right">100</td>
        <td align="right">15</td>
        <td align="right">20</td>
        <td align="right">95</td>
        <td align="right">10</td>
        <td align="right">1,200.00</td>
        <td align="right">12,000.00</td>
        <td align="center">2005-04-01</td>
        <td align="right">7</td>
        <td align="center">理由2</td>
    </tr>    
    {* 3行目 *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>00000003<br>商品3</td>
        <td align="right">50</td>
        <td align="right">20</td>
        <td align="right">20</td>
        <td align="right">50</td>
        <td align="right">10</td>
        <td align="right">1,200.00</td>
        <td align="right">12,000.00</td>
        <td align="center">2005-04-01</td>
        <td align="right">7</td>
        <td align="center">理由3</td>
    </tr>    
    {* 4行目 *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>00000004<br>商品4</td>
        <td align="right">70</td>
        <td align="right">10</td>
        <td align="right">20</td>
        <td align="right">60</td>
        <td align="right">10</td>
        <td align="right">1,200.00</td>
        <td align="right">12,000.00</td>
        <td align="center">2005-04-01</td>
        <td align="right">7</td>
        <td align="center">理由4</td>
    </tr>    
    {* 5行目 *}
    <tr class="Result1">
        <td align="right">5</td>
        <td>00000005<br>商品5</td>
        <td align="right">60</td>
        <td align="right">25</td>
        <td align="right">20</td>
        <td align="right">65</td>
        <td align="right">10</td>
        <td align="right">1,200.00</td>
        <td align="right">12,000.00</td>
        <td align="center">2005-04-01</td>
        <td align="right">7</td>
        <td align="center">理由5</td>
    </tr>    
    <tr class="Result2" style="font-weight: bold;">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">60,000.00</td>
        <td></td>
        <td></td>
        <td></td>
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
