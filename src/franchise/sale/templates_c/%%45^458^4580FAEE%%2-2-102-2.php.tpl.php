<?php /* Smarty version 2.6.14, created on 2010-04-07 20:45:48
         compiled from 2-2-102-2.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<!-- styleseet -->
<style type="text/css">
	/** ǯ�٥��顼 **/
	font.color {
		color: #555555;
		font-size: 16px;
	    font-weight:bold;
	}
</style>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<!--------------------- ���ȳ��� --------------------->
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
		<td valign="top">

			<table>
				<tr>
					<td>
</form>
<!---------------------- ����ɽ��1���� ------------------->
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="450"><tr><td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['error_msg2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg2']; ?>
<br>
<?php endif; ?>
</span>

<table class="Data_Table" border="1" width="100%">
	<tr>
		<td class="Title_Pink" width="100" nowrap><b>����</b></td>
		<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_part_1']['html']; ?>
</td>
	</tr>
	<tr>
        <td class="Title_Pink" width="100"><b>���ô����</b></td>
        <td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
    </tr>
	<tr>
		<td class="Title_Pink" width="100"><b>ͽ������<font color="#ff0000">��</font></b></td>
		<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
	</tr>
		<?php if ($_SESSION['group_kind'] != '3'): ?>
		<tr>
        	<td class="Title_Pink" width="100"><b>�����</b></td>
        	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_fc']['html']; ?>
</td>
    	</tr>
	<?php endif; ?>
</table>
<table width="100%">
	<tr>
		<td align="right"><?php echo $this->_tpl_vars['form']['indicate_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
	</tr>
</table>

</td></tr></table>


<!--ɽ���ܥ��󤬲����줿���or�������⽵�ܥ��󲡲�or���إܥ�����ˡ���������ɽ�������������顼���ʤ��Ȥ��Τ�-->
<?php if (( $_POST['indicate_button'] == "ɽ����" || $_POST['back_w_button_flg'] == true || $_POST['next_w_button_flg'] == true ) && $this->_tpl_vars['var']['error_msg'] == NULL): ?>
	<br>
	<font size="+0.5" color="#555555"><b>�ڥ�������ɽ�����֡�<?php echo $this->_tpl_vars['var']['cal_range']; ?>
��</b></font>
	<!---------------------- ����ɽ��1��λ ---------------------->
	<br>
	<hr>
	<!---------------------- �̾參������ ---------------------->
	<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
		<A NAME="<?php echo $this->_tpl_vars['i']; ?>
">
		<A NAME="<?php echo $this->_tpl_vars['j']; ?>
m">
		
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button'][$this->_tpl_vars['i']]['html']; ?>
��<?php echo $this->_tpl_vars['var']['year']; ?>
ǯ <?php echo $this->_tpl_vars['var']['month']; ?>
�<?php echo $this->_tpl_vars['form']['next_w_button'][$this->_tpl_vars['i']]['html']; ?>
</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>����ɼ���̡���<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="675">
				<tr>
					<td class="Title_Pink" width="100"><b>����</b></td>
					<td class="Value" align="left" width="125"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0][0]; ?>
</td>
					<td class="Title_Pink" width="100"><b>ͽ����</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0][1]; ?>
��</td>
					<td class="Title_Pink" width="100"><b>ͽ����</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0][2]; ?>
</td>
				</tr>
			</table>
			</td>
			<td align="left">
				<table width="410">
				<tr>
					<td><?php echo $this->_tpl_vars['form']['form_slip_button']['html']; ?>
</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		
		<table class="Data_Table" height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">
		
		<?php echo $this->_tpl_vars['calendar'][$this->_tpl_vars['i']]; ?>


		<?php echo $this->_tpl_vars['calendar3'][$this->_tpl_vars['i']]; ?>


				<?php $_from = $this->_tpl_vars['calendar2'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
			<?php echo $this->_tpl_vars['calendar2'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>

		<?php endforeach; endif; unset($_from); ?>

		</table>
		</A>
		</A>
		<br>
		<hr>
		<br>

	<?php endforeach; endif; unset($_from); ?>

	<!---------------------- ��ԥ������� ---------------------->
	<?php $_from = $this->_tpl_vars['act_disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
		<A NAME="<?php echo $this->_tpl_vars['i']; ?>
">
		
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button'][$this->_tpl_vars['i']]['html']; ?>
��<?php echo $this->_tpl_vars['var']['year']; ?>
ǯ <?php echo $this->_tpl_vars['var']['month']; ?>
�<?php echo $this->_tpl_vars['form']['next_w_button'][$this->_tpl_vars['i']]['html']; ?>
</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>����ɼ���̡���<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="450">
				<tr>
					<td class="Title_Pink" width="100"><b>ͽ����</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['act_disp_data'][$this->_tpl_vars['i']][0][0]; ?>
��</td>
					<td class="Title_Pink" width="100"><b>ͽ����</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['act_disp_data'][$this->_tpl_vars['i']][0][1]; ?>
</td>
				</tr>
			</table>
			</td>
			<td align="left">
				<table width="410">
				<tr>
					<td><?php echo $this->_tpl_vars['form']['form_slip_button']['html']; ?>
</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		
		<table class="Data_Table" height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">
		
		<?php echo $this->_tpl_vars['act_calendar'][$this->_tpl_vars['i']]; ?>


		<?php echo $this->_tpl_vars['act_calendar3'][$this->_tpl_vars['i']]; ?>


		<?php echo $this->_tpl_vars['act_calendar2'][$this->_tpl_vars['i']]; ?>


		</table>
		</A>
		<br>
		<hr>
		<br>

	<?php endforeach; endif; unset($_from); ?>

	<!-- �ǡ�����̵����硢������ܥ������ɽ�� -->
	<?php if ($this->_tpl_vars['var']['data_msg'] != NULL && $this->_tpl_vars['var']['act_data_flg'] == false): ?>
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button']['html']; ?>
��<?php echo $this->_tpl_vars['var']['year']; ?>
ǯ <?php echo $this->_tpl_vars['var']['month']; ?>
�<?php echo $this->_tpl_vars['form']['next_w_button']['html']; ?>
</font><br><br>
		<!-- ���顼ɽ�� -->
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;"><?php echo $this->_tpl_vars['var']['data_msg']; ?>
</span></font>
	<?php endif;  endif; ?>
<!--******************** ����2ɽ����λ *******************-->
					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
