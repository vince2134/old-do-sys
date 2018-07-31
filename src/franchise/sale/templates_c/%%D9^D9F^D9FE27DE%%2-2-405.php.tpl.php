<?php /* Smarty version 2.6.14, created on 2010-01-08 16:16:47
         compiled from 2-2-405.php.tpl */ ?>
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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['err_illegal_post']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_illegal_post']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['err_claim']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_claim']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_claim']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_bill_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_bill_no']['error']; ?>
<br>
<?php endif; ?>

<?php if ($this->_tpl_vars['form']['form_payin_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_payin_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_trade']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_trade']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_bank']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_bank']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_limit_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_limit_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['err_count']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_count']['error']; ?>
<br>
<?php endif;  $_from = $this->_tpl_vars['form']['form_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['item']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['item']['error']; ?>
<br>
    <?php endif;  endforeach; endif; unset($_from);  $_from = $this->_tpl_vars['form']['form_rebate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['item']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['item']['error']; ?>
<br>
    <?php endif;  endforeach; endif; unset($_from); ?>
</ul>
</span>

<span style="color:#000000;font:bold 16px;">
<?php echo $this->_tpl_vars['form']['divide_msg']['html']; ?>

</span>

<?php if ($this->_tpl_vars['var']['freeze_flg'] != true && $this->_tpl_vars['var']['renew_flg'] != true): ?>
<br>
<?php echo $this->_tpl_vars['form']['402_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['409_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['405_button']['html']; ?>

<br><br><br>
<?php endif; ?>


<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="left">
        <td  style="font-weight: bold;" class="Title_Pink">
        <?php if ($this->_tpl_vars['var']['freeze_flg'] != true && $this->_tpl_vars['var']['get_flg'] != true):  echo $this->_tpl_vars['form']['form_claim_search']['html']; ?>
<font color="red">※</font></td><?php else: ?>
        請求先<font color="red">※</td><?php endif; ?>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
　<?php echo $this->_tpl_vars['var']['claim_state_print']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">振込名義１</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_pay_name']['html']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">振込名義２</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_account_name']['html']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" width="100" style="font-weight: bold;">請求番号</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_bill_no']['html']; ?>
</td>
        <td class="Title_Pink" width="100" style="font-weight: bold;">請求額</td>
        <td class="Value" width="250"><?php echo $this->_tpl_vars['form']['form_bill_amount']['html']; ?>
</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
    <tr align="left">
        <td class="Title_Pink" width="100" style="font-weight: bold;">入金日<font color="red">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_payin_day']['html']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">取引区分<font color="red">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
				<td class="Title_Pink" style="font-weight: bold;">集金担当者</td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_collect_staff']['html']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">銀行</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bank']['html']; ?>
</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink" style="font-weight: bold;">手形期日</td>
        <td class="Value" width="250"><?php echo $this->_tpl_vars['form']['form_limit_day']['html']; ?>
</td>
        <td class="Title_Pink" width="100" style="font-weight: bold;">手形券面番号</td>
        <td class="Value" width="250"><?php echo $this->_tpl_vars['form']['form_bill_paper_no']['html']; ?>
</td>
    </tr>
</table>
<table width=100%><tr>
<td align="right">
<?php if ($this->_tpl_vars['var']['freeze_flg'] == null && $this->_tpl_vars['var']['renew_flg'] == null): ?>
    <?php if ($this->_tpl_vars['var']['get_flg'] != true): ?>
        <?php echo $this->_tpl_vars['form']['divide_button']['html']; ?>

    <?php endif; ?>
    <?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>

<?php endif; ?></td>
</tr></table>
        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['illegal_post_flg'] != true && $this->_tpl_vars['var']['divide_null_flg'] != true): ?>

<?php if ($this->_tpl_vars['var']['divide_flg'] == true || $this->_tpl_vars['var']['freeze_flg'] == true || $this->_tpl_vars['var']['get_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>
<span style="font-weight:bold;color:#0000ff">※入金額を０円で登録すると請求書や元帳に入金額０円で表示されます。<br>
表示させない場合は空で登録して下さい。</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink" width="30">No.</td>
        <td class="Title_Pink" width="200">得意先コード<br>得意先名</td>
        <td class="Title_Pink" width="90">請求額</td>
        <td class="Title_Pink" width="90">入金額</td>
        <td class="Title_Pink" width="90">手数料</td>
        <td class="Title_Pink" width="180">備考</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>
<br style="font-size: 4px;">

<A NAME="sum">
<table width="100%">
        <?php if ($this->_tpl_vars['var']['freeze_flg'] != true && $this->_tpl_vars['var']['renew_flg'] == null): ?>
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['sum_button']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
        <tr>
        <td align="right">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">入金額合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_amount_total']['html']; ?>
</td>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">手数料合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_rebate_total']['html']; ?>
</td>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_payin_total']['html']; ?>
</td>
                </tr>
            </table>
            <br style="font-size: 4px;">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80" style="font-weight: bold;">請求額</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_bill2_amount']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if ($this->_tpl_vars['var']['freeze_flg'] != true && $this->_tpl_vars['var']['renew_flg'] == null): ?>
    <tr height="15">
        <td colspan="3" align="right"><br><?php echo $this->_tpl_vars['form']['form_verify_btn']['html']; ?>
</td>
    </tr>    
    <?php elseif ($this->_tpl_vars['var']['divide_flg'] == true): ?>
    <tr>
        <td colspan=3 align=right><?php echo $this->_tpl_vars['form']['hdn_ok_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['back_button']['html']; ?>
</td>
    </tr>    
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['renew_flg'] == true && $this->_tpl_vars['var']['get_flg'] != null): ?>
    <tr>
        <td colspan=3 align=right><?php echo $this->_tpl_vars['form']['get_back_btn']['html']; ?>
</td>
    </tr>    
    <?php endif; ?>
</table>
</A>

        </td>
    </tr>
</table>
<?php endif; ?>

<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

