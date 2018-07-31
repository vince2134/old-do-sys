<?php /* Smarty version 2.6.9, created on 2006-03-06 10:09:27
         compiled from meta_test.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>
 
</script>

<body background="../../../image/back_purple.png">
 <form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<font size="+0.5" color="#555555"><b>【行追加・行削除】</b></font>
<input type="button" value="初期状態" onClick='javascript:location.href = "./watanabe_add_row.php"'>
<br><br>

<table class="List_Table" align="center" border="1" width="500">
	<tr align="center">
		<td class="Title_Purple" width="100"><b>NO</b></td>
		<td class="Title_Purple" width="300"><b>商品名</b></td>
		<td class="Title_Purple" width="100"><b>行(<a href="javascript:Button_Submit_1('add_row_flg', '#', 'true')">追加</a>)</b></td>
	</tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
