<?php /* Smarty version 2.6.9, created on 2006-01-31 08:52:27
         compiled from 1-6-201.php.tpl */ ?>

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
		<td class="Title_Pink" width="100"><b>出力形式</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_r_output']['html']; ?>
</td>
	</tr>

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
			<?php echo $this->_tpl_vars['form']['button']['hyouji16']['html']; ?>
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
		<td class="Title_Pink" width=""><b>No</b></td>
		<td class="Title_Pink" width=""><b>ショップ名</b></td>
		<td class="Title_Pink" width=""><b>レンタル先</b></td>
		<td class="Title_Pink" width=""><b>商品名</b></td>
		<td class="Title_Pink" width=""><b>レンタル料</b></td>
		<td class="Title_Pink" width=""><b>レンタル数</b></td>
		<td class="Title_Pink" width=""><b>レンタル額</b></td>
		<td class="Title_Pink" width=""><b>備考</b></td>
	</tr>

	<tr class="Result1">
		<td align="right" rowspan="11">1</td>
		<td align="left" rowspan="11">FC1</td>
		<td align="center" rowspan="4">得意先A</td>
		<td align="left">商品A</td>
		<td align="right">100</td>
		<td align="right">1</td>
		<td align="right">100</td>
		<td align="right"></td>
	</tr>
	<tr class="Result1">
		<td align="left">商品B</td>
		<td align="right">200</td>
		<td align="right">2</td>
		<td align="right">400</td>
		<td align="right"></td>
	</tr>

	<tr class="Result1">
		<td align="left">商品C</td>
		<td align="right">300</td>
		<td align="right">3</td>
		<td align="right">900</td>
		<td align="right"></td>
	</tr>
	<tr class="Result1">
		<td align="left">商品D</td>
		<td align="right">400</td>
		<td align="right">4</td>
		<td align="right">1,600</td>
		<td align="right"></td>
	</tr>

	<tr class="Result2">
		<td align="left"><b>小計</b></td>
		<td align="left"><b>4種類</b></td>
		<td align="right"><b>1,000</b></td>
		<td align="right"><b>10</b></td>
		<td align="right"><b>3,000</b></td>
		<td align="right"></td>
	</tr>
	
	<tr class="Result1">
		<td align="center" rowspan="5">得意先B</td>
		<td align="left">商品A</td>
		<td align="right">500</td>
		<td align="right">5</td>
		<td align="right">2,500</td>
		<td align="right"></td>
	</tr>
	<tr class="Result1">
		<td align="left">商品C</td>
		<td align="right">600</td>
		<td align="right">6</td>
		<td align="right">3,600</td>
		<td align="right"></td>
	</tr>

	<tr class="Result1">
		<td align="left">商品F</td>
		<td align="right">700</td>
		<td align="right">7</td>
		<td align="right">4,900</td>
		<td align="right"></td>
	</tr>
	<tr class="Result1">
		<td align="left">商品G</td>
		<td align="right">800</td>
		<td align="right">8</td>
		<td align="right">6,400</td>
		<td align="right"></td>
	</tr>
	<tr class="Result1">
		<td align="left">商品J</td>
		<td align="right">900</td>
		<td align="right">9</td>
		<td align="right">8,100</td>
		<td align="right"></td>
	</tr>
	<tr class="Result2">
		<td align="left"><b>小計</b></td>
		<td align="left"><b>5種類</b></td>
		<td align="right"><b>3,500</b></td>
		<td align="right"><b>35</b></td>
		<td align="right"><b>25,500</b></td>
		<td align="right"></td>
	</tr>

	<tr class="Result3">
		<td align="left"><b>合計</b></td>
		<td align="left"><b>10社</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b></b></td>
		<td align="right"><b>4,500</b></td>
		<td align="right"><b>45</b></td>
		<td align="right"><b>28,500</b></td>
		<td align="right"><b></b></td>
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

	
