<?php /* Smarty version 2.6.9, created on 2006-09-19 13:39:25
         compiled from 1-1-131.php.tpl */ ?>
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>ショップ名</b></td>
        <td class="Value">アメニティ東陽</td>
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


<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">契約開始日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求日</td>
        <td class="Value">毎月 <?php echo $this->_tpl_vars['form']['form_date']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>
<br><br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">商品コード<font color="red">※</font></td>
        <td class="Title_Purple">商品名<font color="red">※</font></td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">単価</td>
        <td class="Title_Purple">合計</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['insurance']):
?>
    <tr class="<?php echo $this->_tpl_vars['insurance'][0]; ?>
">
        <td><?php echo $this->_tpl_vars['form']['form_code'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_name'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_num'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_add_button']['html']; ?>
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
