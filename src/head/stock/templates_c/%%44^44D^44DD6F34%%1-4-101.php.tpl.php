<?php /* Smarty version 2.6.14, created on 2010-01-08 17:12:06
         compiled from 1-4-101.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="left" valign="top">
        <td>
            <table>
                <tr>
                    <td>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['order_err1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['order_err1']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_inquiry_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_inquiry_day']['error']; ?>
<br>
<?php endif; ?>
</span>

<table width="650">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">�Ȳ���</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_inquiry_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�Ͷ�ʬ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
        <td class="Title_Yellow">������ʬ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">����ʬ��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">���ʥ�����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Yellow">����̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">����̾��ά�Ρ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
        <td class="Title_Yellow">°����ʬ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_attri_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�߸˶�ʬ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_stock_div']['html']; ?>
</td>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">���ʥ��롼��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_goods_gr']['html']; ?>
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

<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>

<table width="100%">
    <tr>
        <td>
<?php if ($_POST['form_show_button'] == "ɽ����" || $_POST['form_order_button'] == "ȯ�����Ϥ�" || $_POST['h_ok_button'] != null): ?>

<span style="font: bold 15px; color: #555555;">
�ھȲ���:
<?php if ($this->_tpl_vars['form']['form_order_all_check']['error'] == null && $this->_tpl_vars['form']['form_inquiry_day']['error'] == null && $this->_tpl_vars['var']['day'] != "--"):  echo $this->_tpl_vars['var']['day']; ?>

<?php else: ?>����̵��<?php endif; ?>
�����ʥ��롼��:
<?php if ($this->_tpl_vars['var']['goods_gr_name'] != null):  echo $this->_tpl_vars['var']['goods_gr_name']; ?>

<?php else: ?>����̵��<?php endif; ?>
��
</span>
<br>

<table width="1050">
    <tr>
        <td>
��<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>��
        </td>
        <td width="900" colspan="2" align="right">
            <font color="#0000FF"><b>�������å����դ������ʤ�ȯ���뤳�Ȥ���ǽ�Ǥ���</b></font>
        </td>
    </tr>
        <td colspan="2">
<table class="List_Table" border="1" width="900">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">���ʥ�����</td>
        <td class="Title_Yellow">�Ͷ�ʬ</td>
        <td class="Title_Yellow">������ʬ</td>
        <td class="Title_Yellow">����ʬ��</td>
        <td class="Title_Yellow">����̾</td>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Title_Yellow">�߸˿�</td>
        <td class="Title_Yellow">�߸�ñ��</td>
        <td class="Title_Yellow">�߸˶��</td>
        <td class="Title_Yellow">�ǽ��谷��</td>
        <td class="Title_Yellow">��ʧ�Ȳ�</td>
		<td class="Title_Yellow"><br></td>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_order_all_check']['html']; ?>
</td>
    </tr>
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
    <?php if (!(1 & $this->_tpl_vars['i'])): ?>
    <tr height="23" class="Result1">
    <?php else: ?>
    <tr height="23" class="Result2">
    <?php endif; ?>
        <td align="right">
        <?php if ($_POST['f_page1'] != null): ?>
           <?php echo $_POST['f_page1']*10+$this->_tpl_vars['i']-9; ?>

        <?php else: ?>
           <?php echo $this->_tpl_vars['i']+1; ?>

        <?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][4]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][8]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <td align="center"><a href="./1-4-105.php?ware_id=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][10]; ?>
&goods_id=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][11]; ?>
">��ʧ</a></td>
		<td><br></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_order_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" height="23">
        <td>���</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['num_total']; ?>
</td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['money_total']; ?>
</td>
        <td></td>
        <td></td>
		<td><br></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_order_button']['html']; ?>
</td>
    </tr>
</table>
        </td>
    </tr>
</table>

<?php endif; ?>

        </td>
    </tr>
</table>

<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
