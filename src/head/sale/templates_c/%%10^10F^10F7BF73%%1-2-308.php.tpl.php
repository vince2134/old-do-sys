<?php /* Smarty version 2.6.14, created on 2009-12-28 16:14:19
         compiled from 1-2-308.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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



                    </td>
                </tr>
                <tr>
                    <td>

<table width="350" align="center">
    <tr>
        <td>
        <table align="center">
            <tr>
                <td><b><font color="blue"><li>作成しました。</font></b><br><br></td>
            </tr>
            <?php if ($this->_tpl_vars['var']['warning'] == true): ?>
            <tr>
                <td><b><font color="red"><?php echo $this->_tpl_vars['var']['warning']; ?>
</font></b><br><br></td>
            </tr>
            <?php endif; ?>
            <?php $_from = ($this->_tpl_vars['err_msg']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
            <tr>
                <td><b><font color="red"><li><?php echo $this->_tpl_vars['err_msg'][$this->_tpl_vars['i']]; ?>
</font></b></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <?php $_from = ($this->_tpl_vars['err_msg2']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
            <tr>
                <td><b><font color="red"><li><?php echo $this->_tpl_vars['err_msg2'][$this->_tpl_vars['j']]; ?>
</font></b></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <?php $_from = ($this->_tpl_vars['err_msg3']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
            <tr>    
                <td><b><font color="red"><li><?php echo $this->_tpl_vars['err_msg3'][$this->_tpl_vars['i']]; ?>
</font></b></td>
            </tr>   
            <?php endforeach; endif; unset($_from); ?>
            <?php $_from = ($this->_tpl_vars['err_msg4']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
            <tr>    
                <td><b><font color="red"><li><?php echo $this->_tpl_vars['err_msg4'][$this->_tpl_vars['i']]; ?>
</font></b></td>
            </tr>   
            <?php endforeach; endif; unset($_from); ?>
        </table>
        </td>
    </tr>
</table>

<table width="100" align="center">
    <tr>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_ok_button']['html']; ?>
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
