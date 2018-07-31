<?php /* Smarty version 2.6.14, created on 2007-06-29 10:15:01
         compiled from 2-6-202.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0 >
				<tr>
					<td valign="top">

<table  class="List_Table" border="1" width="400" >
	<colgroup>
		<col width="200">
		<col width="200">
	</colgroup>

	<tr>
		<td class="Title_Gray" align="center"><b>実績データ一覧</b></td>
		<td class="Title_Gray" align="center"><b>CSV出力</b></td>
	</tr>
	
	<tr class="Result3">
		<td ><b>売上推移</b></td>
		<td class="Value" align="center"></td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　得意先別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf23']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　サービス別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf24']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　商品別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf25']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　担当者別/商品別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf26']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　地区別/得意先別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf27']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　業種別/得意先別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf29']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td ><b>ABC分析</b></td>
		<td class="Value" align="center"></td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　得意先別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf31']['html']; ?>
</td>
	</tr>

    <tr class="Result3">
        <td bgcolor="#EBEBEB"><b>　　　商品別</b></td>
        <td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf28']['html']; ?>
</td>
    </tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　担当者別/商品別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf32']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td ><b>仕入推移</b></td>
		<td class="Value" align="center"></td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　仕入先別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf34']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td bgcolor="#EBEBEB"><b>　　　仕入先別/商品別</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf35']['html']; ?>
</td>
	</tr>

	<tr class="Result3">
		<td ><b>営契約業成績</b></td>
		<td class="Value" align="center"><?php echo $this->_tpl_vars['form']['button']['csvf36']['html']; ?>
</td>
	</tr>

</table>
					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
