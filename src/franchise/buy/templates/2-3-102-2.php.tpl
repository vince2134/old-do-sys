
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

			<table border=0 >
				<tr>
					<td>


<!---------------------- 画面表示1開始 --------------------->
<table width="100%">
	<tr>
		<td align="left"><font size="+0.9"><b>下記の内容で発注してもよろしいですか？</b></font>
		{$form.button.touroku3.html}　　{$form.button.after_touroku.html}　　{$form.button.modoru.html}</td>
	</tr>
</table>
<br>
<table  class="Data_Table" border="1" width="650" >
	<tr>
		<td class="Title_Blue" width="100"><b>出荷可能数</b></td>
		<td class="Value" colspan="3">7 日後までの発注済数と引当数を考慮する</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>発注番号</b></td>
		<td class="Value" colspan="3"></td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>発注日</b></td>
		<td class="Value"></td>
		<td class="Title_Blue" width="100"><b>希望納期</b></td>
		<td class="Value" width="200"></td>
	</tr>

	<tr>
		<td class="Title_Blue"><b>入荷予定日</b></td>
		<td class="Value"></td>
		<td class="Title_Blue" width="93"><b>運送業者</b></td>
		<td class="Value">{$form.form_trans_check.html}</td>
	</tr>

	<tr>
		<td class="Title_Blue"><b>仕入先</b></td>
		<td class="Value" colspan="3"></td>
	</tr>

	<tr>
		<td class="Title_Blue"><b>直送先</b></td>
		<td class="Value"></td>
		<td class="Title_Blue" width="100"><b>仕入倉庫</b></td>
		<td class="Value" width="250"></td>
	</tr>

	<tr>
		<td class="Title_Blue"><b>取引区分</a></b></td>
		<td class="Value"></td>
		<td class="Title_Blue" width="100"><b>担当者</b></td>
		<td class="Value" width="200"></td>
	</tr>
	
	<tr>
		<td class="Title_Blue" ><b>通信欄<br>（仕入先宛）</b></td>
		<td class="Value" colspan="3"></td>
	</tr>
	
	<tr>
		<td class="Title_Blue"><b>通信欄<br>（本部宛）</b></td>
		<td class="Value" colspan="3"></td>
	</tr>

</table>
<br>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Blue" width=""><b>No.</b></td>
		<td class="Title_Blue" width=""><b>商品コード<br>商品名</b></td>
		<td class="Title_Blue" width=""><b>実棚数<br>(A)</b></td>
		<td class="Title_Blue" width=""><b>発注済数<br>(B)</b></td>
		<td class="Title_Blue" width=""><b>引当数<br>(C)</b></td>
		<td class="Title_Blue" width=""><b>出荷可能数<br>(A+B-C)</b></td>
		<td class="Title_Blue" width=""><b>発注数</b></td>
		<td class="Title_Blue" width=""><b>仕入単価</b></td>
		<td class="Title_Blue" width=""><b>仕入金額</b></td>
		<td class="Title_Blue" width=""><b>入荷予定日</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">00000001<br>商品1</td>
		<td align="right">80</td>
		<td align="right">5</td>
		<td align="right">20</td>
		<td align="right">65</td>
		<td align="right">10</td>
		<td align="right">1,200.00</td>
		<td align="right">12,000.00</td>
		<td align="center">2005-04-01</td>
	</tr>
	
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">00000002<br>商品2</td>
		<td align="right">100</td>
		<td align="right">15</td>
		<td align="right">20</td>
		<td align="right">95</td>
		<td align="right">10</td>
		<td align="right">1,200.00</td>
		<td align="right">12,000.00</td>
		<td align="center">2005-04-01</td>
	</tr>	
	
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">00000003<br>商品3</td>
		<td align="right">50</td>
		<td align="right">20</td>
		<td align="right">20</td>
		<td align="right">50</td>
		<td align="right">10</td>
		<td align="right">1,200.00</td>
		<td align="right">12,000.00</td>
		<td align="center">2005-04-01</td>
	</tr>	

	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">00000004<br>商品4</td>
		<td align="right">70</td>
		<td align="right">10</td>
		<td align="right">20</td>
		<td align="right">60</td>
		<td align="right">10</td>
		<td align="right">1,200.00</td>
		<td align="right">12,000.00</td>
		<td align="center">2005-04-01</td>
	</tr>	

	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">00000005<br>商品5</td>
		<td align="right">60</td>
		<td align="right">25</td>
		<td align="right">20</td>
		<td align="right">65</td>
		<td align="right">10</td>
		<td align="right">1,200.00</td>
		<td align="right">12,000.00</td>
		<td align="center">2005-04-01</td>
	</tr>	

	<tr class="Result2">
		<td align="left"><b>合計</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>60,000.00</b></td>
		<td></td>
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
	

