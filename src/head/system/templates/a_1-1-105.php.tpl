
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

	<tr align="left">

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border="0"  width="100%" cellspacing='0'>
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
{$var.calendar}

<br>
<table align="center" width='880'>
	<tr>
		<td align="right">{$form.button.set4.html}　　{$form.button.close.html}</td>
	</tr>
</table>

<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>
					</td>
				</tr>

			</table>

		</td>
<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

