{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="500">
    <tr>
        <td class="Title_Green" width="80"><b>���״���</b></td>
        <td class="Value">{$var.update_time} �� {$var.end_day}</td>
    </tr>
</table>
<table>
    <tr>
        <td style="color: #0000ff; font-weight: bold;"><li>�оݤȤʤ���ɼ�ϡ�����η�����������������̤�»���ɼ�Ǥ���</li></td>
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

<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col width="100">
<col width="100" style="font-weight: bold;">
<col width="100">
    <tr>
        <td class="Title_Green">ô����</td>
        <td class="Value" colspan="3">{$disp_staff_data[1]}</td>
    </tr>
    {if $smarty.get.staff_id != "0"}
    <tr>
        <td class="Title_Green">������ס�</td>
        <td class="Value" align="right"{if $disp_staff_data[2] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[2]|number_format}</td>
        <td class="Title_Green">�������ס�</td>
        <td class="Value" align="right"{if $disp_staff_data[3] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[3]|number_format}</td>
    </tr>
    <tr>    
        <td class="Title_Green">�ڻ�����ס�</td> 
        <td class="Value" align="right"{if $disp_staff_data[4] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[4]|number_format}</td>
        <td class="Title_Green">�ڻ�ʧ��ס�</td> 
        <td class="Value" align="right"{if $disp_staff_data[5] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[5]|number_format}</td>
    </tr>
    {elseif $smarty.get.staff_id == "0"}
    <tr>
        <td class="Title_Green">������ס�</td>
        <td class="Value" align="right"{if $disp_staff_data[2] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[2]|number_format}</td>
        <td class="Title_Green">�ڻ�����ס�</td> 
        <td class="Value" align="right"{if $disp_staff_data[4] < 0} style="color: #ff0000;"{/if}>{$disp_staff_data[4]|number_format}</td>
    </tr>
    {/if}
</table>
<br>

<table class="List_Table" border="1" width="100%">
<col width="30">
<col width="100">
<col>
<col width="100">
<col width="100">
<col width="100">
<col width="0">
<col width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">�谷��ʬ</td>
        <td class="Title_Green">�����ʬ</td>
        <td class="Title_Green">���ٷ��</td>
        <td class="Title_Green">����</td>
        <td class="Title_Green">���</td>
        <td class="Title_Green"></td>
        <td class="Title_Green">��۷�߷�</td>
    </tr>
{$var.html}
</table>

<table align="right">
    <tr>
        <td>{$form.form_return_button.html}</td>
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
