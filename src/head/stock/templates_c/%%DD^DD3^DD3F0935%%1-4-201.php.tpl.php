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

    <!-- ���顼ɽ�� -->
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <!-- ê���� -->
    <?php if ($this->_tpl_vars['form']['form_create_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_create_day']['error']; ?>
<br>
    <?php endif; ?>   
    </span> 


<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
        <tr>    
            <td class="Title_Yellow">ê����<font color="#ff0000">��</font></td> 
            <td class="Value" width="300"><?php echo $this->_tpl_vars['form']['form_create_day']['html']; ?>
</td>
        </tr>   


    <tr>
        <td class="Title_Yellow">�оݾ���</td>
        <td class="Value" width="300"><?php echo $this->_tpl_vars['form']['form_target_goods']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['create_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
    </tr>
</table>

<!-- ê���ǡ�����0�ξ��Υ��顼ɽ�� -->
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

<span style="font: bold 15px; color: #555555;">�ڸ���Ĵ�����ê���ۡ�<?php echo $this->_tpl_vars['form']['form_delete_button']['html']; ?>
</span><br>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Yellow" width="60"><b>ê����</b></td>
        <td class="Value" align="center"><?php echo $this->_tpl_vars['data1'][0]; ?>
</td>
        <td class="Title_Yellow" width="120"><b>ê��Ĵ��ɽ�ֹ�</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['data1'][1]; ?>
</td>
        <td class="Title_Yellow" width="80"><b>�оݾ���</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['data1'][2]; ?>
</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">�Ҹ�</td>
        <td class="Title_Yellow" colspan="2">ê��Ĵ��ɽ</td>
        <td class="Title_Yellow" rowspan="2">ê������</td>
        <td class="Title_Yellow" rowspan="2">ê������ɽ</td>
        <td class="Title_Yellow" rowspan="2">�����Ͽ</td>
    </tr>
    <tr align="center">
        <td class="Title_Yellow"><b>Ģɼ����</b>��<a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-202.php?invent_no=<?php echo $this->_tpl_vars['data1'][1]; ?>
" target="_blank">���Ҹ�</a>��</td>
        <td class="Title_Yellow"><b>CSV����</b>��<a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-201.php?invent_no=<?php echo $this->_tpl_vars['var']['invent_no']; ?>
&ware_id=all">���Ҹ�</a>��</td>
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
" target="_blank">Ģɼ����</a></td>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-201.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">CSV����</a></td>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-204.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">����</a></td>
        <?php if ($this->_tpl_vars['data2'][$this->_tpl_vars['i']][3] == 't' && $this->_tpl_vars['data2'][$this->_tpl_vars['i']][4] == 'f'): ?>
        <td align="center"><a href="<?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>1<?php else: ?>2<?php endif; ?>-4-208.php?invent_no=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][0]; ?>
&ware_id=<?php echo $this->_tpl_vars['data2'][$this->_tpl_vars['i']][1]; ?>
">ɽ��</a></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['data2'][$this->_tpl_vars['i']][4] == 't'): ?>
        <td align="center">�����Ͽ</a></td>
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
