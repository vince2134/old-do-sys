<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:27
         compiled from 113.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'Plug_Minus_Numformat', '113.php.tpl', 99, false),array('modifier', 'escape', '113.php.tpl', 118, false),array('modifier', 'Plug_Unit_Add', '113.php.tpl', 120, false),)), $this); ?>
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
                    <td width="650">

<!-- エラーメッセージの判定-->
<?php if ($this->_tpl_vars['form']['form_trade_ym_s']['error'] != NULL): ?>
    <font color="red"><b><li><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['error']; ?>
</b></font>
<?php endif; ?>


<table width="100%">
    <tr style="color: #555555;">
        <td align="right"><b>出力形式</b>　<?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">集計期間<font color="red">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html'];  echo $this->_tpl_vars['form']['form_trade_ym_e_abc']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">表示対象</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
        <td class="Title_Gray">抽出対象</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_abstract']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font><td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
</td>
    </tr>
</table>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td>
<!--表示ボタン押下の場合-->
<?php if ($this->_tpl_vars['var']['disp_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Gray">順位</td>
        <td class="Title_Gray">業種</td>
        <td class="Title_Gray">売上金額</td>
        <td class="Title_Gray">構成比</td>
        <td class="Title_Gray">累積金額</td>
        <td class="Title_Gray">累積構成比</td>
        <td class="Title_Gray">区分</td>
    </tr>



<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>

        <?php $this->assign('last', ($this->_foreach['data']['total']-1)); ?>

    <!-- 合計行（初めと終わりのみ） -->
    <?php if (($this->_foreach['data']['iteration'] <= 1) || ($this->_foreach['data']['iteration'] == $this->_foreach['data']['total'])): ?>
    <tr class="Result3">
        <td align="center"><b>合計</b></td>
        <td align="center"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['count'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
業種</b></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_sale'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td></td>
    </tr>
    <?php endif; ?>

    <!-- 最後のループ以外 -->
    <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) != true): ?>

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
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sale_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 2, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 2, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['accumulated_sale'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['accumulated_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 2, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 2, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
</td>
        <!-- 区分 -->
        <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] != NULL): ?>
        <td bgcolor="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['bgcolor']; ?>
" align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['span']; ?>
">
            <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank']; ?>
<br>
            <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank_rate']; ?>

        </td>
        <?php endif; ?>
    </tr>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>

        </td>
    </tr>
</table>
<?php endif; ?>
<!-- 表示ボタン押下 END -->

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
