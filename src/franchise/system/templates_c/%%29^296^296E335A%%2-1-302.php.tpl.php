<?php /* Smarty version 2.6.14, created on 2010-04-05 16:02:35
         compiled from 2-1-302.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['password']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['password_conf']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['password_conf']['error']; ?>
<br><?php endif; ?>
<!-- 現在のパスワード比較 -->
<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
<?php endif; ?>

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="140"><b>現在のパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_now']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font><br>(確認用)</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['password_conf']['html']; ?>
</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align="left">
            <font color="#ff0000"><b>※は必須入力です</b></font>
        </td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>

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
