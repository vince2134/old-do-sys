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
    <tr align="center">
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
        <td class="Title_Pink">���ͽ����</td>
        <td class="Value" colspan="3">{$form.f_date_b1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����襳����</td>
        <td class="Value">{$form.f_code_a1.html}</td>
        <td class="Title_Pink">������̾</td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��ԥ�����</td>
        <td class="Value"><input type="text"></td>
        <td class="Title_Pink">���̾</td>
        <td class="Value"><input type="text"></td>
    </tr>
    <tr>
        <td class="Title_Pink">���ͽ���</td>
        <td class="Value" colspan="3">{$form.f_code_e1.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
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
        <td class="Title_Pink">���ͽ����</td>
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">���</td>
        <td class="Title_Pink">���۳�</td>
        <td class="Title_Pink">���ͽ���</td>
    </tr>
    {* 1���� *}
    <tr class="Result1">
        <td align="right">1</td>
        <td align="center">2005-04-25</td>
        <td>������1</td>
        <td>��ԣ�</td>
        <td align="right">0</td>
        <td align="right">100,000</td>
    </tr>
    {* 2���� *}
    <tr class="Result1">
        <td align="right">2</td>
        <td align="center">2005-04-26</td>
        <td>������2</td>
        <td>��ԣ�</td>
        <td align="right">0</td>
        <td align="right">25,000</td>
    </tr>
    {* 3���� *}
    <tr class="Result1">
        <td align="right">3</td>
        <td align="center">2005-04-27</td>
        <td>������3</td>
        <td>��ԣ�</td>
        <td align="right">0</td>
        <td align="right">20,000</td>
    </tr>
    {* 4���� *}
    <tr class="Result1">
        <td align="right">4</td>
        <td align="center">2005-04-28</td>
        <td>������4</td>
        <td>��ԣ�</td>
        <td align="right">0</td>
        <td align="right">20,000</td>
    </tr>
    {* 5���� *}
    <tr class="Result1">
        <td align="right">5</td>
        <td align="center">2005-04-29</td>
        <td>������5</td>
        <td>��ԣ�</td>
        <td align="right">0</td>
        <td align="right">55,000</td>
    </tr>
    <tr class="Result2" align="center">
        <td>���</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">220,000</td>
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
