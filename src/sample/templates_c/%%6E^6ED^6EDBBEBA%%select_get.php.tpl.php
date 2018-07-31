<?php /* Smarty version 2.6.9, created on 2006-08-11 19:09:06
         compiled from select_get.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<font size="+1">セレクトボックスの値を取得する関数</font>
<table  class="Data_Table" border="1" width="450" >
	<tr>
		<td class="Title_Purple" width="100"><b>セレクトボックス</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['select_table']['html']; ?>
</td>
	</tr>
</table>


<select>
    <option style=color:red;><font color="red">aaa</font></option>
</select>
<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
