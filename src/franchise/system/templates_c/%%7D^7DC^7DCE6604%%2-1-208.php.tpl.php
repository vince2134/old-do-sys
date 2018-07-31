<?php /* Smarty version 2.6.14, created on 2010-04-28 18:08:51
         compiled from 2-1-208.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


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

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>
 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_bank_select']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_bank_select']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_b_bank_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_b_bank_cd']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_b_bank_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_b_bank_name']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_b_bank_kana']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_b_bank_kana']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_bank_cname']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_bank_cname']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_fax']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_fax']['error']; ?>
<br><?php endif; ?>
</span>


<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple"><b>銀行名<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_select']['html']; ?>
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
        <td class="Title_Purple">支店コード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_b_bank_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">支店名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_b_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">支店名<br>（フリガナ）<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_b_bank_kana']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">郵便番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['input_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所1</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所3</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FAX</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
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
        <td align="right"><?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['csv_button']['html']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">銀行コード</td>
        <td class="Title_Purple">銀行名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">支店コード</td>
        <td class="Title_Purple">支店名</td>
        <td class="Title_Purple">支店名<br>（フリガナ）</td>
        <td class="Title_Purple">非表示</td>
        <td class="Title_Purple">備考</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class=<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['j']]; ?>
> 
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td><a href="2-1-208.php?b_bank_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
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
