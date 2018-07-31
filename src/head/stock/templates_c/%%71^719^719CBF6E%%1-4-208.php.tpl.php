<?php /* Smarty version 2.6.14, created on 2010-05-13 19:39:19
         compiled from 1-4-208.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border="0" width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="left" valign="top">
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

 
<?php if ($this->_tpl_vars['var']['err_mess'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['err_mess']; ?>
</li>
    </span><br>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow" width="100"><b>½ÐÎÏ·Á¼°</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
    <?php if ($_GET['ware_id'] == null): ?>
    <tr>
        <td class="Title_Yellow"><b>ÂÐ¾ÝÁÒ¸Ë</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

<span style="font: bold 15px; color: #555555;">
¡ÚÃª²·Æü¡§<?php echo $this->_tpl_vars['var']['invent_day']; ?>
¡¡Ãª²·Ä´ººÈÖ¹æ¡§<?php echo $this->_tpl_vars['var']['invent_no']; ?>
¡¡Á°²óÃª²·Ä´ººÈÖ¹æ¡§<?php if ($this->_tpl_vars['var']['last_no'] != '0000000000'):  echo $this->_tpl_vars['var']['last_no'];  else: ?>¤Ê¤·<?php endif; ?>¡Û
</span>
<br>
<br>
<br>
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
<span style="font: bold 15px; color: #555555;">
<?php if ($this->_tpl_vars['i'] < $this->_tpl_vars['var']['ware_list_num']): ?>
    ¡Ú<?php echo $this->_tpl_vars['ary_ware_list_name'][$this->_tpl_vars['i']]; ?>
¡Û
<?php elseif ($this->_tpl_vars['i'] == $this->_tpl_vars['var']['ware_list_num']): ?>
    ¡ÚÁ´ÁÒ¸Ë¡Û
<span style="color: #0000ff; font-size: 12px; font-weight: bold; line-height: 130%;">
    ¼ÂÃª¿ô¤¬0¤Î¾ì¹ç¡¢Ãª²·Ã±²Á¤ÏÉ½¼¨¤µ¤ì¤Þ¤»¤ó
</span>
<?php endif; ?>
</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">¾¦ÉÊÊ¬ÎàÌ¾</td>
        <td class="Title_Yellow">¾¦ÉÊÌ¾</td>
        <td class="Title_Yellow">Ä¢Êí¿ô</td>
        <td class="Title_Yellow">¼ÂÃª¿ô</td>
        <td class="Title_Yellow">Ãª²·<br>º¹°Û¿ô</td>
        <td class="Title_Yellow">Ãª²·Ã±²Á</td>
        <td class="Title_Yellow">Ãª²·¶â³Û</td>
        <td class="Title_Yellow">Á°²ó<br>ºß¸Ë¿ô</td>
        <td class="Title_Yellow">Á°²ó<br>ºß¸Ë¶â³Û</td>
        <td class="Title_Yellow">Á°²ó<br>ÂÐÈæ¿ô</td>
                <?php if ($this->_tpl_vars['i'] < $this->_tpl_vars['var']['ware_list_num']): ?>
        <td class="Title_Yellow">Ãª²·¼Â»Ü¼Ô</td>
                <td class="Title_Yellow">º¹°Û¸¶°ø</td>
        <?php endif; ?>
    </tr>

    <?php $_from = $this->_tpl_vars['page_data'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ware'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ware']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
        $this->_foreach['ware']['iteration']++;
?>
    <?php if (!(1 & $this->_tpl_vars['j'])): ?>
    <tr class="Result1">
    <?php else: ?>
    <tr class="Result2">
    <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][2] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][2]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][3] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][4] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][4]; ?>
</td>
        <?php if ($this->_tpl_vars['i'] == $this->_tpl_vars['var']['ware_list_num'] && $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][3] == '0'): ?>
        <td align="center">-</td>
        <?php else: ?>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][5] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][5]; ?>
</td>
        <?php endif; ?>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][6] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][6]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][8]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][9] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][9]; ?>
</td>
        <?php if ($this->_tpl_vars['i'] < $this->_tpl_vars['var']['ware_list_num']): ?>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][10]; ?>
</td>
                        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][12]; ?>
</td>
        <?php endif; ?>
    </tr>

        <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][90] == true): ?>
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="2"><b>¾¦ÉÊÊ¬Îà·×</b></td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][0] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][0]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][1] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][2] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][2]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][3] < 0): ?> style="color: #ff0000;"<?php endif; ?>></td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][4] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][5] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][6] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][6]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['g_product_total'][$this->_tpl_vars['i']][$this->_tpl_vars['j']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['i'] < $this->_tpl_vars['var']['ware_list_num']): ?>
        <td></td>
                <td></td>
        <?php endif; ?>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

        <tr class="Result4">
        <td colspan="3"><b>ÁÒ¸Ë·×</b></td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][0] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][0]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][1] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][2] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][3] < 0): ?> style="color: #ff0000;"<?php endif; ?>></td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][4] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][4]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][5] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][5]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][6] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][6]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][7] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['ware_total'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['i'] < $this->_tpl_vars['var']['ware_list_num']): ?>
        <td></td>
                <td></td>
        <?php endif; ?>
    </tr>
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
