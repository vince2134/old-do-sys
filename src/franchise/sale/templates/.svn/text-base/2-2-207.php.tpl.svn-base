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
    <li>{$form.form_round_staff.error}
{/if}
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
{if $form.form_sale_amount.error != null}
    <li>{$form.form_sale_amount.error}
{/if}
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}
{/if}
{if $msg.err_msg_print != null}
    <li>{$msg.err_msg_print}
{/if}
{if $var.renew_flg == "t"}
    <li>日次更新されているため、削除できません。
{/if}
{if $var.act_buy_renew_err != null}
    <li>{$var.act_buy_renew_err}
{/if}
{if $var.intro_buy_renew_err != null}
    <li>{$var.intro_buy_renew_err}
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>   
                </tr>   
                <tr style="page-break-before: always;">    
                    <td>    

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_page}</td>
    </tr>
    <tr>
        <td>{$html.html_1}</td>
    </tr>
    <tr>
        <td>{$html.html_2}</td>
    </tr>
    <tr>
        <td>{$html.html_page2}</td>
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
