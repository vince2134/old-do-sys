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
{* ����(ɬ��)�Υ��顼�����å� *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="600">
    <tr>
        <td>
{* ------------ �������� START --------------- *}
<table width="100%">    
    <tr style="color: #555555;">
        <td colspan="2" align="left">
            <span style="color: #0000ff; font-weight: bold;">
        {* �����ξ�� *}   
        {if $var.group_kind == "1" }
            ����FC�������׸�����̾���⤷����ά�ΤǤ�</td>
        {else}
            ���ֻ�����׸�����̾���⤷����ά�ΤǤ�</td>
        {/if}
        <td align="right">  <b>���Ϸ���</b>��{$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Table_Search" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">���״���<font color="red">��</font></td>
        <td class="Value">  {$form.form_trade_ym_s.html}����
                            {$form.form_trade_ym_e.html}</td> 
    </tr>
    <tr>
        {* FC�ξ��ϻ����襳����2����Ϥ��ʤ� *}
        {if $var.group_kind == "1" }
            <td class="Title_Gray">FC�������</td>
            <td class="Value">  {$form.form_client.html}<br>{$form.form_rank.html}</td>
        {else}
            <td class="Title_Gray">������</td>
            <td class="Value">  {$form.form_client.html}</td>
        {/if}
    </tr>
    <tr>
        <td class="Title_Gray">ɽ���о�</td>
        <td class="Value">  {$form.form_out_range.html}</td>
    </tr>
    {if $var.group_kind == "1" }
    <tr>
        <td class="Title_Gray">����о�</td>
        <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
    </tr>
    {/if}
</table>

<table width="100%">
    <tr>
        <td align="left"><font color="red"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_display.html}����{$form.form_clear.html}</td>
    </tr>
</table>
{* ------------ �������� END --------------- *}

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
{* ���ϥե饰��TRUE�ξ�� START *}
{if $out_flg == true }

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* --------------- �إå�START ----------------- *}
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>

        {* �����ξ���FC��������FC��������ʬ *}
        {if $var.group_kind == "1" }
            <td class="Title_Gray" align="center">FC�������</td>
            <td class="Title_Gray" align="center">FC��������ʬ</td>
        {else}
            <td class="Title_Gray" align="center">������</td>
        {/if}    

        <td class="Title_Gray" align="center"></td>

        {* ���״��֤ο����������ȥ���� *}
        {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center">{$disp_head[$i]}</td>
        {/foreach}

        <td class="Title_Gray" align="center">����</td>
        <td class="Title_Gray" align="center">��ʿ��</td>
    </tr>
{* --------------- �إå�END  ------------------- *}

{* ------------ �����ǡ���START ----------------- *}
{foreach key=i from=$disp_data item=item name=data}

    {* �Ǹ�����ǤǤʤ����ϡ���������η��פ���� *}
    {if $smarty.foreach.data.last OR $smarty.foreach.data.first}

      {* �롼����������-1��������$last�˼��� *}
      {assign var="last" value=`$smarty.foreach.data.total-1`}
      {* ------ ��׹� ----- *}
      <tr class="Result3">
        <td align="left"><b>���</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}Ź��</b></td>

        {* �����ξ���FC��������ʬ�ι�θ *}
        {if $var.group_kind == "1" }
            <td></td>
            <td align="left"><b>�������</b></td>
        {else}
            <td align="left"><b>�������</b></td>
        {/if}

        {* ���ꤵ�줿���״��֤Τ߽��Ϥ����� *}
        {foreach key=j from=$disp_data[$last].total_arari_rate item=money }
        <td align="right">{$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}</td>
        {/foreach}

        <td align="right">{$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}</td>
      </tr>
    {/if}

    {* ------ ���ٹ� ------- *}
    {* �Ǹ�ιԤ�̵����� *}
    {if $smarty.foreach.data.last == false }
        {if $i is even}
            <tr class="Result1">
        {else}
            <tr class="Result2">
        {/if}
    
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>

        {* �����ξ��ϡ�FC��������ʬ����Ϥ��� *}
        {if $var.group_kind == "1" }
            <td align="left">{$disp_data[$i].rank_cd}<br>{$disp_data[$i].rank_name|escape}</td>
        {/if}

        <td align="left"><b>�������</b></td>

        {* ���ꤵ�줿���״��֤Τ߽��Ϥ����� *}
        {foreach key=j from=$disp_data[$i].net_amount item=money }
        <td align="right">{$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}</td>
        {/foreach}

        <td align="right">{$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}</td>
        </tr>

    {/if}
{/foreach}
</table>
{* ------------- �����ǡ��� ���� -------------- *}
{/if}
{* ���ϥե饰��TRUE�ξ�� END *}
        </td>
    </tr>
</table>
{*-------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
