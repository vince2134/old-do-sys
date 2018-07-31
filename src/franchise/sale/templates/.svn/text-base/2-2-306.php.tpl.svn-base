
{$var.html_header}
<SCRIPT>
<!--

{literal}
{/literal}

//-->
</SCRIPT>


<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{$form.hidden}
{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

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

{*-------------------- エラー表示開始 -------------------*}
{if $errors!=NULL }
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		{foreach from=$errors item=errors}
		<li>{$errors}</li><BR>
		{/foreach}
	</span>
{/if}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{*-------------------- 画面表示1開始 -------------------*}
<table  class="Data_Table" border="1" width="650" >

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.bill_no.label}</b></td>
        <td class="Value">{$form.bill_no.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.hyoujikensuu.label}</b></td>
        <td class="Value">{$form.hyoujikensuu.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.close_day_s.label}</b></td>
        <td class="Value" colspan="3">{$form.close_day_s.html}　〜　{$form.close_day_e.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.client_cd.label}</b></td>
        <td class="Value" width="175">{$form.client_cd.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.client_cname.label}</b></td>
        <td class="Value">{$form.client_cname.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.claim_cd.label}</b></td>
        <td class="Value" width="175">{$form.claim_cd.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.claim_cname.label}</b></td>
        <td class="Value">{$form.claim_cname.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.staff_cd.label}</b></td>
        <td class="Value">{$form.staff_cd.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.staff_name.label}</b></td>
        <td class="Value">{$form.staff_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.pay_amount.label}</b></td>
        <td class="Value">{$form.pay_amount.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.bill_amount_last.label}</b></td>
        <td class="Value">{$form.bill_amount_last.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.rest_amount.label}</b></td>
        <td class="Value">{$form.rest_amount.html}</td>
        <td class="Title_Pink" width="100"><b>{$form.bill_amount_this.label}</b></td>
        <td class="Value">{$form.bill_amount_this.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink" width="100"><b>{$form.claim_update.label}</b></td>
        <td class="Value" colspan="3">{$form.claim_update.html}</td>
    </tr>

</table>
<table width='650'>
    <tr>
        <td align='right'>
            {$form.hyouji_button.html}　　{$form.kuria_button.html}
        </td>
    </tr>
</table>
{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}
{$var.html_page}
{$form.chk.html}

<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Pink" width=""><b>No.</b></td>
        <td class="Title_Pink" width=""><b>請求番号</b></td>
        <td class="Title_Pink" width=""><b>請求締日</b></td>
        <td class="Title_Pink" width=""><b>得意先</b></td>
        <td class="Title_Pink" width=""><b>請求先</b></td>
        <td class="Title_Pink" width=""><b>担当者</b></td>
        <td class="Title_Pink" width=""><b>前月御買上残高</b></td>
        <td class="Title_Pink" width=""><b>当月御入金額</b></td>
        <td class="Title_Pink" width=""><b>繰越残高額</b></td>
        <td class="Title_Pink" width=""><b>当月御買上額</b></td>
        <td class="Title_Pink" width=""><b>当月消費税額</b></td>
        <td class="Title_Pink" width=""><b>税込御買上額</b></td>
        <td class="Title_Pink" width=""><b>御買上残高</b></td>
        <td class="Title_Pink" width=""><b>請求更新</b></td>
    </tr>
		{if $claim_data.0.no != null}

			{foreach key=i from=$claim_data item=item}
				<tr class="Result1">
					<td align="right">{$claim_data.$i.no}</td>
					<td align="left">{$claim_data.$i.bill_no}</td>
					<td align="center">{$claim_data.$i.bill_close_day_this}</td>
					<td align="left">{$claim_data.$i.client_cd1}-{$claim_data.$i.client_cd2}<br>{$claim_data.$i.client_cname}</td>
					<td align="left">{$claim_data.$i.claim_cd1}-{$claim_data.$i.claim_cd2}<br>{$claim_data.$i.claim_cname}</td>
					<td align="left">{$claim_data.$i.staff_cd}<br>{$claim_data.$i.staff_name}</td>
					<td align="right">{$claim_data.$i.bill_amount_last}</td>
					<td align="right">{$claim_data.$i.pay_amount}</td>
					<td align="right">{$claim_data.$i.rest_amount}</td>
					<td align="right">{$claim_data.$i.sale_amount}</td>
					<td align="right">{$claim_data.$i.tax_amount}</td>
					<td align="right">{$claim_data.$i.intax_amount}</td>
					<td align="right">{$claim_data.$i.bill_amount_this}</td>
					<td align="center">{$claim_data.$i.last_update_day}</td>
				</tr>
			{/foreach}
	        
	    <tr class="Result2">
	        <td align="right">総合計</td>
	        <td align="right">{$claim_data.0.sum.no}社</td>
	        <td align="right"></td>
	        <td align="right"></td>
	        <td align="right"></td>
					<td align="right">{$claim_data.0.sum.staff_cd}</td>
					<td align="right">{$claim_data.0.sum.bill_amount_last}</td>
					<td align="right">{$claim_data.0.sum.pay_amount}</td>
					<td align="right">{$claim_data.0.sum.rest_amount}</td>
					<td align="right">{$claim_data.0.sum.sale_amount}</td>
					<td align="right">{$claim_data.0.sum.tax_amount}</td>
					<td align="right">{$claim_data.0.sum.intax_amount}</td>
					<td align="right">{$claim_data.0.sum.bill_amount_this}</td>
	        <td align="right"></td>
	    </tr>

		{/if}

</table>

                    </td>
                </tr>


                <tr>
                    <td>

{$var.html_page2}
                    </td>
                </tr>


                <tr>
                    <td>
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
