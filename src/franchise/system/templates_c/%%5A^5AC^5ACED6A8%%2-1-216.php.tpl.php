<?php /* Smarty version 2.6.14, created on 2009-12-21 17:14:33
         compiled from 2-1-216.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['contract']; ?>

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
    <?php if ($this->_tpl_vars['form']['form_area_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_area_id']['error']; ?>
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
    <?php if ($this->_tpl_vars['var']['client_cd_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['client_cd_err']; ?>
<br>
    <?php elseif ($this->_tpl_vars['form']['form_client_cd']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client_cname']['error']; ?>
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
    <?php if ($this->_tpl_vars['form']['form_capital']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_capital']['error']; ?>
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
    <?php if ($this->_tpl_vars['form']['form_rep_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_rep_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account']['error']; ?>
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
    <?php if ($this->_tpl_vars['form']['trade_ord']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_ord']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cshop']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cshop']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['close_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['close_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['c_staff_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['c_staff_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_close']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_close']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_m']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_m']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_d']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_d']['error']; ?>
<bt>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_start']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_start']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['start_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['start_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_s_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_s_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['sday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_charge_branch_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['error']; ?>
<br>
    <?php endif; ?>

    </span><br>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="810">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right"><?php if ($_GET['client_id'] != null):  echo $this->_tpl_vars['form']['back_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['next_button']['html'];  endif; ?></td> 
   </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Type" width="60" align="center"><b>����</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
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
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>�ȼ�<font color="#ff0000">��</font></b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_inst']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
        <td class="Title_Purple">������̾<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name2']['html']; ?>
</td>
        <td class="Title_Purple">������̾2<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_read2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cname']['html']; ?>
</td>
        <td class="Title_Purple">ά��<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cname_read']['html']; ?>
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
        <td class="Title_Purple">����3</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
        <td class="Title_Purple">����2<br>(�եꥬ��)</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ܶ�</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_capital']['html']; ?>
����</td>
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
        <td class="Title_Purple" width="125">URL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Ի�̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rep_name']['html']; ?>
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

<table class="Data_Table" border="1" width="100%">
<col width="64" style="font-weight: bold;">
<col width="84" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">�����ô��</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_charger']['html']; ?>
</td>
        <td class="Title_Purple">����ô��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_part']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['trade_ord']['html']; ?>
</td>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_close']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" width="130" colspan="2">��ʧ��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_m']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_pay_d']['html']; ?>
��</td>
        <td class="Title_Purple">��ʧ���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_terms']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bank']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��������ά��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_b_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_holiday']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�϶���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_start']['html']; ?>
</td>
        <td class="Title_Purple">���������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_s_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" >���<font color="#ff0000">��</font></td>
        <td class="Title_Purple" >�ޤ���ʬ</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_coax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">������<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ü����ʬ</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_franct']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ƕ�ʬ</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_c_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">ô����Ź<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_record']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">���׻���</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_important']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['entry_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['ok_button']['html']; ?>
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
