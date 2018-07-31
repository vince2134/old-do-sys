
{$var.html_header}

<body class="bgimg_purple">
<form name="dateForm" method="post">

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


<!---------------------- 画面表示1開始 --------------------->

<!---------------------- 画面表示2開始 --------------------->
<table border="0">
	<tr>
	<td align="left">
		<table class="Data_Table" border="1" width="420" height="33">
			<tr>
				<td class="Title_Purple" width="90"><b>得意先名</b></td>
				<td class="Value" width="120">得意先A</td>
				<td class="Title_Purple" width="90"><b>取引区分</b></td>
				<td class="Value" width="120">掛売上</td>
			</tr>
		</table>
	</td>
	<td width="100">　　　　　</td>
	<td align="left">
		<table class="Data_Table" border="1" width="420" height="33">
			<tr>
				<td class="Title_Purple" width="90"><b>ご紹介口座</b></td>
				<td class="Value" width="120">十光A</td>
				<td class="Title_Purple" width="90"><b>ご紹介料</b></td>
				<td class="Value" width="120" align="right">2,400(契約合計)</td>
			</tr>
		</table>
	</td>
	</tr>
</table>

<br>

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Purple" rowspan="2"><b>行No.</b></td>
		<td class="Title_Purple" rowspan="2"><b>契約日<br>契約状態</b></td>
		<td class="Title_Purple" rowspan="2"><b>順路</b></td>
		<td class="Title_Purple" rowspan="2"><b>販売区分</b></td>
		<td class="Title_Purple" colspan="8"><b>巡回内容</b></td>
		<td class="Title_Purple" rowspan="2"><b>巡回日<br>（基準日）</b></td>
		<td class="Title_Purple" rowspan="2"><b>巡回担当（売上）</b></td>
		<td class="Title_Purple" rowspan="2"><b>変更<br><br>複写追加</b></td>
		<td class="Title_Purple" rowspan="2"><b>備考</b></td>
		<!--<td class="Title_Purple" rowspan="2"><b>複写<br>追加</b></td>-->
	</tr>

	<tr>
		<td class="Title_Purple" align="center" rowspan="1"><b></b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>印字</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>名称</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>数量</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>原価選択</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>営業原価<br>原価合計額</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>売上売価<br>売上合計額</b></td>
		<td class="Title_Purple" align="center" rowspan="1"><b>ご紹介料</b></td>
	</tr>

{foreach from=$disp_data key=i item=item}
	<!--1行目-->
	<!--サービス-->
	<tr class="{$disp_data.$i[0]}">
		<td align="center" rowspan="4">{$i+1}</td>
		<td align="center" rowspan="4">{$disp_data.$i[1]}</td>
		<td align="center" rowspan="4">{$disp_data.$i[2]}</td>
		<td align="center" rowspan="4">{$disp_data.$i[3]}</td>
		<td class="Title_Purple" align="left"><b>サービス</b></td>
		<td align="center">{$disp_data.$i[4]}</td>
		<td align="right">{$disp_data.$i[5]}</td>
		<td align="right">{$disp_data.$i[6]}</td>
		<td align="center" rowspan="2">{$disp_data.$i[7]}</td>
		<td align="right" rowspan="2">{$disp_data.$i[8]}</td>
		<td align="right" rowspan="2">{$disp_data.$i[9]}</td>
		<td align="right" rowspan="2">{$disp_data.$i[10]}</td>
		<td align="center" rowspan="4">{$disp_data.$i[11]}</td>
		<td align="center" rowspan="4">{$disp_data.$i[12]}</td>
		<td align="center" rowspan="4"><a href="./2-1-104_sample.php?flg=chg">変更</a><br><br><a href="./2-1-104_sample.php?flg=copy">複写追加</a></td>
		<td align="center" rowspan="4">{$disp_data.$i[13]}</td>
		<!--<td align="center" rowspan="4"></td>-->
	</tr>

	<!--アイテム-->
	<tr class="{$disp_data.$i[0]}">
		<td class="Title_Purple" align="left"><b>アイテム</b></td>
		<td align="center">{$disp_data.$i[14]}</td>
		<td align="right">{$disp_data.$i[15]}</td>
		<td align="right">{$disp_data.$i[16]}</td>
	</tr>
	
	<!--本体-->
	<tr class="{$disp_data.$i[0]}">
		<td class="Title_Purple" align="left"><b>本体</b></td>
		<td align="center">{$disp_data.$i[17]}</td>
		<td align="right">{$disp_data.$i[18]}</td>
		<td align="right">{$disp_data.$i[19]}</td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
	</tr>

	<!--消耗品-->
	<tr class="{$disp_data.$i[0]}">
		<td class="Title_Purple" align="left"><b>消耗品</b></td>
		<td align="center">{$disp_data.$i[20]}</td>
		<td align="right">{$disp_data.$i[21]}</td>
		<td align="right">{$disp_data.$i[22]}</td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
		<td class="Title_Purple" align="left"></td>
	</tr>

{/foreach}


</table>

<table width="100%">
	<tr>
		<td align='right'>
			{$form.form_insert.html}　　{$form.form_back.html}
		</td>
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
