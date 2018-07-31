{$var.html_header}
<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>   
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>   

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_round_staff.error != null}
    <li>a{$form.form_round_staff.error}
{/if}
{if $form.form_multi_staff.error != null}
    <li>b{$form.form_multi_staff.error}
{/if}
{if $form.form_round_day.error != null}
    <li>c{$form.form_round_day.error}
{/if}
{if $form.form_slip_no.error != null}
    <li>d{$form.form_slip_no.error}
{/if}

{if $var.error_msg != null}
    <li>{$var.error_msg}
{/if}
{if $var.error_msg2 != null}
    <li>{$var.error_msg2}
{/if}
{if $var.error_msg3 != null}
    <li>{$var.error_msg3}
{/if}

{* 既に巡回報告されていないかチェック *}
{if $var.trust_confirm_err != null}
    <li>{$var.trust_confirm_err}<br>
    {foreach from=$var.trust_confirm_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 巡回日チェック月次（委託先が得意先に対して月次やってたら売上確定できないので） *}
{if $var.ord_time_itaku_err != null}
    <li>{$var.ord_time_itaku_err}<br>
    {foreach from=$var.ord_time_itaku_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 削除されているかチェック *}
{if $var.del_err != null}
    <li>{$var.del_err}<br>
    {foreach from=$var.del_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 巡回日チェック月次（自分が委託先に対して月次やってたらダメ） *}
{if $var.ord_time_err != null}
    <li>{$var.ord_time_err}<br>
    {foreach from=$var.ord_time_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* システム開始日チェック *}
{if $var.ord_time_start_err != null}
    <li>{$var.ord_time_start_err}<br>
    {foreach from=$var.ord_time_start_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 巡回日が前回の請求締日以降かチェック *}
{if $var.claim_day_bill_err != null}
    <li>{$var.claim_day_bill_err}<br>
    {foreach from=$var.claim_day_bill_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 番号が重複した場合 *}
{if $var.error_sale != null}
    <li>{$var.error_sale}<br>
    {foreach from=$var.err_sale_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{* 予定巡回日が未来日付の場合のエラー *}
{if $var.err_future_date_msg != null}
    <li>{$var.err_future_date_msg}<br>
    {foreach from=$var.ary_future_date_no key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}

{* 商品予定出荷してないエラー *}
{if $var.move_warning != null}
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
    {$var.move_warning}</font><br>
    {$form.form_confirm_warn.html}<br><br>
    </td></tr>
</table>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$html_s}
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{$html_l}
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
