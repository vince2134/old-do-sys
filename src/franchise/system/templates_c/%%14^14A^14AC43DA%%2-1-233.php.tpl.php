<?php /* Smarty version 2.6.14, created on 2010-04-05 16:40:05
         compiled from 2-1-233.php.tpl */ ?>
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


<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table>
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">施設コード</td>
        <td class="Title_Purple">施設名</td>
        <td class="Title_Purple">備考</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
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
