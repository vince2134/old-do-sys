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
		<table class="Data_Table" border="1" width="450">
		    <tr align="left">
		        <td class="Title_Purple" width="120"><b>����å�̾</b></td>
		        <td class="Value">����</td>
		    </tr>
		    <tr align="left"">
		        <td class="Title_Purple" width="120"><b>ǯ��</b></td>
		        <td class="Value">{$form.form_day_y.html} - {$form.form_day_m.html} �� {$form.form_day2_y.html} - {$form.form_day2_m.html}</td>
		    </tr>
		</table>
        </td>
    </tr>
    <tr align="right">
        <td>{$form.form_show_button.html}��{$form.form_clear_button.html}</td>
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

<table class="Data_Table" border="1" width="650">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ǯ��</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">�Ϳ�</td>
        <td class="Title_Purple">ñ��</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">����</td>
    </tr>
{foreach from=$disp_data key=i item=item}
    <tr class="{$disp_data.$i[0]}">
        <td rowspan="4" align="center">{$disp_data.$i[1]}</td>
        <td rowspan="4" align="center">{$disp_data.$i[2]}</td>
        <td align="left">{$disp_data.$i[3]}</td>
        <td align="right">{$disp_data.$i[4]}</td>
        <td align="right">{$disp_data.$i[5]}</td>
        <td align="right">{$disp_data.$i[6]}</td>
        <td rowspan="4" align="right">{$disp_data.$i[7]}</td>
        <td rowspan="4">{$disp_data.$i[8]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[9]}</td>
        <td align="right">{$disp_data.$i[10]}</td>
        <td align="right">{$disp_data.$i[11]}</td>
        <td align="right">{$disp_data.$i[12]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[13]}</td>
        <td align="right">{$disp_data.$i[14]}</td>
        <td align="right">{$disp_data.$i[15]}</td>
        <td align="right">{$disp_data.$i[16]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[17]}</td>
        <td align="right">{$disp_data.$i[18]}</td>
        <td align="right">{$disp_data.$i[19]}</td>
        <td align="right">{$disp_data.$i[20]}</td>
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_back_button.html}</td>
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
