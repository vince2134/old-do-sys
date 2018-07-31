<?php /* Smarty version 2.6.14, created on 2011-05-19 15:30:00
         compiled from 2-2-303.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['errors'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
		<li><?php echo $this->_tpl_vars['errors']; ?>
</li><BR>
		<?php endforeach; endif; unset($_from); ?>
	</span>
<?php endif; ?>
 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

                    </td>
                </tr>


                <tr>
                    <td>


                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_footer']; ?>
