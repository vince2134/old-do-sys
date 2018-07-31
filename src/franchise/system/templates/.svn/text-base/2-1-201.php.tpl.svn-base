{$form.javascript}
{$var.html_header}

<body class="bgimg_purple">
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

{* -------------------- 画面表示１start -------------------- *}

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 登録・変更完了メッセージ出力 *}
{if $var.comp_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;"><li>{$var.comp_msg}</span><br><br>
{/if}

{* エラーメッセージ出力 *}
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_part_cd.error != null}<li>{$form.form_part_cd.error}<br>{/if}
    {if $form.form_part_name.error != null}<li>{$form.form_part_name.error}<br>{/if}
    {if $form.form_branch_id.error != null}<li>{$form.form_branch_id.error}<br>{/if}
    </span><br>
{/if}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">{$form.form_part_cd.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_part_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_part_name.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_part_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_branch_id.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_branch_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_note.label}</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
    {if $smarty.session.part_permit == 'w'}
        <td style="color: #ff0000; font-weight: bold;">※は必須入力です</td>
        
    {/if}
    </tr>
    <tr>
        <td>{if $var.get_part_id != NULL}{$form.del_button.html}{/if}<td>
        <td align="right">{$form.form_btn_gr.form_btn_add.html}　{$form.form_btn_gr.form_btn_clear.html}</td>
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

全<b>{$var.total_count}</b>件　　{$form.form_btn_gr.form_btn_csv_out.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">{$form.form_part_cd.label}</td>
        <td class="Title_Purple">{$form.form_part_name.label}</td>
        <td class="Title_Purple">{$form.form_branch_id.label}</td>
        <td class="Title_Purple">{$form.form_note.label}</td>
    </tr>
    {foreach key=i from=$ary_list_data item=item}
    <tr class="Result1"> 
        <td align="right">{$i+1}</td>
        <td>{$item[1]}</td>
        <td><a href="?id={$item[0]}">{$item[2]}</a></td>
        <td>{$item[3]}</td>
        <td>{$item[4]}</td>
    </tr>
    {/foreach}
    {$form.hidden}
    </form>
</table>
{*--------------- 画面表示２ e n d ---------------*}

        </td>
    </tr>
</table>

                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
