{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.form_input_day.error != null}
    <li>{$form.form_input_day.error}
{/if}
{if $form.form_balance_this.error != null}
    <li>{$form.form_balance_this.error}
{/if}
</ul>
</span>

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col width="220">
<col width="110" style="font-weight: bold;">
<col>
{*
    <tr>
        <td class="Title_Pink">出力形式</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
*}
    {* 1行目 *}
    <tr>
        <td class="Title_Pink">対象月<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_input_day.html}</td>
        <td class="Title_Pink">表示件数</td>
        <td class="Value">{$form.form_display_num.html}</td>
    </tr>

    {* 2行目 *}
    <tr>
{if $var.trade_div == "sale"}
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC・取引先{else}得意先{/if}</td>
        <td class="Value" colspan="3">
            {$form.form_client_cd.html}&nbsp;{$form.form_client_name.html}
            {* 本部画面の場合、FC・取引先のセレクトボックスを表示 *}
            {if $smarty.session.group_kind == "1"}
            <br>{$form.form_rank.html}
            {/if}
        </td>
    {* FC画面の場合はグループで検索可能 *}
    {if $smarty.session.group_kind != "1"}
    </tr>
    {* 2.5行目 *}
    <tr>
        <td class="Title_Pink">グループ</td>
        <td class="Value" colspan="3">{$form.form_client_gr_name.html}&nbsp;{$form.form_client_gr.html}</td>
    {/if}
{else}
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC・取引先{else}仕入先{/if}</td>
        <td class="Value" colspan="3">
            {$form.form_client_cd.html}&nbsp;{$form.form_client_name.html}
            {* 本部画面の場合、FC・取引先のセレクトボックスを表示 *}
            {if $smarty.session.group_kind == "1"}
            <br>{$form.form_rank.html}
            {/if}
        </td>
{/if}
    </tr>

    {* 3行目 *}
    <tr>
        <td class="Title_Pink">当月{if $var.trade_div == "sale"}売{else}買{/if}掛残高<br>(税込)</td>
        <td class="Value">{$form.form_balance_this.html}<br>{$form.form_balance_radio.html}<br></td>
        <td class="Title_Pink">取引状態</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>

{if $var.trade_div == "buy" && $var.group_kind == "1"}
    {* 3.5行目 *}
    <tr>
        <td class="Title_Pink">FC・取引先区分</td>
        <td class="Value" colspan="3">{$form.form_supplier_div.html}</td>
    </tr>
{/if}

    {* 取引区分 *}
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value" colspan="3">{$form.form_trade.html}</td>
    </tr>

</table>

<table width="100%">
    <tr>
        <td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.form_display_button.html}　　{$form.form_clear_button.html}</td>
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
{if $var.err_flg != true}

<table width="100%">
    <tr>
        <td>

{* POSTがない（初期表示時）は何も表示しない *}
{if $smarty.post != null}

<span style="font: bold 15px; color: #555555;">【対象月：{$var.input_day}】</span><br>
{$var.html_page}

{* 結果が0件の場合は結果テーブル、下の全件数は表示しない *}
{if $var.data_list_count != 0}

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC・取引先{elseif $var.trade_div == "sale"}得意先{else}仕入先{/if}</td>
        <td class="Title_Pink">前月{if $var.trade_div == "sale"}売{else}買{/if}掛残高</td>
        <td class="Title_Pink">当月{if $var.trade_div == "sale"}売上{else}仕入{/if}額</td>
        <td class="Title_Pink">消費税</td>
        <td class="Title_Pink">当月{if $var.trade_div == "sale"}売上{else}仕入{/if}額(税込)</td>
        <td class="Title_Pink">当月{if $var.trade_div == "sale"}入金{else}支払{/if}額</td>
        <td class="Title_Pink">手数料</td>
        <td class="Title_Pink">調整額</td>
        <td class="Title_Pink">割賦残高</td>
        {* <td class="Title_Pink">繰越額</td> *}
        <td class="Title_Pink">当月{if $var.trade_div == "sale"}売{else}買{/if}掛残高</td>
{*
    {if $var.group_kind == 1}
        <td class="Title_Pink">SV<br>窓口担当1</td>
    {else}
        <td class="Title_Pink">契約担当者1<br>巡回担当者1</td>
    {/if}
*}
    </tr>

    <tr class="Result3" align="center" height="30px">
        <td>合計</td>
        <td>{if $var.data_list_count != null}{$var.data_list_count}社{/if}</td>
        <td align="right">{$total_money[3]}</td>
        <td align="right">{$total_money[4]}</td>
        <td align="right">{$total_money[5]}</td>
        <td align="right">{$total_money[6]}</td>
        <td align="right">{$total_money[7]}</td>
        <td align="right">{$total_money[8]}</td>
        <td align="right">{$total_money[9]}</td>
        {* <td align="right">{$total_money[10]}</td> *}
        <td align="right">{$total_money[11]}</td>
        <td align="right"{if $total_money[12] < 0} style="color: #ff0000;"{/if}>{$total_money[12]|number_format}</td>
{*
        <td align="right"></td>
*}
    </tr>
    {foreach key=i from=$disp_data item=item}
    {if $i%2 == 0}
    <tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
        <td align="right">{$item[16]}</td>
        <td>{$item[0]}{if $item[14] != "2"}-{$item[1]}{/if}<br>{$item[2]}</td>
        <td align="right">{$item[3]}</td>
        <td align="right">{$item[4]}</td>
        <td align="right">{$item[5]}</td>
        <td align="right">{$item[6]}</td>
        <td align="right">{$item[7]}</td>
        <td align="right">{$item[8]}</td>
        <td align="right">{$item[9]}</td>
        {* <td align="right">{$item[10]}</td> *}
        <td align="right">{$item[11]}</td>
        <td align="right">{$item[12]}</td>
{*
        <td align="left">{$item[12]}<br>{$item[13]}</td>
*}
    </tr>
    {/foreach}

    <tr class="Result3" align="center" height="30px">
        <td>合計</td>
        <td>{if $var.data_list_count != null}{$var.data_list_count}社{/if}</td>
        <td align="right">{$total_money[3]}</td>
        <td align="right">{$total_money[4]}</td>
        <td align="right">{$total_money[5]}</td>
        <td align="right">{$total_money[6]}</td>
        <td align="right">{$total_money[7]}</td>
        <td align="right">{$total_money[8]}</td>
        <td align="right">{$total_money[9]}</td>
        {* <td align="right">{$total_money[10]}</td> *}
        <td align="right">{$total_money[11]}</td>
        <td align="right"{if $total_money[12] < 0} style="color: #ff0000;"{/if}>{$total_money[12]|number_format}</td>
{*
        <td align="right"></td>
*}
    </tr>
</table>
{$var.html_page2}

{/if}{* 結果が0件か判定おわり *}

{/if}{* POSTがないか判定おわり *}

        </td>
    </tr>
</table>

{/if}
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
