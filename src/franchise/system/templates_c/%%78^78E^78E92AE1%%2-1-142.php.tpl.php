<?php /* Smarty version 2.6.14, created on 2010-04-05 16:15:33
         compiled from 2-1-142.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<!-- styleseet -->
<style type="text/css">

	/** 総合計 **/
	td.total {
		height: 24px;
		background-color:  #FFBBC3;
		border-color: #B9B9B8;
	}

	/** ショップごとの合計 **/
	td.sub {
		height: 24px;
		border-color: #B9B9B8;
		background-color: #99CCFF;
	}

</style>

<body class="bgimg_purple">
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table  class="Data_Table" border="1" width="650">
    <tr>
        <td class="Title_Pink" width="100"><b>状況</b></td>
        <td class="Value" align="left" colspan="3"><?php echo $this->_tpl_vars['form']['form_stat_check']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>レンタル番号</b></td>
        <td class="Value" align="left" ><?php echo $this->_tpl_vars['form']['form_rental_no']['html']; ?>
</td>
        <td class="Title_Pink" width="100"><b>商品分類</b></td>
        <td class="Value" align="left" ><?php echo $this->_tpl_vars['form']['form_g_product_id']['html']; ?>
</td>
    </tr>
	<tr>
      	<td class="Title_Pink" width="110"><b>ユーザコード</b></td>
       	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
		<td class="Title_Pink" width="110"><b>ユーザ名</b></td>
       	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
	<tr>
      	<td class="Title_Pink" width="100"><b>商品コード</b></td>
       	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
		<td class="Title_Pink" width="100"><b>商品名</b></td>
       	<td class="Value" align="left"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
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
<br>

<?php $_from = $this->_tpl_vars['disp_data2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
	<table class="List_Table" border="1" width="650">
	    <tr align="center" style="font-weight: bold;">
	        <td class="sub" width="162">ショップ名</td>
	        <td class="sub" width="162">レンタル合計数</td>
	        <td class="sub" width="162">レンタル合計額</td>
	        <td class="sub" width="162">ユーザ提供合計額</td>
	    </tr>
	    <tr>
	        <td class="Value"><?php echo $this->_tpl_vars['disp_data2'][$this->_tpl_vars['i']][0]; ?>
<br><?php echo $this->_tpl_vars['disp_data2'][$this->_tpl_vars['i']][1]; ?>
</td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['disp_data2'][$this->_tpl_vars['i']][2]; ?>
</td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['disp_data2'][$this->_tpl_vars['i']][3]; ?>
</td>
	        <td class="Value" align="right"><?php echo $this->_tpl_vars['disp_data2'][$this->_tpl_vars['i']][4]; ?>
</td>
	    </tr>
	</table>
	<br>
	<table class="List_Table" border="1" width="100%">
	    <tr align="center" style="font-weight: bold;">
	        <td class="Title_Purple"><b>No.</b></td>
	        <td class="Title_Purple"><b>設置先</b></td>
	        <td class="Title_Purple"><b>レンタル番号</b></td>
	        <td class="Title_Purple"><b>出荷日</b></td>
	        <td class="Title_Purple"><b>解約日</b></td>
	        <td class="Title_Purple"><b>状況</b></td>
	        <td class="Title_Purple"><b>商品名</b></td>
	        <td class="Title_Purple"><b>数量</b></td>
	        <td class="Title_Purple"><b>シリアル</b></td>
			<td class="Title_Purple"><b>　レンタル単価<br>ユーザ提供単価</b></td>
			<td class="Title_Purple"><b>　レンタル金額<br>ユーザ提供金額</b></td>
			<td class="Title_Purple"><b>備考</b></td>
	    </tr>
	   
		<?php echo $this->_tpl_vars['html'][$this->_tpl_vars['i']]; ?>


	</table>
<br><hr><br>
<?php endforeach; endif; unset($_from); ?>



                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
