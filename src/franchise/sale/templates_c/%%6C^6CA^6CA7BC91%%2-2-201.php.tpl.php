<?php /* Smarty version 2.6.14, created on 2009-12-06 09:47:28
         compiled from 2-2-201.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['html_js']; ?>

</script>

<?php if (( $this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['renew_flg'] != 'true' && $this->_tpl_vars['var']['done_flg'] != 'true' && $this->_tpl_vars['var']['slip_del_flg'] != true && $this->_tpl_vars['var']['buy_err_mess'] == null )): ?>
    <?php if (( $this->_tpl_vars['var']['client_id'] != null && $_SESSION['group_kind'] == '2' )): ?>
        <body onLoad="tegaki_daiko_checked(); ad_offset_radio_disable();">
    <?php else: ?>
    <body onLoad="ad_offset_radio_disable();">
    <?php endif;  else: ?>
        <body >
<?php endif; ?>


<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <?php if ($this->_tpl_vars['var']['done_flg'] == true): ?>
    	<tr align="center" valign="top" height="160">
	<?php else: ?>
		<tr align="center" valign="top">
	<?php endif; ?>
        <td>

<?php if ($this->_tpl_vars['var']['slip_del_flg'] == true): ?>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li>伝票が削除されているため、変更できません。<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
        </tr>
    </table>
<?php elseif ($this->_tpl_vars['var']['buy_err_mess'] != null): ?>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li><?php echo $this->_tpl_vars['var']['buy_err_mess']; ?>
の仕入が本部で日次更新されているため、変更できません。<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
        </tr>
    </table>
<?php elseif ($this->_tpl_vars['var']['done_flg'] == true): ?>
            <table>
                <tr>
                    <td>

    <span style="font: bold;"><font size="+1">手書伝票の作成が完了しました。<br><br>
    </font></span>
    <table>
        <tr>
            <td align="left"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td><td align="left"><?php echo $this->_tpl_vars['form']['ok_slip_button']['html']; ?>
</td>
        </tr>
        <tr>
            <td align="left"><?php echo $this->_tpl_vars['form']['slip_bill_button']['html']; ?>
</td><td align="left"><?php echo $this->_tpl_vars['form']['ok_slip_bill_button']['html']; ?>
</td><td>　　<?php echo $this->_tpl_vars['form']['slip_copy_button']['html']; ?>
</td>
        </tr>
    </table>
    <table width="435">
        <tr><td colspan="3" width="100%" height="70" align="right" valign="bottom"><?php echo $this->_tpl_vars['form']['return_edit_button']['html']; ?>
</td></tr>
    </table>

<?php else: ?>
<fieldset>
<legend>
    <span style="font: bold 15px; color: #555555;">【伝票番号】： <?php echo $this->_tpl_vars['form']['form_sale_no']['html']; ?>
 </span>
</legend>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">

        <?php if ($this->_tpl_vars['var']['duplicate_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['duplicate_err']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['var']['slip_renew_mess'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['slip_renew_mess']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_delivery_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_delivery_day']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_request_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_request_day']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['var']['error_msg16'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_msg16']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['trade_sale_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_sale_select']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_ac_staff_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ac_staff_select']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_daiko']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_daiko']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_ad_offset_total']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ad_offset_total']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['act_div'][0]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['act_div'][0]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['act_request_rate']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['act_request_rate']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['act_request_price']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['act_request_price']['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['intro_ac_price']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['intro_ac_price']['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['intro_ac_rate']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['intro_ac_rate']['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_account_price'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_price'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_price'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_price'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_price'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_price'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_price'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_price'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_price'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_price'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_account_rate'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_rate'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_rate'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_rate'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_rate'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_rate'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_rate'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_rate'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account_rate'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account_rate'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['var']['error_msg3'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_msg3']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['error_msg4'][1] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg4'][1]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg4'][2] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg4'][2]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg4'][3] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg4'][3]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg4'][4] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg4'][4]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg4'][5] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg4'][5]; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['error_msg5'][1] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg5'][1]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg5'][2] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg5'][2]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg5'][3] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg5'][3]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg5'][4] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg5'][4]; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['error_msg5'][5] != null): ?>
        <li><?php echo $this->_tpl_vars['error_msg5'][5]; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_divide'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_divide'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_divide'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_divide'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_divide'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_divide'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_divide'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_divide'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_divide'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_divide'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_print_flg1'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg1'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg1'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg1'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg1'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg1'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg1'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg1'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg1'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg1'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_print_flg2'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg2'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg2'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg2'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg2'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg2'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg2'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg2'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg2'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg2'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_print_flg3'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg3'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg3'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg3'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg3'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg3'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg3'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg3'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_print_flg3'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_print_flg3'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php $_from = $this->_tpl_vars['error_loop_num1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['form']['form_goods_num1'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num1'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num1'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num1'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num1'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num1'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num1'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num1'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num1'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num1'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_goods_num2'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num2'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num2'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num2'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num2'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num2'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num2'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num2'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num2'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num2'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_goods_num3'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num3'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num3'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num3'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num3'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num3'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num3'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num3'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_num3'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_num3'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_trade_price'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_price'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_price'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_price'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_price'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_price'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_price'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_price'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_price'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_price'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_sale_price'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_price'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_price'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_price'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_price'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_price'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_price'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_price'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_price'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_price'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_serv'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_serv'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_serv'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_serv'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_serv'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_serv'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_serv'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_serv'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_serv'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_serv'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['error_goods_num2'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num2'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num2'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num2'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num2'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num2'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num2'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num2'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num2'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num2'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['error_goods_num3'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num3'][1]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num3'][2]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num3'][2]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num3'][3]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num3'][3]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num3'][4]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num3'][4]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['error_goods_num3'][5]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['error_goods_num3'][5]['error']; ?>
<br>
    <?php endif; ?>

        <?php $_from = $this->_tpl_vars['error_loop_num1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
                <?php if ($this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

        <?php $_from = $this->_tpl_vars['error_loop_num1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['form']['form_ad_offset_amount'][$this->_tpl_vars['i']]['error'] != null): ?>
            <li><?php echo $this->_tpl_vars['form']['form_ad_offset_amount'][$this->_tpl_vars['i']]['error']; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    </ul>
    </span>

    <?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
        <span style="font: bold;"><font size="+1">以下の内容で手書伝票を作成しますか？</font></span><br>
    <?php endif; ?>

<?php if ($this->_tpl_vars['var']['error_flg'] != true && $this->_tpl_vars['var']['ad_total_warn_mess'] != null): ?>
<br>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br><?php echo $this->_tpl_vars['var']['ad_total_warn_mess']; ?>
</font>
    </td></tr>
</table>
<br>
<?php endif; ?>

    
        <table>
        <tr>
            <td>

    <!-- 直営判定 -->
    <?php if ($_SESSION['group_kind'] == '2' && $this->_tpl_vars['var']['client_id'] != NULL): ?>
    <table class="Data_Table" border="1" width="400">
        <tr>
            <td class="Title_Purple" align="center" width="92"><b>代行区分</b></td>
            <td class="Value" width="308"><?php echo $this->_tpl_vars['form']['daiko_check']['html']; ?>
</td>
        </tr>
    </table>
    <br>
    <?php endif; ?>

<table class="List_Table" border="1">
    <tr align="center">
        <td class="Title_Pink" width=""><b>売上計上日<font color="red">※</font></b></td>
        <td class="Title_Pink" nowrap><b>
         
        <?php if ($this->_tpl_vars['var']['aord_id'] == null && $this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['renew_flg'] != 'true'): ?>
            <a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">得意先</a><font color="#ff0000">※</font></td>
        <?php else: ?>
            得意先<font color="#ff0000">※</font></b></td>
        <?php endif; ?>
        <td class="Title_Pink" width=""><b>取引区分<font color="red">※</font></b></td>
        <td class="Title_Pink" width=""><b>請求日<font color="red">※</font></b></td>
        <td class="Title_Pink" width=""><b>請求先</b></td>
        <td class="Title_Pink" width=""><b>売上担当者</b></td>
    </tr>

    <tr class="Result1">
        <td align="center" width="150"><?php echo $this->_tpl_vars['form']['form_delivery_day']['html']; ?>
</td>
        <td align="left" width="" nowrap><?php echo $this->_tpl_vars['form']['form_client']['cd1']['html']; ?>
&nbsp;-&nbsp;<?php echo $this->_tpl_vars['form']['form_client']['cd2']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
<br><?php echo $this->_tpl_vars['form']['form_client']['name']['html']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['form']['trade_sale_select']['html']; ?>
</td>
        <td align="center" width="150"><?php echo $this->_tpl_vars['form']['form_request_day']['html']; ?>
</td>
        <td align="left" width="180"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['form']['form_ac_staff_select']['html']; ?>
</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>直送先</b></td>
        <td class="Value" width="185" colspan="5"><?php echo $this->_tpl_vars['form']['form_direct_select']['html']; ?>
</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>紹介口座先</b></td>
        <td class="Value" width="185" colspan="2"><nobr><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</nobr></td>
        <td class="Title_Purple" width="110"><b><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['label']; ?>
</b></td>
        <td class="Value" width="185" colspan="2">
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <?php if ($this->_tpl_vars['var']['ac_name'] == "無し"): ?>
                <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>
</td></tr>
                <?php else: ?>
                <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][0]['html'];  echo $this->_tpl_vars['form']['intro_ac_price']['html']; ?>
円</td><td>　<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>
</td></tr>
                <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['html'];  echo $this->_tpl_vars['form']['intro_ac_rate']['html']; ?>
％</td><td></td></tr>
                <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][2]['html']; ?>
</td><td></td></tr>
                <?php endif; ?>
            </table>
        </td>
    </tr>

    <?php if ($_SESSION['group_kind'] == '2' && $this->_tpl_vars['var']['client_id'] != NULL): ?>
    <tr>
        <td class="Title_Pink" nowrap><b>
        <?php if ($this->_tpl_vars['var']['aord_id'] == null && $this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['renew_flg'] != 'true'): ?>
            <?php echo $this->_tpl_vars['form']['form_daiko_link']['html']; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['form']['form_daiko_link']['label']; ?>

        <?php endif; ?>
        </b></td>
        <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_daiko']['cd1']['html']; ?>
&nbsp;-&nbsp;<?php echo $this->_tpl_vars['form']['form_daiko']['cd2']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_daiko']['name']['html']; ?>
</td>
        <td class="Title_Pink" nowrap><b>代行委託料</b></td>
        <td class="Value" colspan="2">
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <tr><td><?php echo $this->_tpl_vars['form']['act_div'][0]['html'];  echo $this->_tpl_vars['form']['act_request_price']['html']; ?>
円</td><td>　<?php echo $this->_tpl_vars['form']['act_div'][2]['html']; ?>
</td></tr>
                <tr><td><?php echo $this->_tpl_vars['form']['act_div'][1]['html'];  echo $this->_tpl_vars['form']['act_request_rate']['html']; ?>
％</td><td></td></tr>
            </table>
        </td>
    </tr>
    <?php endif; ?>

    <tr class="Result1">
        <td class="Title_Pink"><b>備考</b></td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Pink"><b>税抜合計<br>消費税</b></td>
        <td class="Value" colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
        <td class="Title_Pink" ><b>伝票合計</b></td>
        <td class="Value" colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Pink">
            <table width="100%" cellspacing="0" cellpadding="0"><tr>
                <td class="Title_Pink"><b>前受金残高</b></td>
                <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['renew_flg'] != 'true'): ?>
                <td align="right"><?php echo $this->_tpl_vars['form']['form_ad_sum_btn']['html']; ?>
</td>
                <?php endif; ?>
            </tr></table>
        </td>
        <td class="Value" colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['html']; ?>
</td>
        <td class="Title_Pink" ><b>前受相殺額合計</b></td>
        <td class="Value" colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_ad_offset_total']['html']; ?>
</td>
    </tr>

</table>
<BR>

    <?php if ($this->_tpl_vars['var']['warning'] != null): ?><font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font><br><?php endif; ?>

    <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['renew_flg'] != 'true'): ?>
    <table width="100%">
        <tr><td align="right" colspan="3"><?php echo $this->_tpl_vars['form']['form_sum_btn']['html']; ?>
</td></tr>
    </table>
    <?php endif; ?>

            </td>
        </tr>
    </table>

            </td>
        </tr>
        <tr>
            <td>

<A NAME="hand">

<table border="0" width="985">
    <tr>
    <td align="left"><font size="+0.5" color="#555555"><b>【商品出荷倉庫：<?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
&nbsp;】</b></font></td>
    <td align="left" width="922"><b><font color="blue">
        <li>前受相殺額以外は税抜金額を登録してください。
        <li>「サービス名」「アイテム」にチェックを付けると伝票に印字されます
    </font></b></td>
    </tr>
</table>

    

    
    <table class="Data_Table" border="1" width="950">
                <tr>
            <td class="Title_Purple" rowspan="2"><b>販売区分<font color="#ff0000">※</font></b></td>
            <td class="Title_Purple" rowspan="2"><b>サービス名</b></td>
            <td class="Title_Purple" rowspan="2"><b>アイテム</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <td class="Title_Purple" colspan="2"><b>金額</b></td>
            <td class="Title_Purple" rowspan="2"><b>消耗品</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <td class="Title_Purple" rowspan="2"><b>本体商品</b></td>
            <td class="Title_Purple" rowspan="2"><b>数量</b></td>
            <!-- ＦＣ側の代行判定 -->
            <?php if ($this->_tpl_vars['var']['contract_div'] == 1 || $_SESSION['group_kind'] == '2'): ?>
                <!-- 通常or直営 -->
                <td class="Title_Purple" rowspan="2"><b>口座料<br>(商品単位)</b></td>
            <?php else: ?>
                <!-- FC側の代行は口座料なし -->
            <?php endif; ?>
            <td class="Title_Purple" rowspan="2"><b>前受相殺額</b></td>
                                    <?php if ($this->_tpl_vars['var']['freeze_flg'] != true): ?>
            <td class="Title_Purple" rowspan="2"><b>クリア</b></td>
            <?php endif; ?>
        </tr>

        <tr>
            <td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></b></td>
            <td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
        </tr>


                <?php $_from = $this->_tpl_vars['loop_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
                <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
            <tr class="Value" style="color: red">
        <?php else: ?>
            <tr>
        <?php endif; ?>
                        <td class="Value" align="center"><?php echo $this->_tpl_vars['form']['form_divide'][$this->_tpl_vars['i']]['html']; ?>
</td>

                        <td class="Value"><?php echo $this->_tpl_vars['form']['form_print_flg1'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_serv'][$this->_tpl_vars['i']]['html']; ?>
</td>

                        <td class="Value">
                <?php echo $this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['freeze_flg'] == false): ?>(<?php echo $this->_tpl_vars['form']['form_search1'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif;  echo $this->_tpl_vars['form']['form_print_flg2'][$this->_tpl_vars['i']]['html']; ?>
<br>
                <?php echo $this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['html']; ?>
<br>
                <?php echo $this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['html']; ?>

            </td>
                                    <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
                <td class="Value" align="right">一式<?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_num1'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <?php else: ?>
                <td class="Value" align="right"><font color=#555555>一式</font><?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_num1'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <?php endif; ?>
                        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_amount'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>

                        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['freeze_flg'] == false): ?>(<?php echo $this->_tpl_vars['form']['form_search3'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif; ?><br><?php echo $this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num3'][$this->_tpl_vars['i']]['html']; ?>
</td>

                        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['freeze_flg'] == false): ?>(<?php echo $this->_tpl_vars['form']['form_search2'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif; ?><br><?php echo $this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num2'][$this->_tpl_vars['i']]['html']; ?>
</td>

                        <td class="Value">
                <table height="20">
                                        <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
                    <tr style="color: red">
                        <td><?php echo $this->_tpl_vars['form']['form_aprice_div'][$this->_tpl_vars['i']]['html']; ?>
</td>
                        <td>
                            <?php echo $this->_tpl_vars['form']['form_br']['html']; ?>
<br>
                            <?php echo $this->_tpl_vars['form']['form_account_price'][$this->_tpl_vars['i']]['html']; ?>
円<br>
                            <?php echo $this->_tpl_vars['form']['form_account_rate'][$this->_tpl_vars['i']]['html']; ?>
%
                        </td>
                    <?php else: ?>
                    <tr>
                        <td><font color="#555555"><?php echo $this->_tpl_vars['form']['form_aprice_div'][$this->_tpl_vars['i']]['html']; ?>
</font></td>
                        <td><font color="#555555">
                            <?php echo $this->_tpl_vars['form']['form_br']['html']; ?>
<br>
                            <?php echo $this->_tpl_vars['form']['form_account_price'][$this->_tpl_vars['i']]['html']; ?>
円<br>
                            <?php echo $this->_tpl_vars['form']['form_account_rate'][$this->_tpl_vars['i']]['html']; ?>
%
                        </font></td>
                    <?php endif; ?>
                    </tr>
                </table>
            </td>

                        <td class="Value">
                                <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
                    <table cellspacing="0" cellpadding="0">
                        <tr style="color: red"><td><?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][1]['html']; ?>
</td><td></td></tr>
                        <tr style="color: red">
                            <td><?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][2]['html']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['form']['form_ad_offset_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
                        </tr>
                    </table>
                <?php else: ?>
                    <table cellspacing="0" cellpadding="0">
                        <tr><td><font color="#555555"><?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][1]['html']; ?>
</font></td><td></td></tr>
                        <tr>
                            <td><font color="#555555"><?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][2]['html']; ?>
</font></td>
                            <td><font color="#555555"><?php echo $this->_tpl_vars['form']['form_ad_offset_amount'][$this->_tpl_vars['i']]['html']; ?>
</font></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </td>

            <?php if ($this->_tpl_vars['var']['freeze_flg'] != true): ?>
            <td class="Value" align="center"><?php echo $this->_tpl_vars['form']['clear_line'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php endforeach; endif; unset($_from); ?>

    </table>

            </td>
        </tr>
    </table>


</fieldset>
<?php endif; ?>

<A NAME="foot"></A>
<?php if ($this->_tpl_vars['var']['slip_del_flg'] != true && $this->_tpl_vars['var']['buy_err_mess'] == null && $this->_tpl_vars['var']['done_flg'] != true): ?>
    <table width="100%">
        <tr>
            <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        </tr>
        <tr>
             
            <?php if ($this->_tpl_vars['var']['renew_flg'] == 'true'): ?>
                                <td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
            <?php elseif ($this->_tpl_vars['var']['client_id'] != null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
                 
                <td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['form_sale_btn']['html'];  if ($this->_tpl_vars['var']['new_entry'] == 'false'): ?>　<?php echo $this->_tpl_vars['form']['form_back_button']['html'];  endif; ?></td>
            <?php elseif ($this->_tpl_vars['var']['client_id'] != null && $this->_tpl_vars['var']['comp_flg'] == true): ?>
                 
                <td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['history_back']['html']; ?>
</td>
            <?php endif; ?>
        </tr>
    </table>
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
