<?php /* Smarty version 2.6.14, created on 2009-12-26 12:23:34
         compiled from 2-1-240.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>

 </script>

<body class="bgimg_purple" <?php echo $this->_tpl_vars['var']['form_load']; ?>
>
<form name="dateForm" method="post">
<!--------------------- ���ȳ��� --------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ ------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!---------------------- ����ɽ��1���� ------------------->

<!-- ���顼ɽ�� -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['item']; ?>
<br>
<?php endforeach; endif; unset($_from);  echo $this->_tpl_vars['var']['duplicat_mesg']; ?>

</span>

<!--�����ʬ�����ꤵ��Ƥ��ʤ����ϡ����顼ɽ��(��Ǥ��ν������) -->
<?php if ($this->_tpl_vars['var']['trade_error_flg'] == true && $this->_tpl_vars['var']['client_id'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">�����ʬ�����ꤵ��Ƥ��ޤ���</font>
    </span><br>
	<td align='right'><?php echo $this->_tpl_vars['form']['form_back_trade']['html']; ?>
</td>
<?php else: ?>

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="113"><b>������</b></td>
		<td class="Value" width="310"><?php echo $this->_tpl_vars['form']['form_daiko_price']['html']; ?>
</td>
		<td class="Title_Purple" width="113"><b>�������</b></td>
		<td class="Value" width="310"><?php echo $this->_tpl_vars['form']['state']['html']; ?>
</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="950">
	<tr>
		<td class="Title_Purple" width="90"><b>�ܵ�̾</b></td>
		<td class="Value" width="310"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
		<td class="Title_Purple" width="110"><b>������</b></td>
		<td class="Value" width="230"><?php echo $this->_tpl_vars['form']['form_contract_day']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="90"><b>�����谸����</b></td>
		<td class="Value" width="310" colspan="3"><?php echo $this->_tpl_vars['form']['form_daiko_note']['html']; ?>
</td>
	</tr>
</table>

	<br>
	<br>
	<table border="0" width="985">
		<tr>
		<td align="left"><font size="+0.5" color="#555555"><b>�ڷ��������١�</b></font></td>
        <td align="left" width=832><b><font color="blue">
            <li>�Ķȸ�������ȴ��ۤ���Ͽ���Ƥ���������
        </td>
		</tr>
	</table>

	<table class="Data_Table" border="1" width="950">
		<tr>
			<td class="Title_Purple" rowspan="2" width="90"><b>�����ʬ</b></td>
			<td class="Title_Purple" rowspan="2" width="200"><b>�����ӥ�̾</b></td>
						<td class="Title_Purple" rowspan="2" width="130"><b>�����ƥ�</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" colspan="2"><b>���</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>������</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>���ξ���</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>��Ʊ��</b></td>
			<!--<td class="Title_Purple" rowspan="2" width="50"><b>����</b></td>-->
		</tr>

		<tr>
			<td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��</b></td>
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
			<A NAME="<?php echo $this->_tpl_vars['i']; ?>
">
				<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['form_divide'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_print_flg1'][$this->_tpl_vars['i']]['html']; ?>
 <?php echo $this->_tpl_vars['form']['form_serv'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value">
					<?php echo $this->_tpl_vars['form']['form_print_flg2'][$this->_tpl_vars['i']]['html']; ?>
 <?php echo $this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['html']; ?>
<br>
					�� <?php echo $this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['html']; ?>
<br>
					�� <?php echo $this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['html']; ?>

				</td>
				<td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['br_flg'] == 'true'): ?><br><?php endif;  echo $this->_tpl_vars['form']['form_goods_num1'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_trade_amount'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num3'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_goods_num2'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['mst_sync_flg'][$this->_tpl_vars['i']]['html']; ?>
</td>
							</A>
			</tr>
		<?php endforeach; endif; unset($_from); ?>

	</table>
	<table width="950">
		<tr>
			<td align='right'><?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
		</tr>
	</table>
	
	<p>
	<table>
	<tr>
	<td>
	<br><br>
		<table class="Data_Table" border="1" width="450" height="240" >
			<tr>
				<td class="Title_Purple" width="110"><b>��No.<font color="#ff0000">��</font></b></td>
				<td class="Value" width="185"><?php echo $this->_tpl_vars['form']['form_line']['html']; ?>
</td>
			</tr>
			<tr>
				<td class="Title_Purple" width="90">
					<b>���ô��<br>������</b>
				</td>
				<td class="Value" >
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
				</td>
			</tr>

			<tr>
				<td class="Title_Purple"><b>��ϩ<font color="#ff0000">��</font></b></td>
				<td class="Value" ><?php echo $this->_tpl_vars['form']['form_route_load']['html']; ?>
</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90"><b>����</b></td>
				<td class="Value" width="200"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
			</tr>
		</table>
	</td>

	<td valign="top">
	<b><font color="blue">
	<li>�ֽ���ȯ�����װʹߤ�ͽ��ǡ����Ϻƺ�������ޤ���<br>
	<li>�ַ���λ���װʹߤ�ͽ��ǡ����Ϻ�������ޤ���
	</font></b>
		<table class="Data_Table" border="1" width="450" height="240" >
			<tr>
				<td class="Title_Purple" width="90" nowrap rowspan="4"><b>�����</b></td>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_stand_day']['label']; ?>
��<?php echo $this->_tpl_vars['form']['form_stand_day']['html']; ?>
</td>
				</tr>
				
				<tr>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_update_day']['label']; ?>
��<?php echo $this->_tpl_vars['form']['form_update_day']['html']; ?>
</td>
				</tr>
				
				<tr>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_contract_eday']['label']; ?>
��<?php echo $this->_tpl_vars['form']['form_contract_eday']['html']; ?>
</td>
				</tr>
				
				<tr>
				<td class="Value" width="460" colspan="3">
					<table border="0">

						<tr>
							<td><b><font color="#ff0000">��</font></b><br>
							<font color="#555555">
								��<?php echo $this->_tpl_vars['form']['form_round_div1'][0]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_abcd_week1']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_week_rday1']['html']; ?>
����<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][1]['html']; ?>

								��<?php echo $this->_tpl_vars['form']['form_rday2']['html']; ?>
��<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][2]['html']; ?>

								����<?php echo $this->_tpl_vars['form']['form_cale_week3']['html']; ?>

								��<?php echo $this->_tpl_vars['form']['form_week_rday3']['html']; ?>
����<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][3]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_week4']['html']; ?>
���ּ�����<?php echo $this->_tpl_vars['form']['form_week_rday4']['html']; ?>
����<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][4]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_month5']['html']; ?>
���������<?php echo $this->_tpl_vars['form']['form_week_rday5']['html']; ?>
��<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][5]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_month6']['html']; ?>
�����������<?php echo $this->_tpl_vars['form']['form_cale_week6']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_week_rday6']['html']; ?>
����<br>

								��<?php echo $this->_tpl_vars['form']['form_round_div1'][6]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_irr_day']['html']; ?>
(�ǽ���:<?php echo $this->_tpl_vars['var']['last_day']; ?>
)
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>

	</tr>
	</table>

	<!--******************** ����ɽ��1��λ *******************-->



	<!---------------------- ����ɽ��2���� ------------------->
	<table width="950">
		<tr>
			<td align='left'><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
		</tr>

		<tr>
			<td align='right'><?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
		</tr>
	</table>
<!--******************** ����ɽ��2��λ *******************-->

<!-- ��Ǻ��-->
<?php endif; ?>
<!-- -->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->
<?php echo $this->_tpl_vars['var']['html_footer']; ?>
