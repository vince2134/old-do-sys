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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_build_day_s.error != null}
<li>{$form.form_build_day_s.error}<br>
{/if}
{if $form.form_build_day_e.error != null}
<li>{$form.form_build_day_e.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="750">
    <tr>
        <td>

<table class="Data_Table" border="1"width="650">
<col width="150" style="font-weight: bold;">
<col width="150">
<col width="150" style="font-weight: bold;">
<col width="200">
    <tr>
        <td class="Title_Yellow">{$form.form_build_no.label}</td>
        <td class="Value">{$form.form_build_no.html}</td>
        <td class="Title_Yellow">{$form.form_build_day_s.label}</td>
        <td class="Value">{$form.form_build_day_s.html}　〜　{$form.form_build_day_e.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">{$form.form_goods_cd.label}</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Yellow">{$form.form_goods_name.label}</td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">{$form.form_output_ware_id.label}</td>
        <td class="Value">{$form.form_output_ware_id.html}</td>
        <td class="Title_Yellow">{$form.form_input_ware_id.label}</td>
        <td class="Value">{$form.form_input_ware_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">{$form.form_select_count.label}</td>
        <td class="Value" colspan="3">{$form.form_select_count.html}</td>
    </tr>
</table>

<table width="650">
    <tr>
        <td align="right">{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
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
<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
</span>
<br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">組立管理番号</td>
        <td class="Title_Yellow">組立日</td>
        <td class="Title_Yellow">完成品コード</td>
        <td class="Title_Yellow">完成品名</td>
        <td class="Title_Yellow">引落倉庫名</td>
        <td class="Title_Yellow">入庫倉庫名</td>
        <td class="Title_Yellow">組立数</td>
    </tr>
    {foreach from=$build_data key=i item=item}
    <tr class="{$build_data[$i].color}">
        <td align="right">{$build_data[$i].no}</td>
        <td align="left">{$build_data[$i].build_cd}</td>
        <td align="right">{$build_data[$i].build_day}</td>
        <td align="left">{$build_data[$i].goods_cd}</td>
        <td align="left">{$build_data[$i].goods_name}</td>
        <td align="left">{$build_data[$i].output_ware_name}</td>
        <td align="left">{$build_data[$i].input_ware_name}</td>
        <td align="right">{$build_data[$i].build_num}</td>
    </tr>
    {/foreach}
</table>
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
{$form.hidden}
{$var.html_footer}
