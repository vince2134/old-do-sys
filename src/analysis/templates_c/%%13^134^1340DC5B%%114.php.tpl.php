<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:28
         compiled from 114.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'Plug_Minus_Numformat', '114.php.tpl', 152, false),array('modifier', 'escape', '114.php.tpl', 165, false),array('modifier', 'Plug_Unit_Add', '114.php.tpl', 167, false),array('function', 'cycle', '114.php.tpl', 163, false),)), $this); ?>

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
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
    <li><?php echo $this->_tpl_vars['message']; ?>
<br />
<?php endforeach; endif; unset($_from); ?>
</span>

<table>
    <tr>
        <td>

                        <table width="100%">
                <tr style="color: #555555;">
                    <td align="right"><b>出力形式</b> <?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
                </tr>
            </table>

                        <table class="Data_Table" border="1" width="100%">
                <col width="100px" class="bold">
                <col width="600px">
                <tr>
                    <td class="Title_Gray">集計期間<span class="required">※</span></td>
                    <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html']; ?>
 から <?php echo $this->_tpl_vars['form']['form_trade_ym_e_abc']['html']; ?>
</td>
                </tr>
                                <?php if ($_SESSION['group_kind'] !== '1'): ?>
                <tr>
                    <td class="Title_Gray">所属本支店</td>
                    <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_branch']['html']; ?>
</td>
                </tr>
                <tr>
                    <td class="Title_Gray">部署</td>
                    <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_part']['html']; ?>
</td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="Title_Gray">表示対象</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
                </tr>
                                <?php if ($_SESSION['group_kind'] === '1'): ?>
                <tr>
                    <td class="Title_Gray">抽出対象</td>
                    <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_out_abstract']['html']; ?>
</td>
                </tr>
                <?php endif; ?>
            </table>

                        <table width="100%">
                <tr>
                    <td class="required">※は必須入力です</td>
                    <td align="right"><?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
</td>
                </tr>
            </table>

        </td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['out_flg'] === true): ?>

<table width="100%">
    <tr>
        <td>

            <table class="List_Table" border="1" width="100%">

                    <tr class="bold" align="center">
                    <td class="Title_Gray">順位</td>
                    <td class="Title_Gray">担当者</td>
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

                        <?php if (($this->_foreach['data']['iteration'] <= 1) || ($this->_foreach['data']['iteration'] == $this->_foreach['data']['total'])): ?>
                <tr class="Result3">
                    <td align="center" class="bold">合計</td>
                    <td align="center" class="bold"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['count'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
人</td>
                    <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_sale'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center"></td>
                </tr>
            <?php endif; ?>

                        <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) != true): ?>
                <tr class="<?php echo smarty_function_cycle(array('values' => "Result1, Result2"), $this);?>
">
                    <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['cd']; ?>
<br /><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br /></td>
                    <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
                    <td align="right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sale_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 2, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 2, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
</td>
                    <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['accumulated_sale'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
</td>
                    <td align="right"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['accumulated_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 2, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 2, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
</td>
                                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] != null): ?>
                    <!-- aizawa-m 背景色変更のためコメント
                    <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] == 'A'):  $this->assign('abc_bgcolor', "#a8d3ff");  endif; ?>
                    <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] == 'B'):  $this->assign('abc_bgcolor', "#ffffa8");  endif; ?>
                    <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank'] == 'C'):  $this->assign('abc_bgcolor', "#ffa8d3");  endif; ?>
                    <td bgcolor="<?php echo $this->_tpl_vars['abc_bgcolor']; ?>
" align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['span']; ?>
">
-->
                    <td bgcolor="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['bgcolor']; ?>
" align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['span']; ?>
">
                        <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank']; ?>
<br />
                        <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rank_rate']; ?>
<br />
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

