<?php /* Smarty version 2.6.14, created on 2010-04-05 16:40:12
         compiled from 2-1-229.php.tpl */ ?>
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



<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="400">
<col width="80" style="font-weight: bold;">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">構成品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">構成品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="2">構成内容</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_parts_goods_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_parts_goods_name']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2">

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['search_num']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" rowspan="2">構成品コード</td>
        <td class="Title_Purple" rowspan="2">構成品名</td>
        <td class="Title_Purple" colspan="3">構成内容</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">構成数</td>
    </tr>
    <?php $_from = $this->_tpl_vars['show_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><a href="2-1-230.php?goods_id=<?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][0]; ?>
"><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][1]; ?>
</a></td>
        <td align="left"><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][5]; ?>
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
