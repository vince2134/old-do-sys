{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
<table width="450">
    <tr>    
        <td> 

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col width="60" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">���������</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">���������</td>
        <td class="Title_Purple">�����</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">Ĵ����</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="153" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">������ݻ�</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">������ݻ�</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>   
    </tr>   
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col width="60" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" rowspan="7">�������</td>
        <td class="Title_Purple">�����</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">���ʳ�</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">�Ͱ���</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">�����</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value"</td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">�����</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="153" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�ǿ������</td>
        <td class="Value"></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_close_button.html}</td>
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
