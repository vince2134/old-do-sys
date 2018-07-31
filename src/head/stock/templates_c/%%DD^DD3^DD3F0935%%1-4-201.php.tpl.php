<?php /* Smarty version 2.6.14, created on 2010-04-05 15:54:18
         compiled from 1-4-201.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border="0" width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['err_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['err_mess']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td>

<?php if ($this->_tpl_vars['disp'] == 'u'): ?>

    <!-- ¥¨¥é¡¼É½¼¨ -->
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <!-- Ãª²·Æü -->
    <?php if ($this->_tpl_vars['form']['form_create_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_create_day']['error']; ?>
<br>
    <?php endif; ?>   
    </span> 


<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
        <tr>    
            <td class="Title_Yellow">Ãª²·Æü<font color="#ff0000">¢¨</font></td> 
            <td class="Value" width="300"><?php echo $this->_tpl_vars['form']['form_create_day']['html']; ?>
</td>
        </tr>   


    <tr>
        <td class="Title_Yellow">ÂÐ¾Ý¾¦ÉÊ</td>
        <td class="Value" width="300"><?php echo $this->_tpl_vars['form']['form_target_goods']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['create_button']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
    </tr>
</table>

<!-- Ãª²·¥Ç¡¼¥¿¤¬0¤Î¾ì¹ç¤Î¥¨¥é¡¼É½¼¨ -->
<?php if ($this->_tpl_vars['data2'] != null): ?>
<br><br><br>
<table width="100%">
    <tr>
        <td><span style="color: #0000ff; font-weight: bold; line-height: 130%;"><?php echo $this->_tpl_vars['data2'][0]; ?>
</span></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
<?php endif; ?>


<?php elseif ($this->_tpl_vars['disp'] == 'l'): ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">¡Ú¸½ºßÄ´ººÃæ¤ÎÃª²·¡Û¡¡<?php echo $this->_tpl_vars['form']['form_delete_button']['html']; ?>
</span><br>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Yellow" width="60"><b>Ãª²·Æü</b></td>
        <td class="Value" align="center"><?php echo $this->_tpl_vars['data1'][0]; ?>
</td>
        <td class="Title_Yellow" width="120"><b>Ãª²·Ä´ººÉ½ÈÖ¹æ</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['data1'][1]; ?>
</td>
        <td class="Title_Yellow" width="80"><b>ÂÐ¾Ý¾¦ÉÊ</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['data1'][2]; ?>
</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">ÁÒ¸Ë</td>
        <td class="Title_Yellow" colspan="2">Ãª²·Ä´ººÉ½</td>
        <td class="Title_Yellow" rowspan="2">Ãª²·ÆþÎÏ</td>
        <td class="Title_Yellow" rowspan="2">Ãª²·°ìÍ÷É½</td>
        <td class="Title_Yellow" rowspan="2">°ì»þÅÐÏ¿</td>
    </tr>
    <tr align="center">
        <td class="Title_Yellow"><b>Ä¢É¼°õºþ</b>¡Ê<a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-202.php?invent_no=<?php echo $this->_tpl_vars['data1'][1]; ?>
" target="_blank">Á´ÁÒ¸Ë</a>¡Ë</td>
        <td class="Title_Yellow"><b>CSV½ÐÎÏ</b>¡Ê<a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-201.php?invent_no=<?php echo $this->_tpl_vars['var']['invent_no']; ?>
&ware_id=all">Á´ÁÒ¸Ë</a>¡Ë</td>
    </tr>
    <?php $_from = $this->_tpl_vars['data2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['data2'][$this->_tpl_vars['i']][4] == 't'): ?>
    <tr class="Result5">
    <?php else: ?>
    <tr class="Result1">
    <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-202.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
" target="_blank">Ä¢É¼°õºþ</a></td>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-201.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">CSV½ÐÎÏ</a></td>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-204.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">ÆþÎÏ</a></td>
        <?php if ($this->_tpl_vars['data2'][$this->_tpl_vars['i']][3] == 't' && $this->_tpl_vars['data2'][$this->_tpl_vars['i']][4] == 'f'): ?>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-208.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">É½¼¨</a></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['data2'][$this->_tpl_vars['i']][4] == 't'): ?>
        <td align="center">°ì»þÅÐÏ¿</a></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<?php endif; ?>

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
