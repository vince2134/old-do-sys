<?php /* Smarty version 2.6.9, created on 2006-09-19 17:21:27
         compiled from 1-1-123.php.tpl */ ?>
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

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>����å�̾</b></td>
        <td class="Value">����˥ƥ�����</td>
        <td class="Title_Purple" width="80"><b>�����ʬ</b></td>
        <td class="Value">�����</td>
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

<span style="font: bold 15px; color: #555555;">�������</span>��<?php echo $this->_tpl_vars['form']['form_btn_add_keiyaku']['html']; ?>
<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�в���</td>
        <td class="Title_Purple">ô����</td>
        <td class="Title_Purple">ľ����</td>
        <td class="Title_Purple">�����ȼ�</td>
        <td class="Title_Purple">�в��Ҹ�</td>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">����ñ��<br>���ñ��</td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">������<br>����</td>
        <td class="Title_Purple">����</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 $_from = $this->_tpl_vars['item'][7]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['goods']):
        $this->_foreach['count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['item'][1]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
" align="center"><a href="1-1-104.php?contract_id=<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</a></td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][5]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][6]; ?>
</td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['goods'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][2]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][3][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][3][1]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][4][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][4][1]; ?>
</td>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
" align="right"><?php echo $this->_tpl_vars['item'][8][0]; ?>
<br><?php echo $this->_tpl_vars['item'][8][1]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][9]; ?>
</td>
        <?php endif; ?>
    </tr>
<?php endforeach; endif; unset($_from);  endforeach; endif; unset($_from); ?>
</table>
<br>

<span style="font: bold 15px; color: #555555;">��󥿥����</span>��<?php echo $this->_tpl_vars['form']['form_btn_add_rental']['html']; ?>
<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">��󥿥볫����</td>
        <td class="Title_Purple">������̾</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">��<br>����</td>
        <td class="Title_Purple">��󥿥뿽����</td>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        <td class="Title_Purple">���ꥢ��</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">��󥿥���</td>
        <td class="Title_Purple">��󥿥���</td>
        <td class="Title_Purple">����</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 $_from = $this->_tpl_vars['item'][9]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['goods']):
        $this->_foreach['count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['item'][1]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
" align="center"><a href="1-1-141.php?rental_id=<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</a></td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php if ("{".($this->_tpl_vars['item'][5]) != null): ?>��<?php endif;  echo $this->_tpl_vars['item'][5]; ?>
<br><?php echo $this->_tpl_vars['item'][6]; ?>
<br><?php echo $this->_tpl_vars['item'][7]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['goods'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <td><?php if ($this->_tpl_vars['goods'][2] != null):  $_from = $this->_tpl_vars['goods'][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['serial']):
 echo $this->_tpl_vars['serial']; ?>
<br><?php endforeach; endif; unset($_from);  endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][5]; ?>
</td>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['item'][10]; ?>
</td>
        <?php endif; ?>
    </tr>
<?php endforeach; endif; unset($_from);  endforeach; endif; unset($_from); ?>
</table>
<br>

<span style="font: bold 15px; color: #555555;">���������</span>��<?php echo $this->_tpl_vars['form']['form_btn_add_hoken']['html']; ?>
<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">�Ϳ�</td>
        <td class="Title_Purple">ñ��</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">����</td>
    </tr>
    <?php $_from = $this->_tpl_vars['disp_data3'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['insurance']):
        $this->_foreach['count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['insurance'][1]; ?>
">
        <td align="center"><a href="./1-1-131.php?insurance_id=<?php echo $this->_tpl_vars['insurance'][0]; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['insurance'][2]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['insurance'][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['insurance'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['insurance'][5]; ?>
</td>
        <?php if ($this->_tpl_vars['i'] == 0): ?>
        <td class="Result1" rowspan="<?php echo $this->_foreach['count']['total']; ?>
" align="right"><?php echo $this->_tpl_vars['disp_data3'][1]; ?>
</td>
        <td class="Result1" rowspan="<?php echo $this->_foreach['count']['total']; ?>
"><?php echo $this->_tpl_vars['disp_data3'][2]; ?>
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
