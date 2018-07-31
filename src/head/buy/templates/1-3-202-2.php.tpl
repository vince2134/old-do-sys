{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="referer" method="post">

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

</form>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<form {$form.attributes}>
<table  class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">出力形式</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">伝票番号</td>
        <td class="Value">{$form.form_slip_no.html}</td>
        <td class="Title_Blue">発注番号</td>
        <td class="Value">{$form.form_ord_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入日</td>
        <td class="Value" colspan="3">{$form.form_buy_day.html}</td>
    </tr>    
    <tr>
        <td class="Title_Blue">仕入先コード</td>
        <td class="Value">{$form.form_buy_name.html}</td>
        <td class="Title_Blue">仕入先名</td>
        <td class="Value">{$form.form_buy_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入金額</td>
        <td class="Value">{$form.form_buy_amount.html}</td>
        <td class="Title_Blue">日次更新</td>
        <td class="Value">{$form.form_renew.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　　{$form.clear_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">仕入先コード<br>仕入先</td>
        <td class="Title_Blue">伝票番号</td>
        <td class="Title_Blue">仕入日</td>
        <td class="Title_Blue">仕入金額</td>
        <td class="Title_Blue">発注番号</td>
        <td class="Title_Blue">日次更新</td>
        <td class="Title_Blue">変更</td>
        <td class="Title_Blue">削除</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>000001<br>仕入先A</td>
        <td><a href="1-3-205.php">00040378</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000001</a></td>
        <td align="center">○</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 2行目 *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>000002<br>仕入先B</td>
        <td><a href="1-3-205.php">00040377</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000002</a></td>
        <td align="center">○</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 3行目 *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>000003<br>仕入先C</td>
        <td><a href="1-3-205.php">00040376</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000003</a></td>
        <td align="center">○</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 4行目 *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>000004<br>仕入先D</td>
        <td><a href="1-3-205.php">00040375</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000004</a></td>
        <td align="center"></td>
        <td align="center"><a href="1-3-201.php" onClick="javascript:dialogue5('変更します。')">変更</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    {* 6行目 *}
    <tr class="Result1">
        <td align="right">5</td>
        <td>000005<br>仕入先E</td>
        <td><a href="1-3-205.php">00040374</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000005</a></td>
        <td align="center"></td>
        <td align="center"><a href="1-3-201.php" onClick="javascript:return(dialogue5('変更します。'))">変更</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</td>
        <td></td>
        <td align="right">5件</td>
        <td></td>
        <td align="right">14,000.00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    {* 12行目 *}
    <tr class="Result4" style="font-weight: bold;">
        <td>総合計</td>
        <td></td>
        <td align="right">20件</td>
        <td></td>
        <td align="right">280,000.00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
