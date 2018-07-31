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


{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">前月買掛残</td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple">現在買掛残</td>
        <td class="Value"></td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col width="57" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" rowspan="6">当月仕入</td>
        <td class="Title_Purple">総仕入</td>
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
        <td class="Title_Purple">純仕入</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">消費税</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">支払額</td>
        <td class="Value"></td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">最新支払日</td>
        <td class="Value"></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_close_button.html}</td>
    </tr>
</table>

{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
        {*--------------- コンテンツ部 e n d ---------------*}

    </tr>
</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
    

