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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">�谷����</td>
        <td class="Value">{$form.form_start.html}{if $smarty.get.start != NULL || $smarty.get.end != NULL} �� {/if}{$form.form_end.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Value">{$form.form_ware_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">����̾</td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    {if $var.get_cshop_id != NULL}
        <tr>
            <td class="Title_Yellow">���Ƚ�</td>
            <td class="Value">{$form.form_cshop.html}</td>
        </tr>
    {/if}
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Yellow"><b>No.</b></td>
        <td class="Title_Yellow"><b>��ɼ�ֹ�</b></td>
        <td class="Title_Yellow"><b>�谷��</b></td>
        <td class="Title_Yellow"><b>�谷��ʬ</b></td>
        <td class="Title_Yellow"><b>���˿�</b></td>
        <td class="Title_Yellow"><b>�и˿�</b></td>
        <td class="Title_Yellow"><b>��ʧ��</b></td>
    </tr>
    {foreach key=j from=$row item=items}
    {* �����ʤ鿧�դ��ʤ� *}
    {if $j==0 || $j%2==0}
        <tr class="Result1">
    {else}
        {* ����ʤ鿧�դ��� *}
        <tr class="Result2">
    {/if}
        <td align="right">
        {if $smarty.post.f_page1 != null}
            {$smarty.post.f_page1*100+$j-99}
        {else}
            {$j+1}
        {/if}
        </td>
        <td>{$row[$j][0]}</td>
        <td align="center">{$row[$j][1]}</td>
        <td align="center">{$row[$j][2]}</td>
        {* ���ˡ��и�Ƚ�� *}
        {if $row[$j][3] == '1'}
            {* ���˿� *}
            <td align="right">{$row[$j][4]}</td>
            <td align="right"></td>
        {else}
            {* �и˿� *}
            <td align="right"></td>
            <td align="right">{$row[$j][4]}</td>
        {/if}
        {* ������̾��NULL�ξ��ϡ��ּ��ҸˡפȤ��� *}
        {if $row[$j][5] == NULL}
            <td>���Ҹ�</td>
        {else}
            <td>{$row[$j][5]}</td>
        {/if}
    </tr>
    {/foreach}
    <tr class="Result3" align="center">
        <td><b>����</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.in_count}</td>
        <td align="right">{$var.out_count}</td>
        <td></td>
    </tr>
</table>
{$var.html_page2}

<table align="right">
    <tr>
        <td>{$form.return_btn.html}</td>
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
