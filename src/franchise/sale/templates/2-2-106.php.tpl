{$var.html_header}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
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

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="960">
    <tr>
        <td>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{* ���������λ��å����� *}
{if $var.lump_change_comp_mess != null}
    <li>{$var.lump_change_comp_mess}
{/if}
{* �����λ��å����� *}
{if $var.del_comp_mess != null}
    <li>{$var.del_comp_mess}
{/if}
{* ���괰λ��å����� *}
{if $var.confirm_comp_mess != null}
    <li>{$var.confirm_comp_mess}
{/if}
{* ���λ��å����� *}
{if $var.repo_comp_mess != null}
    <li>{$var.repo_comp_mess}
{/if}
{* ��ǧ��λ��å����� *}
{if $var.accept_comp_mess != null}
    <li>{$var.accept_comp_mess}
{/if}
</span>

{* ���顼��å����� *}
<span style="font: bold; color: #ff0000;">
    <ul style="margin-left: 16px;">

{*--- ����������������顼 ---*}
{* ͽ���������顼 *}
{if $form.form_lump_change_date.error != null}
    <li>{$form.form_lump_change_date.error}
{/if}

{*--- ������������顼 ---*}
{* ���������Ʊ���¹ԥ��顼 *}
{if $form.del_err_mess.error != null}
    <li>{$form.del_err_mess.error}
{/if}
{* ��������Ҹ˻���ʤ����顼 *}
{if $form.back_ware[$var.del_line].error != null}
    <li>{$form.back_ware[$var.del_line].error}
{/if}

{*--- ������������顼 ---*}
{* ��������δ��˳��ꥨ�顼 *}
{if $var.confirm_err != null}
    <li>{$var.confirm_err}<br>
    {foreach from=$var.ary_err_confirm         key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ��������δ��˺�����顼 *}
{if $var.del_err != null}
    <li>{$var.del_err}<br>
    {foreach from=$var.ary_err_del             key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ���� *}
    {foreach from=$var.del_no                  key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ�������η�������顼 *}
{if $var.deli_day_renew_err != null}
    <li>{$var.deli_day_renew_err}<br>
    {foreach from=$var.ary_err_deli_day_renew  key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ�������Υ����ƥ೫�������顼 *}
{if $var.deli_day_start_err != null}
    <li>{$var.deli_day_start_err}<br>
    {foreach from=$var.ary_err_deli_day_start  key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �������η�������顼 *}
{if $var.claim_day_renew_err != null}
    <li>{$var.claim_day_renew_err}<br>
    {foreach from=$var.ary_err_claim_day_renew key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �������Υ����ƥ೫�������顼 *}
{if $var.deli_day_start_err != null}
    <li>{$var.deli_day_start_err}<br>
    {foreach from=$var.ary_err_deli_day_start  key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ���������������������顼 *}
{if $var.claim_day_bill_err != null}
    <li>{$var.claim_day_bill_err}<br>
    {foreach from=$var.ary_err_claim_day_bill  key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ���� *}
    {foreach from=$var.claim_day_bill_no       key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �Ҳ�����������������顼 *}
{if $var.buy_err_mess1 != null}
    <li>{$var.buy_err_mess1}<br>
    {foreach from=$var.ary_err_buy1            key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �Ҳ������������������顼 *}
{if $var.buy_err_mess2 != null}
    <li>{$var.buy_err_mess2}<br>
    {foreach from=$var.ary_err_buy2            key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �Ҳ��������������顼 *}
{if $var.buy_err_mess3 != null}
    <li>{$var.buy_err_mess3}<br>
    {foreach from=$var.ary_err_buy3            key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �����ֹ��ʣ���顼 *}
{if $var.error_pay_no != null}
    <li>{$var.error_pay_no}<br>
    {foreach from=$var.ary_err_pay_no          key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* �Ҳ��������ֹ��ʣ���顼 *}
{if $var.error_buy_no != null}
    <li>{$var.error_buy_no}<br>
    {foreach from=$var.ary_err_buy_no          key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}

