<?php /* Smarty version 2.6.14, created on 2010-03-23 19:15:08
         compiled from 132.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '132.php.tpl', 138, false),array('modifier', 'Plug_Minus_Numformat', '132.php.tpl', 190, false),array('modifier', 'Plug_Unit_Add', '132.php.tpl', 194, false),)), $this); ?>

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
        <td align="right"><b>½ÐÎÏ·Á¼°</b> <?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

<table class="Data_Table" border="1" width="100%">
<?php if ($_SESSION['group_kind'] === '1'): ?>
<col width="120px" class="bold">
<?php else: ?>
<col width=" 80px" class="bold">
<?php endif; ?>
<col width="300px">
<col width=" 80px" class="bold">
<col width="300px">
    <tr>
        <td class="Title_Gray">½¸·×´ü´Ö<span class="required">¢¨</span></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html']; ?>
 ¤«¤é <?php echo $this->_tpl_vars['form']['form_trade_ym_e']['html']; ?>
</td>
    </tr>
    <tr>
                <?php if ($_SESSION['group_kind'] === '1'): ?>
        <td class="Title_Gray">¥·¥ç¥Ã¥×¡¦Éô½ð</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_shop_part']['html']; ?>
</td>
                <?php else: ?>
        <td class="Title_Gray">Éô½ð</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_part']['html']; ?>
</td>
        <td class="Title_Gray">Ã´Åö¼Ô</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
    <tr>
        <td class="Title_Gray">ÁÆÍøÎ¨</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_margin']['html']; ?>
</td>
        <td class="Title_Gray">É½¼¨ÂÐ¾Ý</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td class="required">¢¨¤ÏÉ¬¿ÜÆþÎÏ¤Ç¤¹</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br />

                    </td>
                </tr>
                <tr>
                    <td>


<?php if ($this->_tpl_vars['out_flg'] === 'true'): ?>

<table width="100%">
    <tr>
        <td>

                        <?php if ($_SESSION['group_kind'] === '1'): ?>
            <span style="font: bold 15px; color: #555555;"><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_data'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span><br />
            <?php endif; ?>

            <table class="List_Table" border="1" width="100%">

    
                <tr class="bold" align="center">
                    <td class="Title_Gray">No.</td>
                    <td class="Title_Gray">Éô½ð</td>
                    <td class="Title_Gray">Ã´Åö¼Ô</td>
                    <td class="Title_Gray"></td>
                                        <?php $_from = $this->_tpl_vars['disp_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['ym']):
?>
                    <td class="Title_Gray"><?php echo $this->_tpl_vars['ym']; ?>
</td>
                    <?php endforeach; endif; unset($_from); ?>
                    <td class="Title_Gray">·î¹ç·×</td>
                    <td class="Title_Gray">·îÊ¿¶Ñ</td>
                </tr>

    
    
        <?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>

        
                        <?php if (($this->_foreach['data']['iteration'] <= 1) || ($this->_foreach['data']['iteration'] == $this->_foreach['data']['total'])): ?>

                                <?php $this->assign('last', ($this->_foreach['data']['total']-1)); ?>

                <tr class="Result4">
                    <td align="center" class="bold">¹ç·×</td>
                    <td align="center" class="bold"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_count']; ?>
Éô½ð</td>
                    <td></td>
                    <td class="bold">
                        Çä¾å¶â³Û<br />
                        ÁÆÍø±×³Û<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        ÁÆÍøÎ¨<br />
                        <?php endif; ?>
                    </td>

                                <?php $_from = $this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_net_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_arari_gaku'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_arari_rate'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>
                <?php endforeach; endif; unset($_from); ?>

                                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>

                                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>

                </tr>

            <?php endif; ?>

        
        
                        <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) !== true && ( $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sub_flg'] === '1' || $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sub_flg'] === '2' )): ?>

                <?php if (!(!(1 & $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sub_flg']))): ?>
                <tr class="Result1">
                <?php else: ?>
                <tr class="Result2">
                <?php endif; ?>
                                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rowspan'] !== null): ?>
                    <td align="right" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rowspan']; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
                    <td rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['rowspan']; ?>
">
                        <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['cd']; ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br />
                    </td>
                <?php endif; ?>
                    <td>
                        <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['cd2']; ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['name2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br />
                    </td>
                    <td class="bold">
                        Çä¾å¶â³Û<br />
                        ÁÆÍø±×³Û<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        ÁÆÍøÎ¨<br />
                        <?php endif; ?>
                    </td>

                        <?php elseif (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) !== true && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sub_flg'] === 'true'): ?>

                <tr class="Result3">
                    <td align="center" class="bold">¾®·×</td>
                    <td class="bold">
                        Çä¾å¶â³Û<br />
                        ÁÆÍø±×³Û<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        ÁÆÍøÎ¨<br />
                        <?php endif; ?>
                    </td>

            <?php endif; ?>


                        <?php if (($this->_foreach['data']['iteration'] == $this->_foreach['data']['total']) !== true): ?>

                                <?php $_from = $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['arari_gaku'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['arari_rate'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>
                <?php endforeach; endif; unset($_from); ?>

                                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>

                                    <td align="right">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br />
                                                <?php if ($_POST['form_margin'] === '1'): ?>
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>
<br />
                        <?php endif; ?>
                    </td>

                </tr>

            <?php endif; ?>

        
    <?php endforeach; endif; unset($_from); ?>

    
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

