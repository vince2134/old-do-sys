<?php /* Smarty version 2.6.14, created on 2010-03-02 14:13:30
         compiled from 2-0-210-1.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- ����ɽ��1���� --------------------->
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width='450'>
	<tr>
		<td align='left'>
			<?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>

		</td>
	</tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->
<!--
					</td>
				</tr>
				<tr>
					<td>
-->
<br>
<br>
<!---------------------- ����ɽ��2���� --------------------->
<?php echo $this->_tpl_vars['var']['html_page']; ?>


<table class="List_Table" border="1" width="500">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>���ʥ�����<br>����̾</b></td>
		<td class="Title_Purple" width=""><b>ά��</b></td>
		<td class="Title_Purple" width=""><b>���ʶ�ʬ</b></td>
		<td class="Title_Purple" width=""><b>�Ͷ�ʬ</b></td>
		<td class="Title_Purple" width=""><b>°����ʬ</b></td>
	</tr>

	<!--1����-->
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
		<td align="left"><?php echo $this->_tpl_vars['item']; ?>
<br>
        <?php elseif ($this->_tpl_vars['j'] == 1): ?>
        <?php echo $this->_tpl_vars['item']; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['j'] == 2): ?>
		<td align="left"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 3): ?>
		<td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 4): ?>
		<td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 5): ?>
		<td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
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