{*--- �����������顼 ---*}
{* �������δ�����𥨥顼 *}
{if $var.trust_confirm_err != null}
    <li>{$var.trust_confirm_err}<br>
    {foreach from=$var.trust_confirm_no        key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ��������������η�������顼 *}
{if $var.ord_time_itaku_err != null}
    <li>{$var.ord_time_itaku_err}<br>
    {foreach from=$var.ord_time_itaku_no       key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ�������Υ����ƥ೫�������顼 *}
{if $var.ord_time_start_err != null}
    <li>{$var.ord_time_start_err}<br>
    {foreach from=$var.ord_time_start_no       key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ����������ʬ�η�������顼 *}
{if $var.ord_time_err != null}
    <li>{$var.ord_time_err}<br>
    {foreach from=$var.ord_time_err            key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ��ɼ�ֹ��ʣ�ʼ��������������˥��顼 *}
{if $var.error_sale != null}
    <li>{$var.error_sale}<br>
    {foreach from=$var.err_sale_no             key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}

{*--- ��ǧ���������顼 ---*}
{* ��𤵤줿����饤����Ԥΰ�����δ��˼�å��顼 *}
{if $var.cancel_err != null}
    <li>{$var.cancel_err}
{/if}
{* �����or�Ҳ����λ����ֹ��ʣ���顼 *}
{if $var.error_buy != null}
    <li>{$var.error_buy}
{/if}
{* �����ֹ��ʣ���顼 *}
{if $var.error_payin != null}
    <li>{$var.error_payin}
{/if}
{* ���������������� *}
{if $var.deli_day_act_renew_err != null}
    <li>{$var.deli_day_act_renew_err}
{/if}
{* ��������������������� *}
{if $var.pay_day_act_err != null}
    <li>{$var.pay_day_act_err}
{/if}
{* �Ҳ�������������� *}
{if $var.deli_day_intro_renew_err != null}
    <li>{$var.deli_day_intro_renew_err}
{/if}
{* �Ҳ������������������� *}
{if $var.pay_day_intro_renew_err != null}
    <li>{$var.pay_day_intro_renew_err}
{/if}


{* �Ҳ���������������������顼 *}
{*
{if $var.buy_err_mess != null}
    <li>{$var.buy_err_mess}
{/if}
*}


