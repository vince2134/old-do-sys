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

<table class="Data_Table" border="1" width="500">
    <tr>
        <td class="Title_Green" width="80"><b>集計期間</b></td>
        <td class="Value">{if $var.daily_update_time != null}{$var.daily_update_time}{else}未実施{/if} 〜 {if $var.end_day != null}{$var.end_day}{else}{$var.now}{/if}<br>（最終日次更新日付 〜 {if $var.end_day != null}指定日付{else}現在日付{/if}）</td>
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

<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col width="100">
<col width="100" style="font-weight: bold;">
<col width="100">
    <tr>
        <td class="Title_Green">担当者</td>
        <td class="Value" colspan="3">{$disp_staff_data[1]}</td>
    </tr>
    <tr>
        <td class="Title_Green">【売上合計】</td>
        <td class="Value" align="right"{if $disp_staff_data[2] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[2]|number_format}</td>
        <td class="Title_Green">【入金合計】</td>
        <td class="Value" align="right"{if $disp_staff_data[3] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[3]|number_format}</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
<col width="30">
<col width="100">
<col>
<col width="100">
<col width="100">
<col width="100">
<col width="0">
<col width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">取扱区分</td>
        <td class="Title_Green">販売区分</td>
        <td class="Title_Green">明細件数</td>
        <td class="Title_Green">原価</td>
        <td class="Title_Green">金額</td>
        <td class="Title_Green"></td>
        <td class="Title_Green">金額月次累計</td>
    </tr>
{$var.html}
</table>

<table align="right">
    <tr>
        <td>{$form.form_return_button.html}</td>
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
