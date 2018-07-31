<?php /* Smarty version 2.6.14, created on 2010-01-16 19:54:29
         compiled from 2-1-238.php.tpl */ ?>
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
<?php if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
    <li>a<?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li>b<?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_round_day']['error'] != null): ?>
    <li>c<?php echo $this->_tpl_vars['form']['form_round_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_slip_no']['error'] != null): ?>
    <li>d<?php echo $this->_tpl_vars['form']['form_slip_no']['error']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_msg2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg2']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_msg3'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg3']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['var']['trust_confirm_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['trust_confirm_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['trust_confirm_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['ord_time_itaku_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['ord_time_itaku_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ord_time_itaku_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['del_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['del_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['del_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['ord_time_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['ord_time_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ord_time_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['ord_time_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['ord_time_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ord_time_start_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['claim_day_bill_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['claim_day_bill_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['claim_day_bill_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['error_sale'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_sale']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['err_sale_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_future_date_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_future_date_msg']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_future_date_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?>

<?php if ($this->_tpl_vars['var']['move_warning'] != null): ?>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
    <?php echo $this->_tpl_vars['var']['move_warning']; ?>
</font><br>
    <?php echo $this->_tpl_vars['form']['form_confirm_warn']['html']; ?>
<br><br>
    </td></tr>
</table>
<?php endif; ?>
</span>

<?php echo $this->_tpl_vars['html_s']; ?>


                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['html_l']; ?>


                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
