{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{* ɽ�����¤Τ߻��Υ�å����� *} 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_btype_cd.error == null && $form.form_btype_name.error == null}
        <li>{$var.message}<br>
    {/if}
    </span>
     {* ���顼��å��������� *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_btype_cd.error != null}
        <li>{$form.form_btype_cd.error}<br>
    {/if}
    {if $form.form_btype_name.error != null}
        <li>{$form.form_btype_name.error}<br>
    {/if}
    </span> 
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table class="Data_Table" border="1" width="450">
    <tr>
        <td class="Title_Purple" width="120"><b>��ʬ��ȼ�</b></td>
        <td class="Title_Purple" width="100"><b>������<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_btype.html}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="650">
    <tr>
        <td class="Title_Purple" width="120" rowspan="4"><b>��ʬ��ȼ�</b>
        <td class="Title_Purple" width="100"><b>������<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_btype_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" width=""><b>̾��<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_btype_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>����</b></td>
        <td class="Value">{$form.form_btype_note.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>��ǧ</b></td>
        <td class="Value">{$form.form_accept.html}</td>
    </tr>
</table>

<table width='650'>
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
<table width="100%">
    <tr>
        <td>

<table border="0" width="650">
    <tr>
        <td width="50%" align="left">��<b>{$var.total_count}</b>�{$form.form_csv_button.html}</td>
    </tr>
</table>

<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple" width="30" rowspan="2"><b>No.</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>��ʬ��ȼ�</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>��ʬ��ȼ�</b></td>
    </tr>
    
    <tr align="center">
        <td class="Title_Purple" width=""><b>������</b></td>
        <td class="Title_Purple" width=""><b>̾��</b></td>
        <td class="Title_Purple" width=""><b>����</b></td>
        <td class="Title_Purple" width=""><b>��ǧ</b></td>
        <td class="Title_Purple" width=""><b>������</b></td>
        <td class="Title_Purple" width=""><b>̾��</b></td>
        <td class="Title_Purple" width=""><b>����</b></td>
        <td class="Title_Purple" width=""><b>��ǧ</b></td>
    </tr>
{foreach from=$page_data item=item key=i}
    <tr class={$tr[$i]}>
        <td align="right">{$i+1}</td>
        <td align="left">{$item[0]}</td>
        <td align="left">{$item[1]}</td>
        <td align="left">{$item[2]}</a></td>
        {if $item[7] == '1' }
            <td align="center">��</td>
        {elseif $item[7] == '2'}
            <td align="center"><font color="red">��</font></td>
        {else}
            <td></td>
        {/if}
        <td align="left">{$item[4]}</td>
        <td align="left"><a href="?sbtype_id={$item[3]}#input_form">{$item[5]}</a></td>
        <td align="left">{$item[6]}</a></td>
        {if $item[8] == '1'}
            <td align="center">��</td>
        {else}
            <td align="center"><font color="red">��</font></td>
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
