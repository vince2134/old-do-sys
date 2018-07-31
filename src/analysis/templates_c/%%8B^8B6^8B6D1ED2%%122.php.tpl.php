<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:30
         compiled from 122.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'Plug_Minus_Numformat', '122.php.tpl', 155, false),array('modifier', 'escape', '122.php.tpl', 173, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%" height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="left" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['form']['form_trade_ym_s']['error'] != NULL): ?>
    <font color="red"><b><li><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['error']; ?>
</b></font>
<?php endif; ?>

<table width="600">
    <tr>
        <td>
<table width="100%">    
    <tr style="color: #555555;">
        <td colspan="2" align="left">
            <span style="color: #0000ff; font-weight: bold;">
           
        <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
            ・「FC・取引先」検索は名前もしくは略称です</td>
        <?php else: ?>
            ・「仕入先」検索は名前もしくは略称です</td>
        <?php endif; ?>
        <td align="right">  <b>出力形式</b>　<?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value">  <?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html']; ?>
から
                            <?php echo $this->_tpl_vars['form']['form_trade_ym_e']['html']; ?>
</td> 
    </tr>
    <tr>
                <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
            <td class="Title_Gray">FC・取引先</td>
            <td class="Value">  <?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>
</td>
        <?php else: ?>
            <td class="Title_Gray">仕入先</td>
            <td class="Value">  <?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="Title_Gray">表示対象</td>
        <td class="Value">  <?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
    </tr>
    <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
    <tr>
        <td class="Title_Gray">抽出対象</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_out_abstract']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
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
<?php if ($this->_tpl_vars['out_flg'] == true): ?>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>

                <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
            <td class="Title_Gray" align="center">FC・取引先</td>
            <td class="Title_Gray" align="center">FC・取引先区分</td>
        <?php else: ?>
            <td class="Title_Gray" align="center">仕入先</td>
        <?php endif; ?>    

        <td class="Title_Gray" align="center"></td>

                <?php $_from = $this->_tpl_vars['disp_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['date']):
?>
        <td class="Title_Gray" align="center"><?php echo $this->_tpl_vars['disp_head'][$this->_tpl_vars['i']]; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>

        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>

<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>

        <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) || ($this->_foreach['data']['iteration'] <= 1)): ?>

            <?php $this->assign('last', ($this->_foreach['data']['total']-1)); ?>
            <tr class="Result3">
        <td align="left"><b>合計</b></td>
        <td align="left"><b><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_count']; ?>
店舗</b></td>

                <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
            <td></td>
            <td align="left"><b>仕入金額</b></td>
        <?php else: ?>
            <td align="left"><b>仕入金額</b></td>
        <?php endif; ?>

                <?php $_from = $this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_arari_rate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>

        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
      </tr>
    <?php endif; ?>

            <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) == false): ?>
        <?php if (!(1 & $this->_tpl_vars['i'])): ?>
            <tr class="Result1">
        <?php else: ?>
            <tr class="Result2">
        <?php endif; ?>
    
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['cd']; ?>
<br><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>

                <?php if ($this->_tpl_vars['var']['group_kind'] == '1'): ?>
            <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank_cd']; ?>
<br><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <?php endif; ?>

        <td align="left"><b>仕入金額</b></td>

                <?php $_from = $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <?php endforeach; endif; unset($_from); ?>

        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        </tr>

    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
