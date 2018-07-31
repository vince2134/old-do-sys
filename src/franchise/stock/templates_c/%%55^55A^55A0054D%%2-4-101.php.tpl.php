<?php /* Smarty version 2.6.14, created on 2010-01-08 16:37:38
         compiled from 2-4-101.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['order_err1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['order_err1']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['order_err2']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['order_err2']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_inquiry_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_inquiry_day']['error']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
<col width="110" style="font-weight: bold;">
<col width="200">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">照会日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_inquiry_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象商品</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_target_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
        <td class="Title_Yellow">管理区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品分類</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品名(略称)</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">拠点倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
        <td class="Title_Yellow">個人倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_ware']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">属性区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_attri_div']['html']; ?>
</td>
        <td class="Title_Yellow">在庫区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_stock_div']['html']; ?>
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

<table width="100%">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>

<?php if ($_POST['form_show_button'] == "表　示" || $_POST['order_button_flg'] == 'true'): ?>
<span style="font: bold 16px; color: #555555;">
【照会日:
<?php if ($this->_tpl_vars['form']['form_order_all_check']['error'] == null && $this->_tpl_vars['form']['form_inquiry_day']['error'] == null && $this->_tpl_vars['var']['inquiry_day'] != '--'):  echo $this->_tpl_vars['var']['inquiry_day']; ?>
】
<?php else: ?>
指定無し】
<?php endif; ?>
</span><br>


<table width="1050"> 
    <tr>
        <td>
            全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
        </td>
        <td width="900" colspan="2" align="right">
            <font color="#0000FF"><b>※チェックを付けた商品は発注することが可能です。</b></font>
        </td>
    </tr>
    <tr>
        <td colspan="2">
<table class="List_Table" border="1" width="900">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード</td>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Title_Yellow">管理区分</td>
        <td class="Title_Yellow">商品分類</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">在庫数</td>
        <td class="Title_Yellow">在庫単価</td>
        <td class="Title_Yellow">在庫金額</td>
        <td class="Title_Yellow">最終取扱日</td>
        <td class="Title_Yellow">受払照会</td>
		<td class="Title_Yellow"><br></td>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_order_all_check']['html']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if (!(1 & $this->_tpl_vars['i'])): ?>
    <tr class="Result1" height="23">
    <?php else: ?>
    <tr class="Result2" height="23">
    <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][13]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][10]; ?>
</td>
        <td align="center">
        <a href="./2-4-105.php?ware_id=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][11]; ?>
&goods_id=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][12]; ?>
">受払</a>
        </td>
		<td><br></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_order_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>       
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" height="23">
        <td>合計</td>
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
<?php endif; ?>

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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
