{*
 * ����
 *---------------------------------------------
 *  ����        ô����          ����
 *  2007-11-18  watanabe-k      ��������
 *
 *}

{$var.html_header}

<style TYPE="text/css">
<!--
.required {ldelim}
    font-weight: bold;
    color: #ff0000;
    {rdelim}
.bold {ldelim}
    font-weight: bold;
    {rdelim}
-->
</style>

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
        <td class="Title_Gray"width="100"><b>���״���</b><span class="required">��</span></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html} ���� {$form.form_trade_ym_e_abc.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>�Ͷ�ʬ</b></td>
        <td class="Value">{$form.form_g_goods.html}</td>
        <td class="Title_Gray" width="100"><b>������ʬ</b></td>
        <td class="Value">{$form.form_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>����ʬ��</b></td>
        <td class="Value">{$form.form_g_product.html}</td>
        <td class="Title_Gray" width="100"><b>ɽ���о�</b></td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>

    {*����оݤ������ξ��Τ�ɽ��*}
    {if $smarty.session.group_kind == '1'}
    <tr>
        <td class="Title_Gray" width="100"><b>����о�</b></td>
        <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
    </tr>
    {/if}

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
        <td class="Title_Gray" align="center">���</td>
        <td class="Title_Gray" align="center">����</td>
        <td class="Title_Gray" align="center">�����</td>
        <td class="Title_Gray" align="center">������</td>
        <td class="Title_Gray" align="center">���Ѷ��</td> 
        <td class="Title_Gray" align="center">���ѹ�����</td> 
        <td class="Title_Gray" align="center">��ʬ</td> 
    </tr>   
{* --------------- �إå�END  ------------------- *}

{foreach key=i from=$disp_data item=item name=data}

    {*��׹Ի����ѤΥ���*}
    {assign var="last" value=`$smarty.foreach.data.total-1`}

    {* ��׹� *} 
    {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
    <tr class="Result3">
        <td align="left" height="30px"><b>���</b></td>
        <td align="left"><b>{$disp_data[$last].count|Plug_Minus_Numformat}����</b></td>
        <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    {/if}

    { if $smarty.foreach.data.last != true }

        {if $i is even}
    <tr class="Result1">
        {else}
    <tr class="Result2">
        {/if}

        <td align="right">{$disp_data[$i].no}</td>
        <td align="left">{$disp_data[$i].cd}<br>{$disp_data[$i].name|escape}</td>
        <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
        <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
        <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
        {*��ʬ*}
        {if $disp_data[$i].rank != null}

<!-- aizawa_m �طʿ��ѹ��Τ��ᥳ����
        <td bgcolor="#FFFFFF" align="center" rowspan="{$disp_data[$i].span}">
-->
        <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
            {$disp_data[$i].rank}<br>
            {$disp_data[$i].rank_rate}
        </td>
        {/if}
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
    

