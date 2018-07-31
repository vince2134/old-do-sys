{$var.html_header}

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
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.err_non_check.error != null}<li>{$form.err_non_check.error}<br>{/if}
{if $form.err_non_buy.error != null}<li>{$form.err_non_buy.error}<br>{/if}
{if $form.err_bought_slip.error != null}<li>{$form.err_bought_slip.error}<br>{/if}
{if $form.err_non_reason.error != null}<li>{$form.err_non_reason.error}<br>{/if}
{if $form.err_valid_data.error != null}<li>{$form.err_valid_data.error}<br>{/if}
{*
{if $var.ord_d_id_error != null}<li>{$var.ord_d_id_error}<br>{/if}
{if $var.reason_error != null}<li>{$var.reason_error}<br>{/if}
*}
{if $form.form_c_staff.error != null}<li>{$form.form_c_staff.error}<br>{/if}
{if $form.form_ord_day.error != null}<li>{$form.form_ord_day.error}<br>{/if}
{if $form.form_multi_staff.error != null}<li>{$form.form_multi_staff.error}<br>{/if}
{if $form.form_hope_day.error != null}<li>{$form.form_hope_day.error}<br>{/if}
{if $form.form_arrival_day.error != null}<li>{$form.form_arrival_day.error}<br>{/if}
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
{$form.hidden}

{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_day"}</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_no"}</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_hope_day"}</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_arrival_day"}</td>
        <td class="Title_Blue">商品</td>
        <td class="Title_Blue">発注数</td>
        <td class="Title_Blue">入荷数</td>
        <td class="Title_Blue">発注残</td>
        <td class="Title_Blue">仕入倉庫</td>
        <td class="Title_Blue">仕入入力</td>
        <td class="Title_Blue">{$form.form_ord_comp_check.html}</td>
    </tr>
    {$html.html_l}
    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center"><b><font color="#ff0000">チェックを付けた商品の理由は必須です</font></b><br>{$form.ord_comp_button.html}</td>
    </tr>
</table>
{$var.html_page2}

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
