{$var.html_header}

<script language="javascript">
{$var.code_value}
</script>

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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_value != null}<li>{$var.error_value}<br>{/if}
{if $form.g_name.error != null}<li>{$form.g_name.error}<br>{/if}
{if $form.note.error != null}<li>{$form.note.error}<br>{/if}
</span>
<br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">グループ名</td>
        <td class="Value">{$form.g_select.html}　{$form.button.display.html}　　{$form.button.delete.html}</td>
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

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">グループ名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.g_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">コメント<font color="#ff0000">※</font></td>
        <td class="Value">{$form.note.html}</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">行<br>（<a href="#" title="入力欄を一行追加します。" onClick="javascript:insert_row('insert_row_flg')">追加</a>）</td>
    </tr>
    {$var.html_row}
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.button.touroku.html}</td>
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
