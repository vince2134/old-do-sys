<?php /* Smarty version 2.6.9, created on 2006-09-01 17:16:16
         compiled from 2-0-216.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%">

        <tr>
        <td valign="top">
            <table  width="100%">
                <tr>
                    <td>



<table>
    <tr>
        <td>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['form']['close_button']['html']; ?>
</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ショップコード<br>ショップ名</td>
        <td class="Title_Purple">担当者<br>コード</td>
        <td class="Title_Purple">スタッフコード<br>スタッフ名</td>
        <td class="Title_Purple">所属部署</td>
        <td class="Title_Purple">役職</td>
        <td class="Title_Purple">職種</td>
        <td class="Title_Purple">在職識別</td>
        <td class="Title_Purple">トイレ診断士資格</td>
        <td class="Title_Purple">取得資格</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</a><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</a><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][11]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
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
