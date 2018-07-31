<?php /* Smarty version 2.6.14, created on 2010-01-08 17:13:57
         compiled from 1-4-110.php.tpl */ ?>
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
<?php if ($this->_tpl_vars['form']['form_base_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_base_date']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_object_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_object_day']['error']; ?>

<?php endif; ?>
</span>

<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col width="190">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">対象在庫<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_base_date']['html']; ?>
 時点で <?php echo $this->_tpl_vars['form']['form_object_day']['html']; ?>
 日以上 <?php echo $this->_tpl_vars['form']['form_io_type']['html']; ?>
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
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
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

全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Title_Yellow">製品区分</td>
        <td class="Title_Yellow">商品コード<br>商品名</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">在庫数</td>
        <td class="Title_Yellow">在庫単価</td>
        <td class="Title_Yellow">在庫金額</td>
        <td class="Title_Yellow">在庫日数</td>
        <td class="Title_Yellow">最終売上日</td>
        <td class="Title_Yellow">最終仕入日</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if (!(1 & $this->_tpl_vars['i'])): ?>
    <tr class="Result1">
    <?php else: ?>
    <tr class="Result2">
    <?php endif; ?> 
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][10]; ?>
<br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][3]; ?>
</td>
		<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['i']][4] < 0): ?>
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][4]; ?>
</font></td>
	<?php else: ?>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][4]; ?>
</td>
	<?php endif; ?>
		    <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][5]; ?>
</td>
		<?php if ($this->_tpl_vars['row'][$this->_tpl_vars['i']][6] < 0): ?>
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][6]; ?>
</font></td>
	<?php else: ?>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][6]; ?>
</td>
	<?php endif; ?>
	        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($_POST['form_io_type'] == '1' || $_POST['form_io_type'] == '0'): ?>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][8]; ?>
</td>
        <?php elseif ($_POST['form_io_type'] == '2'): ?>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][8]; ?>
</td>
        <td align="center"></td>
        <?php elseif ($_POST['form_io_type'] == '4'): ?>
        <td align="center"></td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['i']][8]; ?>
</td>
    <?php endif; ?>        
    </tr>
    <?php if ($this->_tpl_vars['g_goods_total'][$this->_tpl_vars['i']] != null): ?>
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>Ｍ区分計</b></td>
        <td align="right"></td>
        <td align="right"></td>
				<?php if ($this->_tpl_vars['g_goods_total'][$this->_tpl_vars['i']] < 0): ?>
        <td align="right"><font color="red"><?php echo $this->_tpl_vars['g_goods_total'][$this->_tpl_vars['i']]; ?>
</font></td>
		<?php else: ?>
        <td align="right"><?php echo $this->_tpl_vars['g_goods_total'][$this->_tpl_vars['i']]; ?>
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
        <td align="right"></td>
        <td align="right"></td>
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
