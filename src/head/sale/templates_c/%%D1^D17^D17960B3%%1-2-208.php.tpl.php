<?php /* Smarty version 2.6.14, created on 2010-01-08 10:48:29
         compiled from 1-2-208.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_sheet']; ?>

</script>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
        <tr align="center" valign="top" height="160">
    <?php else: ?>
        <tr align="center" valign="top">
    <?php endif; ?>
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['ary_division_err_msg'] != null): ?>
    <?php $_from = $this->_tpl_vars['var']['ary_division_err_msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['division_err_msg']):
?><li><?php echo $this->_tpl_vars['division_err_msg']; ?>
</li><br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['renew_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['renew_msg']; ?>
<br>
<?php endif; ?>
</span>

<?php $_from = $this->_tpl_vars['form']['form_split_pay_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['form']['form_split_pay_amount'][$this->_tpl_vars['i']]['error'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['form']['form_split_pay_amount'][$this->_tpl_vars['i']]['error']; ?>
</li><br>
        </span>
    <?php endif;  endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['var']['division_comp_flg'] == true): ?>
    <span style="font: bold 15px; color: #555555;">ʬ������Ͽ��λ���ޤ�����<br><br></span>
<?php endif; ?>

<!-- ��Ͽ��ǧ��å�����ɽ�� -->
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="675">
<col width="80" style="font-weight: bold;">
<col>
<col width="60" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">��ɼ�ֹ�</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_sale_no']['html']; ?>
</td>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_trade_sale']['html']; ?>
</td>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">ľ����</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
        <td class="Title_Pink">���ô����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cstaff_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�в��Ҹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
        <td class="Title_Pink">������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day']['html']; ?>
</td>
        <td class="Title_Pink">���׾���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">����</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="100%">
    <tr>
        <td class="Title_Blue" width="80" align="center"><b>��ȴ���</b></td>
        <td class="Value" align="right" width="120"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
        <td class="Title_Blue" width="80" align="center"><b>������</b></td>
        <td class="Value" align="right" width="120"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
        <td class="Title_Blue" width="80" align="center"><b>�ǹ����</b></td>
        <td class="Value" align="right" width="120"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" >
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['division_flg'] == 'true'): ?>
<table class="List_Table" border="1" align="center" width="400">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Purple">ʬ����</td>
        <td class="Title_Purple">ʬ������</td>
        <td class="Title_Purple">ʬ�������</td>
    </tr>
    <?php $_from = $this->_tpl_vars['form']['form_pay_date']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td class="value" align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td class="value" align="center"><?php echo $this->_tpl_vars['form']['form_pay_date'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td class="value" align="right"><?php echo $this->_tpl_vars['form']['form_pay_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<table width="400" align="center">
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
    </tr>
</table>

<?php else: ?>

<table align="center">
    <tr>
        <td>
            <table class="List_Table" border="1" width="500" align="left">
                <tr>
                    <td class="Title_Purple" align="center" width="100"><b>���������<font color="#ff0000">��</font></b></td>
                    <td class="Value">�������Ρ�<?php echo $this->_tpl_vars['form']['form_pay_m']['html']; ?>
 ���顡��� <?php echo $this->_tpl_vars['form']['form_pay_d']['html']; ?>
</td>
                    <td class="Title_Purple" align="center" width="80"><b>ʬ����<font color="red">��</font></b></td>
                    <td class="Value" width="100"><?php echo $this->_tpl_vars['form']['form_division_num']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td><?php if ($this->_tpl_vars['var']['division_comp_flg'] != true): ?>����<?php echo $this->_tpl_vars['form']['form_conf_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_button']['html'];  endif; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php if ($this->_tpl_vars['var']['division_set_flg'] === true): ?>
        </td>
    </tr>
    <tr>
        <td align="center">

<br>
<table>
    <tr>
        <td>
            <table class="List_Table" border="1" align="center" width="400">
                <tr style="font-weight: bold;" align="center">
                    <td class="Title_Purple">ʬ����</td>
                    <td class="Title_Purple">ʬ������</td>
                    <td class="Title_Purple">ʬ�������<font color="red">��</font></td>
                </tr>
                <?php $_from = $this->_tpl_vars['form']['form_split_pay_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
                <tr>
                    <td class="value" align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
                    <td class="value" align="center"><?php echo $this->_tpl_vars['form']['form_pay_date'][$this->_tpl_vars['i']]['html']; ?>
</td>
                    <td class="value" align="right"><?php echo $this->_tpl_vars['form']['form_split_pay_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>
        </td>
    </tr>
    <?php if ($this->_tpl_vars['var']['division_comp_flg'] != true): ?>
    <tr>
        <td align="right"><?php if ($this->_tpl_vars['var']['division_set_flg'] === true): ?>����<?php echo $this->_tpl_vars['form']['add_button']['html'];  endif; ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['division_comp_flg'] == true): ?>
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>
<?php endif;  endif; ?>

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
