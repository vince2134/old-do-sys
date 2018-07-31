<?php /* Smarty version 2.6.14, created on 2010-04-05 16:08:41
         compiled from 1-1-224.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>
 
</script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
			 <?php echo $this->_tpl_vars['var']['page_header']; ?>
 		</td>
	</tr>

	<tr align="center">
	

				<td valign="top">

			<table>
				<tr>
					<td>


<table width="450">
    <tr>
        <td align="right">
            <?php if ($_GET['goods_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td> 
   </tr>
</table>
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_make_goods']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_make_goods']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['goods_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['goods_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['numerator_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['numerator_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['numerator_numeric_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['numerator_numeric_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['denominator_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['denominator_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['denominator_numeric_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['denominator_numeric_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['used_goods_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['used_goods_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['used_make_goods_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['used_make_goods_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['make_goods_flg_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['make_goods_flg_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['goods_input_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['goods_input_err']; ?>
<br>
    <?php endif; ?>
    </span>
<table class="Data_Table" border="1" width="450">

	<tr>
		<td class="Title_Purple" width="110"><b><?php echo $this->_tpl_vars['form']['form_goods_link']['html']; ?>
<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_make_goods']['html']; ?>
</td>
	</tr>

</table>
<table width="450">
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
	</tr>
</table>

<br>

					</td>
				</tr>

				<tr>
					<td>

<font size="+0.5" color="#555555"><b>【部品内容】</b></font>
<table class="List_Table" border="1" width="650">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">商品コード</td>
		<td class="Title_Purple">商品名</td>
		<td class="Title_Purple">数量（分子/分母）</td>
    <?php if ($this->_tpl_vars['var']['freeze_flg'] != true): ?>
		<td class="Title_Purple"><b>行(<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true')">追加</a>)</b></td>
    <?php endif; ?>
	</tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


</table>
<table width="650">
	<tr>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>

		</td>
	</tr>
</table>

					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
