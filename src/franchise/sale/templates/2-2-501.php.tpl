{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

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
<ul style="margin-left: 16px;">
{if $form.form_input_day.error != null}
    <li>{$form.form_input_day.error}
{/if}
{if $form.form_balance_this.error != null}
    <li>{$form.form_balance_this.error}
{/if}
</ul>
</span>

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
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
        <td class="Title_Pink">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
*}
    {* 1���� *}
    <tr>
        <td class="Title_Pink">�оݷ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_input_day.html}</td>
        <td class="Title_Pink">ɽ�����</td>
        <td class="Value">{$form.form_display_num.html}</td>
    </tr>

    {* 2���� *}
    <tr>
{if $var.trade_div == "sale"}
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC�������{else}������{/if}</td>
        <td class="Value" colspan="3">
            {$form.form_client_cd.html}&nbsp;{$form.form_client_name.html}
            {* �������̤ξ�硢FC�������Υ��쥯�ȥܥå�����ɽ�� *}
            {if $smarty.session.group_kind == "1"}
            <br>{$form.form_rank.html}
            {/if}
        </td>
    {* FC���̤ξ��ϥ��롼�פǸ�����ǽ *}
    {if $smarty.session.group_kind != "1"}
    </tr>
    {* 2.5���� *}
    <tr>
        <td class="Title_Pink">���롼��</td>
        <td class="Value" colspan="3">{$form.form_client_gr_name.html}&nbsp;{$form.form_client_gr.html}</td>
    {/if}
{else}
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC�������{else}������{/if}</td>
        <td class="Value" colspan="3">
            {$form.form_client_cd.html}&nbsp;{$form.form_client_name.html}
            {* �������̤ξ�硢FC�������Υ��쥯�ȥܥå�����ɽ�� *}
            {if $smarty.session.group_kind == "1"}
            <br>{$form.form_rank.html}
            {/if}
        </td>
{/if}
    </tr>

    {* 3���� *}
    <tr>
        <td class="Title_Pink">����{if $var.trade_div == "sale"}��{else}��{/if}�ݻĹ�<br>(�ǹ�)</td>
        <td class="Value">{$form.form_balance_this.html}<br>{$form.form_balance_radio.html}<br></td>
        <td class="Title_Pink">�������</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>

{if $var.trade_div == "buy" && $var.group_kind == "1"}
    {* 3.5���� *}
    <tr>
        <td class="Title_Pink">FC��������ʬ</td>
        <td class="Value" colspan="3">{$form.form_supplier_div.html}</td>
    </tr>
{/if}

    {* �����ʬ *}
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value" colspan="3">{$form.form_trade.html}</td>
    </tr>

</table>

<table width="100%">
    <tr>
        <td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_display_button.html}����{$form.form_clear_button.html}</td>
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
{if $var.err_flg != true}

<table width="100%">
    <tr>
        <td>

{* POST���ʤ��ʽ��ɽ�����ˤϲ���ɽ�����ʤ� *}
{if $smarty.post != null}

<span style="font: bold 15px; color: #555555;">���оݷ{$var.input_day}��</span><br>
{$var.html_page}

{* ��̤�0��ξ��Ϸ�̥ơ��֥롢�����������ɽ�����ʤ� *}
{if $var.data_list_count != 0}

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{if $smarty.session.group_kind == "1"}FC�������{elseif $var.trade_div == "sale"}������{else}������{/if}</td>
        <td class="Title_Pink">����{if $var.trade_div == "sale"}��{else}��{/if}�ݻĹ�</td>
        <td class="Title_Pink">����{if $var.trade_div == "sale"}���{else}����{/if}��</td>
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">����{if $var.trade_div == "sale"}���{else}����{/if}��(�ǹ�)</td>
        <td class="Title_Pink">����{if $var.trade_div == "sale"}����{else}��ʧ{/if}��</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">Ĵ����</td>
        <td class="Title_Pink">����Ĺ�</td>
        {* <td class="Title_Pink">���۳�</td> *}
        <td class="Title_Pink">����{if $var.trade_div == "sale"}��{else}��{/if}�ݻĹ�</td>
{*
    {if $var.group_kind == 1}
        <td class="Title_Pink">SV<br>���ô��1</td>
    {else}
        <td class="Title_Pink">����ô����1<br>���ô����1</td>
    {/if}
*}
    </tr>

    <tr class="Result3" align="center" height="30px">
        <td>���</td>
        <td>{if $var.data_list_count != null}{$var.data_list_count}��{/if}</td>
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
        <td>���</td>
        <td>{if $var.data_list_count != null}{$var.data_list_count}��{/if}</td>
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

{/if}{* ��̤�0�狼Ƚ�ꤪ��� *}

{/if}{* POST���ʤ���Ƚ�ꤪ��� *}

        </td>
    </tr>
</table>

{/if}
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
