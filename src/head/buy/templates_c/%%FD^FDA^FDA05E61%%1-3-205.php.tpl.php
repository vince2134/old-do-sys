<?php /* Smarty version 2.6.14, created on 2009-12-28 19:06:03
         compiled from 1-3-205.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    	<tr align="center" valign="top" height="160">
	<?php else: ?>
		<tr align="center" valign="top">
	<?php endif; ?>
        <td>
            <table>
                <tr>
                    <td>

<!-- 登録確認メッセージ表示 -->
<?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    <?php if ($_GET['del_buy_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>伝票が削除されているため、変更できませんでした。<br>
    </span>
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['del_ord_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>発注が削除されているため、登録できませんでした。<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['change_ord_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>発注が変更されたため、仕入入力できませんでした。<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['inst_err'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>仕入が変更されたため、割賦設定が行えませんでした。<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['ps_stat'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>仕入が既に完了しているため、登録できません。<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php else: ?>
	<span style="font: bold;"><font size="+1">仕入完了しました。<br><br>
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_split_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php endif; ?>
<?php else: ?>

		<table>
	    <tr>
	        <td>

	<table class="Data_Table" border="1">
	<col width="80" style="font-weight: bold;">
	<col>
	<col width="60" style="font-weight: bold;">
	<col>
	<col width="80" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Blue">伝票番号</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_no']['html']; ?>
</td>
	        <td class="Title_Blue">仕入先</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
	        <td class="Title_Blue">発注番号</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">入荷日</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
	        <td class="Title_Blue">取引区分</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_buy']['html']; ?>
</td>
	        <td class="Title_Blue">仕入日</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">仕入倉庫</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
	        <td class="Title_Blue">直送先</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
	        <td class="Title_Blue">発注担当者</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_oc_staff_name']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">仕入担当者</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_name']['html']; ?>
</td>
	        <td class="Title_Blue">備考</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
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

	<table class="List_Table" border="1" width="100%">
	    <tr align="center" style="font-weight: bold;">
	        <td class="Title_Blue">No.</td>
	        <td class="Title_Blue">商品コード<br>商品名</td>
	        <td class="Title_Blue">仕入数</td>
	        <td class="Title_Blue">仕入単価</td>
	        <td class="Title_Blue">仕入金額</td>    
	    </tr>
	    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] === 't' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '掛返品' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '掛値引' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '現金返品' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '現金値引'): ?>
	    <tr class="Result1" style="color: red">
        <?php else: ?>
	    <tr class="Result1">
        <?php endif; ?>
	        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
	        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
	    </tr>                                                                           
	    <?php endforeach; endif; unset($_from); ?>                                   
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table class="List_Table" border="1" align="right">
	    <tr>
	        <td class="Title_Blue" width="80" align="center"><b>税抜金額</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_total']['html']; ?>
</td>
	        <td class="Title_Blue" width="80" align="center"><b>消費税</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_tax']['html']; ?>
</td>
	        <td class="Title_Blue" width="80" align="center"><b>税込金額</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_money']['html']; ?>
</td>
	    </tr>
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

    <?php if ($this->_tpl_vars['var']['act_sale_flg'] == true): ?>
	<table class="List_Table" border="1" align="right">
	    <tr>
	        <td width="80" align="center" bgcolor="#FDFD88"><b>売上番号</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_act_sale_no']['html']; ?>
</td>
	        <td width="80" align="center" bgcolor="#FDFD88"><b>代行売上額</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_act_sale_amount']['html']; ?>
</td>
	    </tr>
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>
    <?php endif; ?>

	<table width="100%">
	    <tr>
	        <td align="right">
	        <?php if ($this->_tpl_vars['var']['input_flg'] != null):  echo $this->_tpl_vars['form']['ok_button']['html']; ?>
　<?php endif; ?>　<?php echo $this->_tpl_vars['form']['form_split_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
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
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
