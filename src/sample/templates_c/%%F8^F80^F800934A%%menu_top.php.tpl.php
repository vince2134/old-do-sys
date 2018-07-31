<?php /* Smarty version 2.6.9, created on 2006-04-18 15:44:20
         compiled from menu_top.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
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

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->

<table  class="Data_Table" border="1" width="450" >
<col width="100">

	<tr>
		<td class="Title_Yellow"><b>調査表番号</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Yellow"><b>棚卸実施日</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_date_b1']['html']; ?>
</td>
	</tr>

	<?php if ($_SESSION['shop_div'] == '1'): ?>
		<tr>
			<td class="Title_Yellow" width="100"><b>事業所</b></td>
			<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_cshop']['html']; ?>
</td>
		</tr>
	<?php endif; ?>

</table>
<table width='450'>
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
<?php echo $this->_tpl_vars['var']['html_page']; ?>



<table class="List_Table" border="1" width="100%">
<?php if ($_SESSION['shop_div'] == '1'): ?>
	<tr align="center">
		<td class="Title_Yellow" width="" ><b>No.</b></td>
		<td class="Title_Yellow" width=""><b>事業所</b></td>
		<td class="Title_Yellow" width=""><b>棚卸実施日</b></td>
		<td class="Title_Yellow" width=""><b>調査表番号</b></td>
		<td class="Title_Yellow" width=""><b>棚卸一覧表</b></td>
		<td class="Title_Yellow" width=""><b>棚卸差異明細一覧表</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">事業所A</td>
		<td align="center">2005-08-31</td>
		<td align="left">00100019</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left"></td>
		<td align="center">2005-07-31</td>
		<td align="left">00100018</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left"></td>
		<td align="center">2005-06-30</td>
		<td align="left">00100017</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left"></td>
		<td align="center">2005-05-31</td>
		<td align="left">00100016</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left"></td>
		<td align="center">2005-04-30</td>
		<td align="left">00100015</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--6行目-->
	<tr class="Result1">
		<td align="right">6</td>
		<td align="left"></td>
		<td align="center">2005-03-31</td>
		<td align="left">00100014</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--7行目-->
	<tr class="Result1">
		<td align="right">7</td>
		<td align="left"></td>
		<td align="center">2005-02-28</td>
		<td align="left">00100013</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--8行目-->
	<tr class="Result1">
		<td align="right">8</td>
		<td align="left"></td>
		<td align="center">2005-01-31</td>
		<td align="left">00100012</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--9行目-->
	<tr class="Result1">
		<td align="right">9</td>
		<td align="left"></td>
		<td align="center">2004-12-31</td>
		<td align="left">00100011</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--10行目-->
	<tr class="Result1">
		<td align="right">10</td>
		<td align="left"></td>
		<td align="center">2004-11-30</td>
		<td align="left">00100010</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
<?php else: ?>
	<tr align="center">
		<td class="Title_Yellow" width="" ><b>No.</b></td>
		<td class="Title_Yellow" width=""><b>棚卸実施日</b></td>
		<td class="Title_Yellow" width=""><b>調査表番号</b></td>
		<td class="Title_Yellow" width=""><b>棚卸一覧表</b></td>
		<td class="Title_Yellow" width=""><b>棚卸差異明細一覧表</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="center">2005-08-31</td>
		<td align="left">00100019</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="center">2005-07-31</td>
		<td align="left">00100018</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="center">2005-06-30</td>
		<td align="left">00100017</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="center">2005-05-31</td>
		<td align="left">00100016</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="center">2005-04-30</td>
		<td align="left">00100015</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--6行目-->
	<tr class="Result1">
		<td align="right">6</td>
		<td align="center">2005-03-31</td>
		<td align="left">00100014</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--7行目-->
	<tr class="Result1">
		<td align="right">7</td>
		<td align="center">2005-02-28</td>
		<td align="left">00100013</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--8行目-->
	<tr class="Result1">
		<td align="right">8</td>
		<td align="center">2005-01-31</td>
		<td align="left">00100012</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--9行目-->
	<tr class="Result1">
		<td align="right">9</td>
		<td align="center">2004-12-31</td>
		<td align="left">00100011</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
	<!--10行目-->
	<tr class="Result1">
		<td align="right">10</td>
		<td align="center">2004-11-30</td>
		<td align="left">00100010</a></td>
		<td align="center"><a href="1-4-206.php">表示</a></td>
		<td align="center"><a href="1-4-208.php">表示</a></td>
	</tr>
<?php endif; ?>
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

	
