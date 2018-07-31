<?php /* Smarty version 2.6.14, created on 2009-12-26 17:25:19
         compiled from 2-2-204.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-2-204.php.tpl', 141, false),)), $this); ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<SCRIPT>
<!--

<?php echo '

function Post_Blank(str_check,my_page,post_page,check_name,num){

    // 確認ダイアログ表示
    if (window.confirm(str_check+"\\nよろしいですか？")){

        //発行する伝票が選択されているか判定
        for(var i=0;i<num;i++){
            var form_name = check_name+"["+i+"]";
            if(document.dateForm.elements[form_name] != undefined){
	
                if(document.dateForm.elements[form_name].checked == true){
                    var check_flg = true;
                }
            }
        }



        //伝票が選択されていた場合にファイルを開く
        if(check_flg == true){
            //別画面でウィンドウを開く
            document.dateForm.target="_blank";
            document.dateForm.action=post_page;
            //POST情報を送信する
            document.dateForm.submit();
        }else{
            document.dateForm.hdn_button.value = "error";
        }

        document.dateForm.target="_self";
        document.dateForm.action=my_page;
        return true;

    }else{
        return false;
    }
}



'; ?>

<?php echo $this->_tpl_vars['result_js']; ?>

//-->
</SCRIPT>



<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr>
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
<?php endforeach; endif; unset($_from);  echo $this->_tpl_vars['var']['err_msg']; ?>

</span>

<?php echo $this->_tpl_vars['var']['search_html']; ?>

<br style="font-size: 4px;">

<table class="Table_Search">
	<col width=" 80px" style="font-weight: bold;">
	<col width="300px">
	<col width=" 90px" style="font-weight: bold;">
	<col width="400px">

	<tr>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['slip_out']['label']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['slip_out']['html']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['slip_flg']['label']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['slip_flg']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['ord_no']['label']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['ord_no']['html']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['contract_div']['label']; ?>
</td>
		<td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['contract_div']['html']; ?>
</td>
	</tr>

</table>

<table width='100%'>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<?php if ($this->_tpl_vars['var']['action'] != '初期表示'): ?>
<table>
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1">

    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_client_name'), $this);?>
<br>
        </td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_slip'), $this);?>
</b></td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_round_day'), $this);?>
</td>
        <td class="Title_Pink"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_staff'), $this);?>
</td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
        <td class="Title_Pink">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_act_client_cd'), $this);?>
<br>
            <br style="font-size: 4px;">
            <?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_act_client_name'), $this);?>
<br>
        </td>
    <?php endif; ?>
        <td class="Title_Pink">伝票形式</td>
        <td class="Title_Pink" width="150"><?php echo $this->_tpl_vars['form']['form_slip_all_check']['html']; ?>
</td>
        <td class="Title_Pink" width="150"><?php echo $this->_tpl_vars['form']['form_re_slip_all_check']['html']; ?>
</td>
    </tr>

			<?php $_from = $this->_tpl_vars['result_html']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
				<tr class="<?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['class']; ?>
">
					<td align="right"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['no']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['client_cd1']; ?>
-<?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['client_cd2']; ?>
<br>
						<?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['client_cname']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['ord_no']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['ord_time']; ?>
</td>
					<td align="left"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['staff_cd1']; ?>
<br><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['staff_name1']; ?>
</td>

					<?php if ($_SESSION['group_kind'] == '2'): ?>
						<td align="left"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['act_cd']; ?>
<br><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['act_name']; ?>
</td>
					<?php endif; ?>

					<td align="center"><?php echo $this->_tpl_vars['result_html'][$this->_tpl_vars['i']]['slip_out']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['form_slip_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
					<td align="center"><?php echo $this->_tpl_vars['form']['form_re_slip_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>

    <tr class="Result3" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    <?php if ($_SESSION['group_kind'] == '2'): ?>
        <td></td>
    <?php endif; ?>
        <td></td>
        <td><?php echo $this->_tpl_vars['form']['form_sale_slip']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_re_sale_slip']['html']; ?>
</td>
    </tr>
</table>
<?php endif;  echo $this->_tpl_vars['var']['html_page2']; ?>


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

    
