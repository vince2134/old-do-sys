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

<!-- ��Ͽ��ǧ��å�����ɽ�� -->
<?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    <?php if ($_GET['del_buy_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>��ɼ���������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���Ǥ�����<br>
    </span>
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['del_ord_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>ȯ���������Ƥ��뤿�ᡢ��Ͽ�Ǥ��ޤ���Ǥ�����<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['change_ord_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>ȯ���ѹ����줿���ᡢ�������ϤǤ��ޤ���Ǥ�����<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['inst_err'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>�������ѹ����줿���ᡢ�������꤬�Ԥ��ޤ���Ǥ�����<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php elseif ($_GET['ps_stat'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>���������˴�λ���Ƥ��뤿�ᡢ��Ͽ�Ǥ��ޤ���<br>
    <span>  
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
</td>
	    </tr>
	</table>
    <?php else: ?>
	<span style="font: bold;"><font size="+1">������λ���ޤ�����<br><br>
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_split_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
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
	        <td class="Title_Blue">��ɼ�ֹ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_no']['html']; ?>
</td>
	        <td class="Title_Blue">������</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
��<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
	        <td class="Title_Blue">ȯ���ֹ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_no']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">������</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arrival_day']['html']; ?>
</td>
	        <td class="Title_Blue">�����ʬ</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_buy']['html']; ?>
</td>
	        <td class="Title_Blue">������</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_buy_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">�����Ҹ�</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_name']['html']; ?>
</td>
	        <td class="Title_Blue">ľ����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
	        <td class="Title_Blue">ȯ��ô����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_oc_staff_name']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Blue">����ô����</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_name']['html']; ?>
</td>
	        <td class="Title_Blue">����</td>
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
	        <td class="Title_Blue">���ʥ�����<br>����̾</td>
	        <td class="Title_Blue">������</td>
	        <td class="Title_Blue">����ñ��</td>
	        <td class="Title_Blue">�������</td>    
	    </tr>
	    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] === 't' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '������' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '���Ͱ�' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '��������' || $this->_tpl_vars['form']['form_trade_buy']['html'] == '�����Ͱ�'): ?>
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
	        <td class="Title_Blue" width="80" align="center"><b>��ȴ���</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_total']['html']; ?>
</td>
	        <td class="Title_Blue" width="80" align="center"><b>������</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_buy_tax']['html']; ?>
</td>
	        <td class="Title_Blue" width="80" align="center"><b>�ǹ����</b></td>
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
	        <td width="80" align="center" bgcolor="#FDFD88"><b>����ֹ�</b></td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_act_sale_no']['html']; ?>
</td>
	        <td width="80" align="center" bgcolor="#FDFD88"><b>�������</b></td>
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
��<?php endif; ?>��<?php echo $this->_tpl_vars['form']['form_split_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
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
