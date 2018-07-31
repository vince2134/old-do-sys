{$var.html_header}

<script>
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
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value">{$form.form_output_type.html}</td>
        <td class="Title_Purple">表示件数</td>
        <td class="Value">{$form.form_display_num.html}</td>
    </tr>
    <tr>
       <td class="Title_Purple">親子区分</td>
        <td class="Value" colspan="3">{$form.form_parents_div.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">グループ</td>
        <td class="Value">{$form.form_client_gr.html}</td>
        <td class="Title_Purple">グループ名</td>
        <td class="Value">{$form.form_client_gr_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Purple">得意先名・略称</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_id.html}</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value">{$form.form_c_staff.html}</td>
        <td class="Title_Purple">業種</td>
        <td class="Value">{$form.form_btype.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state_type.html}</td>
        <td class="Title_Purple">取引区分</td>
        <td class="Value">{$form.form_trade.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　　{$form.clear_button.html}</td>
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
