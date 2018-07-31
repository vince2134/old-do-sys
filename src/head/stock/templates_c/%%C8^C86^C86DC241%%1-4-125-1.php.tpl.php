<?php /* Smarty version 2.6.9, created on 2006-09-19 13:35:39
         compiled from 1-4-125-1.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="referer" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>

<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0 >
				<tr>
					<td>
<!---------------------- 画面表示1開始 --------------------->
<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Yellow" width="100"><b>申請番号</b></td>
		<td class="Value" ><?php echo $this->_tpl_vars['form']['form_appli_num']['html']; ?>
</td>
		<td class="Title_Yellow" width="100"><b>出荷状況</b></td>
		<td class="Value" ><?php echo $this->_tpl_vars['form']['form_situation']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Yellow" width="100"><b>申請日</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_appli_day']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Yellow" width="100"><b>申請元</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_appli']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Yellow" width="100"><b>備考<br>(自社宛)</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_my_note']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Yellow" width="100"><b>備考<br>(本社宛)</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_head_note']['html']; ?>
</td>
	</tr>

</table>

		<!---------------------- 画面1表示終了 --------------------->
					<br>
					</td>
				</tr>


				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Yellow" width=""><b>No.</b></td>
		<td class="Title_Yellow" width=""><b>商品名</b></td>
		<td class="Title_Yellow" width=""><b>申請数</b></td>
		<td class="Title_Yellow" width=""><b>出荷済数</b></td>
	</tr>

	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">00000001<br>尿石防止剤　エムワイザCP</td>
		<td align="right">100</td>
		<td align="right">0</td>
	</tr>

	<tr class="Result2">
		<td align="right">2</td>
		<td align="left">00000100<br>尿石防止剤　ピピダリア</td>
		<td align="right">150</td>
		<td align="right">0</td>
	</tr>

</table>
<table width="100%">
	<tr>
		<td align="right"><?php echo $this->_tpl_vars['form']['form_return']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_cansel']['html']; ?>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	