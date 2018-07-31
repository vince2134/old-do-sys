{$var.html_header}
<script language="javascript">
{$var.code_value}
</script>

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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_direct_cd.error != null}<li>{$form.form_direct_cd.error}<br>{/if}
{if $var.form_direct_cd_error != null}<li>{$var.form_direct_cd_error}<br>{/if}
{if $form.form_direct_name.error != null}<li>{$form.form_direct_name.error}<br>{/if}
{if $form.form_direct_cname.error != null}<li>{$form.form_direct_cname.error}<br>{/if}
{if $form.form_post.error != null}<li>{$form.form_post.error}<br>{/if}
{if $form.form_address1.error != null}<li>{$form.form_address1.error}<br>{/if}
{if $form.form_tel.error != null}<li>{$form.form_tel.error}<br>{/if}
{if $form.form_fax.error != null}<li>{$form.form_fax.error}<br>{/if}
{if $var.form_client_error != null}<li>{$var.form_client_error}<br>{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$form.hidden}

<table width="450">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right">
            {if $smarty.get.direct_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">直送先コード<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_direct_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_direct_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名２</td>
        <td class="Value">{$form.form_direct_name2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_direct_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_post.html}　　{$form.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_address1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所3</td>
        <td class="Value">{$form.form_address3.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FAX</td>
        <td class="Value">{$form.form_fax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.form_claim_link.html}</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
    {if $smarty.session.direct_permit == 'w'}
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
    {/if}
    </tr>
    <tr>
        <td>{if $var.direct_id != NULL}{$form.del_button.html}{/if}<td>
        <td align="right">
            {if $var.freeze_flg == true}
            {$form.comp_button.html}　　{$form.return_button.html}
            {else}
            {$form.entry_button.html}　　{$form.return_button.html}
            {/if}
        </td>
    </tr>
</table>
<br>

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
