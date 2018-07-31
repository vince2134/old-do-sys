<?php /* Smarty version 2.6.14, created on 2010-06-17 21:01:22
         compiled from 2-4-109.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

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
<?php if ($this->_tpl_vars['form']['form_stock_date']['error'] != null): ?>
<li><?php echo $this->_tpl_vars['form']['form_stock_date']['error']; ?>
<br>
<?php elseif ($this->_tpl_vars['form']['form_over_day']['error'] != null): ?>
<li><?php echo $this->_tpl_vars['form']['form_over_day']['error']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="700">
<col width="110" style="font-weight: bold;">
<col width="240">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">対象在庫<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_stock_date']['html']; ?>
　時点で　<?php echo $this->_tpl_vars['form']['form_over_day']['html']; ?>
　日以上　<?php echo $this->_tpl_vars['form']['form_sale_buy']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
        <td class="Title_Yellow">製品区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
    <?php if ($_SESSION['shop_div'] == '1'): ?>
        <tr>
            <td class="Title_Yellow">事業所</td>
            <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_cshop']['html']; ?>
</td>
        </tr>
    <?php endif; ?>
</table>

<table width=100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
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

<table width=$width>
    <tr>    
        <td>全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件</td>
    </tr>   
</table>

<span style="font: bold 16px; color: #555555;">
【事業所:<?php echo $this->_tpl_vars['var']['cshop_name']; ?>
】
</span><br>

<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Yellow"><b>No.</b></td>
        <td class="Title_Yellow"><b>Ｍ区分</b></td>
        <td class="Title_Yellow"><b>製品区分</b></td>
        <td class="Title_Yellow"><b>商品コード<br>商品名</b></td>
        <td class="Title_Yellow"><b>倉庫</b></td>
        <td class="Title_Yellow"><b>在庫数</b></td>
        <td class="Title_Yellow"><b>在庫単価</b></td>
        <td class="Title_Yellow"><b>在庫金額</b></td>
        <td class="Title_Yellow"><b>在庫日数</b></td>
        <td class="Title_Yellow"><b>最終売上日</b></td>
        <td class="Title_Yellow"><b>最終仕入日</b></td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>

        <td align="right">
            <?php echo $this->_tpl_vars['j']+1; ?>

        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <?php if ($_POST['form_sale_buy'] == '1'): ?>
            <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <?php else: ?>
            <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
				<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][4] < 0): ?>
			<td align="right"><font color="red"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</font></td>
		<?php else: ?>
        	<td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
		<?php endif; ?>
		        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
		
				<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] < 0): ?>
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</font></td>
		<?php else: ?>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
		<?php endif; ?>
				
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
                <?php if ($_POST['form_sale_buy'] == '1'): ?>
            <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
            <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
                <?php elseif ($_POST['form_sale_buy'] == '2'): ?>
            <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
            <td align="center"></td>
                <?php elseif ($_POST['form_sale_buy'] == '4'): ?>
            <td align="center"></td>
            <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
        <?php endif; ?>
    </tr>
    <?php if ($this->_tpl_vars['g_goods_total'][$this->_tpl_vars['j']] != null): ?>
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>Ｍ区分計</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
				<?php if ($this->_tpl_vars['g_goods_total'][$this->_tpl_vars['j']] < 0): ?>	
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['g_goods_total'][$this->_tpl_vars['j']]; ?>
</font></td>
        <?php else: ?>
		<td align="right"><?php echo $this->_tpl_vars['g_goods_total'][$this->_tpl_vars['j']]; ?>
</td>
		<?php endif; ?>
		        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?> 
    <tr class="Result4">
        <td colspan="5"><b>総合計</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
				<?php if ($this->_tpl_vars['var']['total_amount'] < 0): ?>	
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['var']['total_amount']; ?>
</font></td>
		<?php else: ?>
        <td align="right"><?php echo $this->_tpl_vars['var']['total_amount']; ?>
</td>
		<?php endif; ?>
		        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
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
