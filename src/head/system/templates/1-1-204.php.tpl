{* -------------------------------------------------------------------
 * @Program         1-1-204
 * @fnc.Overview    �Ҹ���Ͽ/�ѹ�
 * @author          �դ���
 * @Cng.Tracking    #1: 20060111
 * ---------------------------------------------------------------- *}

{$form.javascript}
{$var.html_header}

<script language="javascript">
<!--
{$var.code_value_disp}
//-->
</script>

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

{* ���顼��å��������� *}
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_ware_cd.error != null}<li>{$form.form_ware_cd.error}<br>{/if}
    {if $form.form_ware_name.error != null}<li>{$form.form_ware_name.error}<br>{/if}
    {if $form.form_note.error != null}<li>{$form.form_note.error}<br>{/if}
    </span><br>
{/if}

<table class="Data_Table" border="1" width="500">

<col width="130" style="font-weight: bold;">
<col width="*">
    <tr>
        <td class="Title_Purple">{$form.form_ware_cd.label}<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_ware_name.label}<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware_name.html}</td>
    </tr>

	<tr>
        <td class="Title_Purple"><a href="{$var.js_blank_link}">{$form.form_own_shop_cd.label}</a><font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_own_shop_cd.html}</td>
{* <input type="text" name="f_branch[code1]" size="7" maxLength="6" value="" onFocus="onForm(this)" onBlur="blurForm(this)"> - <input type="text" name="f_branch[code2]" size="4" maxLength="4" value="" onFocus="onForm(this)" onBlur="blurForm(this)"><input type="text" name="f_branch[name]" size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly"> *}
		</td>
    </tr>

    <tr>
        <td class="Title_Purple">{$form.form_note.label}</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="500">
    <tr>
        <td align="left"><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.form_button.form_add_button.html}����{$form.form_button.form_return_button.html}</td>
    </tr>
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
