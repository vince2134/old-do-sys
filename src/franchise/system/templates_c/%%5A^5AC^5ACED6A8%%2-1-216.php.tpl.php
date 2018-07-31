<?php /* Smarty version 2.6.14, created on 2009-12-21 17:14:33
         compiled from 2-1-216.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['contract']; ?>

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
    <?php if ($this->_tpl_vars['form']['form_area_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_area_id']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_btype']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_shop_gr_1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_shop_gr_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['client_cd_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['client_cd_err']; ?>
<br>
    <?php elseif ($this->_tpl_vars['form']['form_client_cd']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client_cname']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_address1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_address1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_capital']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_capital']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_fax']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_fax']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['email_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['email_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['url_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['url_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_rep_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_rep_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_represent_cell']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_represent_cell']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_direct_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_direct_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['d_tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['d_tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['trade_ord']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_ord']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cshop']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cshop']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['close_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['close_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['c_staff_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['c_staff_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_close']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_close']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_m']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_m']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_d']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_pay_d']['error']; ?>
<bt>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_start']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_start']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['start_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['start_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trans_s_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_trans_s_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['sday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_charge_branch_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['error']; ?>
<br>
    <?php endif; ?>

    </span><br>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="810">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right"><?php if ($_GET['client_id'] != null):  echo $this->_tpl_vars['form']['back_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['next_button']['html'];  endif; ?></td> 
   </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Type" width="60" align="center"><b>状態</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>   
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>地区<font color="#ff0000">※</font></b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>業種<font color="#ff0000">※</font></b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>施設</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_inst']['html']; ?>
</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>業態</b></td>
                    <td class="Value"><?php echo $this->_tpl_vars['form']['form_bstruct']['html']; ?>
</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">仕入先コード<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">仕入先名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
        <td class="Title_Purple">仕入先名<br>(フリガナ)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">仕入先名2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name2']['html']; ?>
</td>
        <td class="Title_Purple">仕入先名2<br>(フリガナ)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_read2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cname']['html']; ?>
</td>
        <td class="Title_Purple">略称<br>(フリガナ)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cname_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['input_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
        <td class="Title_Purple">住所2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所3</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
        <td class="Title_Purple">住所2<br>(フリガナ)</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">資本金</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_capital']['html']; ?>
万円</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
        <td class="Title_Purple">FAX</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">Email</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_email']['html']; ?>
</td>
        <td class="Title_Purple" width="125">URL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">代表者氏名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rep_name']['html']; ?>
</td>
        <td class="Title_Purple">代表者役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_position']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">代表者携帯</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_cell']['html']; ?>
</td>
        <td class="Title_Purple">直通TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_tel']['html']; ?>
</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
<col width="64" style="font-weight: bold;">
<col width="84" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">窓口ご担当</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_charger']['html']; ?>
</td>
        <td class="Title_Purple">契約担当</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">仕入先部署</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_part']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['trade_ord']['html']; ?>
</td>
        <td class="Title_Purple">締日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_close']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" width="130" colspan="2">支払日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_m']['html']; ?>
の<?php echo $this->_tpl_vars['form']['form_pay_d']['html']; ?>
日</td>
        <td class="Title_Purple">支払条件</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_terms']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">振込口座</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bank']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">振込口座略称</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_b_bank_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">休日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_holiday']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">創業日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_start']['html']; ?>
</td>
        <td class="Title_Purple">取引開始日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_s_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" >金額<font color="#ff0000">※</font></td>
        <td class="Title_Purple" >まるめ区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_coax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">消費税<font color="#ff0000">※</font></td>
        <td class="Title_Purple">課税単位</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">端数区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_franct']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_c_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">担当支店<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">取引履歴</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_record']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">重要事項</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_important']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">備考</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['ok_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['back_button']['html']; ?>
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
