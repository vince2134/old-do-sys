<?php /* Smarty version 2.6.14, created on 2010-03-31 18:33:29
         compiled from 2-6-201.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
		
			<table border=0 >
				<tr>
					<td valign="top">

<table class="List_Table" border="1" width="400">
    <col width="200" style="font-weight: bold;">
    <col width="200" align="center">

    <tr align="center" style="font-weight: bold;">
        <td class="Title_Gray">�ޥ�������</td>
        <td class="Title_Gray">CSV����</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr class="Result3">
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button'][$this->_tpl_vars['key']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>


					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
