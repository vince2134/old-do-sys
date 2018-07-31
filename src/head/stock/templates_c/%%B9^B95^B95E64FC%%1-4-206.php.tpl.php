<?php /* Smarty version 2.6.9, created on 2007-01-30 20:23:38
         compiled from 1-4-206.php.tpl */ ?>
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

<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">½ÐÎÏ·Á¼°</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">ÂÐ¾ÝÁÒ¸Ë</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

<span style="font: bold 15px; color: #555555;">
¡ÚÃª²·Æü¡§<?php echo $this->_tpl_vars['var']['invent_day']; ?>
¡¡Ãª²·Ä´ººÈÖ¹æ¡§<?php echo $this->_tpl_vars['var']['invent_no']; ?>
¡¡Á°²óÃª²·Ä´ººÈÖ¹æ¡§<?php if ($this->_tpl_vars['var']['last_no'] != '0000000000'):  echo $this->_tpl_vars['var']['last_no'];  endif; ?>¡Û
</span>
<br><br>

<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['x'] => $this->_tpl_vars['items']):
?>
    <span style="font bold 15px; color: #555555;">¡Ú<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][0][0]; ?>
¡Û</span><br>
    <table class="List_Table" border="1" width="100%">
        <tr align="center" style="font-weight: bold;">
            <td class="Title_Yellow">No.</td>
            <td class="Title_Yellow">£Í¶èÊ¬</td>
            <td class="Title_Yellow">ÉÊÌ¾</td>
            <td class="Title_Yellow">Ãª²·¿ô</td>
            <td class="Title_Yellow">Ãª²·Ã±²Á</td>
            <td class="Title_Yellow">Ãª²·¶â³Û</td>
            <td class="Title_Yellow">Á°²óºß¸Ë¿ô</td>
            <td class="Title_Yellow">Á°²óºß¸Ë¶â³Û</td>
            <td class="Title_Yellow">Á°²óÂÐÈæ¿ô</td>
            <td class="Title_Yellow">Á°²óÂÐÈæ¶â³Û</td>
        </tr>

                <?php $_from = $this->_tpl_vars['row'][$this->_tpl_vars['x']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
        
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][1] == "£Í¶èÊ¬·×"): ?>
                        <tr class="Result2">
                <td align="right">¡¡</td>
                <td align="left" colspan="4"><b><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][1]; ?>
</b></td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2]; ?>
</td>
                <?php endif; ?>
                <td align="left" colspan="3">¡¡</td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</td>
                <?php endif; ?>
            </tr>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][1] == "ÁÒ¸Ë·×"): ?>
                        <tr class="Result3">
                <td align="left" colspan="5"><b><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][1]; ?>
</b></td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2]; ?>
</td>
                <?php endif; ?>
                <td align="left" colspan="3">¡¡</td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</td>
                <?php endif; ?>
            </tr>
        <?php else: ?>
                        <tr class="Result1">
                <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][1]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][2]; ?>
</td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][3]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][4] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][4]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][4]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][5] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][5]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][5]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][6] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][6]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][6]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][7] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][7]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][7]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][8] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][8]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][8]; ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][9] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][9]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['x']][$this->_tpl_vars['j']][9]; ?>
</td>
                <?php endif; ?>
            </tr>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </table>

        </td>
    </tr>
    <tr>
        <td>

    <table align="right">
        <tr>
            <td><?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
</td>
        </tr>
    </table>
    <br><br>
<?php endforeach; endif; unset($_from); ?>

<span style="font: bold 15px; color: #555555;">¡ÚÁ´ÁÒ¸Ë¡Û</span>
<span style="color: blue; font-weight: bold; line-height: 130%;">
    Á´ÁÒ¸Ë¤ÎÃª²·¿ô¤¬0¤Î¾ì¹ç¡¢Ãª²·Ã±²Á¤ÏÉ½¼¨¤µ¤ì¤Þ¤»¤ó¡£
</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">£Í¶èÊ¬</td>
        <td class="Title_Yellow">¾¦ÉÊÌ¾</td>
        <td class="Title_Yellow">Ãª²·¿ô</td>
        <td class="Title_Yellow">Ãª²·Ã±²Á</td>
        <td class="Title_Yellow">Ãª²·¶â³Û</td>
        <td class="Title_Yellow">Á°²óºß¸Ë¿ô</td>
        <td class="Title_Yellow">Á°²óºß¸Ë¶â³Û</td>
        <td class="Title_Yellow">Á°²óÂÐÈæ¿ô</td>
        <td class="Title_Yellow">Á°²óÂÐÈæ¶â³Û</td>
    </tr>
        <?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    
        <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][1] == "£Í¶èÊ¬·×"): ?>
                <tr class="Result2">
            <td align="right">¡¡</td>
            <td align="left" colspan="4"><b><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][1]; ?>
</b></td>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][2] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</td>
            <?php endif; ?>
            <td align="left" colspan="3">¡¡</td>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][3] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php elseif ($this->_tpl_vars['total'][$this->_tpl_vars['j']][1] == "ÁÒ¸Ë·×"): ?>
                <tr class="Result3">
            <td align="left" colspan="5"><b><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][1]; ?>
</b></td>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][2] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</td>
            <?php endif; ?>
            <td align="left" colspan="3">¡¡</td>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][3] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php else: ?>
                <tr class="Result1">
            <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
            <td align="left"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][0]; ?>
</td>
            <td align="left"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][1]; ?>
</td>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][2] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][2]; ?>
</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][3] != null): ?>
                <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][3] < 0): ?>
                    <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</font></td>
                <?php else: ?>
                    <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][3]; ?>
</td>
                <?php endif; ?>
            <?php else: ?>
                <td align="center">-</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][4] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][4]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][4]; ?>
</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][5] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][5]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][5]; ?>
</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][6] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][6]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][6]; ?>
</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][7] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][7]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][7]; ?>
</td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['total'][$this->_tpl_vars['j']][8] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][8]; ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo $this->_tpl_vars['total'][$this->_tpl_vars['j']][8]; ?>
</td>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
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
