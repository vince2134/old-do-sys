{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

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
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>����å�̾</b></td>
        <td class="Value">����˥ƥ�����</td>
        <td class="Title_Purple" width="80"><b>�����ʬ</b></td>
        <td class="Value">�����</td>
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
<table width="750">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����ȼ�</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ľ����</td>
        <td class="Value">{$form.form_direct_select.html}</td>
        <td class="Title_Purple">�в��Ҹ�</td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ô����</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�̿���<br>�������谸��</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�в���</td>
        <td class="Value" colspan="3">

            <table border="0">
                <tr>
                    <td rowspan="3">{$form.form_round_div.html}</td>
                    <td>
                        <font color="#555555">
                        (1) ����� {$form.form_stand_day1.html}<br>
                        (2) ����� {$form.form_stand_day2.html}
                        </font>
                    <td valign="bottom">
                        <font color="#555555">
                        �� {$form.form_rmonth.html} ��������� {$form.form_day.html}<br>
                        �� {$form.form_rweek.html} ���ּ����� {$form.form_week.html} ����
                        </font>
                    </td>
                </tr>
            </table>

        </td>
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

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">���ʥ�����<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����̾<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">�Ժ��</td>
    </tr>
    <tr class="Result1">
        <td align="center">1</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result2">
        <td align="center">2</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="center">3</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td>{$form.add_row_link.html}</td>
    <td align="right">
        <table class="List_Table" border="1">
            <tr>
                <td class="Title_Pink" align="center" width="80"><b>��ȴ���</b></td>
                <td class="Value" align="right">{$form.form_sale_total.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>������</b></td>
                <td class="Value" align="right">{$form.form_sale_tax.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>�ǹ����</b></td>
                <td class="Value" align="right">{$form.form_sale_money.html}</td>
            </tr>
        </table>
    </td>
    <td align="right">{$form.form_sum_btn.html}</td>
    </tr>
    <tr>
        <td>
            <font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>
        </td>
        <td align="right" colspan="2">
            {$form.entry_button.html}����{$form.return_button.html}
        </td>
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
