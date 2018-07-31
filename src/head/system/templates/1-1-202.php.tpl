{* -------------------------------------------------------------------
 * @Program         1-1-202
 * @fnc.Overview    部署登録/変更
 * @author          ふくだ
 * @Cng.Tracking    #1: 20051215
 * ---------------------------------------------------------------- *}

{$form.javascript}
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{* -------------------- 外枠start -------------------- *}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトルstart *} {$var.page_header} {* 画面タイトルend *}
        </td>
    </tr>

    <tr align="center">
       

        {* -------------------- 画面表示start -------------------- *}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>

{* -------------------- 画面表示１start -------------------- *}

{* エラーメッセージ出力 *}
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_part_cd.error != null}<li>{$form.form_part_cd.error}<br>{/if}
    {if $form.form_part_name.error != null}<li>{$form.form_part_name.error}<br>{/if}
    {if $form.form_note.error != null}<li>{$form.form_note.error}<br>{/if}
    </span><br>
{/if}

<table class="Data_Table" border="1" width="450">

<col width="100" style="font-weight: bold;">
<col width="*">
    <tr>
        <td class="Title_Purple">{$form.form_part_cd.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_part_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_part_name.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_part_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_note.label}</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="450">
    <tr>
        <td align="left"><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">{$form.form_button.form_add_button.html}　　{$form.form_button.form_return_button.html}</td>
    </tr>
</form>
</table>

{* -------------------- 画面表示１end -------------------- *}

                    </td>
                </tr>
            </table>

        </td>
        {* -------------------- 画面表示end -------------------- *}

    </tr>

</table>
{* -------------------- 外枠end -------------------- *}

{$var.html_footer}
