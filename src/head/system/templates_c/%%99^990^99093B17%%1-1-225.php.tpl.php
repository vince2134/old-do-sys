<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:38
         compiled from 1-1-225.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


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



    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['comp_msg'] != null && $this->_tpl_vars['form']['form_trans_cd']['error'] == null && $this->_tpl_vars['form']['form_trans_name']['error'] == null && $this->_tpl_vars['form']['form_trans_cname']['error'] == null && $this->_tpl_vars['form']['form_post']['error'] == null && $this->_tpl_vars['form']['form_address1']['error'] == null && $this->_tpl_vars['form']['form_tel']['error'] == null && $this->_tpl_vars['form']['form_fax']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br>
    <?php endif; ?>
    </span> 
         <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_trans_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_address1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_address1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_fax']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_fax']['error']; ?>
<br>
    <?php endif; ?>
    </span> 
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col width="*">

	<tr>
		<td class="Title_Purple">運送業者コード<font color="#ff0000">※</font></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_cd']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">運送業者名<font color="#ff0000">※</font></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_name']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">略称<font color="#ff0000">※</font></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_cname']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_auto_input_button']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所2</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所3</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">TEL</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">FAX</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">グリーン指定業者</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_green_trans']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple">備考</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_note']['html']; ?>
</td>
	</tr>

</table>
<table width="450">
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

					</td>
				</tr>

				<tr>
					<td>

<table>
	<tr>
		<td width="50%" align="left">全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
	</tr>
</table>

<table class="List_Table" border="1" width="650">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">運送業者コード</td>
		<td class="Title_Purple">運送業者名</td>
		<td class="Title_Purple">略称</td>
		<td class="Title_Purple">グリーン指定業者</td>
		<td class="Title_Purple">備考</td>
	</tr>

<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<tr class="Result1">
		<td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item'][0]; ?>
</a></td>
		<td align="left"><a href="?trans_id=<?php echo $this->_tpl_vars['item'][1]; ?>
"><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
		<td align="left"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item'][5]; ?>
</a></td>
	</tr>
<?php endforeach; endif; unset($_from); ?>

</table>


					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
