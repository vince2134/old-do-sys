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
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>ショップ名</b></td>
        <td class="Value">アメニティ東陽</td>
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


<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">契約開始日</td>
        <td class="Value">{$form.form_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求日</td>
        <td class="Value">毎月 {$form.form_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>
<br><br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">商品コード<font color="red">※</font></td>
        <td class="Title_Purple">商品名<font color="red">※</font></td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">単価</td>
        <td class="Title_Purple">合計</td>
    </tr>
{foreach from=$disp_data key=i item=insurance}
    <tr class="{$insurance[0]}">
        <td>{$form.form_code[$i].html}</td>
        <td>{$form.form_name[$i].html}</td>
        <td align="right">{$form.form_num[$i].html}</td>
        <td align="right">{$form.form_price[$i].html}</td>
        <td align="right">{$form.form_amount[$i].html}</td>
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_add_button.html}　　{$form.form_back_button.html}</td>
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
