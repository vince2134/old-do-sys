<?php /* Smarty version 2.6.14, created on 2007-05-22 20:23:48
         compiled from 2-2-306.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<SCRIPT>
<!--

<?php echo '
'; ?>


//-->
</SCRIPT>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['errors'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
		<li><?php echo $this->_tpl_vars['errors']; ?>
</li><BR>
		<?php endforeach; endif; unset($_from); ?>
	</span>
<?php endif; ?>
 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table  class="Data_Table" border="1" width="650" >

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['bill_no']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['bill_no']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['hyoujikensuu']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['hyoujikensuu']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['close_day_s']['label']; ?>
</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['close_day_s']['html']; ?>
　〜　<?php echo $this->_tpl_vars['form']['close_day_e']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['client_cd']['label']; ?>
</b></td>
        <td class="Value" width="175"><?php echo $this->_tpl_vars['form']['client_cd']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['client_cname']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['client_cname']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['claim_cd']['label']; ?>
</b></td>
        <td class="Value" width="175"><?php echo $this->_tpl_vars['form']['claim_cd']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['claim_cname']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['claim_cname']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['staff_cd']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['staff_cd']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['staff_name']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['staff_name']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['pay_amount']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['pay_amount']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['bill_amount_last']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['bill_amount_last']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['rest_amount']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['rest_amount']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['bill_amount_this']['label']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['bill_amount_this']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b><?php echo $this->_tpl_vars['form']['claim_update']['label']; ?>
</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['claim_update']['html']; ?>
</td>
    </tr>

</table>
<table width='650'>
    <tr>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['hyouji_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria_button']['html']; ?>

        </td>
    </tr>
</table>

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<?php echo $this->_tpl_vars['form']['chk']['html']; ?>


<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>No.</b></td>
        <td class="Title_Pink" width=""><b>請求番号</b></td>
        <td class="Title_Pink" width=""><b>請求締日</b></td>
        <td class="Title_Pink" width=""><b>得意先</b></td>
        <td class="Title_Pink" width=""><b>請求先</b></td>
        <td class="Title_Pink" width=""><b>担当者</b></td>
        <td class="Title_Pink" width=""><b>前月御買上残高</b></td>
        <td class="Title_Pink" width=""><b>当月御入金額</b></td>
        <td class="Title_Pink" width=""><b>繰越残高額</b></td>
        <td class="Title_Pink" width=""><b>当月御買上額</b></td>
        <td class="Title_Pink" width=""><b>当月消費税額</b></td>
        <td class="Title_Pink" width=""><b>税込御買上額</b></td>
        <td class="Title_Pink" width=""><b>御買上残高</b></td>
        <td class="Title_Pink" width=""><b>請求更新</b></td>
    </tr>
		<?php if ($this->_tpl_vars['claim_data']['0']['no'] != null): ?>

			<?php $_from = $this->_tpl_vars['claim_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
				<tr class="Result1">
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_no']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_close_day_this']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['client_cd1']; ?>
-<?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['client_cd2']; ?>
<br><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['client_cname']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cd1']; ?>
-<?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cd2']; ?>
<br><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cname']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['staff_cd']; ?>
<br><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['staff_name']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_amount_last']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['pay_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['rest_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['sale_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['tax_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['intax_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_amount_this']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['last_update_day']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
	        
	    <tr class="Result2">
	        <td align="right">総合計</td>
	        <td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['no']; ?>
社</td>
	        <td align="right"></td>
	        <td align="right"></td>
	        <td align="right"></td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['staff_cd']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['bill_amount_last']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['pay_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['rest_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['sale_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['tax_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['intax_amount']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['bill_amount_this']; ?>
</td>
	        <td align="right"></td>
	    </tr>

		<?php endif; ?>

</table>

                    </td>
                </tr>


                <tr>
                    <td>

<?php echo $this->_tpl_vars['var']['html_page2']; ?>

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
<?php echo $this->_tpl_vars['var']['html_footer']; ?>
