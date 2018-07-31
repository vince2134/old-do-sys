{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
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
{if $form.form_inquiry_day.error != null}
    <li>{$form.form_inquiry_day.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
<col width="110" style="font-weight: bold;">
<col width="200">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">照会日</td>
        <td class="Value" colspan="3">{$form.form_inquiry_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象商品</td>
        <td class="Value" colspan="3">{$form.form_target_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Value">{$form.form_g_goods.html}</td>
        <td class="Title_Yellow">管理区分</td>
        <td class="Value">{$form.form_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品分類</td>
        <td class="Value" colspan="3">{$form.form_g_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品名(略称)</td>
        <td class="Value" colspan="3">{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">拠点倉庫</td>
        <td class="Value">{$form.form_ware.html}</td>
        <td class="Title_Yellow">個人倉庫</td>
        <td class="Value">{$form.form_staff_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">属性区分</td>
        <td class="Value">{$form.form_attri_div.html}</td>
        <td class="Title_Yellow">在庫区分</td>
        <td class="Value">{$form.form_stock_div.html}</td>
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
<table width="100%">
    <tr>
        <td>

{if $var.err_flg != true}

{if $smarty.post.form_show_button == "表　示" || $smarty.post.order_button_flg == "true"}
<span style="font: bold 16px; color: #555555;">
【照会日:
{if $form.form_order_all_check.error == null && $form.form_inquiry_day.error == null && $var.inquiry_day != '--'}
{$var.inquiry_day}】
{else}
指定無し】
{/if}
</span><br>


<table width="1050"> 
    <tr>
        <td>
            全<b>{$var.match_count}</b>件
        </td>
        <td width="900" colspan="2" align="right">
            <font color="#0000FF"><b>※チェックを付けた商品は発注することが可能です。</b></font>
        </td>
    </tr>
    <tr>
        <td colspan="2">
<table class="List_Table" border="1" width="900">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード</td>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Title_Yellow">管理区分</td>
        <td class="Title_Yellow">商品分類</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">在庫数</td>
        <td class="Title_Yellow">在庫単価</td>
        <td class="Title_Yellow">在庫金額</td>
        <td class="Title_Yellow">最終取扱日</td>
        <td class="Title_Yellow">受払照会</td>
		<td class="Title_Yellow"><br></td>
        <td class="Title_Yellow">{$form.form_order_all_check.html}</td>
    </tr>
    {foreach from=$page_data item=item key=i}
    {if $i IS even}
    <tr class="Result1" height="23">
    {else}
    <tr class="Result2" height="23">
    {/if}
        <td align="right">{$i+1}</td>
        <td>{$item[3]}</td>
        <td>{$item[2]}</td>
        <td>{$item[1]}</td>
        <td>{$item[13]}</td>
        <td>{$item[4]}</td>
        <td>{$item[6]}</td>
        <td align="right">{$item[7]}</td>
        <td align="right">{$item[8]}</td>
        <td align="right">{$item[9]}</td>
        <td align="center">{$item[10]}</td>
        <td align="center">
        <a href="./2-4-105.php?ware_id={$page_data[$i][11]}&goods_id={$page_data[$i][12]}">受払</a>
        </td>
		<td><br></td>
        <td align="center">{$form.form_order_check[$i].html}</td>
    </tr>       
    {/foreach}
    <tr class="Result3" height="23">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.num_total}</td>
        <td></td>
        <td align="right">{$var.money_total}</td>
        <td></td>
        <td></td>
		<td><br></td>
        <td align="center">{$form.form_order_button.html}</td>
    </tr>
</table>
        </td>
{*-- 「発注入力」は一つのTABLE内に納めるためコメント
        <td><br></td>
        <td>
<table class="List_Table" border="1" width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">{$form.form_order_all_check.html}</td>
    </tr>    
{foreach from=$page_data item=item key=i}
    {if $i IS even}
    <tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
        <td align="center">{$form.form_order_check[$i].html}</td>
    </tr>
{/foreach}
    <tr class="Result3">
        <td align="center">{$form.form_order_button.html}</td>
    </tr>
</table>
--*}
{/if}

{/if}

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
