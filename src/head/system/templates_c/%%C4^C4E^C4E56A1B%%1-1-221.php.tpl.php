<?php /* Smarty version 2.6.14, created on 2009-12-06 09:33:00
         compiled from 1-1-221.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

 </script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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
    <?php if ($this->_tpl_vars['form']['form_goods_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_url']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_url']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_g_goods']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_g_goods']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_product']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_product']['error']; ?>
<br>
    <?php endif; ?>
	<?php if ($this->_tpl_vars['form']['form_g_product']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_g_product']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_in_num']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_in_num']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_supplier']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_supplier']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_supplier2']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_supplier2']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_supplier3']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_supplier3']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_point']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_point']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_unit']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_unit']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_lead']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_lead']['error']; ?>
<br>
    <?php endif; ?>
    </span>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="650">
    <tr>
        <td>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_dialog_button']['html']; ?>
</td>
        <td align="right">
            <?php if ($_GET['goods_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table>
    <tr>    
        <td>    
        <table class="Data_Table" border="1" width="350">
            <tr>    
                <td class="Type"  align="center" width="100"><b>����</b></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
            </tr>   
        </table>
        </td>   
		<td>    
        <table class="Data_Table" border="1" width="280">
            <tr>    
                <td class="Type" align="center" width="100"><b>��ǧ</b></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
            </tr>   
        </table>
        </td>      
	</tr>
	<tr>
		<td>
        <table class="Data_Table" border="1" width="280">
            <tr>    
                <td class="Type" align="center" width="100"><b>RtoR</b></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_rental']['html']; ?>
</td>
            </tr>   
        </table>
        </td>   
        <td>
        <table class="Data_Table" border="1" width="280">
            <tr>    
                <td class="Type" align="center" width="100"><b>���ꥢ�����</b></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_serial']['html']; ?>
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

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">���ʥ�����<font color="#ff0000">��</font></td>
        <td class="Value">
        <table> 
            <tr>    
                <td rowspan="2"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
                <td><font color=#555555>�壱�夬����������</font></td>
            </tr>   
            <tr>    
                <td><font color=#555555>�壱�夬���ʳ��ϥ���å���</font></td>
            </tr>   
        </table>
        </td>   
    </tr>
	<tr>
        <td class="Title_Purple">�Ͷ�ʬ</a><font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������ʬ</a><font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
	<tr>
        <td class="Title_Purple">����ʬ��</a><font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">°����ʬ<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_attri_div']['html']; ?>
</td>
    </tr>
	<tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_album_link']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
�ե�����̾�����Ϥ��Ʋ�����</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ޡ���<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_mark_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ñ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_in_num']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_client_link2']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_client_link3']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier3']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�������<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sale_manage']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�߸˴���<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_stock_manage']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�߸˸¤���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_stock_only']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ȯ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_point']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ȯ��ñ�̿�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�꡼�ɥ�����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_lead']['html']; ?>
��</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��̾�ѹ�<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_name_change']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ƕ�ʬ<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ƥ�<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_royalty']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�ǿ������</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['sale_day']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ǿ�������</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['buy_day']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Purple" width="130"><b>����</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
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
