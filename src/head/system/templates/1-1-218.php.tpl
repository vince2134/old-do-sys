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
<table>
    <tr>
        <td>

{if $smarty.post.form_search_button != "�����ե������ɽ��" && $smarty.post.show_button != "ɽ����"}
    {$form.form_search_button.html}
{else}

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ľ���襳����</td>
        <td class="Value">{$form.form_direct_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ľ����̾</td>
        <td class="Value">{$form.form_direct_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��</td>
        <td class="Value">{$form.form_direct_cname.html}</td>
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

<table align="right">
    <tr>
        <td>{$form.show_button.html}����{$form.clear_button.html}</td>
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
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

��<b>{$var.total_count}</b>��
<table class="List_Table" border="1" width="600">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ľ���襳����</td>
        <td class="Title_Purple">ľ����̾</td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">������</td>
    </tr>

    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">{$j+1}</td>
        <td align="left">{$row[$j][1]}</td>
        <td align="left"><a href="1-1-219.php?direct_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        <td align="left">{$row[$j][3]}</td>
        <td align="left">{$row[$j][4]}</td>
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
