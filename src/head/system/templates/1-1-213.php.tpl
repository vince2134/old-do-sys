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
    <tr align="center" valign="rop">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_area_cd.error == null && $form.form_area_name.error == null}
        <li>{$var.message}<br><br>
    {/if}
    </span>
     {* ���顼��å��������� *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_area_cd.error != null}
        <li>{$form.form_area_cd.error}<br>
    {/if}
    {if $form.form_area_name.error != null}
        <li>{$form.form_area_name.error}<br>
    {/if}
    </span> 
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�϶襳����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_area_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_area_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_area_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.form_entry_button.html}����{$form.form_clear_button.html}</td>
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

��<b>{$var.total_count}</b>�{$form.form_csv_button.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�϶襳����</td>
        <td class="Title_Purple">�϶�̾</td>
        <td class="Title_Purple">����</td>
    </tr>

    {foreach from=$page_data key=i item=item}
    <tr class=Result1>
        <td align="right">{$i+1}</td>
        <td align="left">{$item[0]}</a></td>
        <td align="left"><a href="?area_id={$item[1]}">{$item[2]}</a></td>
        <td align="left">{$item[3]}</a></td>
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
