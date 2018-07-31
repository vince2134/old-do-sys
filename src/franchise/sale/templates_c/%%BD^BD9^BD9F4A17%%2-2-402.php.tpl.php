<?php /* Smarty version 2.6.14, created on 2010-01-08 15:35:55
         compiled from 2-2-402.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['js_sheet']; ?>

</script>

<body bgcolor="#D8D0C8" <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true && $this->_tpl_vars['var']['group_kind'] == '2'): ?>onLoad="Staff_Select(); Act_Select();"<?php endif; ?>>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


</script>

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
<?php if ($this->_tpl_vars['form']['err_illegal_verify']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_illegal_verify']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_payin_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_payin_date']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_collect_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_collect_staff']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_act_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_act_client']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_claim_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_select']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_bill_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_bill_no']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_noway_forms']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_noway_forms']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_plural_rebate']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_plural_rebate']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_act_trade']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_act_trade']['error']; ?>
<br>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['form']['err_trade1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_amount1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_amount2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_bank1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_bank2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_limit_date1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_limit_date2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_limit_date3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['var']['duplicate_err_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['duplicate_err_msg']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['var']['just_daily_update_flg'] == true): ?>
    <li>日次更新処理が行われているため、変更できません。<br>
<?php endif; ?>
</ul>
</span>

<?php if ($this->_tpl_vars['var']['filiation_flg'] == true): ?>
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">注）親子関係のある得意先が選択されています。<br></span>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['verify_flg'] == true && $this->_tpl_vars['var']['verify_only_flg'] != true && $this->_tpl_vars['var']['just_daily_update_flg'] != true): ?>
    <span style="font: bold 16px;">以下の内容で入金しますか？</span><br><br>
<?php endif; ?>

<table width="700">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?>
<br>
<?php echo $this->_tpl_vars['form']['form_trans_client_btn']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_trans_bank_btn']['html']; ?>
　<?php echo $this->_tpl_vars['form']['405_button']['html']; ?>

<br><br><br>
<?php endif; ?>

<table class="List_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col width="220">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">入金番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_payin_no']['html']; ?>
</style></td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_payin_date']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink" valign="bottom">
            <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?><a href="#" onClick="return Open_SubWin('../dialog/2-0-402.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">得意先</a><?php else: ?>得意先<?php endif; ?><font color="#ff0000">※</font><br><br style="font-size: 8px;">銀行<br>支店<br>口座</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
<br><br style="font-size: 5px;"><?php echo $this->_tpl_vars['form']['form_c_bank']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_c_b_bank']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_c_account']['html']; ?>
<br></td>
    </tr>
    <tr>
        <td class="Title_Pink">集金担当者</td>
        <td class="Value"<?php if ($this->_tpl_vars['var']['group_kind'] != '2'): ?> colspan="3"<?php endif; ?>><?php echo $this->_tpl_vars['form']['form_collect_staff']['html']; ?>
</td>
        <?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
        <td class="Title_Pink">
            <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?>
            <div id="link_str"></div>
            <?php else: ?>
            代行店集金
            <?php endif; ?>
        </td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_act_client']['html']; ?>
</td>
        <?php endif; ?>
    <tr>
        <td class="Title_Pink" valign="bottom">請求先<span style="color: #ff0000;">※</span><br><br style="font-size: 8px;">振込名義1<br>振込名義2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_select']['html']; ?>
<br><br style="font-size: 5px;"><div id="pay_account_name"><?php echo $this->_tpl_vars['var']['pay_account_name']; ?>
</div></td>
        <td class="Title_Pink">請求番号<br>請求額</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['billbill']['html']; ?>
<div id="bill_no_amount"><?php echo $this->_tpl_vars['var']['bill_no_amount']; ?>
</div></td>
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
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font></td>
        <td class="Title_Pink">銀行<br>支店<br>口座番号</td>
        <td class="Title_Pink">手形期日</td>
        <td class="Title_Pink">手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?><td class="Title_Add">行削除</td><?php endif; ?>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td><A NAME="foot"><?php echo $this->_tpl_vars['form']['form_add_row_btn']['html']; ?>
</A></td>
        <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?>
        <td align="right"><A NAME="sum"><?php echo $this->_tpl_vars['form']['form_calc_btn']['html']; ?>
</A></td>
        <?php endif; ?>
    </tr>
    <tr align="right">
        <td colspan="2">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">入金合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_amount_total']['html']; ?>
</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">手数料合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_rebate_total']['html']; ?>
</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">合計</td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_payin_total']['html']; ?>
</td>
                </tr>
            </table>
            <br style="font-size: 4px;">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">請求額</td>
                    <td class="Value" align="right" width="100"><div id="bill_amount"><?php echo $this->_tpl_vars['var']['bill_amount']; ?>
</div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?><font color="#ff0000"><b>※は必須入力です</b></font><?php endif; ?>
        </td>
        <td colspan="2" align="right">
                        <?php if ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?>
            <?php echo $this->_tpl_vars['form']['form_verify_btn']['html']; ?>

                        <?php elseif ($this->_tpl_vars['var']['verify_flg'] == true && $this->_tpl_vars['var']['verify_only_flg'] != true): ?>
            <?php echo $this->_tpl_vars['form']['hdn_form_ok_btn']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_return_btn']['html']; ?>

                        <?php elseif ($this->_tpl_vars['var']['verify_flg'] != true && $this->_tpl_vars['var']['verify_only_flg'] == true): ?>
            <?php echo $this->_tpl_vars['form']['form_return_btn']['html']; ?>

            <?php endif; ?>
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
