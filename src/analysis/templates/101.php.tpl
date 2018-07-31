{*
 * 履歴：
 *---------------------------------------------
 *  日付        担当者          内容
 *  2007-10-27  watanabe-k      新規作成
 *
 *}

{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="left">
    

        {*-------------------- 画面表示開始 -------------------*}
        <td valign="top">
        
            <table border=0 >
                <tr>
                    <td>

{*-------------------- メッセージ表示 -------------------*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=message}
    <li>{$message}<br>
{/foreach}
</span>
{*-------------------- 画面表示1開始 -------------------*}
<table width="750">
    <tr align="right">
        <td width="650" style="color: #555555;"><b>出力形式</b></td>
        <td>{$form.form_output_type.html}</td>
    </tr>
</table>
<table  class="Data_Table" border="1" width="750" >

    <tr>
        <td class="Title_Gray"width="100"><b>集計期間</b></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html}{$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>商品</b></td>
        <td class="Value">{$form.form_goods.html}</td>
        <td class="Title_Gray" width="100"><b>Ｍ区分</b></td>
        <td class="Value">{$form.form_g_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>管理区分</b></td>
        <td class="Value">{$form.form_product.html}</td>
        <td class="Title_Gray" width="100"><b>商品分類</b></td>
        <td class="Value">{$form.form_g_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>粗利率</b></td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray" width="100"><b>表示対象</b></td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>抽出対象</b></td>
        <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
    </tr>

</table>
<table width='750'>
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font></td>
        <td align='right'>
            {$form.form_display.html}　　{$form.form_clear.html}
        </td>
    </tr>
</table>
{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>
                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}
{*表示ボタンが押されないと表示しない*}
{if $var.disp_flg == true}
<table width="100%">
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* --------------- ヘッダSTART ----------------- *}
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">商品</td>
        <td class="Title_Gray" align="center"></td>
        {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center">{$disp_head[$i]}</td>
        {/foreach}
        <td class="Title_Gray" align="center">月合計</td> 
        <td class="Title_Gray" align="center">月平均</td> 
    </tr>   
{* --------------- ヘッダEND  ------------------- *}

   

{foreach key=i from=$disp_data item=item name=data}

    {*合計行参照用のキー*}
    {assign var="last" value=`$smarty.foreach.data.total-1`}

    {* 合計行 *} 
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
    <tr class="Result3">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}件</b></td>
        <td align="left"><b>
            売上数<br>
            売上金額<br>
            粗利益額<br>
        {if $var.margin_flg == true}
            粗利率
        {/if}
        </b></td>
        {* 指定された集計期間のみ出力させる *} 
        {foreach key=j from=$disp_head item=money }
        <td align="right">
            {$disp_data[$last].total_num[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {/foreach}
        <td align="right">
            {$disp_data[$last].sum_num|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        <td align="right">
            {$disp_data[$last].sum.ave_num|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
    </tr>
    {/if}  

    { if $smarty.foreach.data.last != true }
    {*データ行*}
        {if $i is even}
    <tr class="Result1">
        {else}  
    <tr class="Result2">
        {/if}   
    
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>
        <td align="left"><b>
                売上数<br>
                売上金額<br>
                粗利益額<br>
        {if $var.margin_flg == true}
                粗利率
        {/if}
        </b></td> 
        {* 指定された集計期間のみ出力させる *} 
        {foreach key=j from=$disp_head item=money }
        <td align="right">
            {$disp_data[$i].num[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {/foreach}
        {*月合計*}
        <td align="right">
            {$disp_data[$i].sum_num|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {*月平均*}
        <td align="right">
            {$disp_data[$i].ave_num|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
    </tr>   
        {/if}   
{/foreach}
</table>

        </td>
    </tr>
</table>
{/if}
{********************* 画面表示2終了 ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
    

