{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
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
            <table height="100%" valign="bottm">
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
{if $var.err_msg != null}
        <td><span style="font: bold 13px; color: #ff0000;">{$var.err_msg}</span><br><br></td>
{else}
        {* aoyama-n 2009/09/04 *}
        <td align=center>
        <span style="color: red;">���֥饦�������ܥ���ϻ��Ѥ����ˡ�OK�ܥ���򥯥�å����Ʋ�������</span>
        <br><br><br>

        {*  <td><span style="font: bold 16px;">���ⴰλ���ޤ�����</span><br><br></td> *}
        <span style="font: bold 16px;">���ⴰλ���ޤ�����</span><br><br>
        </td>
{/if}
    </tr>
    <tr>
        <td align="center">{$form.ok_button.html}</td>
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
