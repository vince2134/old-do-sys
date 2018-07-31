<?php /* Smarty version 2.6.14, created on 2010-04-05 15:59:29
         compiled from 1-1-234.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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

			<table border="0">
				<tr>
					<td>


<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!---------------------- 画面表示1開始 --------------------->
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['message'] != null && $this->_tpl_vars['form']['form_bstruct_cd']['error'] == null && $this->_tpl_vars['form']['form_bstruct_name']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['var']['message']; ?>
<br><br>
    <?php endif; ?>
    </span>
          <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_bstruct_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_bstruct_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_bstruct_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_bstruct_name']['error']; ?>
<br>
    <?php endif; ?>
    </span> 

<table class="Data_Table" border="1" width="450">

	<tr>
		<td class="Title_Purple" width="100"><b>業態コード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_cd']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>業態名<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_name']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>備考</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_note']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>承認</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
	</tr>
</table>
<table width='450'>
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>

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

<table>
	<tr>
		<td width="50%" align="left">全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
	</tr>
</table>


<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>業態コード</b></td>
		<td class="Title_Purple" width=""><b>業態名</b></td>
		<td class="Title_Purple" width=""><b>備考</b></td>
		<td class="Title_Purple" width=""><b>承認</b></td>
	</tr>

    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<tr class="Result1">
		<td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
		<td align="left"><a href="?bstruct_id=<?php echo $this->_tpl_vars['item'][1]; ?>
"><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
		<td align="left"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <?php if ($this->_tpl_vars['item'][4] == '1'): ?>
		    <td align="center">○</td>
        <?php else: ?>
            <td align="center"><font color="red">×</font></td>
        <?php endif; ?>
	</tr>
    <?php endforeach; endif; unset($_from); ?>
	
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

	
