<?php /* Smarty version 2.6.14, created on 2010-01-15 21:19:59
         compiled from 1-1-222.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script>
<?php echo $this->_tpl_vars['var']['js']; ?>

</script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<?php echo $this->_tpl_vars['var']['page_header']; ?>
		</td>
	</tr>

	<tr align="center">
	


				<td valign="top">

			<table>
				<tr>
					<td>


<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table border="0" width="100%">
<tr>
	<font size="+0.5" color="#555555"><b>【商品名】： <?php echo $this->_tpl_vars['var']['goods_name']; ?>
 </b></font>
</tr>
<tr>
	<font size="+0.5" color="#555555"><b>【略　記】： <?php echo $this->_tpl_vars['var']['goods_cname']; ?>
 </b></font>
</tr>
<tr>
    <td>
    <?php if ($this->_tpl_vars['var']['warning'] != null): ?>
    <font color="blue"><b><?php echo $this->_tpl_vars['var']['warning']; ?>

    </b></font>
    <?php endif; ?>
    </td>
</tr>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['item']; ?>
<br>
<?php endforeach; endif; unset($_from); ?>
</span>


</table>

<table class="Data_Table" border="1" width="610">
<col width="130" style="font-weight: bold;">
<col width="130">
<col width="130">
<col width="100">
<col width="150">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple" rowspan="2">単価項目</td>
		<td class="Title_Purple" rowspan="2">現在単価</td>
		<td class="Title_Purple" colspan="2">改訂単価</td>
		<td class="Title_Purple" rowspan="2">改訂日</td>
	</tr>

	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">指定</td>
		<td class="Title_Purple">標準価格の％</td>
	</tr>

        <?php $_from = $this->_tpl_vars['form']['form_price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['price'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['price']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['price']['iteration']++;
?>
    <?php if ($this->_tpl_vars['i'] > 0 && $this->_tpl_vars['i'] != 2 && $this->_tpl_vars['i'] != 3): ?>
        <?php if ($this->_tpl_vars['i'] == 1): ?>
        <tr class="Result2">
        <?php else: ?>
        <tr class="Result1">
        <?php endif; ?>
            <td class="Title_Purple" align="left"><?php echo $this->_tpl_vars['form']['form_price'][$this->_tpl_vars['i']]['label'];  if ($this->_tpl_vars['required_flg'][$this->_tpl_vars['i']] == true): ?><font color="#ff0000">※</font><?php endif; ?></td>
            <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][$this->_tpl_vars['i']]['html']; ?>
</a></td>
            <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][$this->_tpl_vars['i']]['html']; ?>
</td>
            <td align="center">
            <?php if ($this->_tpl_vars['i'] > 1):  echo $this->_tpl_vars['form']['form_cost_rate'][$this->_tpl_vars['i']]['html']; ?>
 %<?php endif; ?></td>
            <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][$this->_tpl_vars['i']]['html']; ?>
</td>
        </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?> 
     
    <tr class="Result2">
        <td class="Title_Purple" align="left"><?php echo $this->_tpl_vars['form']['form_price'][0]['label'];  if ($this->_tpl_vars['required_flg'][0] == true): ?><font color="#ff0000">※</font><?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][0]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][0]['html']; ?>
</td>
        <td align="center"></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][0]['html']; ?>
</td>
    </tr>
        <tr class="Result2">
        <td class="Title_Purple" align="left"><?php echo $this->_tpl_vars['form']['form_price'][3]['label'];  if ($this->_tpl_vars['required_flg'][3] == true): ?><font color="#ff0000">※</font><?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][3]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][3]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cost_rate'][3]['html']; ?>
 %</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][3]['html']; ?>
</td>
        <tr class="Result2">
        <td class="Title_Purple" align="left"><?php echo $this->_tpl_vars['form']['form_price'][2]['label'];  if ($this->_tpl_vars['required_flg'][2] == true): ?><font color="#ff0000">※</font><?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][2]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][2]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cost_rate'][2]['html']; ?>
 %</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][2]['html']; ?>
</td>
    </tr>
</table>

<table width="610">
	<tr>
        <?php if ($this->_tpl_vars['var']['new_flg'] == true): ?>
        <td align="left">
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        <?php endif; ?>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>

		</td>
	</tr>
</table>
<br>

					</td>
				</tr>

				<tr>
					<td>


<font size="+0.5" color="#555555"><b>【改訂履歴】</b></font>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="610">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">改訂日</td>
		<td class="Title_Purple">単価項目</td>
		<td class="Title_Purple">改訂前単価</td>
		<td class="Title_Purple">改訂後単価</td>
		<td class="Title_Purple">単価改定者</td>
	</tr>
    <?php $_from = $this->_tpl_vars['show_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
	<tr class="Result1">
                <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
                <?php if ($this->_tpl_vars['j'] == 0): ?>
		<td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
                <?php elseif ($this->_tpl_vars['j'] == 1): ?>
		<td align="left"><?php echo $this->_tpl_vars['item']; ?>
</td>
                <?php elseif ($this->_tpl_vars['j'] > 1): ?>
		<td align="left"><?php echo $this->_tpl_vars['item']; ?>
</td>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	
</table>

<?php echo $this->_tpl_vars['var']['html_page2']; ?>


					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
