<?php /* Smarty version 2.6.14, created on 2010-04-05 13:28:43
         compiled from 1-1-218.php.tpl */ ?>
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

<?php if ($_POST['form_search_button'] != "検索フォームを表示" && $_POST['show_button'] != "表　示"): ?>
    <?php echo $this->_tpl_vars['form']['form_search_button']['html']; ?>

<?php else: ?>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">直送先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_cname']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="250">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<?php endif; ?>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件
<table class="List_Table" border="1" width="600">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">直送先コード</td>
        <td class="Title_Purple">直送先名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">請求先</td>
    </tr>

    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="left"><a href="1-1-219.php?direct_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
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
