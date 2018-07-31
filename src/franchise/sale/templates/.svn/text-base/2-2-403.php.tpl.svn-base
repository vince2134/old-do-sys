{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
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
{if $form.form_collect_staff.error != null}
    <li>{$form.form_collect_staff.error}<br>
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}<br>
{/if}
{if $form.form_payin_day.error != null}
    <li>{$form.form_payin_day.error}<br>
{/if}
{if $form.form_input_day.error != null}
    <li>{$form.form_input_day.error}<br>
{/if}
{if $form.form_payin_no.error != null}
    <li>{$form.form_payin_no.error}<br>
{/if}
{if $form.form_sum_amount.error != null}
    <li>{$form.form_sum_amount.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>    
        <td>{$html.html_s}</td>
    </tr>   
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_payin_day"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_input_day"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_collect_staff"}</td>
        {if $var.group_kind == "2"}
        <td class="Title_Act">
            {Make_Sort_Link_Tpl form=$form f_name="sl_act_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_act_client_name"}<br>
        </td>
        {/if}
        <td class="Title_Pink">金額</td> 
        <td class="Title_Pink">振込入金額</td> 
        <td class="Title_Pink">手数料</td> 
        <td class="Title_Pink">合計金額</td> 
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_name"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_name"}<br>
        </td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_deposit_kind"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_account_no"}<br>
        </td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Title_Pink">削除</td>
    </tr>
    <tr class="Result3" align="right" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {if $var.group_kind == "2"}<td></td>{/if}
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
    {foreach key=i from=$disp_list_data item=item}
    {if bcmod($item[1], 2) == 0}
    <tr class="Result2">
    {else}  
    <tr class="Result1">
    {/if}  
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right">{$item[1]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="center"><a href="./{if $item[20] == "1"}2-2-402{else}2-2-405{/if}.php?payin_id={$item[2]}">{$item[3]}</a></td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="center">{$item[4]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{$item[5]}</td>{/if}
        <td>{if $item[6] != null}{$item[6]}{else}手数料{/if}</td>
        <td>{$item[17]}</td>
        {if $var.group_kind == "2"}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{if $item[19] != "-<br>"}{$item[19]}{/if}</td>{/if}
        {/if}
        <td align="right"{if $item[7] < 0} style="color: #ff0000;"{/if}>{$item[7]|number_format}</td>
        <td align="right"{if $item[9] < 0} style="color: #ff0000;"{/if}>{$item[9]|number_format}</td>
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
    <tr class="Result3" align="right" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {if $var.group_kind == "2"}<td></td>{/if}
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
