<?php /* Smarty version 2.6.9, created on 2006-01-31 08:52:19
         compiled from 1-6-204.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_pink.png">
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
		<td class="Title_Pink" width="100"><b>取引年月<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_date_c1']['html']; ?>
</td>
	</tr>
	
	<tr>
		<td class="Title_Pink"width="110"><b>ショップコード</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_code_a1']['html']; ?>
</td>
		<td class="Title_Pink"width="110"><b>ショップ名</b></td>
		<td class="Value" width="220"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
	</tr>

</table>
<table width='650'>
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
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
<?php echo $this->_tpl_vars['var']['html_page']; ?>


<font size="+0.5" color="#555555"><b>【取引年月：2006-01】</b></font>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Pink" width=""><b>NO</b></td>
		<td class="Title_Pink" width=""><b>ショップ名</b></td>
		<td class="Title_Pink" width=""><b>売上金額<br>(ロイヤリティ対象外)</b></td>
		<td class="Title_Pink" width=""><b>売上金額<br>(ロイヤリティ対象)</b></td>
		<td class="Title_Pink" width=""><b>総計</b></td>
		<td class="Title_Pink" width=""><b>ロイヤリティ額</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">FC1</td>
		<td align="right">10,000</td>
		<td align="right">10,000</td>
		<td align="right">20,000</td>
		<td align="right">600.00</td>
	</tr>
	
	<!--2行目-->
	<tr class="Result2">
		<td align="right" rowspan="3">2</td>
		<td align="left">FC2</td>
		<td align="right">20,000</td>
		<td align="right">20,000</td>
		<td align="right">40,000</td>
		<td align="right">1,200.00</td>
	</tr>
	
	<!--3行目-->
	<tr class="Result2">
		<td align="left">FC3</td>
		<td align="right">30,000</td>
		<td align="right">30,000</td>
		<td align="right">60,000</td>
		<td align="right">1,800.00</td>
	</tr>

	<!--4行目-->
	<tr class="Result2">
		<td align="left">FC4</td>
		<td align="right">40,000</td>
		<td align="right">40,000</td>
		<td align="right">80,000</td>
		<td align="right">2,400.00</td>
	</tr>

	<!--5行目-->
	<tr class="Result1">
		<td align="right" rowspan="2">3</td>
		<td align="left">FC5</td>
		<td align="right">50,000</td>
		<td align="right">50,000</td>
		<td align="right">100,000</td>
		<td align="right">3,000</td>
	</tr>

	<!--6行目-->
	<tr class="Result1">
		<td align="left">FC6</td>
		<td align="right">60,000</td>
		<td align="right">60,000</td>
		<td align="right">120,000</td>
		<td align="right">3,600.00</td>
	</tr>

	<tr class="Result3" align="center">
		<td align="left"><b>合計</b></td>
		<td align="center"><b>10社</b></td>
		<td align="right"><b>550,000</b></td>
		<td align="right"><b>550,000</b></td>
		<td align="right"><b>1,100.000.00</b></td>
		<td align="right"><b>33,000</b></td>
	</tr>

</table>

<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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

	
