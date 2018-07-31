{$var.html_header}
<SCRIPT>
<!--

{literal}
function Link_Action(action_name,id) {
	if (confirm("削除します。\nよろしいですか？")==true) {
		document.forms[0].link_action.value=action_name;
		document.forms[0].bill_id.value=id;
		document.forms[0].submit();
	}
}

{/literal}

{$var.js}

//-->
</SCRIPT>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>   
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>    

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{if $errors != NULL}
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		{foreach from=$errors item=errors}
		<li>{$errors}</li><BR>
		{/foreach}
	</span>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>

{$var.html_page}
{$form.chk.html}

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_close_day"}</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_claim_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_claim_name"}<br>
        </td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_collect_day"}</td>
        <td class="Title_Pink">{$smarty.const.BILL_AMOUNT_THIS}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_staff"}</td>
        <td class="Title_Pink">請求書送付</td>
        <td class="Title_Pink">請求書</td>
        <td class="Title_Pink">{$form.claim_issue_all.html}</td>
        <td class="Title_Pink">{$form.re_claim_issue_all.html}</td>
        <td class="Title_Pink">{$form.claim_cancel_all.html}</td>
        <td class="Title_Pink">{$form.claim_renew_all.html}</td>
    </tr>
		{if $claim_data.0.no != null}

			{foreach key=i from=$claim_data item=item}
                {if bcmod($i, 2) == 0}
				<tr class="Result1">
                {else}
				<tr class="Result2">
                {/if}
					<td align="right">{$claim_data.$i.no}</td>
					<td align="center">{$claim_data.$i.bill_no}</td>
					<td align="center">{$claim_data.$i.bill_close_day_this}</td>
				    <td>{$claim_data.$i.claim_cd1}-{$claim_data.$i.claim_cd2}<br>{$claim_data.$i.claim_cname}</td>
					<td align="center">{$claim_data.$i.collect_day}</td>
					<td align="right">{$claim_data.$i.bill_amount_this}</td>
					<td>{$claim_data.$i.staff_cd}<br>{$claim_data.$i.staff_name}</td>
					<td align="center">{$claim_data.$i.claim_send}</td>
					<td>{$form.format.$i.html}</td>
					<td align="center">{$form.claim_issue.$i.html}</td>
					<td align="center">{$form.re_claim_issue.$i.html}</td>
					<td align="center">{$form.claim_cancel.$i.html}</td>
					<td align="center">{$form.claim_renew.$i.html}</td>
				</tr>
			{/foreach}
	        
	    <tr class="Result3">
	        <td><b>合計</b></td>
	        <td align="right">{$claim_data.0.sum.no}件</td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td align="right">{$claim_data.0.sum.bill_amount_this}</td>
	        <td align="right">{$claim_data.0.sum.staff_cd}</td>
	        <td></td>
	        <td></td>
	        <td align="center">{$form.pre_hakkou_button.html}<br><br>{$form.hakkou_button.html}</td>
	        <td align="center">{$form.re_hakkou_button.html}</td>
	        <td align="center">{$form.cancel_button.html}</td>
	        <td align="center">{$form.renew_button.html}</td>
	    </tr>

		{/if}

</table>
{$var.html_page2}

        </td>
    </tr>
</table>

{/if}
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
