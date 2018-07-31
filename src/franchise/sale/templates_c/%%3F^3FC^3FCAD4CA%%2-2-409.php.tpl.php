<?php /* Smarty version 2.6.14, created on 2010-01-27 13:03:07
         compiled from 2-2-409.php.tpl */ ?>
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
<?php if ($this->_tpl_vars['form']['err_illegal_verify']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_illegal_verify']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_noway_forms']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_noway_forms']['error']; ?>
<br>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['form']['err_claim1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_claim2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_payin_date5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_trade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_form']):
?>
    <?php if ($this->_tpl_vars['err_form']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['err_form']['error']; ?>
<br>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['form']['err_bank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
<?php $_from = $this->_tpl_vars['form']['err_rebate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
</ul>
</span>

 
<?php $_from = $this->_tpl_vars['var']['filiation_flg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['err_flg']):
?>
<?php if ($this->_tpl_vars['err_flg'] == 1): ?>
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">注）<?php echo $this->_tpl_vars['j']+1; ?>
行目　親子関係のある請求先が選択されています。<br></span>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

 
<?php if ($this->_tpl_vars['var']['verify_flg'] == true): ?>
    <span style="font: bold 16px;">以下の内容で入金しますか？</span><br><br>
<?php endif; ?>

<table>
    <tr>    
        <td>    

<?php if ($this->_tpl_vars['var']['verify_flg'] != true): ?>
<br>
<?php echo $this->_tpl_vars['form']['form_trans_client_btn']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_trans_bank_btn']['html']; ?>
　<?php echo $this->_tpl_vars['form']['405_button']['html']; ?>

<br><br><br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>    
        <td class="Title_Pink">入金日</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_payin_date_clt_set']['html']; ?>
</td>
    </tr>   
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_clt_set']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_clt_set']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_clt_set_btn']['html']; ?>
</td>
    </tr>
</table>
<?php endif; ?>

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
        <td class="Title_Pink">請求先コード<br>請求先名<font color="#ff0000">※</font><br>振込名義1<br>振込名義2</td>
        <td class="Title_Pink">入金日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Title_Pink">銀行<font color="#ff0000"></font><br>支店<font color="#ff0000"></font><br>口座番号<font color="#ff0000"></font></td>
        <td class="Title_Pink">請求番号</td>
        <td class="Title_Pink">請求額</td>
        <td class="Title_Pink">金額<font color="#ff0000">※</font><br>手数料</td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <?php if ($this->_tpl_vars['var']['verify_flg'] != true): ?><td class="Title_Add">行削除</td><?php endif; ?>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td align="left"><A NAME="foot"><?php echo $this->_tpl_vars['form']['form_add_row_btn']['html']; ?>
</A></td>
        <?php if ($this->_tpl_vars['var']['verify_flg'] != true): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_calc_btn']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">入金額合計</td>
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
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            <?php if ($this->_tpl_vars['var']['verify_flg'] != true): ?><font color="#ff0000"><b>※は必須入力です</b></font><?php endif; ?>
        </td>
        <td colspan="2" align="right">
                        <?php if ($this->_tpl_vars['var']['verify_flg'] != true): ?>
            <?php echo $this->_tpl_vars['form']['form_verify_btn']['html']; ?>

                        <?php elseif ($this->_tpl_vars['var']['verify_flg'] == true): ?>
            <?php echo $this->_tpl_vars['form']['hdn_form_ok_btn']['html']; ?>
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
