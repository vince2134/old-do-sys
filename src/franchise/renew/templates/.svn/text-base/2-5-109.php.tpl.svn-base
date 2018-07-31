{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

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

<table class="Data_Table" border="1" width="500">
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">集計期間</td>
        {* 2009-10-12 aoyama-n*}
        {* <td class="Value">{$html.renew_day} 〜 {$html.end_day}</td> *}
        <td class="Value">{$html.start_day} 〜 {$html.end_day}</td>
    </tr>
    <tr>
        <td class="Title_Green">支店</td>
        <td class="Value">{$form.form_branch.html}</td>
    </tr>
</table>

<table width="500">
    <tr align="right">
        <td>{$form.form_show_button.html}</td>
    </tr>
</table>

{* 2009-10-12 aoyama-n *}
{* <table> *}
{*    <tr> *}
{*        <td style="color: #0000ff; font-weight: bold;"><li>対象となる伝票は、前回月次締日より後の日次更新未実施の伝票です。</li></td> *}
{*    </tr> *}
{* </table> *}

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

<div align="right">{$form.form_return_button.html}</div>
<br>

    {$html.html_d}
    {$html.html_h}
    {*{$html.html_m}*}

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
