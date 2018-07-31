<?php /* Smarty version 2.6.14, created on 2009-12-29 10:27:22
         compiled from 2-2-302.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-2-302.php.tpl', 78, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<SCRIPT>
<!--

<?php echo '
function Link_Action(action_name,id) {
	if (confirm("削除します。\\nよろしいですか？")==true) {
		document.forms[0].link_action.value=action_name;
		document.forms[0].bill_id.value=id;
		document.forms[0].submit();
	}
}

'; ?>


<?php echo $this->_tpl_vars['var']['js']; ?>


//-->
</SCRIPT>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


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

<table>
    <tr>    
        <td><?php echo $this->_tpl_vars['html']['html_s']; ?>
</td>
    </tr>   
</table>
<br>

                    </td>   
                </tr>   
                <tr>    
                    <td>    

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>    
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<?php echo $this->_tpl_vars['form']['chk']['html']; ?>


<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_close_day'), $this);?>
</td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_claim_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_claim_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_collect_day'), $this);?>
</td>
        <td class="Title_Pink"><?php echo @BILL_AMOUNT_THIS; ?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_staff'), $this);?>
</td>
        <td class="Title_Pink">請求書送付</td>
        <td class="Title_Pink">請求書</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['claim_issue_all']['html']; ?>
</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['re_claim_issue_all']['html']; ?>
</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['claim_cancel_all']['html']; ?>
</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['claim_renew_all']['html']; ?>
</td>
    </tr>
		<?php if ($this->_tpl_vars['claim_data']['0']['no'] != null): ?>

			<?php $_from = $this->_tpl_vars['claim_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
                <?php if (bcmod ( $this->_tpl_vars['i'] , 2 ) == 0): ?>
                <tr class="Result1">
                <?php else: ?>  
                <tr class="Result2">
                <?php endif; ?> 
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_no']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_close_day_this']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cd1']; ?>
-<?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cd2']; ?>
<br><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_cname']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['collect_day']; ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['bill_amount_this']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['staff_cd']; ?>
<br><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['staff_name']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['claim_data'][$this->_tpl_vars['i']]['claim_send']; ?>
</td>
                    <td align="left"><?php echo $this->_tpl_vars['form']['format'][$this->_tpl_vars['i']]['html']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['claim_issue'][$this->_tpl_vars['i']]['html']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['re_claim_issue'][$this->_tpl_vars['i']]['html']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['claim_cancel'][$this->_tpl_vars['i']]['html']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['claim_renew'][$this->_tpl_vars['i']]['html']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
	        
	    <tr class="Result3">
	        <td><b>合計</b></td>
	        <td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['no']; ?>
件</td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['bill_amount_this']; ?>
</td>
	        <td align="right"><?php echo $this->_tpl_vars['claim_data']['0']['sum']['staff_cd']; ?>
</td>
            <td></td>
            <td></td>
	        <td align="center"><?php echo $this->_tpl_vars['form']['pre_hakkou_button']['html']; ?>
<br><br><?php echo $this->_tpl_vars['form']['hakkou_button']['html']; ?>
</td>
	        <td align="center"><?php echo $this->_tpl_vars['form']['re_hakkou_button']['html']; ?>
</td>
	        <td align="center"><?php echo $this->_tpl_vars['form']['cancel_button']['html']; ?>
</td>
	        <td align="center"><?php echo $this->_tpl_vars['form']['renew_button']['html']; ?>
</td>
	    </tr>

		<?php endif; ?>

</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
