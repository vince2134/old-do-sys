<?php /* Smarty version 2.6.14, created on 2009-12-21 14:42:07
         compiled from 1-2-105.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '1-2-105.php.tpl', 78, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_delete']; ?>

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
<?php if ($this->_tpl_vars['form']['err_saled_slip']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_saled_slip']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_c_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_c_staff']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_aord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_aord_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_arrival_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_arrival_day']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_s']; ?>
</td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<li>発注番号があるものはオンライン受注です</li>
</span>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_aord_no'), $this);?>
</td>
        <td class="Title_Act"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_no'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_direct'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_aord_day'), $this);?>
</td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink">受注金額</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_hope_day'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_arrival_day'), $this);?>
</td>
        <td class="Title_Pink">売上入力</td>
        <td class="Title_Pink">削除</td>
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
                <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 't' && ( $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '1' || $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '2' )): ?>
            <td align="center"><a href="1-2-110.php?aord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
                <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 'f' && ( $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '1' || $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '2' )): ?>
            <td align="center"><a href="1-2-101.php?aord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
                <?php else: ?>
            <td align="center"><a href="1-2-108.php?aord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <?php endif; ?>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][18]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
                <?php if (( $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '1' || $this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == '2' )): ?>
        <td align="center" class="color">
            <a href="1-2-201.php?aord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
">入力</a>
        </td>
        <?php else: ?>
        <td align="center">
            済
        </td>
        <?php endif; ?>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][12] == 1 && $this->_tpl_vars['var']['disabled'] == NULL && $this->_tpl_vars['row'][$this->_tpl_vars['j']][17] == null): ?>
            <a href="#" onClick="Order_Delete('data_delete_flg','aord_id_flg',<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,'hdn_del_enter_date','<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][16]; ?>
');">削除</a>
        <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" align="center">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><?php echo $this->_tpl_vars['var']['total_price']; ?>
</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<table>
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
    </tr>
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
