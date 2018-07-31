<?php /* Smarty version 2.6.14, created on 2010-04-05 16:16:18
         compiled from 2-3-303.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-3-303.php.tpl', 69, false),array('modifier', 'number_format', '2-3-303.php.tpl', 114, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
   <?php echo $this->_tpl_vars['var']['order_delete']; ?>

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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_pay_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_pay_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_sum_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sum_amount']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_input_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_input_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_account_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_account_day']['error']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_s']; ?>
</td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_payout_day'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_input_day'), $this);?>
<br>
        </td>
        <td class="Title_Blue">取引区分</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_bank_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_bank_name'), $this);?>
<br>
        </td>   
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_b_bank_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_b_bank_name'), $this);?>
<br>
        </td>   
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_deposit_kind'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_account_no'), $this);?>
<br>
        </td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Blue">支払金額</td>
        <td class="Title_Blue">手数料</td>
        <td class="Title_Blue">合計金額</td>
        <td class="Title_Blue">決済日<br>手形券面番号</td>
        <td class="Title_Blue">備考</td>
        <td class="Title_Blue">日次更新</td>
        <td class="Title_Blue">削除</td>
    </tr>
    <tr class="Result3" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
                <?php if ($this->_tpl_vars['var']['sum1'] < 0): ?><td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum1'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
        <?php else: ?><td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum1'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum2'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <?php if ($this->_tpl_vars['var']['sum3'] < 0): ?><td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum3'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
        <?php else: ?><td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum3'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
        <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
    <?php if (bcmod ( $this->_tpl_vars['j'] , 2 ) == 0): ?>
    <tr class="Result1">
    <?php else: ?>  
    <tr class="Result2">
    <?php endif; ?>
                <td align="right">
        <?php if ($_POST['form_display'] == "表　示"): ?>
                          <?php echo $this->_tpl_vars['j']+1; ?>

        <?php elseif ($_POST['f_page1'] != null): ?>
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
                <td align="center"><a href="2-3-302.php?pay_id=<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['item'][1]; ?>
</a></td>
                <td align="center"><?php echo $this->_tpl_vars['item'][3]; ?>
<br><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
                <td align="center"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
                <td><?php echo $this->_tpl_vars['item'][5]; ?>
<br><?php echo $this->_tpl_vars['item'][6]; ?>
</td>
                <td><?php echo $this->_tpl_vars['item'][7]; ?>
<br><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
                <td><?php echo $this->_tpl_vars['item'][9]; ?>
<br><?php echo $this->_tpl_vars['item'][10]; ?>
</td>
                <?php if ($this->_tpl_vars['item'][13] != null): ?>
            <td><?php echo $this->_tpl_vars['item'][12]; ?>
-<?php echo $this->_tpl_vars['item'][13]; ?>
<br><?php echo $this->_tpl_vars['item'][11]; ?>
</td>
        <?php else: ?>
            <td><?php echo $this->_tpl_vars['item'][12]; ?>
<br><?php echo $this->_tpl_vars['item'][11]; ?>
</td>
        <?php endif; ?>        
                <?php if ($this->_tpl_vars['item'][14] < 0): ?>
            <td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][14])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
        <?php else: ?>
            <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][14])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <?php endif; ?>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][15])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <?php if ($this->_tpl_vars['item'][15] != 0): ?>
            <?php if ($this->_tpl_vars['item'][16] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][16])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
            <?php else: ?>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][16])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <?php else: ?>
             <?php if ($this->_tpl_vars['item'][14] < 0): ?>
                <td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][14])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
             <?php else: ?>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][14])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <?php endif; ?>
                <td><?php echo $this->_tpl_vars['item'][21]; ?>
<br><?php echo $this->_tpl_vars['item'][22]; ?>
<br></td>
                <td><?php echo $this->_tpl_vars['item'][17]; ?>
</td>
                <?php if ($this->_tpl_vars['item'][18] == 't'): ?>
        <td align="center"><?php echo $this->_tpl_vars['item'][19]; ?>
</td>
        <td></td>
        <?php else: ?>
        <td align="center"></td>
                <td align="center"><?php if ($this->_tpl_vars['item'][20] == null):  if ($this->_tpl_vars['var']['auth'] == 'w'): ?><a href="#" onClick="Order_Delete('data_delete_flg','pay_h_id','<?php echo $this->_tpl_vars['item'][0]; ?>
');">削除</a><?php endif;  endif; ?></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
                <?php if ($this->_tpl_vars['var']['sum1'] < 0): ?><td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum1'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
        <?php else: ?><td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum1'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
                <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum2'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <?php if ($this->_tpl_vars['var']['sum3'] < 0): ?><td align="right"><font color="#ff0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum3'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</font></td>
        <?php else: ?><td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum3'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


        </td>
    </tr>
</table>

<?php endif; ?>

</form>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
