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
{* ��Ͽ���ѹ���λ��å��������� *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>

{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_serv_cd.error != null}<li>{$form.form_serv_cd.error}<br>{/if}
{if $form.form_serv_name.error != null}<li>{$form.form_serv_name.error}<br>{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����ӥ�������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_serv_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ӥ�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_serv_name.html}</td>
    </tr>
	<tr>
        <td class="Title_Purple">���Ƕ�ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ǧ</td>
        <td class="Value">{$form.form_accept.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td style="font-weight: bold; color: #ff0000;">����ɬ�����ϤǤ�</td>
        <td align="right">{$form.entry_button.html}����{$form.clear_button.html}</td>
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
{$form.hidden}

<table width="100%">
    <tr>
        <td>

�� <b>{$var.total_count}</b> �{$form.csv_button.html}</td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����ӥ�������</td>
        <td class="Title_Purple">�����ӥ�̾</td>
		<td class="Title_Purple">���Ƕ�ʬ</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">��ǧ</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">{$j+1}</td>
        <td align="left">{$row[$j][1]}</td>
        <td align="left"><a href="1-1-231.php?serv_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        <td align="center">{$row[$j][3]}</td>
		<td align="left">{$row[$j][4]}</td>
        {if $row[$j][5] == "1"}<td align="center">��</td>
        {else}<td align="center" style="color: #ff0000;">��</td>
        {/if}
    </tr>   
    {/foreach}
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
