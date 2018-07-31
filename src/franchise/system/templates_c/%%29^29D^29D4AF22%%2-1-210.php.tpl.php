<?php /* Smarty version 2.6.14, created on 2010-04-28 18:37:30
         compiled from 2-1-210.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


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

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_bank_b_bank']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_bank_b_bank']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_deposit_kind']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_deposit_kind']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_account_no']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_account_no']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_account_identifier']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_account_identifier']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_account_holder']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_account_holder']['error']; ?>
<br><?php endif; ?>
</span>


<?php echo $this->_tpl_vars['form']['genre']['html']; ?>



<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple"><b>銀行名<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_b_bank']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">預金種目<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_deposit_kind']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座番号<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_identifier']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座名義<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_holder']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">非表示</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_nondisp_flg']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_entry_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_btn']['html']; ?>
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

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_btn']['html']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">銀行コード</td>
        <td class="Title_Purple">銀行名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">支店コード</td>
        <td class="Title_Purple">支店名</td>
        <td class="Title_Purple">預金種目</td>
        <td class="Title_Purple">口座番号</td>
        <td class="Title_Purple">口座名</td>
        <td class="Title_Purple">口座名義</td>
        <td class="Title_Purple">非表示</td>
        <td class="Title_Purple">備考</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
"> 
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][6]; ?>
</td>
        <td><a href="2-1-210.php?account_id=<?php echo $this->_tpl_vars['item'][5]; ?>
"><?php echo $this->_tpl_vars['item'][7]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][10]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][11]; ?>
</td>
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
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
