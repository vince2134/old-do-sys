{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
            <table height="100%">
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td valign="middle">

{if $smarty.get.ps == "1"}
<span style="font: bold 16px;">��Ͽ��λ���ޤ�����</span><br><br>
{elseif $smarty.get.ps == "2"}
<span style="font: bold 16px;">�ѹ���λ���ޤ�����</span><br><br>
{elseif $smarty.get.err == "1"}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>��ɼ���������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
</ul>
</span>
{elseif $smarty.get.err == "2"}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>���������������Ԥ�줿���ᡢ�ѹ��Ǥ��ޤ���<br>
</ul>
</span>
{/if}

<table width="100%">
    <tr>
        <td align="right">{$form.ok_button.html}</td>
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
