{$var.html_header}

<script language="javascript">
{$js}
 </script>

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

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">����åץ�����</td>
        <td class="Value">{$form.form_client_cd.html}</td>
        <td class="Title_Purple">����å�̾</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����åռ���</td>
        <td class="Value" colspan="3">{$form.form_staff_kind.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ͥåȥ����ID</td>
        <td class="Value">{$form.form_staff_cd.html}</td>
        <td class="Title_Purple">�����å�̾</td>
        <td class="Value">{$form.form_staff_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ô���ԥ�����</td>
        <td class="Value" colspan="3">{$form.form_charge_cd.html}</td>
{*
        <td class="Title_Purple">��°����</td>
        <td class="Value">{$form.form_part.html}</td>
*}
    </tr>
    <tr>
        <td class="Title_Purple">��</td>
        <td class="Value">{$form.form_position.html}</td>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_job_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�߿�����</td>
        <td class="Value" colspan="3">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ȥ�����ǻλ��</td>
        <td class="Value" colspan="3">{$form.form_toilet_license.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value" colspan="3">{$form.form_license.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>���Ϸ���</b></td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">{$form.show_button.html}����{$form.clear_button.html}</td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>

                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $var.display_flg == true}
<table width="100%">
    <tr>
        <td>

��<b>{$var.total_count}</b>��
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" rowspan="2">����åץ�����<br>����å�̾</td>
        <td class="Title_Purple" rowspan="2">ô����<br>������</td>
        <td class="Title_Purple" rowspan="2">����</td>
        <td class="Title_Purple" rowspan="2">�ͥåȥ����ID<br>�����å�̾</td>
        <td class="Title_Purple" rowspan="2">��</td>
        <td class="Title_Purple" rowspan="2">��Ź</td>
        <td class="Title_Purple" rowspan="2">��°����</td>
        <td class="Title_Purple" rowspan="2">����</td>
        <td class="Title_Purple" rowspan="2">�߿�����</td>
        <td class="Title_Purple" rowspan="2">�ȥ�����ǻλ��</td>
        <td class="Title_Purple" rowspan="2">�������</td>
        <td class="Title_Purple">�ͥåȥ����</td>
    </tr>
    <tr>
        <td class="Title_Purple" align="center"><b>ȯ����:{$form.form_issue_date.html}</b></td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="{$tr[$j]}">
        <td align="right">{$j+1}</td>
        {if $row[$j][1] != null}
        <td>{$row[$j][1]}-{$row[$j][2]}
        {else}
        <td>
        {/if}
        <br>{$row[$j][3]}</td>
        <td>{$row[$j][4]}</td>
        <td align="center">{$row[$j][0]}</td>
        <td>
        {if $row[$j][6] != null}
            {$row[$j][6]}-{$row[$j][7]}
        {/if}
        <br><a href="1-1-109.php?staff_id={$row[$j][5]}">{$row[$j][8]}</a></td>
        <td>{$row[$j][10]}</td>
        <td>{$row[$j][15]}</td>
        <td>{$row[$j][9]}</td>
        <td align="center">{$row[$j][11]}</td>
        <td align="center">{$row[$j][12]}</td>
        <td align="center">{$row[$j][13]}</td>
        <td>{$row[$j][14]}</td>
        <td align="center"><a href="javascript:Print_Link('{$row[$j][5]}')">����</a></td>
    </tr>
    {/foreach}
</table>

        </td>
    </tr>
</table>
{/if}
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