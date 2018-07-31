<?php /* Smarty version 2.6.14, created on 2009-12-21 13:37:30
         compiled from 1-2-102.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '1-2-102.php.tpl', 67, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_cancel']; ?>

 </script>

<body bgcolor="#D8D0C8">
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
<?php if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
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

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Act"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_fc_ord_day'), $this);?>
</td>
        <td class="Title_Act"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_fc_ord_no'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_direct'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_hope_day'), $this);?>
</td>
        <td class="Title_Pink">商品</td>
        <td class="Title_Pink">単価</td>
        <td class="Title_Pink">数量</td>
        <td class="Title_Pink">合計金額</td>
        <td class="Title_Pink">通信欄<br>（本部宛）<br></td>
        <td class="Title_Pink">出荷予定日<br>返信<font color="#ff0000">※</font></td>
        <td class="Title_Pink">取消</td>
    </tr>
    <?php echo $this->_tpl_vars['html']['html_l']; ?>

</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<font color="#ff0000"><b>※は必須入力です</b></font>

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
