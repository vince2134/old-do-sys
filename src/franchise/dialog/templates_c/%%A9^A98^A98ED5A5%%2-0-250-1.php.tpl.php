<?php /* Smarty version 2.6.14, created on 2007-02-16 10:41:41
         compiled from 2-0-250-1.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">


		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- ����ɽ��1���� --------------------->

<table width='450'>
    <tr>
        <td align='left'>
            <?php echo $this->_tpl_vars['form']['form_button']['close_button']['html']; ?>

        </td>
    </tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>
<br>
<!---------------------- ����ɽ��2���� --------------------->
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple"><b>�����襳����<br>������̾</b></td>
		<td class="Title_Purple"><b>�϶�</b></td>
		<td class="Title_Purple" width="80"><b>����</b></td>
	</tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
		<td align="right">
            ��  <?php echo $this->_tpl_vars['j']+1; ?>

        </td>           	
		<td align="left">
			<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br>
			<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
		</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][4] == 1): ?>
        	�����
        <?php else: ?>
        	����ٻ���
        <?php endif; ?>
        </td>
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
</body>
</html>
	
