<?php /* Smarty version 2.6.9, created on 2006-09-01 18:02:41
         compiled from 1-0-250-1.php.tpl */ ?>
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

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>



<table>
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_button']['close_button']['html']; ?>
</td>
    </tr>
</table>
<br>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先コード<br>得意先名</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">状態</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
            　  <?php echo $this->_tpl_vars['j']+1; ?>

        </td>               
        <td>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][4] == 1): ?>
            取引中
        <?php else: ?>
            取引休止中
        <?php endif; ?>
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

</body>
</html>