<?php /* Smarty version 2.6.14, created on 2010-04-05 15:59:29
         compiled from 1-1-234.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">

			<table border="0">
				<tr>
					<td>


<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!---------------------- ����ɽ��1���� --------------------->
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
		<td class="Title_Purple" width="100"><b>���֥�����<font color="#ff0000">��</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_cd']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>����̾<font color="#ff0000">��</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_name']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>����</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct_note']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>��ǧ</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
	</tr>
</table>
<table width='450'>
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>

		</td>
	</tr>
</table>
<br>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->

<table>
	<tr>
		<td width="50%" align="left">��<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>�<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
	</tr>
</table>


<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>���֥�����</b></td>
		<td class="Title_Purple" width=""><b>����̾</b></td>
		<td class="Title_Purple" width=""><b>����</b></td>
		<td class="Title_Purple" width=""><b>��ǧ</b></td>
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
		    <td align="center">��</td>
        <?php else: ?>
            <td align="center"><font color="red">��</font></td>
        <?php endif; ?>
	</tr>
    <?php endforeach; endif; unset($_from); ?>
	
</table>


<!--******************** ����ɽ��2��λ *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
