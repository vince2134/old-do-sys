<?php /* Smarty version 2.6.14, created on 2009-12-06 13:05:03
         compiled from 1-3-102.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script>
<?php echo $this->_tpl_vars['var']['js']; ?>

</script>
<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

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
<ul style="margin-left: 16px;">
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_designated_date']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_designated_date']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_arrival_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_arrival_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_ware']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ware']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_staff']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_staff']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_note_your']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note_your']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_note_your2']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note_your2']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_direct']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_direct']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_no']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_no']['error']; ?>
<br>
    <?php endif; ?>   
    <?php if ($this->_tpl_vars['form']['form_buy_money']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_buy_money']['error']; ?>
<br>
    <?php endif; ?>   
    <?php $_from = $this->_tpl_vars['goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['goods_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['goods_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['price_num_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['price_num_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['price_num_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['num_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['num_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['num_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['price_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['price_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['price_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['duplicate_goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <li><?php echo $this->_tpl_vars['duplicate_goods_err'][$this->_tpl_vars['i']]; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
</ul>
</span> 
<?php if ($this->_tpl_vars['var']['freeze_flg'] != null): ?>
    <?php if ($this->_tpl_vars['var']['goods_twice'] != null): ?>
        <font color="red"><b><?php echo $this->_tpl_vars['var']['goods_twice']; ?>
</b></font><br>
    <?php endif; ?>
    <span style="font: bold;"><font size="+1">�ʲ������Ƥ�ȯ���ޤ�����</font></span><br>
<?php endif; ?>


<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Blue">ȯ����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����ʬ</a><font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
        <td class="Title_Blue">�вٲ�ǽ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_designated_date']['html']; ?>
 ����ޤǤ�ȯ��ѿ��Ȱ��������θ����</td>
        <td class="Title_Blue">��˾Ǽ��</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_hope_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
        <td class="Title_Blue">ô����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff']['html']; ?>
</td>
        <td class="Title_Blue">����ͽ����</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����ȼ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans']['html']; ?>
</td>
		                <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['form_direct_link']['html']; ?>
</td>
                <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_direct_text']['cd']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_direct_text']['name']['html']; ?>
&nbsp;&nbsp;�����衧<?php echo $this->_tpl_vars['form']['form_direct_text']['claim']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">�̿���<br>�ʻ����谸��</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_your']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����̿���<br>�ʻ����谸��</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_your2']['html']; ?>
</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>
         <span style="font: bold; color: #ff0000;"><?php echo $this->_tpl_vars['var']['warning']; ?>
</span>
        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
        <td class="Title_Blue">��ê��<br>(A)</td>
        <td class="Title_Blue">ȯ��ѿ�<br>(B)</td>
        <td class="Title_Blue">������<br>(C)</td>
        <td class="Title_Blue">�вٲ�ǽ��<br>(A+B-C)</td>
        <td class="Title_Blue">��åȻ���</td>
        <td class="Title_Blue">��åȿ�</td>
        <td class="Title_Blue">ȯ���<font color="#ff0000">��</font></td>
        <td class="Title_Blue">����ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Blue">�������</td>
        <?php if ($this->_tpl_vars['var']['client_search_flg'] == true && $this->_tpl_vars['var']['freeze_flg'] != true): ?>
            <td class="Title_Blue">�Ժ��</b></td>
        <?php endif; ?>
    </tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

</table>
        </td>
    </tr>
    <tr>
        <td>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php if ($this->_tpl_vars['var']['client_search_flg'] == true): ?>
<table width="100%">
    <tr>
            <td><?php echo $this->_tpl_vars['form']['form_add_row_button']['html']; ?>
</td>
        <td>
            <table class="List_Table" border="1" align="right" >
                <tr>
                    <td class="Title_Blue" width="80" align="center"><b>��ȴ���</b></td>
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_buy_money']['html']; ?>
</td>
                    <td class="Title_Blue" width="80" align="center"><b>������</b></td>
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_tax_money']['html']; ?>
</td>
                    <td class="Title_Blue" width="80" align="center"><b>�ǹ����</b></td>
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_total_money']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td><?php echo $this->_tpl_vars['form']['form_sum_button']['html']; ?>
</td>
    </tr>
</table>

<A NAME="foot"></A>
<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_order_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_comp_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_slip_comp_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
