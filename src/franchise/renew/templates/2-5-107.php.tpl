{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{* ���顼��å����� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.form_count_date.error != null}
    <li>{$form.form_count_date.error}<br>
{/if}
</ul>
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
{*
    <tr>
        <td class="Title_Green">���Ϸ���</td>
        <td class="Value">{$form.f_r_output.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Green">������</td>
        <td class="Value">{$form.form_count_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">���״���<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_count_date.html}<br>{$var.info_msg}</td>
    </tr>
    <tr>
        <td class="Title_Green">���ϼ�</td>
        <td class="Value">{$form.form_e_staff_slct.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
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
<table width="1000">
    <tr>
        <td>

{$var.html}

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
