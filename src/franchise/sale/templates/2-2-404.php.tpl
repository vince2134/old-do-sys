
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{*------------------- ���ȳ��� --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{*-------------------- ����ɽ��1���� -------------------*}
{********************* ����ɽ��1��λ ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

{*-------------------- ����ɽ��2���� -------------------*}


<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>�����ֹ�</b></td>
        <td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>�����ʬ<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>���</b></td>
        <td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>�����</b></td>
        <td class="Title_Pink" width=""><b>�����<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>�����</b></td>
        <td class="Title_Pink" width=""><b>����</b></td>
        <td class="Title_Pink" width=""><b>�������<br>��������ֹ�</b></td>
        <td class="Title_Pink" width=""><b>����</b></td>
    </tr>

    {*1����*}
    <tr class="Result1">
        <td align="left">10000001</td>
        <td align="center">{$form.f_date_a1.html}</td>
        <td align="left">{$form.trade_payin_1.html}</td>
        <td align="left">{$form.form_bank_1.html}</td>
        <td align="left">{$form.f_claim1.html}��<a href="#" onClick="return Open_SubWin('../dialog/2-0-220.php',Array('f_claim1[code1]','f_claim1[code2]','t_claim1'),500,450);">����</a>��<br>{$form.t_claim1.html}</td>
        <td align="right">100,000</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td align="right">0</td>
        <td align="center">{$form.f_date_a2.html}<br>{$form.f_text8.html}</td>
        <td align="center">{$form.f_text20.html}</td>
    </tr>

</table>

<table border="0" width="100%">
    <tr>
        <td align="left">
            <b><font color="red">����ɬ�����ϤǤ�</font></b>
        </td>
        <td align="right">
            {$form.f_change2.html}����{$form.modoru.html}
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
    

