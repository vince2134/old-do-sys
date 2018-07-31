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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul>
{if $form.form_ware.error != null}
    <li>{$form.form_ware.error}<br>
{/if}
{if $var.goods_err != null}
    <li>{$var.goods_err}<br>
{/if}
{if $var.adjust_num_err != null}
    <li>{$var.adjust_num_err}<br>
{/if}
{if $var.adjust_reason_err != null}
    <li>{$var.adjust_reason_err}<br>
{/if}
{if $var.adjust_day_err != null}
    <li>{$var.adjust_day_err}<br>
{/if}
{if $var.goods_input_err != null}
    <li>{$var.goods_input_err}<br>
{/if}
</ul>
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Yellow">調整日<font color="#ff0000">※</font></td>
        <!-- <td class="Value">{$smarty.now|date_format:"%Y-%m-%d"}</td> -->
        <td class="Value" colspan="3">{$form.form_adjust_day.html} の最終在庫を調整する</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware.html}</td>
        <td class="Title_Yellow"><b>状態</b></td>
        <td class="Value">{$form.form_type.html}</td>
    </tr>

</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}{*　{$form.form_all_select_button.html}*}　{$form.mst_goods_button.html}</td>
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
    <span style="font: bold 15px; color: #555555;">【{$var.ware_name}】</span>　　
    <span style="font: bold 14px; color: #0000ff;">調整した後は必ず一番下までスクロールして「実施」ボタンで処理を確定して下さい。</span><br>
{else}
    <span style="font: bold 15px; color: #0000ff;">倉庫を選択してください。</span><br>
{/if}


{if $var.ware_name != null}
<table class="List_Table" border="1" width="850">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">入出区分<br>(<a href="#" onClick="javascript:Button_Submit_1('change_flg', '#', 'true')">全反転</a>)</td>
        <td class="Title_Yellow" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Yellow">調整前</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow">調整後</td>
        <td class="Title_Yellow" rowspan="2">調整理由<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" rowspan="2">調整実施<br>ボタンへ</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">在庫数<br><span style="color: #0000ff;">引当数</span></td>
        <td class="Title_Yellow">調整数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">在庫数<br><span style="color: #0000ff;">引当数</span></td>
    </tr>
    {$var.html}
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_adjust_button.html}<br></td>
    </tr>
    <tr>
        <td colspan="2" align="left">{$form.add_row_button.html}</td>
    </tr>

</table>
{/if}
        </td>
    </tr>
</table>
    {$form.hidden}
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
