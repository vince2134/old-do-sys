{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="Form_Set(); Onload_Focus();">

<script language="javascript">
{$html.js}
</script>

<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å����� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_client_cd1.error != null}
    <li>{$form.err_client_cd1.error}<br>
{/if}
</ul>
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="170" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ɽ�����</td>
        <td class="Value">{$form.form_range.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������ˡ</td>
        <td class="Value">{$form.form_method.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����åץ����� ��6��<font color="#ff0000;" id="required">��</font></td>
        <td class="Value"><span id="method1"></span></td>
    </tr>
    <tr>
        <td class="Title_Purple">����åץ����� ��4��</td>
        <td class="Value"><span id="method2"></span></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}��{$form.clear_button.html}��{$form.close_button.html}{*��{$form.form_test.html}*}</td>
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

{$html.html_page}
{$html.html_l}
{$html.html_page2}

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
