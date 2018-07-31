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
{if $form.form_base_date.error != null}
    <li>{$form.form_base_date.error}
{/if}
{if $form.form_object_day.error != null}
    <li>{$form.form_object_day.error}
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col width="190">
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
        <td class="Value" colspan="3">{$form.form_base_date.html} 時点で {$form.form_object_day.html} 日以上 {$form.form_io_type.html}</td>
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
        <td class="Value" >{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3">{$form.form_ware.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
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

全<b>{$var.match_count}</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Title_Yellow">製品区分</td>
        <td class="Title_Yellow">商品コード<br>商品名</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">在庫数</td>
        <td class="Title_Yellow">在庫単価</td>
        <td class="Title_Yellow">在庫金額</td>
        <td class="Title_Yellow">在庫日数</td>
        <td class="Title_Yellow">最終売上日</td>
        <td class="Title_Yellow">最終仕入日</td>
    </tr>
    {foreach from=$row item=item key=i}
    {if $i is even}
    <tr class="Result1">
    {else}
    <tr class="Result2">
    {/if} 
        <td align="right">{$i+1}</td>
        <td>{$row[$i][0]}</td>
        <td>{$row[$i][1]}</td>
        <td>{$row[$i][10]}<br>{$row[$i][2]}</td>
        <td>{$row[$i][3]}</td>
	{*-- 2009/06/24 改修No.27 マイナスの場合は赤字 --*}
	{if $row[$i][4] < 0 }
        <td align="right"><font color="red">{$row[$i][4]}</font></td>
	{else}
        <td align="right">{$row[$i][4]}</td>
	{/if}
	{*-----------------------------------------------*}
	    <td align="right">{$row[$i][5]}</td>
	{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
	{if $row[$i][6] < 0}
        <td align="right"><font color="red">{$row[$i][6]}</font></td>
	{else}
        <td align="right">{$row[$i][6]}</td>
	{/if}
	{*-----------------------------------------------*}
        <td align="right">{$row[$i][7]}</td>
    {*売上仕入なしを選択*}
    {* {if $smarty.post.form_io_type == '1'} *}
    {* rev.1.3 受払なしを選択も追加 *}
    {if $smarty.post.form_io_type == '1' || $smarty.post.form_io_type == '0'}
        <td align="center">{$row[$i][9]}</td>
        <td align="center">{$row[$i][8]}</td>
    {*売上なしを選択*}
    {elseif $smarty.post.form_io_type == '2'}
        <td align="center">{$row[$i][8]}</td>
        <td align="center"></td>
    {*仕入無しを選択*}
    {elseif $smarty.post.form_io_type == '4'}
        <td align="center"></td>
        <td align="center">{$row[$i][8]}</td>
    {/if}        
    </tr>
    {if $g_goods_total[$i] != null}
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>Ｍ区分計</b></td>
        <td align="right"></td>
        <td align="right"></td>
		{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
		{if $g_goods_total[$i] < 0}
        <td align="right"><font color="red">{$g_goods_total[$i]}</font></td>
		{else}
        <td align="right">{$g_goods_total[$i]}</td>
		{/if}
		{*-----------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    {/if}
    {/foreach} 
    <tr class="Result4">
        <td colspan="5"><b>総合計</b></td>
        <td align="right"></td>
        <td align="right"></td>
		{*-- 2009/06/26 改修No.27 マイナスの場合は赤字 --*}
		{if $var.total_amount < 0}
        <td align="right"><font color="red">{$var.total_amount}</font></td>
		{else}
        <td align="right">{$var.total_amount}</td>
		{/if}
		{*-----------------------------------------------*}
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
