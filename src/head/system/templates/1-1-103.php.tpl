{$var.html_header}

<script language="javascript">
{$var.code_value}
{$var.contract}
{$var.rank_name}
 </script>

<body bgcolor="#D8D0C8">
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
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_area_1.error != null}
        <li>{$form.form_area_1.error}<br>
    {/if}
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_shop_gr_1.error != null}
        <li>{$form.form_shop_gr_1.error}<br>
    {/if}
    {if $form.form_rank.error != null}
        <li>{$form.form_rank.error}<br>
    {/if}
    {if $form.form_shop_cd.error != null}
        <li>{$form.form_shop_cd.error}<br>
    {elseif $var.shop_cd_err != null}
        <li>{$var.shop_cd_err}<br>
    {/if}
    {if $form.form_shop_name.error != null}
        <li>{$form.form_shop_name.error}<br>
    {/if}
    {if $form.form_shop_cname.error != null}
        <li>{$form.form_shop_cname.error}<br>
    {/if}
    {if $form.form_comp_name.error != null}
        <li>{$form.form_comp_name.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error}<br>
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
    {if $form.form_represent_name.error != null}
        <li>{$form.form_represent_name.error}<br>
    {/if}
    {if $form.form_represent_cell.error != null}
        <li>{$form.form_represent_cell.error}<br>
    {/if}
    {if $form.form_direct_tel.error != null}
        <li>{$form.form_direct_tel.error}<br>
    {elseif $var.d_tel_err != null}
        <li>{$var.d_tel_err}<br>
    {/if}
    {if $form.form_contact_cell.error != null}
        <li>{$form.form_contact_cell.error}<br>
    {/if}
    {if $form.form_account_tel.error != null}
        <li>{$form.form_account_tel.error}<br>
    {/if}
    {if $form.form_join_money.error != null}
        <li>{$form.form_join_money.error}<br>
    {/if}
    {if $form.form_assure_money.error != null}
        <li>{$form.form_assure_money.error}<br>
    {/if}
    {if $form.form_royalty.error != null}
        <li>{$form.form_royalty.error}<br>
    {/if}
    {if $form.form_accounts_month.error != null}
        <li>{$form.form_accounts_month.error}<br>
    {/if}
    {if $form.form_limit_money.error != null}
        <li>{$form.form_limit_money.error}<br>
    {/if}
    {if $form.trade_aord_1.error != null}
        <li>{$form.trade_aord_1.error}<br>
    {/if}
    {if $form.trade_buy_1.error != null}
        <li>{$form.trade_buy_1.error}<br>
    {/if}
    {if $form.form_capital_money.error != null}
        <li>{$form.form_capital_money.error}<br>
    {/if}
    {if $form.form_close_1.error != null}
        <li>{$form.form_close_1.error}<br>
    {/if}
    {if $form.form_pay_month.error != null}
        <li>{$form.form_pay_month.error}<br>
    {/if}
    {if $form.form_pay_day.error != null}
        <li>{$form.form_pay_day.error}<br>
    {/if}
    {if $form.form_payout_month.error != null}
        <li>{$form.form_payout_month.error}<br>
    {/if}
    {if $form.form_payout_day.error != null}
        <li>{$form.form_payout_day.error}<br>
    {/if}
    {if $form.form_cont_s_day.error != null}
        <li>{$form.form_cont_s_day.error}<br>
    {/if}
    {if $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    {if $form.form_cont_peri.error != null}
        <li>{$form.form_cont_peri.error}<br>
    {/if}
    {if $var.rday_err != null}
        <li>{$var.rday_err}<br>
    {elseif $var.sday_rday_err != null}
        <li>{$var.sday_rday_err}<br>
    {/if}
    {if $form.form_open_day.error != null}
        <li>{$form.form_open_day.error}<br>
    {elseif $var.eday_err != null}
        <li>{$var.eday_err}<br>
    {/if}
    {if $form.form_establish_day.error != null}
        <li>{$form.form_establish_day.error}<br>
    {/if}
    {if $form.form_corpo_day.error != null}
        <li>{$form.form_corpo_day.error}<br>
    {elseif $var.cday_err != null}
        <li>{$var.cday_err}<br>
    {/if}
    {if $form.form_deli_comment.error != null}
        <li>{$form.form_deli_comment.error}<br>
    {/if}
    {if $var.contact_cell_err != null}
        <li>{$var.contact_cell_err}<br>
    {/if}
    {if $var.account_tel_err != null}
        <li>{$var.account_tel_err}<br>
    {/if}
    {if $var.represent_cell_err != null}
        <li>{$var.represent_cell_err}<br>
    {/if}
    {if $var.claim_close_day_err != null}
        <li>{$var.claim_close_day_err}<br>
    {/if}
    {if $var.claim_coax_err != null}
        <li>{$var.claim_coax_err}<br>
    {/if}
    {if $var.claim_err != null}
        <li>{$var.claim_err}<br>
    {/if}
    {if $var.claim_tax_franct_err != null}
        <li>{$var.claim_tax_franct_err}<br>
    {/if}
    {if $var.claim_c_tax_div_err != null}
        <li>{$var.claim_c_tax_div_err}<br>
    {/if}
    {if $var.claim_tax_div_err != null}
        <li>{$var.claim_tax_div_err}<br>
    {/if}
    {if $var.close_day_err != null}
        <li>{$var.close_day_err}<br>
    {/if}
    {if $var.close_outday_err != null}
        <li>{$var.close_outday_err}<br>
    {/if}
    {if $var.shop_name_err != null}
        <li>{$var.shop_name_err}<br>
    {/if}
    {if $var.comp_name1_err != null}
        <li>{$var.comp_name1_err}<br>
    {/if}
    {if $var.comp_name2_err != null}
        <li>{$var.comp_name2_err}<br>
    {/if}
    {if $var.address1_err != null}
        <li>{$var.address1_err}<br>
    {/if}
    {if $var.address2_err != null}
        <li>{$var.address2_err}<br>
    {/if}
    {if $var.address3_err != null}
        <li>{$var.address3_err}<br>
    {/if}
    </span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

{$form.hidden}
<table width="880">
    <tr>
        <td align="right">
            {if $smarty.get.client_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>

<table width="880">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Type" width="60" align="center"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_state.html}</td>
                </tr>
            </table>
        </td>
       </tr>   
</table>

<table width="880">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>�϶�<font color="#ff0000">��</font></b></td>
                    <td class="Value" width="*">{$form.form_area_1.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>�ȼ�<font color="#ff0000">��</font></b></td>
                    <td class="Value" width="*">{$form.form_btype.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_inst.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_bstruct.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td colspan="2">
            <table width="880" class="Data_Table" border="1">
                <tr style="font-weight: bold;">
                    <td class="Title_Purple" width="60" nowrap>SV</td>
                    <td class="Value">{$form.form_staff_1.html}</td>
                    <td class="Title_Purple" width="60" nowrap>ô��1</td>
                    <td class="Value">{$form.form_staff_2.html}</td>
                    <td class="Title_Purple" width="60" nowrap>ô��2</td>
                    <td class="Value">{$form.form_staff_3.html}</td>
                    <td class="Title_Purple" width="60" nowrap>ô��3</td>
                    <td class="Value">{$form.form_staff_4.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table>
    <tr>
        <td>

<div style="text-align: right; font: bold; color: #3300ff;">
    �������ΰ���ȥ�٥�Υե���ȥ��������礭�����������硢����å�̾�ȼ�̾1��2�ϣ���ʸ�����⡢����1��3�ϣ���ʸ���������Ͽ���Ʋ�������
</div>

<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple">FC��������ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_rank.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����åץ�����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">
        {$form.form_shop_cd.html}{if $var.freeze_flg != true}����{$form.form_cd_search.html}��{/if}
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">����å�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_shop_name.html}</td>
        <td class="Title_Purple">����å�̾<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_shop_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_shop_cname.html}</td>
        <td class="Title_Purple">ά��<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_cname_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ɾ�</td>
        <td class="Value" colspan="3">{$form.form_prefix.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_comp_name.html}</td>
        <td class="Title_Purple">��̾1<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_comp_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾2</b></td>
        <td class="Value">{$form.form_comp_name2.html}</td>
        <td class="Title_Purple">��̾2<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_comp_read2.html}</td>
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
        <td class="Title_Purple">Email</td>
        <td class="Value">{$form.form_email.html}</td>
        <td class="Title_Purple">URL</td>
        <td class="Value">{$form.form_url.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ܶ�</td>
        <td class="Value" colspan="3">{$form.form_capital_money.html}����</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Ի�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_represent_name.html}</td>
        <td class="Title_Purple">��ɽ����</td>
        <td class="Value">{$form.form_represent_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Է���</td>
        <td class="Value">{$form.form_represent_cell.html}</td>
        <td class="Title_Purple">ľ��TEL</td>
        <td class="Value">{$form.form_direct_tel.html}</td>
    </tr>
</table>

<br>

<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value">{$form.form_join_money.html}��</td>
        <td class="Title_Purple">�ݾڶ�</td>
        <td class="Value">{$form.form_assure_money.html}��</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ƥ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_royalty.html}��</td>
    </tr>
    <tr>
        <td class="Title_Purple">�軻��</td>
        <td class="Value">{$form.form_accounts_month.html}�� {$form.form_accounts_day.html}��</td>
        <td class="Title_Purple">������</td>
        <td class="Value">{$form.form_collect_terms.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Ϳ������</td>
        <td class="Value" colspan="3">{$form.form_limit_money.html}����</td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_close_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_claim_link.html}</td>
        <td class="Value" colspan="3">{$form.form_claim.html}</td>
    </tr>

</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">���������</span>
<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="145" style="font-weight: bold;">
<col>
<col width="145" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_pay_month.html}��{$form.form_pay_day.html}</td>
        <td class="Title_Purple">������ˡ</td>
        <td class="Value">{$form.form_pay_way.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����̾��</td>
        <td class="Value">{$form.form_transfer_name.html}</td>
        <td class="Title_Purple">����̾��</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value" colspan="3">{$form.form_bank_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.trade_aord_1.html}</td>
    </tr>
</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">���������</span>
<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="145" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��ʧ��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_payout_month.html}��{$form.form_payout_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��������</td>
        <td class="Value">{$form.form_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��������ά��</td>
        <td class="Value" colspan="3">{$form.form_b_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.trade_buy_1.html}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="880">
<col width="62" style="font-weight: bold;">
<col width="85" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple" colspan="2">Ϣ��ô���Ի�̾</td>
        <td class="Value">{$form.form_contact_name.html}</td>
        <td class="Title_Purple">��</td>
        <td class="Value" colspan="2">{$form.form_contact_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4">{$form.form_contact_cell.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��פ�ô���Ի�̾</td>
        <td class="Value">{$form.form_accountant_name.html}</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2">{$form.form_account_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�ݾڿ�1</td>
        <td class="Value">{$form.form_guarantor1.html}</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2">{$form.form_guarantor1_address.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�ݾڿ�2</td>
        <td class="Value">{$form.form_guarantor2.html}</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2">{$form.form_guarantor2_address.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�Ķȵ���</td>
        <td class="Value">{$form.form_position.html}</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2">{$form.form_holiday.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4">{$form.form_business_limit.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">������̾</td>
        <td class="Value">{$form.form_contract_name.html}</td>
        <td class="Title_Purple">������ɽ��̾</td>
        <td class="Value" colspan="2">{$form.form_represent_contract.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����ǯ����</td>
        <td class="Value">{$form.form_cont_s_day.html}</td>
        <td class="Title_Purple">���󹹿���</td>
        <td class="Value" colspan="2">{$form.form_cont_r_day.html}</td>
    </tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value">{$form.form_cont_peri.html}ǯ</td>
        <td class="Title_Purple">����λ��</td>
        <td class="Value" colspan="2">{$form.form_cont_e_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�϶���</td>
        <td class="Value">{$form.form_establish_day.html}</td>
        <td class="Title_Purple">ˡ���е���</td>
        <td class="Value" colspan="2">{$form.form_corpo_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��ɼȯ��<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.form_slip_issue.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">Ǽ�ʽ񥳥���</td>
        <td class="Value" colspan="4">{$form.form_deliver_radio.html}<br>{$form.form_deli_comment.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">�����</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="4">{$form.form_bill_address_font.html}�������ΰ���ȥ�٥�Υե���ȥ��������礭������</td>
    </tr>
<!--
    <tr>
        <td class="Title_Purple">�����ϰ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.form_claim_scope.html}</td>
    </tr>
-->
    <tr>
        <td class="Title_Purple">ȯ��<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.form_claim_issue.html}<br>
        <font color="#0000FF"><b>�� ����οƻҴط����ʤ���硢������������������������Ʊ�ͤǤ���</b></font></td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.form_claim_send.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ͼ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.claim_pattern.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���<font color="#ff0000">��</font></td>
        <td class="Title_Purple">�ޤ���ʬ</td>
        <td class="Value" colspan="4">{$form.form_coax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">������<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��</td>
        <td class="Value" colspan="4">{$form.form_tax_unit.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ü����ʬ</td>
        <td class="Value" colspan="4">{$form.from_fraction_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ƕ�ʬ</td>
        <td class="Value" colspan="4">{$form.form_c_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">������ʡ�����ʬ��</td>
        <td class="Value" colspan="4">{$form.form_qualify_pride.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4">{$form.form_special_contract.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value" colspan="4">{$form.form_record.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">���׻���</td>
        <td class="Value" colspan="4">{$form.form_important.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����¾</td>
        <td class="Value" colspan="4">{$form.form_other.html}</td>
    </tr>
</table>
<table width="880">
    <tr>
        <td>
            <b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
        </td>
        <td align="right">
            {*{$form.comp_button.html}����{$form.contract_button.html}����{$form.return_button.html}����{$form.button.entry_button.html}����{$form.button.res_button.html}����{$form.button.back_button.html}*}
            {$form.comp_button.html}����{$form.return_button.html}����{$form.button.entry_button.html}����{$form.button.res_button.html}����{$form.button.back_button.html}
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
