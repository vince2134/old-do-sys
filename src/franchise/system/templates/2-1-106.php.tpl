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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
<col width="60" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">前回請求額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">今回請求額</td>
        <td class="Title_Purple">入金額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">調整額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">売上額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">消費税</td>
        <td class="Value"></td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="153" style="font-weight: bold;">
<col width="*">
    <tr>
        <td class="Title_Purple">前月売掛残</td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple">現在売掛残</td>
        <td class="Value"></td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold">
<col width="60" style="font-weight: bold">
<col width="*">
    <tr>
        <td class="Title_Purple" rowspan="7">当月実績</td>
        <td class="Title_Purple">総売上</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">返品額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">値引額</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">純売上</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">消費税</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">粗利益</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">入金額</td>
        <td class="Value"></td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
    <tr>
        <td class="Title_Purple" width="153"><b>最新売上日</b></td>
        <td class="Value"></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.close.html}</td>
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
