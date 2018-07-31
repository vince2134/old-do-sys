<?php /* Smarty version 2.6.14, created on 2010-05-13 13:33:18
         compiled from 1-1-113.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '1-1-113.php.tpl', 111, false),)), $this); ?>
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

<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
        <td class="Title_Purple">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_show_page']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop']['html']; ?>
</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC・取引先区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>
</td>
        <td class="Title_Purple">ショップ 状態</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_state_type_s']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Purple" width="115">得意先名・略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">業種</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
        <td class="Title_Purple">得意先 状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>

    </tr>

</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_button']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_button']['clear_button']['html']; ?>
</td>
    </tr>
</table>

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
    <b style="font-size: 15px; color: #555555;">【得意先 状態： <?php echo $this->_tpl_vars['var']['state_type']; ?>
】</b>
    <?php echo $this->_tpl_vars['var']['html_page']; ?>


<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;" nowrap>
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_rank'), $this);?>
</td>
        <td class="Title_Purple">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_shop_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_shop_name'), $this);?>
<br>
        </td>
        <td class="Title_Purple">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">TEL</td>
        <?php if ($_POST['form_state_type'] == '4'): ?>
        <td class="Title_Purple">状態</td>
        <?php endif; ?>
        <td class="Title_Purple">請求先コード<br>請求先</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class=<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['j']]; ?>
> 
        <td align="right">
			<?php if ($_POST['form_button']['show_button'] == "表　示"): ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php elseif ($_POST['form_show_page'] != 2 && $_POST['f_page1'] != ""): ?>
                <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

            <?php else: ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][20]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td align="left">
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
<br>
            <a href = "1-1-115.php?client_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</a></td>
        </td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <?php if ($_POST['form_state_type'] == '4'): ?>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][7] == 1): ?>
            取引中
        <?php else: ?>
            休止中
        <?php endif; ?>
        </td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
<br>
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][16] != ''): ?>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][16]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][17]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][18]; ?>

        <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>

</table>
<?php if ($_POST['form_show_page'] != 2):  echo $this->_tpl_vars['var']['html_page2']; ?>

<?php endif; ?>

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
