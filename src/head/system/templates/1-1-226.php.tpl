{* -------------------------------------------------------------------
 * @Program         1-1-226
 * @fnc.Overview    �����ȼ���Ͽ/�ѹ�
 * @author          �դ���
 * @Cng.Tracking    #1: 20051215
 * ---------------------------------------------------------------- *}

{$form.javascript}
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{* -------------------- ����start -------------------- *}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ�start *} {$var.page_header} {* ���̥����ȥ�end *}
        </td>
    </tr>

    <tr align="center">
       

        {* -------------------- ����ɽ��start -------------------- *}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>

{* -------------------- ����ɽ����start -------------------- *}
{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{* ���顼��å��������� *} 
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_trans_cd.error != null}<li>{$form.form_trans_cd.error}<br>{/if}
    {if $form.form_trans_name.error != null}<li>{$form.form_trans_name.error}<br>{/if}
    {if $form.form_trans_cname.error != null}<li>{$form.form_trans_cname.error}<br>{/if}
    {if $form.form_post_no.error != null}<li>{$form.form_post_no.error}<br>{/if}
    {if $form.form_address1.error != null}<li>{$form.form_address1.error}<br>{/if}
    {if $form.form_address2.error != null}<li>{$form.form_address2.error}<br>{/if}
    {if $form.form_tel.error != null}<li>{$form.form_tel.error}<br>{/if}
    {if $form.form_fax.error != null}<li>{$form.form_fax.error}<br>{/if}
    {if $form.form_note.error != null}<li>{$form.form_note.error}<br>{/if}
    </span><br>
{/if}

<table class="Data_Table" border="1" width="470">

<col width="120" style="font-weight: bold;">
<col width="*">
    <tr>
        <td class="Title_Purple">{$form.form_trans_cd.label}<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trans_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_trans_name.label}<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trans_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_trans_cname.label}<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trans_cname.html}</td>
    </tr>
	
    <tr>
        <td class="Title_Purple">͹���ֹ�</td>
        <td class="Value">{$form.form_post_no.html}����{$form.form_button.form_search_button.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_address1.label}</td>
        <td class="Value">{$form.form_address1.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_address2.label}</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_tel.label}</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_fax.label}</td>
        <td class="Value">{$form.form_fax.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_green_trans.label}</td>
        <td class="Value">{$form.form_green_trans.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_note.label}</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>

</table>

<table width="470">
    <tr>
        <td align="left"><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.form_button.form_add_button.html}����{$form.form_button.form_return_button.html}</td>
    </tr>
{$form.hidden}
</form>
</table>

{* -------------------- ����ɽ����end -------------------- *}

                    </td>
                </tr>
            </table>

        </td>
        {* -------------------- ����ɽ��end -------------------- *}

    </tr>
</table>
{* -------------------- ����end -------------------- *}

{$var.html_footer}
