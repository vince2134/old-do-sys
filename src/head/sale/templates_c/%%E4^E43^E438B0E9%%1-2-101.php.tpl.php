<?php /* Smarty version 2.6.14, created on 2009-12-06 13:03:07
         compiled from 1-2-101.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<?php echo $this->_tpl_vars['var']['form_potision']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['html_js']; ?>

</script>


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
<?php if ($this->_tpl_vars['form']['form_order_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_order_no']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_designated_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_designated_date']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_arr_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_arr_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['trade_aord_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['trade_aord_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_staff_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_staff_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_trans_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_trans_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_note_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_note_client']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_note_head']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_note_head']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_sale_num']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_num']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['goods_error0'] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error0']; ?>
<br>
<?php endif;  $_from = $this->_tpl_vars['goods_error1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error1'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error1'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error2'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error2'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error3'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error3'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error4'] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error4'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error5'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error5'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  if ($this->_tpl_vars['var']['duplicate_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['duplicate_err']; ?>
<br>
<?php endif;  $_from = $this->_tpl_vars['duplicate_goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['duplicate_goods_err'][$this->_tpl_vars['i']]; ?>
<br>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['var']['forward_day_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['forward_day_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['forward_num_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['forward_num_err']; ?>
<br>
<?php endif; ?>


</span>

<!-- �ե꡼������Ƚ�� -->
<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
	<span style="font: bold;"><font size="+1">�ʲ������ƤǼ����ޤ�����</font></span><br>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
</td>
        <td class="Title_Pink">
		 
        <?php if ($this->_tpl_vars['var']['comp_flg'] == null && $this->_tpl_vars['var']['check_flg'] != true && $_GET['aord_id'] == null): ?>
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,6,1);">������</a>
		<?php else: ?>
            ������
        <?php endif; ?>
		<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
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
        <td class="Title_Pink">�в�ͽ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arr_day']['html']; ?>
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
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_hope_day']['html']; ?>
</td>
		                <td class="Title_Pink">
		 
        <?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-260.php',Array('form_direct_text[cd]','form_direct_text[name]','form_direct_text[claim]','hdn_direct_search_flg'),500,450,'1-3-207',1);">ľ����</a>
		<?php else: ?>
            ľ����
        <?php endif; ?>
		</td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_text']['cd']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_direct_text']['name']['html']; ?>
&nbsp;&nbsp;�����衧<?php echo $this->_tpl_vars['form']['form_direct_text']['claim']['html']; ?>
</td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['trade_aord_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_client']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_head']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['warning'] != null): ?><font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font><?php endif; ?>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr class="Result1" align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">���ʥ�����<font color="#ff0000">��</font><br>����̾<font color="#ff0000">��</font></td>
        <td class="Title_Pink">��ê��<br>(A)</td>
        <td class="Title_Pink">ȯ��ѿ�<br>(B)</td>
        <td class="Title_Pink">������<br>(C)</td>
        <td class="Title_Pink">�вٲ�ǽ��<br>(A+B-C)</td>
		<?php if ($this->_tpl_vars['var']['edit_flg'] == 'true'): ?>
	        <td class="Title_Pink">�����<font color="#ff0000">��</font></td>
		<?php endif; ?>
        <td class="Title_Pink">����ñ��<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�������<br>�����</td>
		<?php if ($this->_tpl_vars['var']['edit_flg'] != 'true'): ?>
	        <td class="Title_Pink">�вٲ��<font color="#ff0000">��</font></td>
    	    <td class="Title_Pink">ʬǼ���в�ͽ����<font color="#ff0000">��</font></td>
        	<td class="Title_Pink">�вٿ�<font color="#ff0000">��</font></td>
		<?php endif; ?>
    <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
        <td class="Title_Add" width="50">�Ժ��</td>
    <?php endif; ?>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>

<table width="100%">
    <tr>
        <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
            <td><?php echo $this->_tpl_vars['form']['add_row_link']['html']; ?>
</td>
        <?php endif; ?>
        <td align="right">
            <table class="List_Table" border="1" width="600">
                <tr>
                    <td class="Title_Pink" width="80" align="center"><b>��ȴ���</b></td>
                    <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
                    <td class="Title_Pink" width="80" align="center"><b>������</b></td>
                    <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
                    <td class="Title_Pink" width="80" align="center"><b>�ǹ����</b></td>
                    <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
            <td><?php echo $this->_tpl_vars['form']['form_sum_button']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
</table>

<A NAME="foot"></A>
<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
		 
		<?php if ($this->_tpl_vars['var']['comp_flg'] == null): ?>
			<td align="right" colspan="2">
															<?php echo $this->_tpl_vars['form']['order']['html']; ?>

        	</td>
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
