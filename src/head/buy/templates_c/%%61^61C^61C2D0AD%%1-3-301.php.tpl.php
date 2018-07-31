<?php /* Smarty version 2.6.14, created on 2009-11-05 09:36:32
         compiled from 1-3-301.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '1-3-301.php.tpl', 170, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script><?php echo $this->_tpl_vars['var']['javascript']; ?>
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
         

<?php if ($this->_tpl_vars['form']['form_close_day']['error'] != null): ?>     <li><?php echo $this->_tpl_vars['form']['form_close_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_order_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_order_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_buy_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_buy_amount']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_pay_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_pay_amount']['error']; ?>
<br>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['err_message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['item']; ?>
</li>
<?php endforeach; endif; unset($_from); ?>
</span>

<table width="800">
    <tr>
        <td>
<table width="100%">
    <tr style="color: #555555;">
        <td width="60"><b>表示件数</b></td>
        <td >   <?php echo $this->_tpl_vars['form']['form_show_num']['html']; ?>

                <span style="color: #0000ff; font-weight: bold;">
                　・「仕入先」検索は名前もしくは略称です</span></td>
    </tr>
</table>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Td_Search_1">仕入締日</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_close_day']['html']; ?>
</td>
        <td class="Td_Search_1">支払予定日</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_order_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Td_Search_1">今回仕入額（税込）</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_buy_amount']['html']; ?>
</td>
        <td class="Td_Search_1">今回支払予定額</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_pay_amount']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Td_Search_1">FC・取引先区分</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>
</td>
        <td class="Td_Search_1">FC・取引先</td>
        <td class="Td_Search_1"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
 <?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Td_Search_1">更新状況</td>
        <td class="Td_Search_1" colspan="3"><?php echo $this->_tpl_vars['form']['form_update_state']['html']; ?>
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

<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>
<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    
 <?php if ($this->_tpl_vars['post_flg'] == 'true'): ?>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">仕入締日</td>            <td class="Title_Blue">仕入先</td>
        <td class="Title_Blue">支払予定日</td>
        <td class="Title_Blue">前回支払残</td>
        <td class="Title_Blue">支払額</td>
        <td class="Title_Blue">繰越金額</td>
        <td class="Title_Blue">今回仕入額</td>
        <td class="Title_Blue">消費税額</td>
        <td class="Title_Blue">今回仕入額（税込）</td>
        <td class="Title_Blue">今回支払残</td>
        <td class="Title_Blue">今回支払予定額</td>
        <td class="Title_Blue">支払明細</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['payment_all_delete']['html']; ?>
</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['payment_all_update']['html']; ?>
</td>
    </tr>
<?php endif; ?>

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
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>  	    <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][3] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][3])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][4] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][4])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][5])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][6])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][7])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][8] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][8])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][9] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][9])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][10] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][10])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
                <td align="center"><a href="1-3-308.php?pay_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][11]; ?>
&c_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
" target="_self">明細</a></td> 
        <td align="center"><?php echo $this->_tpl_vars['form']['payment_delete'][$this->_tpl_vars['j']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['payment_update'][$this->_tpl_vars['j']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    
        <?php if ($this->_tpl_vars['post_flg'] == 'true'): ?>
    <tr class="Result3">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum1'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum1'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum2'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum2'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum3'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum3'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum4'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum4'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum5'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum5'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum6'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum6'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum7'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum7'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum8'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum8'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="center"></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['cancel_button']['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['renew_button']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
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
