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
{if $var.error != null}<li>{$var.error}<br>{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="600">
<col width="110" style="font-weight: bold;">
<col width="190">
<col width="110" style="font-weight: bold;">
<col>
    {* ���ʡ��Ҹˤ����ꤵ��Ƥ��뤫 *}
    {if $var.get_goods_id == NULL && $var.get_ware_id == NULL}
{*
        <tr>
            <td class="Title_Yellow">���Ϸ���</td>
            <td class="Value" colspan="3">{$form.form_output.html}</td>
        </tr>
*}
        <tr>
            <td class="Title_Yellow">�谷����</td>
            <td class="Value" colspan="3">{$form.form_hand_day.html}</td>
        </tr>
        <tr>
            <td class="Title_Yellow">�Ҹ�</td>
            <td class="Value" colspan="3">{$form.form_ware.html}</td>
        </tr>
        <tr>
            <td class="Title_Yellow">���ʥ�����</td>
            <td class="Value">{$form.form_goods_cd.html}</td>
            <td class="Title_Yellow">����̾</td>
            <td class="Value" width="250">{$form.form_goods_cname.html}</td>
        </tr>
        <tr>
            <td class="Title_Yellow">����ʬ��</td>
            <td class="Value">{$form.form_g_product.html}</td>
            {* 2009-10-12 aoyama-n *}
            <td class="Title_Yellow">���Ϸ���</td>
            <td class="Value">{$form.form_output_type.html}</td>
        </tr>
    {else}
        {* ���ꤵ��Ƥ������ϡ��谷���֤���ɽ�� *}
        <tr>
            <td class="Title_Yellow">�谷����</td>
            <td class="Value" colspan="3">{$form.form_hand_day.html}</td>
        </tr>
    {/if}
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}����{$form.clear_button.html}</td>
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

{if $var.display_flg == true}

<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
�ڼ谷���֡�
{if $var.error == null && ($var.hand_start != NULL || $var.hand_end != NULL)}{$var.hand_start} �� {$var.hand_end}
{else}����̵��
{/if}
��
</span>
<br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Title_Yellow">����ʬ��</td>
        <td class="Title_Yellow">���ʥ�����<br>����̾</td>
        <td class="Title_Yellow">���ĺ߸�</td>
        <td class="Title_Yellow">���˿�</td>
        <td class="Title_Yellow">�и˿�</td>
        <td class="Title_Yellow">���߸˿�</td>
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
        {if $smarty.post.show_button == "ɽ����"}
            {$j+1}
        {elseif $smarty.post.f_page1 != null}
            {$smarty.post.f_page1*100+$j-99}
        {else}
            {$j+1}
        {/if}
        </td>
        <td>{$row[$j][0]}</td>
        <td>{$row[$j][9]}</td>
        {* ȯ�����ٹ𡦽в�ͽ������������ܤ��Ƥ�����Ƚ�� *}
        {if $var.get_goods_id == NULL && $var.get_ware_id == NULL}
            {* ��ʧ�Ȳ� *}
            <td>{$row[$j][1]}<br><a href="1-4-114.php?ware_id={$row[$j][3]}&goods_id={$row[$j][4]}&start={$var.hand_start}&end={$var.hand_end}">{$row[$j][2]}</a></td>
        {elseif $var.get_goods_id != NULL && $var.get_ware_id == NULL}
            {* ȯ�����ٹ� *}
            <td>{$row[$j][1]}<br><a href="1-4-114.php?ware_id={$row[$j][3]}&goods_id={$row[$j][4]}&start={$var.hand_start}&end={$var.hand_end}&trans_flg=1">{$row[$j][2]}</a></td>
        {elseif $var.get_goods_id == NULL && $var.get_ware_id != NULL}
            {* �в�ͽ����� *}
            <td>{$row[$j][1]}<br><a href="1-4-114.php?ware_id={$row[$j][3]}&goods_id={$row[$j][4]}&start={$var.hand_start}&end={$var.hand_end}&trans_flg=2">{$row[$j][2]}</a></td>
        {elseif $var.get_goods_id != NULL && $var.get_ware_id != NULL}
            {* �߸˾Ȳ� *}
            <td>{$row[$j][1]}<br><a href="1-4-114.php?ware_id={$row[$j][3]}&goods_id={$row[$j][4]}&start={$var.hand_start}&end={$var.hand_end}&trans_flg=3">{$row[$j][2]}</a></td>
        {/if}
        <td align="right">{$row[$j][5]}</td>
        <td align="right">{$row[$j][6]}</td>
        <td align="right">{$row[$j][7]}</td>
        <td align="right">{$row[$j][8]}</td>
    </tr>
    {/foreach}
</table>
{$var.html_page2}

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