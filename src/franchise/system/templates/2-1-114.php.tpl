
{$var.html_header}

<body bgcolor="#D8D0C8">

<form name="referer" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
<form {$form.attributes}>
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
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
<!---------------------- 画面表示1開始 --------------------->

<table border="0" width='100%'>
<tr valign="top"><td>
<table width="600">
	<tr>
        <td><li><a href="2-1-117.php"><b><font size="5">巡回担当者一括訂正</font></a></td>
    </tr>
    <tr>
        <td><li><a href="2-1-120.php"><b><font size="5">サービス/商品一括訂正</font></a></td>
	</tr>
</table>


</td></tr>
</table>


<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->




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
	

