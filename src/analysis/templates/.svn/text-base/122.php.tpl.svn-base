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
{* 日付(必須)のエラーチェック *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>
{* ------------ 検索項目 START --------------- *}
<table width="100%">    
    <tr style="color: #555555;">
        <td colspan="2" align="left">
            <span style="color: #0000ff; font-weight: bold;">
        {* 本部の場合 *}   
        {if $var.group_kind == "1" }
            ・「FC・取引先」検索は名前もしくは略称です</td>
        {else}
            ・「仕入先」検索は名前もしくは略称です</td>
        {/if}
        <td align="right">  <b>出力形式</b>　{$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value">  {$form.form_trade_ym_s.html}から
                            {$form.form_trade_ym_e.html}</td> 
    </tr>
    <tr>
        {* FCの場合は仕入先コード2を出力しない *}
        {if $var.group_kind == "1" }
            <td class="Title_Gray">FC・取引先</td>
            <td class="Value">  {$form.form_client.html}<br>{$form.form_rank.html}</td>
        {else}
            <td class="Title_Gray">仕入先</td>
            <td class="Value">  {$form.form_client.html}</td>
        {/if}
    </tr>
    <tr>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">  {$form.form_out_range.html}</td>
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
{* ------------ 検索項目 END --------------- *}

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
{* 出力フラグがTRUEの場合 START *}
{if $out_flg == true }

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* --------------- ヘッダSTART ----------------- *}
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>

        {* 本部の場合はFC・取引先とFC・取引先区分 *}
        {if $var.group_kind == "1" }
            <td class="Title_Gray" align="center">FC・取引先</td>
            <td class="Title_Gray" align="center">FC・取引先区分</td>
        {else}
            <td class="Title_Gray" align="center">仕入先</td>
        {/if}    

        <td class="Title_Gray" align="center"></td>

        {* 集計期間の数だけタイトル出力 *}
        {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center">{$disp_head[$i]}</td>
        {/foreach}

        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>
{* --------------- ヘッダEND  ------------------- *}

{* ------------ 一覧データSTART ----------------- *}
{foreach key=i from=$disp_data item=item name=data}

    {* 最後の要素でない場合は、得意先毎の月合計を出力 *}
    {if $smarty.foreach.data.last OR $smarty.foreach.data.first}

      {* ループ総回数から-1した数を$lastに取得 *}
      {assign var="last" value=`$smarty.foreach.data.total-1`}
      {* ------ 合計行 ----- *}
      <tr class="Result3">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}店舗</b></td>

        {* 本部の場合はFC・取引先区分の考慮 *}
        {if $var.group_kind == "1" }
            <td></td>
            <td align="left"><b>仕入金額</b></td>
        {else}
            <td align="left"><b>仕入金額</b></td>
        {/if}

        {* 指定された集計期間のみ出力させる *}
        {foreach key=j from=$disp_data[$last].total_arari_rate item=money }
        <td align="right">{$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}</td>
        {/foreach}

        <td align="right">{$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}</td>
      </tr>
    {/if}

    {* ------ 明細行 ------- *}
    {* 最後の行で無い場合 *}
    {if $smarty.foreach.data.last == false }
        {if $i is even}
            <tr class="Result1">
        {else}
            <tr class="Result2">
        {/if}
    
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>

        {* 本部の場合は、FC・取引先区分を出力する *}
        {if $var.group_kind == "1" }
            <td align="left">{$disp_data[$i].rank_cd}<br>{$disp_data[$i].rank_name|escape}</td>
        {/if}

        <td align="left"><b>仕入金額</b></td>

        {* 指定された集計期間のみ出力させる *}
        {foreach key=j from=$disp_data[$i].net_amount item=money }
        <td align="right">{$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}</td>
        {/foreach}

        <td align="right">{$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}</td>
        </tr>

    {/if}
{/foreach}
</table>
{* ------------- 一覧データ ｅｎｄ -------------- *}
{/if}
{* 出力フラグがTRUEの場合 END *}
        </td>
    </tr>
</table>
{*-------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
