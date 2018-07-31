<?php /* Smarty version 2.6.14, created on 2009-12-26 15:39:02
         compiled from 1-5-102.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['complete_msg'] != null): ?>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['complete_msg']; ?>
<br>
    </span><br>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['renew_err_flg'] == true): ?>
    <span style="font: bold; color: #ff0000;">
    <ul style="margin-left: 16px;">
    <?php if ($this->_tpl_vars['form']['form_renew_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_renew_day']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['form_input_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_input_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['start_day_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['start_day_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['renew_day_sale_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['renew_day_sale_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['renew_day_buy_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['renew_day_buy_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['renew_day_payin_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['renew_day_payin_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['renew_day_payout_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['renew_day_payout_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['invent_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['invent_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['payment_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['payment_err_msg']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['bill_err_msg'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['bill_err_msg']; ?>
</li><br>
    <?php endif; ?>
    </ul>
    </span>
<?php endif; ?>
<span style="font:bold; color: #555555;">入力した年月の情報を月次更新します</span><br><br>

<table width="300">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td width="80" class="Title_Green"><b>更新年月<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_renew_day']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['jikkou']['html']; ?>
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
        <td class="Title_Green">No.</td>
        <td class="Title_Green">月次更新年月</td>
        <td class="Title_Green">締日</td>
        <td class="Title_Green">実施時間</td>
    </tr>
    <?php $_from = $this->_tpl_vars['rec_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][2]; ?>
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
