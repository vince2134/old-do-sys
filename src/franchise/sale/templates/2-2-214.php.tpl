{$var.html_header}

<script language="javascript">
{$var.order_sheet}
</script>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    {if $var.freeze_flg == true}
        <tr align="center" valign="top" height="160">
    {else}
        <tr align="center" valign="top">
    {/if}
        <td>
            <table>
                <tr>
                    <td>

{* 分割設定エラーメッセージ *}
{if $var.ary_division_err_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {foreach key=i from=$var.ary_division_err_msg item=division_err_msg}<li>{$division_err_msg}</li><br>{/foreach}
    </span>
{/if}

{* フォームエラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.form_split_pay_amount item=item key=i}
    {if $form.form_split_pay_amount[$i].error != null}
        <li>{$form.form_split_pay_amount[$i].error}</li><br>
    {/if}
{/foreach}
{if $form.form_trade_sale.error != null}
    <li>{$form.form_trade_sale.error}<br>
{/if}
{if $form.form_claim_day.error != null}
    <li>{$form.form_claim_day.error}<br>
{/if}
{if $var.client_msg != null}
    <li>{$var.client_msg}<br>
{/if}
{if $var.renew_msg != null}
    <li>{$var.renew_msg}<br>
{/if}
</span>

{* 分割売上登録完了メッセージ *}
{if $var.division_comp_flg == true}
    <span style="font: bold 15px; color: #555555;">分割売上登録完了しました。<br><br></span>
{/if}

<!-- 登録確認メッセージ表示 -->
{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="675">
<col width="80" style="font-weight: bold;">
<col>
<col width="60" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" >{$form.form_sale_no.html}</td>
        <td class="Title_Pink">得意先</td>
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value" >{$form.form_trade_sale.html}</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value" colspan="3">{$form.form_direct_name.html}</td>
        <td class="Title_Pink">売上担当者</td>
        <td class="Value">{$form.form_cstaff_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷倉庫</td>
        <td class="Value">{$form.form_ware_name.html}</td>
        <td class="Title_Pink">請求日</td>
        <td class="Value">{$form.form_claim_day.html}</td>
        <td class="Title_Pink">売上計上日</td>
        <td class="Value">{$form.form_sale_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">備考</td>
        <td class="Value" colspan="5">{$form.form_note.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="100%">
    <tr>
        <td class="Title_Blue" width="80" align="center"><b>税抜金額</b></td>
        <td class="Value" align="right">{$form.form_sale_total.html}</td>
        <td class="Title_Blue" width="80" align="center"><b>消費税</b></td>
        <td class="Value" align="right">{$form.form_sale_tax.html}</td>
        <td class="Title_Blue" width="80" align="center"><b>税込金額</b></td>
        <td class="Value" align="right">{$form.form_sale_money.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{$form.hidden}
<table width="100%" >
    <tr>
        <td>

{* 分割確認時のみ *}
{if $var.division_flg == "true"}
<table class="List_Table" border="1" align="center" width="400">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Purple">分割回数</td>
        <td class="Title_Purple">分割回収日</td>
        <td class="Title_Purple">分割回収金額</td>
    </tr>
    {foreach from=$form.form_pay_date item=item key=i}
    <tr>
        <td class="value" align="right">{$i+1}</td>
        <td class="value" align="center">{$form.form_pay_date[$i].html}</td>
        <td class="value" align="right">{$form.form_pay_amount[$i].html}</td>
    </tr>
    {/foreach}
</table>

<table width="400" align="center">
    <tr>
        <td align="right">{$form.return_button.html}</td>
    </tr>
</table>

{* 分割設定時のみ *}
{else}

<table align="center">
    <tr>
        <td>
            <table class="List_Table" border="1" width="550" align="left">
                <tr>
                    <td class="Title_Purple" align="center" width="100"><b>回収開始日<font color="#ff0000">※</font></b></td>
                    <td class="Value">請求日の　{$form.form_pay_m.html} から　毎月 {$form.form_pay_d.html}</td>
                    <td class="Title_Purple" align="center" width="80"><b>分割回数<font color="red">※</font></b></td>
                    <td class="Value">{$form.form_division_num.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table> 
                <tr>    
                    <td>{if $var.division_comp_flg != true}　　{$form.form_conf_button.html}　　{$form.return_button.html}{/if}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{if $var.division_set_flg === true}
        </td>
    </tr>
    <tr>
        <td align="center">

<br>
<table>
    <tr>
        <td>
            <table class="List_Table" border="1" align="center" width="400">
                <tr style="font-weight: bold;" align="center">
                    <td class="Title_Purple">分割回数</td>
                    <td class="Title_Purple">分割回収日</td>
                    <td class="Title_Purple">分割回収金額<font color="red">※</font></td>
                </tr>
                {foreach from=$form.form_split_pay_amount item=item key=i}
                <tr>
                    <td class="value" align="right">{$i+1}</td>
                    <td class="value" align="center">{$form.form_pay_date[$i].html}</td>
                    <td class="value" align="right">{$form.form_split_pay_amount[$i].html}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {if $var.division_comp_flg != true}
    <tr>
        <td align="right">{if $var.division_set_flg === true}　　{$form.add_button.html}{/if}</td>
    </tr>
    {/if}
    {if $var.division_comp_flg == true}
    <tr>
        <td align="right">{$form.ok_button.html}　　{$form.return_button.html}</td>
    </tr>
    {/if}
</table>
{/if}
{/if}

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
