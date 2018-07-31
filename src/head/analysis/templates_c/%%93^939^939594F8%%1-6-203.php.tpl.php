<?php /* Smarty version 2.6.9, created on 2006-01-30 21:35:36
         compiled from 1-6-203.php.tpl */ ?>

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
		<td class="Title_Pink" width=""><b>保険</b></td>
		<td class="Title_Pink" width=""><b>保険額</b></td>
		<td class="Title_Pink" width=""><b>人数</b></td>
		<td class="Title_Pink" width=""><b>総計</b></td>
	</tr>

	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">東陽</td>
		<td align="center">保険</td>
		<td align="right">9,490</td>
		<td align="right">16</td>
		<td align="right"><b>151,840</b></td>
	</tr>
	
	<tr class="Result2">
		<td align="right" rowspan="3">2</td>
		<td align="left" rowspan="3">メディスポ</td>
		<td align="center" align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">3</td>
		<td align="right"><b>9,000</b></td>
	</tr>

	<tr class="Result2">
		<td align="center">障害保険</td>
		<td align="right">1,920</td>
		<td align="right">12</td>
		<td align="right"><b>23,040</b></td>
	</tr>

	<tr class="Result2">
		<td align="center">賠償保険</td>
		<td align="right">2,350</td>
		<td align="right">1</td>
		<td align="right"><b>2,350</b></td>
	</tr>

	<tr class="Result1">
		<td align="right" rowspan="2">3</td>
		<td align="left" rowspan="2">四国</td>
		<td align="center" align="center">障害保険</td>
		<td align="right">1,720</td>
		<td align="right">2</td>
		<td align="right"><b>3,440</b></td>
	</tr>

	<tr class="Result1">
		<td align="center">共済</td>
		<td align="right">3,000</td>
		<td align="right">3</td>
		<td align="right"><b>9,000</b></td>
	</tr>
	
	<tr class="Result2">
		<td align="right">4</td>
		<td align="left">山陽</td>
		<td align="center">賠償保険</td>
		<td align="right">1,280</td>
		<td align="right">1</td>
		<td align="right"><b>1,280</b></td>
	</tr>
	
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left">アルファ</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">1</td>
		<td align="right"><b>3,000</b></td>
	</tr>
	
	<tr class="Result2">
		<td align="right">6</td>
		<td align="left">72</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">3</td>
		<td align="right"><b>9,000</b></td>
	</tr>
	
	<tr class="Result1">
		<td align="right">7</td>
		<td align="left">熊本</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">2</td>
		<td align="right"><b>6,000</b></td>
	</tr>
	
	<tr class="Result2">
		<td align="right">8</td>
		<td align="left">ｻﾆｸﾘｰﾝ宇都宮</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">2</td>
		<td align="right"><b>6,000</b></td>
	</tr>
	
	<tr class="Result1">
		<td align="right">9</td>
		<td align="left">Bee</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">1</td>
		<td align="right"><b>3,000</b></td>
	</tr>
	
	<tr class="Result2">
		<td align="right">10</td>
		<td align="left">BHIC</td>
		<td align="center">共済保険</td>
		<td align="right">3,000</td>
		<td align="right">3</td>
		<td align="right"><b>9,000</b></td>
	</tr>
	
	<tr class="Result3">
		<td align="left"><b>合計</b></td>
		<td align="left"><b>10社</b></td>
		<td align="center"></td>
		<td align="left"></td>
		<td align="right"></td>
		<td align="right"><b>235,950</b></td>
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

	
