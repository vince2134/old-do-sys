{$var.html_header}

<script language="javascript">
{$var.order_delete}
{$var.javascript}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{if $form.form_sale_staff.error != null}
    <li>{$form.form_sale_staff.error}
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}
{/if}
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}
{/if}
{if $form.form_claim_day.error != null}
    <li>{$form.form_claim_day.error}
{/if}
{if $form.form_sale_amount.error != null}
    <li>{$form.form_sale_amount.error}
{/if}
{if $form.form_installment_day.error != null}
    <li>{$form.form_installment_day.error}
{/if}
{if $var.del_error_msg != null}
    <li>{$var.del_error_msg}
{/if}
{if $var.output_error_msg != null}
    <li>{$var.output_error_msg}
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
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>
            {$html.html_page}
            {$html.html_p}
        </td>
    </tr>
    <tr>
        <td>
            {$html.html_g}
        </td>
    </tr>
    <tr>
        <td>
            {$html.html_page2}
        </td>
    </tr>
</table>

{/if}
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
