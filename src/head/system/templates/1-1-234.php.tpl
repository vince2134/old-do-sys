
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

			<table border="0">
				<tr>
					<td>


{$form.hidden}
<!---------------------- 画面表示1開始 --------------------->
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_bstruct_cd.error == null && $form.form_bstruct_name.error == null}
        <li>{$var.message}<br><br>
    {/if}
    </span>
     {* エラーメッセージ出力 *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_bstruct_cd.error != null}
        <li>{$form.form_bstruct_cd.error}<br>
    {/if}
    {if $form.form_bstruct_name.error != null}
        <li>{$form.form_bstruct_name.error}<br>
    {/if}
    </span> 

<table class="Data_Table" border="1" width="450">

	<tr>
		<td class="Title_Purple" width="100"><b>業態コード<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_bstruct_cd.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>業態名<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_bstruct_name.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>備考</b></td>
		<td class="Value">{$form.form_bstruct_note.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>承認</b></td>
		<td class="Value">{$form.form_accept.html}</td>
	</tr>
</table>
<table width='450'>
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
		<td align="right">
			{$form.form_entry_button.html}　　{$form.form_clear_button.html}
		</td>
	</tr>
</table>
<br>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- 画面表示2開始 --------------------->

<table>
	<tr>
		<td width="50%" align="left">全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}</td>
	</tr>
</table>


<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>業態コード</b></td>
		<td class="Title_Purple" width=""><b>業態名</b></td>
		<td class="Title_Purple" width=""><b>備考</b></td>
		<td class="Title_Purple" width=""><b>承認</b></td>
	</tr>

    {foreach from=$page_data key=i item=item}
	<tr class="Result1">
		<td align="right">{$i+1}</td>
		<td align="left">{$item[0]}</td>
		<td align="left"><a href="?bstruct_id={$item[1]}">{$item[2]}</a></td>
		<td align="left">{$item[3]}</td>
        {if $item[4] == '1'}
		    <td align="center">○</td>
        {else}
            <td align="center"><font color="red">×</font></td>
        {/if}
	</tr>
    {/foreach}
	
</table>


<!--******************** 画面表示2終了 *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

