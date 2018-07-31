<?php /* Smarty version 2.6.9, created on 2006-01-12 13:23:14
         compiled from sub_window.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_blue.png">
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
		<td class="Title_Blue" width="100"><b>支払データ取込</b></td>
		<td class="Value">
			<input type="file" size="40">　　<?php echo $this->_tpl_vars['form']['button']['busy']['html']; ?>

		</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b><a href="javascript:Sub_Window('1-0-201.php','bank','0')">銀行</a></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_bank']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['collective']['html']; ?>

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
	<tr align="center">
		<td class="Title_Blue" width=""><b>NO</b></td>
		<td class="Title_Blue" width=""><b>支払日<font color="#ff0000">※</font></b></td>
		<td class="Title_Blue" width=""><b>取引区分<font color="#ff0000">※</font></b></td>
		<td class="Title_Blue" width=""><b>銀行</b></td>
		<td class="Title_Blue" width="" ><b>仕入先<font color="#ff0000">※</font></b></td>
		<td class="Title_Blue" width=""><b>支払金額<font color="#ff0000">※</font><br>手数料</b></td>
		<td class="Title_Blue" width=""><b>手形期日<br>手形券面番号</b></td>
		<td class="Title_Blue" width=""><b>備考</b></td>
		<td class="Title_Blue" width=""><b>行</b>（<a href="#">追加</a>）</td>
	</tr>
	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_dealing1']['html']; ?>
（<a href="javascript:Sub_Window_Open('dealing1.php','dealing1')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_dealing1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_bank1']['html']; ?>
（<a href="#" onClick="return Open_SubWin('1-0-201.php',Array('f_bank1','n_bank1','t_bank1'),500,500);">検索</a>）<?php echo $this->_tpl_vars['form']['n_bank1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_bank1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_layer1']['html']; ?>
（<a href="javascript:Sub_Window_Open('layer1.php','layer1')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_layer1']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a2']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text20']['html']; ?>
</td>
		<td align="center"><a href="javascript:dialogue('削除します。','#')">削除</a></td>
	</tr>
	
	<tr class="Result2">
		<td align="left"><b>合計</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>401,745<br>0</b></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

</table>

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Yellow" width="" rowspan="2"><b>NO</b></td>
		<td class="Title_Yellow" width="" rowspan="2"><b>商品コード<font color="#ff0000">※</font><br>商品名</b></td>
		<td class="Title_Yellow" width="" colspan="2"><b>移動元</b></td>
		<td class="Title_Yellow" width="" colspan="2"><img src="../../../image/arrow.gif"></td>
		<td class="Title_Yellow" width="" colspan="2"><b>移動先</b></td>
		<td class="Title_Yellow" width="" rowspan="2"><b>行（<a href="#" title="入力欄を一行追加します。">追加</a>）</b></td>
	</tr>

	<tr align="center">
		<td class="Title_Yellow" width=""><b>倉庫名<font color="#ff0000">※</font></b></td>
		<td class="Title_Yellow" width=""><b>在庫数<br>（引当数）</b></td>
		<td class="Title_Yellow" width=""><b>移動数<font color="#ff0000">※</font></b></td>
		<td class="Title_Yellow" width=""><b>単位</b></td>
		<td class="Title_Yellow" width=""><b>倉庫名<font color="#ff0000">※</font></b></td>
		<td class="Title_Yellow" width=""><b>在庫数<br>（引当数）</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods1_c']['html']; ?>
（<a href="#" onClick="return Open_SubWin('1-0-202.php',Array('f_goods1_c','t_goods1_b1','t_goods1_b2','f_text9','t_goods1_h1','t_goods1_b3','t_goods1_b4'),500,500,'1');">検索</a>）<br>商品A</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_warehouse2']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods5.php','goods1')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_warehouse2']['html']; ?>
</td>
		<td align="right"><?php echo $this->_tpl_vars['form']['t_goods1_b1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_goods1_b2']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['t_goods1_h1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_warehouse3']['html']; ?>
（<a href="javascript:Sub_Window_Open('goods5.php','goods1')">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_warehouse3']['html']; ?>
</td>
		<td align="right"><?php echo $this->_tpl_vars['form']['t_goods1_b3']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_goods1_b4']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue('削除します。','#')">削除</a></td>
	</tr>
</table>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Blue" width=""><b>NO</b></td>
		<td class="Title_Blue" width=""><b>商品コード<font color="#ff0000">※</font><br>商品名</b></td>
		<td class="Title_Blue" width=""><b>実棚数<br>(A)</b></td>
		<td class="Title_Blue" width=""><b>発注済数<br>(B)</b></td>
		<td class="Title_Blue" width=""><b>引当数<br>(C)</b></td>
		<td class="Title_Blue" width=""><b>出荷可能数<br>(A+B-C)</b></td>
		<td class="Title_Blue" width=""><b>発注数<font color="#ff0000">※</font></b></td>
		<td class="Title_Blue" width=""><b>仕入単価<font color="#ff0000">※</font></b></td>
		<td class="Title_Blue" width=""><b>仕入金額</b></td>
		<td class="Title_Blue" width=""><b>入荷予定日</b></td>
		<td class="Title_Blue" width=""><b>行（<a href="#">追加</a>）</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods5']['html']; ?>
（<a href="#" onClick="return Open_SubWin('1-0-202.php',Array('f_goods5','t_goods5'),500,500);">検索</a>）<br><?php echo $this->_tpl_vars['form']['t_goods5']['html']; ?>
</td>
		<td align="right"><a href="javascript:WindowOpen('1-3-111.php',300,150,'output2');">80</a></td>
		<td align="right">5</td>
		<td align="right">20</td>
		<td align="right">65</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c1']['html']; ?>
</td>
		<td align="center"></td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a11']['html']; ?>
</td>
		<td align="center"><a href="javascript:dialogue('削除します。','#')">削除</a></td>
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

	
