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
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.f_r_output23.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value" colspan="3">{$form.f_text8.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$form.f_date_b1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$form.f_date_b2.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value">{$form.trade_payin_1.html}</td>
        <td class="Title_Pink">���</td>
        <td class="Value">{$form.form_bank_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����襳����</td>
        <td class="Value">{$form.f_code_a1.html}</td>
        <td class="Title_Pink">������̾</td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����</td>
        <td class="Value">{$form.f_code_e1.html}</td>
        <td class="Title_Pink">�����</td>
        <td class="Value">{$form.f_code_e3.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����</td>
        <td class="Value">{$form.f_code_e2.html}</td>
        <td class="Title_Pink">����</td>
        <td class="Value">{$form.f_code_e4.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��������</td>
        <td class="Value" colspan="3">{$form.f_radio11.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.hyouji3.html}����{$form.form_clear_button.html}</td>
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Title_Pink">������<br>������</td>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Title_Pink">���</td>
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">�������<br>��������ֹ�</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">�ѹ�</td>
        <td class="Title_Pink">���</td>
    </tr>
    {* 1���� *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>10000001</td>
        <td align="center">2005-04-21<br>2005-04-21</td>
        <td align="center">��������</td>
        <td>���A</td>
        <td>������1</td>
        <td align="right">100,000</td>
        <td align="right">0</td>
        <td align="right">100,000</td>
        <td align="right">0</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center">��</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 2���� *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>10000002</td>
        <td align="center">2005-04-22<br>2005-04-22</td>
        <td align="center">��������</td>
        <td>���A</td>
        <td>������2</td>
        <td align="right">33,915</td>
        <td align="right">210</td>
        <td align="right">33,915</td>
        <td align="right">0</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center">��</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {* 3���� *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>10000003</td>
        <td align="center">2005-04-23<br>2005-04-23</td>
        <td align="center">��������</td>
        <td>���A</td>
        <td>������3</td>
        <td align="right">33,000</td>
        <td align="right">210</td>
        <td align="right">33,000</td>
        <td align="right">0</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"><a href="1-2-404.php">�ѹ�</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
    </tr>
    {* 4���� *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>10000004</td>
        <td align="center">2005-04-24<br>2005-04-24</td>
        <td align="center">��������</td>
        <td>���A</td>
        <td>������4</td>
        <td align="right">33,000</td>
        <td align="right">210</td>
        <td align="right">33,000</td>
        <td align="right">0</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"><a href="1-2-404.php">�ѹ�</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
    </tr>
    {* 5���� *}
    <tr class="Result1">
        <td align="right">5</td>
        <td>10000005</td>
        <td align="center">2005-04-25<br>2005-04-25</td>
        <td align="center">��������</td>
        <td>���A</td>
        <td>������5</td>
        <td align="right">33,915</td>
        <td align="right">210</td>
        <td align="right">33,915</td>
        <td align="right">0</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"><a href="1-2-404.php">�ѹ�</a></td>
        <td align="center"><a href="#" onClick="javascript:dialogue5('������ޤ���')">���</a></td>
    </tr>
    <tr class="Result2" align="center" style="font-weight: bold;">
        <td>���</td>
        <td></td>    
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">233,830</td>
        <td align="right">840</td>
        <td align="right">233,830</td>
        <td align="right">0</td>
        <td></td>
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
