<?php /* Smarty version 2.6.14, created on 2010-03-02 14:57:26
         compiled from 2-4-204.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<?php echo $this->_tpl_vars['var']['html_js']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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


<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['var']['price_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['price_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['tstock_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['tstock_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['staff_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['staff_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['cause_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['cause_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['db_unique_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['db_unique_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['unique_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['unique_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['injustice_error_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['injustice_error_mess']; ?>

<?php endif;  if ($this->_tpl_vars['var']['staff_line_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['staff_line_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['staff_select_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['staff_select_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['renew_err_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['renew_err_mess']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['remake_err_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['remake_err_mess']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="400">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">棚卸調査表番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['invent_no']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['expected_day']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['ware_name']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象商品</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['target_goods']; ?>
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

<table class="Data_Table" width="500">
<col width="120" style="font-weight: bold;">
    <tr>
        <td rowspan="2" class="Title_Yellow">棚卸実施者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_set']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_line']['html']; ?>
　　　<?php echo $this->_tpl_vars['form']['form_conf_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td align="right" valign="bottom"><?php if ($this->_tpl_vars['var']['add_flg'] == 'false'):  echo $this->_tpl_vars['form']['form_add_button']['html'];  if ($this->_tpl_vars['form']['f_page1']['html'] != null): ?>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['form']['f_page1']['html'];  endif;  else:  echo $this->_tpl_vars['form']['form_input_button']['html'];  endif; ?></td>

    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" height="30" style="font-weight: bold;">
        <td class="Title_Yellow" width="25">No.</td>
        <td class="Title_Yellow" width="150" nowrap>商品分類</td>
        <td class="Title_Yellow" width="380">商品コード<br>商品名</td>
        <td class="Title_Yellow" width="50" nowrap>単位</td>
        <td class="Title_Yellow" width="100">在庫単価<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="75">帳簿数<br>実柵数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="75">差異</td>
        <td class="Title_Yellow" width="160">棚卸実施者<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="105">差異原因</td>
<?php if ($this->_tpl_vars['var']['target_goods'] != "在庫数0" && $this->_tpl_vars['var']['add_flg'] == 'true'): ?>
        <td class="Title_Yellow" width="45" nowrap>行<br>(<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true')">追加</a>)
</td>
<?php endif; ?>
    </tr>


<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
<tr class="Result1">

<td align="right"><?php echo $this->_tpl_vars['item']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_g_product_name'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['html'];  if ($this->_tpl_vars['var']['add_flg'] == 'true'): ?>(<?php echo $this->_tpl_vars['form']['form_search'][$this->_tpl_vars['i']]['html']; ?>
)<?php endif; ?><br>
<?php echo $this->_tpl_vars['form']['form_goods_name'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_unit'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_price'][$this->_tpl_vars['i']]['i']['html']; ?>
.<?php echo $this->_tpl_vars['form']['form_price'][$this->_tpl_vars['i']]['d']['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_stock_num'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_tstock_num'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_diff_num'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_staff'][$this->_tpl_vars['i']]['html']; ?>
</td>

<td><?php echo $this->_tpl_vars['form']['form_cause'][$this->_tpl_vars['i']]['html']; ?>
</td>

<?php if ($this->_tpl_vars['var']['add_flg'] == 'true'): ?>
<td align="center"><?php echo $this->_tpl_vars['form']['add_row_del'][$this->_tpl_vars['i']]['html']; ?>
</td>
<?php endif; ?>

</tr>
<?php endforeach; endif; unset($_from); ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">
        
        <?php if ($this->_tpl_vars['var']['renew_err_mess'] == null && $this->_tpl_vars['var']['remake_err_mess'] == null):  if ($this->_tpl_vars['var']['add_flg'] == 'false'):  echo $this->_tpl_vars['form']['form_entry_back']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_entry_next']['html']; ?>
　　<?php endif;  if ($this->_tpl_vars['form']['form_entry_add_button']['html']):  echo $this->_tpl_vars['form']['form_entry_add_button']['html']; ?>
　　<?php endif;  echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　　<?php endif;  echo $this->_tpl_vars['form']['form_back_button']['html']; ?>

        </td>
    </tr>
</table>

<table width="100%">
    <tr><td align="right" valign="middle"><?php if ($this->_tpl_vars['var']['add_flg'] == 'false'):  echo $this->_tpl_vars['form']['form_add_button']['html'];  if ($this->_tpl_vars['form']['f_page2']['html']): ?>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['form']['f_page2']['html'];  endif;  else:  echo $this->_tpl_vars['form']['form_input_button']['html'];  endif; ?></td></tr>
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
