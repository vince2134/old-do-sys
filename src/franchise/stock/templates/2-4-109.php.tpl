{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<form {$form.attributes}>

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

{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_stock_date.error != null}
<li>{$form.form_stock_date.error}<br>
{elseif $form.form_over_day.error != null}
<li>{$form.form_over_day.error}<br>
{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="700">
<col width="110" style="font-weight: bold;">
<col width="240">
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
        <td class="Value" colspan="3">{$form.form_stock_date.html}�������ǡ�{$form.form_over_day.html}�����ʾ塡{$form.form_sale_buy.html}</td>
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
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">�Ҹ�</td>
        <td class="Value" colspan="3">{$form.form_ware.html}</td>
    </tr>
    {if $smarty.session.shop_div == '1'}
        <tr>
            <td class="Title_Yellow">���Ƚ�</td>
            <td class="Value" colspan="3">{$form.form_cshop.html}</td>
        </tr>
    {/if}
</table>

<table width=100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
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

<table width=$width>
    <tr>    
        <td>��<b>{$var.match_count}</b>��</td>
    </tr>   
</table>

<span style="font: bold 16px; color: #555555;">
�ڻ��Ƚ�:{$var.cshop_name}��
</span><br>

<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Yellow"><b>No.</b></td>
        <td class="Title_Yellow"><b>�Ͷ�ʬ</b></td>
        <td class="Title_Yellow"><b>���ʶ�ʬ</b></td>
        <td class="Title_Yellow"><b>���ʥ�����<br>����̾</b></td>
        <td class="Title_Yellow"><b>�Ҹ�</b></td>
        <td class="Title_Yellow"><b>�߸˿�</b></td>
        <td class="Title_Yellow"><b>�߸�ñ��</b></td>
        <td class="Title_Yellow"><b>�߸˶��</b></td>
        <td class="Title_Yellow"><b>�߸�����</b></td>
        <td class="Title_Yellow"><b>�ǽ������</b></td>
        <td class="Title_Yellow"><b>�ǽ�������</b></td>
    </tr>
    {foreach key=j from=$row item=items}
    {$row[$j][15]}
        <td align="right">
            {$j+1}
        </td>
        <td>{$row[$j][0]}</td>
        <td>{$row[$j][1]}</td>
        {if $smarty.post.form_sale_buy == '1'}
            <td>{$row[$j][10]}<br>{$row[$j][2]}</td>
        {else}
            <td>{$row[$j][9]}<br>{$row[$j][2]}</td>
        {/if}
        <td>{$row[$j][3]}</td>
		{*-- 2009/06/24 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $row[$j][4] < 0 }
			<td align="right"><font color="red">{$row[$j][4]}</font></td>
		{else}
        	<td align="right">{$row[$j][4]}</td>
		{/if}
		{*-------------------------------------------------------*}
        <td align="right">{$row[$j][5]}</td>
		
		{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $row[$j][6] < 0 }
        <td align="right"><font color="red">{$row[$j][6]}</font></td>
		{else}
        <td align="right">{$row[$j][6]}</td>
		{/if}
		{*-------------------------------------------------------*}
		
        <td align="right">{$row[$j][7]}</td>
        {*�������ʤ�������*}
        {if $smarty.post.form_sale_buy == '1'}
            <td align="center">{$row[$j][9]}</td>
            <td align="center">{$row[$j][8]}</td>
        {*���ʤ�������*}
        {elseif $smarty.post.form_sale_buy == '2'}
            <td align="center">{$row[$j][8]}</td>
            <td align="center"></td>
        {*����̵��������*}
        {elseif $smarty.post.form_sale_buy == '4'}
            <td align="center"></td>
            <td align="center">{$row[$j][8]}</td>
        {/if}
    </tr>
    {if $g_goods_total[$j] != null}
    <tr class="Result3">
        <td align="right"></td>
        <td colspan="4"><b>�Ͷ�ʬ��</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
		{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $g_goods_total[$j] < 0}	
        <td align="right"><font color="red">{$g_goods_total[$j]}</font></td>
        {else}
		<td align="right">{$g_goods_total[$j]}</td>
		{/if}
		{*-------------------------------------------------------*}
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    {/if}
    {/foreach} 
    <tr class="Result4">
        <td colspan="5"><b>����</b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
		{*-- 2009/06/26 ����No.27 �ޥ��ʥ��ξ����ֻ� --*}
		{if $var.total_amount < 0}	
        <td align="right"><font color="red">{$var.total_amount}</font></td>
		{else}
        <td align="right">{$var.total_amount}</td>
		{/if}
		{*-------------------------------------------------------*}
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
