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
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Pink">��������</td>
        <td class="Value">{$form.f_date_a1.html}</td>
        <td class="Title_Pink">��˾Ǽ��</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Pink">ľ����</td>
        <td class="Value"></td>
        <td class="Title_Pink">�в��Ҹ�</td>
        <td class="Value">{$form.form_ware_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value">{$form.trade_aord_1.html}</td>
        <td class="Title_Pink">ô����</td>
        <td class="Value">{$form.form_staff_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="3">{$form.f_textarea.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="3"></td>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">���ʥ�����<br>����̾</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">ñ��</td>
        <td class="Title_Pink">����ñ��<br>���ñ��</td>
        <td class="Title_Pink">�������<br>�����</td>
        <td class="Title_Pink">��ɼ����</td>
    </tr>
    {* 1���� *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>10001000<br>����A</td>
        <td align="right">100</td>
        <td>��</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">10,000.00<br>12,500.00</td>
        <td align="center">����</td>
    </tr>
    {* 2���� *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>10001001<br>����B</td>
        <td align="right">40</td>
        <td>��</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">4,000.00<br>5,000.00</td>
        <td align="center">����</td>
    </tr>
    {* 3���� *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>10001002<br>����C</td>
        <td align="right">150</td>
        <td>��</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">15,000.00<br>18,750.00</td>
        <td align="center">���ʤ�</td>
    </tr>
    {* 4���� *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>10001003<br>����D</td>
        <td align="right">110</td>
        <td>��</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">11,000.00<br>13,750.00</td>
        <td align="center">����</td>
    </tr>
    <tr class="Result1">
        <td align="right">5</td>
        <td>10001004<br>����E</td>
        <td align="right">110</td>
        <td>��</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">11,000.00<br>13,750.00</td>
        <td align="center">����</td>
    </tr>
    <tr class="Result2" align="center">
        <td>���</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">51,000.00<br>63,750.00</td>
        <td></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.hattyuusho.html}����{$form.touroku.html}����{$form.modoru.html}</td>
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
