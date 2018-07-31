<?php /* Smarty version 2.6.14, created on 2010-02-24 17:40:47
         compiled from 1-0-302.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_supplier_name.focus();">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%">

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>



<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">仕入先コード1</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_cd']['html']; ?>
-<?php echo $this->_tpl_vars['form']['form_supplier_cd2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">仕入先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">業種</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示順</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sort_type']['html']; ?>
</td>
    </tr>
</table>

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

全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">仕入先コード</td>
        <td class="Title_Purple">仕入先名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">業種</td>
        <td class="Title_Purple">状態</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
<?php if ($this->_tpl_vars['var']['group_kind']['value'] == 2): ?>
        <td><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['return_data'][$this->_tpl_vars['i']]; ?>
);window.close();"><?php echo $this->_tpl_vars['items'][0];  if ($this->_tpl_vars['items'][1] != ' '): ?>-<?php echo $this->_tpl_vars['items'][1]; ?>
 
        <?php endif; ?>
      </a> </td> <td><?php echo $this->_tpl_vars['items'][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['items'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['items'][4]; ?>
</td>
        <td><?php echo $this->_tpl_vars['items'][7]; ?>
</td>
<?php else: ?>
        <td><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['return_data'][$this->_tpl_vars['i']]; ?>
);window.close();"><?php echo $this->_tpl_vars['items'][0]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['items'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['items'][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['items'][3]; ?>
</td>
<?php endif; ?>

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
