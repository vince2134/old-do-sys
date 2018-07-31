
{$var.html_header}

                      
<body class="bgimg_purple" >
<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">
	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
	<!-- ダイアログの場合はメニュは非表示 -->
	{if $var.get_info_id == NULL}
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
	{/if}
		</td>
	</tr>
	
	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{$form.hidden}
<!---------------------- 画面表示1開始 --------------------->

<table class="Data_Table" border="1" width="650">
	<tr>
		<td class="Title_Purple" width="100"><b>サービス</b></td>
		<td class="Value" colspan="3">{$var.serv_name}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="100"><b>アイテム</b></td>
		<td class="Value" width="250">{$var.main_goods_name}</td>
		<td class="Title_Purple" width="100"><b>数量</b></td>
		<td class="Value">{$var.main_goods_num}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="100"><b>営業原価<br>売上単価</b></td>
		<td class="Value">{$var.main_trade_price}<br>{$var.main_sale_price}</td>
		<td class="Title_Purple" width="100"><b>原価合計額<br>売上合計額</b></td>
		<td class="Value">{$var.main_trade_amount}<br>{$var.main_sale_amount}</td>
	</tr>
</table>
<br>
<span style="color: #555555; font-weight: bold; line-height: 130%;">
【内訳】
</span>
<table class="Data_Table" border="1" width="650">
	<tr>
		<td class="Title_Purple"><b>アイテム</b></td>
		<td class="Title_Purple" rowspan="2"><b>数量</b></td>
		<td class="Title_Purple" colspan="2"><b>金額</b></td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>名称</b></td>
		<td class="Title_Purple"><b>営業原価<font color="#ff0000">※</font><br>売上単価</b></td>
		<td class="Title_Purple" ><b>原価合計額<br>売上合計額</b></td>
	</tr>
	
	{foreach key=i from=$loop_num item=items}
		<tr>
			<td class="Value">{$form.break_goods_cd[$var.row][$i].html}<br>{$form.break_goods_name[$var.row][$i].html}</td>
			<td class="Value" align="right">{$form.break_goods_num[$var.row][$i].html}</td>
			<td class="Value" align="right">{$form.break_trade_price[$var.row][$i].html}<br>{$form.break_sale_price[$var.row][$i].html}</td>
			<td class="Value" align="right">{$form.break_trade_amount[$var.row][$i].html}<br>{$form.break_sale_amount[$var.row][$i].html}</td>
			</td>
		</tr>
	{/foreach}

</table>
<!--******************** 画面表示1終了 *******************-->

<!---------------------- 画面表示2開始 --------------------->
<table width="650">
	<tr>
		<td align='right'>
		<!-- 遷移元判定 -->
		{if $var.get_info_id != NULL}
			<!-- ダイアログの場合は閉じるボタンだけ表示 -->
			{$form.close_button.html}
		{else}
			<!-- 設定・クリア・戻るボタンを表示 -->
			{$form.set.html}　　{$form.clear_button.html}　　{$form.form_back.html}
		{/if}
		</td>
	</tr>
</table>
<!--******************** 画面表示2終了 *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->
{$var.html_footer}