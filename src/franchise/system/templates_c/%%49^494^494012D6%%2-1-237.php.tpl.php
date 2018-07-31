<?php /* Smarty version 2.6.14, created on 2009-12-22 14:47:18
         compiled from 2-1-237.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<?php echo $this->_tpl_vars['var']['link_next']; ?>

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
<?php if ($this->_tpl_vars['form']['form_round_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_round_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_slip_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_slip_no']['error']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_buy'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_buy']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_payin'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_payin']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_msg2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg2']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_msg3'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg3']; ?>

<?php endif;  if ($this->_tpl_vars['var']['confirm_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['confirm_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['del_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['del_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['cancel_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['cancel_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['deli_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['claim_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['claim_day_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['claim_day_bill_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['claim_day_bill_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['deli_day_act_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_act_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['pay_day_act_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['pay_day_act_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['deli_day_intro_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_intro_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['pay_day_intro_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['pay_day_intro_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['err_trade_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_trade_advance_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_trade_advance_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_future_date_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_future_date_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_future_date_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_advance_fix_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_advance_fix_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_advance_fix_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_paucity_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_paucity_advance_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_paucity_advance_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_day_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_day_advance_msg']; ?>

<?php endif; ?>
    </ul>
</span>

<?php echo $this->_tpl_vars['html_s']; ?>


                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>
<table>
    <tr>
        <td>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

        </td>
    </tr>
    <tr>
        <td>
<?php echo $this->_tpl_vars['html_l']; ?>

        </td>
    </tr>
    <tr>
        <td>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>

        </td>
    </tr>
    <tr>
        <td>
<?php echo $this->_tpl_vars['html_c']; ?>

        </td>
    </tr>
    <tr>
        <td>
<A NAME="sum">
<table align="left"><tr><td><?php echo $this->_tpl_vars['form']['form_confirm']['html']; ?>
</td></tr></table>
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
