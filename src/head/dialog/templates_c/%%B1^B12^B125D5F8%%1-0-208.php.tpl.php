<?php /* Smarty version 2.6.14, created on 2010-04-27 13:52:10
         compiled from 1-0-208.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_supplier_name.focus()">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%">

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>



<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ȼ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ɽ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sort_type']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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

��<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>��
<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="4">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" align="center">No.</td>
        <td class="Title_Purple">�����襳����</td>
        <td class="Title_Purple">������̾</td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">�ȼ�</td> 
        <td class="Title_Purple">����</td> 
   </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <td><?php echo $this->_tpl_vars['i']+1; ?>
</td>
    <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['return_data'][$this->_tpl_vars['i']]; ?>
);window.close();"><?php echo $this->_tpl_vars['item']; ?>
</a></td>
    <?php elseif ($this->_tpl_vars['j'] == 1): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
    <?php elseif ($this->_tpl_vars['j'] == 2): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
    <?php elseif ($this->_tpl_vars['j'] == 3): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
    <?php elseif ($this->_tpl_vars['j'] == 4): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
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
