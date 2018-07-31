<?php /* Smarty version 2.6.14, created on 2010-05-13 14:07:38
         compiled from 2-3-101.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-3-101.php.tpl', 125, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['order_err1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['order_err1']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['order_err2']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['order_err2']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_designated_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_designated_date']['error']; ?>
<br>
<?php endif; ?>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="550">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">出荷可能数</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_designated_date']['html']; ?>
 日後までの発注済数と引当数を考慮する</td>
    </tr>
    <tr>
        <td class="Title_Blue">対象商品</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_target_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">仕入先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_cd']['html']; ?>
</td>
        <td class="Title_Blue">主な仕入先</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_supplier_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">Ｍ区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Blue">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Blue">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
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

<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>
<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>
<table width="100%">
    <tr>
        <td>

<table width=$width>
    <tr>
        <td>全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件</td>
    </tr>
</table>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">主な仕入先</td>
        <td class="Title_Blue">Ｍ区分</td>
        <td class="Title_Blue">商品コード<br>商品名</td>
        <td class="Title_Blue">仕入単価</td>
        <td class="Title_Blue">実棚数</td>
        <td class="Title_Blue">発注済数</td>
        <td class="Title_Blue">引当数</td>
        <td class="Title_Blue">発注点</td>
        <td class="Title_Blue"><?php echo $this->_tpl_vars['form']['form_order_all_check']['html']; ?>
</td>
    </tr>
        <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
<br><a href="#" onClick="javascript:window.open('../stock/2-4-105.php?goods_id=<?php echo $this->_tpl_vars['item'][5]; ?>
');"><?php echo $this->_tpl_vars['item'][3]; ?>
</a></td>    
        <td align="right"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td align="right"><a href="javascript:Open_Dialog('2-3-111.php',300,160,1,<?php echo $this->_tpl_vars['item'][5]; ?>
,<?php echo $_SESSION['client_id']; ?>
);"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][6])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</a></td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][7])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][8])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][9])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_order_check'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
        <tr class="Result3">
        <td align="right"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_order_button']['html']; ?>
</td>
    </tr>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>

</table>

        </td>
    </tr>
</table>
<?php endif; ?>
<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
