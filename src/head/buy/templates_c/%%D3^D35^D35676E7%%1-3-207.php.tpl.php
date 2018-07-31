<?php /* Smarty version 2.6.14, created on 2009-12-06 13:05:47
         compiled from 1-3-207.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script>
<?php echo $this->_tpl_vars['var']['js']; ?>

</script>
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

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    <?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_designated_date']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_designated_date']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_arrival_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_arrival_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_buy_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_buy_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_ware']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ware']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_buy_staff']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_buy_staff']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_buy_no']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_buy_no']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_direct']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_direct']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['duplicate_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['duplicate_msg']; ?>
<br>
    <?php endif; ?>
    <?php $_from = $this->_tpl_vars['goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['goods_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['goods_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['price_num_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['price_num_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['price_num_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['num_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['num_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['num_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['price_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['price_err'][$this->_tpl_vars['i']] != null): ?>
        <li><?php echo $this->_tpl_vars['price_err'][$this->_tpl_vars['i']]; ?>
<br>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['duplicate_goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <li><?php echo $this->_tpl_vars['duplicate_goods_err'][$this->_tpl_vars['i']]; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['ord_num_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <li><?php echo $this->_tpl_vars['ord_num_err'][$this->_tpl_vars['i']]; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
    </span>
<?php if ($this->_tpl_vars['var']['freeze_flg'] != null): ?>
    <?php if ($this->_tpl_vars['var']['goods_twice'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['var']['goods_twice']; ?>
<br>
    </span>
    <?php endif; ?>
    <span style="font: bold;"><font size="+1">以下の内容で仕入ますか？</font></span><br>
<?php endif; ?>


<table>
    <tr>
        <td>


<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">伝票番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_no']['html']; ?>
</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
        <td class="Title_Blue">発注番号</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
</td>
    </tr>
    <tr>
		<td class="Title_Blue" width="100"><b>発注日</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_order_day']['html']; ?>
</td>
        <td class="Title_Blue"><b>入荷日<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
		<td class="Title_Blue"><b>取引区分<font color="red">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
    </tr>
    <tr>
		<td class="Title_Blue" width="100"><b>入荷予定日</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_hope_day']['html']; ?>
</td>
        <td class="Title_Blue">仕入日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_day']['html']; ?>
</td>
        <td class="Title_Blue">仕入倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">直送先</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_direct']['html']; ?>
</td>
		<td class="Title_Blue" ><b>発注担当者</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_order_staff']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">備考</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
		<td class="Title_Blue" ><b>仕入担当者<font color="red">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_staff']['html']; ?>
</td>
    </tr>
</table>
        </td>   
    </tr>   
    <tr>    
        <td>    
<?php if ($_POST['form_buy_button'] == null): ?>
<font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font>
<?php endif; ?>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="250">
    <tr align="center">
        <td width="90" class="Title_Blue"><b>買掛残高</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['var']['ap_balance']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Blue">現在庫数</td>
        <td class="Title_Blue">発注残</td>
        <td class="Title_Blue">ロット仕入</td>
        <td class="Title_Blue">ロット入数</td>
        <td class="Title_Blue">仕入数<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入単価<font color="#ff0000">※</font></td>
        <td class="Title_Blue">仕入金額</td>
    <?php if ($this->_tpl_vars['var']['show_del_subject_flg'] == true): ?>
        <td class="Title_Add" width="50">行削除</td>
    <?php endif; ?>
    </tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

</table>
            </td>
        </tr>
        <tr>
            <td>
<table width="100%">
    <tr>    
        <?php if ($this->_tpl_vars['var']['select_flg'] == true): ?>
            <td><?php echo $this->_tpl_vars['form']['form_add_row_button']['html']; ?>
</td>
        <td>    
            <table class="List_Table" border="1" align="right">
                <tr>    
                    <td class="Title_Blue" width="80" align="center"><b>税抜金額</b></td> 
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_buy_money']['html']; ?>
</td>
                    <td class="Title_Blue" width="80" align="center"><b>消費税</b></td> 
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_tax_money']['html']; ?>
</td>
                    <td class="Title_Blue" width="80" align="center"><b>税込合計</b></td> 
                    <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['form']['form_total_money']['html']; ?>
</td>
                </tr>   
            </table>
        </td>   
        <td><?php echo $this->_tpl_vars['form']['form_sum_button']['html']; ?>
</td>
        <?php endif; ?>   
    </tr>   
</table>

            </td>
        </tr>
        <tr>
            <td>

<A NAME="foot"></A>
<table width="100%">
    <tr>    
        <td><?php if ($_POST['form_buy_button'] == null): ?><font color="#ff0000"><b>※は必須入力です</b></font><?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_buy_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_comp_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_slip_comp_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
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
