{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{* エラーメッセージ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_msg != null}
    <li>{$var.error_msg}
{/if}
{if $var.error_buy != null}
    <li>{$var.error_buy}
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
{if $var.reserve_del_err != null}
    <li>{$var.reserve_del_err}
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
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="650">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col width="175">
<col width="100" style="font-weight: bold;">
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value">{$form.form_slip_num.html}</td>
        <td class="Title_Pink">表示件数</td>
        <td class="Value">{$form.form_range_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Pink">得意先名</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
	<tr>
        <td class="Title_Pink">代行先コード</td>
        <td class="Value">{$form.form_act.html}</td>
        <td class="Title_Pink">代行先名</td>
        <td class="Value">{$form.form_act_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">巡回日</td>
        <td class="Value" colspan="3">{$form.form_aord_day.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="right">{$form.form_display.html}　{$form.form_clear.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
{$html_l}
{$var.html_page2}

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
