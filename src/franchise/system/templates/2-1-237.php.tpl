{$var.html_header}

{$var.link_next}
<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>   
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>   

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å����� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
{if $form.form_round_day.error != null}
    <li>{$form.form_round_day.error}
{/if}
{if $form.form_claim_day.error != null}
    <li>{$form.form_claim_day.error}
{/if}
{if $form.form_slip_no.error != null}
    <li>{$form.form_slip_no.error}
{/if}

{if $var.error_msg != null}
    <li>{$var.error_msg}
{/if}
{if $var.error_buy != null}
    <li>{$var.error_buy}
{/if}
{if $var.error_payin != null}
    {* �����ֹ��ʣ���顼 *}
    <li>{$var.error_payin}
{/if}
{if $var.error_msg2 != null}
    <li>{$var.error_msg2}
{/if}
{if $var.error_msg3 != null}
    <li>{$var.error_msg3}
{/if}
{if $var.confirm_err != null}
    <li>{$var.confirm_err}
{/if}
{if $var.del_err != null}
    <li>{$var.del_err}
{/if}
{if $var.cancel_err != null}
    <li>{$var.cancel_err}
{/if}
{if $var.renew_err != null}
    <li>{$var.renew_err}
{/if}
{if $var.deli_day_renew_err != null}
    <li>{$var.deli_day_renew_err}
{/if}
{if $var.claim_day_renew_err != null}
    <li>{$var.claim_day_renew_err}
{/if}
{if $var.claim_day_bill_err != null}
    <li>{$var.claim_day_bill_err}
{/if}
{if $var.deli_day_act_renew_err != null}
    <li>{$var.deli_day_act_renew_err}
{/if}
{if $var.pay_day_act_err != null}
    <li>{$var.pay_day_act_err}
{/if}
{if $var.deli_day_intro_renew_err != null}
    <li>{$var.deli_day_intro_renew_err}
{/if}
{if $var.pay_day_intro_renew_err != null}
    <li>{$var.pay_day_intro_renew_err}
{/if}
{if $var.err_trade_advance_msg != null}
    <li>{$var.err_trade_advance_msg}<br>
    {foreach from=$var.ary_trade_advance_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{if $var.err_future_date_msg != null}
    <li>{$var.err_future_date_msg}<br>
    {foreach from=$var.ary_future_date_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{if $var.err_advance_fix_msg != null}
    <li>{$var.err_advance_fix_msg}<br>
    {foreach from=$var.ary_advance_fix_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{if $var.err_paucity_advance_msg != null}
    <li>{$var.err_paucity_advance_msg}<br>
    {foreach from=$var.ary_paucity_advance_no key=i item=slip_no}����{$slip_no}<br>{/foreach}
{/if}
{if $var.err_day_advance_msg != null}
    <li>{$var.err_day_advance_msg}
{/if}
    </ul>
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$html_s}
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}
<table>
    <tr>
        <td>
{$var.html_page}
        </td>
    </tr>
    <tr>
        <td>
{$html_l}
        </td>
    </tr>
    <tr>
        <td>
{$var.html_page2}
        </td>
    </tr>
    <tr>
        <td>
{$html_c}
        </td>
    </tr>
    <tr>
        <td>
<A NAME="sum">
<table align="left"><tr><td>{$form.form_confirm.html}</td></tr></table>
        </td>
    </tr>
</table>
{/if}
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
