<?php /* Smarty version 2.6.14, created on 2009-12-25 19:26:58
         compiled from 2-3-104.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-3-104.php.tpl', 74, false),array('modifier', 'number_format', '2-3-104.php.tpl', 126, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['html']['js']; ?>

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
<?php if ($this->_tpl_vars['form']['form_c_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_c_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['err_bought_slip']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_bought_slip']['error']; ?>

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
         ※発注書印刷についてはオンラインは必要ありません。
    </span>
<?php echo $this->_tpl_vars['html']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_ord_day'), $this);?>
</td>
        <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</td>
        <td class="Title_Blue">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Blue">本部確認</td>
        <td class="Title_Blue">発注金額</td>
                <td class="Title_Blue"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_hope_day'), $this);?>
</td>
        <td class="Title_Blue">通信欄<br>（ＦＣ宛）</td>
        <td class="Title_Blue">仕入完了</td>
        <td class="Title_Blue">削除</td>
        <td class="Title_Blue">発注書印刷</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <?php if (!(1 & $this->_tpl_vars['j'])): ?>
    <tr class="Result1"> 
    <?php else: ?>
    <tr class="Result2">
    <?php endif; ?>
        <td align="right">
            <?php echo $this->_tpl_vars['var']['no']+$this->_tpl_vars['j']+1; ?>

        </td>
                <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] != null):  echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2];  endif; ?></td>
             
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '3' || ( $this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == null && $this->_tpl_vars['row'][$this->_tpl_vars['j']][8] == '1' ) && $this->_tpl_vars['row'][$this->_tpl_vars['j']][14] == 'f'): ?>
                <td align="center"><a href="2-3-102.php?ord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a></td>
            <?php else: ?>
                <td align="center"><a href="2-3-103.php?ord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
&ord_flg=true"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a></td>
            <?php endif; ?>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][11]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '1'): ?>
        <td align="center">
                <font color="#ff0000">未確認</font>
        </td>
            <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '2'): ?>
        <td align="center">
                済
        </td>
            <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '3'): ?>
        <td align="center">
                <font color="#008000">取消</font>
        </td>
            <?php else: ?>
        <td align="center">
                ----
        </td>
            <?php endif; ?>
        <td align="right">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['row'][$this->_tpl_vars['j']][6])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>

        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][16]; ?>
</td>
        <td align="center">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][8] == 3 || $this->_tpl_vars['row'][$this->_tpl_vars['j']][8] == 4): ?>
                済
            <?php else: ?>
                <font color="#ff0000">未</font>
            <?php endif; ?>
        </td>
        <td align="center">
            <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '3' || $this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == null && $this->_tpl_vars['row'][$this->_tpl_vars['j']][8] == '1'): ?>
                <?php if ($this->_tpl_vars['var']['auth'] == 'w'): ?><a href="#" onClick="Order_Delete('data_delete_flg','ord_id_flg',<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,'hdn_del_enter_date','<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
');">削除</a><?php endif; ?>
            <?php endif; ?>
        </td>
        <td align="center">
                        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] == 't' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][5] != '3' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] == 't'): ?>
                <?php if ($this->_tpl_vars['var']['auth'] == 'w'): ?><a href="#" onClick="window.open('../../franchise/buy/2-3-105.php?ord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
','_blank','');">印刷</a><?php endif; ?>

                        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] == 't' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] == 'f'): ?>
                <?php if ($this->_tpl_vars['var']['auth'] == 'w'): ?> <a href="#" onClick="window.open('../../franchise/buy/2-3-107.php?ord_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
','_blank','');">印刷</a><?php endif; ?>

                        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][5] != '3' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] == 't'): ?>
                <a href="#" onClick="Order_Sheet('order_sheet_flg','ord_id_flg',2,<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
);">印刷</a>

                        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] == 'f' && $this->_tpl_vars['row'][$this->_tpl_vars['j']][10] == 'f'): ?>
                <a href="#" onClick="Order_Sheet('order_sheet_flg','ord_id_flg',1,<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
);">印刷</a>

                        <?php else: ?>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['html']['html_page2']; ?>


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
