<?php /* Smarty version 2.6.14, created on 2009-12-26 12:28:35
         compiled from 2-1-104.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>


<?php echo '
'; ?>



 </script>

<!-- �ܵ��褬����Ƚ�� -->
<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>
	<!-- ���򤵤줿��硢���������ؿ��ƽФ� -->                           
	<body class="bgimg_purple" <?php echo $this->_tpl_vars['var']['form_load']; ?>
>
<?php else: ?>
	<!-- ���򤵤�Ƥ��ʤ� -->      
	<body class="bgimg_purple">
<?php endif; ?>

<form name="dateForm" method="post">
<!--------------------- ���ȳ��� ---------------------->
<A NAME="daiko">
<table border="0" width="100%" height="90%" class="M_table">
</A>
	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!---------------------- ����ɽ��1���� --------------------->
<?php echo $this->_tpl_vars['form']['back']['html']; ?>
 <?php echo $this->_tpl_vars['form']['next']['html']; ?>

<table border="0">
<td valign="top">
<!-- ʣ���ɲäξ��˼������ɽ�� -->
<?php if ($this->_tpl_vars['var']['flg'] == 'copy'): ?>
<table width=550>
    <tr>
        <td align="left">      
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

        </td> 
   </tr>
</table>
 <?php endif; ?>
<!-- ���顼ɽ�� -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['item']; ?>
<br>
<?php endforeach; endif; unset($_from); ?>

<?php echo $this->_tpl_vars['var']['duplicat_mesg']; ?>

<?php echo $this->_tpl_vars['var']['advance_mesg']; ?>

</span>




<!--�����ʬ�����ꤵ��Ƥ��ʤ����ϡ����顼ɽ��(��Ǥ��ν������) -->
<?php if ($this->_tpl_vars['var']['trade_error_flg'] == true && $this->_tpl_vars['var']['client_id'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">�����ʬ�����ꤵ��Ƥ��ޤ���</font></span><br>
	<tr>
	<td align='right'><?php echo $this->_tpl_vars['form']['form_back_trade']['html']; ?>
</td>
	</tr>
	<tr height="300">
	<td>��</td>
	</tr>
<?php else: ?>

	<table class="Data_Table" border="1" width="">
		<tr>
	<!-- ľ�Ĥξ�� -->
	<?php if ($this->_tpl_vars['var']['group_kind'] == '2' && $this->_tpl_vars['var']['client_id'] != NULL): ?>
			<td class="Title_Purple" width="80"><b>��Զ�ʬ</b></td>
			<td class="Value" width="370"><?php echo $this->_tpl_vars['form']['daiko_check']['html']; ?>
</td>
	<?php endif; ?>
			<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['state']['label']; ?>
</b></td>
			<td class="Value" width="310" ><?php echo $this->_tpl_vars['form']['state']['html']; ?>
</td>
		</tr>
	</table>
	<br>

<table class="Data_Table" border="1" width="">
	<tr>
		<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
</b></td>
		<td class="Value" width="370"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
		<td class="Title_Purple" width="80"><b>��Ͽ��</b></td>
		<td class="Value" width="310" ><?php echo $this->_tpl_vars['form']['form_contract_day']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="80"><b>������</b></td>
		<td class="Value" width="620" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="80"><b>�Ҳ������</b></td>
		<td class="Value" width="310" ><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</td>
		<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['label']; ?>
</b></td>
		<td class="Value" width="310" >

	<?php if ($this->_tpl_vars['var']['ac_name'] != '̵��'): ?>
		<?php echo $this->_tpl_vars['form']['intro_ac_div'][0]['html'];  echo $this->_tpl_vars['form']['intro_ac_price']['html']; ?>
�ߡ�<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>

		<br><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['html'];  echo $this->_tpl_vars['form']['intro_ac_rate']['html']; ?>
��
		<br><?php echo $this->_tpl_vars['form']['intro_ac_div'][2]['html']; ?>

	<?php else: ?>
		<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>

	<?php endif; ?>
		</td>
	</tr>

	<!-- ľ��Ƚ�� -->
	<?php if ($this->_tpl_vars['var']['group_kind'] == '2' && $this->_tpl_vars['var']['client_id'] != NULL): ?>
	<tr>
		<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['form_daiko_link']['html']; ?>
</b></td>
		<td class="Value" width="310"><?php echo $this->_tpl_vars['form']['form_daiko']['html']; ?>
</td>
		<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['act_div'][1]['label']; ?>
</b></td>
		<td class="Value" width="310" >
		<?php echo $this->_tpl_vars['form']['act_div'][0]['html'];  echo $this->_tpl_vars['form']['act_request_price']['html']; ?>
�ߡ�<?php echo $this->_tpl_vars['form']['act_div'][2]['html']; ?>

		<br><?php echo $this->_tpl_vars['form']['act_div'][1]['html'];  echo $this->_tpl_vars['form']['act_request_rate']['html']; ?>
��
		</td>
	</tr>
	<?php endif; ?>

</table>

<!-- �ܵ��褬���򤵤줿����������ɽ�� -->
<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>
	<!-- �ܵ��褬���� -->

	<br>
	<br>
	<A NAME="keiyaku">
	<table border="0" width="1480">
		<tr>
		<td align="left"><font size="+0.5" color="#555555"><b>�ڷ��������١�</b></font></td>
		<td align="left" width=922><b><font color="blue">
            <li>�����껦�۰ʳ�����ȴ��ۤ���Ͽ���Ƥ���������<br>
			<li>�֥����ӥ�̾�ס֥����ƥ�פ˥����å����դ������ɼ�˰�������ޤ���<br>
			<li>����Ʊ���פ˥����å����դ���Ⱦ��ʤΥ����ɡ�̾�Τ��ޥ�����Ʊ������ޤ���<br>

			<?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
			<li>����饤����Ԥη�����ѹ��������ϡ�������Ǻ��ټ�������ɬ�פ�����ޤ���
			<?php endif; ?>
		</td>


				<td align="right">
			<table class="Data_Table" border="1" width="300">
				<tr>
				<td class="Title_Purple" width="160"><b><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['label']; ?>
��<?php echo $this->_tpl_vars['form']['form_ad_sum_btn']['html']; ?>
</b></td>
				<td class="Value" width="140" align="right"><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['html']; ?>
</td>
				</tr>
			</table>
		</td>

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
			<td class="Title_Purple" rowspan="2"><b>�Ҳ������<br>(����ñ��)</b></td>
			<td class="Title_Purple" rowspan="2"><b>�����껦��</b></td>
			<td class="Title_Purple" rowspan="2"><b>��Ʊ��</b></td>
			<!-- �ܵ�̾�����򤵤줿����ɽ�� -->
			<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>	
				<td class="Title_Purple" rowspan="2"><b><?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</b></td>
			<?php endif; ?>
		</tr>

		<tr>
			<td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></b></td>
			<td class="Title_Purple" ><b>������׳�<br>����׳�</b></td>
		</tr>
		
		<?php $_from = $this->_tpl_vars['loop_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
			<tr>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_divide'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value">
					<?php echo $this->_tpl_vars['form']['form_print_flg1'][$this->_tpl_vars['i']]['html']; ?>
<br>
					<?php echo $this->_tpl_vars['form']['form_serv'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value">
					<?php echo $this->_tpl_vars['form']['form_goods_cd1'][$this->_tpl_vars['i']]['html']; ?>
(<?php echo $this->_tpl_vars['form']['form_search1'][$this->_tpl_vars['i']]['html']; ?>
)<?php echo $this->_tpl_vars['form']['form_print_flg2'][$this->_tpl_vars['i']]['html']; ?>
<br>
					<?php echo $this->_tpl_vars['form']['official_goods_name'][$this->_tpl_vars['i']]['html']; ?>
<br>
					<?php echo $this->_tpl_vars['form']['form_goods_name1'][$this->_tpl_vars['i']]['html']; ?>

				</td>
				<td class="Value"><font color=#555555>�켰</font><?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_goods_num1'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_amount'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_sale_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd3'][$this->_tpl_vars['i']]['html']; ?>
(<?php echo $this->_tpl_vars['form']['form_search3'][$this->_tpl_vars['i']]['html']; ?>
)<br><?php echo $this->_tpl_vars['form']['form_goods_name3'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_num3'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd2'][$this->_tpl_vars['i']]['html']; ?>
(<?php echo $this->_tpl_vars['form']['form_search2'][$this->_tpl_vars['i']]['html']; ?>
)<br><?php echo $this->_tpl_vars['form']['form_goods_name2'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_num2'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<td class="Value">
					<table height="20">
						<tr>
						<td><?php echo $this->_tpl_vars['form']['form_aprice_div'][$this->_tpl_vars['i']]['html']; ?>
</td>
						<td>
							<font color="#555555">
							<?php echo $this->_tpl_vars['form']['form_br']['html']; ?>
<br>
							<?php echo $this->_tpl_vars['form']['form_account_price'][$this->_tpl_vars['i']]['html']; ?>
��<br>
							<?php echo $this->_tpl_vars['form']['form_account_rate'][$this->_tpl_vars['i']]['html']; ?>
%
							</font>
						</td>
						</tr>
					</table>
				<td class="Value">
					<font color="#555555">
					<?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][1]['html']; ?>
<br>
					<?php echo $this->_tpl_vars['form']['form_ad_offset_radio'][$this->_tpl_vars['i']][2]['html'];  echo $this->_tpl_vars['form']['form_ad_offset_amount'][$this->_tpl_vars['i']]['html']; ?>

					</font>
				</td>
				</td>
				<td class="Value"><?php echo $this->_tpl_vars['form']['mst_sync_flg'][$this->_tpl_vars['i']]['html']; ?>
</td>

				<!-- �ܵ�̾�����򤵤줿����ɽ�� -->
				<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>	
					<td class="Value"><?php echo $this->_tpl_vars['form']['clear_line'][$this->_tpl_vars['i']]['html']; ?>
</td>
				<?php endif; ?>
			</tr>
		<?php endforeach; endif; unset($_from); ?>

	</table>

	<p>
	<table>
	<tr>
	<td>
		<br><br>
		<table class="Data_Table" border="1" width="470" height="240" >
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
			<!-- ľ��Ƚ�� -->
			<?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
				<tr>
					<td class="Title_Purple" width="90"><b>�����谸����</b></td>
					<td class="Value" width="200"><?php echo $this->_tpl_vars['form']['form_daiko_note']['html']; ?>
</td>
				</tr>
			<?php endif; ?>
		</table>
	</td>
	<td valign="top">
	<b><font color="blue">
	<li>�ֽ���ȯ�����װʹߤ�ͽ��ǡ����Ϻƺ�������ޤ���<br>
	<li>�ַ���λ���װʹߤ�ͽ��ǡ�������������ޤ���
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



	<!---------------------- ����ɽ��2���� --------------------->
	<table width="930">
		<tr>
			<td align='left'><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
		</tr>

		<tr>
		<!-- �ܵ��褬���򤵤�Ƥ�����Τ���Ͽ������ܥ���ɽ�� -->
		<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>	
			<td align="left"><?php echo $this->_tpl_vars['form']['delete_button']['html']; ?>
</b></td>
			<td align='right'><?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>

				<!-- �����פ������ܤ������ˤ������ܥ���ɽ�� -->
				<?php if ($this->_tpl_vars['var']['return_flg'] != NULL): ?>
					����<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
				<?php endif; ?>
		<?php else: ?>
			<!-- �����פ������ܤ������ˤ������ܥ���ɽ�� -->
			<?php if ($this->_tpl_vars['var']['return_flg'] != NULL): ?>
				<td align='right'><?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
			<?php endif; ?>
		<?php endif; ?>
		</tr>
	</table>
<?php else: ?>
	<!-- �ܵ��褬���򤵤�Ƥʤ����ϡ��ٹ�ɽ�� -->

	<table width="980">
		<tr>
			<td align='left'><b><font color="#ff0000">�ܵ�������򤷤Ƥ���������</font></b></td>
		</tr>
		<tr>
			<td align='left'><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
		</tr>
	</table>
	<table height="260">
		<tr>
			<td align='left'><b>��</b></td>
		</tr>
	</table>
<?php endif; ?>
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
