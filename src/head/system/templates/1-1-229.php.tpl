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

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="400">
    <tr>
        <td class="Title_Purple" colspan="2"><b>�����ʥ�����</b></td>
        <td class="Value">{$form.form_goods_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2"><b>������̾</b></td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" width="80" rowspan="2"><b>��������</b></td>
        <td class="Title_Purple" width="90"><b>���ʥ�����</b></td>
        <td class="Value">{$form.form_parts_goods_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" width="90"><b>����̾</b></td>
        <td class="Value">{$form.form_parts_goods_name.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>���Ϸ���</b></td>
        <td class="Value">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}



��<b>{$var.search_num}</b>��

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" rowspan="2">�����ʥ�����</td>
        <td class="Title_Purple" rowspan="2">������̾</td>
        <td class="Title_Purple" rowspan="2">��ǧ</td>
        <td class="Title_Purple" colspan="3">��������</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        <td class="Title_Purple">������</td>
    </tr>
    {foreach from=$show_data item=item key=i}
    <tr class="{$tr[$i]}">
        <td align="right">{$i+1}</td>
        <td><a href="1-1-230.php?goods_id={$show_data[$i][0]}">{$show_data[$i][1]}</a></td>
        <td>{$show_data[$i][2]}</td>
        <td align="center">{if $show_data[$i][6] == '��'}<font color="#ff0000">{$show_data[$i][6]}</font>{else}{$show_data[$i][6]}{/if}</td>
        <td>{$show_data[$i][3]}</td>        
        <td>{$show_data[$i][4]}</td>
        <td align="right">{$show_data[$i][5]}</td>    
    </tr>
    {/foreach}
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
