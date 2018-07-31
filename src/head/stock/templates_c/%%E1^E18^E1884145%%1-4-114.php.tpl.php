<?php /* Smarty version 2.6.14, created on 2010-01-08 17:12:31
         compiled from 1-4-114.php.tpl */ ?>
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

<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">¼è°·´ü´Ö</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_start']['html'];  if ($_GET['start'] != NULL || $_GET['end'] != NULL): ?> ¡Á <?php endif;  echo $this->_tpl_vars['form']['form_end']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">ÁÒ¸Ë</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">¾¦ÉÊÌ¾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
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

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">ÅÁÉ¼ÈÖ¹æ</td>
        <td class="Title_Yellow">¼è°·Æü</td>
        <td class="Title_Yellow">¼è°·¶èÊ¬</td>
        <td class="Title_Yellow">Æþ¸Ë¿ô</td>
        <td class="Title_Yellow">½Ð¸Ë¿ô</td>
        <td class="Title_Yellow">¼õÊ§Àè</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j']%2 == 0): ?>
        <tr class="Result1">
    <?php else: ?>
                <tr class="Result2">
    <?php endif; ?>
        <td align="right">
        <?php if ($_POST['f_page1'] != null): ?>
            <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['j']+1; ?>

        <?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][3] == '1'): ?>
                        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
            <td align="right"></td>
        <?php else: ?>
                        <td align="right"></td>
            <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == NULL): ?>
            <td>¼«ÁÒ¸Ë</td>
        <?php else: ?>
            <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" align="center">
        <td><b>Áí¹ç·×</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['in_count']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['var']['out_count']; ?>
</td>
        <td></td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['return_btn']['html']; ?>
</td>
    </tr>
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
