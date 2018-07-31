<?php /* Smarty version 2.6.14, created on 2009-12-24 17:52:39
         compiled from 2-2-113.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '2-2-113.php.tpl', 174, false),)), $this); ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script>
    <?php echo $this->_tpl_vars['var']['javascript']; ?>

</script>
<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			 <?php echo $this->_tpl_vars['var']['page_header']; ?>
 		</td>
	</tr>

	<tr align="left">
		<td valign="top">
		
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

<?php echo $this->_tpl_vars['var']['search_html']; ?>


<br style="font-size: 4px;">

<table class="Table_Search">

<?php if ($_SESSION['group_kind'] == '2'): ?>
<col width=" 80px" style="font-weight: bold;">
<col width="300px">
<?php endif; ?>
<col width="110px" style="font-weight: bold;">
<col width="350px">

    <tr>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
        <td class="Td_Search_3"><b>代行区分</b></td>
        <td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['form_act_div']['html']; ?>
</td>
    <?php endif; ?>
		<td class="Td_Search_3"><b>除外巡回担当者<br>（複数選択）</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['form_not_multi_staff']['html']; ?>
<br> 例）0001,0002</td>
    </tr>
<table width='1000px'>
	<tr>
		<td align='right'>
			<?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>

		</td>
	</tr>
</table>

					<br>
					</td>
				</tr>


				<tr>
					<td>
<?php if ($_POST['form_show_button'] == "表　示" || $this->_tpl_vars['var']['match_count'] > 0): ?>
<div class="note">
※前集計日報(0)とは付番前の集計日報であり付番後は発行できません。
</div>
<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="900">
	<tr align="center">
		<td class="Title_Pink" width="30" ><b>No.</b></td>
		<td class="Title_Pink" width=""   ><b>日報No.</b></td>
		<td class="Title_Pink" width=""   ><b>予定巡回日</b></td>
		<td class="Title_Pink" width=""   ><b>巡回担当者コード</b></td>
		<td class="Title_Pink" width=""   ><b>巡回担当者名</b></td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
		<td class="Title_Pink" width=""   ><b>代行区分</b></td>
    <?php endif; ?>    
		<td class="Title_Pink" width=""   ><b>巡回件数</b></td>
		<td class="Title_Pink" width=""   ><b><?php echo $this->_tpl_vars['form']['aord_prefix_all']['html']; ?>
</b></td>
		<td class="Title_Pink" width=""   ><b><?php echo $this->_tpl_vars['form']['aord_unfix_all']['html']; ?>
</b></td>
		<td class="Title_Pink" width=""   ><b><?php echo $this->_tpl_vars['form']['aord_fix_all']['html']; ?>
</b></td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['page_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['page_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['page_count']['iteration']++;
?>
    <?php if (!(1 & $this->_tpl_vars['i'])): ?>
	<tr class="Result1">
    <?php else: ?>
	<tr class="Result2">
    <?php endif; ?>
		<td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']]['key']; ?>
</td>
		<td align=""><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][0]; ?>
</td>
		<td align="center"><a href="2-2-106.php?aord_id_array=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']]['ary_id']; ?>
&back_display=count_daily"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1]; ?>
</a></td>
		<td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2]; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][3]; ?>
</td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
		<td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][6]; ?>
</td>
    <?php endif; ?>
		<td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][4]; ?>
</td>
                <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']]['slip_flg'] == true): ?>
        <td></td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][7]; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['form_reslipout_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
                <?php else: ?>
		<td align="center"><?php echo $this->_tpl_vars['form']['form_preslipout_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['form_slipout_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td></td>
        <?php endif; ?>
	</tr>
    <?php endforeach; endif; unset($_from); ?>

    <tr align="center" class="Result3">
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
        <?php if ($_SESSION['group_kind'] == '2'): ?>
            <td></td>
        <?php endif; ?>
	    <td></td>
	    <td><?php echo $this->_tpl_vars['form']['form_preslipout_button']['html']; ?>
</td>
	    <td><?php echo $this->_tpl_vars['form']['form_slipout_button']['html']; ?>
</td>
	    <td><?php echo $this->_tpl_vars['form']['form_reslipout_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td>

<table class="List_Table" border="1">
	<tr align="center">
		<td class="Title_Pink" width=""   ><b><?php echo $this->_tpl_vars['form']['slip_out_all']['html']; ?>
</b></td>
		<td class="Title_Pink" width=""   ><b><?php echo $this->_tpl_vars['form']['reslip_out_all']['html']; ?>
</b></td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if (!(1 & $this->_tpl_vars['i'])): ?>
	<tr class="Result1">
    <?php else: ?>
	<tr class="Result2">
    <?php endif; ?>
   
     
    <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']]['slip_flg'] == true && ( $this->_tpl_vars['form']['form_slip_check'][$this->_tpl_vars['i']]['html'] != null || $this->_tpl_vars['form']['form_reslip_check'][$this->_tpl_vars['i']]['html'] != null )): ?>
		<td align="center"><?php echo ((is_array($_tmp=@$this->_tpl_vars['form']['form_slip_check'][$this->_tpl_vars['i']]['html'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['page_data'][$this->_tpl_vars['i']][8]) : smarty_modifier_default($_tmp, @$this->_tpl_vars['page_data'][$this->_tpl_vars['i']][8])); ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['form_reslip_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
    <?php else: ?>
		<td align="center" height="23"></td>
		<td align="center"></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    <tr align="center" class="Result3">
	    <td><?php echo $this->_tpl_vars['form']['slip_out_button']['html']; ?>
</td>
	    <td><?php echo $this->_tpl_vars['form']['reslip_out_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_page2']; ?>

<?php endif; ?>
<?php echo $this->_tpl_vars['form']['hidden']; ?>



					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
