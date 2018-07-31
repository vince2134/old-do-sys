<?php /* Smarty version 2.6.14, created on 2010-04-05 15:53:42
         compiled from 1-4-109.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

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
    <?php if ($this->_tpl_vars['form']['form_build_no']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_build_no']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_goods_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_goods_name']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_create_num']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_create_num']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_output_ware']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_output_ware']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_input_ware']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_input_ware']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>

    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_create_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_create_day']['error']; ?>

    <?php endif; ?>
</span>  

<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">組立管理番号<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_build_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">組立日<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_create_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">
        <?php if ($this->_tpl_vars['var']['freeze_flg'] != true): ?>
            <a href="#" onClick="return Open_SubWin_2('../dialog/1-0-210.php',Array('form_goods_cd','form_goods_name'),500,450,7,0,1);">商品コード</a>
        <?php else: ?>
            商品コード
        <?php endif; ?>
        <font color="#ff0000">※</font>
        </td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">組立数<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_create_num']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">引落倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_ware']['html']; ?>
</td>
        <td class="Title_Yellow">入庫倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_input_ware']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php if ($this->_tpl_vars['var']['freeze_flg'] != true):  echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php endif;  echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php if ($this->_tpl_vars['var']['validate_flg'] == true): ?>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%" style="font-weight: bold;">
<col width="110">
<col>
<col width="110">
<col>
    <tr align="center">
        <td class="Title_Yellow">組立数</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['var']['create_num']; ?>
</td>
        <td class="Title_Yellow">完成品在庫数<br>（引当数）</td>
        <td class="Value" align="right"><?php echo $this->_tpl_vars['var']['stock_num']; ?>
（<?php echo $this->_tpl_vars['var']['rstock_num']; ?>
）</td>
    </tr>
    <tr align="center">
        <td class="Title_Yellow">引当倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['output_ware_name']; ?>
</td>
        <td class="Title_Yellow">入庫倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['input_ware_name']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">部品コード</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">構成数</td>
        <td class="Title_Yellow">現在庫数</td>
        <td class="Title_Yellow">使用数</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][4]; ?>
/<?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][6]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_create_button']['html']; ?>
</td>
    </tr>
</table>

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
