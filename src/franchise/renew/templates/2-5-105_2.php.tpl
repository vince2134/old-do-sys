{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table height="90%" class="M_Table">

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
    {if $form.form_end_day.error != null}
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>{$form.form_end_day.error}<br>
        </span>
    {/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.form_output_radio.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">���״���</td>
        <td class="Value">{$var.update_time} �� {$form.form_end_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Green">ô����</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td>{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
    </tr>
    <tr>
        <td style="color: #0000ff; font-weight: bold;"><li>�оݤȤʤ���ɼ�ϡ����������������������̤�»ܤ���ɼ�Ǥ���</li></td>
    </tr>
</table>

        </tr>
    </td>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">����塦�����</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">ô����̾</td>
        <td colspan="8" class="Title_Green">�����߷�</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">��߷�</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">��<br>���</td>
        <td class="Title_Green">���<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>�����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">��<br>���</td>
        <td class="Title_Green">���<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>�����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
    </tr>
    {$var.html_1}
</table>
<br><br>

<span style="font: bold 15px; color: #555555;">�ڻ�������ʧ��</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">ô����̾</td>
        <td colspan="8" class="Title_Green">�����߷�</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">��߷�</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">��<br>����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">��ʧ<br>�����</td>
        <td class="Title_Green">��ʧ<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">��<br>����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">��ʧ<br>�����</td>
        <td class="Title_Green">��ʧ<br>���</td>
        <td class="Title_Green">����<br>���</td>
    </tr>
    {$var.html_2}
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
