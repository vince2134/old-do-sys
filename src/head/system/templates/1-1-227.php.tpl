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

    {*-------------------- ����ɽ������ -------------------*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_rank_cd.error == null && $form.form_rank_name.error == null}
        <li>{$var.message}<br>
    {/if}
    </span>
    {* ���顼��å��������� *}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_rank_cd.error != null}
        <li>{$form.form_rank_cd.error}<br>
    {/if}
    {if $form.form_rank_name.error != null}
        <li>{$form.form_rank_name.error}<br>
    {/if}
    </span> 

{*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
<table class="Data_Table" border="2" width="450">
<col width="110" style="font-weight: bold;">
<col width="*">

    <tr>
        <td class="Title_Purple">FC��������ʬ������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_rank_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">FC��������ʬ̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_rank_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_rank_note.html}</td>
    </tr>

</table>
<table width="450">
    <tr>
        <td align="left">
            <b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
        </td>
        <td align="right">
            {$form.form_entry_button.html}����{$form.form_clear_button.html}
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
<table>
    <tr>
        <td width="50%" align="left">��<b>{$var.total_count}</b>�{$form.form_csv_button.html}</td>
    </tr>
</table>
<table class="List_Table" border="1" width=450>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">FC��������ʬ������</td>
        <td class="Title_Purple">FC��������ʬ̾</td>
        <td class="Title_Purple">����</td>
    </tr>
        {foreach key=i from=$page_data item=item}
        <tr class="Result1">
                <td align="right">{$i+1}</td>
                <td align="left">{$item[0]}</td>
                <td align="left"><a href="?rank_cd={$item[0]}">{$item[1]}</a></td>
                <td align="left">{$item[2]}</td>
        </tr>
        {/foreach}  
</table>

{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
        {*--------------- ����ƥ���� e n d ---------------*}

    </tr>
</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
    

