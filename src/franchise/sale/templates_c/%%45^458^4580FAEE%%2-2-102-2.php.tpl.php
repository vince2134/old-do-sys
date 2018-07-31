<?php /* Smarty version 2.6.14, created on 2010-04-07 20:45:48
         compiled from 2-2-102-2.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<!-- styleseet -->
<style type="text/css">
	/** 年度カラー **/
	font.color {
		color: #555555;
		font-size: 16px;
	    font-weight:bold;
	}
</style>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<!--------------------- 外枠開始 --------------------->
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
		<td valign="top">

			<table>
				<tr>
					<td>
</form>
<!---------------------- 画面表示1開始 ------------------->
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
		<td class="Title_Pink" width="100" nowrap><b>部署</b></td>
		<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_part_1']['html']; ?>
</td>
	</tr>
	<tr>
        <td class="Title_Pink" width="100"><b>巡回担当者</b></td>
        <td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
    </tr>
	<tr>
		<td class="Title_Pink" width="100"><b>予定巡回日<font color="#ff0000">※</font></b></td>
		<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
	</tr>
		<?php if ($_SESSION['group_kind'] != '3'): ?>
		<tr>
        	<td class="Title_Pink" width="100"><b>代行先</b></td>
        	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_fc']['html']; ?>
</td>
    	</tr>
	<?php endif; ?>
</table>
<table width="100%">
	<tr>
		<td align="right"><?php echo $this->_tpl_vars['form']['indicate_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
	</tr>
</table>

</td></tr></table>


<!--表示ボタンが押された場合or前週・翌週ボタン押下or切替ボタン時に、カレンダー表示、ただしエラーがないときのみ-->
<?php if (( $_POST['indicate_button'] == "表　示" || $_POST['back_w_button_flg'] == true || $_POST['next_w_button_flg'] == true ) && $this->_tpl_vars['var']['error_msg'] == NULL): ?>
	<br>
	<font size="+0.5" color="#555555"><b>【カレンダー表示期間：<?php echo $this->_tpl_vars['var']['cal_range']; ?>
】</b></font>
	<!---------------------- 画面表示1終了 ---------------------->
	<br>
	<hr>
	<!---------------------- 通常カレンダー ---------------------->
	<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
		<A NAME="<?php echo $this->_tpl_vars['i']; ?>
">
		<A NAME="<?php echo $this->_tpl_vars['j']; ?>
m">
		
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button'][$this->_tpl_vars['i']]['html']; ?>
　<?php echo $this->_tpl_vars['var']['year']; ?>
年 <?php echo $this->_tpl_vars['var']['month']; ?>
月　<?php echo $this->_tpl_vars['form']['next_w_button'][$this->_tpl_vars['i']]['html']; ?>
</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>【伝票識別　　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="675">
				<tr>
					<td class="Title_Pink" width="100"><b>部署</b></td>
					<td class="Value" align="left" width="125"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0][0]; ?>
</td>
					<td class="Title_Pink" width="100"><b>予定件数</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0][1]; ?>
件</td>
					<td class="Title_Pink" width="100"><b>予定金額</b></td>
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

	<!---------------------- 代行カレンダー ---------------------->
	<?php $_from = $this->_tpl_vars['act_disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
		<A NAME="<?php echo $this->_tpl_vars['i']; ?>
">
		
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button'][$this->_tpl_vars['i']]['html']; ?>
　<?php echo $this->_tpl_vars['var']['year']; ?>
年 <?php echo $this->_tpl_vars['var']['month']; ?>
月　<?php echo $this->_tpl_vars['form']['next_w_button'][$this->_tpl_vars['i']]['html']; ?>
</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>【伝票識別　　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="450">
				<tr>
					<td class="Title_Pink" width="100"><b>予定件数</b></td>
					<td class="Value" align="right" width="125"><?php echo $this->_tpl_vars['act_disp_data'][$this->_tpl_vars['i']][0][0]; ?>
件</td>
					<td class="Title_Pink" width="100"><b>予定金額</b></td>
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

	<!-- データが無い場合、前月・翌月ボタンだけ表示 -->
	<?php if ($this->_tpl_vars['var']['data_msg'] != NULL && $this->_tpl_vars['var']['act_data_flg'] == false): ?>
		<font class="color"><?php echo $this->_tpl_vars['form']['back_w_button']['html']; ?>
　<?php echo $this->_tpl_vars['var']['year']; ?>
年 <?php echo $this->_tpl_vars['var']['month']; ?>
月　<?php echo $this->_tpl_vars['form']['next_w_button']['html']; ?>
</font><br><br>
		<!-- エラー表示 -->
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;"><?php echo $this->_tpl_vars['var']['data_msg']; ?>
</span></font>
	<?php endif;  endif; ?>
<!--******************** 画面2表示終了 *******************-->
					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
