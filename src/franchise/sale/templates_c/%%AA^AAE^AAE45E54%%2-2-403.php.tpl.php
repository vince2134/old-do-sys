<?php /* Smarty version 2.6.14, created on 2010-01-08 16:05:56
         compiled from 2-2-403.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-2-403.php.tpl', 75, false),array('modifier', 'number_format', '2-2-403.php.tpl', 127, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


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
<?php if ($this->_tpl_vars['form']['err_daily_update']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_daily_update']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_collect_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_collect_staff']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_payin_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_payin_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_input_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_input_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_payin_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_payin_no']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_sum_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sum_amount']['error']; ?>
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
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_payin_day'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_input_day'), $this);?>
<br>
        </td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_collect_staff'), $this);?>
</td>
        <?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
        <td class="Title_Act">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_act_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_act_client_name'), $this);?>
<br>
        </td>
        <?php endif; ?>
        <td class="Title_Pink">金額</td> 
        <td class="Title_Pink">振込入金額</td> 
        <td class="Title_Pink">手数料</td> 
        <td class="Title_Pink">合計金額</td> 
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_bank_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_bank_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_b_bank_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_b_bank_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_deposit_kind'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_account_no'), $this);?>
<br>
        </td>
        <td class="Title_Pink">手形期日<br>手形券面番号</td>
        <td class="Title_Pink">備考</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Title_Pink">削除</td>
    </tr>
    <tr class="Result3" align="right" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?><td></td><?php endif; ?>
        <td<?php if ($this->_tpl_vars['var']['calc_sum'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_bank'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_bank'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_rebate'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_rebate'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php $_from = $this->_tpl_vars['disp_list_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if (bcmod ( $this->_tpl_vars['item'][1] , 2 ) == 0): ?>
    <tr class="Result2">
    <?php else: ?>  
    <tr class="Result1">
    <?php endif; ?>  
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="right"><?php echo $this->_tpl_vars['item'][1]; ?>
</td><?php endif; ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="center"><a href="./<?php if ($this->_tpl_vars['item'][20] == '1'): ?>2-2-402<?php else: ?>2-2-405<?php endif; ?>.php?payin_id=<?php echo $this->_tpl_vars['item'][2]; ?>
"><?php echo $this->_tpl_vars['item'][3]; ?>
</a></td><?php endif; ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="center"><?php echo $this->_tpl_vars['item'][4]; ?>
</td><?php endif; ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['item'][5]; ?>
</td><?php endif; ?>
        <td><?php if ($this->_tpl_vars['item'][6] != null):  echo $this->_tpl_vars['item'][6];  else: ?>手数料<?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['item'][17]; ?>
</td>
        <?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php if ($this->_tpl_vars['item'][19] != "-<br>"):  echo $this->_tpl_vars['item'][19];  endif; ?></td><?php endif; ?>
        <?php endif; ?>
        <td align="right"<?php if ($this->_tpl_vars['item'][7] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][7])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['item'][9] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][9])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="right"<?php if ($this->_tpl_vars['item'][18] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][18])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="right"<?php if ($this->_tpl_vars['item'][8] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][8])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td><?php endif; ?>
        <td><?php echo $this->_tpl_vars['item'][10]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][11]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][12]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][13]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][14]; ?>
</td>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="center"><?php echo $this->_tpl_vars['item'][15]; ?>
</td><?php endif; ?>
        <?php if ($this->_tpl_vars['item'][0] != 0): ?><td rowspan="<?php echo $this->_tpl_vars['item'][0]; ?>
" align="center"><?php echo $this->_tpl_vars['form']['form_del_link'][$this->_tpl_vars['i']]['html']; ?>
</td><?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" align="right" height="30px">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <?php if ($this->_tpl_vars['var']['group_kind'] == '2'): ?><td></td><?php endif; ?>
        <td<?php if ($this->_tpl_vars['var']['calc_sum'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_bank'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_bank'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_rebate'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_rebate'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td<?php if ($this->_tpl_vars['var']['calc_sum_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['calc_sum_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td></td>
        <td></td>
        <td></td>
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

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
