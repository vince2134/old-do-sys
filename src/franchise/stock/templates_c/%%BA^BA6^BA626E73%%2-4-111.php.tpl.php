<?php /* Smarty version 2.6.14, created on 2010-04-26 18:55:15
         compiled from 2-4-111.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_handling_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_handling_day']['error']; ?>
<br><?php endif; ?>
</span>

<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">取扱期間<b><font color="#ff0000">※</font></b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_handling_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
        <?php if ($_SESSION['shop_div'] == '1'): ?>
    <tr>
        <td class="Title_Yellow">事業所</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_shop']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
    <tr>
        <td class="Title_Yellow">調整理由</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_reason']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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

<?php if ($this->_tpl_vars['var']['show_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>

<span style="font: bold 14px; color: #555555;">【取扱期間：
<?php if ($this->_tpl_vars['form']['form_handling_day']['error'] == null && ( $this->_tpl_vars['var']['hand_start'] != NULL || $this->_tpl_vars['var']['hand_end'] != NULL )): ?>
    <?php echo $this->_tpl_vars['var']['hand_start']; ?>
 〜 <?php echo $this->_tpl_vars['var']['hand_end']; ?>

<?php else: ?>
    指定無し
<?php endif; ?>
<?php if ($_SESSION['shop_div'] == '1'): ?>
　事業所：<?php echo $this->_tpl_vars['var']['cshop_name']; ?>

<?php endif; ?>
】</span>
<br>
全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件<br>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">日付</td>
        <td class="Title_Yellow">商品コード<br>商品名</td>
        <td class="Title_Yellow">調整数</td>
        <td class="Title_Yellow">調整額</td>
        <td class="Title_Yellow">調整理由</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['item'][0]; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
<br><?php echo $this->_tpl_vars['item'][5]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['item'][6] == 'minus'): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['item'][7]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['item'][6] == 'minus'): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][9]; ?>
</td>
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
</table>

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
