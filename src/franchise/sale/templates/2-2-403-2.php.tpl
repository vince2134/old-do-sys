{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{if $form.err_daily_update.error != null}
    <li>{$form.err_daily_update.error}<br>
{/if}
{if $form.form_payin_date.error != null}
    <li>{$form.form_payin_date.error}<br>
{/if}
{if $form.form_input_date.error != null}
    <li>{$form.form_input_date.error}<br>
{/if}
{if $form.form_calc_amount.error != null}
    <li>{$form.form_calc_amount.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="650">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">出力形式</td>
        <td class="Value">{$form.form_output_type.html}</td>
        <td class="Title_Pink">表示件数</td>
        <td class="Value">{$form.form_range_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">入金番号</td>
        <td class="Value" colspan="3">{$form.form_payin_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">入金日</td>
        <td class="Value" colspan="3">{$form.form_payin_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">入力日</td>
        <td class="Value" colspan="3">{$form.form_input_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Pink">巡回担当者</td>
        <td class="Value">{$form.form_collect_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Pink">得意先名</td>
        <td class="Value">{$form.form_client_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行コード</td>
        <td class="Value">{$form.form_bank_cd.html}</td>
        <td class="Title_Pink">銀行名</td>
        <td class="Value">{$form.form_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">支店コード</td>
        <td class="Value">{$form.form_b_bank_cd.html}</td>
        <td class="Title_Pink">支店名</td>
        <td class="Value">{$form.form_b_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">預金種目</td>
        <td class="Value">{$form.form_deposit_kind.html}</td>
        <td class="Title_Pink"> 口座番号</td>
        <td class="Value">{$form.form_account_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">合計金額</td>
        <td class="Value">{$form.form_calc_amount.html}</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Value">{$form.form_daily_renew.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_btn.html}　　{$form.form_clear_btn.html}</td>
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
<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">入金番号</td>
        <td class="Title_Pink">入金日<br>入力日</td>
        <td class="Title_Pink">得意先コード<br>得意先名</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">巡回担当者</td>
        <td class="Title_Pink">金額</td> 
        <td class="Title_Pink">振込入金額</td> 
        <td class="Title_Pink">手数料</td> 
        <td class="Title_Pink">合計金額</td> 
        <td class="Title_Pink">銀行コード<br>銀行名</td>
        <td class="Title_Pink">支店コード<br>支店名</td>
        <td class="Title_Pink">預金種目<br>口座番号</td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Title_Pink">削除</td>
    </tr>
    {foreach key=i from=$disp_list_data item=item}
    <tr class="Result1">
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right">{$item[1]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}"><a href="./2-2-402.php?payin_id={$item[2]}">{$item[3]}</a></td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{$item[4]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{$item[5]}</td>{/if}
        <td>{if $item[6] != null}{$item[6]}{else}手数料{/if}</td>
        <td>{$item[17]}</td>
        <td align="right"{if $item[7] < 0} style="color: #ff0000;"{/if}>{$item[7]|number_format}</td>
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right"{if $item[9] < 0} style="color: #ff0000;"{/if}>{$item[9]|number_format}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right"{if $item[18] < 0} style="color: #ff0000;"{/if}>{$item[18]|number_format}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right"{if $item[8] < 0} style="color: #ff0000;"{/if}>{$item[8]|number_format}</td>{/if}
        <td>{$item[10]}</td>
        <td>{$item[11]}</td>
        <td>{$item[12]}</td>
        <td>{$item[13]}</td>
        <td>{$item[14]}</td>
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="center">{$item[15]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="center">{$form.form_del_link[$i].html}</td>{/if}
    </tr>
    {/foreach}
    <tr class="Result2" align="right">
        <td></td>
        <td>合計</td>    
        <td></td>    
        <td></td>
        <td></td>
        <td></td>
        <td{if $var.calc_sum < 0} style="color: #ff0000;"{/if}>{$var.calc_sum|number_format}</td>
        <td{if $var.calc_sum_bank < 0} style="color: #ff0000;"{/if}>{$var.calc_sum_bank|number_format}</td>
        <td{if $var.calc_sum_rebate < 0} style="color: #ff0000;"{/if}>{$var.calc_sum_rebate|number_format}</td>
        <td{if $var.calc_sum_amount < 0} style="color: #ff0000;"{/if}>{$var.calc_sum_amount|number_format}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

</table>
{$var.html_page2}

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
