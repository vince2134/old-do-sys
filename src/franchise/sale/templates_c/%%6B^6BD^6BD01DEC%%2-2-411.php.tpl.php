<?php /* Smarty version 2.6.14, created on 2010-04-05 14:37:14
         compiled from 2-2-411.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<style TYPE="text/css">
<!--
.required {
    font-weight: bold;
    color: #ff0000;
    }
-->
</style>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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

 
<?php if ($this->_tpl_vars['errors'] != null): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
    <li><?php echo $this->_tpl_vars['errors']; ?>
</li><br>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
</span>
<?php endif; ?>

<?php echo $this->_tpl_vars['form']['confirm_msg']['html']; ?>

<br>

<table>
    <tr>
        <td>

<table class="List_Table" border="1">
<col width="100px" style="font-weight: bold;">
<col width="500px">
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_advance_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">入金日<span class="required">※</span></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_day']['html']; ?>
</td>
    </tr>
    <tr>
                <?php if ($this->_tpl_vars['var']['freeze_flg'] == true || $this->_tpl_vars['var']['fix_flg'] == true): ?>
        <td class="Title_Pink">得意先<span class="required">※</span></td>
                <?php else: ?>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<span class="required">※</span></td>
        <?php endif; ?>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
　<?php echo $this->_tpl_vars['var']['client_state_print']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求先<span class="required">※</span></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">金額<span class="required">※</span></td>
                <?php if ($this->_tpl_vars['var']['freeze_flg'] == true || $this->_tpl_vars['var']['fix_flg'] == true): ?>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_amount']['html']; ?>
</td>
                <?php else: ?>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_amount']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="Title_Pink">銀行</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table border="0" width="100%">
    <tr>
                <?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['hdn_ok_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['back_button']['html']; ?>
</td>
                <?php elseif ($this->_tpl_vars['var']['fix_flg'] == true): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['back_button']['html']; ?>
</td>
                <?php else: ?>
        <td><span class="required">※は必須入力です</span></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['confirm_button']['html']; ?>
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
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
