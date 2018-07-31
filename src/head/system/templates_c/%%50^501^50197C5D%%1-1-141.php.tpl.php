<?php /* Smarty version 2.6.9, created on 2006-12-01 14:35:10
         compiled from 1-1-141.php.tpl */ ?>
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

<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" height="35" width="450">
    <tr>
        <td class="Title_Purple" width="130"><b>ショップ名</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fshop_select']['html']; ?>
</td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">申請担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shinsei_tantou_select']['html']; ?>
</td>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_junkai_tantou_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">お客様名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_name']['html']; ?>
</td>
        <td class="Title_Purple">お客様TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">お客様住所</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル申込日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_moushikomi_date']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">レンタル出荷日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_syukka_date']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">本部担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_honbu_tantou_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求日</td>
        <td class="Value">2006年 <?php echo $this->_tpl_vars['form']['form_seikyu_month_select']['html']; ?>
 月から<?php if ($this->_tpl_vars['form']['form_seikyu_date_static']['html'] != null): ?>　毎月 <?php echo $this->_tpl_vars['form']['form_seikyu_date_static']['html'];  endif; ?></td>
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

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <?php if ($this->_tpl_vars['var']['state'] != null): ?><td class="Title_Purple">状況</td><?php endif; ?>
        <td class="Title_Purple">数量</td>
        <?php if ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'off'): ?><td class="Title_Purple">解約</td><?php endif; ?>
        <?php if ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'off'): ?><td class="Title_Purple">解約数</td><?php endif; ?>
        <?php if ($this->_tpl_vars['var']['state'] == 'chg_req'): ?><td class="Title_Purple">解約申請数</td><?php endif; ?>
        <?php if ($this->_tpl_vars['var']['state'] == 'non_req' || $this->_tpl_vars['var']['state'] == 'chg_req'): ?><td class="Title_Purple">解約日</td><?php endif; ?>
        <td class="Title_Purple">シリアル</td>
        <td class="Title_Purple">レンタル単価<br>　　　　金額</td>
        <td class="Title_Purple">ユーザ提供単価<br>　　　　　金額</td>
    </tr>
    <?php if ($this->_tpl_vars['var']['state'] == null): ?>
    <?php $_from = $this->_tpl_vars['disp_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['goods']):
?>
    <tr class="<?php echo $this->_tpl_vars['goods'][0]; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_name'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_goods_num'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td><?php $_from = $this->_tpl_vars['goods'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['serial']):
 if ($this->_tpl_vars['serial'] != ""):  echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html']; ?>
<br><?php endif;  endforeach; endif; unset($_from); ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_rental_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_user_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_user_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'off'): ?>
    <?php $_from = $this->_tpl_vars['disp_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['goods']):
?>
    <?php $_from = $this->_tpl_vars['goods'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['serial_item_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['serial_item_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['serial_item']):
        $this->_foreach['serial_item_count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['goods'][0]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][2]; ?>
</td>
        <?php endif; ?>
        <td align="center"<?php if ($this->_tpl_vars['serial_item'][0] == "契約中"): ?> style="color: #0000ff;"<?php endif; ?>><?php echo $this->_tpl_vars['serial_item'][0]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['serial_item'][1]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_kaiyaku_check'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_kaiyaku_num'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['serial_item'][2]; ?>
</td>
        <td><?php if ($this->_tpl_vars['serial_item'][3] != "-"):  echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html'];  else:  echo $this->_tpl_vars['serial_item'][3];  endif; ?></td>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['goods'][5][1]; ?>
</td>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['form']['form_user_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['goods'][6][1]; ?>
</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['state'] == 'new_req'): ?>
    <?php $_from = $this->_tpl_vars['disp_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['goods']):
?>
    <?php $_from = $this->_tpl_vars['goods'][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['serial_item_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['serial_item_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['serial_item']):
        $this->_foreach['serial_item_count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['goods'][0]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][2]; ?>
</td>
        <?php endif; ?>
        <td align="center" style="color: #0000ff;">新規申請</td>
        <td align="right"><?php echo $this->_tpl_vars['serial_item'][0]; ?>
</td>
        <td><?php if ($this->_tpl_vars['serial_item'][1] != "-"):  echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html'];  else:  echo $this->_tpl_vars['serial_item'][1];  endif; ?></td>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['goods'][4][1]; ?>
</td>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][5][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][5][1]; ?>
</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'on'): ?>
    <?php $_from = $this->_tpl_vars['disp_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['goods']):
?>
    <?php $_from = $this->_tpl_vars['goods'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['serial_item_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['serial_item_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['serial_item']):
        $this->_foreach['serial_item_count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['goods'][0]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['form']['form_goods_name'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="center"<?php if ($this->_tpl_vars['serial_item'][0] == "契約中"): ?> style="color: #0000ff;"<?php endif; ?>><?php echo $this->_tpl_vars['serial_item'][0]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['serial_item'][1]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['serial_item'][2]; ?>
</td>
        <td><?php if ($this->_tpl_vars['serial_item'][0] == "解約済" || $this->_tpl_vars['serial_item'][3] == "-"):  echo $this->_tpl_vars['serial_item'][3];  else:  echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html'];  endif; ?></td>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j'] >= $this->_tpl_vars['goods'][3]): ?>
        <td align="right"<?php if ($this->_tpl_vars['j'] == 0): ?> rowspan="<?php echo $this->_tpl_vars['goods'][3]; ?>
"<?php endif; ?>><?php if ($this->_tpl_vars['j'] == 0):  echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['goods'][5][1];  endif; ?></td>
        <td align="right"<?php if ($this->_tpl_vars['j'] == 0): ?> rowspan="<?php echo $this->_tpl_vars['goods'][3]; ?>
"<?php endif; ?>><?php if ($this->_tpl_vars['j'] == 0):  echo $this->_tpl_vars['goods'][6][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][6][1];  endif; ?></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['state'] == 'chg_req'): ?>
    <?php $_from = $this->_tpl_vars['disp_goods_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['goods']):
?>
    <?php $_from = $this->_tpl_vars['goods'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['serial_item_count'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['serial_item_count']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['serial_item']):
        $this->_foreach['serial_item_count']['iteration']++;
?>
    <tr class="<?php echo $this->_tpl_vars['goods'][0]; ?>
">
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td align="right" rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][1]; ?>
</td>
        <td rowspan="<?php echo $this->_foreach['serial_item_count']['total']; ?>
"><?php echo $this->_tpl_vars['goods'][2]; ?>
</td>
        <?php endif; ?>
        <td align="center"<?php if ($this->_tpl_vars['serial_item'][0] == "契約中"): ?> style="color: #0000ff;"<?php elseif ($this->_tpl_vars['serial_item'][0] == "解約申請"): ?> style="color: #ff0000;"<?php endif; ?>><?php echo $this->_tpl_vars['serial_item'][0]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['serial_item'][1]; ?>
</td>
        <td align="right" style="color: #ff0000;"><?php echo $this->_tpl_vars['serial_item'][2]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['serial_item'][3]; ?>
</td>
        <td><?php if ($this->_tpl_vars['serial_item'][0] == "解約済" || $this->_tpl_vars['serial_item'][4] == "-"):  echo $this->_tpl_vars['serial_item'][4];  else:  echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['html'];  endif; ?></td>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j'] >= $this->_tpl_vars['goods'][3]): ?>
        <td align="right"<?php if ($this->_tpl_vars['j'] == 0): ?> rowspan="<?php echo $this->_tpl_vars['goods'][3]; ?>
"<?php endif; ?>><?php if ($this->_tpl_vars['j'] == 0):  echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['html']; ?>
<br><?php echo $this->_tpl_vars['goods'][5][1];  endif; ?></td>
        <td align="right"<?php if ($this->_tpl_vars['j'] == 0): ?> rowspan="<?php echo $this->_tpl_vars['goods'][3]; ?>
"<?php endif; ?>><?php if ($this->_tpl_vars['j'] == 0):  echo $this->_tpl_vars['goods'][6][0]; ?>
<br><?php echo $this->_tpl_vars['goods'][6][1];  endif; ?></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
</table>

<table align="right">
    <tr>
        <td><?php if ($this->_tpl_vars['var']['state'] == null):  echo $this->_tpl_vars['form']['form_add_button']['html']; ?>
　　<?php elseif ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'off'):  echo $this->_tpl_vars['form']['form_chg_off_button']['html']; ?>
　　<?php elseif ($this->_tpl_vars['var']['state'] == 'new_req'):  echo $this->_tpl_vars['form']['form_new_accept_button']['html']; ?>
　　<?php elseif ($this->_tpl_vars['var']['state'] == 'non_req' && $this->_tpl_vars['var']['fshop_network'] == 'on'):  echo $this->_tpl_vars['form']['form_chg_on_button']['html']; ?>
　　<?php elseif ($this->_tpl_vars['var']['state'] == 'chg_req'):  echo $this->_tpl_vars['form']['form_chg_accept_button']['html']; ?>
　　<?php endif;  echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
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
