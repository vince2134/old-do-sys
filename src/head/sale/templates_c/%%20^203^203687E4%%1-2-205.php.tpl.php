<?php /* Smarty version 2.6.14, created on 2009-11-02 14:09:02
         compiled from 1-2-205.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_sheet']; ?>

 </script>

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
    <?php if ($_GET['del_flg'] == 'true'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>伝票が削除されたため、登録できませんでした。<br>
</span>
    <?php elseif ($_GET['renew_flg'] == 'true'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>日次更新されたため、登録できませんでした。<br>
</span>
    <?php elseif ($_GET['aord_del_flg'] == 'true'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>受注伝票が削除されたため、登録できませんでした。<br>
</span>
    <?php elseif ($_GET['inst_err'] == 'true'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>売上が変更されたため、割賦設定が行えませんでした。<br>
</span>
    <?php elseif ($_GET['aord_finish_flg'] == 'true'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>受注が変更されたため、登録できませんでした。<br>
</span>
    <?php else: ?>
	<span style="font: bold;"><font size="+1">売上完了しました。<br><br>
    <?php endif; ?>
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['slip_bill_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['order_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
	    </tr>
	</table>
<?php else: ?>

		<table>
	    <tr>
	        <td>

	
	<table class="Data_Table" border="1">
	<col width="80" style="font-weight: bold;">
	<col>
	<col width="60" style="font-weight: bold;">
	<col>
	<col width="90" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Pink">伝票番号</td>
	        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_sale_no']['html']; ?>
</td>
	        <td class="Title_Pink">得意先</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
	        <td class="Title_Pink">受注番号</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">取引区分</td>
	        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_trade_sale']['html']; ?>
</td>
	        <td class="Title_Pink">運送業者</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_name']['html']; ?>
</td>
	        <td class="Title_Pink">受注担当者</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_name']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">直送先</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
	        <td class="Title_Pink">売上担当者</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cstaff_name']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">出荷倉庫</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
	        <td class="Title_Pink">請求日</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day']['html']; ?>
</td>
	        <td class="Title_Pink">売上計上日</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">備考</td>
	        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
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
	     
	    <?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
	        <tr align="center" style="font-weight: bold;">
	        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	            <td class="Title_Blue"><?php echo $this->_tpl_vars['item']; ?>
</td>
	        <?php endforeach; endif; unset($_from); ?>
	        </tr>
	    <?php endforeach; endif; unset($_from); ?>                          
	     
	    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
	    <tr class="Result1">
	        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
	        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
			<td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
	         
	        <?php if ($this->_tpl_vars['var']['aord_id'] != NULL): ?>
	            <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
	        <?php endif; ?>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
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
	        <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
	        <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
	        <td class="Title_Pink" align="center" width="80"><b>税込金額</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
	    </tr>
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table align="right">
	    <tr>
	        <td>
	            <?php echo $this->_tpl_vars['form']['order_button']['html']; ?>

	            <?php if ($this->_tpl_vars['var']['input_flg'] == true): ?>　<?php echo $this->_tpl_vars['form']['ok_button']['html'];  endif; ?>
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
