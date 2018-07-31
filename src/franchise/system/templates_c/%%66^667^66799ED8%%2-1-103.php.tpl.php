<?php /* Smarty version 2.6.14, created on 2010-05-11 15:41:19
         compiled from 2-1-103.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

<?php echo $this->_tpl_vars['var']['contract']; ?>

<?php echo $this->_tpl_vars['var']['js']; ?>

</script>

<body bgcolor="#D8D0C8" <?php if ($this->_tpl_vars['var']['complete_flg'] != true): ?> onLoad="<?php echo $this->_tpl_vars['var']['onload'];  if ($_SESSION['group_kind'] == '2'): ?>onload_code_disable() <?php endif; ?>"<?php endif; ?>>
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


<?php if ($this->_tpl_vars['var']['update_con_mesg'] != null): ?>
<div class="note">
	<li>丸め区分が変更されたため、以下の契約は金額の丸め処理を再実施しました。</li><br>
	<?php echo $this->_tpl_vars['var']['update_con_mesg']; ?>

</div>
<?php endif; ?>

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
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
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
    <?php if ($this->_tpl_vars['form']['form_client_gr']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_client_gr']['error']; ?>
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
    <?php if ($this->_tpl_vars['form']['form_parent_establish_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_parent_establish_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['parent_esday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['parent_esday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_company_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_company_tel']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['url_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['url_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['rep_cell_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['rep_cell_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_direct_tel']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_direct_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['d_tel_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['d_tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_trade_stime1']['error'] != null || $this->_tpl_vars['form']['form_trade_etime1']['error'] != null || $this->_tpl_vars['form']['form_trade_stime2']['error'] != null || $this->_tpl_vars['form']['form_trade_etime2']['error'] != null): ?>
        <li>営業時間は半角数字のみです。<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cledit_limit']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cledit_limit']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['close_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['close_err']; ?>
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
    <?php if ($this->_tpl_vars['form']['form_cont_s_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cont_s_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['sday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cont_peri']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cont_peri']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cont_r_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cont_r_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['rday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['rday_err']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['sday_rday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['sday_rday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_establish_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_establish_day']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['esday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['esday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['intro_act_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['intro_act_err']; ?>
<br>
    <?php endif; ?>
	<?php if ($this->_tpl_vars['form']['form_intro_act']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_intro_act']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_account']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_account']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cshop']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_cshop']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_round_start']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_round_start']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['rsday_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['rsday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['trade_aord_1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['trade_aord_1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_coax_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_coax_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_tax_franct_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_tax_franct_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_month_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_month_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['claim1_monthly_check'][0]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['claim1_monthly_check'][0]['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['claim2_monthly_check'][0]['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['claim2_monthly_check'][0]['error']; ?>
<br>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['form']['form_s_pattern_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_s_pattern_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_c_pattern_select']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_c_pattern_select']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_c_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_c_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim2_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim2_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim2_coax_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim2_coax_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim2_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim2_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim2_tax_franct_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim2_tax_franct_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim2_c_tax_div_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim2_c_tax_div_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_deliver_note']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_deliver_note']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_charge_branch_id']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['del_err_mess'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['del_err_mess']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['claim_del_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['claim_del_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['client_name1_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['client_name1_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['client_name2_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['client_name2_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address1_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address1_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address2_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address2_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['address3_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['address3_err']; ?>
<br>
    <?php endif; ?>
</span>
<br>

<table width="810" >
    <tr>
        <td colspan="2">

<table width="100%">
    <tr>
        <td align="right"><?php if ($_GET['client_id'] != null):  echo $this->_tpl_vars['form']['back_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['next_button']['html'];  endif; ?></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="402">
    <tr>
        <td class="Type" width="60" align="center"><b>状態</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td>

<table class="Data_Table" border="1" width="502">
    <tr>
        <td class="Title_Purple" width="60"><b>グループ</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_gr']['html'];  echo $this->_tpl_vars['form']['form_parents_div']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr> 
    <tr>
        <td>

<table class="Data_Table" border="1" width="402">
    <tr>
        <td class="Title_Purple" width="60"><b>地区<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td>

<table class="Data_Table" border="1" width="402">
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

<table class="Data_Table" border="1" width="402">
    <tr>
        <td class="Title_Purple" width="60"><b>施設</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_inst']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td>

<table class="Data_Table" border="1" width="402">
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

                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

<div style="text-align: right; font: bold; color: #3300ff;">
    ・得意先名を伝票印字しない時は、得意先名の右隅のチェックを付けて下さい。
</div>
<div style="text-align: right; font: bold; color: #3300ff;">
    ・請求書の宛先とラベルのフォントサイズを大きく印字する場合、得意先名1と2は１４文字以内、住所1〜3は１８文字以内で登録して下さい。
</div>

<table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col width="400">
<col>
    <tr>
        <td class="Title_Purple">得意先コード<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">
        <?php echo $this->_tpl_vars['form']['form_client']['html'];  if ($this->_tpl_vars['var']['complete_flg'] != true): ?>　（<?php echo $this->_tpl_vars['form']['form_cd_search']['html']; ?>
）<?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先名1<font color="#ff0000">※</font>　<?php echo $this->_tpl_vars['form']['form_client_slip1']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
        <td class="Title_Purple">得意先名1<br>(フリガナ)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先名2　　<?php echo $this->_tpl_vars['form']['form_client_slip2']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name2']['html']; ?>

        <td class="Title_Purple">得意先名2<br>(フリガナ)</td>
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
        <td class="Title_Purple">敬称</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_prefix']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">代表者氏名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rep_name']['html']; ?>
</td>
        <td class="Title_Purple">代表者役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rep_position']['html']; ?>
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
        <td class="Title_Purple">住所3<br>(ビル名・他)</td>
        <td class="Value" colspan=><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
        <td class="Title_Purple">住所2<br>(フリガナ)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
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
        <td class="Title_Purple">創業日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_establish_day']['html']; ?>
</td>
        <td class="Title_Purple">担当者Email</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_email']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col width="400">
    <tr>
        <td class="Title_Parent">親会社名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_company_name']['html']; ?>
</td>
        <td class="Title_Parent">親会社TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_company_tel']['html']; ?>
</td>
    </tr>
    <tr>       
        <td class="Title_Parent">親会社住所</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_company_address']['html']; ?>
</td>
    </tr>  
    <tr>
        <td class="Title_Parent">資本金</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_capital']['html']; ?>
万円</td>
        <td class="Title_Parent">親会社創業日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_parent_establish_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Parent">親会社代表者氏名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_parent_rep_name']['html']; ?>
</td>
        <td class="Title_Parent">URL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="85" style="font-weight: bold;">
<col width="20" style="font-weight: bold;" align="center">
<col width="50" style="font-weight: bold;">
<col width="200">
<col width="50" style="font-weight: bold;">
<col width="200">
<col width="50" style="font-weight: bold;">
<col width="300">
    <tr>
        <td class="Title_Purple" rowspan="4">担当情報</td>
        <td class="Title_Purple">1</td>
        <td class="Title_Purple">部署</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_part1']['html']; ?>
</td>
        <td class="Title_Purple">役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_represe1']['html']; ?>
</td>
        <td class="Title_Purple">氏名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">2</td>
        <td class="Title_Purple">部署</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_part2']['html']; ?>
</td>
        <td class="Title_Purple">役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_represe2']['html']; ?>
</td>
        <td class="Title_Purple">氏名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">3</td>
        <td class="Title_Purple">部署</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_part3']['html']; ?>
</td>
        <td class="Title_Purple">役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger_represe3']['html']; ?>
</td>
        <td class="Title_Purple">氏名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charger3']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">備考</td>
        <td class="Value" colspan="5"><?php echo $this->_tpl_vars['form']['form_charger_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
<table class="Data_Table" border="1" width="100%">
<col width="65" style="font-weight: bold;">
<col width="93" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">営業時間</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade_stime1']['html']; ?>
 〜 <?php echo $this->_tpl_vars['form']['form_trade_etime1']['html']; ?>
 <br><?php echo $this->_tpl_vars['form']['form_trade_stime2']['html']; ?>
 〜 <?php echo $this->_tpl_vars['form']['form_trade_etime2']['html']; ?>
</td>
        <td class="Title_Purple">休日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_holiday']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2"><?php echo $this->_tpl_vars['form']['intro_claim_link']['html']; ?>
</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2"><?php echo $this->_tpl_vars['form']['intro_claim_link2']['html']; ?>
</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim2']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_warning']['html']; ?>
<br>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">請求月<font color="#000000">◆</font></td>
        <td class="Value" colspan="3">
        <font color="#0000ff"><b>・請求書を作成する月にチェックして下さい。</b></font>
        <br>
        <?php $_from = $this->_tpl_vars['form']['claim1_monthly_check']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
            <?php echo $this->_tpl_vars['form']['claim1_monthly_check'][$this->_tpl_vars['i']]['html']; ?>

        <?php endforeach; endif; unset($_from); ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">与信限度</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cledit_limit']['html']; ?>
万円</td>
        <td class="Title_Purple">回収条件</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_col_terms']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['trade_aord_1']['html']; ?>
<b><font color="#ff0000">★</font><font color="#0000ff">現金売上の場合も入金漏れの防止のため毎月請求書作成を行なって下さい。</font></b></td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">締日<font color="#ff0000">※</font><font color="#000000">◆</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_close']['html']; ?>
</td>
        <td class="Title_Purple">集金日<font color="#ff0000">※</font><font color="#000000">◆</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_m']['html']; ?>
の<?php echo $this->_tpl_vars['form']['form_pay_d']['html']; ?>
<b><font color="#ff0000">★</font><font color="#0000ff">現金売上については締日と集金日は同一です。</font></b></td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">集金方法</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_pay_way']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">振込銀行口座</td>
        <td class="Value"colspan="3"><?php echo $this->_tpl_vars['form']['form_bank']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">振込名義1</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_name']['html']; ?>
</td>
        <td class="Title_Purple">振込名義2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_name']['html']; ?>
</td>
   </tr>
    <tr>
        <td class="Title_Purple" colspan="2">銀行手数料負担区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bank_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">契約年月日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_s_day']['html']; ?>
</td>
        <td class="Title_Purple">契約更新日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_r_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">契約期間</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_peri']['html']; ?>
年</td>
        <td class="Title_Purple">契約終了日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cont_e_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">売上伝票</td>
        <td class="Title_Purple">発行<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_slip_out']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">発行元<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_s_pattern_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">コメント</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_deliver_radio']['html']; ?>
<br>
        <font color="#0000FF"><b>・個別コメントを選択した場合、登録したコメントが請求書以外で有効になります。</b></font><br>
        <?php echo $this->_tpl_vars['form']['form_deliver_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="5">請求書</td>
        <td class="Title_Purple">宛先</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_bill_address_font']['html']; ?>
　請求書の宛先とラベルのフォントサイズを大きくする</td>
    </tr>
<!--
    <tr>
        <td class="Title_Purple">請求範囲<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim_scope']['html']; ?>
</td>
    </tr>
-->
    <tr>
        <td class="Title_Purple">発行<font color="#ff0000">※</font><font color="#000000">◆</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim_out']['html']; ?>
<br>
        <font color="#0000FF"><b>・請求の親子関係がない場合、個別明細請求書は明細請求書と同様です。</b></font></td>
    </tr>
    <tr>
        <td class="Title_Purple">送付<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim_send']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">発行元<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_c_pattern_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_claim_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">金額<font color="#ff0000">※</font></td>
        <td class="Title_Purple">まるめ区分<font color="#000000">◆</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_coax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">消費税<font color="#ff0000">※</font></td>
        <td class="Title_Purple">課税単位<font color="#000000">◆</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">端数区分<font color="#000000">◆</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_franct']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分<font color="#000000">◆</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_c_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">設備情報等・その他</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['intro_act_link']['html']; ?>
</td>
        <td class="Value"><?php if ($_SESSION['group_kind'] == '2'):  echo $this->_tpl_vars['form']['form_client_div']['html']; ?>
　<?php endif;  echo $this->_tpl_vars['form']['form_intro_act']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">お振込先口座名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trans_account']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">銀行/支店名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bank_fc']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_account_num']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">担当支店<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_charge_branch_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">現契約担当</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_id1']['html']; ?>
</td>
        <td class="Title_Purple">初期契約社員</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff_id2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">巡回開始日</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_round_start']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引履歴</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_record']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">重要事項</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_important']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です。</b></font>　　<font color="#000000">◆</font><font color="#555555"><b>の項目に関して：請求時は請求先の設定に合わせます。</b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['entry_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['button']['ok_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['contract_button']['html']; ?>
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
