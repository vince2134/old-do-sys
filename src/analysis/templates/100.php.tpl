{*
 * ����
 *---------------------------------------------
 *  ����        ô����          ����
 *  2007-10-06  watanabe-k      ��������
 *
 *}

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
                    <td>

{*-------------------- ��å�����ɽ�� -------------------*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=message}
    <li>{$message}<br>
{/foreach}
</span>
{*-------------------- ����ɽ��1���� -------------------*}
<table width="750">
    <tr align="right">
        <td width="650" style="color: #555555;"><b>���Ϸ���</b></td>
        <td>{$form.form_output_type.html}</td>
    </tr>
</table>
<table  class="Data_Table" border="1" width="750" >

    <tr>
        <td class="Title_Gray"width="100"><b>���״���</b></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html}{$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>�����ӥ�̾</b></td>
        <td class="Value" colspan="3">{$form.form_serv.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>����Ψ</b></td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray" width="100"><b>ɽ���о�</b></td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>

</table>
<table width='750'>
    <tr>
        <td align="left"><font color="red"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align='right'>
            {$form.form_display.html}����{$form.form_clear.html}
        </td>
    </tr>
</table>
{********************* ����ɽ��1��λ ********************}

                    <br>
                    </td>
                </tr>
                <tr>
                    <td>

{*-------------------- ����ɽ��2���� -------------------*}
{*ɽ���ܥ��󤬲�����ʤ���ɽ�����ʤ�*}
{if $var.disp_flg == true}
<table width="100%">
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
{* --------------- �إå�START ----------------- *}
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">�����ӥ�</td>
        <td class="Title_Gray" align="center"></td>
        {foreach key=i from=$disp_head item=date}
        <td class="Title_Gray" align="center">{$disp_head[$i]}</td>
        {/foreach}
        <td class="Title_Gray" align="center">����</td> 
        <td class="Title_Gray" align="center">��ʿ��</td> 
    </tr>   
{* --------------- �إå�END  ------------------- *}

   

{foreach key=i from=$disp_data item=item name=data}

    {*��׹Ի����ѤΥ���*}
    {assign var="last" value=`$smarty.foreach.data.total-1`}

    {* ��׹� *} 
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
    <tr class="Result3">
        <td align="left"><b>���</b></td>
        <td align="left"><b>{$disp_data[$last].total_count}��</b></td>
        <td align="left"><b>
            ����<br>
            �����<br>
            �����׳�<br>
        {if $var.margin_flg == true}
            ����Ψ
        {/if}
        </b></td>
        {* ���ꤵ�줿���״��֤Τ߽��Ϥ����� *} 
        {foreach key=j from=$disp_head item=money }
        <td align="right">
            {$disp_data[$last].total_num[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {/foreach}
        <td align="right">
            {$disp_data[$last].sum_num|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        <td align="right">
            {$disp_data[$last].sum.ave_num|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
    </tr>
    {/if}  

    { if $smarty.foreach.data.last != true }
    {*�ǡ�����*}
        {if $i is even}
    <tr class="Result1">
        {else}  
    <tr class="Result2">
        {/if}   
    
        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>
        <td align="left"><b>
                ����<br>
                �����<br>
                �����׳�<br>
        {if $var.margin_flg == true}
                ����Ψ
        {/if}
        </b></td> 
        {* ���ꤵ�줿���״��֤Τ߽��Ϥ����� *} 
        {foreach key=j from=$disp_head item=money }
        <td align="right">
            {$disp_data[$i].num[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br>
            {$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {/foreach}
        {*����*}
        <td align="right">
            {$disp_data[$i].sum_num|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
        {*��ʿ��*}
        <td align="right">
            {$disp_data[$i].ave_num|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br>
            {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}
        </td>
    </tr>   
        {/if}   
{/foreach}
</table>

        </td>
    </tr>
</table>
{/if}
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
    
