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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{* フォームエラー *}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}
{/if}
{if $form.form_round_day.error != null}
    <li>{$form.form_round_day.error}
{/if}
{if $form.form_claim_day.error != null}
    <li>{$form.form_claim_day.error}
{/if}
{if $form.form_slip_no.error != null}
    <li>{$form.form_slip_no.error}
{/if}
{if $form.form_round_staff.error != null}
    <li>{$form.form_round_staff.error}
{/if}

{* その他のエラー *}
{if $msg.error_pay_no != null}
    <li>{$msg.error_pay_no}<br>
    {foreach from=$msg.ary_err_pay_no          key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.error_buy_no != null}
    <li>{$msg.error_buy_no}<br>
    {foreach from=$msg.ary_err_buy_no          key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.deli_day_start_err != null}
    <li>{$msg.deli_day_start_err}<br>
    {foreach from=$msg.ary_err_deli_day_start  key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.deli_day_renew_err != null}
    <li>{$msg.deli_day_renew_err}<br>
    {foreach from=$msg.ary_err_deli_day_renew  key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.claim_day_start_err != null}
    <li>{$msg.claim_day_start_err}<br>
    {foreach from=$msg.ary_err_claim_day_start key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.claim_day_renew_err != null}
    <li>{$msg.claim_day_renew_err}<br>
    {foreach from=$msg.ary_err_claim_day_renew key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.claim_day_bill_err != null}
    <li>{$msg.claim_day_bill_err}<br>
    {foreach from=$msg.ary_err_claim_day_bill  key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.confirm_err != null}
    <li>{$msg.confirm_err}<br>
    {foreach from=$msg.ary_err_confirm         key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.del_err != null}
    <li>{$msg.del_err}<br>
    {foreach from=$msg.ary_err_del             key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.buy_err_mess1 != null}
    <li>{$msg.buy_err_mess1}<br>
    {foreach from=$msg.ary_err_buy1            key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.buy_err_mess2 != null}
    <li>{$msg.buy_err_mess2}<br>
    {foreach from=$msg.ary_err_buy2            key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.buy_err_mess3 != null}
    <li>{$msg.buy_err_mess3}<br>
    {foreach from=$msg.ary_err_buy3            key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.err_trade_advance_msg != null}
    <li>{$msg.err_trade_advance_msg}<br>
    {foreach from=$msg.ary_err_trade_advance   key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.err_future_date_msg != null}
    <li>{$msg.err_future_date_msg}<br>
    {foreach from=$msg.ary_err_future_date     key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.err_advance_fix_msg != null}
    <li>{$msg.err_advance_fix_msg}<br>
    {foreach from=$msg.ary_err_advance_fix     key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
{if $msg.err_paucity_advance_msg != null}
    <li>{$msg.err_paucity_advance_msg}<br>
    {foreach from=$msg.ary_err_paucity_advance key=i item=slip_no}　　{$slip_no}<br>{/foreach}
{/if}
</ul>
</span>

{* 商品予定出荷してないエラー *}
{if $msg.move_warning != null}
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[警告]<br>
    {$msg.move_warning}</font><br>
    {$form.form_confirm_warn.html}<br><br>
    </td></tr>
</table>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$html.html_s}
{*--------------- 画面表示１ e n d ---------------*}

                    </td>   
                </tr>   
                <tr style="page-break-before: always;">    
                    <td>    

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{$html.html_l}
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
