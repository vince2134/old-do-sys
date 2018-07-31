<?php /* Smarty version 2.6.14, created on 2009-12-21 13:37:57
         compiled from 1-2-104.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['forward_num']; ?>

 </script>
 
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
    <?php if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['form_ord_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_ord_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trade_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_staff_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_staff_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['form_def_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_def_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_def_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_def_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['forward_day_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['forward_day_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['forward_num_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['forward_num_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_note_your']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_note_your']['error']; ?>
<br>
    <?php endif; ?>
    <?php if (( $this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null ) || $this->_tpl_vars['var']['price_warning'] != null): ?>
        <font color="#ff00ff"><p>[警告]
        <?php if ($this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null): ?>
         <br><?php echo $this->_tpl_vars['var']['alert_message']; ?>
</font>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['var']['price_warning'] != null): ?>
        <br><?php echo $this->_tpl_vars['var']['price_warning']; ?>
</font>
            <br>
        <?php endif; ?>
        <?php echo $this->_tpl_vars['form']['button']['alert_ok']['html']; ?>
<p>
    <?php endif; ?>
    </span>
 
<!-- フリーズ画面判定 -->
<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
	<span style="font: bold;"><font size="+1">以下の内容で受注しますか？</font></span><br>
<?php endif; ?>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="800">
    <tr>
        <td>


<table class="Data_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
</td>
        <td class="Title_Pink">得意先</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['client_cd']; ?>
　<?php echo $this->_tpl_vars['var']['client_name']; ?>
</td>
        <td class="Title_Pink">FC発注番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['fc_ord_id']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_day']['html']; ?>
</td>
        <td class="Title_Pink">出荷可能数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_designated_date']['html']; ?>
 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Pink">受注担当者<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_def_day']['html']; ?>
</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_select']['html']; ?>
</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">希望納期</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['hope_day']; ?>
</td>
        <td class="Title_Pink">直送先</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['direct_name']; ?>
</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_your']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['var']['note_my']; ?>
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
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<br>商品名</td>
        <td class="Title_Pink">実棚数<BR>（A）</td>
        <td class="Title_Pink">発注済数<BR>（B）</td>
        <td class="Title_Pink">引当数<BR>（C）</td>
        <td class="Title_Pink">出荷可能数<BR>（A+B-C）</td>
        <td class="Title_Pink">受注数</td>
        <td class="Title_Pink"><font color="#0000ff">原価単価</font><br><font color="#ff0000">FC発注単価</font><br>売上単価</td>
        <td class="Title_Pink"><font color="#0000ff">原価金額</font><br><font color="#ff0000">FC発注金額</font><br>売上金額</td>
        <td class="Title_Pink">出荷回数<font color="#ff0000">※</font></font></td>
        <td class="Title_Pink">分納時出荷予定日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">出荷数<font color="#ff0000">※</font></font></td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][11] == true): ?>
    <tr bgcolor="pink" >
    <?php else: ?>
    <tr class="Result1">
    <?php endif; ?>
                <td align="right">
            <?php if ($_POST['show_button'] == "表　示"): ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php elseif ($_POST['f_page1'] != null): ?>
                <?php echo $_POST['f_page1']*10+$this->_tpl_vars['j']-9; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
                <td align="right"><a href="#" onClick="Open_mlessDialmg_g('1-2-107.php',<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
,<?php echo $_SESSION['client_id']; ?>
,300,160);"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</a></td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
                <td align="right"><font color="#0000ff"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</font><br><font color="ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</font><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
                <td align="right"><font color="#0000ff"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</font><br><font color="ff0000"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</font><br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_forward_times'][$this->_tpl_vars['j']]['html']; ?>
</td>
		<?php else: ?>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_forward_times'][$this->_tpl_vars['j']]['html']; ?>
</td>
		<?php endif; ?>
                <td align="center" width="130">
		<!-- フリーズ画面判定-->
		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
			<!-- フリーズ画面-->
			<?php $_from = $this->_tpl_vars['disp_count'][$this->_tpl_vars['j']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_day'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>
<br>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
			<!-- 初期表示-->
			<?php $_from = $this->_tpl_vars['num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_day'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>

        	<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
        </td>
        		<!-- フリーズ画面判定-->
		<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
        <td align="right" width="130">
			<!-- フリーズ画面-->
			<?php $_from = $this->_tpl_vars['disp_count'][$this->_tpl_vars['j']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
        		<?php echo $this->_tpl_vars['form']['form_forward_num'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>
<br>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
        <td align="center" width="130">
			<!-- 初期表示-->
			<?php $_from = $this->_tpl_vars['num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
            	<?php echo $this->_tpl_vars['form']['form_forward_num'][$this->_tpl_vars['j']][$this->_tpl_vars['i']]['html']; ?>

        	<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right" class="List_Table" border="1" width="650">
    <tr>
        <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
        <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
        <td class="Title_Pink" align="center" width="80"><b>税込金額</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
		 
		<?php if ($this->_tpl_vars['var']['comp_flg'] == null): ?>
			            <?php if (( $this->_tpl_vars['var']['alert_message'] != null && $this->_tpl_vars['var']['alert_output'] != null ) || $this->_tpl_vars['var']['price_warning'] != null): ?> 
        	<td align="right" colspan="2">　　<?php echo $this->_tpl_vars['form']['button']['back']['html']; ?>
</td>
            <?php else: ?>
        	<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['button']['entry']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['back']['html']; ?>
</td>
            <?php endif; ?>
		<?php else: ?>
			 
			<td align="right" colspan="2"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
		<?php endif; ?>
    </tr>
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
