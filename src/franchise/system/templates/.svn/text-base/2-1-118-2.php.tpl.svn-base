
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
<tr valign="top">
    <td>

<font size="+0.5" color="#555555"><b>【営業単価変更】</b></font>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Purple"><b>No.</b></td>
		<td class="Title_Purple"><b>巡回予定日</b></td>
		<td class="Title_Purple"><b>得意先</b></td>
		<td class="Title_Purple"><b>請求先</b></td>
		<td class="Title_Purple"><b>アイテム</b></td>
		<td class="Title_Purple"><b>営業単価</b></td>
		<td class="Title_Purple"><b>売上単価</b></td>
		<td class="Title_Purple"><b>巡回担当者</b></td>
	</tr>
    {foreach from=$demo_data item=item key=i}
    {if $i IS even}
	<tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
		<td align="right">{$i+1}</td>
		<td align="left">{$demo_data[$i][0]}</td>
		<td align="left">{$demo_data[$i][1]}</td>
		<td align="left">{$demo_data[$i][2]}</td>
		<td align="left">{$demo_data[$i][3]}</td>
		<td align="right">{$demo_data[$i][4]}</td>
		<td align="right">{$demo_data[$i][5]}</td>
		<td align="left">{$demo_data[$i][6]}</td>
	</tr>
    {/foreach}
</table>

<br>

<table width="100%">
	<tr>
		<td align="center">
			<img src="../../../image/yajirusi.png">
		</td>
	</tr>
</table>

<br>

<table class="List_Table" border="1" width="450" align="center">
    <tr>
        <td class="Title_Purple"><b>営業単価</b></td>
        <td class="Value">{$form.f_code_c1.html}</td>
    </tr>
</table>

<table width="450"  align="center">
    <tr>
        <td align="right">{$form.button.change2.html}　{$form.button.modoru.html}</td>
    </tr>
</table>

    </td>
</tr>
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
	

