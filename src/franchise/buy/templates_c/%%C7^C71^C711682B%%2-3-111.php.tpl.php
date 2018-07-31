<?php /* Smarty version 2.6.14, created on 2011-06-19 17:23:03
         compiled from 2-3-111.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-3-111.php.tpl', 28, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">


<table>
    <tr>
        <td>

<table>
	<tr>
		<td>商品名：<?php echo $this->_tpl_vars['var']['goods_name']; ?>
</td>
	</tr>
</table>

<table class="List_Table" border="1" width="100%">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Blue">倉庫名</td>
		<td class="Title_Blue">在庫数</td>
		<td class="Title_Blue">引当数</td>
	</tr>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<tr class="Result1">
		<td align="left"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
		<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][1])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
		<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][2])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
	<tr class="Result1">
		<td align="left"><?php echo $this->_tpl_vars['sum'][0]; ?>
</td>
		<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['sum'][1])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
		<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['sum'][2])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
	</tr>
</table>

<table align="center">
	<tr>
		<td><?php echo $this->_tpl_vars['form']['button']['close']['html']; ?>
</td>
	</tr>
</table>

        </td>
    </tr>
</table>
