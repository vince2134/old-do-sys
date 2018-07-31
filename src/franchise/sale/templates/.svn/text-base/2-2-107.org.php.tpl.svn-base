
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- メニュー開始 --> {$var.page_menu} <!-- メニュー終了 -->
		</td>

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->



<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>


				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->
<fieldset>
<legend><font size="+0.5" color="#555555"><b>【伝票番号】： 00000001 </b></font><a href="../system/2-1-115.php">契約マスタ表示</a></legend>
<table class="List_Table" border="1">
<!--
<col width="35">
<col width="120">
<col width="200">
<col width="120">
<col width="120">
<col width="120">
<col width="50">
<col width="55">
<col width="50">
<col width="55">
-->
	<tr align="center">
		<td class="Title_Pink" width=""><b>No.</b></td>
		<td class="Title_Pink" width=""><b>配送日<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>コース名<br>順路</b></td>
		<td class="Title_Pink" width=""><b>得意先名<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>取引区分<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>売上計上日<font color="red">※</font><br>請求日<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>巡回担当者<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>商品合計<br>消費税</b></td>
		<td class="Title_Pink" width=""><b>伝票合計</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="center" width="150">{$form.form_delivery_day.html}</td>
		<td align="left">{$form.form_course.html}<br>{$form.form_regular_route.html}</td>
		<td align="left">{$form.form_client_cd.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('form_client_cd[cd1]','form_client_cd[cd2]','form_client_name'),500,450);">検索</a>）<br>{$form.form_client_name.html}</td>
		<td align="left">{$form.trade_aord.html}</td>
		<td align="center" width="150">{$form.form_sale_day.html}<br>{$form.form_bill_day.html}</td>
		<td align="left">
			{$form.form_staff_1.html}&nbsp;{$form.form_percentage1.html}%<br>
			{$form.form_staff_2.html}&nbsp;{$form.form_percentage2.html}%<br>
			{$form.form_staff_3.html}&nbsp;{$form.form_percentage3.html}%
		</td>
		<td align="right">147,600.00<br>7,380</td>
		<td align="right">154,980.00</td>
	</tr>
	<tr class="Result1">
		<td class="Title_Pink"><b>備考</b></td>
		<td class="Value" colspan="3">{$form.form_note.html}</td>
		<td class="Title_Pink" ><b>訂正理由</b></td>
		<td class="Value"  colspan="6">{$form.form_correction.html}</td>
	</tr>
</table>
<BR>
<table class="List_Table" border="1">
<col width="10">
<col width="120">
<col width="120">
<col width="120">
<col width="50">
<col width="110">
<col width="50">
<col width="55">
	<tr align="center">
		<td class="Title_Pink" width=""><b>No.</b></td>
		<td class="Title_Pink" width=""><b>販売区分<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>サービス<br>サービス名</b></td>
		<td class="Title_Pink" width=""><b>商品コード<font color="red">※</font><br>商品名<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>商品数<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>売上単価<font color="red">※</font><br>売上金額<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>商品コード<br>預け</b></td>
		<td class="Title_Pink" width=""><b>預け数<font color="red">※</font></b></td>
		<td class="Title_Pink" width=""><b>{$form.form_slip.html}</b></td>
		<td class="Title_Pink" width=""><b>行（<a href="#">追加</a>）</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">{$form.form_divide_1.html}</td>
		<td align="left">{$form.form_serv_1.html}</td>
		<td align="left">{$form.form_goods_cd1.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd1','form_goods_name1'),500,450);">検索</a>）<br>{$form.form_goods_name1.html}</td>
		<td align="center">{$form.form_goods_num1.html}</td>
		<td align="center">{$form.form_sale_price1.html}<br>{$form.form_sale_amount1.html}</td>
		<td align="left">{$form.form_goods_cd2.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd2','form_goods_name2'),500,450);">検索</a>）<br>{$form.form_goods_name2.html}</td>
		<td align="center">{$form.form_impri_num1.html}</td>
		<td align="center">{$form.form_slip_check[0].html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>
	
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">{$form.form_divide_2.html}</td>
		<td align="left">{$form.form_serv_2.html}</td>
		<td align="left">{$form.form_goods_cd3.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd3','form_goods_name3'),500,450);">検索</a>）<br>{$form.form_goods_name3.html}</td>
		<td align="center">{$form.form_goods_num2.html}</td>
		<td align="center">{$form.form_sale_price2.html}<br>{$form.form_sale_amount2.html}</td>
		<td align="left">{$form.form_goods_cd4.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd4','form_goods_name4'),500,450);">検索</a>）<br>{$form.form_goods_name4.html}</td>
		<td align="center">{$form.form_impri_num2.html}</td>
		<td align="center">{$form.form_slip_check[1].html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">{$form.form_divide_3.html}</td>
		<td align="left">{$form.form_serv_3.html}</td>
		<td align="left">{$form.form_goods_cd5.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd5','form_goods_name5'),500,450);">検索</a>）<br>{$form.form_goods_name5.html}</td>
		<td align="center">{$form.form_goods_num3.html}</td>
		<td align="center">{$form.form_sale_price3.html}<br>{$form.form_sale_amount3.html}</td>
		<td align="left">{$form.form_goods_cd6.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd6','form_goods_name6'),500,450);">検索</a>）<br>{$form.form_goods_name6.html}</td>
		<td align="center">{$form.form_impri_num3.html}</td>
		<td align="center">{$form.form_slip_check[2].html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">{$form.form_divide_4.html}</td>
		<td align="left">{$form.form_serv_4.html}</td>
		<td align="left">{$form.form_goods_cd7.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd7','form_goods_name7'),500,450);">検索</a>）<br>{$form.form_goods_name7.html}</td>
		<td align="center">{$form.form_goods_num4.html}</td>
		<td align="center">{$form.form_sale_price4.html}<br>{$form.form_sale_amount4.html}</td>
		<td align="left">{$form.form_goods_cd8.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd8','form_goods_name8'),500,450);">検索</a>）<br>{$form.form_goods_name8.html}</td>
		<td align="center">{$form.form_impri_num4.html}</td>
		<td align="center">{$form.form_slip_check[3].html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">{$form.form_divide_5.html}</td>
		<td align="left">{$form.form_serv_5.html}</td>
		<td align="left">{$form.form_goods_cd9.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd9','form_goods_name9'),500,450);">検索</a>）<br>{$form.form_goods_name9.html}</td>
		<td align="center">{$form.form_goods_num5.html}</td>
		<td align="center">{$form.form_sale_price5.html}<br>{$form.form_sale_amount5.html}</td>
		<td align="left">{$form.form_goods_cd10.html}（<a href="#" onClick="return Open_SubWin('../dialog/2-0-210.php',Array('form_goods_cd10','form_goods_name10'),500,450);">検索</a>）<br>{$form.form_goods_name10.html}</td>
		<td align="center">{$form.form_impri_num5.html}</td>
		<td align="center">{$form.form_slip_check[4].html}</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

</table>
</fieldset>
<table border="0" width="100%">
	<tr>
		<td align="left"><b><font color="red">※は必須入力です</font></b></td>
	</tr>
	<tr>
		<td align='right'>
			{$form.correction_button.html}　<!--　{$form.button.reflection.html}　-->　{$form.return_button.html}
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
	

