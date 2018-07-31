<?php /* Smarty version 2.6.14, created on 2009-12-26 12:28:35
         compiled from 2-1-104.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>


<?php echo '
'; ?>



 </script>

<!-- 顧客先が選択判定 -->
<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>
	<!-- 選択された場合、巡回日選択関数呼出し -->                           
	<body class="bgimg_purple" <?php echo $this->_tpl_vars['var']['form_load']; ?>
>
<?php else: ?>
	<!-- 選択されていない -->      
	<body class="bgimg_purple">
<?php endif; ?>

<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<A NAME="daiko">
<table border="0" width="100%" height="90%" class="M_table">
</A>
	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!---------------------- 画面表示1開始 --------------------->
<?php echo $this->_tpl_vars['form']['back']['html']; ?>
 <?php echo $this->_tpl_vars['form']['next']['html']; ?>

<table border="0">
<td valign="top">
<!-- 複写追加の場合に次へ戻る表示 -->
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
<!-- エラー表示 -->
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




<!--取引区分が設定されていない場合は、エラー表示(後でこの処理削除) -->
<?php if ($this->_tpl_vars['var']['trade_error_flg'] == true && $this->_tpl_vars['var']['client_id'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">取引区分が設定されていません。</font></span><br>
	<tr>
	<td align='right'><?php echo $this->_tpl_vars['form']['form_back_trade']['html']; ?>
</td>
	</tr>
	<tr height="300">
	<td>　</td>
	</tr>
<?php else: ?>

	<table class="Data_Table" border="1" width="">
		<tr>
	<!-- 直営の場合 -->
	<?php if ($this->_tpl_vars['var']['group_kind'] == '2' && $this->_tpl_vars['var']['client_id'] != NULL): ?>
			<td class="Title_Purple" width="80"><b>代行区分</b></td>
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
		<td class="Title_Purple" width="80"><b>登録日</b></td>
		<td class="Value" width="310" ><?php echo $this->_tpl_vars['form']['form_contract_day']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="80"><b>請求先</b></td>
		<td class="Value" width="620" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="80"><b>紹介口座先</b></td>
		<td class="Value" width="310" ><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</td>
		<td class="Title_Purple" width="80"><b><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['label']; ?>
</b></td>
		<td class="Value" width="310" >

	<?php if ($this->_tpl_vars['var']['ac_name'] != '無し'): ?>
		<?php echo $this->_tpl_vars['form']['intro_ac_div'][0]['html'];  echo $this->_tpl_vars['form']['intro_ac_price']['html']; ?>
円　<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>

		<br><?php echo $this->_tpl_vars['form']['intro_ac_div'][1]['html'];  echo $this->_tpl_vars['form']['intro_ac_rate']['html']; ?>
％
		<br><?php echo $this->_tpl_vars['form']['intro_ac_div'][2]['html']; ?>

	<?php else: ?>
		<?php echo $this->_tpl_vars['form']['intro_ac_div'][3]['html']; ?>

	<?php endif; ?>
		</td>
	</tr>

	<!-- 直営判定 -->
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
円　<?php echo $this->_tpl_vars['form']['act_div'][2]['html']; ?>

		<br><?php echo $this->_tpl_vars['form']['act_div'][1]['html'];  echo $this->_tpl_vars['form']['act_request_rate']['html']; ?>
％
		</td>
	</tr>
	<?php endif; ?>

</table>

<!-- 顧客先が選択された場合に入力欄表示 -->
<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>
	<!-- 顧客先がある -->

	<br>
	<br>
	<A NAME="keiyaku">
	<table border="0" width="1480">
		<tr>
		<td align="left"><font size="+0.5" color="#555555"><b>【契約品明細】</b></font></td>
		<td align="left" width=922><b><font color="blue">
            <li>前受相殺額以外は税抜金額を登録してください。<br>
			<li>「サービス名」「アイテム」にチェックを付けると伝票に印字されます。<br>
			<li>「非同期」にチェックを付けると商品のコード・名称がマスタと同期されません。<br>

			<?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
			<li>オンライン代行の契約を変更した場合は、委託先で再度受託する必要があります。
			<?php endif; ?>
		</td>


				<td align="right">
			<table class="Data_Table" border="1" width="300">
				<tr>
				<td class="Title_Purple" width="160"><b><?php echo $this->_tpl_vars['form']['form_ad_rest_price']['label']; ?>
　<?php echo $this->_tpl_vars['form']['form_ad_sum_btn']['html']; ?>
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
			<td class="Title_Purple" rowspan="2"><b>販売区分<font color="#ff0000">※</font></b></td>
			<td class="Title_Purple" rowspan="2"><b>サービス名</b></td>
			<td class="Title_Purple" rowspan="2"><b>アイテム</b></td>
			<td class="Title_Purple" rowspan="2"><b>数量</b></td>
			<td class="Title_Purple" colspan="2"><b>金額</b></td>
			<td class="Title_Purple" rowspan="2"><b>消耗品</b></td>
			<td class="Title_Purple" rowspan="2"><b>数量</b></td>
			<td class="Title_Purple" rowspan="2"><b>本体商品</b></td>
			<td class="Title_Purple" rowspan="2"><b>数量</b></td>
			<td class="Title_Purple" rowspan="2"><b>紹介口座料<br>(商品単位)</b></td>
			<td class="Title_Purple" rowspan="2"><b>前受相殺額</b></td>
			<td class="Title_Purple" rowspan="2"><b>非同期</b></td>
			<!-- 顧客名が選択された場合に表示 -->
			<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>	
				<td class="Title_Purple" rowspan="2"><b><?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</b></td>
			<?php endif; ?>
		</tr>

		<tr>
			<td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></b></td>
			<td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
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
				<td class="Value"><font color=#555555>一式</font><?php echo $this->_tpl_vars['form']['form_issiki'][$this->_tpl_vars['i']]['html']; ?>
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
円<br>
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

				<!-- 顧客名が選択された場合に表示 -->
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
				<td class="Title_Purple" width="110"><b>行No.<font color="#ff0000">※</font></b></td>
				<td class="Value" width="185"><?php echo $this->_tpl_vars['form']['form_line']['html']; ?>
</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90">
					<b>巡回担当<br>チーム</b>
				</td>
				<td class="Value" >
					メイン1<b><font color="#ff0000">※</font></b> <?php echo $this->_tpl_vars['form']['form_c_staff_id1']['html']; ?>
　売上<?php echo $this->_tpl_vars['form']['form_sale_rate1']['html']; ?>
％<br>
					サブ2　 <b>　</b><?php echo $this->_tpl_vars['form']['form_c_staff_id2']['html']; ?>
　売上<?php echo $this->_tpl_vars['form']['form_sale_rate2']['html']; ?>
％<br>
					サブ3　 <b>　</b><?php echo $this->_tpl_vars['form']['form_c_staff_id3']['html']; ?>
　売上<?php echo $this->_tpl_vars['form']['form_sale_rate3']['html']; ?>
％<br>
					サブ4　 <b>　</b><?php echo $this->_tpl_vars['form']['form_c_staff_id4']['html']; ?>
　売上<?php echo $this->_tpl_vars['form']['form_sale_rate4']['html']; ?>
％<br>
				</td>
			</tr>

			<tr>
				<td class="Title_Purple"><b>順路<font color="#ff0000">※</font></b></td>
				<td class="Value" ><?php echo $this->_tpl_vars['form']['form_route_load']['html']; ?>
</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90"><b>備考</b></td>
				<td class="Value" width="200"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
			</tr>
			<!-- 直営判定 -->
			<?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
				<tr>
					<td class="Title_Purple" width="90"><b>委託先宛備考</b></td>
					<td class="Value" width="200"><?php echo $this->_tpl_vars['form']['form_daiko_note']['html']; ?>
</td>
				</tr>
			<?php endif; ?>
		</table>
	</td>
	<td valign="top">
	<b><font color="blue">
	<li>「修正発効日」以降の予定データは再作成されます。<br>
	<li>「契約終了日」以降は予定データが作成されません。
	</font></b>
		<table class="Data_Table" border="1" width="450" height="240" >
				<tr>
					<td class="Title_Purple" width="90" nowrap rowspan="4"><b>巡回日</b></td>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_stand_day']['label']; ?>
：<?php echo $this->_tpl_vars['form']['form_stand_day']['html']; ?>
</td>
				</tr>
				
				<tr>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_update_day']['label']; ?>
：<?php echo $this->_tpl_vars['form']['form_update_day']['html']; ?>
</td>
				</tr>
				
				<tr>
					<td class="Value"><?php echo $this->_tpl_vars['form']['form_contract_eday']['label']; ?>
：<?php echo $this->_tpl_vars['form']['form_contract_eday']['html']; ?>
</td>
				</tr>
				
				<tr>
				<td class="Value" width="460" colspan="3">
					<table border="0">

						<tr>
							<td><b><font color="#ff0000">※</font></b><br>
							<font color="#555555">
								　<?php echo $this->_tpl_vars['form']['form_round_div1'][0]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_abcd_week1']['html']; ?>
週　<?php echo $this->_tpl_vars['form']['form_week_rday1']['html']; ?>
曜日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][1]['html']; ?>

								毎月　<?php echo $this->_tpl_vars['form']['form_rday2']['html']; ?>
日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][2]['html']; ?>

								毎月　第<?php echo $this->_tpl_vars['form']['form_cale_week3']['html']; ?>

								　<?php echo $this->_tpl_vars['form']['form_week_rday3']['html']; ?>
曜日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][3]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_week4']['html']; ?>
週間周期の<?php echo $this->_tpl_vars['form']['form_week_rday4']['html']; ?>
曜日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][4]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_month5']['html']; ?>
ヶ月周期の<?php echo $this->_tpl_vars['form']['form_week_rday5']['html']; ?>
日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][5]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_cale_month6']['html']; ?>
ヶ月周期の第<?php echo $this->_tpl_vars['form']['form_cale_week6']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_week_rday6']['html']; ?>
曜日<br>

								　<?php echo $this->_tpl_vars['form']['form_round_div1'][6]['html']; ?>

								<?php echo $this->_tpl_vars['form']['form_irr_day']['html']; ?>
(最終日:<?php echo $this->_tpl_vars['var']['last_day']; ?>
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

	<!--******************** 画面表示1終了 *******************-->



	<!---------------------- 画面表示2開始 --------------------->
	<table width="930">
		<tr>
			<td align='left'><b><font color="#ff0000">※は必須入力です</font></b></td>
		</tr>

		<tr>
		<!-- 顧客先が選択されている場合のみ登録・削除ボタン表示 -->
		<?php if ($this->_tpl_vars['var']['client_id'] != NULL): ?>	
			<td align="left"><?php echo $this->_tpl_vars['form']['delete_button']['html']; ?>
</b></td>
			<td align='right'><?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>

				<!-- 契約概要から遷移した場合にだけ戻るボタン表示 -->
				<?php if ($this->_tpl_vars['var']['return_flg'] != NULL): ?>
					　　<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
				<?php endif; ?>
		<?php else: ?>
			<!-- 契約概要から遷移した場合にだけ戻るボタン表示 -->
			<?php if ($this->_tpl_vars['var']['return_flg'] != NULL): ?>
				<td align='right'><?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
			<?php endif; ?>
		<?php endif; ?>
		</tr>
	</table>
<?php else: ?>
	<!-- 顧客先が選択されてない場合は、警告表示 -->

	<table width="980">
		<tr>
			<td align='left'><b><font color="#ff0000">顧客先を選択してください。</font></b></td>
		</tr>
		<tr>
			<td align='left'><b><font color="#ff0000">※は必須入力です</font></b></td>
		</tr>
	</table>
	<table height="260">
		<tr>
			<td align='left'><b>　</b></td>
		</tr>
	</table>
<?php endif; ?>
<!--******************** 画面表示2終了 *******************-->

<!-- 後で削除-->
<?php endif; ?>
<!-- -->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->
<?php echo $this->_tpl_vars['var']['html_footer']; ?>
