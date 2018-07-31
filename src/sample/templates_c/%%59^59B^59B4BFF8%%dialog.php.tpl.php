<?php /* Smarty version 2.6.9, created on 2006-01-26 09:48:30
         compiled from dialog.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../image/back_pink.png" onLoad="return Link_Switch('test_dialog.php',450,200)">
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
<col width="100">
<col width="225">
<col width="100">
<col width="225">
	<tr>
		<td class="Title_Pink" width="100"><b>受注番号</b></td>
		<td class="Value" colspan="3">
			<?php echo $this->_tpl_vars['form']['f_text_auto']['html']; ?>

		</td>
	</tr>

	<tr>
		<td class="Title_Pink" width="100"><b>受注日<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_date_a1']['html']; ?>
</td>
		<td class="Title_Pink" width="100"><b>希望納期</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_date_a2']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Pink"><b><a href="javascript:Sub_Window_Open('customer.php')">得意先</a><font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_customer']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('direct.php')">直送先</a></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_direct']['html']; ?>
</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('warehouse.php')">出荷倉庫</a><font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_warehouse']['html']; ?>
</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('forwarding.php')">運送業者<br>(グリーン指定)</a></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_forwarding']['html']; ?>
　</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('dealing.php')">取引区分</a><font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_dealing']['html']; ?>
</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b><a href="javascript:Sub_Window_Open('charge.php')">担当者</a><font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_charge']['html']; ?>
　</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b>通信欄<br>（得意先宛）</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_textarea']['html']; ?>
</td>
	</tr>
	
	<tr>
		<td class="Title_Pink" width="100"><b>通信欄<br>（本部宛）</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_textarea']['html']; ?>
</td>
	</tr>
</table>
<br>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table class="List_Table" border="1" width="100%">
	<tr class="Result1" align="center">
		<td class="Title_Pink" width=""><b>NO</b></td>
		<td class="Title_Pink" width=""><b>商品コード<font color="#ff0000">※</font><br>商品名<font color="#ff0000">※</font></b></td>
		<td class="Title_Pink" width=""><b>受注数<font color="#ff0000">※</font></b></td>
		<td class="Title_Pink" width="90"><b>単位</b></td>
		<td class="Title_Pink" width=""><b>原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></b></td>
		<td class="Title_Pink" width=""><b>原価金額<font color="#ff0000">※</font><br>売上金額<font color="#ff0000">※</font></b></td>
		<td class="Title_Pink" width=""><b><?php echo $this->_tpl_vars['form']['allcheck19']['html']; ?>
</b></td>
		<td class="Title_Pink" width=""><b>行（<a href="#" title="入力欄を一行追加します。">追加</a>）</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods1']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods1.php','goods1')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_goods1']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left">個</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c2']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c3']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c4']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['check19']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>
	
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods2']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods1.php','goods2')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_goods2']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left">個</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c5']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c6']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c7']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c8']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['check19']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>
	
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods3']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods1.php','goods3')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_goods3']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left">個</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c9']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c10']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c11']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c12']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['check19']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods4']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods1.php','goods4')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_goods4']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left">個</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c13']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c14']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c15']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_code_c16']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['check19']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue5('削除します。')">削除</a></td>
	</tr>

	<tr class="Result2" align="center">
		<td align="left"><b>合計</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>3,000.00<br>3,750.00</b></td>
		<td></td>
		<td></td>
	</tr>

</table>

<table width="100%">
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
		<td align="right"><?php echo $this->_tpl_vars['form']['button']['order']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['complete']['html']; ?>
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

	
