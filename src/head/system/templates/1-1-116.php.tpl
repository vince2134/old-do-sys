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
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">���Ϸ���</td>
        <td class="Value">{$form.f_r_output2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����åץ�����</td>
        <td class="Value">{$form.f_shop.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����å�̾��ά��</td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC��������ʬ</td>
        <td class="Value">{$form.form_rank_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶�</td>
        <td class="Value">{$form.form_area_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.f_radio34.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.button.hyouji.html}����{$form.button.kuria.html}</td>
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

��<b>{$var.total_count}</b>��
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">����å�̾</td>
        <td class="Title_Purple">FC��������ʬ</td>
        <td class="Title_Purple">�϶�</td>
        <td class="Title_Purple">����</td>
    </tr>
    {*1����*}
    <tr class="Result1">
        <td align="right">1</td>
        <td>000000-0001</a><br><a href="1-1-123.php">����˥ƥ�����</a></td>
        <td align="center">ľ��</td>
        <td align="center">�϶�A</td>
        <td align="center">�����</td>
    </tr>
    {*2����*}
    <tr class="Result1">
        <td align="right">2</td>
        <td>000000-0002</a><br><a href="1-1-123.php">����˥ƥ����</a></td>
        <td align="center">����Ź</td>
        <td align="center">�϶�B</td>
        <td align="center">�����</td>
    </tr>   
    {*3����*}
    <tr class="Result1">
        <td align="right">3</td>
        <td>000000-0003</a><br><a href="1-1-123.php">���˥��꡼���Ե�</a></td>
        <td align="center">����Ź</td>
        <td align="center">�϶�C</td>
        <td align="center">�����</td>
    </tr>
    {*4����*}
    <tr class="Result1">
        <td align="right">4</td>
        <td>000000-0004</a><br><a href="1-1-123.php">����˥ƥ��̴���</a></td>
        <td align="center">����Ź</td>
        <td align="center">�϶�D</td>
        <td align="center">�����</td>
    </tr>
    {*5����*}
    <tr class="Result1">
        <td align="right">5</td>
        <td>000000-0005</a><br><a href="1-1-123.php">���ܥ��꡼�󥢥å�</a></td>
        <td align="center">����Ź</td>
        <td align="center">�϶�E</td>
        <td align="center">�����</td>
    </tr>
    {*6����*}
    <tr class="Result1">
        <td align="right">6</td>
        <td>000001-0000</a><br><a href="1-1-123.php">�������</a></td>
        <td align="center">������</td>
        <td align="center">�϶�F</td>
        <td align="center">�����</td>
    </tr>
    {*7����*}
    <tr class="Result1">
        <td align="right">7</td>
        <td>000002-0000</a><br><a href="1-1-123.php">����˥ƥ��꡼��</a></td>
        <td align="center">����Ź</td>
        <td align="center">�϶�G</td>
        <td align="center">�����</td>
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