{*--- �������顼 ---*}
{* �����ʬ�����⥨�顼 *}
{if $var.err_trade_advance_msg != null}
    <li>{$var.err_trade_advance_msg}<br>
    {* ����� *}
    {foreach from=$var.ary_err_trade_advance key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ��ǧ�� *}
    {foreach from=$var.ary_trade_advance_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ͽ��������̤��ξ��Υ��顼 *}
{if $var.err_future_date_msg != null}
    <li>{$var.err_future_date_msg}<br>
    {* ����� *}
    {foreach from=$var.ary_err_future_date key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ��ǧ�������� *}
    {foreach from=$var.ary_future_date_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ̤�������������ɼ�����륨�顼 *}
{if $var.err_advance_fix_msg != null}
    <li>{$var.err_advance_fix_msg}<br>
    {* ����� *}
    {foreach from=$var.ary_err_advance_fix key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ��ǧ�� *}
    {foreach from=$var.ary_advance_fix_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ������Ĺ���­���顼 *}
{if $var.err_paucity_advance_msg != null}
    <li>{$var.err_paucity_advance_msg}<br>
    {* ����� *}
    {foreach from=$var.ary_err_paucity_advance key=i item=slip_no}����{$slip_no}<br>{/foreach}
    {* ��ǧ�� *}
    {foreach from=$var.ary_paucity_advance_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{* ���������ͽ������ != ���������顼 *}
{* �����Ǥϥ����å��ʤ��ʼ����褬ͽ���������ѹ������顢��������Ʊ�������ͤù���Ǥޤ���
{if $var.err_day_advance_msg != null}
    <li>{$var.err_day_advance_msg}
{/if}
*}

</span>

{* ����ͽ��в٤��Ƥʤ��ٹ� *}
{* rev.1.3 ͽ��������2����ʾ�Υ��Ƥ���ٹ��ɲ� *}
{* {if $var.move_warning != null} *}
{if $var.move_warning != null || $var.warn_lump_change != null}
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[�ٹ�]<br>
	{if $var.move_warning != null}
    {$var.move_warning}</font><br>
    {$form.form_confirm_warn.html}<br><br>
	{/if}
	{if $var.warn_lump_change != null}
    {$var.warn_lump_change}</font><br>
    {$form.form_lump_change_warn.html}<br><br>
	{/if}
    </td></tr>
</table>
{/if}


{* ͽ��ǡ����������0��ˤʤä���硢���ܥ���ɽ�� *}
{if $var.modoru_disp_flg == true}
    {$form.modoru.html}

{* 0�露��ʤ����ϰ�������ե������ɽ�� *}
{else}
<table width="550">
    <tr>
        <td width="260">
            <table class="List_Table" width="250">
                <tr class="Result1">
                    <td class="Title_Pink" width="100" align="center"><b>ͽ������</b></td>
                    <td>{$form.form_lump_change_date.html}</td>
                </tr>
            </table>
        </td>
        <td width="290" align="left">
            {$form.btn_lump_change.html}
        </td>
    </tr>
    <tr>
        <td align="left" width="" colspan="2">
            <b><font color="blue">
                <li>���ꤷ�����դ� ͽ������ �� ������ �����������ޤ���
                <li>��������� ���̤���ꡢ�ޤ��� ����饤����Ԥ�̤��� ��ͽ��ǡ������оݤǤ���
            </font></b>
        </td>
    </tr>
</table>
<br>
{/if}


{* ��ɼ���Ȥ�ɽ�� *}
{foreach from=$h_data_list key=i item=item}
<fieldset width="100%">
<legend><span style="font: bold 15px; color: #555555;">
    ����ɼ�ֹ桡{if $h_data_list[$i][0][0] != NULL}{$h_data_list[$i][0][0]}{else}��������{/if}��
</span></legend>
<br>
<table class="List_Table" border="1" width="400">
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>��Զ�ʬ</b></td>
        <td >{if $h_data_list[$i][0][20] == "1"}���ҽ��{elseif $h_data_list[$i][0][20] == "2"}����饤�����{else}���ե饤�����{/if}</td>
    </tr>
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>�����</b></td>
        <td >{$h_data_list[$i][0][34]}</td>
    </tr>
</table>
<br>
<table class="List_Table" border="1" width="100%">
{* <table class="List_Table" border="1"> *}
    {*--- 1���� ��������Υإå� ---*}
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">ͽ������</td>
        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind != "2"}<td class="Title_Pink">��ϩ</td>{/if}
        <td class="Title_Pink">������̾</td>
        <td class="Title_Pink">�����ʬ</td>
        {* FC¦����ԤǤϡ�����������ɽ�� *}
        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind == "2"}
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">������</td>
        {/if}
        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind != "2"}<td class="Title_Pink">���ô��������</td>{/if}
    </tr>

    {*--- 2���� ��������Υǡ��� ---*}
    <tr class="{$h_data_list[$i][0][23]}">
        <td align="center">{$h_data_list[$i][0][1]}</td>
        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind != "2"}<td align="center">{$h_data_list[$i][0][2]}</td>{/if}
        <td>{$h_data_list[$i][0][3]}-{$h_data_list[$i][0][4]}<br>{$h_data_list[$i][0][5]}</td>
        <td align="center">{$h_data_list[$i][0][6]}</td>
        {* FC¦����ԤǤϡ�����������ɽ�� *}
        {if $h_data_list[$i][0][20] == '1' || $smarty.session.group_kind == '2'}
        <td align="center">{$h_data_list[$i][0][8]}</td>
        <td align="left">{$h_data_list[$i][0][33]}<br>{$h_data_list[$i][0][32]}</td>
        {/if}
        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind != "2"}
        <td>{$h_data_list[$i][0][9]}{$h_data_list[$i][0][10]}{$h_data_list[$i][0][11]}{$h_data_list[$i][0][12]}</td>
        {/if}
    </tr>

    {*--- 3���� ľ���� ---*}
    {* ͽ����Ǻ�ä���ɼ�ξ�硢ľ�����ɽ�� *}
    {if $h_data_list[$i][0][40] == "t"}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" align="center"><b>ľ����</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="left" colspan="6">{else}<td align="left" colspan="4">{/if}
        {if $h_data_list[$i][0][41] != null}{$h_data_list[$i][0][42]}��{$h_data_list[$i][0][43]}�������衧{$h_data_list[$i][0][44]}{/if}
        </td>
    </tr>
    {/if}

    {*--- 4���� �Ҳ���� ---*}
    {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind == "2"}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" align="center"><b>�Ҳ������</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="left" colspan="3">{else}<td align="left" colspan="2">{/if}
        {if $h_data_list[$i][0][26] != null}{$h_data_list[$i][0][27]}<br>{$h_data_list[$i][0][29]}{else}̵��{/if}
        </td>
        <td class="Title_Pink" width="100" align="center"><b>�Ҳ������<br>(��ȴ)</b></td>
        {if $h_data_list[$i][0][20] == "1"}
            {if $h_data_list[$i][0][30] == "1"}<td align="left" colspan="2">ȯ�����ʤ�{else}<td align="right" colspan="2">{$h_data_list[$i][0][31]}{/if}
        {else}
            {if $h_data_list[$i][0][30] == "1"}<td align="left">ȯ�����ʤ�{else}<td align="right">{$h_data_list[$i][0][31]}{/if}
        {/if}
        </td>
    </tr>
    {/if}

    {*--- 5���� ����� ---*}
    {if $h_data_list[$i][0][20] != "1"}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>�����</b></td>
        <td align="left" colspan="2">{$h_data_list[$i][0][35]}</td>
        <td class="Title_Pink" width="100" align="center"><b>��԰�����<br>(��ȴ)</b></td>
        {if $h_data_list[$i][0][36] == "ȯ�����ʤ�"}<td align="left">{else}<td align="right">{/if}{$h_data_list[$i][0][36]}</td>
    </tr>
    {/if}

    {*--- 6���� ���� ---*}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>����</b></td>
        {if $h_data_list[$i][0][20] == "1"}
        {* �̾� *}
        <td colspan="3">{$h_data_list[$i][0][24]}</td>
        {elseif $smarty.session.group_kind == "2"}
        {* ľ�Ĥ���� *}
        <td colspan="2">{$h_data_list[$i][0][24]}</td>
        {else}
        {* FC¦����� *}
        <td colspan="2">{$h_data_list[$i][0][25]}</td>
        {/if}
        <td class="Title_Pink" width="100" align="center"><b>������ͳ</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td colspan="2">{else}<td>{/if}{$h_data_list[$i][0][15]}</td>
    </tr>

    {*--- 7���� ��ɼ��� ---*}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>��ȴ���<br>������</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="right" colspan="3">{else}<td align="right" colspan="2">{/if}
            {$h_data_list[$i][0][13]}<br>{$h_data_list[$i][0][14]}
        </td>
        <td class="Title_Pink" width="100" align="center"><b>��ɼ���</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="right" colspan="2">{else}<td align="right" colspan="1">{/if}
            {$h_data_list[$i][0][22]}
        </td>
    </tr>

    {*--- 8���� ���� ---*}
    {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind == "2"}
    <tr class="{$h_data_list[$i][0][23]}">
        <td class="Title_Pink" width="100" align="center"><b>������Ĺ�</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="right" colspan="3">{else}<td align="right" colspan="2">{/if}
            {$h_data_list[$i][0][45]}
        </td>
        <td class="Title_Pink" width="100" align="center"><b>�����껦�۹��</b></td>
        {if $h_data_list[$i][0][20] == "1"}<td align="right" colspan="2">{else}<td align="right" colspan="1">{/if}
            {$h_data_list[$i][0][46]}
        </td>
    </tr>
    {/if}

