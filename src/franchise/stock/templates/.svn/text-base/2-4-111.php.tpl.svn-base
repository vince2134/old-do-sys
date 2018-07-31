{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_handling_day.error != null}
        <li>{$form.form_handling_day.error}<br>{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">取扱期間<b><font color="#ff0000">※</font></b></td>
        <td class="Value" colspan="3">{$form.form_handling_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>
    {*本社の場合のみ表示*}
    {if $smarty.session.shop_div == '1'}
    <tr>
        <td class="Title_Yellow">事業所</td>
        <td class="Value" colspan="3">{$form.form_shop.html}</td>
    </tr>
    {/if}
    <tr>
        <td class="Title_Yellow">調整理由</td>
        <td class="Value" colspan="3">{$form.form_reason.html}</td>
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
{if $var.show_flg == true}
<table width="100%">
    <tr>
        <td>

<span style="font: bold 14px; color: #555555;">【取扱期間：
{if $form.form_handling_day.error == null && ($var.hand_start != NULL || $var.hand_end != NULL)}
    {$var.hand_start} 〜 {$var.hand_end}
{else}
    指定無し
{/if}
{if $smarty.session.shop_div == '1'}
　事業所：{$var.cshop_name}
{/if}
】</span>
<br>
全<b>{$var.match_count}</b>件<br>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">日付</td>
        <td class="Title_Yellow">商品コード<br>商品名</td>
        <td class="Title_Yellow">調整数</td>
        <td class="Title_Yellow">調整額</td>
        <td class="Title_Yellow">調整理由</td>
    </tr>
    {foreach from=$row_data key=i item=item}
    <tr class="{$item[0]}">
        <td align="right">{$item[1]}</td>
        <td>{$item[2]}</td>
        <td align="center">{$item[3]}</td>
        <td>{$item[4]}<br>{$item[5]}</td>
        <td align="right"{if $item[6] == "minus"} style="color: #ff0000;"{/if}>{$item[7]}</td>
        <td align="right"{if $item[6] == "minus"} style="color: #ff0000;"{/if}>{$item[8]}</td>
        <td>{$item[9]}</td>
    </tr>   
    {/foreach}
</table>

        </td>
    </tr>
</table>
{/if}
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
