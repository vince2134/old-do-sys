{$var.html_header}

<script language="javascript">
{$var.code_value}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{* ���顼��å��������� *} 
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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
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
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ľ���襳����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_direct_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ľ����̾1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_direct_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ľ����̾2</td>
        <td class="Value">{$form.form_direct_name2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_direct_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">͹���ֹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_post.html}����{$form.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_address1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����3</td>
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
        <td class="Title_Purple">{$form.intro_claim_link.html}</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</b></td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">��{$form.form_back_button.html}{$form.comp_button.html}��{$form.entry_button.html}��{$form.return_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
