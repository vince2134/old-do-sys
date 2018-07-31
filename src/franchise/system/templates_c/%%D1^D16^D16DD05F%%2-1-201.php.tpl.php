<?php /* Smarty version 2.6.14, created on 2010-04-05 16:02:18
         compiled from 2-1-201.php.tpl */ ?>
<?php echo $this->_tpl_vars['form']['javascript']; ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body class="bgimg_purple">
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


<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;"><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
</span><br><br>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['qf_err_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_part_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_part_cd']['error']; ?>
<br><?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_part_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_part_name']['error']; ?>
<br><?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_branch_id']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_branch_id']['error']; ?>
<br><?php endif; ?>
    </span><br>
<?php endif; ?>


<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_part_cd']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_part_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_part_name']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_part_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_branch_id']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_branch_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_note']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
    <?php if ($_SESSION['part_permit'] == 'w'): ?>
        <td style="color: #ff0000; font-weight: bold;">※は必須入力です</td>
        
    <?php endif; ?>
    </tr>
    <tr>
        <td><?php if ($this->_tpl_vars['var']['get_part_id'] != NULL):  echo $this->_tpl_vars['form']['del_button']['html'];  endif; ?><td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_btn_gr']['form_btn_add']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_btn_gr']['form_btn_clear']['html']; ?>
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

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　　<?php echo $this->_tpl_vars['form']['form_btn_gr']['form_btn_csv_out']['html']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_part_cd']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_part_name']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_branch_id']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_note']['label']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['ary_list_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1"> 
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><a href="?id=<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php echo $this->_tpl_vars['form']['hidden']; ?>

    </form>
</table>

        </td>
    </tr>
</table>

                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
