<?php /* Smarty version 2.6.14, created on 2010-04-05 16:05:06
         compiled from 1-1-230.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script language="javascript">
<?php echo $this->_tpl_vars['var']['js']; ?>

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
        <td valign="top">
            <table>
                <tr>
                    <td>

<?php if ($_GET['goods_id'] != null): ?>
<table width="100%">
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['back_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['next_button']['html']; ?>
</td> 
   </tr>
</table>

        </td>
    </tr>
</table>
<?php endif; ?>


<table>
    <tr valign="top">
        <td>

<span style="font: bold 15px; color: #555555;">【構成内容】</span>

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
    <?php if ($this->_tpl_vars['form']['form_price'][0]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_price'][0]['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_price'][1]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_price'][1]['error']; ?>

    <?php endif; ?>
    </span>

<table class="Data_Table" border="1" width="400" align="left">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">構成品コード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">構成品名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">単位</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_unit']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">品名変更</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_name_change']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">承認</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
    </tr>
</table>

<table class="Data_Table" border="1" width="300">
    <?php $_from = $this->_tpl_vars['form']['form_rank_price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['price'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['price']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
        $this->_foreach['price']['iteration']++;
?>
    <tr>
        <td class="Title_Purple" width="110"><b><?php echo $this->_tpl_vars['form']['form_rank_price'][$this->_tpl_vars['i']]['label']; ?>
</b></td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_rank_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <?php if ($this->_tpl_vars['i'] == 0 && $_GET['goods_id'] == null && $this->_tpl_vars['var']['freeze_flg'] != true): ?>
        <td class="Value" rowspan="<?php echo $this->_foreach['price']['total']; ?>
"><?php echo $this->_tpl_vars['form']['form_total_button']['html']; ?>
</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

        </td>
    </tr>
    <tr valign="top">
        <td>

<table>
    <tr>
        <td align="left"><b><font color="#ff0000">※は必須入力です</font></b></td>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
    <tr valign="top">
        <td>

<span style="font: bold 15px; color: #555555;">【構成内容】</span>

     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['price_err']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['price_err']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['parts_goods_err']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['parts_goods_err']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['count_err']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['count_err']['error']; ?>

    <?php endif; ?>
    </span>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">仕入単価</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">仕入金額</td>
    <?php if ($this->_tpl_vars['var']['freeze_flg'] != true && $_GET['goods_id'] == null): ?>
        <td class="Title_Purple">行(<a href="#" onClick="javascript:Button_Submit_1('add_flg', '#', 'true')">追加</a>)</td>
    <?php endif; ?>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
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
