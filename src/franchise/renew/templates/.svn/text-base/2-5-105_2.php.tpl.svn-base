{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table height="90%" class="M_Table">

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
{* エラーメッセージ *}
    {if $form.form_end_day.error != null}
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>{$form.form_end_day.error}<br>
        </span>
    {/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">出力形式</td>
        <td class="Value" colspan="3">{$form.form_output_radio.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">集計期間</td>
        <td class="Value">{$var.update_time} 〜 {$form.form_end_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">担当者</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td>{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
    </tr>
    <tr>
        <td style="color: #0000ff; font-weight: bold;"><li>対象となる伝票は、前回月次締日より後の日次更新未実施の伝票です。</li></td>
    </tr>
</table>

        </tr>
    </td>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">【売上・入金】</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">担当者名</td>
        <td colspan="8" class="Title_Green">日次累計</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">月次累計</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">現金<br>売上</td>
        <td class="Title_Green">掛<br>売上</td>
        <td class="Title_Green">売上<br>合計</td>
        <td class="Title_Green">現金<br>入金</td>
        <td class="Title_Green">振込<br>入金</td>
        <td class="Title_Green">入金<br>手数料</td>
        <td class="Title_Green">入金<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
        <td class="Title_Green">現金<br>売上</td>
        <td class="Title_Green">掛<br>売上</td>
        <td class="Title_Green">売上<br>合計</td>
        <td class="Title_Green">現金<br>入金</td>
        <td class="Title_Green">振込<br>入金</td>
        <td class="Title_Green">入金<br>手数料</td>
        <td class="Title_Green">入金<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
    </tr>
    {$var.html_1}
</table>
<br><br>

<span style="font: bold 15px; color: #555555;">【仕入・支払】</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">担当者名</td>
        <td colspan="8" class="Title_Green">日次累計</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">月次累計</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">現金<br>仕入</td>
        <td class="Title_Green">掛<br>仕入</td>
        <td class="Title_Green">仕入<br>合計</td>
        <td class="Title_Green">現金<br>支払</td>
        <td class="Title_Green">振込<br>支払</td>
        <td class="Title_Green">支払<br>手数料</td>
        <td class="Title_Green">支払<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
        <td class="Title_Green">現金<br>仕入</td>
        <td class="Title_Green">掛<br>仕入</td>
        <td class="Title_Green">仕入<br>合計</td>
        <td class="Title_Green">現金<br>支払</td>
        <td class="Title_Green">振込<br>支払</td>
        <td class="Title_Green">支払<br>手数料</td>
        <td class="Title_Green">支払<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
    </tr>
    {$var.html_2}
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
