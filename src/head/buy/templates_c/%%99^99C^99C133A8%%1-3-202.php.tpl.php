<?php /* Smarty version 2.6.14, created on 2009-12-28 19:08:19
         compiled from 1-3-202.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '1-3-202.php.tpl', 81, false),array('modifier', 'date_format', '1-3-202.php.tpl', 146, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_delete']; ?>

<?php echo $this->_tpl_vars['var']['hidden_submit']; ?>

 </script>

<body bgcolor="#D8D0C8" <?php echo $this->_tpl_vars['var']['javascript']; ?>
>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

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
<?php if ($this->_tpl_vars['form']['err_renew_slip']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_renew_slip']['error']; ?>
<br>
<?php endif; ?>

<?php if ($this->_tpl_vars['form']['form_c_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_c_staff']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_buy_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_buy_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_buy_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_buy_amount']['error']; ?>
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

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>Âå¹ÔÇä¾å¡¦¾Ò²ðÇä¾å¤Ï»ÅÆþ¶â³Û¤ò³ÎÄê¤¹¤ëº¬µò¤È¤Ê¤ëÃÍ¤Ç¤¹¡£</li>
</span>
<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_buy_day'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_input_day'), $this);?>
<br>
        </td>
        <td class="Title_Blue">»ÅÆþ¶â³Û<br>(ÀÇÈ´)</td>
        <td class="Title_Blue">¾ÃÈñÀÇ³Û</td>
        <td class="Title_Blue">»ÅÆþ¶â³Û<br>(ÀÇ¹þ)</td>
        <td class="Title_Act">Âå¹ÔÇä¾å</td>
        <td class="Title_Act">¾Ò²ðÇä¾å</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_no'), $this);?>
</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_day'), $this);?>
</td>
        <td class="Title_Blue">¼è°ú¶èÊ¬</td>
        <td class="Title_Blue">Ê¬³ä²ó¿ô</td>
        <td class="Title_Blue">Æü¼¡¹¹¿·</td>
        <td class="Title_Blue">ºï½ü</td>
    </tr>
    <tr class="Result3">
        <td><b>¹ç·×</b></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['row_count']; ?>
·ï</td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_notax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_notax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum1']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_tax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_tax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum2']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_ontax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_ontax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum3']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_act_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_act_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum4']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_intro_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_intro_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum5']; ?>
<br></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <?php if (bcmod ( $this->_tpl_vars['j'] , 2 ) == 0): ?>
    <tr class="Result1">
    <?php else: ?>  
    <tr class="Result2">
    <?php endif; ?>  
        <td align="right">
            <?php echo $this->_tpl_vars['var']['no']+$this->_tpl_vars['j']; ?>

        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="center">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 't' || $this->_tpl_vars['row'][$this->_tpl_vars['j']][18] == 't'): ?>
                <a href="1-3-205.php?buy_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a>
            <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][17] == '1'): ?>
                <a href="1-3-201.php?buy_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a>
            <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][17] == '2'): ?>
                <a href="1-3-207.php?buy_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a>
            <?php endif; ?>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
<br><?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][16])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
        <td align="right">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] < 0): ?><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</font>
            <?php else:  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</font><?php endif; ?>
        </td>
        <td align="right">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] < 0): ?><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</font>
            <?php else:  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7];  endif; ?>
        </td>
        <td align="right">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][8] < 0): ?><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</font>
            <?php else:  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8];  endif; ?>
        </td>
        <td align="right">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][19] < 0): ?><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][19]; ?>
</font>
            <?php else:  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][19];  endif; ?>
        </td>
        <td align="right">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][20] < 0): ?><font color="#ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][20]; ?>
</font>
            <?php else:  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][20];  endif; ?>
        </td>
        <td align="center"><a href="1-3-103.php?ord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == "³äÉê»ÅÆþ"): ?>
        <td align="right"><a href="1-3-206.php?buy_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
&division_flg=true"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
²ó</a></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
        <td align="center">
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>

        </td>
        <td align="center">
                            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][18] == 'f' && ( ( $this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] != NULL ) || ( $this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] == NULL ) )): ?>
                <?php if ($this->_tpl_vars['var']['auth'] == 'w'): ?>
                <a href="#" onClick="Order_Delete<?php echo $this->_tpl_vars['j']; ?>
('data_delete_flg','buy_h_id','<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
','hdn_del_enter_date','<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][16]; ?>
');">ºï½ü</a>
                <?php endif; ?>
            <?php endif; ?>
        </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3">
        <td><b>¹ç·×</b></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['row_count']; ?>
·ï</td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_notax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_notax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum1']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_tax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_tax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum2']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_ontax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_ontax_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum3']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_act_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_act_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum4']; ?>
<br></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['gross_intro_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['minus_intro_amount']; ?>
<br><?php echo $this->_tpl_vars['var']['sum5']; ?>
<br></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="500" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
    <tr class="Result1">
        <td class="Title_Pink">Çã³Ý¶â³Û</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['kake_nuki_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['kake_nuki_amount']; ?>
</td>
        <td class="Title_Pink">Çã³Ý¾ÃÈñÀÇ</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['kake_tax_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['kake_tax_amount']; ?>
</td>
        <td class="Title_Pink">Çã³Ý¹ç·×</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['kake_komi_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['kake_komi_amount']; ?>
</td>
    </tr>   
    <tr class="Result1">
        <td class="Title_Pink">¸½¶â¶â³Û</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['genkin_nuki_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['genkin_nuki_amount']; ?>
</td>
        <td class="Title_Pink">¸½¶â¾ÃÈñÀÇ</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['genkin_tax_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['genkin_tax_amount']; ?>
</td>
        <td class="Title_Pink">¸½¶â¹ç·×</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['genkin_komi_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['genkin_komi_amount']; ?>
</td>
    </tr>   
    <tr class="Result1">
        <td class="Title_Pink">ÀÇÈ´¹ç·×</td>
        <td align="right"<?php if ($this->_tpl_vars['var']['total_nuki_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['total_nuki_amount']; ?>
</td>
        <td class="Title_Pink">¾ÃÈñÀÇ¹ç·×</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['total_tax_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['total_tax_amount']; ?>
</td>
        <td class="Title_Pink">ÀÇ¹þ¹ç·×</td> 
        <td align="right"<?php if ($this->_tpl_vars['var']['total_komi_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['var']['total_komi_amount']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

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
