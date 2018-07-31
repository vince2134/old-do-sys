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
                    <td width="650">
{*---------------- メッセージ類 START -----------------*}
{* 日付（必須）のエラーチェック *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*---------------- メッセージ類  END  -----------------*}


{*-------------------- 画面表示1開始 ------------------*}
<table width="100%" >
    <tr style="color: #555555;">
        <td colspan="2" align="left"><span style="color: #0000ff; font-weight: bold;">
        {* 本部の場合 *}
        {if $var.group_kind == "1" }
            ・「FC・取引先」検索は名前もしくは略称です
        {else}
            ・「得意先」検索は名前もしくは略称です
        {/if}
        </td>
        <td align="right">  <b>出力形式</b>　{$form.form_output_type.html}</td>
   </tr>
</table>        

<table  class="Table_Search" border="1" width="100%" >
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value" colspan="3">  {$form.form_trade_ym_s.html}から
                                        {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
    {* 本部の場合 *}
    {if $var.group_kind == "1" }
            <td class="Title_Gray">FC・取引先</td>
            <td class="Value" colspan="3">  {$form.form_client.html}<br>
                                            {$form.form_rank.html}</td>
    {else}
            <td class="Title_Gray">得意先</td>
            <td class="Value" colspan="3">  {$form.form_client.html}</td>
        </tr>
        <tr>
            <td class="Title_Gray">グループ</td>
            <td class="Value" colspan="3">  {$form.form_client_gr.html}</td>
    {/if}
    </tr>
    <tr>
        <td class="Title_Gray">粗利率</td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>
    {if $var.group_kind == "1" }
    <tr>
        <td class="Title_Gray">抽出対象</td>
        <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
    </tr>
    {/if}
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
    </tr>
</table>
{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
{*-------------------- 画面表示2開始 -------------------*}
{* =====  出力フラグがTRUEの場合 START ===== *}
{if $out_flg == true }

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* ------------------ タイトル START ------------------ *}
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Gray" align="center">No.</td>
        
    {* 本部の場合 *}
    {if $var.group_kind == "1" }
        <td class="Title_Gray">FC・取引先</td>
        <td class="Title_Gray">FC・取引先区分</td>
    {else}
        <td class="Title_Gray">得意先</td>
    {/if}
        <td class="Title_Gray"></td>

    {* ヘッダの年月 *}
    {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center"><b>{$disp_head[$i]}</b></td>
    {/foreach}

        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>
{* ----------------- タイトル END ------------------ *}


{* -------------- 一覧データ START ----------------- *}
{foreach key=i from=$disp_data item=item name=data}

    {* ----------------- 合計行 START ------------------ *}
    {* 配列要素が最初または、最後の場合 *}
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last }

      {* ループの総回数から、-1をした数をlast変数に取得 *}
      {assign var="last" value=`$smarty.foreach.data.total-1`}
      <tr class="Result3">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}店舗</b></td>
        
        {* 本部の場合 *}
        {if $var.group_kind == "1" }
            <td></td>
        {/if}

        <td style="font-weight: bold;">売上金額<br>粗利益額<br>
        {* 粗利率が表示の場合 *}
        {if $rate_flg == true }
            粗利率
        {/if}
        </td>

        {* 指定された期間のみ出力させる *}
        {foreach key=j from=$disp_data[$last].total_arari_rate item=money}
         <td align="right">{$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br>
                           {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br>
                           {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        {/foreach}
        <td align="right">{$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        <td align="right">{$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
      </tr>
    {/if}
    {* ------------------- 合計行 END  --------------------- *}

  
    {* ------------------- 明細行 START -------------------- *} 
    {* 配列要素が最後でない場合 *}
    { if $smarty.foreach.data.last != true } 
        {if $i is even }
            <tr class="Result1">
        {else}
            <tr class="Result2"> 
        {/if}
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">   {$disp_data[$i].cd}<br>
                            {$disp_data[$i].name|escape}</td>
        {* 本部の場合 *}
        {if $var.group_kind == "1" }
            <td align="left">{$disp_data[$i].rank_cd}<br>
                             {$disp_data[$i].rank_name|escape}</td>
        {/if}

        <td style="font-weight: bold;">売上金額<br>粗利益額<br>
        {* 粗利率が表示の場合 *}
        {if $rate_flg == true }
            粗利率
        {/if}
        </td>

        {* 指定された期間のみ出力させる *}
        {foreach key=j from=$disp_data[$i].net_amount item=money}
            <td align="right">{$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>{$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br>{$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        {/foreach}

        <td align="right">  {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        <td align="right">  {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
      </tr>
    {/if}
    {* ------------------ 明細行 END ------------------- *} 

{/foreach}
{* -----------  一覧データ END ----------------- *}
</table>

{/if}
{* ===== 出力フラグがTRUEの場合 END ===== *}
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
