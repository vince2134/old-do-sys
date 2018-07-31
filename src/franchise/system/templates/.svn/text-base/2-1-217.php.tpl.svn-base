
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="center">
        {*-------------------- 画面表示開始 -------------------*}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>


{*-------------------- 画面表示1開始 -------------------*}

{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
<table class="Data_Table" border="1" width="450">

    <tr>
        <td class="Title_Purple" width="150"><b>前月買掛残</b></td>
        <td class="Value" width="300"></td>
    </tr>

    <tr>
        <td class="Title_Purple" width="150"><b>現在買掛残</b></td>
        <td class="Value"></td>
    </tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
<col width="75">
<col width="75">
<col width="300">
    <tr>
        <td class="Title_Purple" rowspan="6"><b>当月仕入</b></td>
        <td class="Title_Purple"><b>総仕入</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>返品額</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>値引額</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>純仕入</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>消費税</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>支払額</b></td>
        <td class="Value"></td>
    </tr>

</table>
<br>
<table class="Data_Table" border="1" width="450">

    <tr>
        <td class="Title_Purple" width="150"><b>最新支払日</b></td>
        <td class="Value" width="300"></td>
    </tr>
</table>
<table width='450'>
    <tr>
        <td align='right'>
            {$form.close.html}
        </td>
    </tr>
</table>

{********************* 画面表示2終了 ********************}

                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
    

