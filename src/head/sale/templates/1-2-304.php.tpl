
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{*------------------- ���ȳ��� --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>

    <tr align="center">
        <td valign="top">

            <table>
                <tr>
                    <td>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.fix_message != null}
    <li>{$var.fix_message}<br>
{/if}
</span>
{*-------------------- ����ɽ��1���� -------------------*}

<table  class="Data_Table" border="1" width="650" >
<col width="120" class="Title_Pink">
<col width="">
<col width="120">

    <tr>
        <td class="Title_Pink"><b>�����ֹ�</b></td>
        <td class="Value" colspan="3">{$claim_data.bill_no}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>��������</b></td>
        <td class="Value">{$claim_data.bill_close_day_this}</td>
        <td class="Title_Pink"><b>���ͽ����</b></td>
        <td class="Value">{$claim_data.collect_day}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>������</b></td>
        <td class="Value">{$claim_data.claim_cname}</td>
        <td class="Title_Pink"><b>����������</b></td>
        {if $claim_data.bill_format == 1}
        <td class="Value">���������</td>
        {elseif $claim_data.bill_format == 2}
        <td class="Value">��������</td>
        {elseif $claim_data.bill_format == 3}
        <td class="Value">���Ϥ��ʤ�</td>
        {elseif $claim_data.bill_format == 4}
        <td class="Value">����</td>
        {elseif $claim_data.bill_format == 5}
        <td class="Value">���������</td>
        {/if}

    </tr>

    <tr>
        <td class="Title_Pink"><b>ȯ�Լ�</b></td>
        <td class="Value">{$claim_data.issue_staff_name}</td>
        <td class="Title_Pink"><b>������</b></td>
        <td class="Value">{$claim_data.fix_staff_name}</td>
    </tr>


    
</table>
{********************* ����ɽ��1��λ ********************}

                    </td>
                </tr>

                <tr>
                    <td>

{*-------------------- ����ɽ��2���� -------------------*}
<br><br>
{*�������ȯ���������ܤ������������Τ�ɽ��*}
{if $smarty.get.client_id == null}
<table width="100%">
    <tr>
        <td align="left" colspan="2">
        <table class="List_Table" border="1" width="100%" >
            <tr align="center">
                <td class="Title_Pink" width=""><b>{$smarty.const.BILL_AMOUNT_LAST}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.PAYIN_AMOUNT}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.REST_AMOUNT}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.SALE_AMOUNT}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.TAX_AMOUNT}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.INTAX_AMOUNT}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.BILL_AMOUNT_THIS}</b></td>
                <td class="Title_Pink" width=""><b>{$smarty.const.PAYMENT_THIS}</b></td>
            </tr>
    
            <tr class="Result1">
                <td align="right">{$claim_data.bill_amount_last|number_format}</td>
                <td align="right">{$claim_data.pay_amount|number_format}</td>
                <td align="right">{$claim_data.rest_amount|number_format}</td>
                <td align="right">{$claim_data.sale_amount|number_format}</td>
                <td align="right">{$claim_data.tax_amount|number_format}</td>
                <td align="right">{$claim_data.intax_amount|number_format}</td>
                <td align="right">{$claim_data.bill_amount_this|number_format}</td>
{*                <td align="right">{if $claim_data.payment_this>0}{$claim_data.payment_this|number_format}{else}0{/if}</td>*}
                <td align="right">{$claim_data.payment_this|number_format}</td>
            </tr>
        </table>
        </td>
    </tr>
    <tr>
        {if $claim_data.tune_amount > 0}
        <td align="left">
        <table class="List_Table" border="1" width="">
            <tr class="Result1">
                <td class="Title_Pink" width="" ><b>{$smarty.const.TUNE_AMOUNT}</b></td>
                <td width="100" align="right">{$claim_data.tune_amount|number_format}</td>
            </tr>
        </table>
        </td>
        {/if}

        {if $claim_data.split_bill_amount > 0 || $claim_data.split_bill_rest_amount > 0}
        <td align="right">
        <table class="List_Table" border="1" width="">
            <tr class="Result1">
                {if $claim_data.split_bill_amount > 0}
                <td class="Title_Pink" width=""><b>{$smarty.const.INSTALLMENT_AMOUNT_THIS}</b></td>
                <td width="100" align="right">{$claim_data.split_bill_amount|number_format}</td>
                {/if}
                {if $claim_data.split_bill_rest_amount > 0}
                <td class="Title_Pink" width="" ><b>{$smarty.const.INSTALLMENT_REST_AMOUNT}</b></td>
                <td width="100" align="right">{$claim_data.split_bill_rest_amount|number_format}</td>
                {/if}
            </tr>
        </table>
        </td>
        {/if}
    </tr>
