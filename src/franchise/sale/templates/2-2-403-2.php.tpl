{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å����� *}
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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="650">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">���Ϸ���</td>
        <td class="Value">{$form.form_output_type.html}</td>
        <td class="Title_Pink">ɽ�����</td>
        <td class="Value">{$form.form_range_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value" colspan="3">{$form.form_payin_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$form.form_payin_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$form.form_input_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Pink">���ô����</td>
        <td class="Value">{$form.form_collect_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����襳����</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Pink">������̾</td>
        <td class="Value">{$form.form_client_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��ԥ�����</td>
        <td class="Value">{$form.form_bank_cd.html}</td>
        <td class="Title_Pink">���̾</td>
        <td class="Value">{$form.form_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��Ź������</td>
        <td class="Value">{$form.form_b_bank_cd.html}</td>
        <td class="Title_Pink">��Ź̾</td>
        <td class="Value">{$form.form_b_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�¶����</td>
        <td class="Value">{$form.form_deposit_kind.html}</td>
        <td class="Title_Pink"> �����ֹ�</td>
        <td class="Value">{$form.form_account_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��׶��</td>
        <td class="Value">{$form.form_calc_amount.html}</td>
        <td class="Title_Pink">��������</td>
        <td class="Value">{$form.form_daily_renew.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_btn.html}����{$form.form_clear_btn.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Title_Pink">������<br>������</td>
        <td class="Title_Pink">�����襳����<br>������̾</td>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Title_Pink">���ô����</td>
        <td class="Title_Pink">���</td> 
        <td class="Title_Pink">���������</td> 
        <td class="Title_Pink">�����</td> 
        <td class="Title_Pink">��׶��</td> 
        <td class="Title_Pink">��ԥ�����<br>���̾</td>
        <td class="Title_Pink">��Ź������<br>��Ź̾</td>
        <td class="Title_Pink">�¶����<br>�����ֹ�</td>
        <td class="Title_Pink">�������<br>��������ֹ�</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">��������</td>
        <td class="Title_Pink">���</td>
    </tr>
    {foreach key=i from=$disp_list_data item=item}
    <tr class="Result1">
        {if $item[0] != 0}<td rowspan="{$item[0]}" align="right">{$item[1]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}"><a href="./2-2-402.php?payin_id={$item[2]}">{$item[3]}</a></td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{$item[4]}</td>{/if}
        {if $item[0] != 0}<td rowspan="{$item[0]}">{$item[5]}</td>{/if}
        <td>{if $item[6] != null}{$item[6]}{else}�����{/if}</td>
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
        <td>���</td>    
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
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
