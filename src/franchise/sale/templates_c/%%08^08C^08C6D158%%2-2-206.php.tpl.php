<?php /* Smarty version 2.6.14, created on 2009-12-22 11:40:52
         compiled from 2-2-206.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>   
    
        <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>    

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_round_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_round_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_slip_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_slip_no']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['msg']['error_pay_no'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['error_pay_no']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_pay_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['error_buy_no'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['error_buy_no']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_buy_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['deli_day_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['deli_day_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_deli_day_start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['deli_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['deli_day_renew_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_deli_day_renew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['claim_day_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['claim_day_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_claim_day_start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['claim_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['claim_day_renew_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_claim_day_renew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['claim_day_bill_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['claim_day_bill_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_claim_day_bill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['confirm_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['confirm_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_confirm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['del_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['del_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_del']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['buy_err_mess1'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['buy_err_mess1']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_buy1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['buy_err_mess2'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['buy_err_mess2']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_buy2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['buy_err_mess3'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['buy_err_mess3']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_buy3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['err_trade_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['err_trade_advance_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_trade_advance']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['err_future_date_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['err_future_date_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_future_date']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['err_advance_fix_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['err_advance_fix_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_advance_fix']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['msg']['err_paucity_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['msg']['err_paucity_advance_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['msg']['ary_err_paucity_advance']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?>
</ul>
</span>

<?php if ($this->_tpl_vars['msg']['move_warning'] != null): ?>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
    <?php echo $this->_tpl_vars['msg']['move_warning']; ?>
</font><br>
    <?php echo $this->_tpl_vars['form']['form_confirm_warn']['html']; ?>
<br><br>
    </td></tr>
</table>
<?php endif; ?>

<?php echo $this->_tpl_vars['html']['html_s']; ?>


                    </td>   
                </tr>   
                <tr style="page-break-before: always;">    
                    <td>    

<?php echo $this->_tpl_vars['html']['html_l']; ?>


                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
