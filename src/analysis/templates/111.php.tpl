{*
 *
 * FC別商品別ABC分析（template）
 *
 *
 * 履歴：
 *
 *  日付        担当者          内容
 *  2007-12-01  fukuda          新規作成
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
                <col width="120px" class="bold">
                <col width="250px">
                <col width=" 80px" class="bold">
                <col width="250px">
                <tr>
                    <td class="Title_Gray">集計期間<span class="required">※</span></td>
                    <td class="Value" colspan="3">{$form.form_trade_ym_s.html} から {$form.form_trade_ym_e_abc.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">FC・取引先区分</td>
                    <td class="Value" colspan="3">{$form.form_rank.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">Ｍ区分</td>
                    <td class="Value">{$form.form_g_goods.html}</td>
                    <td class="Title_Gray">管理区分</td>
                    <td class="Value">{$form.form_product.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">商品分類</td>
                    <td class="Value">{$form.form_g_product.html}</td>
                    <td class="Title_Gray">表示対象</td>
                    <td class="Value">{$form.form_out_range.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">抽出対象</td>
                    <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
                </tr>
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
                    <td class="Title_Gray">No.</td>
                    <td class="Title_Gray">FC・取引先</td>
                    <td class="Title_Gray">FC・取引先区分</td>
                    <td class="Title_Gray">順位</td>
                    <td class="Title_Gray">商品</td>
                    <td class="Title_Gray">売上金額</td>
                    <td class="Title_Gray">構成比</td>
                    <td class="Title_Gray">累積金額</td>
                    <td class="Title_Gray">累積構成比</td>
                    <td class="Title_Gray">区分</td>
                </tr>
    {********** テーブルヘッダ ここまで **********}

    {********** テーブルデータ ここから **********}

        {* FC毎ループ *}
        {foreach key=i from=$disp_data item=item name=data}

            {* 合計行参照用のキー *}
            {assign var="last" value=`$smarty.foreach.data.total-1`}

            {* 合計行 - 配列要素が最初または最後の場合 *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
                <tr class="Result4">
                    <td align="right" class="bold">合計</td>
                    <td align="center" class="bold">{$disp_data[$last].count|Plug_Minus_Numformat}店舗</td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center"></td>
                </tr>
            {/if}

            {* 明細行 - 最後の行でない＋小計行でない場合 *}
            {if $smarty.foreach.data.last != true && $disp_data[$i].sub_flg !== "true"}

                {if $disp_data[$i].sub_flg is not even}
                <tr class="Result1">
                {else}
                <tr class="Result2">
                {/if}

                    {* 得意先の1行目(hoge_rowspanあり)の場合 *}
                    {if $disp_data[$i].hoge_rowspan !== null}
                        <td align="center" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].hoge_no}<br>
                        </td>
                        <td align="left" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].cd}<br>
                        {$disp_data[$i].name}<br>
                        </td>
                        <td align="left" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].rank_cd}<br>
                        {$disp_data[$i].rank_name}<br>
                        </td>
                    {/if}

                    <td align="right">{$disp_data[$i].piyo_no}</td>
                    <td>{$disp_data[$i].cd2}<br />{$disp_data[$i].name2|escape}<br /></td>
                    <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    {* 区分 - rowspan 用の値がある場合 *}
                    {if $disp_data[$i].rank != null}
                    <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
                        {$disp_data[$i].rank}<br />
                        {$disp_data[$i].rank_rate}<br />
                    </td>
                    {/if}
                </tr>

            {/if}

            {* 小計行 - 最後の行でない＋明細行でない場合 *}
            {if $smarty.foreach.data.last != true && $disp_data[$i].sub_flg === "true"}

                    <tr class="Result3">
                        <td></td>
                        <td align="center" class="bold">小計</td>
                        <td align="right">{$disp_data[$i].accumulated_sale_hoge|Plug_Minus_Numformat}</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td></td>
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

