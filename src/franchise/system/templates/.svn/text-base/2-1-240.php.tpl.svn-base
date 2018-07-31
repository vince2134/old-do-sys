
{$var.html_header}

<script language="javascript">
{$var.java_sheet}
 </script>

<body class="bgimg_purple" {$var.form_load}>
<form name="dateForm" method="post">
<!--------------------- 外枠開始 --------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 ------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

{$form.hidden}
<!---------------------- 画面表示1開始 ------------------->

<!-- エラー表示 -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
{* 予定データ重複作成エラー表示 *}
{$var.duplicat_mesg}
</span>

<!--取引区分が設定されていない場合は、エラー表示(後でこの処理削除) -->
{if $var.trade_error_flg == true && $var.client_id != NULL}
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">取引区分が設定されていません。</font>
    </span><br>
	<td align='right'>{$form.form_back_trade.html}</td>
{else}

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="113"><b>受託料</b></td>
		<td class="Value" width="310">{$form.form_daiko_price.html}</td>
		<td class="Title_Purple" width="113"><b>契約状態</b></td>
		<td class="Value" width="310">{$form.state.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="950">
	<tr>
		<td class="Title_Purple" width="90"><b>顧客名</b></td>
		<td class="Value" width="310">{$form.form_client.html}</td>
		<td class="Title_Purple" width="110"><b>受託日</b></td>
		<td class="Value" width="230">{$form.form_contract_day.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="90"><b>受託先宛備考</b></td>
		<td class="Value" width="310" colspan="3">{$form.form_daiko_note.html}</td>
	</tr>
</table>

	<br>
	<br>
	<table border="0" width="985">
		<tr>
		<td align="left"><font size="+0.5" color="#555555"><b>【契約品明細】</b></font></td>
        <td align="left" width=832><b><font color="blue">
            <li>営業原価は税抜金額を登録してください。
        </td>
		</tr>
	</table>

	<table class="Data_Table" border="1" width="950">
		<tr>
			<td class="Title_Purple" rowspan="2" width="90"><b>販売区分</b></td>
			<td class="Title_Purple" rowspan="2" width="200"><b>サービス名</b></td>
			{* <td class="Title_Purple" rowspan="2" width="130"><b>アイテム（正式）<br>　　　　（略称）</b></td> *}
			<td class="Title_Purple" rowspan="2" width="130"><b>アイテム</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>数量</b></td>
			<td class="Title_Purple" colspan="2"><b>金額</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>消耗品</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>数量</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>本体商品</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>数量</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>非同期</b></td>
			<!--<td class="Title_Purple" rowspan="2" width="50"><b>内訳</b></td>-->
		</tr>

		<tr>
			<td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価</b></td>
			<td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
		</tr>
		
		{foreach key=i from=$loop_num item=items}
            {* 2009-09-22 hashimoto-y *}
            {if $toSmarty_discount_flg[$i] === 't'}
                 <tr class="Value" style="color: red">
            {else}
			    <tr>
            {/if}
			<A NAME="{$i}">
				<td class="Value" align="center">{$form.form_divide[$i].html}</td>
				<td class="Value">{$form.form_print_flg1[$i].html} {$form.form_serv[$i].html}</td>
				<td class="Value">
					{$form.form_print_flg2[$i].html} {$form.form_goods_cd1[$i].html}<br>
					　 {$form.official_goods_name[$i].html}<br>
					　 {$form.form_goods_name1[$i].html}
				</td>
				<td class="Value" align="right">{$form.form_issiki[$i].html}{if $var.br_flg == 'true'}<br>{/if}{$form.form_goods_num1[$i].html}</td>
				<td class="Value" align="right">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
				<td class="Value" align="right">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>
				<td class="Value">{$form.form_goods_cd3[$i].html}<br>{$form.form_goods_name3[$i].html}</td>
				<td class="Value" align="right">{$form.form_goods_num3[$i].html}</td>
				<td class="Value">{$form.form_goods_cd2[$i].html}<br>{$form.form_goods_name2[$i].html}</td>
				<td class="Value" align="right">{$form.form_goods_num2[$i].html}</td>
				<td class="Value" align="center">{$form.mst_sync_flg[$i].html}</td>
				{* <td class="Value" align="center">{$form.form_breakdown[$i].html}</td> *}
			</A>
			</tr>
		{/foreach}

	</table>
	<table width="950">
		<tr>
			<td align='right'>{$form.clear_button.html}</td>
		</tr>
	</table>
	
	<p>
	<table>
	<tr>
	<td>
	<br><br>
		<table class="Data_Table" border="1" width="450" height="240" >
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
		</table>
	</td>

	<td valign="top">
	<b><font color="blue">
	<li>「修正発効日」以降の予定データは再作成されます。<br>
	<li>「契約終了日」以降の予定データは作成されません。
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



	<!---------------------- 画面表示2開始 ------------------->
	<table width="950">
		<tr>
			<td align='left'><b><font color="#ff0000">※は必須入力です</font></b></td>
		</tr>

		<tr>
			<td align='right'>{$form.entry_button.html}　　{$form.form_back.html}</td>
		</tr>
	</table>
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
