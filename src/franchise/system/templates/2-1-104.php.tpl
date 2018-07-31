
{$var.html_header}

<script language="javascript">
{$var.java_sheet}

{literal}
{/literal}


 </script>

<!-- 顧客先が選択判定 -->
{if $var.client_id != NULL}
	<!-- 選択された場合、巡回日選択関数呼出し -->                           
	<body class="bgimg_purple" {$var.form_load}>
{else}
	<!-- 選択されていない -->      
	<body class="bgimg_purple">
{/if}

<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<A NAME="daiko">
<table border="0" width="100%" height="90%" class="M_table">
</A>
	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

{$form.hidden}
<!---------------------- 画面表示1開始 --------------------->
{$form.back.html} {$form.next.html}
<table border="0">
<td valign="top">
<!-- 複写追加の場合に次へ戻る表示 -->
{if $var.flg == 'copy'}
<table width=550>
    <tr>
        <td align="left">      
                {$form.back_button.html}
                {$form.next_button.html}
        </td> 
   </tr>
</table>
 {/if}
<!-- エラー表示 -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
{* 警告エラー表示 *}

{$var.duplicat_mesg}
{$var.advance_mesg}
</span>




<!--取引区分が設定されていない場合は、エラー表示(後でこの処理削除) -->
{if $var.trade_error_flg == true && $var.client_id != NULL}
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">取引区分が設定されていません。</font></span><br>
	<tr>
	<td align='right'>{$form.form_back_trade.html}</td>
	</tr>
	<tr height="300">
	<td>　</td>
	</tr>
{else}

	<table class="Data_Table" border="1" width="">
		<tr>
	<!-- 直営の場合 -->
	{if $var.group_kind == '2' && $var.client_id != NULL}
			<td class="Title_Purple" width="80"><b>代行区分</b></td>
			<td class="Value" width="370">{$form.daiko_check.html}</td>
	{/if}
			<td class="Title_Purple" width="80"><b>{$form.state.label}</b></td>
			<td class="Value" width="310" >{$form.state.html}</td>
		</tr>
	</table>
	<br>

