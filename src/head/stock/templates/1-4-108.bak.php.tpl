{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_ware.error != null}
    <li>{$form.form_ware.error}<br>
{/if}
{if $var.goods_err != null}
    <li>{$var.goods_err}<br>
{/if}
{if $var.adjust_num_err != null}
    <li>{$var.adjust_num_err}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Yellow">調整日</td>
        <td class="Value">{$smarty.now|date_format:"%Y-%m-%d"}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}
    </tr>

</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　{$form.form_all_select_button.html}</td>
    <tr>
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

{if $var.ware_name != null}
    <span style="font: bold 15px; color: #555555;">【{$var.ware_name}】</span><br>
{else}
    <span style="font: bold 15px; color: #ff0000;">倉庫を選択してください。</span><br>
{/if}

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">入出区分<br>(<a href="#" onClick="javascript:Button_Submit_1('change_flg', '#', 'true')">全反転</a>)</td>
        <td class="Title_Yellow" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Yellow">調整前</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow">調整後</td>
        <td class="Title_Yellow" rowspan="2">調整理由<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" rowspan="2">行<br>（<a href="#" title="入力欄を一行追加します。" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true')">追加</a>）</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">在庫数<br>(引当数)</td>
        <td class="Title_Yellow">調整数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">在庫数<br>(引当数)</td>
    </tr>
    {$var.html}
    {$form.hidden}
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_adjust_button.html}</td>
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
