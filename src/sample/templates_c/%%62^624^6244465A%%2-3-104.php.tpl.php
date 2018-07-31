<?php /* Smarty version 2.6.9, created on 2006-02-14 09:41:53
         compiled from 2-3-104.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_blue.png">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%">

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
		
			<table border="0" width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
<table width='450'>
	<tr>
		<td align='left'>
			<?php echo $this->_tpl_vars['form']['button']['order_rest_f']['html']; ?>
 
		</td>
	</tr>
</table>
<br>
<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Blue" width="100"><b>発注番号</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>発注日</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_date_b1']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>入荷予定日</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_date_b2']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Blue"width="100"><b>仕入先コード</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text6']['html']; ?>
</td>
		<td class="Title_Blue"width="100"><b>仕入先名</b></td>
		<td class="Value" width="250"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>発注者</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_select26']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b>日次更新</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_radio11']['html']; ?>
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

<?php echo $this->_tpl_vars['var']['html_page']; ?>


<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Blue" width=""><b>NO</b></td>
		<td class="Title_Blue" width=""><b>発注日時</b></td>
		<td class="Title_Blue" width=""><b>発注番号</b></td>
		<td class="Title_Blue" width=""><b>仕入先</b></td>
		<td class="Title_Blue" width=""><b>本部確認</b></td>
		<td class="Title_Blue" width=""><b>発注金額</b></td>
		<td class="Title_Blue" width=""><b>発注書発行</b></td>
		<td class="Title_Blue" width=""><b>入荷予定日<br>入力</b></td>
		<td class="Title_Blue" width=""><b>日次更新</b></td>
		<td class="Title_Blue" width=""><b>強制完了</b></td>
		<td class="Title_Blue" width=""><b>削除</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="center">2005-04-20<br>14:23</td>
		<td align="left"><a href="2-3-102.php">00005071</a></td>
		<td align="left">本部</td>
		<td align="center">済</td>
		<td align="right">3,980</td>
		<td align="center">----</td>
		<td align="center" class="">----</td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center">----</td>
	</tr>

	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="center">2005-04-21<br>15:23</td>
		<td align="left"><a href="2-3-102.php">00005072</a></td>
		<td align="left">本部</td>
		<td align="center">済</td>
		<td align="right">3,980</td>
		<td align="center">----</td>
		<td align="center" class=""><a href="2-3-102.php">2005-04-22</a></td>
		<td align="center"></td>
		<td align="center">○</td>
		<td align="center">----</td>
	</tr>

	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="center">2005-04-22<br>2:11</td>
		<td align="left"><a href="2-3-102-3.php">00005073</a></td>
		<td align="left">本部</td>
		<td align="center">済</td>
		<td align="right">3,980</td>
		<td align="center"><a href="2-3-105.php">発行済</a></td>
		<td align="center" class=""><a href="2-3-102.php">2005-04-22</a></td>
		<td align="center">○</td>
		<td align="center"></td>
		<td align="center">----</td>
	</tr>

	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="center">2005-04-23<br>12:45</td>
		<td align="left"><a href="2-3-102.php">00005074</a></td>
		<td align="left">本部</td>
		<td align="center"><font ="red">取消</font></td>
		<td align="right">3,980</td>
		<td align="center">----</td>
		<td align="center">----</td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="center">2005-04-24<br>14:23</td>
		<td align="left"><a href="2-3-102-3.php">00005075</a></td>
		<td align="left">仕入先4</td>
		<td align="center">----</td>
		<td align="right">3,980</td>
		<td align="center">----</td>
		<td align="center">----</td>
		<td align="center">○</td>
		<td align="center"></td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
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

	
