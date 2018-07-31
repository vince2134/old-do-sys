<?php /* Smarty version 2.6.14, created on 2010-02-22 14:39:26
         compiled from 2-2-116.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<script>
    <?php echo $this->_tpl_vars['var']['javascript']; ?>

</script>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>   
    
        <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>    

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <li><?php echo $this->_tpl_vars['item']; ?>
<br>
<?php endforeach; endif; unset($_from); ?>
</span>

<?php echo $this->_tpl_vars['html']['html_s']; ?>


                    </td>
                </tr>
                <tr style="page-break-before: always;">
                    <td align="left">

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<div class="note">
※前集計日報(0)とは付番前の集計日報であり付番後は発行できません。
</div>
<table width="1000">
    <tr>
        <td colspan="2"><?php echo $this->_tpl_vars['var']['html_page']; ?>
</td>
    </tr>
    <tr>
        <td>
<table class="List_Table" border="1" width="800">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Pink">No.</td>
		<td class="Title_Pink">予定巡回日</td>
		<td class="Title_Pink">委託先コード</td>
		<td class="Title_Pink">委託先名</td>
		<td class="Title_Pink">巡回件数</td>
		<td class="Title_Pink"><?php echo $this->_tpl_vars['form']['aord_prefix_all']['html']; ?>
</td>
		<td class="Title_Pink"><?php echo $this->_tpl_vars['form']['aord_unfix_all']['html']; ?>
</td>
		<td class="Title_Pink"><?php echo $this->_tpl_vars['form']['aord_fix_all']['html']; ?>
</td>
    </tr>

    <?php $_from = $this->_tpl_vars['aord_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<tr class="<?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['bg_color']; ?>
">
        <td align="right" ><?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['no']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['ord_time']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['shop_cd']; ?>
</td>
        <td align="left"  ><?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['shop_name']; ?>
</td>
        <td align="right" ><?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['count']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_preslip_out'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_unslip_out'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_slip_out'][$this->_tpl_vars['i']]['html']; ?>
</td>
	</tr>
    <?php endforeach; endif; unset($_from); ?>

    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_preslipout_button']['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_slipout_button']['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_reslipout_button']['html']; ?>
</td>
    </tr>
</table>
        </td>
        <td>
<table class="List_Table" border="1">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Pink"><?php echo $this->_tpl_vars['form']['slip_out_all']['html']; ?>
</td>
		<td class="Title_Pink"><?php echo $this->_tpl_vars['form']['reslip_out_all']['html']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['aord_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<tr class="<?php echo $this->_tpl_vars['aord_data'][$this->_tpl_vars['i']]['bg_color']; ?>
">
        <td align="center" height="23"><?php echo $this->_tpl_vars['form']['form_slip_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_reslip_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3">
        <td align="center"><?php echo $this->_tpl_vars['form']['slip_out_button']['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['reslip_out_button']['html']; ?>
</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><?php echo $this->_tpl_vars['var']['html_page2']; ?>
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
