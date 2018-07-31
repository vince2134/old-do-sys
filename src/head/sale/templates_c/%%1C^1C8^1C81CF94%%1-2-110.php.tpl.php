<?php /* Smarty version 2.6.14, created on 2010-01-14 15:54:19
         compiled from 1-2-110.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<?php echo $this->_tpl_vars['var']['form_potision']; ?>



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
<?php if ($this->_tpl_vars['form']['form_order_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_order_no']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_designated_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_designated_date']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ord_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ord_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_hope_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_hope_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_arr_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_arr_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_ware_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ware_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['trade_aord_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['trade_aord_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_staff_select']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_staff_select']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_note_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_note_client']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_note_head']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_note_head']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_sale_num']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_num']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error0'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error0']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error1'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error1']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error2']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error3'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error3']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error4'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error4']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error5'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error5']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['duplicate_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['duplicate_err']; ?>
<br>
<?php endif; ?>
</span>

<!-- フリーズ画面判定 -->
<?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    <span style="font: bold;"><font size="+1">以下の内容で受注しますか？</font></span><br>
<?php endif; ?>


<table>
    <tr>
        <td>

<table class="Data_Table" border="1">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_order_no']['html']; ?>
</td>
        <td class="Title_Pink">得意先</a></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Pink">FC発注番号</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fc_order_no']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ord_day']['html']; ?>
</td>
        <td class="Title_Pink">出荷可能数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_designated_date']['html']; ?>
 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['trade_aord_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_arr_day']['html']; ?>
</td>
        <td class="Title_Pink">直送先</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">希望納期</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_hope_day']['html']; ?>
</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_select']['html']; ?>
</td>
        <td class="Title_Pink">担当者<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_client']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_note_head']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php if ($this->_tpl_vars['var']['warning'] != null): ?><font color="#ff0000"><?php echo $this->_tpl_vars['var']['warning']; ?>
</font><?php endif; ?>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="900">
    <tr class="Result1" align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink" width="300">商品コード<font color="#ff0000">※</font><br>商品名<font color="#ff0000">※</font></td>
        <td class="Title_Pink">実棚数<br>(A)</td>
        <td class="Title_Pink">発注済数<br>(B)</td>
        <td class="Title_Pink">引当数<br>(C)</td>
        <td class="Title_Pink">出荷可能数<br>(A+B-C)</td>
        <td class="Title_Pink">受注数<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
                    <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
                    <td class="Title_Pink" align="center" width="80"><b>税込合計</b></td>
                    <td class="Value" align="right" width="100"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
                </tr>
        </table>
        </td>
        <?php if ($this->_tpl_vars['var']['warning'] == null): ?>
        <td align="center">
            <?php echo $this->_tpl_vars['form']['form_sum_button']['html']; ?>

        </td>
        <?php endif; ?>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right"><?php if ($this->_tpl_vars['var']['freeze_flg'] != true):  echo $this->_tpl_vars['form']['order_conf']['html'];  else:  echo $this->_tpl_vars['form']['order']['html'];  endif;  if ($this->_tpl_vars['var']['aord_id'] != null): ?>　　<?php echo $this->_tpl_vars['form']['complete']['html'];  endif; ?></td>
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
