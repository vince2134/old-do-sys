<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:23
         compiled from 110.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'Plug_Minus_Numformat', '110.php.tpl', 132, false),array('modifier', 'escape', '110.php.tpl', 150, false),array('modifier', 'Plug_Unit_Add', '110.php.tpl', 152, false),)), $this); ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<style TYPE="text/css">
<!--
.required {
    font-weight: bold;
    color: #ff0000;
    }
.bold {
    font-weight: bold;
    }
-->
</style>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="left">

                <td valign="top">

            <table border=0 >
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
    <li><?php echo $this->_tpl_vars['message']; ?>
<br>
<?php endforeach; endif; unset($_from); ?>
</span>
<table width="750">
    <tr align="right">
        <td width="650" style="color: #555555;"><b>出力形式</b></td>
        <td><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>
<table  class="Data_Table" border="1" width="750" >

    <tr>
        <td class="Title_Gray"width="100"><b>集計期間</b><span class="required">※</span></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html']; ?>
 から <?php echo $this->_tpl_vars['form']['form_trade_ym_e_abc']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>Ｍ区分</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>管理区分</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>商品分類</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>表示対象</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
    </tr>

        <?php if ($_SESSION['group_kind'] == '1'): ?>
    <tr>
        <td class="Title_Gray" width="100"><b>抽出対象</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_out_abstract']['html']; ?>
</td>
    </tr>
    <?php endif; ?>

</table>
<table width='750'>
    <tr>
        <td align="left"><font color="red"><b>※は必須入力です</b></font></td>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>

        </td>
    </tr>
</table>

                    <br>
                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['disp_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">順位</td>
        <td class="Title_Gray" align="center">商品</td>
        <td class="Title_Gray" align="center">売上金額</td>
        <td class="Title_Gray" align="center">構成比</td>
        <td class="Title_Gray" align="center">累積金額</td> 
        <td class="Title_Gray" align="center">累積構成比</td> 
        <td class="Title_Gray" align="center">区分</td> 
    </tr>   

<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>

        <?php $this->assign('last', ($this->_foreach['data']['total']-1)); ?>

     
    <?php if (($this->_foreach['data']['iteration'] <= 1) || ($this->_foreach['data']['iteration'] == $this->_foreach['data']['total'])): ?>
    <tr class="Result3">
        <td align="left" height="30px"><b>合計</b></td>
        <td align="left"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['count'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
商品</b></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_sale'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <?php endif; ?>

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
                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] != null): ?>

<!-- aizawa_m 背景色変更のためコメント
        <td bgcolor="#FFFFFF" align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['span']; ?>
">
-->
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


                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
