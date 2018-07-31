<?php /* Smarty version 2.6.14, created on 2010-04-05 16:16:16
         compiled from 2-3-302.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-3-302.php.tpl', 132, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script Language="JavaScript">
<!--
<?php echo $this->_tpl_vars['var']['js']; ?>

-->
</script>

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
        <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
        <li><?php echo $this->_tpl_vars['errors']; ?>
</li><BR>
        <?php endforeach; endif; unset($_from); ?>
    </span> 
<?php endif;  if ($this->_tpl_vars['var']['duplicate_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['duplicate_err']; ?>
<br>
<?php endif; ?>
</span>
<br>

<?php if ($this->_tpl_vars['var']['disp_pattern'] == '1'): ?> 
<table>
    <tr>    
        <td>    

<table class="List_Table" border="1">
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">支払日</td>        
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_day_all']['html']; ?>
</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">取引区分</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_all']['html']; ?>
</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">銀行</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_all']['html']; ?>
</td>
    </tr>   
</table>

        </td>   
        <td valign="bottom"><?php echo $this->_tpl_vars['form']['all_set_button']['html']; ?>
</td>
    </tr>   
</table>
<?php endif; ?>
<br>

                    </td>   
                </tr>
                <tr>
                    <td>

<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">仕入先コード<font color="red">※</font><br>仕入先名<br>振込銀行</td>
        <td class="Title_Blue">支払日<font color="red">※</font></td>
        <td class="Title_Blue">取引区分<font color="red">※</font></td>
        <td class="Title_Blue">銀行名<br>支店名<br>口座番号</td>
        <td class="Title_Blue">支払予定額</td>
        <td class="Title_Blue">支払金額<font color="red">※</font><br>手数料</td>
        <td class="Title_Blue">決済日<br>手形券面番号</td>
        <td class="Title_Blue">備考</td>
        <?php if ($this->_tpl_vars['var']['disp_pattern'] == '1'): ?>
        <td style="background-color:800080;color:white;font-style:bolde">行削除</td>
        <?php endif; ?>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_l']; ?>

</table>

        </td>
    </tr>

<?php if ($this->_tpl_vars['var']['disp_pattern'] == '1'): ?>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td>
            <font color="#ff0000"><b>※は必須入力です </b></font>
            <br>
            <A NAME="foot"><?php echo $this->_tpl_vars['form']['add_row_button']['html']; ?>
</A>
        </td>
    </tr>
</table>

        </td>
    </tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['disp_pattern'] == '4'): ?>
    <tr>
        <td>

<br style="font-size: 4px;">
<table class="List_Table" align="right">
    <tr>
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">支払金額合計</td>
        <td class="Value" align="right" width="90"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum_pay_mon'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">手数料合計</td>
        <td class="Value" align="right" width="90"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum_pay_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
</table>

        </td>
    </tr>
<?php endif; ?>

    <tr>
        <td>

<br style="font-size: 4px;">
<table width="100%">
    <tr style="font-weight:bold;" align="right">
        <td align="right" colspan="3">
            <?php if ($this->_tpl_vars['var']['disp_pattern'] == '1'): ?>
            <?php echo $this->_tpl_vars['form']['confirm_button']['html']; ?>

            <?php elseif ($this->_tpl_vars['var']['disp_pattern'] == '2'): ?>
            <?php echo $this->_tpl_vars['form']['confirm_button']['html']; ?>

            <?php elseif ($this->_tpl_vars['var']['disp_pattern'] == '3'): ?>
            <?php echo $this->_tpl_vars['form']['back_btn']['html']; ?>

            <?php elseif ($this->_tpl_vars['var']['disp_pattern'] == '4'): ?>
            <?php echo $this->_tpl_vars['form']['payout_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['back_btn']['html']; ?>

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
