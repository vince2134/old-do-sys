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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul>
{if $form.form_ware.error != null}
    <li>{$form.form_ware.error}<br>
{/if}
{if $var.goods_err != null}
    <li>{$var.goods_err}<br>
{/if}
{if $var.adjust_num_err != null}
    <li>{$var.adjust_num_err}<br>
{/if}
{if $var.adjust_reason_err != null}
    <li>{$var.adjust_reason_err}<br>
{/if}
{if $var.adjust_day_err != null}
    <li>{$var.adjust_day_err}<br>
{/if}
{if $var.goods_input_err != null}
    <li>{$var.goods_input_err}<br>
{/if}
</ul>
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Yellow">Ĵ����<font color="#ff0000">��</font></td>
        <!-- <td class="Value">{$smarty.now|date_format:"%Y-%m-%d"}</td> -->
        <td class="Value" colspan="3">{$form.form_adjust_day.html} �κǽ��߸ˤ�Ĵ������</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�о��Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware.html}</td>
        <td class="Title_Yellow"><b>����</b></td>
        <td class="Value">{$form.form_type.html}</td>
    </tr>

</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}{*��{$form.form_all_select_button.html}*}��{$form.mst_goods_button.html}</td>
    <tr>
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

{if $var.ware_name != null}
    <span style="font: bold 15px; color: #555555;">��{$var.ware_name}��</span>����
    <span style="font: bold 14px; color: #0000ff;">Ĵ���������ɬ�����ֲ��ޤǥ������뤷�ơּ»ܡץܥ���ǽ�������ꤷ�Ʋ�������</span><br>
{else}
    <span style="font: bold 15px; color: #0000ff;">�Ҹˤ����򤷤Ƥ���������</span><br>
{/if}


{if $var.ware_name != null}
<table class="List_Table" border="1" width="850">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">���ж�ʬ<br>(<a href="#" onClick="javascript:Button_Submit_1('change_flg', '#', 'true')">��ȿž</a>)</td>
        <td class="Title_Yellow" rowspan="2">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
        <td class="Title_Yellow">Ĵ����</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow">Ĵ����</td>
        <td class="Title_Yellow" rowspan="2">Ĵ����ͳ<font color="#ff0000">��</font></td>
        <td class="Title_Yellow" rowspan="2">Ĵ���»�<br>�ܥ����</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">�߸˿�<br><span style="color: #0000ff;">������</span></td>
        <td class="Title_Yellow">Ĵ����<font color="#ff0000">��</font></td>
        <td class="Title_Yellow">ñ��</td>
        <td class="Title_Yellow">�߸˿�<br><span style="color: #0000ff;">������</span></td>
    </tr>
    {$var.html}
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_adjust_button.html}<br></td>
    </tr>
    <tr>
        <td colspan="2" align="left">{$form.add_row_button.html}</td>
    </tr>

</table>
{/if}
        </td>
    </tr>
</table>
    {$form.hidden}
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
