<?php /* Smarty version 2.6.14, created on 2009-12-21 13:37:57
         compiled from 1-2-104.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['forward_num']; ?>

 </script>
 
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
    <?php if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['form_ord_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_ord_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_staff_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_staff_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['form_def_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_def_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_def_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_def_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['forward_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['forward_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['forward_num_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['forward_num_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_note_your']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note_your']['error']; ?>
<br>
    <?php endif; ?>
    <?php if (( $this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null ) || $this->_tpl_vars['var']['price_warning'] != null): ?>
        <font color="#ff00ff"><p>[�ٹ�]
        <?php if ($this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null): ?>
         <br><?php echo $this->_tpl_vars['var']['alert_message']; ?>
</font>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['var']['price_warning'] != null): ?>
        <br><?php echo $this->_tpl_vars['var']['price_warning']; ?>
</font>
            <br>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['form']['button']['alert_ok']['html']; ?>
<p>
    <?php endif; ?>
    </span>
 
<!-- �ե꡼������Ƚ�� -->
<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
	<span style="font: bold;"><font size="+1">�ʲ������ƤǼ����ޤ�����</font></span><br>
<?php endif; ?>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="800">
    <tr>
        <td>


<table class="Data_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
</td>
        <td class="Title_Pink">������</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['client_cd']; ?>
��<?php echo $this->_tpl_vars['var']['client_name']; ?>
</td>
        <td class="Title_Pink">FCȯ���ֹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['fc_ord_id']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_day']['html']; ?>
</td>
        <td class="Title_Pink">�вٲ�ǽ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_designated_date']['html']; ?>
 ����ޤǤ�ȯ��ѿ��Ȱ��������θ����</td>
        <td class="Title_Pink">����ô����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�в�ͽ����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_def_day']['html']; ?>
</td>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_select']['html']; ?>
</td>
        <td class="Title_Pink">�в��Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">��˾Ǽ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['hope_day']; ?>
</td>
        <td class="Title_Pink">ľ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['direct_name']; ?>
</td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_your']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['var']['note_my']; ?>
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

<table width="100%">
    <tr>
        <td>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">���ʥ�����<br>����̾</td>
        <td class="Title_Pink">��ê��<BR>��A��</td>
        <td class="Title_Pink">ȯ��ѿ�<BR>��B��</td>
        <td class="Title_Pink">������<BR>��C��</td>
        <td class="Title_Pink">�вٲ�ǽ��<BR>��A+B-C��</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink"><font color="#0000ff">����ñ��</font><br><font color="#ff0000">FCȯ��ñ��</font><br>���ñ��</td>
        <td class="Title_Pink"><font color="#0000ff">�������</font><br><font color="#ff0000">FCȯ����</font><br>�����</td>
        <td class="Title_Pink">�вٲ��<font color="#ff0000">��</font></font></td>
        <td class="Title_Pink">ʬǼ���в�ͽ����<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�вٿ�<font color="#ff0000">��</font></font></td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == true): ?>
    <tr bgcolor="pink" >
    <?php else: ?>
    <tr class="Result1">
    <?php endif; ?>
                <td align="right">
            <?php if ($_POST['show_button'] == "ɽ����"): ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php elseif ($_POST['f_page1'] != null): ?>
                <?php echo $_POST['f_page1']*10+$this->_tpl_vars['j']-9; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
                <td align="right"><a href="#" onClick="Open_mlessDialmg_g('1-2-107.php',<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,<?php echo $_SESSION['client_id']; ?>
,300,160);"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</a></td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
                <td align="right"><font color="#0000ff"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</font><br><font color="ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</font><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
                <td align="right"><font color="#0000ff"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</font><br><font color="ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</font><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_forward_times'][$this->_tpl_vars['j']]['html']; ?>
</td>
		<?php else: ?>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_forward_times'][$this->_tpl_vars['j']]['html']; ?>
</td>
		<?php endif; ?>
                <td align="center" width="130">
		<!-- �ե꡼������Ƚ��-->
		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
			<!-- �ե꡼������-->
			<?php $_from = $this->_tpl_vars['disp_count'][$this->_tpl_vars['j']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_day'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>
<br>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
			<!-- ���ɽ��-->
			<?php $_from = $this->_tpl_vars['num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_day'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>

        	<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
        </td>
        		<!-- �ե꡼������Ƚ��-->
		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
        <td align="right" width="130">
			<!-- �ե꡼������-->
			<?php $_from = $this->_tpl_vars['disp_count'][$this->_tpl_vars['j']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_num'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>
<br>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
        <td align="center" width="130">
			<!-- ���ɽ��-->
			<?php $_from = $this->_tpl_vars['num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
            	<?php echo $this->_tpl_vars['form']['form_forward_num'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>

        	<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right" class="List_Table" border="1" width="650">
    <tr>
        <td class="Title_Pink" align="center" width="80"><b>��ȴ���</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
        <td class="Title_Pink" align="center" width="80"><b>������</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
        <td class="Title_Pink" align="center" width="80"><b>�ǹ����</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
		 
		<?php if ($this->_tpl_vars['var']['comp_flg'] == null): ?>
			            <?php if (( $this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null ) || $this->_tpl_vars['var']['price_warning'] != null): ?> 
        	<td align="right" colspan="2">����<?php echo $this->_tpl_vars['form']['button']['back']['html']; ?>
</td>
            <?php else: ?>
        	<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['button']['entry']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['back']['html']; ?>
</td>
            <?php endif; ?>
		<?php else: ?>
			 
			<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
		<?php endif; ?>
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
