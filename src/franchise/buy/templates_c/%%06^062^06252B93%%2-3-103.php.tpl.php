<?php /* Smarty version 2.6.14, created on 2009-12-25 19:27:20
         compiled from 2-3-103.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', '2-3-103.php.tpl', 235, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_sheet']; ?>

 </script>

<body bgcolor="#D8D0C8" <?php echo $this->_tpl_vars['var']['load']; ?>
>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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

<!-- ��Ͽ��ǧ��å�����ɽ�� -->
<?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    <?php if ($_GET['output_flg'] == 'delete'): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
     <li>��ɼ���������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
    </span>
    <?php elseif ($_GET['output_flg'] == 'finish'): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
     <li>�����򵯤����Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
    </span>
    <?php endif; ?>

    <table width="100%" align="center">
        <?php if ($_GET['output_flg'] != 'delete' && $_GET['output_flg'] != 'finish'): ?>
        <tr>
            <td align="center">
            <span style="font: bold 16px;">ȯ��λ���ޤ�����<br><br>
	        <?php if ($this->_tpl_vars['var']['warning'] != null): ?>
            	<?php echo $this->_tpl_vars['var']['warning']; ?>

	        <?php endif; ?>
            </span>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['order_button']['html']; ?>
��
	        <?php if ($this->_tpl_vars['var']['warning'] != null || $this->_tpl_vars['var']['offline_flg'] != null): ?>
	            <?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
��
	        <?php endif; ?>
	        <?php if ($this->_tpl_vars['var']['warning'] == null): ?>
	            <?php echo $this->_tpl_vars['form']['return_button']['html']; ?>

	        <?php endif; ?>
	        </td>
        </tr>
    </table>
<?php else: ?>
		<table>
	    <tr>
	        <td>

		<table class="Data_Table" border="1">
	<col width="110" style="font-weight: bold;">
	<col>
	<col width="60" style="font-weight: bold;">
	<col>
	<col width="80" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Blue">ȯ���ֹ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
</td>
	        <td class="Title_Blue">ȯ����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
	        <td class="Title_Blue">ȯ����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_time']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">�����ȼ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans']['html']; ?>
</td>
	        <td class="Title_Blue">ľ����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
	        <td class="Title_Blue">��˾Ǽ��</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_hope_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">�����Ҹ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
	        <td class="Title_Blue">ô����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_name']['html']; ?>
</td>
	        <td class="Title_Blue">�����ʬ</a></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_ord']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue" >�̿���<br>�ʻ����谸��</td>
	        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_my']['html']; ?>
</td>
	    </tr>
	    	    <tr>
	        <td class="Title_Blue" >�̿���<br>�ʣƣð���</td>
	        <td class="Value" colspan="5">
            <?php $_from = $this->_tpl_vars['note_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['note']):
?>
                <?php echo $this->_tpl_vars['note_head'][$this->_tpl_vars['j']][0]; ?>
<br>
            <?php endforeach; endif; unset($_from); ?>
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
	        <tr align="center">
	        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	            <td class="Title_Blue"><b><?php echo $this->_tpl_vars['item']; ?>
</b></td>
	        <?php endforeach; endif; unset($_from); ?>
	        </tr>
	    <?php endforeach; endif; unset($_from); ?>                          

	     
	    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
	        <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>

	            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][1] == "���"): ?>
	                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
	                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
	            <?php else: ?>
	                <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
	                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
	            <?php endif; ?>
	            <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
	            <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
	            <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
	            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] != null): ?>
	                <?php if (((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][6])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/.*-.*/", "-") : smarty_modifier_regex_replace($_tmp, "/.*-.*/", "-"))): ?>
	                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
	                <?php else: ?>
	                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
	                <?php endif; ?>
	            <?php endif; ?>
	            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] != null): ?>
	                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
	            <?php endif; ?>
	            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][8] != null): ?>
	                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][9] != null): ?>
	                    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
	                <?php else: ?>
	                    <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
	                <?php endif; ?>
	            <?php endif; ?>
	            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][9] != null): ?>
	                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
	            <?php endif; ?>
	        </tr>                                                                                             
	    <?php endforeach; endif; unset($_from); ?>                            
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table width="100%">
	    <tr>
	        <td align="right">
	        <table class="List_Table" border="1">
	            <tr>
	            <td class="Title_Pink" width="70" align="center"><b>��ȴ���</b></td>
	            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_total']['html']; ?>
</td>
	            <td class="Title_Pink" width="70" align="center"><b>������</b></td>
	            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_tax']['html']; ?>
</td>
	            <td class="Title_Pink" width="70" align="center"><b>�ǹ����</b></td>
	            <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_money']['html']; ?>
</td>
	            </tr>
	        </table>
	        </td>
	    </tr>
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table width="100%">
	    <tr>
	        <td align="right"><?php echo $this->_tpl_vars['form']['order_button']['html']; ?>
��
	        <?php if ($this->_tpl_vars['var']['warning'] != null || $this->_tpl_vars['var']['offline_flg'] != null): ?>
	            <?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
��
	        <?php endif; ?>
	        <?php if ($this->_tpl_vars['var']['warning'] == null): ?>
	            <?php echo $this->_tpl_vars['form']['return_button']['html']; ?>

	        <?php endif; ?>
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
