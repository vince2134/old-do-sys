<?php /* Smarty version 2.6.14, created on 2010-04-05 15:53:45
         compiled from 1-4-115.php.tpl */ ?>
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
<?php if ($this->_tpl_vars['form']['form_build_day_s']['error'] != null): ?>
<li><?php echo $this->_tpl_vars['form']['form_build_day_s']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_build_day_e']['error'] != null): ?>
<li><?php echo $this->_tpl_vars['form']['form_build_day_e']['error']; ?>
<br>
<?php endif; ?>
</span>

<table width="750">
    <tr>
        <td>

<table class="Data_Table" border="1"width="650">
<col width="150" style="font-weight: bold;">
<col width="150">
<col width="150" style="font-weight: bold;">
<col width="200">
    <tr>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_build_no']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_build_no']['html']; ?>
</td>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_build_day_s']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_build_day_s']['html']; ?>
　〜　<?php echo $this->_tpl_vars['form']['form_build_day_e']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_goods_cd']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_goods_name']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_output_ware_id']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_ware_id']['html']; ?>
</td>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_input_ware_id']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_input_ware_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow"><?php echo $this->_tpl_vars['form']['form_select_count']['label']; ?>
</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_select_count']['html']; ?>
</td>
    </tr>
</table>

<table width="650">
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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
<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
</span>
<br>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">組立管理番号</td>
        <td class="Title_Yellow">組立日</td>
        <td class="Title_Yellow">完成品コード</td>
        <td class="Title_Yellow">完成品名</td>
        <td class="Title_Yellow">引落倉庫名</td>
        <td class="Title_Yellow">入庫倉庫名</td>
        <td class="Title_Yellow">組立数</td>
    </tr>
    <?php $_from = $this->_tpl_vars['build_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['color']; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['build_cd']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['build_day']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['goods_cd']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['goods_name']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['output_ware_name']; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['input_ware_name']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['build_data'][$this->_tpl_vars['i']]['build_num']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


        </td>
    </tr>
</table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
