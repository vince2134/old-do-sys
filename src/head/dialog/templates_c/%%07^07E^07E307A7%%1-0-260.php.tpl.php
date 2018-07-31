<?php /* Smarty version 2.6.14, created on 2009-12-21 11:20:03
         compiled from 1-0-260.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_direct_name.focus()">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%">

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>



<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
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
    <tr>
        <td class="Title_Purple">表示順</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_turn']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_button']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_button']['close_button']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">直送先コード</td>
        <td class="Title_Purple">直送先名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">請求先</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
            <?php echo $this->_tpl_vars['j']+1; ?>

        </td>
        <td align="left">
            <a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['return_data'][$this->_tpl_vars['j']]; ?>
); window.close();"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][0]; ?>
</a>
        </td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][3]; ?>
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
