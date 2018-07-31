<?php /* Smarty version 2.6.9, created on 2006-01-30 21:04:41
         compiled from 1-6-134.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_gray.png">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">
		<td width="18%" valign="top" lowspan="2">
			<!-- メニュー開始 --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- メニュー終了 -->
		</td>

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Gray"width="100"><b>出力形式</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output']['html']; ?>
</td>
		<td class="Title_Gray"width="100"><b>取引年月</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Gray" width="100"><b>部署</b></td>
		<td class="Value" width="220"><?php echo $this->_tpl_vars['form']['form_part_1']['html']; ?>
</td>
		<td class="Title_Gray" width="100"><b>担当者</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
	</tr>

</table>
<table width='650'>
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['button']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['kuria']['html']; ?>

		</td>
	</tr>
</table>
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>


				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->
<table class="List_Table" border="1" align="left">
	<tr align="center">
		<td class="Title_Gray" width="100" align="left"><b>取引年月</b></td>
		<td class="Value" align="center" width="">2005-01 〜 2005-12</td>
		<td class="Title_Gray" width="100" align="left"><b>部署</b></td>
		<td class="Value" align="left" width="130">部署1</td>
		<td class="Title_Gray" width="100" align="left"><b>担当者</b></td>
		<td class="Value" align="left" width="130">担当者1</td>
	</tr>
</table>
					</td>
				</tr>
				<tr>
					<td>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Gray" width="" rowspan="2"><b>NO</b></td>
		<td class="Title_Gray" width="" rowspan="2"><b>商品名</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>新規</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>増設</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>減額</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>キャンセル</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>変更</b></td>
		<td class="Title_Gray" width="" rowspan="2"><b>総合計</b></td>
	</tr>

	<tr align="center">
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
	</tr>

	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">商品1</td>
		<td align="right">5,000</td>
		<td align="right">2</td>
		<td align="right">1</td>
		<td align="right">10,000</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">10,000</td>
	</tr>
	
	<tr class="Result1">
		<td align="right" rowspan="2">2</td>
		<td align="left" rowspan="2">商品2</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right">4,500</td>
		<td align="right">7</td>
		<td align="right">1</td>
		<td align="right">31,500</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">31,500</td>
	</tr>

	<tr class="Result1">
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right">-500</td>
		<td align="right">2</td>
		<td align="right">1</td>
		<td align="right">-1,000</td>
		<td align="right" class="Result2">-1,000</td>
	</tr>

	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">商品5</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">6</td>
		<td align="left">商品6</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">7</td>
		<td align="left">商品7</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">8</td>
		<td align="left">商品8</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">9</td>
		<td align="left">商品9</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">10</td>
		<td align="left">商品10</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result2">
		<td align="left"><b>合計</b></td>
		<td align="left"><b></b></td>
		<td align="left"><b></b></td>
		<td align="right"><b>2</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>10,000</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>7</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>31,500</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>0</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>0</b></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"><b>0</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>2</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>-1,000</b></td>
		<td align="right"><b>40,500</b></td>
	</tr>

</table>
<br><br>
					</td>
				</tr>
				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->
<table class="List_Table" border="1" align="left">
	<tr align="center">
		<td class="Title_Gray" width="100" align="left"><b>取引年月</b></td>
		<td class="Value" align="center" width="">2005-01 〜 2005-12</td>
		<td class="Title_Gray" width="100" align="left"><b>部署</b></td>
		<td class="Value" align="left" width="130">部署1</td>
		<td class="Title_Gray" width="100" align="left"><b>担当者</b></td>
		<td class="Value" align="left" width="130">担当者1</td>
	</tr>
</table>
					</td>
				</tr>
				<tr>
					<td>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Gray" width="" rowspan="2"><b>NO</b></td>
		<td class="Title_Gray" width="" rowspan="2"><b>商品名</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>新規</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>増設</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>減額</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>キャンセル</b></td>
		<td class="Title_Gray" width="" colspan="4"><b>変更</b></td>
		<td class="Title_Gray" width="" rowspan="2"><b>総合計</b></td>
	</tr>

	<tr align="center">
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
		<td class="Title_Gray" width=""><b>単価</b></td>
		<td class="Title_Gray" width=""><b>件数</b></td>
		<td class="Title_Gray" width=""><b>回数/月</b></td>
		<td class="Title_Gray" width=""><b>合計</b></td>
	</tr>

	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">商品1</td>
		<td align="right">5,000</td>
		<td align="right">2</td>
		<td align="right">1</td>
		<td align="right">10,000</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">10,000</td>
	</tr>
	
	<tr class="Result1">
		<td align="right" rowspan="2">2</td>
		<td align="left" rowspan="2">商品2</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right">4,500</td>
		<td align="right">7</td>
		<td align="right">1</td>
		<td align="right">31,500</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">31,500</td>
	</tr>

	<tr class="Result1">
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right">-500</td>
		<td align="right">2</td>
		<td align="right">1</td>
		<td align="right">-1,000</td>
		<td align="right" class="Result2">-1,000</td>
	</tr>

	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">商品5</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">6</td>
		<td align="left">商品6</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">7</td>
		<td align="left">商品7</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">8</td>
		<td align="left">商品8</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">9</td>
		<td align="left">商品9</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result1">
		<td align="right">10</td>
		<td align="left">商品10</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">0</td>
		<td align="right" class="Result2">0</td>
	</tr>

	<tr class="Result2">
		<td align="left"><b>合計</b></td>
		<td align="left"><b></b></td>
		<td align="left"><b></b></td>
		<td align="right"><b>2</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>10,000</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>7</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>31,500</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>0</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>0</b></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"><b>0</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>2</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>-1,000</b></td>
		<td align="right"><b>40,500</b></td>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
