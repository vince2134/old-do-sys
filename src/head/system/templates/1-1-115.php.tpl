{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
</script>

<body bgcolor="#D8D0C8" onLoad="{$var.onload};">
<form {$form.attributes}>

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
{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_area_id.error != null}
        <li>{$form.form_area_id.error}<br>
    {/if}
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_shop_gr_1.error != null}
        <li>{$form.form_shop_gr_1.error}<br>
    {/if}
    {if $var.client_cd_err != null}
        <li>{$var.client_cd_err}<br>
    {/if}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_client_name.error != null}
        <li>{$form.form_client_name.error}<br>
    {/if}
    {if $form.form_client_cname.error != null}
        <li>{$form.form_client_cname.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_capital.error != null}
        <li>{$form.form_capital.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error != null}<br>
    {elseif $var.tel_err != null}
        <li>{$var.tel_err}<br>
    {/if}
    {if $form.form_fax.error != null}
        <li>{$form.form_fax.error}<br>
    {/if}
    {if $var.email_err != null}
        <li>{$var.email_err}<br>
    {/if}
    {if $var.url_err != null}
        <li>{$var.url_err}<br>
    {/if}
    {if $form.form_company_tel.error != null}
        <li>{$form.form_company_tel.error}<br>
    {/if}
    {if $form.form_rep_name.error != null}
        <li>{$form.form_rep_name.error}<br>
    {/if}
    {if $var.rep_cell_err != null}
        <li>{$var.rep_cell_err}<br>
    {/if}
    {if $form.form_trade_stime1.error != null || 
        $form.form_trade_etime1.error != null || 
        $form.form_trade_stime2.error != null || 
        $form.form_trade_etime2.error != null}
        <li>�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���<br>
    {/if}
    {if $var.claim_err != null}
        <li>{$var.claim_err}<br>
    {/if}
    {if $form.form_cledit_limit.error != null}
        <li>{$form.form_cledit_limit.error}<br>
    {/if}
    {if $var.close_err != null}
        <li>{$var.close_err}<br>
    {/if}
    {if $form.form_pay_m.error != null}
        <li>{$form.form_pay_m.error}<br>
    {/if}
    {if $form.form_pay_d.error != null}
        <li>{$form.form_pay_d.error}<bt>
    {/if}
    {if $form.form_cont_s_day.error != null}
        <li>{$form.form_cont_s_day.error}<br>
    {elseif $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    {if $form.form_cont_peri.error != null}
        <li>{$form.form_cont_peri.error}<br>
    {/if}
    {if $form.form_cont_r_day.error != null}
        <li>{$form.form_cont_r_day.error}<br>
    {elseif $var.rday_err != null}
        <li>{$var.rday_err}<br>
    {elseif $var.sday_rday_err != null}
        <li>{$var.sday_rday_err}<br>
    {/if}
    {if $form.form_establish_day.error != null}
        <li>{$form.form_establish_day.error}<br>
    {elseif $var.esday_err != null}
        <li>{$var.esday_err}<br>
    {/if}
    {if $form.form_deliver_note.error != null}
        <li>{$form.form_deliver_note.error}<br>
    {/if}
    {if $var.intro_act_err != null}
        <li>{$var.intro_act_err}<br>
    {/if}
    {if $form.form_account.error != null}
        <li>{$form.form_account.error}<br>
    {/if}
    {if $form.form_cshop.error != null}
        <li>{$form.form_cshop.error}<br>
    {/if}
    {if $form.form_round_start.error != null}
        <li>{$form.form_round_start.error}<br>
    {elseif $var.rsday_err != null}
        <li>{$var.rsday_err}<br>
    {/if}
	{if $var.parent_esday_err != null}
        <li>{$var.parent_esday_err}<br>
    {/if}
	{if $var.cont_e_day_err != null}
        <li>{$var.cont_e_day_err}<br>
    {/if}
	{if $var.claim_coax_err != null}
        <li>{$var.claim_coax_err}<br>
    {/if}
	{if $var.claim_tax_div_err != null}
        <li>{$var.claim_tax_div_err}<br>
    {/if}
	{if $var.claim_tax_franct_err != null}
        <li>{$var.claim_tax_franct_err}<br>
    {/if}
	{if $var.claim_c_tax_div_err != null}
        <li>{$var.claim_c_tax_div_err}<br>
    {/if}
    </span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table width="810">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td>{$form.button.list_confirm_button.html}</td>
        <td align="right">
            {if $smarty.get.client_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403" height="32">
                <tr>
                    <td class="Type" width="60" align="center"><b>����å� ����</b></td>
                    <td class="Value" width="*">{$form.form_state_fc.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403" height="32">
                <tr>
                    <td class="Title_Purple" width="60"><b>����å�</b></td>
                    <td class="Value" width="*">{$form.form_fc.html}  {$form.form_fc_name.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403" height="32">
                <tr>
                    <td class="Type" width="60" align="center"><b>������<br>����</b></td>
                    <td class="Value" width="*">{$form.form_state.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403" height="32">
                <tr>
                <td class="Title_Purple" width="60"><b>���롼��</b></td>
                <td class="Value">{$form.form_client_gr.html}{$form.form_parents_div.html}</td>
{*                  <td class="Type" width="70" align="center"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_type.html}</td>*}
                </tr>
            </table>
        </td>
       </tr>   
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>�϶�<font color="#ff0000">��</font></b></td>
                    <td class="Value" width="*">{$form.form_area_id.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>�ȼ�<font color="#ff0000">��</font></b></td>
                    <td class="Value" width="*">{$form.form_btype.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_inst.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_bstruct.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<div align="right"><b><font color="#3300ff">��������̾����ɼ�������ʤ����ϡ�������̾�α����Υ����å����դ��Ʋ�������</font></b></div>

<table>
<tr>
    <td>
    <table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
    <col width="150" style="font-weight: bold;">
    <col width="240">
    <col width="150" style="font-weight: bold;">
    <col width="255">
        <tr>
            <td class="Title_Purple">�����襳����<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_client.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple"><b>������̾1<font color="#ff0000">��</font></b>��{$form.form_client_slip1.html}</td>
            <td class="Value">{$form.form_client_name.html}
            <td class="Title_Purple"><b>������̾1<br>(�եꥬ��)</b></td>
            <td class="Value">{$form.form_client_read.html}</td>
        </tr>
       
        <tr>
            <td class="Title_Purple"><b>������̾2</b>����{$form.form_client_slip2.html}</td>
            <td class="Value">{$form.form_client_name2.html}
            <td class="Title_Purple"><b>������̾2<br>(�եꥬ��)</b></td>
            <td class="Value">{$form.form_client_read2.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_client_cname.html}</td>
            <td class="Title_Purple">ά��<br>(�եꥬ��)</td>
            <td class="Value">{$form.form_cname_read.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�ɾ�</td>
            <td class="Value" colspan="3">{$form.form_prefix.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">��ɽ�Ի�̾<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_rep_name.html}</td>
            <td class="Title_Purple">��ɽ����</td>
            <td class="Value">{$form.form_rep_position.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">͹���ֹ�<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_post.html}����{$form.button.input_button.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">����1<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_address1.html}</td>
            <td class="Title_Purple">����2</td>
            <td class="Value">{$form.form_address2.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">����3<br>(�ӥ�̾��¾)</td>
            <td class="Value">{$form.form_address3.html}</td>
            <td class="Title_Purple">����2<br>(�եꥬ��)</td>
            <td class="Value">{$form.form_address_read.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">TEL<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_tel.html}</td>
            <td class="Title_Purple">FAX</td>
            <td class="Value">{$form.form_fax.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�϶���</td>
            <td class="Value">{$form.form_establish_day.html}</td>
            <td class="Title_Purple">ô��Email</td>
            <td class="Value">{$form.form_email.html}</td>
        </tr>
    </table>
    </td>
</tr>
<tr>
    <td>
    <table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
    <col width="150" style="font-weight: bold;">
    <col width="240">
    <col width="150" style="font-weight: bold;">
    <col width="255">
        <tr>
            <td class="Title_Parent">�Ʋ��̾</td>
            <td class="Value">{$form.form_company_name.html}</td>
            <td class="Title_Parent">�Ʋ��TEL</td>
            <td class="Value">{$form.form_company_tel.html}</td>
        </tr>
        <tr>        
            <td class="Title_Parent">�Ʋ�ҽ���</td>
            <td class="Value" colspan="3">{$form.form_company_address.html}</td>
        </tr>   
        <tr>
            <td class="Title_Parent">���ܶ�</td>
            <td class="Value">{$form.form_capital.html}����</td>
            <td class="Title_Parent">�Ʋ���϶���</td>
            <td class="Value">{$form.form_parent_establish_day.html}</td>
        </tr>
        <tr>
            <td class="Title_Parent">�Ʋ����ɽ�Ի�̾</td>
            <td class="Value">{$form.form_parent_rep_name.html}</td>
            <td class="Title_Parent">URL</td>
            <td class="Value">{$form.form_url.html}</td>
        </tr>
    </table>
    </td>
</tr>
<tr>
    <td>

    <table class="Data_Table" border="1" width="100%">
    <col width="78" style="font-weight: bold;">
    <col width="21" style="font-weight: bold;">
    <col width="46" style="font-weight: bold;">
    <col width="160">
    <col width="46" style="font-weight: bold;">
    <col width="160">
    <col width="46" style="font-weight: bold;">
    <col width="228">
        <tr>
            <td class="Title_Purple" rowspan="4">ô������</td>
            <td class="Title_Purple" align="center">1</td>
            <td class="Title_Purple">����</td>
            <td class="Value">{$form.form_charger_part1.html}</td>
            <td class="Title_Purple">��</td>
            <td class="Value">{$form.form_charger_represe1.html}</td>
            <td class="Title_Purple">��̾</td>
            <td class="Value">{$form.form_charger1.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" align="center">2</td>
            <td class="Title_Purple">����</td>
            <td class="Value">{$form.form_charger_part2.html}</td>
            <td class="Title_Purple">��</td>
            <td class="Value">{$form.form_charger_represe2.html}</td>
            <td class="Title_Purple">��̾</td>
            <td class="Value">{$form.form_charger2.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" align="center">3</td>
            <td class="Title_Purple">����</td>
            <td class="Value">{$form.form_charger_part3.html}</td>
            <td class="Title_Purple">��</td>
            <td class="Value">{$form.form_charger_represe3.html}</td>
            <td class="Title_Purple">��̾</td>
            <td class="Value">{$form.form_charger3.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">����</td>
            <td class="Value" colspan="5">{$form.form_charger_note.html}</td>
        </td>
    </table>
    </td>
</tr>
<tr>
    <td>
    <table class="Data_Table" border="1" width="100%">
    <col width="64" style="font-weight: bold;">
    <col width="84" style="font-weight: bold;">
    <col width="240">
    <col width="150" style="font-weight: bold;">
    <col width="255">
        <tr>
            <td class="Title_Purple" colspan="2">�ĶȻ���</td>
            <td class="Value">{$form.form_trade_stime1.html} �� {$form.form_trade_etime1.html} <br>{$form.form_trade_stime2.html} �� {$form.form_trade_etime2.html}</td>
            <td class="Title_Purple">����</td>
            <td class="Value">{$form.form_holiday.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">{$form.intro_claim_link.html}</td>
            <td class="Value" colspan="3">{$form.form_claim.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">������2</td>
            <td class="Value" colspan="3">{$form.form_claim2.html}</td>
        </tr>
    <tr>    
        <td class="Title_Purple" colspan="2">�����</td>
        <td class="Value" colspan="3">
        <br>    
        {foreach from=$form.claim1_monthly_check item=item key=i}
            {$form.claim1_monthly_check[$i].html}
        {/foreach}
        </td>   
    </tr>   
        <tr>
            <td class="Title_Purple" colspan="2">Ϳ������</td>
            <td class="Value">{$form.form_cledit_limit.html}����</td>
            <td class="Title_Purple">������</td>
            <td class="Value">{$form.form_col_terms.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">�����ʬ<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.trade_aord_1.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">����<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_close.html}</td>
            <td class="Title_Purple">������<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_pay_m.html}��{$form.form_pay_d.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">������ˡ</td>
            <td class="Value" colspan="3">{$form.form_pay_way.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">������Ը���</td>
            <td class="Value" colspan="3">{$form.form_bank.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">����̾��1</td>
            <td class="Value">{$form.form_pay_name.html}</td>
            <td class="Title_Purple">����̾��2</td>
            <td class="Value">{$form.form_account_name.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">��Լ������ô��ʬ</td>
            <td class="Value" colspan="3">{$form.form_bank_div.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">����ǯ����</td>
            <td class="Value">{$form.form_cont_s_day.html}</td>
            <td class="Title_Purple">���󹹿���</td>
            <td class="Value">{$form.form_cont_r_day.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">�������</td>
            <td class="Value">{$form.form_cont_peri.html}ǯ</td>
            <td class="Title_Purple">����λ��</td>
            <td class="Value">{$form.form_cont_e_day.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" rowspan="3">�����ɼ</td>
            <td class="Title_Purple">ȯ��<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_slip_out.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�ͼ�<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.sale_pattern.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">������</td>
            <td class="Value" colspan="3">{$form.form_deliver_radio.html}<br>{$form.form_deliver_note.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" rowspan="3">�����</td>
            <td class="Title_Purple">ȯ��<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_claim_out.html}</td>
        </tr>
<!--
        <tr>
            <td class="Title_Purple">�����ϰ�<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_claim_scope.html}</td>
        </tr>
-->
        <tr>
            <td class="Title_Purple">����<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_claim_send.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�ͼ�<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.claim_pattern.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">������</td>
            <td class="Value" colspan="4">{$form.form_claim_note.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">���<font color="#ff0000">��</font></td>
            <td class="Title_Purple">�ޤ���ʬ</td>
            <td class="Value" colspan="3">{$form.form_coax.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" rowspan="3">������<font color="#ff0000">��</font></td>
            <td class="Title_Purple">����ñ��</td>
            <td class="Value" colspan="3">{$form.form_tax_div.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">ü����ʬ</td>
            <td class="Value" colspan="3">{$form.form_tax_franct.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">���Ƕ�ʬ</td>
            <td class="Value" colspan="3">{$form.form_c_tax_div.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple" colspan="2">����������������¾</td>
            <td class="Value" colspan="3">{$form.form_note.html}</td>
        </tr>
    </table>
    </td>
</tr>
<tr>
    <td>

    <table class="Data_Table" border="1" width="810">
    <col width="150" style="font-weight: bold;">
    <col width="653">
        <tr>
            <td class="Title_Purple">{$form.intro_act_link.html}</td>
            <td class="Value" colspan="3">{$form.form_client_div.html}��{$form.form_intro_act.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�����������̾</td>
            <td class="Value" colspan="3">{$form.form_trans_account.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">���/��Ź̾</td>
            <td class="Value" colspan="3">{$form.form_bank_fc.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�����ֹ�</td>
            <td class="Value" colspan="3">{$form.form_account_num.html}</td>
        </tr>
{*
        <tr>
            <td class="Title_Purple">���Ҳ���<br>(����̾������)</td>
            <td class="Value" colspan="3">{$form.form_account.html}</td>
        </tr>
*}
    </table>
    </td>
</tr>
<tr>
    <td>
    <table class="Data_Table" border="1" width="810">
    <col width="150" style="font-weight: bold;">
    <col width="240">
    <col width="150" style="font-weight: bold;">
    <col width="257">
        <tr>
            <td class="Title_Purple">ô����Ź<font color="#ff0000">��</font></td>
            <td class="Value" colspan="3">{$form.form_charge_branch_id.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">������ô��</td>
            <td class="Value">{$form.form_c_staff_id1.html}</td>
            <td class="Title_Purple">�������Ұ�</td>
            <td class="Value">{$form.form_c_staff_id2.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">��󳫻���</td>
            <td class="Value" colspan="3">{$form.form_round_start.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">�������</td>
            <td class="Value" colspan="3">{$form.form_record.html}</td>
        </tr>
        <tr>
            <td class="Title_Purple">���׻���</td>
            <td class="Value" colspan="3">{$form.form_important.html}</td>
        </tr>
    </table>
    </td>
</tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">������ɬ�����ϤǤ�</font></b></td>
        <td align="right">
            {$form.button.entry_button.html}����{$form.button.res_button.html}{$form.button.ok_button.html}����{$form.button.back_button.html}
        </td>
    </tr>
</table>

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
