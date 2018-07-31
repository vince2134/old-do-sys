<?php /* Smarty version 2.6.14, created on 2009-12-28 13:57:23
         compiled from 2-1-221.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

 </script>

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
    <?php if ($this->_tpl_vars['form']['form_goods_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_url']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_url']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_g_goods_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_g_goods_id']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_product_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_product_id']['error']; ?>
<br>
    <?php endif; ?>
	<?php if ($this->_tpl_vars['form']['form_g_product_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_g_product_id']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_in_num']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_in_num']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_supplier']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_supplier']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_point']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_point']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_order_unit']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_order_unit']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_lead']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_lead']['error']; ?>
<br>
    <?php endif; ?>
    </span>

<table width="520">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_dialog_button']['html']; ?>
</td>
        <td align="right"><?php if ($_GET['goods_id'] != null):  echo $this->_tpl_vars['form']['back_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['next_button']['html'];  endif; ?>
        </td>
    </tr>
</table>
<br>

<table>
    <tr>
        <td>
        <table class="Data_Table" border="1" width="280">
            <tr>
                <td class="Type" width="40" align="center" width="100"><b>状態</b></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
            </tr>
        </table>
        </td>
	</tr>
	<!-- 本部商品のみ表示 -->
	<?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
		<tr>
	        <td>
	        <table class="Data_Table" border="1" width="280">
	            <tr>
	                <td class="Type" width="40" align="center" width="100"><b>RtoR</b></td>
	                <td class="Value"><?php echo $this->_tpl_vars['form']['form_rental']['html']; ?>
</td>
	            </tr>
	        </table>
	        </td>
			<td>
	        <table class="Data_Table" border="1" width="280">
	            <tr>    
	                <td class="Type" align="center" width="100"><b>シリアル管理</b></td>
	                <td class="Value"><?php echo $this->_tpl_vars['form']['form_serial']['html']; ?>
</td>
	            </tr>   
	        </table>
	        </td>   
	    </tr>
	<?php endif; ?>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">商品コード<font color="#ff0000">※</font></td>
        <td class="Value">
        <table>
            <tr>
                <td rowspan="2"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
                <td><font color=#555555>上１桁が０は本部用</font></td>
            </tr>
            <tr>
                <td><font color=#555555>上１桁が０以外はショップ用</font></td>
            </tr>
        </table>
        </td>
    </tr>
	<tr>
        <td class="Title_Purple">Ｍ区分</a><font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_g_goods_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_g_goods_id']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">管理区分</a><font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_product_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_product_id']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
	<tr>
        <td class="Title_Purple">商品分類</a><font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_g_product_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_g_product_id']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">商品名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略記<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">属性区分<font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_attri_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_attri_div']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
	<tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_album_link']['html']; ?>
</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">マーク<font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_mark_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_mark_div']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">単位</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">入数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_in_num']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">販売管理<font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_sale_manage_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_sale_manage']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">在庫管理<font color="#ff0000">※</font></td>
        <td class="Value">
                        <?php echo $this->_tpl_vars['form']['form_stock_manage']['html']; ?>

        </td>
    </tr>
    <tr>
        <td class="Title_Purple">在庫限り品</td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_stock_only_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_stock_only']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">発注点</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_point']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">発注単位数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">リードタイム</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_lead']['html']; ?>
日</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">品名変更<font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_name_change_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_name_change']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分<font color="#ff0000">※</font></td>
        <td class="Value">
            <?php if ($this->_tpl_vars['var']['head_flg'] == true): ?>
                <?php echo $this->_tpl_vars['form']['form_tax_div_name']['html']; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">最新売上日</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['sale_day']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">最新仕入日</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['buy_day']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
</td>
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
