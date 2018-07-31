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
                    <td width="700">

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
<!-- エラーメッセージの判定-->
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*--------------- メッセージ類 e n d ---------------*}


{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="100%">
    <tr style="color: #555555;">
        <td align="right"><b>出力形式</b>　{$form.form_output_type.html}</td>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html}{$form.form_trade_ym_e_abc.html}</td>
    </tr>
    <tr>
    <!--本部の場合-->
    {if $var.group_kind == "1"}
        <td class="Title_Gray">FC・取引先区分</td>
        <td class="Value" colspan="3">{$form.form_rank.html}</td>
    {else}
        <td class="Title_Gray">グループ</td>
        <td class="Value">{$form.form_client_gr.html}</td>
    {/if}
    </tr>
    <tr>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">{$form.form_out_range.html}</td>
    <!--本部の場合-->
    {if $var.group_kind == "1"}
        <td class="Title_Gray">抽出対象</td>
        <td class="Value">{$form.form_out_abstract.html}</td>
    {/if}
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font><td>
        <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td>
{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<!--表示ボタン押下の場合-->
{if $var.disp_flg   == true}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
{* -------------- ヘッダ START ------------------ *}
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Gray">順位</td>
        <!-- 本部の場合 -->
        {if $var.group_kind == "1"}
            <td class="Title_Gray">FC・取引先</td>
            <td class="Title_Gray">FC・取引先区分</td>
        {else}
            <td class="Title_Gray">得意先</td>
        {/if}
        <td class="Title_Gray">売上金額</td>
        <td class="Title_Gray">構成比</td>
        <td class="Title_Gray">累積金額</td>
        <td class="Title_Gray">累積構成比</td>
        <td class="Title_Gray">区分</td>
    </tr>
{* --------------- ヘッダ END ------------------- *}


{* --------------- 明細 START ------------------- *}

{foreach key=i from=$disp_data item=item name=data}

    {* 合計行参照用のキー *}
    {assign var="last" value=`$smarty.foreach.data.total-1`}

    <!-- 合計行（初めと終わりのみ） -->
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
    <tr class="Result3">
        <td align="center"><b>合計</b></td>
        <td align="center"><b>{$disp_data[$last].count|Plug_Minus_Numformat}店舗</b></td>
        <!-- 本部の場合 -->
        {if $var.group_kind == "1"}
            <td></td>
        {/if}
        <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td></td>
    </tr>
    {/if}

    <!-- 最後のループ以外 -->
    {if $smarty.foreach.data.last != true}

        {if $i is even}
            <tr class="Result1">
        {else}
            <tr class="Result2">
        {/if}

        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>
        <!-- 本部の場合 -->
        {if $var.group_kind == "1"}
            <td >{$disp_data[$i].rank_cd}<br>{$disp_data[$i].rank_name}</td>
        {/if}
        <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
        <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
        <!-- 区分 -->
        {if $disp_data[$i].rank != NULL}
        <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}" bgcolor="{$disp_data[$i].bgcolor}">
            {$disp_data[$i].rank}<br>
            {$disp_data[$i].rank_rate}
        </td>
        {/if}
    </tr>
    {/if}
{/foreach}
</table>

        </td>
    </tr>
</table>
{/if}
<!-- 表示ボタン押下 END -->
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
