{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">請求先コード</td>
        <td class="Value">{$form.form_claim_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先名</td>
        <td class="Value">{$form.form_claim_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC区分</td>
        <td class="Value">{$form.form_fc_kubun_radio.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">請求先コード</td>
        <td class="Title_Purple">請求先名</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td align="right">1</td>
        <td><a href="#" onClick="returnValue=Array('000001','0001','請求先A');window.close();">000001-0001</a></td>
        <td>請求先A</td>
    </tr>
    {* 2行目 *}
    <tr class="Result1">
        <td align="right">2</td>
        <td><a href="#" onClick="returnValue=Array('000002','0002','請求先B');window.close();">000002-0002</a></td>
        <td>請求先B</td>
    </tr>
    {* 3行目 *}
    <tr class="Result1">
        <td align="right">3</td>
        <td><a href="#" onClick="returnValue=Array('000003','0003','請求先C');window.close();">000003-0003</a></td>
        <td>請求先C</td>
    </tr>
    {* 4行目 *}
    <tr class="Result1">
        <td align="right">4</td>
        <td><a href="#" onClick="returnValue=Array('000004','0004','請求先D');window.close();">000004-0004</a></td>
        <td>請求先D</td>
    </tr>
    {* 5行目 *}
    <tr class="Result1">
        <td align="right">5</td>
        <td><a href="#" onClick="returnValue=Array('000005','0005','請求先E');window.close();">000005-0005</a></td>
        <td>請求先E</td>
    </tr>
</table>
{$var.html_page2}

<table align="right">
    <tr>
        <td>{$form.form_close_button.html}</td>
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
