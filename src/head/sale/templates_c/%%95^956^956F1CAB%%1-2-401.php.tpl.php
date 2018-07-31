<?php /* Smarty version 2.6.9, created on 2006-12-01 15:14:14
         compiled from 1-2-401.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

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


    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['f_collect_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['f_collect_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['f_bill_close_day_this']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['f_bill_close_day_this']['error']; ?>
<br>
    <?php endif; ?>
    </span>


<table width="700" >
    <tr>
        <td>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">回収予定日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_collect_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求締日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_bill_close_day_this']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_claim_cd']['html']; ?>
</td>
        <td class="Title_Pink">請求先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_claim_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_bank_cd']['html']; ?>
</td>
        <td class="Title_Pink">銀行名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">支店コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_branch_cd']['html']; ?>
</td>
        <td class="Title_Pink">支店名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_branch_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">預金種別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_account_class']['html']; ?>
</td>
        <td class="Title_Pink">口座番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_bank_account']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_bill_no']['html']; ?>
</td>
        <td class="Title_Pink">集金方法</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_pay_way']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">表示件数</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['show_number']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
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

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">回収予定日</td>
        <td class="Title_Pink">請求締日</td>
        <td class="Title_Pink">請求番号</td>
        <td class="Title_Pink">請求先</td>
        <td class="Title_Pink">集金方法</td>
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">支店</td>
        <td class="Title_Pink">預金種目<br>口座番号</td>
        <td class="Title_Pink">回収予定額</td>
        <td class="Title_Pink">入金額</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j']%2 == 0): ?>
        <tr class="Result1">
    <?php else: ?>
                <tr class="Result2">
    <?php endif; ?>
       <td align="right">
            <?php if ($_POST['f_page1'] != null): ?>
		<?php if ($this->_tpl_vars['var']['r'] == 10): ?>
                   <?php echo $_POST['f_page1']*10+$this->_tpl_vars['j']-9; ?>

		<?php elseif ($this->_tpl_vars['var']['r'] == 50): ?>
                   <?php echo $_POST['f_page1']*50+$this->_tpl_vars['j']-49; ?>

		<?php elseif ($this->_tpl_vars['var']['r'] == 100): ?>
                   <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

		<?php else: ?>
	       　  <?php echo $this->_tpl_vars['j']+1; ?>

		<?php endif; ?>
            <?php else: ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
<br>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][11]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['sum1']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['var']['sum2']; ?>
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
