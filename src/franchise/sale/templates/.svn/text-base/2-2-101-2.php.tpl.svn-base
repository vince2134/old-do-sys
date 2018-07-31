
{$var.html_header}

<!-- styleseet -->
<style type="text/css">
	/** 年度カラー **/
	font.color {ldelim}
		color: #555555;
		font-size: 16px;
	    font-weight:bold;
	{rdelim}

	/** カレンダーの項目(月から金) **/
	td.calweek {ldelim}
		background-color:  #cccccc;
		width:135px;
	{rdelim}

	/** カレンダーの項目(土) **/
	td.calsaturday {ldelim}
		background-color:  #66CCFF;
		width:135px;
	{rdelim}

	/** カレンダーの項目(日) **/
	td.calsunday {ldelim}
		background-color:  #FFBBC3;
		width:135px;
	{rdelim}

	/** カレンダーの枠 **/
	tr.cal_flame {ldelim}
		font-size: 130%;
		font-weight: bold;
	{rdelim}

</style>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<!-------------------- 外枠開始 --------------------->
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
{* 検索フォーム *}

<table width="450"><tr><td>

{* エラー表示 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{* 予定巡回日 *}
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}<br>
{/if}
</span>

<table  width="100%">
	<tr align="right" style="color: #555555;">
    	<td><b>出力形式</b>{$form.form_output_type.html}</td>
	</tr>
