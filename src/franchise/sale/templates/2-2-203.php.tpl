
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
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


<table  class="Data_Table" border="1" width="650" >
    <tr>
        <td class="Title_Pink" width="100"><b>��ɼ�ֹ�</b></td>
        <td class="Value" colspan="3">{$form.f_text8.html}����{$form.hyouji.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>���׾���</b></td>
        <td class="Value" width="225"></td>
        <td class="Title_Pink" width="100"><b>������</b></td>
        <td class="Value" width="225"></td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>������</b></td>
        <td class="Value" colspan="3" width="550"></td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>���ô����</b></td>
        <td class="Value" colspan="3"></td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>�в��Ҹ�</b></td>
        <td class="Value"></td>
        <td class="Title_Pink" width="100"><b>�����ʬ</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>������̾</b></td>
        <td class="Value"></td>
        <td class="Title_Pink" width="100"><b>��ϩ</b></td>
        <td class="Value"></td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>����</b></td>
        <td class="Value" colspan="3"></td>
    </tr>
</table>
<br>
{********************* ����ɽ��1��λ ********************}

                    </td>
                </tr>

                <tr>
                    <td>

{*-------------------- ����ɽ��2���� -------------------*}

<table class="List_Table" border="1" width="100%">
    <tr class="Result1" align="center">
        <td class="Title_Pink" width=""><b>No.</b></td>
        <td class="Title_Pink" width=""><b>�����ʬ</b></td>
        <td class="Title_Pink" width=""><b>�����ӥ�������<br>�����ӥ�̾</b></td>
        <td class="Title_Pink" width=""><b>���ʥ�����<br>����̾</b></td>
        <td class="Title_Pink" width=""><b>���ʿ�</b></td>
        <td class="Title_Pink" width=""><b>����ñ��<br>���ñ��</b></td>
        <td class="Title_Pink" width=""><b>�������<br>�����</b></td>
        <td class="Title_Pink" width=""><b>��󥿥뾦�ʥ�����<br>��󥿥�̾</b></td>
        <td class="Title_Pink" width=""><b>��󥿥��</b></td>
        <td class="Title_Pink" width=""><b>��ɼȯ��</b></td>
    </tr>

    {*1����*}
    <tr class="Result1">
        <td align="right">1</td>
        <td align="center">����</td>
        <td align="left"></td>
        <td align="left">12345678<br>����A</td>
        <td align="right">1</td>
        <td align="right">630.00<br>1,200.00</td>
        <td align="right">630.00<br>1,200.00</td>
        <td align="left"></td>
        <td align="right"></td>
        <td align="center">����</td>
    </tr>
    
    {*2����*}
    <tr class="Result1">
        <td align="right">2</td>
        <td align="center">����</td>
        <td align="left">12345679<br>�����켰</td>
        <td align="left">12345679<br>����B</td>
        <td align="right">1</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="left">12345679<br>����C</td>
        <td align="right">1</td>
        <td align="center">���ʤ�</td>
    </tr>

    {*1����*}
    <tr class="Result1">
        <td align="right">3</td>
        <td align="center">����</td>
        <td align="left"></td>
        <td align="left">12345678<br>����A</td>
        <td align="right">1</td>
        <td align="right">630.00<br>1,200.00</td>
        <td align="right">630.00<br>1,200.00</td>
        <td align="left"></td>
        <td align="right"></td>
        <td align="center">����</td>
    </tr>
    
    {*2����*}
    <tr class="Result1">
        <td align="right">4</td>
        <td align="center">����</td>
        <td align="left">12345679<br>�����켰</td>
        <td align="left">12345679<br>����B</td>
        <td align="right">1</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="left">12345679<br>����C</td>
        <td align="right">1</td>
        <td align="center">���ʤ�</td>
    </tr>

    {*2����*}
    <tr class="Result1">
        <td align="right">5</td>
        <td align="center">����</td>
        <td align="left">12345679<br>�����켰</td>
        <td align="left">12345679<br>����B</td>
        <td align="right">1</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="right">30,500.00<br>72,000.00</td>
        <td align="left">12345679<br>����C</td>
        <td align="right">1</td>
        <td align="center">���ʤ�</td>
    </tr>

</table>
<br>
<table class="List_Table" border="1" width="400" align="right">
    <tr class="Result1">
        <td class="Title_Pink"><b>�����</b></td>
        <td align="right"><b>218,400.00</b></td>
        <td class="Title_Pink"><b>������</b></td>
        <td align="right"><b>10,920.00</b></td>
        <td class="Title_Pink"><b>�ǹ������</b></td>
        <td align="right"><b>229,320.00</b></td>
    </tr>
    <tr class="Result1">
        <td class="Title_Pink"><b>�������</b></td>
        <td align="right"><b>92,760.00</b></td>
        <td align="right" colspan="2"><b></b></td>
        <td class="Title_Pink"><b>������</b></td>
        <td align="right"><b>125,640.00</b></td>
    </tr>
</table>
{********************* ����ɽ��2��λ ********************}
                    </td>
                </tr>
                <tr>
                    <td>
{*-------------------- ����ɽ��3���� -------------------*}
<table width="100%">
    <tr>
        <td align="right">{$form.uriage.html}��{$form.modoru.html}</td>
    </tr>
</table>
{********************* ����ɽ��3��λ ********************}

                    </td>
                </tr>
            </table>
        </td>
        {********************* ����ɽ����λ ********************}

    </tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}
    

