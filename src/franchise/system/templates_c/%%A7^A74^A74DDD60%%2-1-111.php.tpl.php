<?php /* Smarty version 2.6.14, created on 2010-05-13 17:15:24
         compiled from 2-1-111.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-1-111.php.tpl', 133, false),)), $this); ?>
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="850">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
        <td class="Title_Purple">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_show_page']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Purple">得意先名・略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
    <tr>
        <td class="Title_Purple">代行業者コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trust']['html']; ?>
</td>
        <td class="Title_Purple">代行業者名・略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trust_name']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">契約担当者1</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_id1']['html']; ?>
</td>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_con_staff']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">契約状態</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
</table>

<table width="850" >
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_button']['show_button']['html']; ?>
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


<?php if ($_POST['form_show_page'] != 2):  echo $this->_tpl_vars['var']['html_page']; ?>

<?php else: ?>
全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<?php endif; ?>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_area'), $this);?>
</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_staff_cd'), $this);?>
</td>
        <td class="Title_Purple">契約状態</td>
        <td class="Title_Purple">巡回担当者</td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
        <td class="Title_Purple">代行先コード<br>代行先名</td>
    <?php endif; ?>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
                        <?php if ($_POST['form_button']['show_button'] == "表　示"): ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

                        <?php elseif ($this->_tpl_vars['var']['page_change'] == true): ?>
                <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-199; ?>

            <?php elseif ($_POST['form_show_page'] != 2 && $_POST['f_page1'] != ""): ?>
                <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>               
        <td>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['client_cd1']; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['client_cd2']; ?>
<br>
            <a href="2-1-115.php?client_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['client_id']; ?>
&get_flg=con"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['client_name']; ?>
</a></td>
        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['client_cname']; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['area_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['tel']; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['charge_cd']; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['staff_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['state']; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['staff2']; ?>
</td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']]['trust']; ?>
</td>
    <?php endif; ?>
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
