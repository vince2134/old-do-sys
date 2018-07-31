<?php /* Smarty version 2.6.14, created on 2010-01-16 16:04:51
         compiled from 2-1-222.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script language="javascript">
<?php echo $this->_tpl_vars['var']['js']; ?>

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
    <?php if ($this->_tpl_vars['var']['price_err'] != null): ?>
       <li> <?php echo $this->_tpl_vars['var']['price_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['rprice_err'] != null): ?>
       <li><?php echo $this->_tpl_vars['var']['rprice_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['cday_err'] != null): ?>
       <li><?php echo $this->_tpl_vars['var']['cday_err']; ?>
<br>
    <?php endif; ?>
    <?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
       <li><?php echo $this->_tpl_vars['item']; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
    </span>

<table width="650">
    <tr>
        <td>
<span style="font: bold 15px; color: #555555;">
【商品名】： <?php echo $this->_tpl_vars['var']['goods_name']; ?>
 <br>
【略　記】： <?php echo $this->_tpl_vars['var']['goods_cname']; ?>
 
</span>
<br>
<?php if ($this->_tpl_vars['var']['warning'] != null): ?>
<span style=" color: blue;">
<b><?php echo $this->_tpl_vars['var']['warning']; ?>

</b>
</span>
<?php endif; ?>
<br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">単価項目</td>
        <td class="Title_Purple" rowspan="2">現在単価</td>
        <td class="Title_Purple" colspan="2">改訂単価</td>
        <td class="Title_Purple" rowspan="2">改訂日</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">指定</td>
        <td class="Title_Purple">標準価格の％</td>
    </tr>
    <!--1行目-->
    <tr class="Result1">
        <td class="Title_Purple"><b><?php echo $this->_tpl_vars['form']['form_price'][0]['label']; ?>
<font color="#ff0000">※</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][0]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][0]['html']; ?>
</td>
        <td align="center"></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][0]['html']; ?>
</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b><?php echo $this->_tpl_vars['form']['form_price'][2]['label']; ?>
<font color="#ff0000">※</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][2]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][2]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cost_rate'][2]['html']; ?>
%</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][2]['html']; ?>
</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b><?php echo $this->_tpl_vars['form']['form_price'][1]['label']; ?>
<font color="#ff0000">※</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][1]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][1]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cost_rate'][1]['html']; ?>
%</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][1]['html']; ?>
</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b><?php echo $this->_tpl_vars['form']['form_price'][3]['label']; ?>
<font color="#ff0000">※</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_price'][3]['html']; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_rprice'][3]['html']; ?>
</td>
        <td></td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_cday'][3]['html']; ?>
</td>
    </tr>
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
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">【改定履歴】</span>
<br>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Purple"><b>改定日</b></td>
        <td class="Title_Purple"><b>単価項目</b></td>
        <td class="Title_Purple"><b>改定前単価</b></td>
        <td class="Title_Purple"><b>改定後単価</b></td>
        <td class="Title_Purple"><b>単価改定者</b></td>
    </tr>
    <!--1行目-->
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['i'] == 0): ?>
            <td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['i'] == 1): ?>
            <td><?php echo $this->_tpl_vars['item']; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['i'] == 2): ?>
            <td align="right"><?php echo $this->_tpl_vars['item']; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['i'] >= 3): ?>
            <td align="right"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
