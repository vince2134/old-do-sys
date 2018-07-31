{*
 *
 * 売上営業成績（本部、FC）（template）
 *
 *
 * 履歴：
 *
 *  日付        担当者          内容
 *  2007-11-17  fukuda          新規作成
 *
 *}

{$var.html_header}

<style TYPE="text/css">
<!--
.required {ldelim}
    font-weight: bold;
    color: #ff0000;
    {rdelim}
.bold {ldelim}
    font-weight: bold;
    {rdelim}
-->
</style>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=message}
    <li>{$message}<br />
{/foreach}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table width="100%">
    <tr style="color: #555555;">
        <td align="right"><b>出力形式</b> {$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Data_Table" border="1" width="100%">
{* 本部用 *}
{if $smarty.session.group_kind === "1"}
<col width="120px" class="bold">
{* FC用 *}
{else}
<col width=" 80px" class="bold">
{/if}
<col width="300px">
<col width=" 80px" class="bold">
<col width="300px">
    <tr>
        <td class="Title_Gray">集計期間<span class="required">※</span></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html} から {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
        {* 本部用 *}
        {if $smarty.session.group_kind === "1"}
        <td class="Title_Gray">ショップ・部署</td>
        <td class="Value" colspan="3">{$form.form_shop_part.html}</td>
        {* FC用 *}
        {else}
        <td class="Title_Gray">部署</td>
        <td class="Value">{$form.form_part.html}</td>
        <td class="Title_Gray">担当者</td>
        <td class="Value">{$form.form_staff.html}</td>
        {/if}
    </tr>
    <tr>
        <td class="Title_Gray">粗利率</td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td class="required">※は必須入力です</td>
        <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br />
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}

{* 表示ボタン押下時 *}
{if $out_flg === "true"}

<table width="100%">
    <tr>
        <td>

            {* 本部機能の場合は、選択されたショップ名を出力する *}
            {if $smarty.session.group_kind === "1"}
            <span style="font: bold 15px; color: #555555;">{$shop_data|escape}</span><br />
            {/if}

            <table class="List_Table" border="1" width="100%">

    {********** テーブルヘッダ ここから **********}

                <tr class="bold" align="center">
                    <td class="Title_Gray">No.</td>
                    <td class="Title_Gray">部署</td>
                    <td class="Title_Gray">担当者</td>
                    <td class="Title_Gray"></td>
                    {* 年月表示 *}
                    {foreach key=i from=$disp_head item=ym}
                    <td class="Title_Gray">{$ym}</td>
                    {/foreach}
                    <td class="Title_Gray">月合計</td>
                    <td class="Title_Gray">月平均</td>
                </tr>

    {********** テーブルヘッダ ここまで **********}

    {********** テーブルデータ ここから **********}

    {* ほげほげループ *}
    {foreach key=i from=$disp_data item=item name=data}

        {********** 合計行専用 ここから **********}

            {* 配列要素が最初または、最後の場合 *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}

                {* ループの総回数から、1を引いた数をlast変数に格納
                   配列の１行目に合計が入ってないので最終行を参照するため *}
                {assign var="last" value=`$smarty.foreach.data.total-1`}

                <tr class="Result4">
                    <td align="center" class="bold">合計</td>
                    <td align="center" class="bold">{$disp_data[$last].total_count}部署</td>
                    <td></td>
                    <td class="bold">
                        売上金額<br />
                        粗利益額<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        粗利率<br />
                        {/if}
                    </td>

                {* ひと月分ずつループ ※指定された期間分のみ出力する *}
                {foreach key=j from=$disp_data[$last].total_net_amount item=money}
                    <td align="right">
                        {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>
                {/foreach}

                {* 月合計 *}
                    <td align="right">
                        {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                {* 月平均 *}
                    <td align="right">
                        {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                </tr>

            {/if}

        {********** 合計行専用 ここまで **********}

        {********** 明細・小計行専用 ここから **********}

            {* 明細（最終行でない＋小計フラグが数値の場合） *}
            {if $smarty.foreach.data.last !== true && ($disp_data[$i].sub_flg === "1" || $disp_data[$i].sub_flg === "2")}

                {if $disp_data[$i].sub_flg is not even}
                <tr class="Result1">
                {else}
                <tr class="Result2">
                {/if}
                {* ぴよ１行目の場合はほげ列を出力する *}
                {if $disp_data[$i].rowspan !== null}
                    <td align="right" rowspan="{$disp_data[$i].rowspan}">{$disp_data[$i].no}</td>
                    <td rowspan="{$disp_data[$i].rowspan}">
                        {$disp_data[$i].cd}<br />
                        {$disp_data[$i].name|escape}<br />
                    </td>
                {/if}
                    <td>
                        {$disp_data[$i].cd2}<br />
                        {$disp_data[$i].name2|escape}<br />
                    </td>
                    <td class="bold">
                        売上金額<br />
                        粗利益額<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        粗利率<br />
                        {/if}
                    </td>

            {* 小計（最終行でない＋小計フラグがtrueの場合） *}
            {elseif $smarty.foreach.data.last !== true && $disp_data[$i].sub_flg === "true"}

                <tr class="Result3">
                    <td align="center" class="bold">小計</td>
                    <td class="bold">
                        売上金額<br />
                        粗利益額<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        粗利率<br />
                        {/if}
                    </td>

            {/if}


            {* 最終行でない場合 *}
            {if $smarty.foreach.data.last !== true}

                {* ひと月分ずつループ ※指定された期間分のみ出力する *}
                {foreach key=j from=$disp_data[$i].net_amount item=money}
                    <td align="right">
                        {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>
                {/foreach}

                {* 月合計 *}
                    <td align="right">
                        {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                {* 月平均 *}
                    <td align="right">
                        {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br />
                        {* 粗利率を表示する場合 *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                </tr>

            {/if}

        {********** 明細・小計行専用 ここまで **********}

    {/foreach}

    {********** テーブルデータ ここまで **********}

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

