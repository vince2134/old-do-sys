<?php /* Smarty version 2.6.14, created on 2010-02-25 17:12:47
         compiled from 1-4-116.php.tpl */ ?>
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

<span style="color: <?php echo $this->_tpl_vars['var']['mesg_color']; ?>
; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['mesg'] != null): ?>
<li><?php echo $this->_tpl_vars['var']['mesg']; ?>
<br>
<?php endif; ?>
</span>

<?php if ($this->_tpl_vars['var']['del_button_flg'] == false): ?>
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1"width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">組立管理番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['build_cd']; ?>
</td>
        <td class="Title_Yellow">組立日</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['build_day']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">完成品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['goods_cd']; ?>
</td>
        <td class="Title_Yellow">完成品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['goods_name']; ?>
</td>
    </tr>
        <td class="Title_Yellow">組立数</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['build_goods_data'][0]['build_num']; ?>
</td>
    <tr>
        <td class="Title_Yellow">引落倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['output_ware_name']; ?>
</td>
        <td class="Title_Yellow">入庫倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['build_goods_data'][0]['input_ware_name']; ?>
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
<table width="550">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
</span>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">構成数</td>
        <td class="Title_Yellow">使用数</td>
    </tr>
    <?php $_from = $this->_tpl_vars['parts_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['parts_goods_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['parts_goods_data'][$this->_tpl_vars['i']]['goods_cd']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['parts_goods_data'][$this->_tpl_vars['i']]['goods_name']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['parts_goods_data'][$this->_tpl_vars['i']]['parts_num']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['parts_goods_data'][$this->_tpl_vars['i']]['num']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<table width="100%">
    <tr>
        <?php if ($_GET['new_flg'] == 'true'): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_ok_button']['html']; ?>
</td>
        <?php else: ?>
        <td align="right"><?php if ($this->_tpl_vars['var']['del_button_flg'] == false):  echo $this->_tpl_vars['form']['form_del_button']['html']; ?>
　　<?php endif;  echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
</td>
        <?php endif; ?>
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
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
