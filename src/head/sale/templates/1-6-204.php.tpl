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

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">���ǯ��<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.f_date_c1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">����åץ�����</td>
        <td class="Value">{$form.f_code_a1.html}</td>
        <td class="Title_Pink">����å�̾</td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.hyouji.html}����{$form.kuria.html}</td>
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

<span style="font: bold 14px; color: #555555;">�ڼ��ǯ�2006-01��</span><br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">����å�̾</td>
        <td class="Title_Pink">�����<br>(�����ƥ��оݳ�)</td>
        <td class="Title_Pink">�����<br>(�����ƥ��о�)</td>
        <td class="Title_Pink">���</td>
        <td class="Title_Pink">�����ƥ���</td>
    </tr>
    {* 1���� *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>FC1</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">20,000</td>
        <td align="right">600.00</td>
    </tr>
    {* 2���� *}
    <tr class="Result2">
        <td align="right" rowspan="3">2</td>
        <td>FC2</td>
        <td align="right">20,000</td>
        <td align="right">20,000</td>
        <td align="right">40,000</td>
        <td align="right">1,200.00</td>
    </tr>
    {* 3���� *}
    <tr class="Result2">
        <td>FC3</td>
        <td align="right">30,000</td>
        <td align="right">30,000</td>
        <td align="right">60,000</td>
        <td align="right">1,800.00</td>
    </tr>
    {* 4���� *}
    <tr class="Result2">
        <td>FC4</td>
        <td align="right">40,000</td>
        <td align="right">40,000</td>
        <td align="right">80,000</td>
        <td align="right">2,400.00</td>
    </tr>
    {* 5���� *}
    <tr class="Result1">
        <td align="right" rowspan="2">3</td>
        <td>FC5</td>
        <td align="right">50,000</td>
        <td align="right">50,000</td>
        <td align="right">100,000</td>
        <td align="right">3,000</td>
    </tr>
    {* 6���� *}
    <tr class="Result1">
        <td>FC6</td>
        <td align="right">60,000</td>
        <td align="right">60,000</td>
        <td align="right">120,000</td>
        <td align="right">3,600.00</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>���</td>
        <td align="center">10��</td>
        <td align="right">550,000</td>
        <td align="right">550,000</td>
        <td align="right">1,100.000.00</td>
        <td align="right">33,000</td>
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
