{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="left" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���դΥ��顼�����å� *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*--------------- ��å������� e n d ---------------*}



{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="750">
    <tr>
        <td>
{* ============= �������� START ================ *}
<table width="100%">
    <tr style="color: #555555;">
        <td colspan="2" align="left"><span style="color: #0000ff; font-weight: bold;">
        {* �����ξ�� *}
        {if $var.group_kind == "1"}
            ����FC�������׸�����̾���⤷����ά�ΤǤ�
        {else}
            ���ֻ�����׸�����̾���⤷����ά�ΤǤ�
        {/if}
        </td>
        <td align="right"><b>���Ϸ���</b>��{$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">���״���<font color="red">��</font></td>
        <td class="Value" colspan="3">  {$form.form_trade_ym_s.html}����
                                        {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
    {* �����ξ�� *}
    {if $var.group_kind == "1"}
        <td class="Title_Gray">FC�������</td>
        <td class="Value"colspan="3">{$form.form_client.html}<br>{$form.form_rank.html}</td>
    {else}
        <td class="Title_Gray">������</td>
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    {/if}
    </tr>
    <tr>
        <td class="Title_Gray">����</td>
        <td class="Value">{$form.form_goods.html}</td>
        <td class="Title_Gray">�Ͷ�ʬ</td>
        <td class="Value">{$form.form_g_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">������ʬ</td>
        <td class="Value">{$form.form_product.html}</td>
        <td class="Title_Gray">����ʬ��</td>
        <td class="Value">{$form.form_g_product.html}</td>
    </tr>
    <tr>
    {* �����ξ�� *}
    {if $var.group_kind == "1"}
        <td class="Title_Gray">ɽ���о�</td>
        <td class="Value">{$form.form_out_range.html}</td>
        <td class="Title_Gray">����о�</td>
        <td class="Value">{$form.form_out_abstract.html}</td>
    {else}
        <td class="Title_Gray">ɽ���о�</td>
        <td class="Value" colspan="3">{$form.form_out_range.html}</td>
    {/if}
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_display.html}����{$form.form_clear.html}</td>
    </tr>
</table>

{* =============== �������� END ================= *}

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
{* ɽ���ܥ��󲡲��� *}
{if $out_flg == true }

{* ============= �ơ��֥륿���ȥ� START =============== *}
<table class="List_Table" border="1" width="100%">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Gray">No.</td>
        {* �����ξ�� *}
        {if $var.group_kind == "1"}
            <td class="Title_Gray">FC�������</td>
            <td class="Title_Gray">FC��������ʬ</td>
        {else}
            <td class="Title_Gray">������</td>
        {/if}
        <td class="Title_Gray">����</td>
        <td class="Title_Gray"></td>
        {foreach key=i from=$disp_head item=ym}        
            <td class="Title_Gray">{$ym}</td>
        {/foreach}
        <td class="Title_Gray" align="center">����</td>
        <td class="Title_Gray" align="center">��ʿ��</td>
    </tr>
{* ============== �ơ��֥륿���ȥ� END ================ *}


{* ================= �����ǡ��� START ================= *}

{* �ۤ��Ԥ�롼�� *}
{ foreach key=i from=$disp_data item=item name=data}

    {* ====== ��׹� START ====== *}
    {** �롼�פΤϤ��ᤫ���Ǹ�ξ�� **} 
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
        
        {assign var="last" value=`$smarty.foreach.data.total-1`}
        <tr class="Result4">
            <td align="center"><b>���</b></td>
            <td align="center"><b>{$disp_data[$last].total_count}Ź��</b></td>

            {* �����ξ�� *}
            {if $var.group_kind == "1"}
                <td></td>
                <td></td>
            {else}
                <td></td>
            {/if}
            
            <td style="font-weight: bold;"> ������<br>�������</td>
        {* ���ꤵ�줿����ʬ�Τ߽��Ϥ��� *}
        {foreach key=j from=$disp_data[$last].total_net_amount item=money}  
            <td align="right">
                {$disp_data[$last].total_num[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}
            </td>
        {/foreach}

        {* ���� *}
            <td align="right">
                {$disp_data[$last].sum_num|Plug_Minus_Numformat}<br>
                {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}
            </td>
        {* ��ʿ�� *}
            <td align="right">
                {$disp_data[$last].sum.ave_num|Plug_Minus_Numformat}<br>
                {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}
            </td>
        </tr>
    {/if}
    {* ======= ��׹� END ======= *}

    
    {* ====== ���ٹ� START ====== *}
    
    {* ���١ʺǽ��ԤǤʤ��ܾ��ץե饰�����ͤξ��) *}
    {if $smarty.foreach.data.last !== true AND ($disp_data[$i].sub_flg === "1" OR $disp_data[$i].sub_flg === "2")}

        {if $disp_data[$i].sub_flg is not even}
        <tr class="Result1">
        {else}
        <tr class="Result2">
        {/if}

        {*�Ԥ�1���ܤξ��Ϥۤ������Ϥ��� *}
        {if $disp_data[$i].rowspan !== null}
            <td align="right" rowspan="{$disp_data[$i].rowspan}">{$disp_data[$i].no}</td>
            <td rowspan="{$disp_data[$i].rowspan}">
                {$disp_data[$i].cd}<br>
                {$disp_data[$i].name|escape}<br>
            </td>
            {* �����ξ�� *}
            {if $var.group_kind == "1"}
                <td rowspan="{$disp_data[$i].rowspan}"> {$disp_data[$i].rank_cd}<br>
                                                        {$disp_data[$i].rank_name}            
                </td>
            {/if}
        {/if}
            <td>{$disp_data[$i].cd2}<br>
                {$disp_data[$i].name2|escape}<br>
            </td>    
            <td style="font-weight: bold;">
                ������<br>
                �������<br>
            </td>
    
    {* ���סʺǽ��ԤǤʤ��ܾ��ץե饰��true�ξ���*} 
    {elseif $smarty.foreach.data.last !== true AND $disp_data[$i].sub_flg === "true"}
        <tr class="Result3">
            <td align="center"><b>����</b></td>
            <td style="font-weight: bold;">
                ������<br>
                �������<br>
            </td>
    {/if}

    {* �ǽ��ԤǤʤ���� *}
    {if $smarty.foreach.data.last !== true}
        
        {* �Ҥȷ�ʬ���ĥ롼�� �����ꤵ�줿����ʬ�Τ߽��Ϥ��� *}
        {foreach key=j from=$disp_data[$i].net_amount item=money}
            <td align="right">
                {$disp_data[$i].num[$j]|Plug_Minus_Numformat}<br>
                {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>
            </td>
        {/foreach}

        {* ���� *}
            <td align="right">
                {$disp_data[$i].sum_num|Plug_Minus_Numformat}<br>
                {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}
            </td>
        {* ��ʿ�� *}
            <td align="right">
                {$disp_data[$i].ave_num|Plug_Minus_Numformat}<br>
                {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}
            </td>
        </tr>
    {/if}
{/foreach}
{* ======= ���ٹ� END ======= *}

</table>
{* ================= �����ǡ��� END =================== *}

{/if}
{* ɽ���ܥ��󲡲��� END *}
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
