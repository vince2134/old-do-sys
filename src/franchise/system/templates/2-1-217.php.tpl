
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- ���ȳ��� --------------------*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>

    <tr align="center">
        {*-------------------- ����ɽ������ -------------------*}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>


{*-------------------- ����ɽ��1���� -------------------*}

{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
<table class="Data_Table" border="1" width="450">

    <tr>
        <td class="Title_Purple" width="150"><b>������ݻ�</b></td>
        <td class="Value" width="300"></td>
    </tr>

    <tr>
        <td class="Title_Purple" width="150"><b>������ݻ�</b></td>
        <td class="Value"></td>
    </tr>
</table>
<br>
<table class="Data_Table" border="1" width="450">
<col width="75">
<col width="75">
<col width="300">
    <tr>
        <td class="Title_Purple" rowspan="6"><b>�������</b></td>
        <td class="Title_Purple"><b>�����</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>���ʳ�</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>�Ͱ���</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>�����</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>������</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Purple"><b>��ʧ��</b></td>
        <td class="Value"></td>
    </tr>

</table>
<br>
<table class="Data_Table" border="1" width="450">

    <tr>
        <td class="Title_Purple" width="150"><b>�ǿ���ʧ��</b></td>
        <td class="Value" width="300"></td>
    </tr>
</table>
<table width='450'>
    <tr>
        <td align='right'>
            {$form.close.html}
        </td>
    </tr>
</table>

{********************* ����ɽ��2��λ ********************}

                    </td>
                </tr>
            </table>
        </td>
        {********************* ����ɽ����λ ********************}

    </tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}
    

