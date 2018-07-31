{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}    

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
{* エラーメッセージ出力 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.order_err1.error != null}
    <li>{$form.order_err1.error}<br>
{/if}
{if $form.order_err2.error != null}
    <li>{$form.order_err2.error}<br>
{/if}
{if $form.form_designated_date.error != null}
    <li>{$form.form_designated_date.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="550">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value" colspan="3">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
    </tr>
    <tr>
        <td class="Title_Blue">対象商品</td>
        <td class="Value" colspan="3">{$form.form_target_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入先コード</td>
        <td class="Value">{$form.form_supplier_cd.html}</td>
        <td class="Title_Blue">主な仕入先</td>
        <td class="Value">{$form.form_supplier_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">Ｍ区分</td>
        <td class="Value" colspan="3">{$form.form_g_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">商品コード</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Blue">商品名</td>
        <td class="Value">{$form.form_goods_name.html}</td>
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
{if $var.display_flg == true}
{if $var.err_flg != true}
<table width="100%">
    <tr>
        <td>

<table width=$width>
    <tr>
        <td>全<b>{$var.match_count}</b>件</td>
    </tr>
</table>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">主な仕入先</td>
        <td class="Title_Blue">Ｍ区分</td>
        <td class="Title_Blue">商品コード<br>商品名</td>
        <td class="Title_Blue">仕入単価</td>
        <td class="Title_Blue">実棚数</td>
        <td class="Title_Blue">発注済数</td>
        <td class="Title_Blue">引当数</td>
        <td class="Title_Blue">発注点</td>
        <td class="Title_Blue">{$form.form_order_all_check.html}</td>
    </tr>
    {*1行目*}
    {foreach from=$page_data key=i item=item}
    <tr class="{$tr[$i]}">
        <td align="right">{$i+1}</td>
        <td>{$item[0]}</td>
        <td>{$item[1]}</td>
        <td>{$item[2]}<br><a href="#" onClick="javascript:window.open('../stock/2-4-105.php?goods_id={$item[5]}');">{$item[3]}</a></td>    
        <td align="right">{$item[4]}</td>
        <td align="right"><a href="javascript:Open_Dialog('2-3-111.php',300,160,1,{$item[5]},{$smarty.session.client_id});">{$item[6]|number_format}</a></td>
        <td align="right">{$item[7]|number_format}</td>
        <td align="right">{$item[8]|number_format}</td>
        <td align="right">{$item[9]|number_format}</td>
        <td align="center">{$form.form_order_check[$i].html}</td>
    </tr>
    {/foreach}
        <tr class="Result3">
        <td align="right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="center">{$form.form_order_button.html}</td>
    </tr>
{$var.html_page2}
</table>

        </td>
    </tr>
</table>
{/if}
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
