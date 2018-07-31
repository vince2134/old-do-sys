<?php /* Smarty version 2.6.14, created on 2012-03-20 15:54:35
         compiled from 2-3-206.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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

<?php if ($this->_tpl_vars['var']['ary_division_err_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php $_from = $this->_tpl_vars['var']['ary_division_err_msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['division_err_msg']):
?><li><?php echo $this->_tpl_vars['division_err_msg']; ?>
</li><br><?php endforeach; endif; unset($_from); ?>
    </span>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['form']['form_split_pay_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['form']['form_split_pay_amount'][$this->_tpl_vars['i']]['error'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['form']['form_split_pay_amount'][$this->_tpl_vars['i']]['error']; ?>
</li><br>
        </span>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['var']['renew_msg'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['var']['renew_msg']; ?>
</li><br>
        </span> 
<?php endif; ?>






<?php if ($this->_tpl_vars['var']['division_comp_flg'] == true): ?>
    <span style="font: bold 15px; color: #555555;">分割支払登録完了しました。<br><br></span>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1">
<col width="80" style="font-weight: bold;">
<col width="140">
<col width="80" style="font-weight: bold;">
<col width="300">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">伝票番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_no']['html']; ?>
</td>
        <td class="Title_Blue">仕入先</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Blue">発注番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">入荷日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
        <td class="Title_Blue">取引区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_buy']['html']; ?>
</td>
        <td class="Title_Blue">仕入日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
        <td class="Title_Blue">直送先</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
        <td class="Title_Blue">発注担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_oc_staff_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_name']['html']; ?>
</td>
        <td class="Title_Blue">備考</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="100%">
    <tr>
        <td class="Title_Blue" width="80" align="center"><b>税抜金額</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_total']['html']; ?>
</td>
        <td class="Title_Blue" width="80" align="center"><b>消費税</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_tax']['html']; ?>
</td>
        <td class="Title_Blue" width="80" align="center"><b>税込金額</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_money']['html']; ?>
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

<table align="center" width="100%">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['division_flg'] == 'true'): ?>
<table class="List_Table" border="1" align="center" width="400">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Purple">分割回数</td>
        <td class="Title_Purple">分割支払日</td>
        <td class="Title_Purple">分割支払金額</td>
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
            <table class="List_Table" border="1" width="450" align="left">
                <tr>
                    <td class="Title_Purple" align="center" width="80"><b>支払開始日<font color="#ff0000">※</font></b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_m']['html']; ?>
　支払日から　毎月 <?php echo $this->_tpl_vars['form']['form_pay_d']['html']; ?>
</td>
                    <td class="Title_Purple" align="center" width="80"><b>分割回数<font color="red">※</font></b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_division_num']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table> 
                <tr>    
                    <td><?php if ($this->_tpl_vars['var']['division_comp_flg'] != true): ?>　　<?php echo $this->_tpl_vars['form']['form_conf_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_button']['html'];  endif; ?></td>
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
                    <td class="Title_Purple">分割回数</td>
                    <td class="Title_Purple">分割支払日</td>
                    <td class="Title_Purple">分割支払金額<font color="red">※</font></td>
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
        <td align="right"><?php if ($this->_tpl_vars['var']['division_set_flg'] === true): ?>　　<?php echo $this->_tpl_vars['form']['add_button']['html'];  endif; ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['division_comp_flg'] == true): ?>
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>
<?php endif; ?>
<?php endif; ?>

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
