{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="left" valign="top">
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

{* エラー時のメッセージ *} 
{if $var.err_mess != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.err_mess}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow" width="100"><b>出力形式</b></td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
    {if $smarty.get.ware_id == null}
    <tr>
        <td class="Title_Yellow"><b>対象倉庫</b></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    {/if}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　{$form.clear_button.html}</td>
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

<span style="font: bold 15px; color: #555555;">
【棚卸日：{$var.invent_day}　棚卸調査番号：{$var.invent_no}　前回棚卸調査番号：{if $var.last_no != '0000000000'}{$var.last_no}{else}なし{/if}】
</span>
<br>
<br>
<br>
{foreach from=$page_data item=item key=i}
<span style="font: bold 15px; color: #555555;">
{if $i < $var.ware_list_num}
    【{$ary_ware_list_name[$i]}】
{elseif $i == $var.ware_list_num}
    【全倉庫】
<span style="color: #0000ff; font-size: 12px; font-weight: bold; line-height: 130%;">
    実棚数が0の場合、棚卸単価は表示されません
</span>
{/if}
</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品分類名</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">帳簿数</td>
        <td class="Title_Yellow">実棚数</td>
        <td class="Title_Yellow">棚卸<br>差異数</td>
        <td class="Title_Yellow">棚卸単価</td>
        <td class="Title_Yellow">棚卸金額</td>
        <td class="Title_Yellow">前回<br>在庫数</td>
        <td class="Title_Yellow">前回<br>在庫金額</td>
        <td class="Title_Yellow">前回<br>対比数</td>
        {* <td class="Title_Yellow">前回<br>対比金額</td> *}
        {if $i < $var.ware_list_num}
        <td class="Title_Yellow">棚卸実施者</td>
        {* <td class="Title_Yellow">棚卸入力者</td> *}
        <td class="Title_Yellow">差異原因</td>
        {/if}
    </tr>

    {foreach from=$page_data[$i] item=items key=j name=ware}
    {if $j is even}
    <tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
        <td align="right">{$j+1}</td>
        <td>{$page_data[$i][$j][0]}</td>
        <td>{$page_data[$i][$j][1]}</td>
        <td align="right"{if $page_data[$i][$j][2]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][2] }</td>
        <td align="right"{if $page_data[$i][$j][3]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][3] }</td>
        <td align="right"{if $page_data[$i][$j][4]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][4] }</td>
        {if $i == $var.ware_list_num && $page_data[$i][$j][3] == "0"}
        <td align="center">-</td>
        {else}
        <td align="right"{if $page_data[$i][$j][5]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][5] }</td>
        {/if}
        <td align="right"{if $page_data[$i][$j][6]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][6] }</td>
        <td align="right"{if $page_data[$i][$j][7]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][7] }</td>
        <td align="right"{if $page_data[$i][$j][8]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][8] }</td>
        <td align="right"{if $page_data[$i][$j][9]  < 0} style="color: #ff0000;"{/if}>{$page_data[$i][$j][9] }</td>
        {if $i < $var.ware_list_num}
        <td>{$page_data[$i][$j][10]}</td>
        {* <td>{$page_data[$i][$j][11]}</td> *}
        {*理由を置き換える。*}
        <td>{$page_data[$i][$j][12]}</td>
        {/if}
    </tr>

    {*商品分類計を表示*}
    {if $page_data[$i][$j][90] == true}
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="2"><b>商品分類計</b></td>
        <td align="right"{if $g_product_total[$i][$j][0] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][0]}</td>
        <td align="right"{if $g_product_total[$i][$j][1] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][1]}</td>
        <td align="right"{if $g_product_total[$i][$j][2] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][2]}</td>
        <td align="right"{if $g_product_total[$i][$j][3] < 0} style="color: #ff0000;"{/if}>{*{$g_product_total[$i][$j][3]}*}</td>
        <td align="right"{if $g_product_total[$i][$j][4] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][4]}</td>
        <td align="right"{if $g_product_total[$i][$j][5] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][5]}</td>
        <td align="right"{if $g_product_total[$i][$j][6] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][6]}</td>
        <td align="right"{if $g_product_total[$i][$j][7] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][7]}</td>
        {* <td align="right"{if $g_product_total[$i][$j][8] < 0} style="color: #ff0000;"{/if}>{$g_product_total[$i][$j][8]}</td> *}
        {if $i < $var.ware_list_num}
        <td></td>
        {* <td></td> *}
        <td></td>
        {/if}
    </tr>
    {/if}
    {/foreach}

    {*倉庫計を表示*}
    <tr class="Result4">
        <td colspan="3"><b>倉庫計</b></td>
        <td align="right"{if $ware_total[$i][0] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][0]}</td>
        <td align="right"{if $ware_total[$i][1] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][1]}</td>
        <td align="right"{if $ware_total[$i][2] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][2]}</td>
        <td align="right"{if $ware_total[$i][3] < 0} style="color: #ff0000;"{/if}>{*{$ware_total[$i][3]}*}</td>
        <td align="right"{if $ware_total[$i][4] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][4]}</td>
        <td align="right"{if $ware_total[$i][5] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][5]}</td>
        <td align="right"{if $ware_total[$i][6] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][6]}</td>
        <td align="right"{if $ware_total[$i][7] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][7]}</td>
        {* <td align="right"{if $ware_total[$i][8] < 0} style="color: #ff0000;"{/if}>{$ware_total[$i][8]}</td> *}
        {if $i < $var.ware_list_num}
        <td></td>
        {* <td></td> *}
        <td></td>
        {/if}
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.form_back_button.html}</td>
    </tr>
</table>
<br><br>
{/foreach}

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
