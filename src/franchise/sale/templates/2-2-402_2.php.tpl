{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">


<table width="100%" height="90%" class="M_table">


    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>

    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<input type="button" value="������ñ��" onclick="javascript:location='2-2-402.php'">
<input type="button" value="���ñ��" style="color: #ff0000;" onclick="javascript:location='2-2-402_2.php'">
<br><br><br>


<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">���<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_bank_1.html}��<input type="submit" value="ɽ����"></td>
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
{* 1���� *}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����ֹ�<font color="#ff0000">��</font></td>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Title_Pink">���<font color="#ff0000">��</font><br>�����</td>
        <td class="Title_Pink">�������<br>��������ֹ�</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">�Ժ��</td>
    </tr>
    <tr class="Result1">
        <td align="">1</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="">2</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="">3</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="">4</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="">5</td>
        <td align="center"><input type="text" size="9"></td>
        <td>{$form.f_claim1.html}<br>{$form.t_claim1.html}</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td>{$form.trade_payin_1.html}</td>
        <td align="center">{$form.f_text9.html}<br>{$form.f_text9.html}</td>
        <td align="center">{$form.f_date_a2.html}<br><input type="text" size="20" maxlength="10"></td>
        <td align="center">{$form.f_text20.html}</td>
        <td align="center"><a href="#">���</a></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="left"><input type="button" value="���ɲ�"></td>
        <td align="right">
            <br>
            <table class="List_Table" border="1" width="">
            <col width="100" style="font-weight: bold;">
            <col>
            <col width="100" style="font-weight: bold;">
                <tr>
                    <td class="Title_Pink">������</td>
                    <td class="Value" align="right"><input type="text" disabled></td>
                    <td class="Title_Pink">������</td>
                    <td class="Value" align="right"><input type="text" disabled> <input type="button" value="�硡��"></td>
                </tr>
            </table>
            <br>
        </td>
    </tr>
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right"><input type="button" value="�����ǧ���̤�"></td>
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
