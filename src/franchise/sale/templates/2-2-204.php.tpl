
{$var.html_header}

<SCRIPT>
<!--

{literal}

function Post_Blank(str_check,my_page,post_page,check_name,num){

    // 確認ダイアログ表示
    if (window.confirm(str_check+"\nよろしいですか？")){

        //発行する伝票が選択されているか判定
        for(var i=0;i<num;i++){
            var form_name = check_name+"["+i+"]";
            if(document.dateForm.elements[form_name] != undefined){
	
                if(document.dateForm.elements[form_name].checked == true){
                    var check_flg = true;
                }
            }
        }



        //伝票が選択されていた場合にファイルを開く
        if(check_flg == true){
            //別画面でウィンドウを開く
            document.dateForm.target="_blank";
            document.dateForm.action=post_page;
            //POST情報を送信する
            document.dateForm.submit();
        }else{
            document.dateForm.hdn_button.value = "error";
        }

        document.dateForm.target="_self";
        document.dateForm.action=my_page;
        return true;

    }else{
        return false;
    }
}



{/literal}
{$result_js}
//-->
</SCRIPT>



<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*------------------- 外枠開始 --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr>
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{*---------------------メッセージ出力-------------------*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
{$var.err_msg}
</span>

{*-------------------- 画面表示1開始 -------------------*}
{$var.search_html}
<br style="font-size: 4px;">

<table class="Table_Search">
	<col width=" 80px" style="font-weight: bold;">
	<col width="300px">
	<col width=" 90px" style="font-weight: bold;">
	<col width="400px">

	<tr>
		<td class="Td_Search_3">{$form.slip_out.label}</td>
		<td class="Td_Search_3">{$form.slip_out.html}</td>
		<td class="Td_Search_3">{$form.slip_flg.label}</td>
		<td class="Td_Search_3">{$form.slip_flg.html}</td>
	</tr>
	<tr>
		<td class="Td_Search_3">{$form.ord_no.label}</td>
		<td class="Td_Search_3">{$form.ord_no.html}</td>
		<td class="Td_Search_3">{$form.contract_div.label}</td>
		<td class="Td_Search_3">{$form.contract_div.html}</td>
	</tr>

</table>

<table width='100%'>
	<tr>
		<td align='right'>
		{$form.form_show_button.html}　　{$form.form_clear_button.html}
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
{$form.hidden}

{if $var.action != '初期表示'}
<table>
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1">

    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</b></td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_round_day"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_staff"}</td>
    {if $smarty.session.group_kind == '2'}
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_act_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_act_client_name"}<br>
        </td>
    {/if}
        <td class="Title_Pink">伝票形式</td>
        <td class="Title_Pink" width="150">{$form.form_slip_all_check.html}</td>
        <td class="Title_Pink" width="150">{$form.form_re_slip_all_check.html}</td>
    </tr>

			{foreach key=i from=$result_html item=item}
				<tr class="{$result_html.$i.class}">
					<td align="right">{$result_html.$i.no}</td>
					<td align="left">{$result_html.$i.client_cd1}-{$result_html.$i.client_cd2}<br>
						{$result_html.$i.client_cname}</td>
					<td align="left">{$result_html.$i.ord_no}</td>
					<td align="center">{$result_html.$i.ord_time}</td>
					<td align="left">{$result_html.$i.staff_cd1}<br>{$result_html.$i.staff_name1}</td>

					{if $smarty.session.group_kind == '2'}
						<td align="left">{$result_html.$i.act_cd}<br>{$result_html.$i.act_name}</td>
					{/if}

					<td align="center">{$result_html.$i.slip_out}</td>
					<td align="center">{$form.form_slip_check.$i.html}</td>
					<td align="center">{$form.form_re_slip_check.$i.html}</td>
				</tr>
			{/foreach}

    <tr class="Result3" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    {if $smarty.session.group_kind == '2'}
        <td></td>
    {/if}
        <td></td>
        <td>{$form.form_sale_slip.html}</td>
        <td>{$form.form_re_sale_slip.html}</td>
    </tr>
</table>
{/if}
{$var.html_page2}

        </td>
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
    

