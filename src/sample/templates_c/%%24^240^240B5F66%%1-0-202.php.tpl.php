<?php /* Smarty version 2.6.9, created on 2006-01-12 17:18:24
         compiled from 1-0-202.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="left">

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- 画面表示1開始 --------------------->

<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Purple" width="100"><b>商品コード</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>商品名</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text30']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>略称</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text10']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>属性区分</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text10']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>製品区分</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text4']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>Ｍ区分</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_text10']['html']; ?>
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
<br>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->
<?php echo $this->_tpl_vars['var']['html_page']; ?>


<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Purple" width=""><b>NO</b></td>
		<td class="Title_Purple" width=""><b>商品コード</b></td>
		<td class="Title_Purple" width=""><b>商品名</b></td>
		<td class="Title_Purple" width=""><b>略称</b></td>
		<td class="Title_Purple" width=""><b>属性区分</b></td>
		<td class="Title_Purple" width=""><b>製品区分</b></td>
		<td class="Title_Purple" width=""><b>Ｍ区分</b></td>
	</tr>

	<!--1行目-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['var']['row0']; ?>
);window.close();">00000001</a></td>
		<td align="left">商品1</td>
		<td align="left">略称1</td>
		<td align="center">製品</td>
		<td align="center">リピート商品</td>
		<td align="left">Ｍ区分1</td>
	</tr>
	
	<!--2行目-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left"><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['var']['row1']; ?>
);window.close();">00000002</a></td>
		<td align="left">商品2</td>
		<td align="left">略称2</td>
		<td align="center">製品</td>
		<td align="center">リピート商品</td>
		<td align="left">Ｍ区分2</td>
	</tr>
	
	<!--3行目-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left"><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['var']['row2']; ?>
);window.close();">00000003</a></td>
		<td align="left">商品3</td>
		<td align="left">略称3</td>
		<td align="center">製品</td>
		<td align="center">リピート商品</td>
		<td align="left">Ｍ区分3</td>
	</tr>

	<!--4行目-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left"><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['var']['row3']; ?>
);window.close();">00000004</a></td>
		<td align="left">商品4</td>
		<td align="left">略称4</td>
		<td align="center">製品</td>
		<td align="center">リピート商品</td>
		<td align="left">Ｍ区分4</td>
	</tr>

	<!--5行目-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left"><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['var']['row4']; ?>
);window.close();">00000005</a></td>
		<td align="left">商品5</td>
		<td align="left">略称5</td>
		<td align="center">製品</td>
		<td align="center">リピート商品</td>
		<td align="left">Ｍ区分5</td>
	</tr>

</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>

<table width='100%'>
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['button']['close']['html']; ?>

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

	
