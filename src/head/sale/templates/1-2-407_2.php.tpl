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
<br><br>
<table class="List_Table" border="1" width="100%">
<col width="">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">請求番号</td>
        <td class="Title_Pink">請求先</td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">金額</td>
        <td class="Title_Pink">備考</td>
    </tr>
    <tr>
        <td class="Value" align="center">1</td>
        <td class="Value" align="left">00000001</td>
        <td class="Value" align="left">000017-0000<br>安藤ｽﾎﾟｰﾂ星川店</td>
        <td class="Value" align="center">{$form.f_date_a1.html}</td>
        <td class="Value" align="center">振込入金</td>
        <td class="Value" align="center">みずほ銀行</td>
        <td class="Value" align="center">10,000</td>
        <td class="Value" align="center"><input type="text"></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="left">
        <font color="#ff0000"><b>※は必須入力です</b></font>
        </td>
        <td align="right">
        <input type="button" value="入金確認画面へ" onclick="javascript:location='1-2-407_3.php'">
        <input type="button" value="戻　る" onclick="javascript:location='1-2-407_1.php'">
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