</table>
<table  class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Pink" width="100" nowrap><b>部署</b></td>
        <td class="Value" align="left">{$form.form_part_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>巡回担当者</b></td>
        <td class="Value" align="left">{$form.form_staff_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>予定巡回月<font color="#ff0000">※</font></b></td>
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


<!--表示ボタンが押された場合or前月・翌月ボタン押下or切替ボタン時に、カレンダー表示-->
{if $smarty.post.indicate_button == "表　示" || $smarty.post.back_button_flg == true || $smarty.post.next_button_flg == true}
	<br>
	<font size="+0.5" color="#555555"><b>【カレンダー表示期間：{$var.cal_range}】</b></font>
	<!---------------------- 画面表示1終了 ---------------------->
	<br>
	<hr>

{*
	履歴：
    　日付　　　　B票No.　　　　担当者　　　内容　
    　2006/10/31　02-027　　　　suzuki　    今月の伝票がないときには、前月・翌月ボタンだけを表示
*}

	<!-- データが無い場合、前月・翌月ボタンだけ表示 -->
	{if $var.cal_range_err == true}
{*
        <!-- 前月・翌月ボタン表示 -->
        <font class="color">{$form.back_button.html}　{$year}年 {$month}月　{$form.next_button.html}</font>　
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">巡回予定月はカレンダー表示期間を指定して下さい。</span></font>
*}

	<!-- データが無い場合、前月・翌月ボタンだけ表示 -->
	{elseif $var.cal_data_flg == false}
        <!-- 前月・翌月ボタン表示 -->
        <font class="color">{$form.back_button.html}　{$year}年 {$month}月　{$form.next_button.html}</font>　
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$var.data_msg}</span></font>

	{else}
		<!-- データあり -->

		<!---------------------- 画面表示2開始 ---------------------->
		<!-- 通常伝票 -->
		{foreach from=$disp_data key=i item=item}
			<!---------------------- 担当者カレンダー開始 ---------------------->

				<!-- 月のデータ存在判定 -->	
				{if $cal_msg[$i] != NULL}
					<!-- 月のデータが無い場合は、警告表示 -->
					<font class="color">{$form.back_button.$i.html}　{$year}年 {$month}月　{$form.next_button.$i.html}</font>　
					<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$cal_msg[$i]}</span></font><br><br>

				{else}
					<!-- 月のデータ表示 -->	

					<A NAME="{$i}">
					<A NAME="m">
					{* 結果ヘッダ *}
					<!-- 前月・翌月ボタン表示 -->
					<font class="color">{$form.back_button.$i.html}　{$year}年 {$month}月　{$form.next_button.$i.html}</font>　

					<font size="+0.5" color="#555555"><b>【伝票識別　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font><br><br>

					<table border="0" width="100%">
					    <tr>
						<td align="left">

					        <table class="Data_Table" border="1" width="450">
					            <tr>
					                <td class="Title_Pink" width="100"><b>部署</b></td>
					                <td class="Value" align="left" width="125">{$disp_data[$i][0][0]}</td>
					                <td class="Title_Pink" width="100"><b>巡回担当者</b></td>
					                <td class="Value" align="left" width="125">{$disp_data[$i][0][1]}</td>
					            </tr>
					            <tr>
					                <td class="Title_Pink" width="100"><b>予定件数</b></td>
					                <td class="Value" align="right" width="125">{$disp_data[$i][0][2]}件</td>
					                <td class="Title_Pink" width="100"><b>予定金額</b></td>
					                <td class="Value" align="right" width="125">{$disp_data[$i][0][3]}</td>
					            </tr>
					        </table>
					    </td>
						<td align="left">
							<table width="600">
							<tr>
								<td>{$form.form_slip_button.html}</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					
					{* 結果カレンダー *}
					<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

					<tr height="20" valign="middle">
					    <td align="center" bgcolor="#cccccc" width="30"><b>巡回<br>基準</b></td>
						<td align="center" class="calsunday" ><b>日</b></td>
					    <td align="center" class="calweek" ><b>月</b></td>
					    <td align="center" class="calweek" ><b>火</b></td>
					    <td align="center" class="calweek" ><b>水</b></td>
					    <td align="center" class="calweek" ><b>木</b></td>
					    <td align="center" class="calweek" ><b>金</b></td>
					    <td align="center" class="calsaturday" ><b>土</b></td>
					</tr>

					{$calendar[$i]}

					</table>
					</A>
					</A>
					<!---------------------- 担当者カレンダー終了 ---------------------->

                    <br>
                    <hr>
					<br>
				{/if}
			<br>
		{/foreach}

		<!-- 代行伝票 -->
		{foreach from=$act_disp_data key=i item=item}
			<!---------------------- 担当者カレンダー開始 ---------------------->

				<!-- 月のデータ存在判定 -->	
				{if $act_cal_msg[$i] != NULL}
					<!-- 月のデータが無い場合は、警告表示 -->	
					<font class="color">{$form.back_button.$i.html}　{$year}年 {$month}月　{$form.next_button.$i.html}</font>　
					<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$act_cal_msg[$i]}</span></font><br><br>
				{else}
					<!-- 月のデータ表示 -->	

					<A NAME="{$i}">
					<A NAME="m">
					{* 結果ヘッダ *}
					<!-- 前月・翌月ボタン表示 -->
					<font class="color">{$form.back_button.$i.html}　{$year}年 {$month}月　{$form.next_button.$i.html}</font>　

					<font size="+0.5" color="#555555"><b>【伝票識別　<font color="blue">青：予定伝票</font>　<font color="Fuchsia">桃：予定伝票(2人)</font>　<font color="FF6600">橙：予定伝票(3人以上)</font>　<font color="green">緑：代行伝票</font>　<font color="gray">灰：確定伝票</font>】</b></font><br><br>

					<table border="0" width="100%">
					    <tr>
						<td align="left">

					        <table class="Data_Table" border="1" width="450">
					            <tr>
					                <td class="Title_Pink" width="110"><b>受託先</b></td>
					                <td class="Value" align="left" width="400" colspan="3">{$act_disp_data[$i][0][0]}</td>
					            </tr>
					            <tr>
					                <td class="Title_Pink" width="100"><b>予定件数</b></td>
					                <td class="Value" align="right" width="125">{$act_disp_data[$i][0][1]}件</td>
					                <td class="Title_Pink" width="100"><b>予定金額</b></td>
					                <td class="Value" align="right" width="125">{$act_disp_data[$i][0][2]}</td>
					            </tr>
					        </table>
					    </td>
						<td align="left">
							<table width="600">
							<tr>
								<td>{$form.form_slip_button.html}</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					
					{* 結果カレンダー *}
					<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

					<tr height="20" valign="middle">
					    <td align="center" bgcolor="#cccccc" width="30"><b>巡回<br>基準</b></td>
						<td align="center" class="calsunday" ><b>日</b></td>
					    <td align="center" class="calweek" ><b>月</b></td>
					    <td align="center" class="calweek" ><b>火</b></td>
					    <td align="center" class="calweek" ><b>水</b></td>
					    <td align="center" class="calweek" ><b>木</b></td>
					    <td align="center" class="calweek" ><b>金</b></td>
					    <td align="center" class="calsaturday" ><b>土</b></td>
					</tr>

					{$act_calendar[$i]}

					</table>
					</A>
					</A>
					<!---------------------- 担当者カレンダー終了 ---------------------->

                    <br>
                    <hr>
					<br>
				{/if}
			<br>
		{/foreach}
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
