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
<input type="button" value="��ư����ǡ�������" onclick="javascript:location='1-2-309.php'">
<input type="button" value="���ط�̥��åץ���" onclick="javascript:location='1-2-407.php'">
<input type="button" value="���ط�̾Ȳ�" style="color: #ff0000;" onclick="javascript:location='1-2-407_1.php'">
<br><br><br>
<br>
<table class="List_Table" border="1" width="700">
<col width="120" style="font-weight: bold;">
<col width="" >
<col width="120" style="font-weight: bold;">
    <tr align="left">
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$form.f_date_a1.html}������{$form.f_date_a1.html}</td>
    </tr>
    <tr align="left">
        <td class="Title_Pink">�����襳����</td>
        <td class="Value">{$form.f_claim1.html}</td>
        <td class="Title_Pink">������̾</td>
        <td class="Value"><input type="text"></td>
    </tr>
    <tr align="left">
        <td class="Title_Pink">���ط��</td>
        <td class="Value">
        <select>
          <option value="0"></option>
          <option value="0">���غ�</option>
          <option value="1">�����­</option>
          <option value="2">�¶����ʤ�</option>
          <option value="3">�¶�Ԥ��Թ�ˤ�뿶�����</option>
          <option value="4">�¶���¿��ذ����ʤ�</option>
          <option value="8">�����Ԥ��Թ�ˤ�뿶�����</option>
          <option value="9">����¾�����顼</option>
        </select>
        </td>
        <td class="Title_Pink">�������</td>
        <td class="Value">
        <input type="radio" value="" checked>����ʤ�
        <input type="radio" value="">�����
        <input type="radio" value="">̤����
        </td>
    </tr>
</table>
<table width="700">
    <tr>
        <td align="right"><input type="button" value="ɽ����">��<input type="button" value="���ꥢ"></td>
    </tr>
</table>
<br><br><br>
<table class="List_Table" border="1" width="100%">
<col width="">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Pink" rowspan="2">No.</td>
        <td class="Title_Pink" rowspan="2">������</td>
        <td class="Title_Pink" rowspan="2">�����ֹ�</td>
        <td class="Title_Pink" rowspan="2">������</td>
        <td class="Title_Pink" colspan="2">����</td>
        <td class="Title_Pink" colspan="2">����</td>
        <td class="Title_Pink" rowspan="2">������</td>
        <td class="Title_Pink" rowspan="2">���ط��</td>
        <td class="Title_Pink" rowspan="2">�����</td>
        <td class="Title_Pink" rowspan="2"><input type="checkbox">����</td>
    </tr>
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Pink">���</td>
        <td class="Title_Pink">��Ź</td>
        <td class="Title_Pink">���</td>
        <td class="Title_Pink">��Ź</td>
    </tr>
    <tr class="Result1">
        <td class="Value" align="center">1</td>
        <td class="Value" align="center">2006-06-27</td>
        <td class="Value" align="left">00000002</td>
        <td class="Value" align="left">000016-0000<br>����ץ�</td>
        <td class="Value" align="left">0001<br>�ߤ��۶��</td>
        <td class="Value" align="left">357<br>���ͻ�Ź</td>
        <td class="Value" align="left">0001<br>�ߤ��۶��</td>
        <td class="Value" align="left">357<br>���ͻ�Ź</td>
        <td class="Value" align="right">10,000</td>
        <td class="Value" align="left">���غ�</td>
        <td class="Value" align="center">��</td>
        <td class="Value" align="center"></td>
    </tr>
    <tr class="Result2">
        <td class="Value" align="center">2</td>
        <td class="Value" align="center">2006-06-27</td>
        <td class="Value" align="left">00000001</td>
        <td class="Value" align="left">000017-0000<br>��ƣ���Ύߎ�������Ź</td>
        <td class="Value" align="left">9900<br>͹�ض�</td>
        <td class="Value" align="left"><br></td>
        <td class="Value" align="left">0001<br>�ߤ��۶��</td>
        <td class="Value" align="left">357<br>���ͻ�Ź</td>
        <td class="Value" align="right">10,000</td>
        <td class="Value" align="left" width="110">���غ�</td>
        <td class="Value" align="center"></td>
        <td class="Value" align="center"><input type="checkbox"></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="right"><input type="button" value="�������Ϥ�" onclick="javascript:location='1-2-407_2.php'"></td>
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