</table>
<br>

<table class="List_Table" border="1" width="100%">
{*
<col width="30">
<col width="60">
<col width="*">
<col width="*">
<col width="30">
<col width="70">
<col width="70">
<col width="*">
<col width="30">
<col width="*">
<col width="30">
<col width="*">
*}
{* <col width="30"> *}
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Title_Pink">�����ӥ�̾</td>
        <td class="Title_Pink">�����ƥ�</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">�Ķȸ���<br>���ñ��</td>
        <td class="Title_Pink">������׳�<br>����׳�</td>
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">���ξ���</td>
        <td class="Title_Pink">����</td>
    {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind == "2"}
        <td class="Title_Pink">������<br>(����ñ��)</td>
        <td class="Title_Pink">�����껦��</td>
    {/if}
        {* <td class="Title_Pink">����</td> *}
    </tr>

    {* ��ɼ�ǡ�����ɽ�� *}
    {foreach from=$data_list[$i] key=j item=item}
    {* aoyama-n 2009-09-18 *}
    {if $data_list[$i][$j][27] === "t" }
    <tr class="{$data_list[$i][$j][19]}" style="color: red">
    {else}
    <tr class="{$data_list[$i][$j][19]}">
    {/if}
        <td align="right">{$j+1}</td>
        {* �����ʬ *}
        <td align="center" nowrap>{$data_list[$i][$j][0]}</td>
        {* �����ӥ� *}
        <td valign="top" nowrap>{$data_list[$i][$j][1]}��{$data_list[$i][$j][2]}<br>����{$data_list[$i][$j][3]}</td>
        {* �����ƥ� *}
        <td valign="top" nowrap>{$data_list[$i][$j][4]}��{$data_list[$i][$j][5]}<br>����{$data_list[$i][$j][22]}<br>����{$data_list[$i][$j][6]}</td>
        {* ���� *}
        {if $data_list[$i][$j][7] == 't' && $data_list[$i][$j][8] != NULL}
        <td align="center" nowrap>
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <tr><td align="center">�켰</td></tr>
                <tr><td align="right">{$data_list[$i][$j][8]}</td></tr>
            </table>
        </td>
        {elseif $data_list[$i][$j][7] == 't' && $data_list[$i][$j][8] == NULL}
        <td align="center">�켰</td>
        {elseif $data_list[$i][$j][7] != 't' && $data_list[$i][$j][8] != NULL}
        <td align="right">{$data_list[$i][$j][8]}</td>
        {/if}

        {* �Ķȸ��������ñ�� *}
        <td align="right" nowrap>{$data_list[$i][$j][20]}<br>{$data_list[$i][$j][9]}</td>
        {* ������ס������ *}
        <td align="right" nowrap>{$data_list[$i][$j][21]}<br>{$data_list[$i][$j][10]}</td>
        {* ������ *}
        <td >{$data_list[$i][$j][11]}<br>{$data_list[$i][$j][12]}</td>
        <td align="right" nowrap>{$data_list[$i][$j][13]}</td>
        {* ���ξ��� *}
        <td >{$data_list[$i][$j][14]}<br>{$data_list[$i][$j][15]}</td>
        <td align="right" nowrap>{$data_list[$i][$j][16]}</td>

        {if $h_data_list[$i][0][20] == "1" || $smarty.session.group_kind == "2"}
        {* �Ҳ������(����ñ��) *}
        <td align="left" nowrap>
        {* �Ҳ���¤����������ɽ�� *}
            {if $h_data_list[$i][0][26] != null}
            <table width="100%">
                {if $data_list[$i][$j][23] != null}
                <tr><td><font color="#555555">�����</font></td><td align="right"><font color="#555555">{$data_list[$i][$j][23]}</font></td></tr>
                {elseif $data_list[$i][$j][24] != null}
                <tr><td><font color="#555555">����</font></td><td align="right"><font color="#555555">{$data_list[$i][$j][24]}&nbsp;��</font></td></tr>
                {else}
                {* <tr><td><font color="#555555">�ʤ�</font></td></tr> *}
                <tr><td></td></tr>
                {/if}
            </table>
            {/if}

        {* �����껦�� *}
        <td align="right" nowrap>
            {if $data_list[$i][$j][25] == "2"}{$data_list[$i][$j][26]}{/if}
        </td>

        {/if}

        {* ���������Ϥ���Ƥ������˥�󥯤�ɽ�� *}
{*
        {if $data_list[$i][$j][22] == true}
            <td align="center" ><a href="#" onClick="Open_mlessDialmg_g('../system/2-1-116.php',{$data_list[$i][$j][17]},{$data_list[$i][$j][18]},670,470,'sale');">����</a></td>
        {else}
            <td align="center" >��</td>
        {/if}
*}
    </tr>
    {/foreach}

