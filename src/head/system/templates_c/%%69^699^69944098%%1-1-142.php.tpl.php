<?php /* Smarty version 2.6.9, created on 2006-09-13 21:38:32
         compiled from 1-1-142.php.tpl */ ?>
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

<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
	<tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_radio']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">状況</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_state_check']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル番号</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rental_no']['html']; ?>
</td>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_cd']['html']; ?>
</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td class="Title_Purple">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
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

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td bgcolor="#ffbbc3" width="90" align="center"><b>ショップ数</b></td>
        <td class="Value" width="*"><?php echo $this->_tpl_vars['head'][0]; ?>
</a></td>
        <td bgcolor="#ffbbc3" width="120" align="center"><b>レンタル総数</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['head'][1]; ?>
</td>
        <td bgcolor="#ffbbc3" width="120" align="center"><b>レンタル総額</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['head'][2]; ?>
</td>
        <td bgcolor="#ffbbc3" width="140" align="center"><b>ユーザ提供総額</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['haed'][3]; ?>
</td>
    </tr>
</table>
<br><br>

<?php echo $this->_tpl_vars['var']['html']; ?>


<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['shop']):
?>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Type" width="90" align="center"><b>ショップ名</b></td>
        <td class="Value" width="*"><?php echo $this->_tpl_vars['shop'][0]; ?>
</a></td>
        <td class="Type" width="120" align="center"><b>レンタル合計数</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['shop'][1]; ?>
</td>
        <td class="Type" width="120" align="center"><b>レンタル合計額</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['shop'][2]; ?>
</td>
        <td class="Type" width="140" align="center"><b>ユーザ提供合計額</b></td>
        <td class="Value" width="100" align="right"><?php echo $this->_tpl_vars['shop'][3]; ?>
</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">設置先</td>
        <td class="Title_Purple">出荷日</td>
        <td class="Title_Purple">解約日</td>
        <td class="Title_Purple">状況</td>
        <td class="Title_Purple">商品名</td> 
        <td class="Title_Purple">数量</td> 
        <td class="Title_Purple">シリアル</td> 
        <td class="Title_Purple">レンタル単価<br>　　　　金額</td> 
        <td class="Title_Purple">ユーザ提供単価<br>　　　　　金額</td> 
        <td class="Title_Purple">備考</td> 
    </tr>
    <?php $_from = $this->_tpl_vars['shop'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['rental']):
?>
    <?php $_from = $this->_tpl_vars['rental'][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rental_h_data_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rental_h_data_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['rental_h_data']):
        $this->_foreach['rental_h_data_count']['iteration']++;
?>
    <?php $_from = $this->_tpl_vars['rental_h_data'][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['goods_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['l'] => $this->_tpl_vars['goods']):
        $this->_foreach['goods_count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['rental'][0]; ?>
">
        <?php if ($this->_tpl_vars['k'] == 0 && $this->_tpl_vars['l'] == 0): ?>
        <td rowspan="<?php echo $this->_tpl_vars['disp_count'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
" align="center"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td rowspan="<?php echo $this->_tpl_vars['disp_count'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]; ?>
" align="center"><?php echo $this->_tpl_vars['rental'][1]; ?>
</td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['l'] == 0): ?>
        <td rowspan="<?php echo $this->_foreach['goods_count']['total']; ?>
" align="center">
            <a href="./1-1-141.php?rental_h_id=<?php echo $this->_tpl_vars['rental_h_data'][0]; ?>
&state=<?php echo $this->_tpl_vars['rental_h_data'][1]; ?>
"><?php echo $this->_tpl_vars['rental_h_data'][2]; ?>
</a>
        </td>
        <?php endif; ?>
        <td align="center"><?php echo $this->_tpl_vars['goods'][0]; ?>
</td>
        <td align="center"<?php if ($this->_tpl_vars['goods'][1] == "契約中"): ?> style="color: #0000ff;"<?php elseif ($this->_tpl_vars['goods'][1] == "解約済"):  else: ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['goods'][1]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['goods'][2]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['goods'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][5][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][5][1]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['goods'][6][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][6][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['goods'][7]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<?php endforeach; endif; unset($_from); ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
