{$var.html_header}
<!--口-->
<script language="javascript">
{$var.code_value1}
</script>
<body background="../../../image/back_purple.png">
<form name="dateForm" method="post" enctype="multipart/form-data" action="#">
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
<table  class="Data_Table" border="1" width="425" >
	<tr>
		<td  class="Value" width="100"><b>部署コード</b></td>
		<td class="Value">{$form.form_part.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_part.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>部署コード</b></td>
		<td class="Value">{$form.form_part_cd[1].html}(検索){$form.form_part_name[1].html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_part_cd[1].html/$form.form_part_name[1].html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>倉庫コード</b></td>
		<td class="Value">{$form.form_ware.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_ware.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>スタッフコード</b></td>
		<td class="Value">{$form.form_staff.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_staff.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>スタッフコード</b></td>
		<td class="Value">{$form.form_staff1.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_staff1.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>業種コード</b></td>
		<td class="Value">{$form.form_btype.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_btype.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>銀行</b></td>
		<td class="Value">{$form.form_bank.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_bank.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>製品区分コード</b></td>
		<td class="Value">{$form.form_product.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_product.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>Ｍ区分コード</b></td>
		<td class="Value">{$form.form_g_goods.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_g_goods.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>地区コード</b></td>
		<td class="Value">{$form.form_area.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_area.html</td>
	</tr>

	<tr>
		<td  class="Value" width="100"><b>顧客区分コード</b></td>
		<td class="Value">{$form.form_client.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_client.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>商品コード</b></td>
		<td class="Value">{$form.form_goods.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_goods.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>運送業者コード</b></td>
		<td class="Value">{$form.form_forwarding.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_forwarding.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>締日コード</b></td>
		<td class="Value">{$form.form_close.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_position1.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>得意先コード</b></td>
		<td class="Value">{$form.form_customer.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_customer.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>仕入先コード</b></td>
		<td class="Value">{$form.form_layer.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_layer.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>ショップコード</b></td>
		<td class="Value">{$form.form_shop.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_shop.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>販売区分コード</b></td>
		<td class="Value">{$form.form_kind.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_kind.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>サービスコード</b></td>
		<td class="Value">{$form.form_service.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_service.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>直送先コード</b></td>
		<td class="Value">{$form.form_direct.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_direct.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>取引区分コード</b></td>
		<td class="Value">{$form.form_dealing.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_dealing.html</td>
	</tr>
	<tr>
		<td  class="Value" width="100"><b>担当者コード</b></td>
		<td class="Value">{$form.form_charge.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_charge.html</td>
	</tr>
	<tr>
		<td class="Value" width=""><b>請求先コード</b></td>
		<td class="Value">{$form.form_claim.html}</td>
	</tr>
	<tr>
		<td class="Title_Pink" colspan="2">$form.form_claim.html</td>
	</tr>
</td>
</tr>
</table>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

