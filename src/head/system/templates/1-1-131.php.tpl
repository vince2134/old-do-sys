{$var.html_header}

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

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>����å�̾</b></td>
        <td class="Value">����˥ƥ�����</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>


<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">���󳫻���</td>
        <td class="Value">{$form.form_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value">��� {$form.form_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>
<br><br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">���ʥ�����<font color="red">��</font></td>
        <td class="Title_Purple">����̾<font color="red">��</font></td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">ñ��</td>
        <td class="Title_Purple">���</td>
    </tr>
{foreach from=$disp_data key=i item=insurance}
    <tr class="{$insurance[0]}">
        <td>{$form.form_code[$i].html}</td>
        <td>{$form.form_name[$i].html}</td>
        <td align="right">{$form.form_num[$i].html}</td>
        <td align="right">{$form.form_price[$i].html}</td>
        <td align="right">{$form.form_amount[$i].html}</td>
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_add_button.html}����{$form.form_back_button.html}</td>
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
