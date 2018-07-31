
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			{* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
		</td>
	</tr>

	<tr align="center">
		<td valign="top">
		
			<table>
				<tr>
					<td>

{*-------------------- 画面表示1開始 -------------------*}
<table  class="Data_Table" border="1" width="550" >

{*-	<tr>
		<td class="Title_Pink" width="175"><b>巡回担当者</b></td>
		<td class="Value">{$form.form_staff_1.html}</td>
	</tr>-*}
	<tr>
		<td class="Title_Pink" width="175"><b>配送日</b></td>
		<td class="Value">{$form.f_date_b1.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>巡回担当者コード</b></td>
		<td class="Value">{$form.f_code_g1.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>巡回担当者コード<br>(カンマ区切り)</b></td>
		<td class="Value">{$form.f_textx.html}</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="175"><b>除外巡回担当者コード<br>(カンマ区切り)</b></td>
		<td class="Value">{$form.f_textx.html}</td>
	</tr>

</table>
<table width='550'>
	<tr>
		<td align='right'>
			{$form.hyouji.html}　　{$form.kuria.html}
		</td>
	</tr>
</table>
{********************* 画面表示1終了 ********************}

					<br>
					</td>
				</tr>


				<tr>
					<td>

{*-------------------- 画面表示2開始 -------------------*}
{$var.html_page}


<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Pink" width=""><b>No.</b></td>
		<td class="Title_Pink" width=""><b>巡回担当者</b></td>
		<td class="Title_Pink" width=""><b>配送日</b></td>
		<td class="Title_Pink" width=""><b>巡回数</b></td>
		<td class="Title_Pink" width=""><b>配送コース順確認表印刷</b></td>
		<td class="Title_Pink" width="150"><b>{$form.allcheck14.html}</b></td>
	</tr>

	{*1行目*}
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">巡回担当1</td>
		<td align="center"><a href="2-2-106.php">2005-06-01</a></td>
		<td align="right">3件</td>
		<td align="center">印刷済</td>
		<td align="center">{$form.check14.html}</td>
	</tr>
	
	{*2行目*}
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">巡回担当2</td>
		<td align="center"><a href="2-2-106.php">2005-06-02</a></td>
		<td align="right">3件</td>
		<td align="center">印刷済</td>
		<td align="center">{$form.check14.html}</td>
	</tr>
	
	{*3行目*}
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">巡回担当3</td>
		<td align="center"><a href="2-2-106.php">2005-06-02</a></td>
		<td align="right">3件</td>
		<td align="center">未</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*4行目*}
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left">巡回担当4</td>
		<td align="center"><a href="2-2-106.php">2005-06-04</a></td>
		<td align="right">3件</td>
		<td align="center">印刷済</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*5行目*}
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">巡回担当1</td>
		<td align="center"><a href="2-2-106.php">2005-06-01</a></td>
		<td align="right">3件</td>
		<td align="center">未</td>
		<td align="center">{$form.check14.html}</td>
	</tr>

	{*6行目*}
	<tr class="Result2">
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right" colspan="2">{$form.delivery.html}</td>
	</tr>

</table>

{$var.html_page2}

{********************* 画面表示2終了 ********************}


					</td>
				</tr>
			</table>
		</td>
		{********************* 画面表示終了 ********************}

	</tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
	

