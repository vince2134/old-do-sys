{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="referer" method="post">

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

</form>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<form {$form.attributes}>
<table  class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">��ɼ�ֹ�</td>
        <td class="Value">{$form.form_slip_no.html}</td>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Value">{$form.form_ord_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">������</td>
        <td class="Value" colspan="3">{$form.form_buy_day.html}</td>
    </tr>    
    <tr>
        <td class="Title_Blue">�����襳����</td>
        <td class="Value">{$form.form_buy_name.html}</td>
        <td class="Title_Blue">������̾</td>
        <td class="Value">{$form.form_buy_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�������</td>
        <td class="Value">{$form.form_buy_amount.html}</td>
        <td class="Title_Blue">��������</td>
        <td class="Value">{$form.form_renew.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}����{$form.clear_button.html}</td>
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">�����襳����<br>������</td>
        <td class="Title_Blue">��ɼ�ֹ�</td>
        <td class="Title_Blue">������</td>
        <td class="Title_Blue">�������</td>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Title_Blue">��������</td>
        <td class="Title_Blue">�ѹ�</td>
        <td class="Title_Blue">���</td>
    </tr>
    {* 1���� *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>000001<br>������A</td>
        <td><a href="1-3-205.php">00040378</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000001</a></td>
        <td align="center">��</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 2���� *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>000002<br>������B</td>
        <td><a href="1-3-205.php">00040377</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000002</a></td>
        <td align="center">��</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 3���� *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>000003<br>������C</td>
        <td><a href="1-3-205.php">00040376</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000003</a></td>
        <td align="center">��</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 4���� *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>000004<br>������D</td>
        <td><a href="1-3-205.php">00040375</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000004</a></td>
        <td align="center"></td>
        <td align="center"><a href="1-3-201.php" onClick="javascript:dialogue5('�ѹ����ޤ���')">�ѹ�</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
    </tr>
    {* 6���� *}
    <tr class="Result1">
        <td align="right">5</td>
        <td>000005<br>������E</td>
        <td><a href="1-3-205.php">00040374</a></td>
        <td align="center">2005-01-04</td>
        <td align="right">2,800.00</td>
        <td><a href="1-3-102.php">00000005</a></td>
        <td align="center"></td>
        <td align="center"><a href="1-3-201.php" onClick="javascript:return(dialogue5('�ѹ����ޤ���'))">�ѹ�</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>���</td>
        <td></td>
        <td align="right">5��</td>
        <td></td>
        <td align="right">14,000.00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    {* 12���� *}
    <tr class="Result4" style="font-weight: bold;">
        <td>����</td>
        <td></td>
        <td align="right">20��</td>
        <td></td>
        <td align="right">280,000.00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
{$var.html_page2}

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
