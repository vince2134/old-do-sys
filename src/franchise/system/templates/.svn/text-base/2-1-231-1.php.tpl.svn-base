{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
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

			<table border="0">
				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table border="0" width=$width>
	<tr>
		<td width="50%" align="left">全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}</td>
	</tr>
</table>

<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple"><b>業種コード</b></td>
		<td class="Title_Purple"><b>業種名</b></td>
		<td class="Title_Purple"><b>備考</b></td>
	</tr>

    {foreach from=$page_data key=i item=item}
	<tr class="Result1">
		<td align="right">{$i + 1}</td>
		<td align="left">{$item[0]}</td>
		<td align="left">{$item[1]}</td>
		<td align="left">{$item[2]}</td>
	</tr>
    {/foreach}
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
	

