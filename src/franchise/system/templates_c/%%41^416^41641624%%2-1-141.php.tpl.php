<?php /* Smarty version 2.6.14, created on 2010-04-05 16:15:31
         compiled from 2-1-141.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>


<?php echo '
function h_column_disabled(f_obj) {

    if(f_obj.value == "3" ){
			//�Ķȸ���
			document.dateForm.elements["form_trade_price[1][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[1][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][2]"].readOnly = true;
		}
		

}
'; ?>



 </script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
<!-- ����Ƚ�� -->
<?php if ($this->_tpl_vars['var']['injust_msg'] == true): ?>
			    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold;"><font size="+1">�ʲ������ˤ�ꡢ�����˼��Ԥ��ޤ�����<br><br>��¾�Υ桼������˽�����Ԥä�<br>���֥饦�������ܥ��󤬲����줿<br><br></font></span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
</td>
	    </tr>
	</table>

<?php else: ?>

	    	    <tr align="center" valign="top">
	        <td>
	            <table>
	                <tr>
	                    <td>
		<!-- ���顼ɽ�� -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	<!-- ��󥿥��ֹ� -->
	<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
	    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
	<?php endif; ?>
	<!-- �桼�� -->
	<?php if ($this->_tpl_vars['var']['error_msg2'] != null): ?>
	    <li><?php echo $this->_tpl_vars['var']['error_msg2']; ?>
<br>
	<?php endif; ?>
	<!-- ������������å� -->
	<?php if ($this->_tpl_vars['var']['goods_error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['var']['goods_error']; ?>
<br>
	<?php endif; ?>
	<!-- ��󥿥뿽���� -->
	<?php if ($this->_tpl_vars['form']['form_rental_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_rental_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ��󥿥�в��� -->
	<?php if ($this->_tpl_vars['form']['form_forward_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_forward_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ����ô���� -->
	<?php if ($this->_tpl_vars['form']['form_app_staff']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_app_staff']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ���ô���� -->
	<?php if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ����� -->
	<?php if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ͹���ֹ� -->
	<?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ����1 -->
	<?php if ($this->_tpl_vars['form']['form_add1']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_add1']['error']; ?>
<br>
	<?php endif; ?>
	<!-- TEL -->
	<?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ���� -->
	<?php if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
	<?php endif; ?>

	<?php $_from = $this->_tpl_vars['error_loop_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
		<!-- ���ʥ����å� -->
		<?php if ($this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ���� -->
		<?php if ($this->_tpl_vars['form']['form_num'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_num'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ���ꥢ�� -->
		<?php $_from = $this->_tpl_vars['error_loop_num2'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
			<?php if ($this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['error'] != null): ?>
			    <li><?php echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['error']; ?>
<br>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<!-- ���ꥢ�������� -->
		<?php if ($this->_tpl_vars['form']['form_goods_cname'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_goods_cname'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ��󥿥�ñ�� -->
		<?php if ($this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- �桼��ñ�� -->
		<?php if ($this->_tpl_vars['form']['form_user_price'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_user_price'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ����� -->
		<?php if ($this->_tpl_vars['form']['form_renew_num'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_renew_num'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- �»��� -->
		<?php if ($this->_tpl_vars['form']['form_exec_day'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_exec_day'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ��������å� -->
		<?php if ($this->_tpl_vars['form']['form_calcel1'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_calcel1'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>

	</span>
	
		<!-- ��ǧ����Ƚ�� -->
	<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
		<!-- ����ɽ��Ƚ�� -->
		<?php if ($this->_tpl_vars['var']['disp_stat'] == 1 || $this->_tpl_vars['var']['disp_stat'] == 5 || $this->_tpl_vars['var']['disp_stat'] == 6): ?>
			<!-- ��󥿥�ID̵������úѡ����������� -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ���Ͽ���ޤ�����</font></span><br>
		<?php elseif (( $this->_tpl_vars['var']['disp_stat'] == 2 && $this->_tpl_vars['var']['stat_flg'] == false ) || $this->_tpl_vars['var']['online_flg'] == 'f'): ?>
			<!-- ����ѡ������(����ѤΤ�) -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ��ѹ����ޤ�����</font></span><br>
		<?php else: ?>
			<!-- ����ѡ�����ѡ�������������ͽ�� -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ��ѹ��������ޤ�����</font></span><br>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo $this->_tpl_vars['form']['hidden']; ?>

	<table width="100%">
	    <tr>
	        <td>

	<table class="Data_Table" border="1" width="600">
	<col width="120" style="font-weight: bold;">
	<tr>
	    <td class="Title_Purple" width="130"><?php echo $this->_tpl_vars['form']['online_flg']['label']; ?>
</td>
	    <td class="Value" ><?php echo $this->_tpl_vars['form']['online_flg']['html']; ?>
</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">��󥿥��ֹ�</td>
	    <td class="Value" ><?php echo $this->_tpl_vars['form']['form_rental_no']['html']; ?>
</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">����å�̾</td>
	    <td class="Value" ><?php echo $this->_tpl_vars['var']['shop_name']; ?>
</td>
	</tr>
	</table>
	<br>
	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	<col width="120" style="font-weight: bold;">
	    <tr>
	        <td class="Title_Purple" width="130">��󥿥뿽����<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rental_day']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">����ô����<font color="#ff0000">��</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_app_staff']['html']; ?>
</td>
			<td class="Title_Purple" width="130">���ô����<font color="#ff0000">��</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_round_staff']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">
			<!-- �桼�����ɽ��Ƚ�� -->
			<?php if ($this->_tpl_vars['var']['comp_flg'] == true): ?>
				<!-- ��ǧ���� -->
			    �桼��̾
			<?php else: ?>
				<!-- ��Ͽ���� -->
			    <?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>

			<?php endif; ?>
			<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">͹���ֹ�<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>

			<!-- ��ư���ϥܥ���ɽ��Ƚ�� -->
			<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
				<!-- ��ǧ���̤���ɽ�� -->
			    ����<?php echo $this->_tpl_vars['form']['input_auto']['html']; ?>

			<?php endif; ?>
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����1<font color="#ff0000">��</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add1']['html']; ?>
</td>
	        <td class="Title_Purple" width="130">����2</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add2']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����3<br>(�ӥ�̾��¾)</td>
	        <td class="Value" colspan=><?php echo $this->_tpl_vars['form']['form_add3']['html']; ?>
</td>
	        <td class="Title_Purple" width="130">����2<br>(�եꥬ��)</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add_read']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">�桼��TEL</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
	    </tr>
	</table>
	<br>

	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Purple" width="130">��󥿥�в���</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_forward_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����ô����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_head_staff']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">�����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day']['html']; ?>

			<!-- ����ѡ�����ѡ�������������ͽ��Τ�ɽ�� -->
			<?php if ($this->_tpl_vars['var']['disp_stat'] == 2 || $this->_tpl_vars['var']['disp_stat'] == 3 || $this->_tpl_vars['var']['disp_stat'] == 4): ?>
				 ����
			<?php endif; ?>
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����(������)</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_h_note']['html']; ?>
</td>
	    </tr>
	</table>
	<br>

	<!-- ����ɽ��Ƚ�� -->
	<?php if ($this->_tpl_vars['var']['disp_stat'] == 2 || $this->_tpl_vars['var']['disp_stat'] == 3 || $this->_tpl_vars['var']['disp_stat'] == 4): ?>
	<table border="0" width="900">
	<tr>
		<td align="right" width=900><b><font color="blue"><li>����饤��β����������ǧ��˼»ܤ���ޤ���</font></b></td>
	</tr>
	</table>

	<?php endif; ?>

	<!-- �桼������Ƚ�� -->
	<?php if ($this->_tpl_vars['var']['warning'] != null): ?>
		<!-- ����ʤ� -->
		<font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font>
	<?php else: ?>
		<!-- �ǡ���ɽ�� -->
		<table class="Data_Table" border="1" width="100%">
				<!-- ����ɽ��Ƚ�� -->
				<?php if ($this->_tpl_vars['var']['disp_stat'] == 1 || $this->_tpl_vars['var']['disp_stat'] == 5 || $this->_tpl_vars['var']['disp_stat'] == 6): ?>
					<!-- ��󥿥�ID̵������úѡ����������� -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">No.</td>
						<td class="Title_Purple">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
						<td class="Title_Purple">����<font color="#ff0000">��</font></td>
						<td class="Title_Purple">���ꥢ��
						<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
							<br><?php echo $this->_tpl_vars['form']['input_form_btn']['html']; ?>

						<?php endif; ?>
						</td>
						<td class="Title_Purple">��󥿥�ñ��<font color="#ff0000">��</font><br>�桼����ñ��<font color="#ff0000">��</font></td>
						<td class="Title_Purple">��󥿥���<br>�桼���󶡶��</td>
						<!-- ����������or��ǧ���̤Ϻ��̵�� -->
						<?php if ($this->_tpl_vars['var']['disp_stat'] != 6 && $this->_tpl_vars['var']['comp_flg'] != true): ?>
							<td class="Title_Add">���</td>
						<?php endif; ?>
					</tr>
				<?php else: ?>
					<!-- ����ѡ�����ѡ�������������ͽ�� -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple" rowspan="2">No.</td>
						<td class="Title_Purple" rowspan="2">����</td>
						<td class="Title_Purple" rowspan="2">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
						<td class="Title_Purple" rowspan="2">����<font color="#ff0000">��</font></td>
						<td class="Title_Purple" rowspan="2">���ꥢ��
						<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
							<br><?php echo $this->_tpl_vars['form']['input_form_btn']['html']; ?>

						<?php endif; ?>
						</td>
						<td class="Title_Purple" rowspan="2">��󥿥�ñ��<font color="#ff0000">��</font><br>�桼����ñ��<font color="#ff0000">��</font></td>
						<td class="Title_Purple" rowspan="2">��󥿥���<br>�桼���󶡶��</td>
						<td class="Title_Purple" rowspan="2">������</td>
						<td class="Title_Purple" colspan="3">����</td>
					<?php if ($this->_tpl_vars['var']['online_flg'] == f && $this->_tpl_vars['var']['comp_flg'] != true): ?>
						<td class="Title_Purple" rowspan="2">���</td>
					<?php endif; ?>
					</tr>
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">�����</td>
						<td class="Title_Purple">������ͳ</td>
						<td class="Title_Purple">�»���</td>
					</tr>

				<?php endif; ?>
			
			<?php echo $this->_tpl_vars['var']['html']; ?>

		</table>


		<A NAME="foot"></A>
		<table width="100%">
		<?php if ($this->_tpl_vars['var']['comp_flg'] == true): ?>
		<!-- ��ǧ���� -->
				<tr>
					<td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
					<td align="right"><?php echo $this->_tpl_vars['form']['ok_btn']['html']; ?>
����<?php echo $this->_tpl_vars['form']['back_btn']['html']; ?>
</td>
				</tr>
		<?php else: ?>
		<!-- ��Ͽ���� -->
				<tr>
					<td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
					<td align="right"><?php echo $this->_tpl_vars['form']['comp_btn']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_btn']['html']; ?>
</td>
				</tr>
				<tr>
					<td align="left"><?php echo $this->_tpl_vars['form']['add_row_btn']['html']; ?>
</td>
				</tr>
		<?php endif; ?>
		</table>
	<?php endif; ?>
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