<table class="Data_Table" border="1" width="">
	<tr>
		<td class="Title_Purple" width="80"><b>{$form.form_client_link.html}</b></td>
		<td class="Value" width="370">{$form.form_client.html}</td>
		<td class="Title_Purple" width="80"><b>登録日</b></td>
		<td class="Value" width="310" >{$form.form_contract_day.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="80"><b>請求先</b></td>
		<td class="Value" width="620" colspan="3">{$form.form_claim.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="80"><b>紹介口座先</b></td>
		<td class="Value" width="310" >{$var.ac_name}</td>
		<td class="Title_Purple" width="80"><b>{$form.intro_ac_div[1].label}</b></td>
		<td class="Value" width="310" >

	{if $var.ac_name != '無し'}
		{$form.intro_ac_div[0].html}{$form.intro_ac_price.html}円　{$form.intro_ac_div[3].html}
		<br>{$form.intro_ac_div[1].html}{$form.intro_ac_rate.html}％
		<br>{$form.intro_ac_div[2].html}
	{else}
		{$form.intro_ac_div[3].html}
	{/if}
		</td>
	</tr>

	<!-- 直営判定 -->
	{if $var.group_kind == '2' && $var.client_id != NULL}
	<tr>
		<td class="Title_Purple" width="80"><b>{$form.form_daiko_link.html}</b></td>
		<td class="Value" width="310">{$form.form_daiko.html}</td>
		<td class="Title_Purple" width="80"><b>{$form.act_div[1].label}</b></td>
		<td class="Value" width="310" >
		{$form.act_div[0].html}{$form.act_request_price.html}円　{$form.act_div[2].html}
		<br>{$form.act_div[1].html}{$form.act_request_rate.html}％
		</td>
	</tr>
	{/if}

</table>

<!-- 顧客先が選択された場合に入力欄表示 -->
{if $var.client_id != NULL}
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

			{if $var.group_kind == '2'}
			<li>オンライン代行の契約を変更した場合は、委託先で再度受託する必要があります。
			{/if}
		</td>


		{* 前受金残高 *}
		<td align="right">
			<table class="Data_Table" border="1" width="300">
				<tr>
				<td class="Title_Purple" width="160"><b>{$form.form_ad_rest_price.label}　{$form.form_ad_sum_btn.html}</b></td>
				<td class="Value" width="140" align="right">{$form.form_ad_rest_price.html}</td>
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
			{if $var.client_id != NULL}	
				<td class="Title_Purple" rowspan="2"><b>{$form.clear_button.html}</b></td>
			{/if}
		</tr>

		<tr>
			<td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></b></td>
			<td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
		</tr>
		
		{foreach key=i from=$loop_num item=items}
			<tr>
				<td class="Value">{$form.form_divide[$i].html}</td>
				<td class="Value">
					{$form.form_print_flg1[$i].html}<br>
					{$form.form_serv[$i].html}</td>
				<td class="Value">
					{$form.form_goods_cd1[$i].html}({$form.form_search1[$i].html}){$form.form_print_flg2[$i].html}<br>
					{$form.official_goods_name[$i].html}<br>
					{$form.form_goods_name1[$i].html}
				</td>
				<td class="Value"><font color=#555555>一式</font>{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
				<td class="Value">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
				<td class="Value">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>
				<td class="Value">{$form.form_goods_cd3[$i].html}({$form.form_search3[$i].html})<br>{$form.form_goods_name3[$i].html}</td>
				<td class="Value">{$form.form_goods_num3[$i].html}</td>
				<td class="Value">{$form.form_goods_cd2[$i].html}({$form.form_search2[$i].html})<br>{$form.form_goods_name2[$i].html}</td>
				<td class="Value">{$form.form_goods_num2[$i].html}</td>
				<td class="Value">
					<table height="20">
						<tr>
						<td>{$form.form_aprice_div[$i].html}</td>
						<td>
							<font color="#555555">
							{$form.form_br.html}<br>
							{$form.form_account_price[$i].html}円<br>
							{$form.form_account_rate[$i].html}%
							</font>
						</td>
						</tr>
					</table>
				<td class="Value">
					<font color="#555555">
					{$form.form_ad_offset_radio[$i][1].html}<br>
					{$form.form_ad_offset_radio[$i][2].html}{$form.form_ad_offset_amount[$i].html}
					</font>
				</td>
				</td>
				<td class="Value">{$form.mst_sync_flg[$i].html}</td>

				<!-- 顧客名が選択された場合に表示 -->
				{if $var.client_id != NULL}	
					<td class="Value">{$form.clear_line[$i].html}</td>
				{/if}
			</tr>
		{/foreach}

	</table>

	<p>
	<table>
	<tr>
	<td>
		<br><br>
		<table class="Data_Table" border="1" width="470" height="240" >
			<tr>
				<td class="Title_Purple" width="110"><b>行No.<font color="#ff0000">※</font></b></td>
				<td class="Value" width="185">{$form.form_line.html}</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90">
					<b>巡回担当<br>チーム</b>
				</td>
				<td class="Value" >
					メイン1<b><font color="#ff0000">※</font></b> {$form.form_c_staff_id1.html}　売上{$form.form_sale_rate1.html}％<br>
					サブ2　 <b>　</b>{$form.form_c_staff_id2.html}　売上{$form.form_sale_rate2.html}％<br>
					サブ3　 <b>　</b>{$form.form_c_staff_id3.html}　売上{$form.form_sale_rate3.html}％<br>
					サブ4　 <b>　</b>{$form.form_c_staff_id4.html}　売上{$form.form_sale_rate4.html}％<br>
				</td>
			</tr>

			<tr>
				<td class="Title_Purple"><b>順路<font color="#ff0000">※</font></b></td>
				<td class="Value" >{$form.form_route_load.html}</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90"><b>備考</b></td>
				<td class="Value" width="200">{$form.form_note.html}</td>
			</tr>
			<!-- 直営判定 -->
			{if $var.group_kind == '2'}
				<tr>
					<td class="Title_Purple" width="90"><b>委託先宛備考</b></td>
					<td class="Value" width="200">{$form.form_daiko_note.html}</td>
				</tr>
			{/if}
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
					<td class="Value">{$form.form_stand_day.label}：{$form.form_stand_day.html}</td>
				</tr>
				
				<tr>
					<td class="Value">{$form.form_update_day.label}：{$form.form_update_day.html}</td>
				</tr>
				
				<tr>
					<td class="Value">{$form.form_contract_eday.label}：{$form.form_contract_eday.html}</td>
				</tr>
				
				<tr>
				<td class="Value" width="460" colspan="3">
					<table border="0">

						<tr>
							<td><b><font color="#ff0000">※</font></b><br>
							<font color="#555555">
								　{$form.form_round_div1[0].html}
								{$form.form_abcd_week1.html}週　{$form.form_week_rday1.html}曜日<br>

								　{$form.form_round_div1[1].html}
								毎月　{$form.form_rday2.html}日<br>

								　{$form.form_round_div1[2].html}
								毎月　第{$form.form_cale_week3.html}
								　{$form.form_week_rday3.html}曜日<br>

								　{$form.form_round_div1[3].html}
								{$form.form_cale_week4.html}週間周期の{$form.form_week_rday4.html}曜日<br>

								　{$form.form_round_div1[4].html}
								{$form.form_cale_month5.html}ヶ月周期の{$form.form_week_rday5.html}日<br>

								　{$form.form_round_div1[5].html}
								{$form.form_cale_month6.html}ヶ月周期の第{$form.form_cale_week6.html}　{$form.form_week_rday6.html}曜日<br>

								　{$form.form_round_div1[6].html}
								{$form.form_irr_day.html}(最終日:{$var.last_day})
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
		{if $var.client_id != NULL}	
			<td align="left">{$form.delete_button.html}</b></td>
			<td align='right'>{$form.entry_button.html}
				<!-- 契約概要から遷移した場合にだけ戻るボタン表示 -->
				{if $var.return_flg != NULL}
					　　{$form.form_back.html}</td>
				{/if}
		{else}
			<!-- 契約概要から遷移した場合にだけ戻るボタン表示 -->
			{if $var.return_flg != NULL}
				<td align='right'>{$form.form_back.html}</td>
			{/if}
		{/if}
		</tr>
	</table>
{else}
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
{/if}
<!--******************** 画面表示2終了 *******************-->

<!-- 後で削除-->
{/if}
<!-- -->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->
{$var.html_footer}
