<?php /* Smarty version 2.6.14, created on 2009-12-25 19:26:57
         compiled from 2-3-106.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-3-106.php.tpl', 69, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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
<?php if ($this->_tpl_vars['form']['err_non_check']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['err_non_check']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_non_buy']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['err_non_buy']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_bought_slip']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['err_bought_slip']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_non_reason']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['err_non_reason']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['err_valid_data']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['err_valid_data']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_c_staff']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_c_staff']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_arrival_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_arrival_day']['error']; ?>
<br><?php endif; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_day'), $this);?>
</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_no'), $this);?>
</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_hope_day'), $this);?>
</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_arrival_day'), $this);?>
</td>
        <td class="Title_Blue">商品</td>
        <td class="Title_Blue">発注数</td>
        <td class="Title_Blue">入荷数</td>
        <td class="Title_Blue">発注残</td>
        <td class="Title_Blue">仕入倉庫</td>
        <td class="Title_Blue">仕入入力</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['form_ord_comp_check']['html']; ?>
</td>
    </tr>
    <?php echo $this->_tpl_vars['html']['html_l']; ?>

    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center"><b><font color="#ff0000">チェックを付けた商品の理由は必須です</font></b><br><?php echo $this->_tpl_vars['form']['ord_comp_button']['html']; ?>
</td>
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
