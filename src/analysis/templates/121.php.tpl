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
<table width="750">
    <tr>
        <td>
{* ============= 検索項目 START ================ *}
<table width="100%">
    <tr style="color: #555555;">
        <td colspan="2" align="left"><span style="color: #0000ff; font-weight: bold;">
        {* 本部の場合 *}
        {if $var.group_kind == "1"}
            ・「FC・取引先」検索は名前もしくは略称です
        {else}
            ・「仕入先」検索は名前もしくは略称です
        {/if}
        </td>
        <td align="right"><b>出力形式</b>　{$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value" colspan="3">  {$form.form_trade_ym_s.html}から
                                        {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
    {* 本部の場合 *}
    {if $var.group_kind == "1"}
        <td class="Title_Gray">FC・取引先</td>
        <td class="Value"colspan="3">{$form.form_client.html}<br>{$form.form_rank.html}</td>
    {else}
        <td class="Title_Gray">仕入先</td>
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    {/if}
    </tr>
    <tr>
        <td class="Title_Gray">商品</td>
        <td class="Value">{$form.form_goods.html}</td>
        <td class="Title_Gray">Ｍ区分</td>
        <td class="Value">{$form.form_g_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">管理区分</td>
        <td class="Value">{$form.form_product.html}</td>
        <td class="Title_Gray">商品分類</td>
        <td class="Value">{$form.form_g_product.html}</td>
    </tr>
    <tr>
    {* 本部の場合 *}
    {if $var.group_kind == "1"}
        <td class="Title_Gray">表示対象</td>
        <td class="Value">{$form.form_out_range.html}</td>
        <td class="Title_Gray">抽出対象</td>
        <td class="Value">{$form.form_out_abstract.html}</td>
    {else}
        <td class="Title_Gray">表示対象</td>
        <td class="Value" colspan="3">{$form.form_out_range.html}</td>
    {/if}
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
    </tr>
</table>

{* =============== 検索項目 END ================= *}

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

{* ============= テーブルタイトル START =============== *}
<table class="List_Table" border="1" width="100%">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Gray">No.</td>
        {* 本部の場合 *}
        {if $var.group_kind == "1"}
            <td class="Title_Gray">FC・取引先</td>
            <td class="Title_Gray">FC・取引先区分</td>
        {else}
            <td class="Title_Gray">仕入先</td>
        {/if}
        <td class="Title_Gray">商品</td>
        <td class="Title_Gray"></td>
        {foreach key=i from=$disp_head item=ym}        
            <td class="Title_Gray">{$ym}</td>
        {/foreach}
        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>
{* ============== テーブルタイトル END ================ *}


{* ================= 一覧データ START ================= *}

{* ほげぴよループ *}
{ foreach key=i from=$disp_data item=item name=data}

    {* ====== 合計行 START ====== *}
    {** ループのはじめか、最後の場合 **} 
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
        
        {assign var="last" value=`$smarty.foreach.data.total-1`}
        <tr class="Result4">
            <td align="center"><b>合計</b></td>
            <td align="center"><b>{$disp_data[$last].total_count}店舗</b></td>

            {* 本部の場合 *}
            {if $var.group_kind == "1"}
                <td></td>
                <td></td>
            {else}
                <td></td>
            {/if}
            
            <td style="font-weight: bold;"> 仕入数<br>仕入金額</td>
        {* 指定された期間分のみ出力する *}
        {foreach key=j from=$disp_data[$last].total_net_amount item=money}  
            <td align="right">
                {$disp_data[$last].total_num[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}
            </td>
        {/foreach}

        {* 月合計 *}
            <td align="right">
                {$disp_data[$last].sum_num|Plug_Minus_Numformat}<br>
                {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}
            </td>
        {* 月平均 *}
            <td align="right">
                {$disp_data[$last].sum.ave_num|Plug_Minus_Numformat}<br>
                {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}
            </td>
        </tr>
    {/if}
    {* ======= 合計行 END ======= *}

    
    {* ====== 明細行 START ====== *}
    
    {* 明細（最終行でない＋小計フラグが数値の場合) *}
    {if $smarty.foreach.data.last !== true AND ($disp_data[$i].sub_flg === "1" OR $disp_data[$i].sub_flg === "2")}

        {if $disp_data[$i].sub_flg is not even}
        <tr class="Result1">
        {else}
        <tr class="Result2">
        {/if}

        {*ぴよ1行目の場合はほげ列を出力する *}
        {if $disp_data[$i].rowspan !== null}
            <td align="right" rowspan="{$disp_data[$i].rowspan}">{$disp_data[$i].no}</td>
            <td rowspan="{$disp_data[$i].rowspan}">
                {$disp_data[$i].cd}<br>
                {$disp_data[$i].name|escape}<br>
            </td>
            {* 本部の場合 *}
            {if $var.group_kind == "1"}
                <td rowspan="{$disp_data[$i].rowspan}"> {$disp_data[$i].rank_cd}<br>
                                                        {$disp_data[$i].rank_name}            
                </td>
            {/if}
        {/if}
            <td>{$disp_data[$i].cd2}<br>
                {$disp_data[$i].name2|escape}<br>
            </td>    
            <td style="font-weight: bold;">
                仕入数<br>
                仕入金額<br>
            </td>
    
    {* 小計（最終行でない＋小計フラグがtrueの場合）*} 
    {elseif $smarty.foreach.data.last !== true AND $disp_data[$i].sub_flg === "true"}
        <tr class="Result3">
            <td align="center"><b>小計</b></td>
            <td style="font-weight: bold;">
                仕入数<br>
                仕入金額<br>
            </td>
    {/if}

    {* 最終行でない場合 *}
    {if $smarty.foreach.data.last !== true}
        
        {* ひと月分ずつループ ※指定された期間分のみ出力する *}
        {foreach key=j from=$disp_data[$i].net_amount item=money}
            <td align="right">
                {$disp_data[$i].num[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>
            </td>
        {/foreach}

        {* 月合計 *}
            <td align="right">
                {$disp_data[$i].sum_num|Plug_Minus_Numformat}<br>
                {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}
            </td>
        {* 月平均 *}
            <td align="right">
                {$disp_data[$i].ave_num|Plug_Minus_Numformat}<br>
                {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}
            </td>
        </tr>
    {/if}
{/foreach}
{* ======= 明細行 END ======= *}

</table>
{* ================= 一覧データ END =================== *}

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
