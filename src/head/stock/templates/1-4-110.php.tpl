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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_base_date.error != null}
    <li>{$form.form_base_date.error}
{/if}
{if $form.form_object_day.error != null}
    <li>{$form.form_object_day.error}
{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col width="190">
<col width="110" style="font-weight: bold;">
<col>
{*
    <tr>
        <td class="Title_Yellow">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Yellow">�оݺ߸�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_base_date.html} ������ {$form.form_object_day.html} ���ʾ� {$form.form_io_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�Ͷ�ʬ</td>
        <td class="Value">{$form.form_g_goods.html}</td>
        <td class="Title_Yellow">���ʶ�ʬ</td>
        <td class="Value">{$form.form_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">���ʥ�����</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Yellow">����̾</td>
        <td class="Value" >{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Value" colspan="3">{$form.form_ware.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
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
<table width="100%">
    <tr>
        <td>

��<b>{$var.match_count}</b>��
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">�Ͷ�ʬ</td>
        <td class="Title_Yellow">���ʶ�ʬ</td>
        <td class="Title_Yellow">���ʥ�����<br>����̾</td>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Title_Yellow">�߸˿�</td>
        <td class="Title_Yellow">�߸�ñ��</td>
        <td class="Title_Yellow">�߸˶��</td>
        <td class="Title_Yellow">�߸�����</td>
        <td class="Title_Yellow">�ǽ������</td>
        <td class="Title_Yellow">�ǽ�������</td>
    </tr>
    {foreach from=$row item=item key=i}
    {if $i is even}
    <tr class="Result1">
    {else}
    <tr class="Result2">
    {/if} 
        <td align="right">{$i+1}</td>
        <td>{$row[$i][0]}</td>
        <td>{$row[$i][1]}</td>
        <td>{$row[$i][10]}<br>{$row[$i][2]}</td>
        <td>{$row[$i][3]}</td>
	{*-- 2009/06/24 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
	{if $row[$i][4] < 0 }
        <td align="right"><font color="red">{$row[$i][4]}</font></td>
	{else}
        <td align="right">{$row[$i][4]}</td>
	{/if}
	{*-----------------------------------------------*}
	    <td align="right">{$row[$i][5]}</td>
	{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
	{if $row[$i][6] < 0}
        <td align="right"><font color="red">{$row[$i][6]}</font></td>
	{else}
        <td align="right">{$row[$i][6]}</td>
	{/if}
	{*-----------------------------------------------*}
        <td align="right">{$row[$i][7]}</td>
    {*�������ʤ�������*}
    {* {if $smarty.post.form_io_type == '1'} *}
    {* rev.1.3 ��ʧ�ʤ���������ɲ� *}
    {if $smarty.post.form_io_type == '1' || $smarty.post.form_io_type == '0'}
        <td align="center">{$row[$i][9]}</td>
        <td align="center">{$row[$i][8]}</td>
    {*���ʤ�������*}
    {elseif $smarty.post.form_io_type == '2'}
        <td align="center">{$row[$i][8]}</td>
        <td align="center"></td>
    {*����̵��������*}
    {elseif $smarty.post.form_io_type == '4'}
        <td align="center"></td>
        <td align="center">{$row[$i][8]}</td>
    {/if}        
    </tr>
    {if $g_goods_total[$i] != null}
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>�Ͷ�ʬ��</b></td>
        <td align="right"></td>
        <td align="right"></td>
		{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $g_goods_total[$i] < 0}
        <td align="right"><font color="red">{$g_goods_total[$i]}</font></td>
		{else}
        <td align="right">{$g_goods_total[$i]}</td>
		{/if}
		{*-----------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    {/if}
    {/foreach} 
    <tr class="Result4">
        <td colspan="5"><b>����</b></td>
        <td align="right"></td>
        <td align="right"></td>
		{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $var.total_amount < 0}
        <td align="right"><font color="red">{$var.total_amount}</font></td>
		{else}
        <td align="right">{$var.total_amount}</td>
		{/if}
		{*-----------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
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
