
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{*------------------- 外枠開始 --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
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
{*-------------------- 画面表示1開始 -------------------*}

<table  class="Data_Table" border="1" width="650" >
<col width="120" class="Title_Pink">
<col width="">
<col width="120">

    <tr>
        <td class="Title_Pink"><b>請求番号</b></td>
        <td class="Value" colspan="3">{$claim_data.bill_no}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>請求締日</b></td>
        <td class="Value">{$claim_data.bill_close_day_this}</td>
        <td class="Title_Pink"><b>回収予定日</b></td>
        <td class="Value">{$claim_data.collect_day}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>請求先</b></td>
        <td class="Value">{$claim_data.claim_cname}</td>
        <td class="Title_Pink"><b>請求書書式設定</b></td>
        {if $claim_data.bill_format == 1}
        <td class="Value">明細請求書</td>
        {elseif $claim_data.bill_format == 2}
        <td class="Value">合計請求書</td>
        {elseif $claim_data.bill_format == 3}
        <td class="Value">出力しない</td>
        {elseif $claim_data.bill_format == 4}
        <td class="Value">指定</td>
        {elseif $claim_data.bill_format == 5}
        <td class="Value">個別請求書</td>
        {/if}

    </tr>

    <tr>
        <td class="Title_Pink"><b>発行者</b></td>
        <td class="Value">{$claim_data.issue_staff_name}</td>
        <td class="Title_Pink"><b>更新者</b></td>
        <td class="Value">{$claim_data.fix_staff_name}</td>
    </tr>


    
</table>
{********************* 画面表示1終了 ********************}

                    </td>
                </tr>

                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}
<br><br>
{*請求書一括発効から遷移して生きた場合のみ表示*}
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
<font size="+0.5" color="#555555"><b>【{$client_data[$i].client_cd1}-{$client_data[$i].client_cd2} {$client_data[$i].client_cname|escape:"html"}】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>月日</b></td>
        <td class="Title_Pink" width=""><b>伝票番号</b></td>
        <td class="Title_Pink" width=""><b>取引区分</b></td>
        <td class="Title_Pink" width="300"><b>商品名</b></td>
        <td class="Title_Pink" width="40"><b>数量</b></td>
{*
        <td class="Title_Pink" width="40"><b>単位</b></td>
*}
        <td class="Title_Pink" width="60"><b>単価</b></td>
        <td class="Title_Pink" width="60"><b>金額</b></td>
        <td class="Title_Pink" width="40"><b>税区分</b></td>
        <td class="Title_Pink" width=""><b>ロイヤリティ</b></td>
        <td class="Title_Pink" width="60"><b>入金</b></td>
        <td class="Title_Pink" width="60"><b>残高</b></td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="right">繰越</td>
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
        <td align="right">計</td>
        <td></td>
        <td></td>
        <td align="right">{$client_data[$i].installment_out_amount|number_format}</td>
        <td></td>
        <td></td>
        <td align="right">{$client_data[$i].pay_amount|number_format}</td>
        <td align="right">{$client_data[$i].bill_amount_this|number_format}</td>
    </tr>

{*割賦がある場合のみ*}
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
        　　{$form.modoru.html}
        </td>
        {else}
        <td align="right">
        {$form.modoru.html}
        </td>
        {/if}
    </tr>
</table>
{********************* 画面表示2終了 ********************}

                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
    

