{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{* 日付のエラーチェック *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*--------------- メッセージ類 e n d ---------------*}


{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>
{* =============== 検索項目 START ================ *}
<table width="100%">
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

<table class="Table_Search" border="1" width="100%">
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
        <td class="Title_Gray">業種</td>
        <td class="Value" colspan="3">  {$form.form_lbtype.html}</td>
    </tr>
    <tr>

    {* 本部の場合 *}
    {if $var.group_kind == "1" }
        <td class="Title_Gray">FC・取引先</td>
        <td class="Value" colspan="3">  {$form.form_client.html}<br>
                                        {$form.form_rank.html}</td>
    {else}
        <td class="Title_Gray">得意先</td>
        <td class="Value" colspan="3">  {$form.form_client.html}<br>
    </tr>
    <tr>
        <td class="Title_Gray">グループ</td>
        <td class="Value" colspan="3">{$form.form_client_gr.html}</td>
    {/if} 
    </tr>

    <tr>
        <td class="Title_Gray">粗利率</td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>
    
    {* 本部の場合 *}
    {if $var.group_kind == "1"}
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
{* =============== 検索項目 END ================ *}

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
{* 表示ボタン押下時 *}
{if $out_flg == true }

{* ============ テーブルタイトル　START ================ *}
<table class="List_Table" border="1" width="100%">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Gray">No.</td>
        <td class="Title_Gray">業種</td>
        {* 本部の場合 *}
        {if $var.group_kind == "1"}
            <td class="Title_Gray">FC・取引先</td>
            <td class="Title_Gray">FC・取引先区分</td>
        {else}
            <td class="Title_Gray">得意先</td>
        {/if}
        <td class="Title_Gray"></td>
        {foreach key=i from=$disp_head item=ym}
        <td class="Title_Gray">{$ym}</td>
        {/foreach}
        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>
{* ============== テーブルタイトル　END ================ *}


{* ============== 一覧データ START =================== *}

{* ほげぴよループ *}
{foreach key=i from=$disp_data item=item name=data}

    {* 〜〜 合計行 START 〜〜 *}
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}

        {* ループ総回数から、1を引いた数をlast変数に格納 *}
        {assign var="last" value=`$smarty.foreach.data.total-1`}
    
        <tr class="Result4">
            <td align="center"><b>合計</b></td>
            <td align="center"><b>{$disp_data[$last].total_count}業種</b></td>
            
            {* 本部の場合 *}
            {if $var.group_kind == "1"}
              <td colspan="2"></td>
            {else}
              <td></td>
            {/if}   
       
            <td style="font-weight: bold;">
            売上金額<br>
            粗利益額<br>
            {* 粗利率が「表示」の場合*}
            {if $margin_flg == true}
                粗利率<br>
            {/if}
            </td>

        {* 指定された期間分のみ出力する *}
        {foreach key=j from=$disp_data[$last].total_net_amount item=money}
            <td align="right">
                {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br>
                {* 粗利率が「表示」の場合 *}
                {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
            </td>
        {/foreach}

        {* 月合計 *}
            <td align="right">
                {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br>
                {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br>
                {* 粗利率が「表示」の場合 *}
                {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
            </td>

        {* 月平均 *}
            <td align="right">
                {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br>
                {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br>
                {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
    </tr>
    {/if}
    {* 〜〜 合計行 END 〜〜 *}


    {* 〜〜 明細・小計行 START 〜〜 *}

    {* 明細（最終行でない＋小計フラグが数値の場合） *}
    {if $smarty.foreach.data.last !== true AND ($disp_data[$i].sub_flg === "1" OR $disp_data[$i].sub_flg === "2")}

        {if $disp_data[$i].sub_flg is not even}
        <tr class="Result1">
        {else}
        <tr class="Result2">
        {/if}

        {* ぴよ1行目の場合は、ほげ列を出力する *}
        {if $disp_data[$i].rowspan !== NULL}
            <td align="right" rowspan="{$disp_data[$i].rowspan}">{$disp_data[$i].no}</td>
            <td rowspan="{$disp_data[$i].rowspan}">
                {$disp_data[$i].cd}<br>
                {$disp_data[$i].name|escape}<br>
            </td>
        {/if}
        <td>
            {$disp_data[$i].cd2}<br>
            {$disp_data[$i].name2|escape}<br>
        </td>
        
        {* 本部の場合 *}
        {if $var.group_kind == "1"}
        <td>
            {$disp_data[$i].rank_cd}<br>
            {$disp_data[$i].rank_name|escape}<br>
        </td>
        {/if}

        <td style="font-weight: bold;">
            売上金額<br>
            粗利益額<br>
            {* 粗利率が「表示」の場合 *}
            {if $margin_flg == true}
            粗利率<br>
            {/if}
        </td>

    {* 小計（最終行でない＋小計フラグtrueの場合） *}
    {elseif $smarty.foreach.data.last !== true AND $disp_data[$i].sub_flg === "true"}
        <tr class="Result3">
            {* 本部の場合 *}
            {if $var.group_kind == "1"}
                <td align="center" colspan="2">
            {else}
                <td align="center">
            {/if}
            <b>小計</b></td>
            <td style="font-weight: bold;">
                売上金額<br>
                粗利益額<br>
                {* 粗利率が「表示」の場合 *}
                {if $margin_flg == true}
                粗利率<br>
                {/if}
            </td>
    {/if}

    {* 最終行でない場合 *}
    {if $smarty.foreach.data.last !== true}

        {* ひと月分ずつループ 指定された期間分のみ出力する *}
        {foreach key=j from=$disp_data[$i].net_amount item=money}
            <td align="right">
                {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
            </td>
        {/foreach}

        {* 月合計 *}
            <td align="right">
                {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br>
                {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br>
                {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
            </td>
            
        {* 月平均 *}
            <td align="right">
                {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br>
                {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br>
                {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
            </td>
        </tr>
    {/if}
    {* 〜〜 明細・小計行 END 〜〜 *} 
{/foreach}
{* ほげぴよループ END *}
</table>

{/if}
{* 表示ボタン押下時 END *}


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
