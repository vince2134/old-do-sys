<?php /* Smarty version 2.6.14, created on 2010-05-13 13:07:42
         compiled from 1-1-101.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '1-1-101.php.tpl', 124, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script>
<?php echo $this->_tpl_vars['var']['javascript']; ?>

</script>
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>


<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップ名/社名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC・取引先区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="350">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_button']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_button']['clear_button']['html']; ?>
</td>
    </tr>
</table>

<br>


                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>

<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" valign="bottom" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_shop_name'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_rank'), $this);?>
</td>
        <td class="Title_Purple"> <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_area'), $this);?>
</td>
        <td class="Title_Purple">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_claim_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_claim_name'), $this);?>
<br>
        </td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_staff'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_tel'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_day'), $this);?>
</td>
        <td class="Title_Purple">状　態</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['label_check_all']['html']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
            <?php if ($_POST['f_page1'] != null): ?>
                <?php echo $_POST['f_page1']*10+$this->_tpl_vars['j']-9; ?>

            <?php else: ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>               
        <td>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
<br>
            <a href="1-1-103.php?client_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a></td>
        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == 1): ?>
            取引中
        <?php else: ?>
            解約・休止中
        <?php endif; ?>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_label_check'][$this->_tpl_vars['j']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result2">
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
        <td align="center" colspan="2"><?php echo $this->_tpl_vars['form']['form_label_button']['html']; ?>
</td>
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
