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
{* 実行完了メッセージ *}
{if $var.complete_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>{$var.complete_msg}<br>
    </span><br>
{/if}

{* エラーメッセージ *}
<span style="font: bold; color: #ff0000;">
{if $var.exec_err_mess != null}
    <li>{$var.exec_err_mess}</li><br>
{/if}
{if $var.temp_err_mess != null}
    <li>{$var.temp_err_mess}</li><br>
{/if}
</span><br>

{* インフォメーション *}
<span style="font:bold; color: #555555;">調査中の棚卸調査表を棚卸更新します</span><br>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>棚卸更新を実施すると棚卸差異数が自動的に在庫調整されます。
</span><br><br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">前回更新日付</td>
        <td class="Value">{$var.renew_before}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.jikkou.html}</td>
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
{$form.hidden}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">調査表作成日</td>
        <td class="Title_Green">更新日時</td>
    </tr>
    {foreach from=$page_data key=i item=item}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td align="center">{$item[0]}</td>
        <td align="center">{$item[1]}</td>
    </tr>
    {/foreach}
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
