<?php /* Smarty version 2.6.14, created on 2009-12-28 16:25:17
         compiled from 1-2-304.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '1-2-304.php.tpl', 101, false),array('modifier', 'escape', '1-2-304.php.tpl', 148, false),array('modifier', 'date_format', '1-2-304.php.tpl', 183, false),)), $this); ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<table border=0 width="100%" height="90%" class="M_Table">

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
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['fix_message'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['fix_message']; ?>
<br>
<?php endif; ?>
</span>

<table  class="Data_Table" border="1" width="650" >
<col width="120" class="Title_Pink">
<col width="">
<col width="120">

    <tr>
        <td class="Title_Pink"><b>請求番号</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['claim_data']['bill_no']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>請求締日</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['claim_data']['bill_close_day_this']; ?>
</td>
        <td class="Title_Pink"><b>回収予定日</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['claim_data']['collect_day']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>請求先</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['claim_data']['claim_cname']; ?>
</td>
        <td class="Title_Pink"><b>請求書書式設定</b></td>
        <?php if ($this->_tpl_vars['claim_data']['bill_format'] == 1): ?>
        <td class="Value">明細請求書</td>
        <?php elseif ($this->_tpl_vars['claim_data']['bill_format'] == 2): ?>
        <td class="Value">合計請求書</td>
        <?php elseif ($this->_tpl_vars['claim_data']['bill_format'] == 3): ?>
        <td class="Value">出力しない</td>
        <?php elseif ($this->_tpl_vars['claim_data']['bill_format'] == 4): ?>
        <td class="Value">指定</td>
        <?php elseif ($this->_tpl_vars['claim_data']['bill_format'] == 5): ?>
        <td class="Value">個別請求書</td>
        <?php endif; ?>

    </tr>

    <tr>
        <td class="Title_Pink"><b>発行者</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['claim_data']['issue_staff_name']; ?>
</td>
        <td class="Title_Pink"><b>更新者</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['claim_data']['fix_staff_name']; ?>
</td>
    </tr>


    
</table>

                    </td>
                </tr>

                <tr>
                    <td>

<br><br>
<?php if ($_GET['client_id'] == null): ?>
<table width="100%">
    <tr>
        <td align="left" colspan="2">
        <table class="List_Table" border="1" width="100%" >
            <tr align="center">
                <td class="Title_Pink" width=""><b><?php echo @BILL_AMOUNT_LAST; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @PAYIN_AMOUNT; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @REST_AMOUNT; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @SALE_AMOUNT; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @TAX_AMOUNT; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @INTAX_AMOUNT; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @BILL_AMOUNT_THIS; ?>
</b></td>
                <td class="Title_Pink" width=""><b><?php echo @PAYMENT_THIS; ?>
</b></td>
            </tr>
    
            <tr class="Result1">
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['bill_amount_last'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['pay_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['rest_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['sale_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['tax_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['intax_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['bill_amount_this'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['payment_this'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
            </tr>
        </table>
        </td>
    </tr>
    <tr>
        <?php if ($this->_tpl_vars['claim_data']['tune_amount'] > 0): ?>
        <td align="left">
        <table class="List_Table" border="1" width="">
            <tr class="Result1">
                <td class="Title_Pink" width="" ><b><?php echo @TUNE_AMOUNT; ?>
</b></td>
                <td width="100" align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['tune_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
            </tr>
        </table>
        </td>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['claim_data']['split_bill_amount'] > 0 || $this->_tpl_vars['claim_data']['split_bill_rest_amount'] > 0): ?>
        <td align="right">
        <table class="List_Table" border="1" width="">
            <tr class="Result1">
                <?php if ($this->_tpl_vars['claim_data']['split_bill_amount'] > 0): ?>
                <td class="Title_Pink" width=""><b><?php echo @INSTALLMENT_AMOUNT_THIS; ?>
</b></td>
                <td width="100" align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['split_bill_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['claim_data']['split_bill_rest_amount'] > 0): ?>
                <td class="Title_Pink" width="" ><b><?php echo @INSTALLMENT_REST_AMOUNT; ?>
</b></td>
                <td width="100" align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claim_data']['split_bill_rest_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <?php endif; ?>
            </tr>
        </table>
        </td>
        <?php endif; ?>
    </tr>
</table>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['client_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
<br><br>
<font size="+0.5" color="#555555"><b>【<?php echo $this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['client_cd1']; ?>
-<?php echo $this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['client_cd2']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['client_cname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>月日</b></td>
        <td class="Title_Pink" width=""><b>伝票番号</b></td>
        <td class="Title_Pink" width=""><b>取引区分</b></td>
        <td class="Title_Pink" width="300"><b>商品名</b></td>
        <td class="Title_Pink" width="40"><b>数量</b></td>
        <td class="Title_Pink" width="60"><b>単価</b></td>
        <td class="Title_Pink" width="60"><b>金額</b></td>
        <td class="Title_Pink" width="40"><b>税区分</b></td>
        <td class="Title_Pink" width=""><b>ロイヤリティ</b></td>
        <td class="Title_Pink" width="60"><b>入金</b></td>
        <td class="Title_Pink" width="60"><b>残高</b></td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="right">繰越</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['bill_amount_last'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>

    <?php $_from = $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bill_d_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bill_d_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
        $this->_foreach['bill_d_data']['iteration']++;
?>
    <?php if ($this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name'] != null): ?>
    <tr class="Result1">
        <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['trading_day'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m-%d") : smarty_modifier_date_format($_tmp, "%m-%d")); ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['slip_no']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['trade_cname']; ?>
</td>
        <?php if ($this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['position'] == 2): ?>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name']; ?>
</td>
        <?php else: ?>
        <td align="left"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name']; ?>
</td>
        <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['quantity']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['sale_price']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['sale_amount']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['tax_div']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['royalty']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['pay_amount']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['rest_amount']; ?>
</td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    <tr class="Result1" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td align="right">計</td>
        <td></td>
        <td></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['installment_out_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td></td>
        <td></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['pay_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['client_data'][$this->_tpl_vars['i']]['bill_amount_this'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>

    <?php $_from = $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['split_bill_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['split_bill_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
        $this->_foreach['split_bill_data']['iteration']++;
?>
    <?php if ($this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name'] != null): ?>
    <tr class="Result1">
        <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['trading_day'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m-%d") : smarty_modifier_date_format($_tmp, "%m-%d")); ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['slip_no']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['trade_cname']; ?>
</td>
        <?php if ($this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['position'] == 2): ?>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
        <?php else: ?>
        <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['formal_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
        <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['quantity']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['sale_price']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['sale_amount']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['split_bill_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['tax_div']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['bill_d_data'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['royalty']; ?>
</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

</table>
<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
    <tr>
        <?php if ($_GET['client_id'] == null): ?>
        <td align="right">
        <?php echo $this->_tpl_vars['form']['form_add_button']['html']; ?>

        <?php if ($this->_tpl_vars['claim_data']['bill_format'] != 3 || $this->_tpl_vars['claim_data']['bill_format'] != 4): ?>
        <?php echo $this->_tpl_vars['form']['form_slipout_button']['html']; ?>

        <?php endif; ?>
        　　<?php echo $this->_tpl_vars['form']['modoru']['html']; ?>

        </td>
        <?php else: ?>
        <td align="right">
        <?php echo $this->_tpl_vars['form']['modoru']['html']; ?>

        </td>
        <?php endif; ?>
    </tr>
</table>

                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