</table>
<br>
<table border="0" width="100%" style="color: #555555;">
    {if $form.back_ware[$i].html != null}
    <tr>
        <td align="left" colspan="2">
            <ul style="color: #0000ff; font-weight: bold; line-height: 130%; margin-left: 16px; margin-top: 0px; margin-bottom: 0px;">
                <li>����ͽ��в٤Ǻ߸˰�ư�Ѥߤ���ɼ����������ϡ�<br>���ʤ��᤹�Ҹˤ���ꤷ�Ƥ���������
            </ul>
        </td>
    </tr>
    {/if}
    <tr>
        <td align="left">
            {* �߸ˤ�ɤ����᤹�����쥯�� *}
            {if $form.back_ware[$i].html != null}�߸��ֵ��Ҹˡ�{$form.back_ware[$i].html}{/if}
            {* ����ܥ��� *}
            {if $form.slip_del[$i].html != null}{$form.slip_del[$i].html}{/if}
        </td>
        <td align="right">
            {if $form.confirm[$i].html != null}{$form.confirm[$i].html}��{* ����ܥ��� *}
            {elseif $form.report[$i].html != null}{$form.report[$i].html}��{* ���ܥ��� *}
            {elseif $form.accept[$i].html != null}{$form.accept[$i].html}��{* ��ǧ�ܥ��� *}
            {/if}
            {$form.slip_change[$i].html}��{$form.con_change[$i].html}��{$form.modoru.html}
        </td>
    </tr>
</table>
</fieldset>
<br><br><br>
{/foreach}

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