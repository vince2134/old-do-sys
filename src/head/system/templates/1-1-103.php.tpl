{$var.html_header}

<script language="javascript">
{$var.code_value}
{$var.contract}
{$var.rank_name}
 </script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_area_1.error != null}
        <li>{$form.form_area_1.error}<br>
    {/if}
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_shop_gr_1.error != null}
        <li>{$form.form_shop_gr_1.error}<br>
    {/if}
    {if $form.form_rank.error != null}
        <li>{$form.form_rank.error}<br>
    {/if}
    {if $form.form_shop_cd.error != null}
        <li>{$form.form_shop_cd.error}<br>
    {elseif $var.shop_cd_err != null}
        <li>{$var.shop_cd_err}<br>
    {/if}
    {if $form.form_shop_name.error != null}
        <li>{$form.form_shop_name.error}<br>
    {/if}
    {if $form.form_shop_cname.error != null}
        <li>{$form.form_shop_cname.error}<br>
    {/if}
    {if $form.form_comp_name.error != null}
        <li>{$form.form_comp_name.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error}<br>
    {elseif $var.tel_err != null}
        <li>{$var.tel_err}<br>
    {/if}
    {if $form.form_fax.error != null}
        <li>{$form.form_fax.error}<br>
    {/if}
    {if $var.email_err != null}
        <li>{$var.email_err}<br>
    {/if}
    {if $var.url_err != null}
        <li>{$var.url_err}<br>
    {/if}
    {if $form.form_represent_name.error != null}
        <li>{$form.form_represent_name.error}<br>
    {/if}
    {if $form.form_represent_cell.error != null}
        <li>{$form.form_represent_cell.error}<br>
    {/if}
    {if $form.form_direct_tel.error != null}
        <li>{$form.form_direct_tel.error}<br>
    {elseif $var.d_tel_err != null}
        <li>{$var.d_tel_err}<br>
    {/if}
    {if $form.form_contact_cell.error != null}
        <li>{$form.form_contact_cell.error}<br>
    {/if}
    {if $form.form_account_tel.error != null}
        <li>{$form.form_account_tel.error}<br>
    {/if}
    {if $form.form_join_money.error != null}
        <li>{$form.form_join_money.error}<br>
    {/if}
    {if $form.form_assure_money.error != null}
        <li>{$form.form_assure_money.error}<br>
    {/if}
    {if $form.form_royalty.error != null}
        <li>{$form.form_royalty.error}<br>
    {/if}
    {if $form.form_accounts_month.error != null}
        <li>{$form.form_accounts_month.error}<br>
    {/if}
    {if $form.form_limit_money.error != null}
        <li>{$form.form_limit_money.error}<br>
    {/if}
    {if $form.trade_aord_1.error != null}
        <li>{$form.trade_aord_1.error}<br>
    {/if}
    {if $form.trade_buy_1.error != null}
        <li>{$form.trade_buy_1.error}<br>
    {/if}
    {if $form.form_capital_money.error != null}
        <li>{$form.form_capital_money.error}<br>
    {/if}
    {if $form.form_close_1.error != null}
        <li>{$form.form_close_1.error}<br>
    {/if}
    {if $form.form_pay_month.error != null}
        <li>{$form.form_pay_month.error}<br>
    {/if}
    {if $form.form_pay_day.error != null}
        <li>{$form.form_pay_day.error}<br>
    {/if}
    {if $form.form_payout_month.error != null}
        <li>{$form.form_payout_month.error}<br>
    {/if}
    {if $form.form_payout_day.error != null}
        <li>{$form.form_payout_day.error}<br>
    {/if}
    {if $form.form_cont_s_day.error != null}
        <li>{$form.form_cont_s_day.error}<br>
    {/if}
    {if $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    {if $form.form_cont_peri.error != null}
        <li>{$form.form_cont_peri.error}<br>
    {/if}
    {if $var.rday_err != null}
        <li>{$var.rday_err}<br>
    {elseif $var.sday_rday_err != null}
        <li>{$var.sday_rday_err}<br>
    {/if}
    {if $form.form_open_day.error != null}
        <li>{$form.form_open_day.error}<br>
    {elseif $var.eday_err != null}
        <li>{$var.eday_err}<br>
    {/if}
    {if $form.form_establish_day.error != null}
        <li>{$form.form_establish_day.error}<br>
    {/if}
    {if $form.form_corpo_day.error != null}
        <li>{$form.form_corpo_day.error}<br>
    {elseif $var.cday_err != null}
        <li>{$var.cday_err}<br>
    {/if}
    {if $form.form_deli_comment.error != null}
        <li>{$form.form_deli_comment.error}<br>
    {/if}
    {if $var.contact_cell_err != null}
        <li>{$var.contact_cell_err}<br>
    {/if}
    {if $var.account_tel_err != null}
        <li>{$var.account_tel_err}<br>
    {/if}
    {if $var.represent_cell_err != null}
        <li>{$var.represent_cell_err}<br>
    {/if}
    {if $var.claim_close_day_err != null}
        <li>{$var.claim_close_day_err}<br>
    {/if}
    {if $var.claim_coax_err != null}
        <li>{$var.claim_coax_err}<br>
    {/if}
    {if $var.claim_err != null}
        <li>{$var.claim_err}<br>
    {/if}
    {if $var.claim_tax_franct_err != null}
        <li>{$var.claim_tax_franct_err}<br>
    {/if}
    {if $var.claim_c_tax_div_err != null}
        <li>{$var.claim_c_tax_div_err}<br>
    {/if}
    {if $var.claim_tax_div_err != null}
        <li>{$var.claim_tax_div_err}<br>
    {/if}
    {if $var.close_day_err != null}
        <li>{$var.close_day_err}<br>
    {/if}
    {if $var.close_outday_err != null}
        <li>{$var.close_outday_err}<br>
    {/if}
    {if $var.shop_name_err != null}
        <li>{$var.shop_name_err}<br>
    {/if}
    {if $var.comp_name1_err != null}
        <li>{$var.comp_name1_err}<br>
    {/if}
    {if $var.comp_name2_err != null}
        <li>{$var.comp_name2_err}<br>
    {/if}
    {if $var.address1_err != null}
        <li>{$var.address1_err}<br>
    {/if}
    {if $var.address2_err != null}
        <li>{$var.address2_err}<br>
    {/if}
    {if $var.address3_err != null}
        <li>{$var.address3_err}<br>
    {/if}
    </span><br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

{$form.hidden}
<table width="880">
    <tr>
        <td align="right">
            {if $smarty.get.client_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>

<table width="880">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Type" width="60" align="center"><b>状態</b></td>
                    <td class="Value" width="*">{$form.form_state.html}</td>
                </tr>
            </table>
        </td>
       </tr>   
</table>

<table width="880">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>地区<font color="#ff0000">※</font></b></td>
                    <td class="Value" width="*">{$form.form_area_1.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>業種<font color="#ff0000">※</font></b></td>
                    <td class="Value" width="*">{$form.form_btype.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>施設</b></td>
                    <td class="Value" width="*">{$form.form_inst.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="438">
                <tr>
                    <td class="Title_Purple" width="60"><b>業態</b></td>
                    <td class="Value" width="*">{$form.form_bstruct.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td colspan="2">
            <table width="880" class="Data_Table" border="1">
                <tr style="font-weight: bold;">
                    <td class="Title_Purple" width="60" nowrap>SV</td>
                    <td class="Value">{$form.form_staff_1.html}</td>
                    <td class="Title_Purple" width="60" nowrap>担当1</td>
                    <td class="Value">{$form.form_staff_2.html}</td>
                    <td class="Title_Purple" width="60" nowrap>担当2</td>
                    <td class="Value">{$form.form_staff_3.html}</td>
                    <td class="Title_Purple" width="60" nowrap>担当3</td>
                    <td class="Value">{$form.form_staff_4.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table>
    <tr>
        <td>

<div style="text-align: right; font: bold; color: #3300ff;">
    ・請求書の宛先とラベルのフォントサイズを大きく印字する場合、ショップ名と社名1と2は１４文字以内、住所1〜3は１８文字以内で登録して下さい。
</div>

<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple">FC・取引先区分<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_rank.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップコード<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">
        {$form.form_shop_cd.html}{if $var.freeze_flg != true}　（{$form.form_cd_search.html}）{/if}
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップ名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_shop_name.html}</td>
        <td class="Title_Purple">ショップ名<br>(フリガナ)</td>
        <td class="Value">{$form.form_shop_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_shop_cname.html}</td>
        <td class="Title_Purple">略称<br>(フリガナ)</td>
        <td class="Value">{$form.form_cname_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">敬称</td>
        <td class="Value" colspan="3">{$form.form_prefix.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">社名1<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_comp_name.html}</td>
        <td class="Title_Purple">社名1<br>(フリガナ)</td>
        <td class="Value">{$form.form_comp_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">社名2</b></td>
        <td class="Value">{$form.form_comp_name2.html}</td>
        <td class="Title_Purple">社名2<br>(フリガナ)</td>
        <td class="Value">{$form.form_comp_read2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_post.html}　　{$form.button.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_address1.html}</td>
        <td class="Title_Purple">住所2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所3<br>(ビル名・他)</td>
        <td class="Value">{$form.form_address3.html}</td>
        <td class="Title_Purple">住所2<br>(フリガナ)</td>
        <td class="Value">{$form.form_address_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_tel.html}</td>
        <td class="Title_Purple">FAX</td>
        <td class="Value">{$form.form_fax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Email</td>
        <td class="Value">{$form.form_email.html}</td>
        <td class="Title_Purple">URL</td>
        <td class="Value">{$form.form_url.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">資本金</td>
        <td class="Value" colspan="3">{$form.form_capital_money.html}万円</td>
    </tr>
    <tr>
        <td class="Title_Purple">代表者氏名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_represent_name.html}</td>
        <td class="Title_Purple">代表者役職</td>
        <td class="Value">{$form.form_represent_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">代表者携帯</td>
        <td class="Value">{$form.form_represent_cell.html}</td>
        <td class="Title_Purple">直通TEL</td>
        <td class="Value">{$form.form_direct_tel.html}</td>
    </tr>
</table>

<br>

<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple">加盟金</td>
        <td class="Value">{$form.form_join_money.html}円</td>
        <td class="Title_Purple">保証金</td>
        <td class="Value">{$form.form_assure_money.html}円</td>
    </tr>
    <tr>
        <td class="Title_Purple">ロイヤリティ<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_royalty.html}％</td>
    </tr>
    <tr>
        <td class="Title_Purple">決算日</td>
        <td class="Value">{$form.form_accounts_month.html}月 {$form.form_accounts_day.html}日</td>
        <td class="Title_Purple">回収条件</td>
        <td class="Value">{$form.form_collect_terms.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">与信限度</td>
        <td class="Value" colspan="3">{$form.form_limit_money.html}万円</td>
    </tr>
    <tr>
        <td class="Title_Purple">締日<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_close_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_claim_link.html}</td>
        <td class="Value" colspan="3">{$form.form_claim.html}</td>
    </tr>

</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">得意先情報</span>
<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="145" style="font-weight: bold;">
<col>
<col width="145" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">集金日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_pay_month.html}の{$form.form_pay_day.html}</td>
        <td class="Title_Purple">集金方法</td>
        <td class="Value">{$form.form_pay_way.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">振込名義</td>
        <td class="Value">{$form.form_transfer_name.html}</td>
        <td class="Title_Purple">口座名義</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">振込銀行</td>
        <td class="Value" colspan="3">{$form.form_bank_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.trade_aord_1.html}</td>
    </tr>
</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">仕入先情報</span>
<table class="Data_Table" border="1" width="880" style="border: 2px solid #3300ff;">
<col width="145" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">支払日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_payout_month.html}の{$form.form_payout_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">振込口座</td>
        <td class="Value">{$form.form_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">振込口座略称</td>
        <td class="Value" colspan="3">{$form.form_b_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.trade_buy_1.html}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="880">
<col width="62" style="font-weight: bold;">
<col width="85" style="font-weight: bold;">
<col width="285">
<col width="150" style="font-weight: bold;">
<col width="285">
    <tr>
        <td class="Title_Purple" colspan="2">連絡ご担当者氏名</td>
        <td class="Value">{$form.form_contact_name.html}</td>
        <td class="Title_Purple">役職</td>
        <td class="Value" colspan="2">{$form.form_contact_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">携帯</td>
        <td class="Value" colspan="4">{$form.form_contact_cell.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">会計ご担当者氏名</td>
        <td class="Value">{$form.form_accountant_name.html}</td>
        <td class="Title_Purple">携帯</td>
        <td class="Value" colspan="2">{$form.form_account_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">保証人1</td>
        <td class="Value">{$form.form_guarantor1.html}</td>
        <td class="Title_Purple">住所</td>
        <td class="Value" colspan="2">{$form.form_guarantor1_address.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">保証人2</td>
        <td class="Value">{$form.form_guarantor2.html}</td>
        <td class="Title_Purple">住所</td>
        <td class="Value" colspan="2">{$form.form_guarantor2_address.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">営業拠点</td>
        <td class="Value">{$form.form_position.html}</td>
        <td class="Title_Purple">休日</td>
        <td class="Value" colspan="2">{$form.form_holiday.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">商圏</td>
        <td class="Value" colspan="4">{$form.form_business_limit.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">契約会社名</td>
        <td class="Value">{$form.form_contract_name.html}</td>
        <td class="Title_Purple">契約代表者名</td>
        <td class="Value" colspan="2">{$form.form_represent_contract.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">契約年月日</td>
        <td class="Value">{$form.form_cont_s_day.html}</td>
        <td class="Title_Purple">契約更新日</td>
        <td class="Value" colspan="2">{$form.form_cont_r_day.html}</td>
    </tr>
        <td class="Title_Purple" colspan="2">契約期間</td>
        <td class="Value">{$form.form_cont_peri.html}年</td>
        <td class="Title_Purple">契約終了日</td>
        <td class="Value" colspan="2">{$form.form_cont_e_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">創業日</td>
        <td class="Value">{$form.form_establish_day.html}</td>
        <td class="Title_Purple">法人登記日</td>
        <td class="Value" colspan="2">{$form.form_corpo_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">伝票発行<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.form_slip_issue.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">納品書コメント</td>
        <td class="Value" colspan="4">{$form.form_deliver_radio.html}<br>{$form.form_deli_comment.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">請求書</td>
        <td class="Title_Purple">宛先</td>
        <td class="Value" colspan="4">{$form.form_bill_address_font.html}　請求書の宛先とラベルのフォントサイズを大きくする</td>
    </tr>
<!--
    <tr>
        <td class="Title_Purple">請求範囲<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.form_claim_scope.html}</td>
    </tr>
-->
    <tr>
        <td class="Title_Purple">発行<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.form_claim_issue.html}<br>
        <font color="#0000FF"><b>※ 請求の親子関係がない場合、個別明細請求書は明細請求書と同様です。</b></font></td>
    </tr>
    <tr>
        <td class="Title_Purple">送付<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.form_claim_send.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">様式<font color="#ff0000">※</font></td>
        <td class="Value" colspan="4">{$form.claim_pattern.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">金額<font color="#ff0000">※</font></td>
        <td class="Title_Purple">まるめ区分</td>
        <td class="Value" colspan="4">{$form.form_coax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">消費税<font color="#ff0000">※</font></td>
        <td class="Title_Purple">課税単位</td>
        <td class="Value" colspan="4">{$form.form_tax_unit.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">端数区分</td>
        <td class="Value" colspan="4">{$form.from_fraction_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分</td>
        <td class="Value" colspan="4">{$form.form_c_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">取得資格・得意分野</td>
        <td class="Value" colspan="4">{$form.form_qualify_pride.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">特約</td>
        <td class="Value" colspan="4">{$form.form_special_contract.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">取引履歴</td>
        <td class="Value" colspan="4">{$form.form_record.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">重要事項</td>
        <td class="Value" colspan="4">{$form.form_important.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">その他</td>
        <td class="Value" colspan="4">{$form.form_other.html}</td>
    </tr>
</table>
<table width="880">
    <tr>
        <td>
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        <td align="right">
            {*{$form.comp_button.html}　　{$form.contract_button.html}　　{$form.return_button.html}　　{$form.button.entry_button.html}　　{$form.button.res_button.html}　　{$form.button.back_button.html}*}
            {$form.comp_button.html}　　{$form.return_button.html}　　{$form.button.entry_button.html}　　{$form.button.res_button.html}　　{$form.button.back_button.html}
        </td>
    </tr>
</table>

        </td>
    </tr>
</table>

{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
