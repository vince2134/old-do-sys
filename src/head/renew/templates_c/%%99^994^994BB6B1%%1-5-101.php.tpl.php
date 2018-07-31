<?php /* Smarty version 2.6.14, created on 2009-12-29 14:55:18
         compiled from 1-5-101.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

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

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">日次更新日</td>
        <td class="Title_Green">作業実施日時</td>
        <td class="Title_Green">更新者</td>
    </tr>
    <?php $_from = $this->_tpl_vars['rec_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

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
