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
{* エラーメッセージ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.form_count_date.error != null}
    <li>{$form.form_count_date.error}<br>
{/if}
</ul>
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
{*
    <tr>
        <td class="Title_Green">出力形式</td>
        <td class="Value">{$form.f_r_output.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Green">集計日</td>
        <td class="Value">{$form.form_count_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">集計期間<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_count_date.html}<br>{$var.info_msg}</td>
    </tr>
    <tr>
        <td class="Title_Green">入力者</td>
        <td class="Value">{$form.form_e_staff_slct.html}</td>
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
<table width="1000">
    <tr>
        <td>

{$var.html}

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
