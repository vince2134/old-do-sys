
{$var.html_header}

<!-- styleseet -->
<style type="text/css">
	/** 年度カラー **/
	font.color {ldelim}
		color: #555555;
		font-size: 16px;
	    font-weight:bold;
	{rdelim}
</style>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<!--------------------- 外枠開始 --------------------->
<table border="0" width="100%" height="90%" class="M_Table">

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
</form>
<!---------------------- 画面表示1開始 ------------------->
<form {$form.attributes}>
{$form.hidden}

<table width="450"><tr><td>

{* エラー表示 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{* 予定巡回日 *}
{if $var.error_msg != null}
    <li>{$var.error_msg}<br>
{/if}
{if $var.error_msg2 != null}
    <li>{$var.error_msg2}<br>
{/if}
</span>

<table class="Data_Table" border="1" width="100%">
	<tr>
		<td class="Title_Pink" width="100" nowrap><b>部署</b></td>
		<td class="Value" align="left">{$form.form_part_1.html}</td>
	</tr>
	<tr>
        <td class="Title_Pink" width="100"><b>巡回担当者</b></td>
        <td class="Value" align="left">{$form.form_staff_1.html}</td>
    </tr>
	<tr>
		<td class="Title_Pink" width="100"><b>予定巡回日<font color="#ff0000">※</font></b></td>
		<td class="Value" align="left">{$form.form_sale_day.html}</td>
	</tr>
	{* FCの場合は表示なし *}
	{if $smarty.session.group_kind != '3'}
		<tr>
        	<td class="Title_Pink" width="100"><b>代行先</b></td>
        	<td class="Value" align="left">{$form.form_fc.html}</td>
    	</tr>
	{/if}
</table>
<table width="100%">
	<tr>
		<td align="right">{$form.indicate_button.html}　　{$form.clear_button.html}</td>
	</tr>
</table>

</td></tr></table>


<!--表示ボタンが押された場合or前週・翌週ボタン押下or切替ボタン時に、カレンダー表示、ただしエラーがないときのみ-->
{if ($smarty.post.indicate_button == "表　示" || $smarty.post.back_w_button_flg == true || $smarty.post.next_w_button_flg == true) && $var.error_msg == NULL}
	<br>
	<font size="+0.5" color="#555555"><b>【カレンダー表示期間：{$var.cal_range}】</b></font>
	<!---------------------- 画面表示1終了 ---------------------->
	<br>
	<hr>
	<!---------------------- 通常カレンダー ---------------------->
	{foreach from=$disp_data key=i item=item}
		<A NAME="{$i}">
		<A NAME="{$j}m">
		{* 結果ヘッダ *}

		<font class="color">{$form.back_w_button.$i.html}　{$var.year}年 {$var.month}月　{$form.next_w_button.$i.html}</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>【伝票識別　　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="675">
				<tr>
					<td class="Title_Pink" width="100"><b>部署</b></td>
					<td class="Value" align="left" width="125">{$disp_data[$i][0][0]}</td>
					<td class="Title_Pink" width="100"><b>予定件数</b></td>
					<td class="Value" align="right" width="125">{$disp_data[$i][0][1]}件</td>
					<td class="Title_Pink" width="100"><b>予定金額</b></td>
					<td class="Value" align="right" width="125">{$disp_data[$i][0][2]}</td>
				</tr>
			</table>
			</td>
			<td align="left">
				<table width="410">
				<tr>
					<td>{$form.form_slip_button.html}</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		{* 部署ごとのカレンダー *}

		<table class="Data_Table" height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">
		
		{$calendar[$i]}

		{$calendar3[$i]}

		{* 部署ごとの担当者 *}
		{foreach from=$calendar2[$i] key=j item=item}
			{$calendar2[$i][$j]}
		{/foreach}

		</table>
		</A>
		</A>
		<br>
		<hr>
		<br>

	{/foreach}

	<!---------------------- 代行カレンダー ---------------------->
	{foreach from=$act_disp_data key=i item=item}
		<A NAME="{$i}">
		{* 結果ヘッダ *}

		<font class="color">{$form.back_w_button.$i.html}　{$var.year}年 {$var.month}月　{$form.next_w_button.$i.html}</font><br><br>

		<table border="0" width="675%">
		<tr>
			<td align="left"><font size="+0.5" color="#555555"><b>【伝票識別　　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font></td>
		</tr>
		</table>
		<table border="0" width="675">
		
		<tr>
			<td align="left">
			<table  class="Data_Table" border="1" width="450">
				<tr>
					<td class="Title_Pink" width="100"><b>予定件数</b></td>
					<td class="Value" align="right" width="125">{$act_disp_data[$i][0][0]}件</td>
					<td class="Title_Pink" width="100"><b>予定金額</b></td>
					<td class="Value" align="right" width="125">{$act_disp_data[$i][0][1]}</td>
				</tr>
			</table>
			</td>
			<td align="left">
				<table width="410">
				<tr>
					<td>{$form.form_slip_button.html}</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		{* 受託先ごとのカレンダー *}

		<table class="Data_Table" height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">
		
		{$act_calendar[$i]}

		{$act_calendar3[$i]}

		{$act_calendar2[$i]}

		</table>
		</A>
		<br>
		<hr>
		<br>

	{/foreach}

	<!-- データが無い場合、前月・翌月ボタンだけ表示 -->
	{if $var.data_msg != NULL && $var.act_data_flg == false}
		<font class="color">{$form.back_w_button.html}　{$var.year}年 {$var.month}月　{$form.next_w_button.html}</font><br><br>
		<!-- エラー表示 -->
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$var.data_msg}</span></font>
	{/if}
{/if}
<!--******************** 画面2表示終了 *******************-->
					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
