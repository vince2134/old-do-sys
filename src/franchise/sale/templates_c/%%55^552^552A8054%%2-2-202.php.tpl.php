<?php /* Smarty version 2.6.14, created on 2009-12-22 11:46:17
         compiled from 2-2-202.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<!--
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>

//-->
</script>

<?php if (( $this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '2' ) && $this->_tpl_vars['var']['freeze_flg'] != true): ?>
    <body bgcolor="#D8D0C8" onLoad="ad_offset_radio_disable();">
<?php else: ?>
    <body bgcolor="#D8D0C8">
<?php endif; ?>
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!--------------------- ���ȳ��� --------------------->
<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            <!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
        </td>
    </tr>

<!-- ������Ƚ�� -->
<?php if ($this->_tpl_vars['var']['error_msg14'] != null): ?>

		    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold; color:red;"><font size="+1"><?php echo $this->_tpl_vars['var']['error_msg14']; ?>
</font></span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
</td>
	    </tr>
	</table>

<?php elseif ($this->_tpl_vars['var']['buy_err_mess'] != null): ?>

		    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold; color:red;">
        <font size="+1"><?php echo $this->_tpl_vars['var']['buy_err_mess']; ?>
�λ�����������������������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���</font>
    </span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
</td>
	    </tr>
	</table>

<?php else: ?>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

<!---------------------- ����ɽ��1���� --------------------->



<!---- ******************** ����ɽ��1��λ ******************* -->


<!---------------------- ����ɽ��2���� ---------------------->
<!-- ���顼ɽ�� -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
<!-- �������� -->
<?php if ($this->_tpl_vars['var']['slip_renew_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['slip_renew_mess']; ?>
<br>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['concurrent_err_flg'] != true): ?>
    <!-- ������ -->
    <?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_delivery_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_delivery_day']['error']; ?>
<br>
    <?php endif; ?>
    <!-- ������ -->
    <?php if ($this->_tpl_vars['form']['form_request_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_request_day']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ���� -->
    <?php if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['form']['form_ad_offset_total']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ad_offset_total']['error']; ?>
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

    <!-- ������(������) -->
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

    <!-- ������(Ψ) -->
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

    <!-- �����ʬ -->
    <?php if ($this->_tpl_vars['form']['trade_aord']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_aord']['error']; ?>
<br>
    <?php endif; ?>
    <!-- ������ͳ -->
    <?php if ($this->_tpl_vars['form']['form_reason']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_reason']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ô���ᥤ�� -->
    <?php if ($this->_tpl_vars['form']['form_c_staff_id1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_c_staff_id1']['error']; ?>
<br>
    <?php endif; ?>
    <!-- ���Ψ��ô���ᥤ�󤬤�����˥��顼Ƚ�� -->
    <?php if ($this->_tpl_vars['form']['form_sale_rate1']['error'] != null && $this->_tpl_vars['form']['form_c_staff_id1']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_rate1']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ô�����֣� -->
    <?php if ($this->_tpl_vars['form']['form_c_staff_id2']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_c_staff_id2']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_rate2']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_rate2']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ô�����֣� -->
    <?php if ($this->_tpl_vars['form']['form_c_staff_id3']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_c_staff_id3']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_rate3']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_rate3']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ô�����֣� -->
    <?php if ($this->_tpl_vars['form']['form_c_staff_id4']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_c_staff_id4']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_sale_rate4']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_sale_rate4']['error']; ?>
<br>
    <?php endif; ?>

    <!-- ���ô���Խ�ʣȽ�� -->
    <?php if ($this->_tpl_vars['var']['error_msg2'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_msg2']; ?>
<br>
    <?php endif; ?>

    <!-- �����ӥ��������ƥ�����Ƚ�� -->
    <?php if ($this->_tpl_vars['var']['error_msg3'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_msg3']; ?>
<br>
    <?php endif; ?>

    <!-- ���Ψ -->
    <?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
    <?php endif; ?>
    <?php $_from = $this->_tpl_vars['error_loop_num3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['error_msg10'][$this->_tpl_vars['i']] != null): ?>
            <li><?php echo $this->_tpl_vars['error_msg10'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    <!-- �����ӥ������������硢�����ӥ�ID�����뤫Ƚ�� -->
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

    <!-- �����ƥ�����������硢�����ƥ�ID�����뤫Ƚ�� -->
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

    <!-- ��ϩ -->
    <?php if ($this->_tpl_vars['form']['form_route_load']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_route_load']['error']; ?>
<br>
    <?php endif; ?>

    <!-- �����ʬ -->
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

    <!-- �����ӥ��������켰�ե饰 -->
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

    <!-- �����ӥ������������ƥ���� -->
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

    <!-- ���ΰ���������ID -->
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

    <!-- �����ƥॳ����-->
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

    <!-- ���̡��켰-->
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

    <!-- ���ο��� -->
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

    <!-- �����ʿ��� -->
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

    <!-- �Ķȸ��� -->
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

    <!-- ���ñ�� -->
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

    <?php $_from = $this->_tpl_vars['error_loop_num1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        <?php $_from = $this->_tpl_vars['error_loop_num2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
            <!-- �����αĶȸ��� -->
            <?php if ($this->_tpl_vars['error_msg6'][$this->_tpl_vars['i']][$this->_tpl_vars['j']] != null): ?>
                <li><?php echo $this->_tpl_vars['error_msg6'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
<br>
            <?php endif; ?>
            <!-- ���������ñ�� -->
            <?php if ($this->_tpl_vars['error_msg7'][$this->_tpl_vars['i']][$this->_tpl_vars['j']] != null): ?>
                <li><?php echo $this->_tpl_vars['error_msg7'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
<br>
            <?php endif; ?>
            <!-- �����ο���-->
            <?php if ($this->_tpl_vars['error_msg8'][$this->_tpl_vars['i']][$this->_tpl_vars['j']] != null): ?>
                <li><?php echo $this->_tpl_vars['error_msg8'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
<br>
            <?php endif; ?>
            <!-- �����Υ����ƥ�-->
            <?php if ($this->_tpl_vars['error_msg11'][$this->_tpl_vars['i']][$this->_tpl_vars['j']] != null): ?>
                <li><?php echo $this->_tpl_vars['error_msg11'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
<br>
            <?php endif; ?>
            <!-- ����������Ƚ��-->
            <?php if ($this->_tpl_vars['error_msg13'][$this->_tpl_vars['i']][$this->_tpl_vars['j']] != null): ?>
                <li><?php echo $this->_tpl_vars['error_msg13'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
<br>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>

    <!-- �����ӥ������� -->
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

    <!-- ���Ρ����� -->
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

    <!-- �����ʡ����� -->
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

<?php endif; ?>

    </ul>
</span>

<?php if ($this->_tpl_vars['var']['error_flg'] != true && $this->_tpl_vars['var']['ad_total_warn_mess'] != null): ?>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[�ٹ�]<br><?php echo $this->_tpl_vars['var']['ad_total_warn_mess']; ?>
</font><br><br>
    <?php echo $this->_tpl_vars['form']['form_ad_warn']['html']; ?>
<br><br>
    </td></tr>
</table>
<?php endif; ?>

<fieldset>
<legend>
    <span style="font: bold 15px; color: #555555;">����ɼ�ֹ�ۡ� <?php echo $this->_tpl_vars['var']['ord_no']; ?>
 </span>
    </legend>
<BR>
<table class="List_Table" border="1" width="400">
    <tr class="Result1">
        <td class="Title_Pink" width="78" align="center"><b>��Զ�ʬ</b></td>
        <td class="Value"><?php if ($this->_tpl_vars['var']['contract_div'] == '1'): ?>���ҽ��<?php elseif ($this->_tpl_vars['var']['contract_div'] == '2'): ?>����饤�����<?php else: ?>���ե饤�����<?php endif; ?></td>
    </tr>
    <tr class="Result1">
        <td class="Title_Pink" width="78" align="center"><b>�����</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['round_form']; ?>
</td>
    </tr>
</table>
<BR>
<table class="List_Table" border="1">
    <tr align="center">
        <td class="Title_Pink" width=""><b>ͽ������<font color="red">��</font></b></td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '3'): ?>
        <td class="Title_Pink" width=""><b>��ϩ<font color="red">��</font></b></td>
        <?php endif; ?>
        <td class="Title_Pink" width=""><b>������</b></td>
        <td class="Title_Pink" width=""><b>�����ʬ<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>������</b></td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '3'): ?>
        <td class="Title_Pink" width=""><b>���ô��������</b></td>
        <?php endif; ?>
    </tr>

    <tr class="Result1">
        <td align="center" width="150"><?php echo $this->_tpl_vars['form']['form_delivery_day']['html']; ?>
</td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '3'): ?>
        <td align="left"><?php echo $this->_tpl_vars['form']['form_route_load']['html']; ?>
</td>
        <?php endif; ?>
        <td align="left" width="180">
            <?php echo $this->_tpl_vars['form']['form_client']['cd1']['html']; ?>
&nbsp;-&nbsp;<?php echo $this->_tpl_vars['form']['form_client']['cd2']['html'];  echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<br>
            <?php echo $this->_tpl_vars['form']['form_client']['name']['html']; ?>

        </td>
        <td align="left"><?php echo $this->_tpl_vars['form']['trade_aord']['html']; ?>
</td>
        <td align="center" width="150"><?php echo $this->_tpl_vars['form']['form_request_day']['html']; ?>
</td>
        <td align="left" width="180"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '3'): ?>
        <td align="left">
            <table >
                <tr>
                    <td><font color="#555555">
                        �ᥤ��1<b><font color="#ff0000">��</font></b> <?php echo $this->_tpl_vars['form']['form_c_staff_id1']['html']; ?>
�����<?php echo $this->_tpl_vars['form']['form_sale_rate1']['html']; ?>
��<br>
                        ����2�� <b>��</b><?php echo $this->_tpl_vars['form']['form_c_staff_id2']['html']; ?>
�����<?php echo $this->_tpl_vars['form']['form_sale_rate2']['html']; ?>
��<br>
                        ����3�� <b>��</b><?php echo $this->_tpl_vars['form']['form_c_staff_id3']['html']; ?>
�����<?php echo $this->_tpl_vars['form']['form_sale_rate3']['html']; ?>
��<br>
                        ����4�� <b>��</b><?php echo $this->_tpl_vars['form']['form_c_staff_id4']['html']; ?>
�����<?php echo $this->_tpl_vars['form']['form_sale_rate4']['html']; ?>
��<br>
                        </font>
                    </td>
                </tr>
            </table>
        </td>
        <?php endif; ?>
    </tr>

        <?php if ($this->_tpl_vars['var']['hand_plan_flg'] == true): ?>
        <tr class="Result1">
            <td class="Title_Purple" width="110"><b>ľ����</b></td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1'): ?>
            <td class="Value" width="185" colspan="7"><?php echo $this->_tpl_vars['form']['form_direct_select']['html']; ?>
</td>
        <?php else: ?>
            <td class="Value" width="185" colspan="4"><?php echo $this->_tpl_vars['form']['form_direct_select']['html']; ?>
</td>
        <?php endif; ?>
        </tr>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '2'): ?>
        <tr class="Result1">
            <td class="Title_Purple" width="110"><b>�Ҳ������</b></td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == '1'): ?>
            <td class="Value" width="185" colspan="3"><nobr><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</nobr></td>
            <td class="Title_Purple" width="110"><b><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['label']; ?>
</b></td>
            <td class="Value" width="185" colspan="3">
        <?php else: ?>
            <td class="Value" width="185" colspan="2"><nobr><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</nobr></td>
            <td class="Title_Purple" width="110"><b><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['label']; ?>
</b></td>
            <td class="Value" width="185" colspan="">
        <?php endif; ?>
                <table cellpadding="0" cellspacing="0" style="color: #555555;">
                    <?php if ($this->_tpl_vars['var']['ac_name'] == "̵��"): ?>
                    <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>
</td></tr>
                    <?php else: ?>
                    <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][0]['html'];  echo $this->_tpl_vars['form']['intro_ac_price']['html']; ?>
��</td><td>��<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>
</td></tr>
                    <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['html'];  echo $this->_tpl_vars['form']['intro_ac_rate']['html']; ?>
��</td><td></td></tr>
                    <tr><td><?php echo $this->_tpl_vars['form']['intro_ac_div'][2]['html']; ?>
</td><td></td></tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] != '2'): ?>
        <tr class="Result1">
            <td class="Title_Pink"><b>����</b></td>
            <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
            <td class="Title_Pink"><b>������ͳ<font color="red">��</font></b></td>
            <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_reason']['html']; ?>
</td>
        </tr>
        <tr class="Result1">
            <td class="Title_Pink"><b>��ȴ���<br>������</b></td>
            <td class="Value" colspan="3" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
            <td class="Title_Pink"><b>��ɼ���</b></td>
            <td class="Value" colspan="4" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
        </tr>

    <?php else: ?>
        <tr class="Result1">
            <td class="Title_Purple"><b>������</b></td>
            <td class="Value" colspan="2"><nobr><?php echo $this->_tpl_vars['form']['form_act_cd']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_act_name']['html']; ?>
</nobr></td>
            <td class="Title_Purple"><b>��԰�����<br>(��ȴ)</b></td>
            <?php if ($this->_tpl_vars['form']['form_act_price']['value'] == "ȯ�����ʤ�"): ?>
            <td class="Value" colspan="3" align="left"><?php echo $this->_tpl_vars['form']['form_act_price']['html']; ?>
</td>
            <?php else: ?>
            <td class="Value" colspan="3" align="right"><?php echo $this->_tpl_vars['form']['form_act_price']['html']; ?>
</td>
            <?php endif; ?>
        </tr>
        <tr class="Result1">
            <td class="Title_Pink"><b>����</b></td>
            <td class="Value" colspan="2"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
            <td class="Title_Pink"><b>������ͳ<font color="red">��</font></b></td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_reason']['html']; ?>
</td>
        </tr>
        <tr class="Result1">
            <td class="Title_Pink"><b>��ȴ���<br>������</b></td>
            <td class="Value" colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
            <td class="Title_Pink"><b>��ɼ���</b></td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
        </tr>
    <?php endif; ?>

        <?php if ($this->_tpl_vars['var']['contract_div'] == '1' || $_SESSION['group_kind'] == '2'): ?>
        <tr class="Result1">
            <td class="Title_Pink">
            <table width="100%" cellspacing="0" cellpadding="0"><tr>
                <td class="Title_Pink"><b>������Ĺ�</b></td>
                <?php if ($this->_tpl_vars['var']['renew_flg'] != 'true'): ?>
                <td align="right"><?php echo $this->_tpl_vars['form']['form_ad_sum_btn']['html']; ?>
</td>
                <?php endif; ?>
            </tr></table>
            </td>
            <?php if ($this->_tpl_vars['var']['contract_div'] == '1'): ?>
            <td class="Value" align="right" colspan="3"><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['html']; ?>
</td>
            <td class="Title_Pink" ><b>�����껦�۹��</b></td>
            <td class="Value" align="right" colspan="2"><?php echo $this->_tpl_vars['form']['form_ad_offset_total']['html']; ?>
</td>
            <?php else: ?>
            <td class="Value" align="right" colspan="2"><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['html']; ?>
</td>
            <td class="Title_Pink" ><b>�����껦�۹��</b></td>
            <td class="Value" align="right" colspan="1"><?php echo $this->_tpl_vars['form']['form_ad_offset_total']['html']; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php endif; ?>

</table>
<BR>

<A NAME="hand">

<table border="0" width="985">
    <tr>
    <td align="left"><font size="+0.5" color="#555555"><b>�ھ��ʽв��Ҹˡ�<?php echo $this->_tpl_vars['var']['ware_name']; ?>
��</b></font></td>
    <td align="left" width=922><b><font color="blue">
        <li>�����껦�۰ʳ�����ȴ��ۤ���Ͽ���Ƥ���������
        <li>�֥����ӥ�̾�ס֥����ƥ�פ˥����å����դ������ɼ�˰�������ޤ�
    </font></b></td>
    </tr>
</table>

<table class="Data_Table" border="1" width="950">
    <tr>
        <td class="Title_Purple" rowspan="2"><b>�����ʬ<font color="#ff0000">��</font></b></td>
        <td class="Title_Purple" rowspan="2"><b>�����ӥ�̾</b></td>
        <td class="Title_Purple" rowspan="2"><b>�����ƥ�</b></td>
        <td class="Title_Purple" rowspan="2"><b>����</b></td>
        <td class="Title_Purple" colspan="2"><b>���</b></td>
        <td class="Title_Purple" rowspan="2"><b>������</b></td>
        <td class="Title_Purple" rowspan="2"><b>����</b></td>
        <td class="Title_Purple" rowspan="2"><b>���ξ���</b></td>
        <td class="Title_Purple" rowspan="2"><b>����</b></td>
        <?php if ($this->_tpl_vars['var']['contract_div'] == 1 || $_SESSION['group_kind'] == '2'): ?>
            <td class="Title_Purple" rowspan="2"><b>������<br>(����ñ��)</b></td>
            <td class="Title_Purple" rowspan="2"><b>�����껦��</b></td>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['var']['contract_div'] == 1 && $this->_tpl_vars['var']['freeze_flg'] != true): ?>
            <td class="Title_Purple" rowspan="2"><b>���ꥢ</b></td>
        <?php endif; ?>
    </tr>

    <tr>
        <td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></b></td>
        <td class="Title_Purple" ><b>������׳�<br>����׳�</b></td>
    </tr>
    
    <?php $_from = $this->_tpl_vars['loop_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
                <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
            <tr class="Value" style="color: red">
        <?php else: ?>
            <tr>
        <?php endif; ?>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_divide'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_print_flg1'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_serv'][$this->_tpl_vars['i']]['html']; ?>
</td>
                        <td class="Value">
                <?php echo $this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['renew_flg'] != true): ?>(<?php echo $this->_tpl_vars['form']['form_search1'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif;  echo $this->_tpl_vars['form']['form_print_flg2'][$this->_tpl_vars['i']]['html']; ?>
<br>
                <?php echo $this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['html']; ?>
<br>
                <?php echo $this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['html']; ?>

            </td>
            <td class="Value" align="right">
						<?php if ($this->_tpl_vars['var']['contract_div'] == 1): ?>
                                  <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
                     �켰
                 <?php else: ?>
                     <font color="#555555">�켰</font>
                 <?php endif; ?>
            <?php endif; ?>
            <?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_num1'][$this->_tpl_vars['i']]['html']; ?>

            </td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_amount'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['renew_flg'] != true): ?>(<?php echo $this->_tpl_vars['form']['form_search3'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif; ?><br><?php echo $this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num3'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['renew_flg'] != true): ?>(<?php echo $this->_tpl_vars['form']['form_search2'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif; ?><br><?php echo $this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num2'][$this->_tpl_vars['i']]['html']; ?>
</td>

            <?php if ($this->_tpl_vars['var']['contract_div'] == 1 || $_SESSION['group_kind'] == '2'): ?>
                        <td class="Value">
                                <?php if ($this->_tpl_vars['toSmarty_discount_flg'][$this->_tpl_vars['i']] === 't'): ?>
                    <table height="20"><tr style="color: red">
                    <td><?php echo $this->_tpl_vars['form']['form_aprice_div'][$this->_tpl_vars['i']]['html']; ?>
</td>
                    <td>
                        <br>
                        <?php echo $this->_tpl_vars['form']['form_account_price'][$this->_tpl_vars['i']]['html']; ?>
��<br>
                        <?php echo $this->_tpl_vars['form']['form_account_rate'][$this->_tpl_vars['i']]['html']; ?>
%
                    </td>
                    </tr></table>
                <?php else: ?>
                    <table height="20"><tr>
                    <td><font color="#555555"><?php echo $this->_tpl_vars['form']['form_aprice_div'][$this->_tpl_vars['i']]['html']; ?>
</font></td>
                    <td>
                        <br><font color="#555555">
                        <?php echo $this->_tpl_vars['form']['form_account_price'][$this->_tpl_vars['i']]['html']; ?>
��<br>
                        <?php echo $this->_tpl_vars['form']['form_account_rate'][$this->_tpl_vars['i']]['html']; ?>
%
                        </font>
                    </td>
                    </tr></table>
                <?php endif; ?>
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
            <?php endif; ?>


            <?php if ($this->_tpl_vars['var']['contract_div'] == 1 && $this->_tpl_vars['var']['freeze_flg'] != true): ?>
                <td class="Value" align="center"><?php echo $this->_tpl_vars['form']['clear_line'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<table width="960">
    <tr>
        <td align='right'><?php if ($this->_tpl_vars['var']['renew_flg'] != true):  echo $this->_tpl_vars['form']['clear_button']['html'];  endif; ?></td>
    </tr>
</table>

</A>

</fieldset>

<table border="0" width="970">
<?php if ($this->_tpl_vars['var']['client_id'] == NULL): ?>
    <tr>
        <td align="left"><b><font color="red">����������򤷤Ƥ���������</font></b></td>
    </tr>
<?php endif; ?>
    <tr>
        <td align="left"><b><font color="red">����ɬ�����ϤǤ�</font></b></td>
    </tr>
    <tr>
        <td align='right'>
<?php if ($this->_tpl_vars['var']['concurrent_err_flg'] == true): ?>
            <?php echo $this->_tpl_vars['form']['form_ok_btn']['html']; ?>

<?php else: ?>
    <?php if ($this->_tpl_vars['var']['client_id'] != NULL && $this->_tpl_vars['var']['renew_flg'] != true): ?>
                <?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>

    <?php endif; ?>
                ����<?php echo $this->_tpl_vars['form']['form_back_btn']['html']; ?>

<?php endif; ?>
        </td>
    </tr>
</table>
<?php endif; ?>
<!--******************** ����ɽ��2��λ *******************-->

                    </td>
                </tr>
            </table>
        </td>
        <!--******************** ����ɽ����λ *******************-->

    </tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

