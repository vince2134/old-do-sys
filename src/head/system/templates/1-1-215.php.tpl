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

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $smarty.post.form_search_button != "�����ե������ɽ��" && $smarty.post.form_button.show_button != "ɽ����"}
    {$form.form_search_button.html}
{else}

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="400">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value">{$form.form_client_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶�</td>
        <td class="Value">{$form.form_area_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_state_type.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="250">
    <tr>
        <td class="Title_Purple" width="80"><b>���Ϸ���</b></td>
        <td class="Value">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">

<table>
    <tr>
        <td align="right">
            {$form.form_button.show_button.html}����{$form.form_button.clear_button.html}
        </td>
    </tr>
</table>
        </td>
    </tr>
</table>
<br>
{/if}
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td align="center">

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table width="500">
    <tr>
        <td>

��<b>{$var.match_count}</b>��
<table class="List_Table" border="1" width="100%">
    
<tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����襳����<br>������̾</td>
        <td class="Title_Purple">�϶�</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">����</td>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {if $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*10+$j-9}
            {else if}
            ��  {$j+1}
            {/if}
        </td>               
        <td align="left">
            {$row[$j][1]}<br>
            <a href="1-1-216.php?client_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        </td>
        <td align="center">{$row[$j][3]}</td>
        <td align="left">{$row[$j][4]}</td>
        <td align="center">
        {if $row[$j][5] == 1}
            �����
        {elseif $row[$j][5] == 2}
            ����ٻ���
        {elseif $row[$j][5] == 3}
            ����
        {/if}
        </td>
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