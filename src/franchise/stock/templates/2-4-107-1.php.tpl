
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
		<td valign="top">
		
			<table>
				<tr>
					<td>
<table border="0" width="100%">
	<tr>
		<td align="left"><font color = "BLUE"><b>・以下の在庫を移動しました。</b></font>　　　{$form.form_comp_button.html}</td>
	</tr>
</table>
<br>
<table class="List_Table" border="1" width="650">
	<tr align="center">
		<td class="Title_Yellow" width="" rowspan="2"><b>No.</b></td>
		<td class="Title_Yellow" width="" rowspan="2"><b>商品コード<br>商品名</b></td>
		<td class="Title_Yellow" width="" colspan="2"><b>移動元</b></td>
		<td class="Title_Yellow" width="" colspan="2"><img src="../../../image/arrow.gif"></td>
		<td class="Title_Yellow" width="" colspan="2"><b>移動先</b></td>
	</tr>

	<tr align="center">
		<td class="Title_Yellow" width=""><b>倉庫名</b></td>
		<td class="Title_Yellow" width=""><b>在庫数<br>（引当数）</b></td>
		<td class="Title_Yellow" width=""><b>移動数</b></td>
		<td class="Title_Yellow" width=""><b>単位</b></td>
		<td class="Title_Yellow" width=""><b>倉庫名</b></td>
		<td class="Title_Yellow" width=""><b>在庫数<br>（引当数）</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">{$form.t_goods1_code.html}<br>{$form.t_goods1_name.html}</td>
		<td align="left">{$form.form_ware_3.html}</td>
		<td align="right">{$form.t_goods1_num1.html}<br>{$form.t_goods1_num2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">{$form.t_goods1_unit.html}</td>
		<td align="left">{$form.form_ware_4.html}</td>
		<td align="right">{$form.t_goods1_num3.html}<br>{$form.t_goods1_num4.html}</td>
	</tr>
	
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">{$form.t_goods2_code.html}<br>{$form.t_goods2_name.html}</td>
		<td align="left">{$form.form_ware_5.html}</td>
		<td align="right">{$form.t_goods2_num1.html}<br>{$form.t_goods2_num2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">{$form.t_goods2_unit.html}</td>
		<td align="left">{$form.form_ware_6.html}</td>
		<td align="right">{$form.t_goods2_num3.html}<br>{$form.t_goods2_num4.html}</td>
	</tr>
		
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
		<td align="left">{$form.form_ware_7.html}</td>
		<td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">{$form.t_goods3_unit.html}</td>
		<td align="left">{$form.form_ware_8.html}</td>
		<td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
	</tr>
	
	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
		<td align="left">{$form.form_ware_7.html}</td>
		<td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">{$form.t_goods3_unit.html}</td>
		<td align="left">{$form.form_ware_8.html}</td>
		<td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
	</tr>
	
	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
		<td align="left">{$form.form_ware_7.html}</td>
		<td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
		<td align="center">{$form.f_text9.html}</td>
		<td align="left">{$form.t_goods3_unit.html}</td>
		<td align="left">{$form.form_ware_8.html}</td>
		<td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
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
	

