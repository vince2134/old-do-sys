<?php /* Smarty version 2.6.14, created on 2010-04-05 14:37:35
         compiled from 2-2-412.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-2-412.php.tpl', 69, false),array('modifier', 'number_format', '2-2-412.php.tpl', 107, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<!--
<?php echo $this->_tpl_vars['html']['js']; ?>

-->
</script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['errors'] != null): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
    <li><?php echo $this->_tpl_vars['errors']; ?>
</li><br>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
</span>
<?php endif; ?>

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
        <td><?php echo $this->_tpl_vars['html']['html_page']; ?>
</td>
    </tr>
    <tr>
        <td>

<table class="List_Table" width="100%" border="1">
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
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_staff'), $this);?>
</td>
        <td class="Title_Pink">¶â³Û</td>
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
        <td class="Title_Pink">ºï½ü</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['form_fix_all']['html']; ?>
</td>
    </tr>
    <?php echo $this->_tpl_vars['html']['html_l']; ?>

    <tr class="Result3">
        <td><b>¹ç·×</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"<?php if ($this->_tpl_vars['var']['sum_amount'] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['sum_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_fix_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_page2']; ?>
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
