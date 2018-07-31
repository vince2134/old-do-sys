<?php /* Smarty version 2.6.9, created on 2007-01-31 19:57:43
         compiled from fukuda07.php.tpl */ ?>
<html>
<head>
<title></title>
</head>

<body style="font-family: Verdana; font-size: 11px;">


<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php echo $this->_tpl_vars['form']['form_quick']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['form_commit']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
<br><br>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['err']['no_random_err_msg'] != null): ?><li><?php echo $this->_tpl_vars['err']['no_random_err_msg']; ?>
<br><?php endif;  if ($this->_tpl_vars['err']['no_select_err_msg'] != null): ?><li><?php echo $this->_tpl_vars['err']['no_select_err_msg']; ?>
<br><?php endif; ?>
</ul>
</span>

<?php echo $this->_tpl_vars['form']['form_src_tpl']['html']; ?>
<br><br>
<?php echo $this->_tpl_vars['html']; ?>

</form>

</body>
</html>