</table>
{/if}

{foreach from=$client_data item=item key=i}
<br><br>
<font size="+0.5" color="#555555"><b>��{$client_data[$i].client_cd1}-{$client_data[$i].client_cd2} {$client_data[$i].client_cname|escape:"html"}��</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>����</b></td>
        <td class="Title_Pink" width=""><b>��ɼ�ֹ�</b></td>
        <td class="Title_Pink" width=""><b>�����ʬ</b></td>
        <td class="Title_Pink" width="300"><b>����̾</b></td>
        <td class="Title_Pink" width="40"><b>����</b></td>
{*
        <td class="Title_Pink" width="40"><b>ñ��</b></td>
*}
        <td class="Title_Pink" width="60"><b>ñ��</b></td>
        <td class="Title_Pink" width="60"><b>���</b></td>
        <td class="Title_Pink" width="40"><b>�Ƕ�ʬ</b></td>
        <td class="Title_Pink" width=""><b>�����ƥ�</b></td>
        <td class="Title_Pink" width="60"><b>����</b></td>
        <td class="Title_Pink" width="60"><b>�Ĺ�</b></td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="right">����</td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td></td>
        <td align="right">{$client_data[$i].bill_amount_last|number_format}</td>
    </tr>

    {foreach from=$bill_d_data[$i] item=items key=j name=bill_d_data}
    {if $bill_d_data[$i][$j].formal_name != null}
    <tr class="Result1">
        <td align="center">{$bill_d_data[$i][$j].trading_day|date_format:"%m-%d"}</td>
        <td align="left">{$bill_d_data[$i][$j].slip_no}</td>
        <td align="left">{$bill_d_data[$i][$j].trade_cname}</td>
        {if $bill_d_data[$i][$j].position == 2}
        <td align="right">{$bill_d_data[$i][$j].formal_name}</td>
        {else}
        <td align="left">{$bill_d_data[$i][$j].formal_name}</td>
        {/if}
        <td align="right">{$bill_d_data[$i][$j].quantity}</td>
{*
        <td align="center">{$bill_d_data[$i][$j].unit}</td>
*}
        <td align="right">{$bill_d_data[$i][$j].sale_price}</td>
        <td align="right">{$bill_d_data[$i][$j].sale_amount}</td>
        <td align="center">{$bill_d_data[$i][$j].tax_div}</td>
        <td align="center">{$bill_d_data[$i][$j].royalty}</td>
        <td align="right">{$bill_d_data[$i][$j].pay_amount}</td>
        <td align="right">{$bill_d_data[$i][$j].rest_amount}</td>
    </tr>
    {/if}
    {/foreach}

    <tr class="Result1" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td align="right">��</td>
        <td></td>
        <td></td>
        <td align="right">{$client_data[$i].installment_out_amount|number_format}</td>
        <td></td>
        <td></td>
        <td align="right">{$client_data[$i].pay_amount|number_format}</td>
        <td align="right">{$client_data[$i].bill_amount_this|number_format}</td>
    </tr>

{*���꤬������Τ�*}
    {foreach from=$split_bill_data[$i] item=items key=j name=split_bill_data}
    {if $split_bill_data[$i][$j].formal_name != null}
    <tr class="Result1">
        <td align="center">{$split_bill_data[$i][$j].trading_day|date_format:"%m-%d"}</td>
        <td align="left">{$split_bill_data[$i][$j].slip_no}</td>
        <td align="left">{$split_bill_data[$i][$j].trade_cname}</td>
        {if $bill_d_data[$i][$j].position == 2}
        <td align="right">{$split_bill_data[$i][$j].formal_name|escape:"html"}</td>
        {else}
        <td align="left">{$split_bill_data[$i][$j].formal_name|escape:"html"}</td>
        {/if}
        <td align="right">{$split_bill_data[$i][$j].quantity}</td>
        <td align="right">{$split_bill_data[$i][$j].sale_price}</td>
        <td align="right">{$split_bill_data[$i][$j].sale_amount}</td>
        <td align="center">{$split_bill_data[$i][$j].tax_div}</td>
        <td align="center">{$bill_d_data[$i][$j].royalty}</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    {/if}
    {/foreach}

</table>
{/foreach}
{$form.hidden}
<table width="100%">
    <tr>
        {if $smarty.get.client_id == null}
        <td align="right">
        {$form.form_add_button.html}
        {if $claim_data.bill_format != 3 || $claim_data.bill_format != 4}
        {$form.form_slipout_button.html}
        {/if}
        ����{$form.modoru.html}
        </td>
        {else}
        <td align="right">
        {$form.modoru.html}
        </td>
        {/if}
    </tr>
</table>
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
    

