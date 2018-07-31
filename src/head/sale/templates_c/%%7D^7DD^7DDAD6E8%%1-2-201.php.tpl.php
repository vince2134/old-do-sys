<?php /* Smarty version 2.6.14, created on 2009-11-02 14:08:25
         compiled from 1-2-201.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<?php echo $this->_tpl_vars['var']['form_potision']; ?>


<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
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
<?php endif;  if ($this->_tpl_vars['form']['form_sale_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['trade_sale_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['trade_sale_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_staff_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_staff_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_cstaff_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_cstaff_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_trans_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_trans_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error0'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error0']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['duplicate_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['duplicate_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['aord_id_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['aord_id_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
<?php endif;  $_from = $this->_tpl_vars['goods_error1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error1'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error1'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error2'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error2'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error3'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error3'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error4'] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error4'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['goods_error5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['goods_error5'][$this->_tpl_vars['i']] != null): ?>
    <li><?php echo $this->_tpl_vars['goods_error5'][$this->_tpl_vars['i']]; ?>
<br>
<?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['duplicate_goods_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['duplicate_goods_err'][$this->_tpl_vars['i']]; ?>
<br>
<?php endforeach; endif; unset($_from);  if ($this->_tpl_vars['form']['form_sale_money']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_money']['error']; ?>
<br>
<?php endif; ?>

</ul>
</span>

<!-- フリーズ画面判定 -->
<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
	<span style="font: bold;"><font size="+1">以下の内容で売上ますか？</font></span><br>
<?php endif; ?>

<table width="980">
    <tr>
        <td>

 

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_sale_no']['html']; ?>
</td>
        <td class="Title_Pink">
         
        <?php if ($this->_tpl_vars['var']['aord_id'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
            <a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,7,1);">得意先</a>
        <?php else: ?>
            得意先
        <?php endif; ?>
        <font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
        <td class="Title_Pink">受注番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_day']['html']; ?>
</td>
        <td class="Title_Pink">売上計上日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
        <td class="Title_Pink">請求日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day']['html']; ?>
</td>
        <td class="Title_Pink">受注担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['trade_sale_select']['html']; ?>
</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_select']['html']; ?>
</td>
        <td class="Title_Pink">売上担当者<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cstaff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_direct_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">メモ</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
<?php if ($_POST['form_sale_btn']['html'] == null):  if ($this->_tpl_vars['var']['warning'] != null): ?><font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font><br><?php endif;  endif; ?>
        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <?php if ($this->_tpl_vars['var']['aord_id'] != null): ?>
            <td class="Title_Pink">受注数</td>
        <?php endif; ?>
		<td class="Title_Pink">現在庫数</td>
        <td class="Title_Pink">出荷数<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
         
        <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['aord_id'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
            <td class="Title_Add" width="50">行削除</td>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['var']['html']; ?>

    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<A NAME="foot"></A>
<?php if ($this->_tpl_vars['var']['warning'] == null): ?>
<table width="100%">
    <tr>
    <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
        <td><?php echo $this->_tpl_vars['form']['add_row_link']['html']; ?>
</td>
    <td align="right">
    <?php else: ?>
    <td align="right" colspan="2">
    <?php endif; ?>
        <table class="List_Table" border="1" width="650">
            <tr>
                <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
                <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
                <td class="Title_Pink" align="center" width="80"><b>税込合計</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
            </tr>
        </table>
    </td>
    <?php if ($this->_tpl_vars['var']['warning'] == null && $this->_tpl_vars['var']['comp_flg'] == null): ?>
    <td align="right"><?php echo $this->_tpl_vars['form']['form_sum_btn']['html']; ?>
</td>
    <?php endif; ?>
    </tr>
    <tr>
        <td><?php if ($_POST['form_sale_btn']['html'] == null): ?><font color="#ff0000"><b>※は必須入力です</b></font></td><?php endif; ?>
    	 
		<?php if ($this->_tpl_vars['var']['comp_flg'] == null): ?>
			 
        	<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['form_sale_btn']['html']; ?>
</td>
		<?php else: ?>
			 
			<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
		<?php endif; ?>
	</tr>
</table>
<?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>

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
