
{$var.html_header}
<script language="javascript">
{$var.html_java}
</script>
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post" enctype="multipart/form-data" action="#">
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

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
		
			<table border="0"  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
<table border="0" width=850>
<col width="650">
<col width="200">
<tr>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>商品コード<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_goods.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>商品名<font color="#ff0000">※</font></b></td>
		<td class="Value" width="">{$form.f_text30.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>略称</b></td>
		<td class="Value">{$form.f_text30.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>属性区分<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio31.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b><a href="javascript:Sub_Window_Open('district.php')">Ｍ区分</a><font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_district.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b><a href="javascript:Sub_Window_Open('product.php')">製品区分</a><font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_product.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple" width="130"><b>単位</b></td>
		<td class="Value">{$form.f_text5.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>入数</b></td>
		<td class="Value">{$form.f_text4.html}</td>
	</tr>
</table>
</td>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>販売管理<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio28.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="131"><b>在庫管理<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio36.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>在庫限り品</b></td>
		<td class="Value">{$form.f_check.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="131"><b>発注点</b></td>
		<td class="Value">{$form.f_text9.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>発注単位数</b></td>
		<td class="Value">{$form.f_text4.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>リードタイム</b></td>
		<td class="Value">{$form.f_text2.html}日</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="131"><b>品名変更<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio33.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>課税区分<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio32.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>ロイヤリティ<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.f_radio16.html}</td>
	</tr>
</table>
<br>
</td>
</tr>
<tr>
<td>
<table class="Data_Table" border="1" width="450">

	<tr align="center">
		<td class="Title_Purple" width="130"><b>{$form.button.update.html}</b></td>
		<td class="Title_Purple" width="" width="130"><b>単価</b></td>
	</tr>


	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>仕入単価</b></td>
		<td align="center">{$form.f_code_c1.html}</td>
	</tr>
	

	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>標準単価</b></td>
		<td align="center">{$form.f_code_c2.html}</td>
	</tr>
	

	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>ショップ価格</b></td>
		<td align="center">{$form.f_code_c3.html}</td>
	</tr>

	
	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>加盟店価格</b></td>
		<td align="center">{$form.f_code_c4.html}</td>
	</tr>


	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>協力店価格</b></td>
		<td align="center">{$form.f_code_c5.html}</td>
	</tr>

	
	<tr class="Result1">
		<td class="Title_Purple" width="130"><b>直営価格</b></td>
		<td align="center">{$form.f_code_c6.html}</td>
	</tr>
</table>
</td>
<td valign="top">
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="130"><b>最新売上日</b></td>
		<td class="Value">2005-04-01</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>最新仕入日</b></td>
		<td class="Value">2005-04-02</td>
	</tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="450" align="left">
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
	</tr>
</table>
</td>
<td>
<table width="450" align="right">
	<tr>
		<td align="right">
			{$form.button.touroku.html}　　{$form.button.modoru.html}
		</td>
	</tr>
</table>
</td>
</tr>
</table>
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>

			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

