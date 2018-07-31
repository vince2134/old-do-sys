<?php /* Smarty version 2.6.14, created on 2009-12-22 13:32:28
         compiled from 2-1-200.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<SCRIPT>
<!--

<?php echo '
function Change_Data(id) {
	document.forms[0].update_button.value="変更前";
	document.forms[0].branch_id.value=id;
	document.forms[0].submit();
}
'; ?>


<?php echo $this->_tpl_vars['var']['js']; ?>


//-->
</SCRIPT>


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

<?php if ($this->_tpl_vars['var']['mesg'] != NULL): ?>
	<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
		<li><?php echo $this->_tpl_vars['var']['mesg']; ?>
</li><BR>
	</span>
<?php endif; ?>

<?php if ($this->_tpl_vars['errors'] != NULL): ?>
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		<?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
		<li><?php echo $this->_tpl_vars['errors']; ?>
</li><BR>
		<?php endforeach; endif; unset($_from); ?>
	</span>
<?php endif; ?>

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['branch_cd']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['branch_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['branch_name']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['branch_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['bases_ware_id']['label']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['bases_ware_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['note']['label']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['note']['html']; ?>
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
        <td align="right"><?php echo $this->_tpl_vars['form']['regist_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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
</b>件　　<?php echo $this->_tpl_vars['form']['csv_button']['html']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['branch_cd']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['branch_name']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['bases_ware_id']['label']; ?>
</td>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['note']['label']; ?>
</td>
    </tr>
		<?php $_from = $this->_tpl_vars['branch_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['branch_data']):
?>
    <tr class="Result1"> 
        <td align="right"><?php echo $this->_tpl_vars['branch_data']['no']; ?>
</td>
        <td><a href="" OnClick="Javascript:Change_Data(<?php echo $this->_tpl_vars['branch_data']['branch_id']; ?>
);return false;"><?php echo $this->_tpl_vars['branch_data']['branch_cd']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['branch_data']['branch_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['branch_data']['ware_name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['branch_data']['note']; ?>
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
