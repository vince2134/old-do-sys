
{$var.html_header}

<body bgcolor="#D8D0C8">

<form name="referer" method="post">
{*-------------------- 外枠開始 ---------------------*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
<form {$form.attributes}>
			{*- 画面タイトル開始 -*} {$var.page_header} {*- 画面タイトル終了 -*}
		</td>
	</tr>

	<tr align="center">
	

		{*--------------------- 画面表示開始 --------------------*}
		<td valign="top">

<table border="0">
		<tr>
			<td>


{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------------- 画面表示1開始 --------------------*}
<font size="+0.5" color="#555555"><b>【サービス/商品一括訂正】</b></font>
<table class="List_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value">{$form.f_customer.code1.html}-{$form.f_customer.code2.html}</td>
        <td class="Title_Purple">得意先名</td>
        <td class="Value">{$form.f_customer.name.html}
    </tr>
    <tr>
        <td class="Title_Purple">請求先コード</td>
        <td class="Value">{$form.f_claim.code1.html}-{$form.f_claim.code2.html}</td>
        <td class="Title_Purple">請求先名</td>
        <td class="Value">{$form.f_claim.name.html}
    </tr>
    <tr>
        <td class="Title_Purple">サービス</td>
        <td class="Value" colspan="3">{$form.form_serv.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">商品コード</td>
        <td class="Value">{$form.f_goods1.html}</td>
        <td class="Title_Purple">商品名</td>
        <td class="Value">{$form.t_goods1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">営業単価</td>
        <td class="Value" colspan="3">{$form.f_code_c1.f_text9.html}　〜　{$form.f_code_c1.f_text9.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">売上単価</td>
        <td class="Value" colspan="3">{$form.f_code_c1.f_text9.html}　〜　{$form.f_code_c1.f_text9.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td>{$form.button.hyouji.html}　{$form.button.kuria.html}</td>
    </tr>
</table>


<br><br>
<table border="0" >
	<tr>
		<td width="50%" align="left">全<b>{$var.total_count}</b>件　{$form.button.csv_button.html}</td>
	</tr>
</table>
<table class="List_Table" border="1" width="100%">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">巡回予定日</td>
		<td class="Title_Purple">得意先</td>
		<td class="Title_Purple">請求先</td>
		<td class="Title_Purple">サービス</td>
		<td class="Title_Purple">アイテム</td>
		<td class="Title_Purple">営業原価</td>
		<td class="Title_Purple">売上単価</td>
		<td class="Title_Purple">巡回担当者</td>
		<td class="Title_Purple">{$form.allcheck13.html}</td>
	</tr>

    {foreach from=$demo_data item=item key=i}
    {if $i IS even}
	<tr class="Result1">
    {else}
    <tr class="Result2">
    {/if}
		<td align="right">{$i+1}</td>
		<td align="left">{$demo_data[$i][0]}</td>
		<td align="left">{$demo_data[$i][1]}</td>
		<td align="left">{$demo_data[$i][2]}</td>
		<td align="left"><font color="blue"><b>{$demo_data[$i][3]}</b></font></td>
		<td align="left"><font color="blue"><b>{$demo_data[$i][4]}</b></font></td>
		<td align="right"><font color="blue"><b>{$demo_data[$i][5]}</b></font></td>
		<td align="right"><font color="blue"><b>{$demo_data[$i][6]}</b></font></td>
		<td align="left">{$demo_data[$i][7]}</td>
		<td align="center">{$form.check13.html}</td>
	</tr>
    {/foreach}	

    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{$form.ikkatsu_teisei_he.html}</td>
    </tr>

</table>
<br>
<table width="100%">
	<tr>
		<td align='right'>
			{$form.button.modoru.html}
		</td>
	</tr>
</table>


</td></tr>
</table>


{*-******************** 画面表示1終了 *******************-*}

					</td>
				</tr>

				<tr>
					<td>

{*--------------------- 画面表示2開始 --------------------*}




{*-******************** 画面表示2終了 *******************-*}

					</td>
				</tr>
			</table>
		</td>
		{*-******************** 画面表示終了 *******************-*}

	</tr>
</table>
{*-******************* 外枠終了 ********************-*}

{$var.html_footer}
	

