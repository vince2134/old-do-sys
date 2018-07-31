<?php /* Smarty version 2.6.14, created on 2010-04-27 13:05:57
         compiled from 2-1-230.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script language="javascript"><?php echo $this->_tpl_vars['var']['code_value']; ?>
 </script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="center">
    
                <td valign="top">

            <table border="0">
                <tr>
                    <td>
</form>
 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<table width=450>
    <tr>
        <td align="right">
            <?php if ($_GET['goods_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td> 
   </tr>
</table>
<table border="0">
<tr valign="top">
<td>
<table class="Data_Table" border="1" width="350" align="left">
<?php if ($_SESSION['group_kind'] == '2'): ?>
    <tr>
        <td class="Title_Purple"><b>状態</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>
    </tr>
<?php endif; ?>
    <tr>
        <td class="Title_Purple" width="100"><b>構成品コード</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>構成品名</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>略称</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>単位</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_unit']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>課税区分</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>品名変更</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_name_change']['html']; ?>
</td>
    </tr>

</table>

<table class="Data_Table" border="1" width="290">
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
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
</table>

<tr valign="top">

<table width="450">
    <tr>
        <td align="left">
        </td>
    </tr>
</table>
</td>
</tr>


                    </td>
                </tr>

                <tr>
                    <td>

<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple"><b>No.</b></td>
        <td class="Title_Purple"><b>商品コード</b></td>
        <td class="Title_Purple"><b>商品名</b></td>
        <td class="Title_Purple"><b>仕入単価</b></td>
        <td class="Title_Purple"><b>数量</b></td>
        <td class="Title_Purple"><b>仕入金額</b></td>
    </tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>


<?php echo $this->_tpl_vars['var']['html_footer']; ?>
