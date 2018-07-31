<?php /* Smarty version 2.6.14, created on 2007-03-19 20:26:11
         compiled from 1-2-202.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script>
    <?php echo $this->_tpl_vars['var']['javascript']; ?>

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
<?php if ($this->_tpl_vars['var']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_sale_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_day']['error']; ?>

<?php elseif ($this->_tpl_vars['var']['sale_day_error'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['sale_day_error']; ?>

<?php endif; ?>
</span>

<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票形式</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_slip_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_slip_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">売上計上日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_sale_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
        <td class="Title_Pink">得意先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_sale']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">発行状況</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_slip']['html']; ?>
</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_renew']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">得意先</td>
        <td class="Title_Pink">伝票番号</td>
        <td class="Title_Pink">売上計上日</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">売上金額</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['slip_check_all']['html']; ?>
</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['re_slip_check_all']['html']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
            <?php if ($_POST['form_show_button'] == "表　示"): ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php elseif ($_POST['f_page1'] != null): ?>
                <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
 - <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td><a href="1-2-205.php?sale_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '11'): ?>
        <td align="center">掛売上</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '13'): ?>
        <td align="center">掛返品</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '14'): ?>
        <td align="center">掛値引</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '15'): ?>
        <td align="center">割賦売上</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '61'): ?>
        <td align="center">現金売上</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '63'): ?>
        <td align="center">現金返品</td>
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] == '64'): ?>
        <td align="center">現金値引</td>
        <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['slip_check'][$this->_tpl_vars['j']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['re_slip_check'][$this->_tpl_vars['j']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result2" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['total_amount']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['output_slip_button']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['output_re_slip_button']['html']; ?>
</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
