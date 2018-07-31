{*
 *
 * 担当者別ABC分析（本部、FC）（template）
 *
 *
 * 履歴：
 *
 *  日付        担当者          内容
 *  2007-11-23  fukuda          新規作成
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

            {* 出力形式 *}
            <table width="100%">
                <tr style="color: #555555;">
                    <td align="right"><b>出力形式</b> {$form.form_output_type.html}</td>
                </tr>
            </table>

            {* 検索テーブル *}
            <table class="Data_Table" border="1" width="100%">
                <col width="100px" class="bold">
                <col width="600px">
                <tr>
                    <td class="Title_Gray">集計期間<span class="required">※</span></td>
                    <td class="Value" colspan="3">{$form.form_trade_ym_s.html} から {$form.form_trade_ym_e_abc.html}</td>
                </tr>
                {* FC機能用 *}
                {if $smarty.session.group_kind !== "1"}
                <tr>
                    <td class="Title_Gray">所属本支店</td>
                    <td class="Value" colspan="3">{$form.form_branch.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">部署</td>
                    <td class="Value" colspan="3">{$form.form_part.html}</td>
                </tr>
                {/if}
                <tr>
                    <td class="Title_Gray">表示対象</td>
                    <td class="Value">{$form.form_out_range.html}</td>
                </tr>
                {* 本部機能用 *}
                {if $smarty.session.group_kind === "1"}
                <tr>
                    <td class="Title_Gray">抽出対象</td>
                    <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
                </tr>
                {/if}
            </table>

            {* 表示ボタンとか *}
            <table width="100%">
                <tr>
                    <td class="required">※は必須入力です</td>
                    <td align="right">{$form.form_display.html}　　{$form.form_clear.html}</td>
                </tr>
            </table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{* 出力フラグtrue時 *}
{if $out_flg === true}

<table width="100%">
    <tr>
        <td>

            <table class="List_Table" border="1" width="100%">

    {********** テーブルヘッダ ここから **********}
                <tr class="bold" align="center">
                    <td class="Title_Gray">順位</td>
                    <td class="Title_Gray">担当者</td>
                    <td class="Title_Gray">売上金額</td>
                    <td class="Title_Gray">構成比</td>
                    <td class="Title_Gray">累積金額</td>
                    <td class="Title_Gray">累積構成比</td>
                    <td class="Title_Gray">区分</td>
                </tr>
    {********** テーブルヘッダ ここまで **********}

    {********** テーブルデータ ここから **********}

        {* 担当者毎ループ *}
        {foreach key=i from=$disp_data item=item name=data}

            {* 合計行参照用のキー *}
            {assign var="last" value=`$smarty.foreach.data.total-1`}

            {* 合計行 - 配列要素が最初または最後の場合 *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
                <tr class="Result3">
                    <td align="center" class="bold">合計</td>
                    <td align="center" class="bold">{$disp_data[$last].count|Plug_Minus_Numformat}人</td>
                    <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center"></td>
                </tr>
            {/if}

            {* 明細行 - 配列要素の最後の行でない場合 *}
            {if $smarty.foreach.data.last != true}
                <tr class="{cycle values="Result1, Result2"}">
                    <td align="right">{$disp_data[$i].no}</td>
                    <td>{$disp_data[$i].cd}<br />{$disp_data[$i].name|escape}<br /></td>
                    <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                {* 区分 - rowspan 用の値がある場合 *}
                {if $disp_data[$i].rank != null}
                    {* A, B, C 毎に区分の背景色を付けてみる *}
<!-- aizawa-m 背景色変更のためコメント
                    {if $disp_data[$i].rank == "A"}{assign var="abc_bgcolor" value="#a8d3ff"}{/if}
                    {if $disp_data[$i].rank == "B"}{assign var="abc_bgcolor" value="#ffffa8"}{/if}
                    {if $disp_data[$i].rank == "C"}{assign var="abc_bgcolor" value="#ffa8d3"}{/if}
                    <td bgcolor="{$abc_bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
-->
                    <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
                        {$disp_data[$i].rank}<br />
                        {$disp_data[$i].rank_rate}<br />
                    </td>
                {/if}
                </tr>
            {/if}

        {/foreach}

    {********** テーブルデータ ここまで **********}

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

