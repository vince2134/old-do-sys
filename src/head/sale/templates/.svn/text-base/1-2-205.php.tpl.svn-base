{$var.html_header}

<script language="javascript">
{$var.order_sheet}
 </script>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    {if $var.freeze_flg == true}
    	<tr align="center" valign="top" height="160">
	{else}
		<tr align="center" valign="top">
	{/if}
        <td>
            <table>
                <tr>
                    <td>

<!-- 登録確認メッセージ表示 -->
{if $var.freeze_flg == true}
    {if $smarty.get.del_flg == 'true'}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>伝票が削除されたため、登録できませんでした。<br>
</span>
    {elseif $smarty.get.renew_flg == 'true'}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>日次更新されたため、登録できませんでした。<br>
</span>
    {elseif $smarty.get.aord_del_flg == 'true'}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>受注伝票が削除されたため、登録できませんでした。<br>
</span>
    {elseif $smarty.get.inst_err == 'true'}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>売上が変更されたため、割賦設定が行えませんでした。<br>
</span>
    {elseif $smarty.get.aord_finish_flg == 'true'}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>受注が変更されたため、登録できませんでした。<br>
</span>
    {else}
	<span style="font: bold;"><font size="+1">売上完了しました。<br><br>
    {/if}
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="center">{$form.ok_button.html}　{$form.slip_bill_button.html}　{$form.order_button.html}　{$form.return_button.html}</td>
	    </tr>
	</table>
{else}

	{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
	<table>
	    <tr>
	        <td>

	{*
	<table class="Data_Table" border="1" width="650">
	<col width="90" style="font-weight: bold;">
	<col>
	<col width="90" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Pink">伝票番号</td>
	        <td class="Value" >{$form.form_sale_no.html}</td>
	        <td class="Title_Pink">受注番号</td>
	        <td class="Value">{$form.form_ord_no.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">得意先</td>
	        <td class="Value" colspan="3">{$form.form_client.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">売上計上日</td>
	        <td class="Value">{$form.form_sale_day.html}</td>
	        <td class="Title_Pink">請求日</td>
	        <td class="Value">{$form.form_claim_day.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">運送業者</td>
	        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_name.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">直送先</td>
	        <td class="Value">{$form.form_direct_name.html}</td>
	        <td class="Title_Pink">出荷倉庫</td>
	        <td class="Value">{$form.form_ware_name.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">取引区分</td>
	        <td class="Value" >{$form.form_trade_sale.html}</td>
	        <td class="Title_Pink">担当者</td>
	        <td class="Value">{$form.form_staff_name.html}</td>
	        
	    </tr>
	    <tr>
	        <td class="Title_Pink">備考</td>
	        <td class="Value" colspan="3">{$form.form_note.html}</td>
	    </tr>
	</table>
	*}

	<table class="Data_Table" border="1">
	<col width="80" style="font-weight: bold;">
	<col>
	<col width="60" style="font-weight: bold;">
	<col>
	<col width="90" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Pink">伝票番号</td>
	        <td class="Value" >{$form.form_sale_no.html}</td>
	        <td class="Title_Pink">得意先</td>
	        <td class="Value">{$form.form_client.html}　{$var.client_state_print}</td>
	        <td class="Title_Pink">受注番号</td>
	        <td class="Value">{$form.form_ord_no.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">取引区分</td>
	        <td class="Value" >{$form.form_trade_sale.html}</td>
	        <td class="Title_Pink">運送業者</td>
	        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_name.html}</td>
	        <td class="Title_Pink">受注担当者</td>
	        <td class="Value">{$form.form_staff_name.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">直送先</td>
	        <td class="Value" colspan="3">{$form.form_direct_name.html}</td>
	        <td class="Title_Pink">売上担当者</td>
	        <td class="Value">{$form.form_cstaff_name.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">出荷倉庫</td>
	        <td class="Value">{$form.form_ware_name.html}</td>
	        <td class="Title_Pink">請求日</td>
	        <td class="Value">{$form.form_claim_day.html}</td>
	        <td class="Title_Pink">売上計上日</td>
	        <td class="Value">{$form.form_sale_day.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Pink">備考</td>
	        <td class="Value" colspan="5">{$form.form_note.html}</td>
	    </tr>
	</table>

	        </td>
	    </tr>
	</table>
	<br>
	{*--------------- 画面表示１ e n d ---------------*}

	                    </td>
	                </tr>
	                <tr>
	                    <td>

	{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
	<table width="100%">
	    <tr>
	        <td>

	<table class="List_Table" border="1" width="100%">
	    {* 項目出力 *} 
	    {foreach key=j from=$item item=items}
	        <tr align="center" style="font-weight: bold;">
	        {foreach key=i from=$items item=item}
	            <td class="Title_Blue">{$item}</td>
	        {/foreach}
	        </tr>
	    {/foreach}                          
	    {* データ出力 *} 
	    {foreach key=j from=$row item=items}
	    <tr class="Result1">
	        <td align="right">{$j+1}</td>
	        <td>{$row[$j][0]}<br>{$row[$j][1]}</td>
			<td align="right">{$row[$j][7]}</td>
	        {* 受注数存在判定 *} 
	        {if $var.aord_id != NULL}
	            <td align="right">{$row[$j][8]}</td>
	        {/if}
	        <td align="right">{$row[$j][2]}</td>
	        <td align="right">{$row[$j][3]}<br>{$row[$j][4]}</td>
	        <td align="right">{$row[$j][5]}<br>{$row[$j][6]}</td>
	    </tr>                                                                                             
	    {/foreach}                 
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table class="List_Table" border="1" align="right">
	    <tr>
	        <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
	        <td class="Value" align="right">{$form.form_sale_total.html}</td>
	        <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
	        <td class="Value" align="right">{$form.form_sale_tax.html}</td>
	        <td class="Title_Pink" align="center" width="80"><b>税込金額</b></td>
	        <td class="Value" align="right">{$form.form_sale_money.html}</td>
	    </tr>
	</table>

	        </td>
	    </tr>
	    <tr>
	        <td>

	<table align="right">
	    <tr>
	        <td>
	            {$form.order_button.html}
	            {if $var.input_flg == true}　{$form.ok_button.html}{/if}
	            　{$form.return_button.html}
	        </td>
	    </tr>
	</table>

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
