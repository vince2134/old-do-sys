
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{*------------------- ���ȳ��� --------------------*}
<table width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>


        {*-------------------- ����ɽ������ -------------------*}
    <tr align="center">
        <td>
        
            <table>
                <tr>
                    <td>

{*-------------------- ����ɽ��1���� -------------------*}
<table>
    <tr>
        <td>

<table  class="Data_Table" border="1" width="400" >
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink"><b>���Ϸ���</b></td>
        <td class="Value">{$form.f_r_output23.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>�������<font color="red">��</font></b></td>
        <td class="Value">{$form.f_date_d1.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b><a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('f_customer[code1]','f_customer[code2]','f_customer[name]'),500,450);">������</a><font color="red">��</font></b></td>
        <td class="Value" colspan="3">{$form.f_customer.html}</td>
    </tr>

</table>

        </td>
        <td rowspan="2" valign="top" align="right">
<table>
<col span="8" width="90" style="color: #525552;">
    <tr>
        <td>11�������</td>
        <td>12��������</td>
        <td>13�����Ͱ�</td>
        <td></td>
    </tr>
    <tr>
        <td>61���������</td>
        <td>62����������</td>
        <td>63�������Ͱ�</td>
        <td></td>
    </tr>
    <tr>
        <td>70���������</td>
        <td>71��ľ��</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>31����������</td>
        <td>32����������</td>
        <td>33���������</td>
        <td>34���껦</td>
    </tr>
    <tr>
        <td>35�������</td>
        <td>36������Ĵ��</td>
        <td>37������¾����</td>
        <td></td>
    </tr>
</table></td>
    </tr>
    <tr>
        <td>

<table width='100%'>
    <tr>
        <td align="left"><b><font color="red">����ɬ�����ϤǤ�</font></b></td>
        <td align='right'>{$form.hyouji20.html}����{$form.kuria.html}</td>
    </tr>
</table>

       </td>
    </tr>
</table>
<br>
<br>
{********************* ����ɽ��1��λ ********************}

                    </td>
                </tr>
                <tr>
                    <td>

{*-------------------- ����ɽ��2���� -------------------*}
<table width="100%" border="0">
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>


<table width="100%">
    <tr valign="top">
        <td colspan="2">000024 - 0001��<span style="font: 20px;">���������؎����Î��̎ގ����ގ��ʎߎ�</span></td>
    </tr>
    <tr>
         <td>
            <table class="List_Table" border="1" align="left" width="350">
                <tr align="center">
                    <td class="Title_Pink" width="60"><b>����</b></td>
                    <td class="Value"  width="60" align="center">25��</td>
                    <td class="Title_Pink" width="60"><b>��ʧ��</b></td>
                    <td class="Value" align="center">����20��</td>
                </tr>
            </table>
         </td>
         <td>
            <table class="List_Table" border="1" align="right"width="400">
                <tr align="">
                    <td class="Type" width="110"><b>������ݻĹ�</b></td>
                    <td class="Value" width="" align="right" colspan="3">5,250 / 10,500 (�������2005-02-10)</td>
                </tr>
            </table>
          </td>
    </tr>
</table>


                    </td>
                </tr>
                <tr>
                    <td>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>ǯ</b></td>
        <td class="Title_Pink" width=""><b>����</b></td>
        <td class="Title_Pink" width=""><b>��ɼNo.</b></td>
        <td class="Title_Pink" width=""><b>���</b></td>
        <td class="Title_Pink" width=""><b>����̾</b></td>
        <td class="Title_Pink" width=""><b>����</b></td>
        <td class="Title_Pink" width=""><b>ñ��</b></td>
        <td class="Title_Pink" width=""><b>���</b></td>
        <td class="Title_Pink" width=""><b>������</b></td>
        <td class="Title_Pink" width=""><b>���(�ǹ�)</b></td>
        <td class="Title_Pink" width=""><b>����</b></td>
        <td class="Title_Pink" width=""><b>�Ĺ�</b></td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right"></td>
        <td align="right">����ۻĹ�</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result2">
        <td align="center">2005</td>
        <td align="center">03-01</td>
        <td align="left">00008051</td>
        <td align="center">61</td>
        <td align="left">����A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">����B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">��ɼ���</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005000</td>
        <td align="center">31</td>
        <td align="left">����(����)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,205</td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center">03-08</td>
        <td align="left">00008052</td>
        <td align="center">61</td>
        <td align="left">����A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">����B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">��ɼ���</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005001</td>
        <td align="center">31</td>
        <td align="left">����(����)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,205</td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result3">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"></td>
        <td align="right"><b>3���</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">4,200</td>
        <td align="right">210</td>
        <td align="right">4,410</td>
        <td align="right">4,410</td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right"></td>
        <td align="right">����ۻĹ�</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center">04-01</td>
        <td align="left">00008053</td>
        <td align="center">61</td>
        <td align="left">����A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">����B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">��ɼ���</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005002</td>
        <td align="center">31</td>
        <td align="left">����(����)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,000</td>
        <td align="right">1,405</td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center">04-08</td>
        <td align="left">00008054</td>
        <td align="center">61</td>
        <td align="left">����A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">����B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">��ɼ���</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,610</td>
    </tr>
    <tr class="Result3">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"></td>
        <td align="right"><b>4���</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">4,200</td>
        <td align="right">210</td>
        <td align="right">4,410</td>
        <td align="right">4,000</td>
        <td align="right">1,610</td>
    </tr>
    <tr class="Result4" align="center">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b>�������</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">8,400</td>
        <td align="right">420</td>
        <td align="right">8,820</td>
        <td align="right">8,410</td>
        <td align="right">1,610</td>
    </tr>

</table>

{$var.html_page2}

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
    

