{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- ���ȳ��� --------------------*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>

    <tr align="left">

        {*-------------------- ����ɽ������ -------------------*}
        <td valign="top">
        
            <table border=0 >
                <tr>
                    <td width="650">
{*---------------- ��å������� START -----------------*}
{* ���ա�ɬ�ܡˤΥ��顼�����å� *}
{if $form.form_trade_ym_s.error != NULL }
    <font color="red"><b><li>{$form.form_trade_ym_s.error}</b></font>
{/if}
{*---------------- ��å�������  END  -----------------*}


{*-------------------- ����ɽ��1���� ------------------*}
<table width="100%" >
    <tr style="color: #555555;">
        <td colspan="2" align="left"><span style="color: #0000ff; font-weight: bold;">
        {* �����ξ�� *}
        {if $var.group_kind == "1" }
            ����FC�������׸�����̾���⤷����ά�ΤǤ�
        {else}
            ����������׸�����̾���⤷����ά�ΤǤ�
        {/if}
        </td>
        <td align="right">  <b>���Ϸ���</b>��{$form.form_output_type.html}</td>
   </tr>
</table>        

<table  class="Table_Search" border="1" width="100%" >
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">���״���<font color="red">��</font></td>
        <td class="Value" colspan="3">  {$form.form_trade_ym_s.html}����
                                        {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
    {* �����ξ�� *}
    {if $var.group_kind == "1" }
            <td class="Title_Gray">FC�������</td>
            <td class="Value" colspan="3">  {$form.form_client.html}<br>
                                            {$form.form_rank.html}</td>
    {else}
            <td class="Title_Gray">������</td>
            <td class="Value" colspan="3">  {$form.form_client.html}</td>
        </tr>
        <tr>
            <td class="Title_Gray">���롼��</td>
            <td class="Value" colspan="3">  {$form.form_client_gr.html}</td>
    {/if}
    </tr>
    <tr>
        <td class="Title_Gray">����Ψ</td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray">ɽ���о�</td>
        <td class="Value">{$form.form_out_range.html}</td>
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
{********************* ����ɽ��1��λ ********************}

                    <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
{*-------------------- ����ɽ��2���� -------------------*}
{* =====  ���ϥե饰��TRUE�ξ�� START ===== *}
{if $out_flg == true }

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* ------------------ �����ȥ� START ------------------ *}
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Gray" align="center">No.</td>
        
    {* �����ξ�� *}
    {if $var.group_kind == "1" }
        <td class="Title_Gray">FC�������</td>
        <td class="Title_Gray">FC��������ʬ</td>
    {else}
        <td class="Title_Gray">������</td>
    {/if}
        <td class="Title_Gray"></td>

    {* �إå���ǯ�� *}
    {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center"><b>{$disp_head[$i]}</b></td>
    {/foreach}

        <td class="Title_Gray" align="center">����</td>
        <td class="Title_Gray" align="center">��ʿ��</td>
    </tr>
{* ----------------- �����ȥ� END ------------------ *}


{* -------------- �����ǡ��� START ----------------- *}
{foreach key=i from=$disp_data item=item name=data}

    {* ----------------- ��׹� START ------------------ *}
    {* �������Ǥ��ǽ�ޤ��ϡ��Ǹ�ξ�� *}
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last }

      {* �롼�פ��������顢-1�򤷤�����last�ѿ��˼��� *}
      {assign var="last" value=`$smarty.foreach.data.total-1`}
      <tr class="Result3">
        <td align="left"><b>���</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}Ź��</b></td>
        
        {* �����ξ�� *}
        {if $var.group_kind == "1" }
            <td></td>
        {/if}

        <td style="font-weight: bold;">�����<br>�����׳�<br>
        {* ����Ψ��ɽ���ξ�� *}
        {if $rate_flg == true }
            ����Ψ
        {/if}
        </td>

        {* ���ꤵ�줿���֤Τ߽��Ϥ����� *}
        {foreach key=j from=$disp_data[$last].total_arari_rate item=money}
         <td align="right">{$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br>
                           {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br>
                           {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        {/foreach}
        <td align="right">{$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        <td align="right">{$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br>
                          {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
      </tr>
    {/if}
    {* ------------------- ��׹� END  --------------------- *}

  
    {* ------------------- ���ٹ� START -------------------- *} 
    {* �������Ǥ��Ǹ�Ǥʤ���� *}
    { if $smarty.foreach.data.last != true } 
        {if $i is even }
            <tr class="Result1">
        {else}
            <tr class="Result2"> 
        {/if}
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">   {$disp_data[$i].cd}<br>
                            {$disp_data[$i].name|escape}</td>
        {* �����ξ�� *}
        {if $var.group_kind == "1" }
            <td align="left">{$disp_data[$i].rank_cd}<br>
                             {$disp_data[$i].rank_name|escape}</td>
        {/if}

        <td style="font-weight: bold;">�����<br>�����׳�<br>
        {* ����Ψ��ɽ���ξ�� *}
        {if $rate_flg == true }
            ����Ψ
        {/if}
        </td>

        {* ���ꤵ�줿���֤Τ߽��Ϥ����� *}
        {foreach key=j from=$disp_data[$i].net_amount item=money}
            <td align="right">{$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>{$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br>{$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        {/foreach}

        <td align="right">  {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
        <td align="right">  {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br>
                            {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}</td>
      </tr>
    {/if}
    {* ------------------ ���ٹ� END ------------------- *} 

{/foreach}
{* -----------  �����ǡ��� END ----------------- *}
</table>

{/if}
{* ===== ���ϥե饰��TRUE�ξ�� END ===== *}
{********************* ����ɽ��2��λ ********************}

                    </td>
                </tr>
            </table>
        </td>
        {********************* ����ɽ����λ ********************}

    </tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}
