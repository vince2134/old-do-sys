{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
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

{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_stock_date.error != null}
<li>{$form.form_stock_date.error}<br>
{elseif $form.form_over_day.error != null}
<li>{$form.form_over_day.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="700">
<col width="110" style="font-weight: bold;">
<col width="240">
<col width="110" style="font-weight: bold;">
<col>
{*
    <tr>
        <td class="Title_Yellow">出力形式</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Yellow">対象在庫<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_stock_date.html}　時点で　{$form.form_over_day.html}　日以上　{$form.form_sale_buy.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Value">{$form.form_g_goods.html}</td>
        <td class="Title_Yellow">製品区分</td>
        <td class="Value">{$form.form_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3">{$form.form_ware.html}</td>
    </tr>
    {if $smarty.session.shop_div == '1'}
        <tr>
            <td class="Title_Yellow">事業所</td>
            <td class="Value" colspan="3">{$form.form_cshop.html}</td>
        </tr>
    {/if}
</table>

<table width=100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
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

<table width=$width>
    <tr>    
        <td>全<b>{$var.match_count}</b>件</td>
    </tr>   
</table>

<span style="font: bold 16px; color: #555555;">
【事業所:{$var.cshop_name}】
</span><br>

<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Yellow"><b>No.</b></td>
        <td class="Title_Yellow"><b>Ｍ区分</b></td>
        <td class="Title_Yellow"><b>製品区分</b></td>
        <td class="Title_Yellow"><b>商品コード<br>商品名</b></td>
        <td class="Title_Yellow"><b>倉庫</b></td>
        <td class="Title_Yellow"><b>在庫数</b></td>
        <td class="Title_Yellow"><b>在庫単価</b></td>
        <td class="Title_Yellow"><b>在庫金額</b></td>
        <td class="Title_Yellow"><b>在庫日数</b></td>
        <td class="Title_Yellow"><b>最終売上日</b></td>
        <td class="Title_Yellow"><b>最終仕入日</b></td>
    </tr>
    {foreach key=j from=$row item=items}
    {$row[$j][15]}
        <td align="right">
            {$j+1}
        </td>
        <td>{$row[$j][0]}</td>
        <td>{$row[$j][1]}</td>
        {if $smarty.post.form_sale_buy == '1'}
            <td>{$row[$j][10]}<br>{$row[$j][2]}</td>
        {else}
            <td>{$row[$j][9]}<br>{$row[$j][2]}</td>
        {/if}
        <td>{$row[$j][3]}</td>
		{*-- 2009/06/24 改修No.27 マイナスの場合は赤字 --*}
		{if $row[$j][4] < 0 }
			<td align="right"><font color="red">{$row[$j][4]}</font></td>
		{else}
        	<td align="right">{$row[$j][4]}</td>
		{/if}
		{*-------------------------------------------------------*}
        <td align="right">{$row[$j][5]}</td>
		
		{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
		{if $row[$j][6] < 0 }
        <td align="right"><font color="red">{$row[$j][6]}</font></td>
		{else}
        <td align="right">{$row[$j][6]}</td>
		{/if}
		{*-------------------------------------------------------*}
		
        <td align="right">{$row[$j][7]}</td>
        {*売上仕入なしを選択*}
        {if $smarty.post.form_sale_buy == '1'}
            <td align="center">{$row[$j][9]}</td>
            <td align="center">{$row[$j][8]}</td>
        {*売上なしを選択*}
        {elseif $smarty.post.form_sale_buy == '2'}
            <td align="center">{$row[$j][8]}</td>
            <td align="center"></td>
        {*仕入無しを選択*}
        {elseif $smarty.post.form_sale_buy == '4'}
            <td align="center"></td>
            <td align="center">{$row[$j][8]}</td>
        {/if}
    </tr>
    {if $g_goods_total[$j] != null}
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>Ｍ区分計</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
		{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
		{if $g_goods_total[$j] < 0}	
        <td align="right"><font color="red">{$g_goods_total[$j]}</font></td>
        {else}
		<td align="right">{$g_goods_total[$j]}</td>
		{/if}
		{*-------------------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    {/if}
    {/foreach} 
    <tr class="Result4">
        <td colspan="5"><b>総合計</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
		{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
		{if $var.total_amount < 0}	
        <td align="right"><font color="red">{$var.total_amount}</font></td>
		{else}
        <td align="right">{$var.total_amount}</td>
		{/if}
		{*-------------------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
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
