<?php /* Smarty version 2.6.14, created on 2010-04-05 16:39:54
         compiled from 2-1-231.php.tpl */ ?>
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



 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>
<table>
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>

<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" colspan="3">大分類業種</td>
        <td class="Title_Purple" colspan="3">小分類業種</td>
    </tr>   
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
    </tr>   
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class=<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
>
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][5]; ?>
</a></td>
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
