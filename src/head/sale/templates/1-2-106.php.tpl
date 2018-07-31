{$var.html_header}

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
{if $form.form_c_staff.error != null}
    <li>{$form.form_c_staff.error}<br>
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}<br>
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}<br>
{/if}
{if $form.form_arrival_day.error != null}
    <li>{$form.form_arrival_day.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>    
        <td>{$html.html_s}</td>
    </tr>   
</table>
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_h_aord_no"}</td>
        <td class="Title_Act">{Make_Sort_Link_Tpl form=$form f_name="sl_fc_ord_no"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_direct"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_aord_day"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_arrival_day"}</td>
        <td class="Title_Pink">商品</td>
        <td class="Title_Pink">受注数</td>
        <td class="Title_Pink">出荷数</td>
        <td class="Title_Pink">受注残</td>
        <td class="Title_Pink">出荷倉庫</td>
        <td class="Title_Pink">売上入力</td>
    </tr>
    {$html.html_l}
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
