<?php /* Smarty version 2.6.9, created on 2006-04-14 20:11:47
         compiled from bg.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table  class="Data_Table" border="1" width="450" >
	<tr>
		<td class="Value">入力箇所<?php echo $this->_tpl_vars['form']['form_data']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Value">hiddenの値を復元<?php echo $this->_tpl_vars['form']['form_hidden']['html']; ?>
</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>
　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>

		</td>
	</tr>
</table>


<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
