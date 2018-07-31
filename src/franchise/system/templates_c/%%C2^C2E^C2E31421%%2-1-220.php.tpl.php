<?php /* Smarty version 2.6.14, created on 2010-05-13 17:32:41
         compiled from 2-1-220.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'Make_Sort_Link_Tpl', '2-1-220.php.tpl', 103, false),)), $this); ?>
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


<table width="700">
    <tr>    
        <td>    
            <table class="Data_Table" border="1" width="430">
            <col width="90" style="font-weight: bold;">
            <col>   
                <tr>    
                    <td class="Title_Purple">商品コード</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">Ｍ区分</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">管理区分</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">商品分類</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">商品名</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">略記</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
                </tr>   
            </table>
        </td>   
        <td valign="bottom">
            <table class="Data_Table" border="1" width="480">
            <col width="90" style="font-weight: bold;">
                <tr>    
                    <td class="Title_Purple">在庫限り品</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_stock_only']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">状態</td> 
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">出力形式</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
                </tr>
                <tr>
                    <td class="Title_Purple">表示件数</td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_display_num']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right"><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
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


<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div1','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div2','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div3','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div4','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div5','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
        <td class="Title_Purple" width="100"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'nl_attri_div6','hdn_form' => 'hdn_attri_div'), $this);?>
</td>
    </tr>
    <tr>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][0]; ?>
件</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][1]; ?>
件</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][2]; ?>
件</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][3]; ?>
件</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][4]; ?>
件</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['attri_div'][0]+$this->_tpl_vars['attri_div'][1]+$this->_tpl_vars['attri_div'][2]+$this->_tpl_vars['attri_div'][3]+$this->_tpl_vars['attri_div'][4]; ?>
件</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br>

<?php if ($this->_tpl_vars['var']['show_page'] == 2): ?>
    全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<?php else: ?>
    <?php echo $this->_tpl_vars['var']['html_page']; ?>

<?php endif; ?>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_goods_cd'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_g_goods'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_product'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_g_product'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_goods_name'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_goods_cname'), $this);?>
</td>
        <td class="Title_Purple"><?php echo Make_Sort_Link_Tpl(array('form' => $this->_tpl_vars['form'],'f_name' => 'sl_attribute'), $this);?>
</td>
        <td class="Title_Purple">アルバム</td>
        <td class="Title_Purple">在庫品</td>
        <td class="Title_Purple">状　態</td>
    </tr>
        <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['j']][11] == 't'): ?>
        <tr class="Result5">
        <?php elseif ($this->_tpl_vars['j']%2 == 1): ?>
		<tr class="Result2">
        <?php else: ?>
		<tr class="Result1">
        <?php endif; ?>
        <td align="right">
			<?php if ($_POST['form_show_button'] == "表　示"): ?>
				            	<?php echo $this->_tpl_vars['j']+1; ?>

            <?php elseif ($_POST['form_show_page'] != 2 && $_POST['f_page1'] != ""): ?>
                <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

            <?php else: ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>
		<td><a href="2-1-221.php?goods_id=<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][1]; ?>
"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][0]; ?>
</a></td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][4]; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][6]; ?>
</td>
        <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['j']][8] != null): ?>
        <td align="center"><a href="#" onClick="window.open('<?php echo $this->_tpl_vars['var']['url'];  echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][8]; ?>
')">表示</a></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
        <td align="center"><?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['j']][10] == '1'): ?>○<?php endif; ?></td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][7]; ?>
</td>
    </tr>
        <?php endforeach; endif; unset($_from); ?>
</table>
<?php if ($this->_tpl_vars['var']['show_page'] != 2): ?>
    <?php echo $this->_tpl_vars['var']['html_page2']; ?>

<?php endif; ?>

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
