<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:15
         compiled from 101.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'Plug_Minus_Numformat', '101.php.tpl', 138, false),array('modifier', 'Plug_Unit_Add', '101.php.tpl', 141, false),array('modifier', 'escape', '101.php.tpl', 168, false),)), $this); ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


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
        <td width="650" style="color: #555555;"><b>½ÐÎÏ·Á¼°</b></td>
        <td><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>
<table  class="Data_Table" border="1" width="750" >

    <tr>
        <td class="Title_Gray"width="100"><b>½¸·×´ü´Ö</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade_ym_s']['html'];  echo $this->_tpl_vars['form']['form_trade_ym_e']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>¾¦ÉÊ</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>£Í¶èÊ¬</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>´ÉÍý¶èÊ¬</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>¾¦ÉÊÊ¬Îà</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>ÁÆÍøÎ¨</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_margin']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>É½¼¨ÂÐ¾Ý</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_out_range']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>Ãê½ÐÂÐ¾Ý</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_out_abstract']['html']; ?>
</td>
    </tr>

</table>
<table width='750'>
    <tr>
        <td align="left"><font color="red"><b>¢¨¤ÏÉ¬¿ÜÆþÎÏ¤Ç¤¹</b></font></td>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>

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
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">¾¦ÉÊ</td>
        <td class="Title_Gray" align="center"></td>
        <?php $_from = $this->_tpl_vars['disp_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['date']):
?>
        <td class="Title_Gray" align="center"><?php echo $this->_tpl_vars['disp_head'][$this->_tpl_vars['i']]; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
        <td class="Title_Gray" align="center">·î¹ç·×</td> 
        <td class="Title_Gray" align="center">·îÊ¿¶Ñ</td> 
    </tr>   

   

<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>

        <?php $this->assign('last', ($this->_foreach['data']['total']-1)); ?>

     
    <?php if (($this->_foreach['data']['iteration'] <= 1) || ($this->_foreach['data']['iteration'] == $this->_foreach['data']['total'])): ?>
    <tr class="Result3">
        <td align="left"><b>¹ç·×</b></td>
        <td align="left"><b><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_count']; ?>
·ï</b></td>
        <td align="left"><b>
            Çä¾å¿ô<br>
            Çä¾å¶â³Û<br>
            ÁÆÍø±×³Û<br>
        <?php if ($this->_tpl_vars['var']['margin_flg'] == true): ?>
            ÁÆÍøÎ¨
        <?php endif; ?>
        </b></td>
         
        <?php $_from = $this->_tpl_vars['disp_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
        <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_num'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_arari_gaku'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['total_arari_rate'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
        <?php endforeach; endif; unset($_from); ?>
        <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_num'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
        <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['sum']['ave_num'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['last']]['ave_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
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
        <td align="left"><b>
                Çä¾å¿ô<br>
                Çä¾å¶â³Û<br>
                ÁÆÍø±×³Û<br>
        <?php if ($this->_tpl_vars['var']['margin_flg'] == true): ?>
                ÁÆÍøÎ¨
        <?php endif; ?>
        </b></td> 
         
        <?php $_from = $this->_tpl_vars['disp_head']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['money']):
?>
        <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['num'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['net_amount'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['arari_gaku'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['arari_rate'][$this->_tpl_vars['j']])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
        <?php endforeach; endif; unset($_from); ?>
                <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_num'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['sum_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
                <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_num'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_net_amount'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_arari_gaku'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp) : smarty_modifier_Plug_Minus_Numformat($_tmp)); ?>
<br>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['ave_arari_rate'])) ? $this->_run_mod_handler('Plug_Minus_Numformat', true, $_tmp, 0, true) : smarty_modifier_Plug_Minus_Numformat($_tmp, 0, true)))) ? $this->_run_mod_handler('Plug_Unit_Add', true, $_tmp, "%") : smarty_modifier_Plug_Unit_Add($_tmp, "%")); ?>

        </td>
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

    
