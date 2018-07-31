<?php /* Smarty version 2.6.14, created on 2009-12-22 14:48:05
         compiled from 2-2-106.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

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



<table width="960">
    <tr>
        <td>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['lump_change_comp_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['lump_change_comp_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['del_comp_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['del_comp_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['confirm_comp_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['confirm_comp_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['repo_comp_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['repo_comp_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['accept_comp_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['accept_comp_mess']; ?>

<?php endif; ?>
</span>

<span style="font: bold; color: #ff0000;">
    <ul style="margin-left: 16px;">

<?php if ($this->_tpl_vars['form']['form_lump_change_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_lump_change_date']['error']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['form']['del_err_mess']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['del_err_mess']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['back_ware'][$this->_tpl_vars['var']['del_line']]['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['back_ware'][$this->_tpl_vars['var']['del_line']]['error']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['var']['confirm_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['confirm_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_confirm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['del_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['del_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_del']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['del_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['deli_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_renew_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_deli_day_renew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['deli_day_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_deli_day_start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['claim_day_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['claim_day_renew_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_claim_day_renew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['deli_day_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_deli_day_start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['claim_day_bill_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['claim_day_bill_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_claim_day_bill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['claim_day_bill_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['buy_err_mess1'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['buy_err_mess1']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_buy1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['buy_err_mess2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['buy_err_mess2']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_buy2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['buy_err_mess3'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['buy_err_mess3']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_buy3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['error_pay_no'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_pay_no']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_pay_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['error_buy_no'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_buy_no']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ary_err_buy_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?>

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
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['ord_time_start_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['ord_time_start_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ord_time_start_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['ord_time_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['ord_time_err']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['ord_time_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['error_sale'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_sale']; ?>
<br>
    <?php $_from = $this->_tpl_vars['var']['err_sale_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?>

<?php if ($this->_tpl_vars['var']['cancel_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['cancel_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_buy'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_buy']; ?>

<?php endif;  if ($this->_tpl_vars['var']['error_payin'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_payin']; ?>

<?php endif;  if ($this->_tpl_vars['var']['deli_day_act_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_act_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['pay_day_act_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['pay_day_act_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['deli_day_intro_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['deli_day_intro_renew_err']; ?>

<?php endif;  if ($this->_tpl_vars['var']['pay_day_intro_renew_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['pay_day_intro_renew_err']; ?>

<?php endif; ?>




<?php if ($this->_tpl_vars['var']['err_trade_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_trade_advance_msg']; ?>
<br>
        <?php $_from = $this->_tpl_vars['var']['ary_err_trade_advance']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['ary_trade_advance_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_future_date_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_future_date_msg']; ?>
<br>
        <?php $_from = $this->_tpl_vars['var']['ary_err_future_date']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['ary_future_date_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_advance_fix_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_advance_fix_msg']; ?>
<br>
        <?php $_from = $this->_tpl_vars['var']['ary_err_advance_fix']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['ary_advance_fix_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif;  if ($this->_tpl_vars['var']['err_paucity_advance_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_paucity_advance_msg']; ?>
<br>
        <?php $_from = $this->_tpl_vars['var']['ary_err_paucity_advance']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['var']['ary_paucity_advance_no']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['slip_no']):
?>　　<?php echo $this->_tpl_vars['slip_no']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?>

</span>

<?php if ($this->_tpl_vars['var']['move_warning'] != null || $this->_tpl_vars['var']['warn_lump_change'] != null): ?>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
	<?php if ($this->_tpl_vars['var']['move_warning'] != null): ?>
    <?php echo $this->_tpl_vars['var']['move_warning']; ?>
</font><br>
    <?php echo $this->_tpl_vars['form']['form_confirm_warn']['html']; ?>
<br><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['var']['warn_lump_change'] != null): ?>
    <?php echo $this->_tpl_vars['var']['warn_lump_change']; ?>
</font><br>
    <?php echo $this->_tpl_vars['form']['form_lump_change_warn']['html']; ?>
<br><br>
	<?php endif; ?>
    </td></tr>
</table>
<?php endif; ?>


<?php if ($this->_tpl_vars['var']['modoru_disp_flg'] == true): ?>
    <?php echo $this->_tpl_vars['form']['modoru']['html']; ?>


<?php else: ?>
<table width="550">
    <tr>
        <td width="260">
            <table class="List_Table" width="250">
                <tr class="Result1">
                    <td class="Title_Pink" width="100" align="center"><b>予定巡回日</b></td>
                    <td><?php echo $this->_tpl_vars['form']['form_lump_change_date']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td width="290" align="left">
            <?php echo $this->_tpl_vars['form']['btn_lump_change']['html']; ?>

        </td>
    </tr>
    <tr>
        <td align="left" width="" colspan="2">
            <b><font color="blue">
                <li>指定した日付で 予定巡回日 と 請求日 を一括訂正します。
                <li>一括訂正は 売上未確定、または オンライン代行で未報告 の予定データが対象です。
            </font></b>
        </td>
    </tr>
</table>
<br>
<?php endif; ?>


<?php $_from = $this->_tpl_vars['h_data_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
<fieldset width="100%">
<legend><span style="font: bold 15px; color: #555555;">
    【伝票番号　<?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][0] != NULL):  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][0];  else: ?>　　　　<?php endif; ?>】
</span></legend>
<br>
<table class="List_Table" border="1" width="400">
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>代行区分</b></td>
        <td ><?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?>自社巡回<?php elseif ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '2'): ?>オンライン代行<?php else: ?>オフライン代行<?php endif; ?></td>
    </tr>
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>巡回日</b></td>
        <td ><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][34]; ?>
</td>
    </tr>
</table>
<br>
<table class="List_Table" border="1" width="100%">
        <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">予定巡回日</td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] != '2'): ?><td class="Title_Pink">順路</td><?php endif; ?>
        <td class="Title_Pink">得意先名</td>
        <td class="Title_Pink">取引区分</td>
                <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
        <td class="Title_Pink">請求日</td>
        <td class="Title_Pink">請求先</td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] != '2'): ?><td class="Title_Pink">巡回担当チーム</td><?php endif; ?>
    </tr>

        <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td align="center"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][1]; ?>
</td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] != '2'): ?><td align="center"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][2]; ?>
</td><?php endif; ?>
        <td><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][3]; ?>
-<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][4]; ?>
<br><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][5]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][6]; ?>
</td>
                <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
        <td align="center"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][8]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][33]; ?>
<br><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][32]; ?>
</td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] != '2'): ?>
        <td><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][9];  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][10];  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][11];  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][12]; ?>
</td>
        <?php endif; ?>
    </tr>

            <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][40] == 't'): ?>
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" align="center"><b>直送先</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="left" colspan="6"><?php else: ?><td align="left" colspan="4"><?php endif; ?>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][41] != null):  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][42]; ?>
：<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][43]; ?>
　請求先：<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][44];  endif; ?>
        </td>
    </tr>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" align="center"><b>紹介口座先</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="left" colspan="3"><?php else: ?><td align="left" colspan="2"><?php endif; ?>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][26] != null):  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][27]; ?>
<br><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][29];  else: ?>無し<?php endif; ?>
        </td>
        <td class="Title_Pink" width="100" align="center"><b>紹介口座料<br>(税抜)</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?>
            <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][30] == '1'): ?><td align="left" colspan="2">発生しない<?php else: ?><td align="right" colspan="2"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][31];  endif; ?>
        <?php else: ?>
            <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][30] == '1'): ?><td align="left">発生しない<?php else: ?><td align="right"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][31];  endif; ?>
        <?php endif; ?>
        </td>
    </tr>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] != '1'): ?>
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>代行先</b></td>
        <td align="left" colspan="2"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][35]; ?>
</td>
        <td class="Title_Pink" width="100" align="center"><b>代行委託料<br>(税抜)</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][36] == "発生しない"): ?><td align="left"><?php else: ?><td align="right"><?php endif;  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][36]; ?>
</td>
    </tr>
    <?php endif; ?>

        <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>備考</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?>
                <td colspan="3"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][24]; ?>
</td>
        <?php elseif ($_SESSION['group_kind'] == '2'): ?>
                <td colspan="2"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][24]; ?>
</td>
        <?php else: ?>
                <td colspan="2"><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][25]; ?>
</td>
        <?php endif; ?>
        <td class="Title_Pink" width="100" align="center"><b>訂正理由</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td colspan="2"><?php else: ?><td><?php endif;  echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][15]; ?>
</td>
    </tr>

        <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>税抜合計<br>消費税</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="right" colspan="3"><?php else: ?><td align="right" colspan="2"><?php endif; ?>
            <?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][13]; ?>
<br><?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][14]; ?>

        </td>
        <td class="Title_Pink" width="100" align="center"><b>伝票合計</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="right" colspan="2"><?php else: ?><td align="right" colspan="1"><?php endif; ?>
            <?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][22]; ?>

        </td>
    </tr>

        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
    <tr class="<?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][23]; ?>
">
        <td class="Title_Pink" width="100" align="center"><b>前受金残高</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="right" colspan="3"><?php else: ?><td align="right" colspan="2"><?php endif; ?>
            <?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][45]; ?>

        </td>
        <td class="Title_Pink" width="100" align="center"><b>前受相殺額合計</b></td>
        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1'): ?><td align="right" colspan="2"><?php else: ?><td align="right" colspan="1"><?php endif; ?>
            <?php echo $this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][46]; ?>

        </td>
    </tr>
    <?php endif; ?>

</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">販売区分</td>
        <td class="Title_Pink">サービス名</td>
        <td class="Title_Pink">アイテム</td>
        <td class="Title_Pink">数量</td>
        <td class="Title_Pink">営業原価<br>売上単価</td>
        <td class="Title_Pink">原価合計額<br>売上合計額</td>
        <td class="Title_Pink">消耗品</td>
        <td class="Title_Pink">数量</td>
        <td class="Title_Pink">本体商品</td>
        <td class="Title_Pink">数量</td>
    <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
        <td class="Title_Pink">口座料<br>(商品単位)</td>
        <td class="Title_Pink">前受相殺額</td>
    <?php endif; ?>
            </tr>

        <?php $_from = $this->_tpl_vars['data_list'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][27] === 't'): ?>
    <tr class="<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][19]; ?>
" style="color: red">
    <?php else: ?>
    <tr class="<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][19]; ?>
">
    <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
                <td align="center" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][0]; ?>
</td>
                <td valign="top" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][1]; ?>
　<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][2]; ?>
<br>　　<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][3]; ?>
</td>
                <td valign="top" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][4]; ?>
　<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][5]; ?>
<br>　　<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][22]; ?>
<br>　　<?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][6]; ?>
</td>
                <?php if ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7] == 't' && $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8] != NULL): ?>
        <td align="center" nowrap>
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <tr><td align="center">一式</td></tr>
                <tr><td align="right"><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8]; ?>
</td></tr>
            </table>
        </td>
        <?php elseif ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7] == 't' && $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8] == NULL): ?>
        <td align="center">一式</td>
        <?php elseif ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7] != 't' && $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8] != NULL): ?>
        <td align="right"><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8]; ?>
</td>
        <?php endif; ?>

                <td align="right" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][20]; ?>
<br><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][9]; ?>
</td>
                <td align="right" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][21]; ?>
<br><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][10]; ?>
</td>
                <td ><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][11]; ?>
<br><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][12]; ?>
</td>
        <td align="right" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][13]; ?>
</td>
                <td ><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][14]; ?>
<br><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][15]; ?>
</td>
        <td align="right" nowrap><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][16]; ?>
</td>

        <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][20] == '1' || $_SESSION['group_kind'] == '2'): ?>
                <td align="left" nowrap>
                    <?php if ($this->_tpl_vars['h_data_list'][$this->_tpl_vars['i']][0][26] != null): ?>
            <table width="100%">
                <?php if ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][23] != null): ?>
                <tr><td><font color="#555555">固定額</font></td><td align="right"><font color="#555555"><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][23]; ?>
</font></td></tr>
                <?php elseif ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][24] != null): ?>
                <tr><td><font color="#555555">売上の</font></td><td align="right"><font color="#555555"><?php echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][24]; ?>
&nbsp;％</font></td></tr>
                <?php else: ?>
                                <tr><td></td></tr>
                <?php endif; ?>
            </table>
            <?php endif; ?>

                <td align="right" nowrap>
            <?php if ($this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][25] == '2'):  echo $this->_tpl_vars['data_list'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][26];  endif; ?>
        </td>

        <?php endif; ?>

            </tr>
    <?php endforeach; endif; unset($_from); ?>

</table>
<br>
<table border="0" width="100%" style="color: #555555;">
    <?php if ($this->_tpl_vars['form']['back_ware'][$this->_tpl_vars['i']]['html'] != null): ?>
    <tr>
        <td align="left" colspan="2">
            <ul style="color: #0000ff; font-weight: bold; line-height: 130%; margin-left: 16px; margin-top: 0px; margin-bottom: 0px;">
                <li>商品予定出荷で在庫移動済みの伝票を削除する場合は、<br>商品を戻す倉庫を指定してください。
            </ul>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td align="left">
                        <?php if ($this->_tpl_vars['form']['back_ware'][$this->_tpl_vars['i']]['html'] != null): ?>在庫返却倉庫：<?php echo $this->_tpl_vars['form']['back_ware'][$this->_tpl_vars['i']]['html'];  endif; ?>
                        <?php if ($this->_tpl_vars['form']['slip_del'][$this->_tpl_vars['i']]['html'] != null):  echo $this->_tpl_vars['form']['slip_del'][$this->_tpl_vars['i']]['html'];  endif; ?>
        </td>
        <td align="right">
            <?php if ($this->_tpl_vars['form']['confirm'][$this->_tpl_vars['i']]['html'] != null):  echo $this->_tpl_vars['form']['confirm'][$this->_tpl_vars['i']]['html']; ?>
　            <?php elseif ($this->_tpl_vars['form']['report'][$this->_tpl_vars['i']]['html'] != null):  echo $this->_tpl_vars['form']['report'][$this->_tpl_vars['i']]['html']; ?>
　            <?php elseif ($this->_tpl_vars['form']['accept'][$this->_tpl_vars['i']]['html'] != null):  echo $this->_tpl_vars['form']['accept'][$this->_tpl_vars['i']]['html']; ?>
　            <?php endif; ?>
            <?php echo $this->_tpl_vars['form']['slip_change'][$this->_tpl_vars['i']]['html']; ?>
　<?php echo $this->_tpl_vars['form']['con_change'][$this->_tpl_vars['i']]['html']; ?>
　<?php echo $this->_tpl_vars['form']['modoru']['html']; ?>

        </td>
    </tr>
</table>
</fieldset>
<br><br><br>
<?php endforeach; endif; unset($_from); ?>

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
