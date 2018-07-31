{$var.html_header}

<body bgcolor="#D8D0C8" >
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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_illegal_verify.error != null}
    <li>{$form.err_illegal_verify.error}<br>
{/if}
{if $var.goods_error0 != null}
    <li>{$var.goods_error0}<br>
{/if}
{if $var.goods_error1 != null}
    <li>{$var.goods_error1}<br>
{/if}
{if $var.goods_error2 != null}
    <li>{$var.goods_error2}<br>
{/if}
{if $var.goods_error3 != null}
    <li>{$var.goods_error3}<br>
{/if}
{if $form.form_move_day.error != null}
    <li>{$form.form_move_day.error}<br>
{/if}
</ul>
</span>
{*--------------- メッセージ類 e n d ---------------*}

{* 登録完了メッセージ *} 
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.insert_msg != null}
    <li>{$var.insert_msg}<br>
{/if}
<li>売買に関係ない移動の場合に使用して下さい。
{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow" width="100">移動日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_move_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">移動元倉庫</td>
        <td class="Value">{$form.form_org_move.html}
        {if $var.warning1 != null}
            <font color="#ff0000"><b>{$var.warning1}</b></font>
        {/if}
        </td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">移動先倉庫</td>
        <td class="Value">{$form.form_move.html}
        {if $var.warning2 != null}
            <font color="#ff0000"><b>{$var.warning2}</b></font>
        {/if}
        </td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_set_button.html}　{$form.form_show_button.html}</td>
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

{$form.hidden}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Yellow" colspan="2">移動元</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow" colspan="2">移動先</td>
        <td class="Title_Yellow" rowspan="2">行<br>（{$form.add_row_link.html}）</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">倉庫名<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
        <td class="Title_Yellow">移動数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">倉庫名<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
    </tr>
    {$var.html}
</table>

<A NAME="foot"></A>
<table border="0" width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_move_button.html}</td>
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
