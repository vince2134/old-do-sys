<?php /* Smarty version 2.6.14, created on 2010-05-20 18:34:40
         compiled from 1-1-103.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

<?php echo $this->_tpl_vars['var']['contract']; ?>

<?php echo $this->_tpl_vars['var']['rank_name']; ?>

 </script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_area_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_area_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_btype']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_shop_gr_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_shop_gr_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_rank']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_rank']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_shop_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_shop_cd']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['shop_cd_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['shop_cd_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_shop_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_shop_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_shop_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_shop_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_comp_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_comp_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_address1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_address1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_fax']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_fax']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['email_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['email_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['url_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['url_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_represent_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_represent_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_represent_cell']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_represent_cell']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_direct_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_direct_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['d_tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['d_tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_contact_cell']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_contact_cell']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_tel']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_join_money']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_join_money']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_assure_money']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_assure_money']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_royalty']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_royalty']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_accounts_month']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_accounts_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_limit_money']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_limit_money']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['trade_aord_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_aord_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['trade_buy_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_buy_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_capital_money']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_capital_money']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_close_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_close_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_month']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_payout_month']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_payout_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_payout_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_payout_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cont_s_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cont_s_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['sday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cont_peri']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cont_peri']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['rday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['rday_err']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['sday_rday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_rday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_open_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_open_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['eday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['eday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_establish_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_establish_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_corpo_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_corpo_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['cday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['cday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_deli_comment']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_deli_comment']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['contact_cell_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['contact_cell_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['account_tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['account_tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['represent_cell_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['represent_cell_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_close_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_close_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_coax_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_coax_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_tax_franct_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_tax_franct_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_c_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_c_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['close_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['close_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['close_outday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['close_outday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['shop_name_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['shop_name_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['comp_name1_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['comp_name1_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['comp_name2_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['comp_name2_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address1_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address1_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address2_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address2_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address3_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address3_err']; ?>
<br>
    <?php endif; ?>
    </span><br>

<table>
    <tr>
        <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="880">
    <tr>
        <td align="right">
            <?php if ($_GET['client_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td> 
   </tr>
</table>

<table width="880">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Type" width="60" align="center"><b>����</b></td>
                    <td class="Value" width="*"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
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
                    <td class="Value" width="*"><?php echo $this->_tpl_vars['form']['form_area_1']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>�ȼ�<font color="#ff0000">��</font></b></td>
                    <td class="Value" width="*"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*"><?php echo $this->_tpl_vars['form']['form_inst']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*"><?php echo $this->_tpl_vars['form']['form_bstruct']['html']; ?>
</td>
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
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
                    <td class="Title_Purple" width="60" nowrap>ô��1</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_2']['html']; ?>
</td>
                    <td class="Title_Purple" width="60" nowrap>ô��2</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_3']['html']; ?>
</td>
                    <td class="Title_Purple" width="60" nowrap>ô��3</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_4']['html']; ?>
</td>
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
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����åץ�����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">
        <?php echo $this->_tpl_vars['form']['form_shop_cd']['html'];  if ($this->_tpl_vars['var']['freeze_flg'] != true): ?>����<?php echo $this->_tpl_vars['form']['form_cd_search']['html']; ?>
��<?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">����å�̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_name']['html']; ?>
</td>
        <td class="Title_Purple">����å�̾<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_cname']['html']; ?>
</td>
        <td class="Title_Purple">ά��<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cname_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ɾ�</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_prefix']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾1<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_name']['html']; ?>
</td>
        <td class="Title_Purple">��̾1<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾2</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_name2']['html']; ?>
</td>
        <td class="Title_Purple">��̾2<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_read2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">͹���ֹ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['input_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����1<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
        <td class="Title_Purple">����2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����3<br>(�ӥ�̾��¾)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
        <td class="Title_Purple">����2<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
        <td class="Title_Purple">FAX</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">Email</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_email']['html']; ?>
</td>
        <td class="Title_Purple">URL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ܶ�</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_capital_money']['html']; ?>
����</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Ի�̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_name']['html']; ?>
</td>
        <td class="Title_Purple">��ɽ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_position']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Է���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_cell']['html']; ?>
</td>
        <td class="Title_Purple">ľ��TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_tel']['html']; ?>
</td>
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
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_join_money']['html']; ?>
��</td>
        <td class="Title_Purple">�ݾڶ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_assure_money']['html']; ?>
��</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ƥ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_royalty']['html']; ?>
��</td>
    </tr>
    <tr>
        <td class="Title_Purple">�軻��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accounts_month']['html']; ?>
�� <?php echo $this->_tpl_vars['form']['form_accounts_day']['html']; ?>
��</td>
        <td class="Title_Purple">������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_collect_terms']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">Ϳ������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_limit_money']['html']; ?>
����</td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_close_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_claim_link']['html']; ?>
</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
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
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_month']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_pay_day']['html']; ?>
</td>
        <td class="Title_Purple">������ˡ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_way']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����̾��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_transfer_name']['html']; ?>
</td>
        <td class="Title_Purple">����̾��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bank_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['trade_aord_1']['html']; ?>
</td>
    </tr>
</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">���������</span>
<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="145" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��ʧ��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_payout_month']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_payout_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��������ά��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_b_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['trade_buy_1']['html']; ?>
</td>
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
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_contact_name']['html']; ?>
</td>
        <td class="Title_Purple">��</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_contact_position']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_contact_cell']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��פ�ô���Ի�̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accountant_name']['html']; ?>
</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_account_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�ݾڿ�1</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_guarantor1']['html']; ?>
</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_guarantor1_address']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�ݾڿ�2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_guarantor2']['html']; ?>
</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_guarantor2_address']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�Ķȵ���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_position']['html']; ?>
</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_holiday']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_business_limit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">������̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_contract_name']['html']; ?>
</td>
        <td class="Title_Purple">������ɽ��̾</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_represent_contract']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����ǯ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_s_day']['html']; ?>
</td>
        <td class="Title_Purple">���󹹿���</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_cont_r_day']['html']; ?>
</td>
    </tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_peri']['html']; ?>
ǯ</td>
        <td class="Title_Purple">����λ��</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_cont_e_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�϶���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_establish_day']['html']; ?>
</td>
        <td class="Title_Purple">ˡ���е���</td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_corpo_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��ɼȯ��<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_slip_issue']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">Ǽ�ʽ񥳥���</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_deliver_radio']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_deli_comment']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">�����</td>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_bill_address_font']['html']; ?>
�������ΰ���ȥ�٥�Υե���ȥ��������礭������</td>
    </tr>
<!--
    <tr>
        <td class="Title_Purple">�����ϰ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_claim_scope']['html']; ?>
</td>
    </tr>
-->
    <tr>
        <td class="Title_Purple">ȯ��<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_claim_issue']['html']; ?>
<br>
        <font color="#0000FF"><b>�� ����οƻҴط����ʤ���硢������������������������Ʊ�ͤǤ���</b></font></td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_claim_send']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ͼ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['claim_pattern']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���<font color="#ff0000">��</font></td>
        <td class="Title_Purple">�ޤ���ʬ</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_coax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">������<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_tax_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ü����ʬ</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['from_fraction_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ƕ�ʬ</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_c_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">������ʡ�����ʬ��</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_qualify_pride']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_special_contract']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_record']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">���׻���</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_important']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����¾</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_other']['html']; ?>
</td>
    </tr>
</table>
<table width="880">
    <tr>
        <td>
            <b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
        </td>
        <td align="right">
                        <?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['entry_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['res_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['back_button']['html']; ?>

        </td>
    </tr>
</table>

        </td>
    </tr>
</table>


                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
