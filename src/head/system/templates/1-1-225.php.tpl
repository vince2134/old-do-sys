
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			{*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}{$var.page_header}{*--------------- ヘッダ類 e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	

		{*-------------------- 画面表示開始 -------------------*}
		<td valign="top">

			<table>
				<tr>
					<td>


{*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}

    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.comp_msg != null 
    && 
    $form.form_trans_cd.error == null 
    && 
    $form.form_trans_name.error == null
    &&
    $form.form_trans_cname.error == null
    &&
    $form.form_post.error == null
    &&
    $form.form_address1.error == null
    &&
    $form.form_tel.error == null
    &&
    $form.form_fax.error == null}
        <li>{$var.comp_msg}<br>
    {/if}
    </span> 
    {* エラーメッセージ出力 *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_trans_cd.error != null}
        <li>{$form.form_trans_cd.error}<br>
    {/if}
    {if $form.form_trans_name.error != null}
        <li>{$form.form_trans_name.error}<br>
    {/if}
    {if $form.form_trans_cname.error != null}
        <li>{$form.form_trans_cname.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error}<br>
    {/if}
    {if $form.form_fax.error != null}
        <li>{$form.form_fax.error}<br>
    {/if}
    </span> 
{$form.hidden}
<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col width="*">

	<tr>
		<td class="Title_Purple">運送業者コード<font color="#ff0000">※</font></td>
		<td class="Value">{$form.form_trans_cd.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">運送業者名<font color="#ff0000">※</font></td>
		<td class="Value">{$form.form_trans_name.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">略称<font color="#ff0000">※</font></td>
		<td class="Value">{$form.form_trans_cname.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
		<td class="Value">{$form.form_post.html}　　{$form.form_auto_input_button.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
		<td class="Value">{$form.form_address1.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所2</td>
		<td class="Value">{$form.form_address2.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">住所3</td>
		<td class="Value">{$form.form_address3.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">TEL</td>
		<td class="Value">{$form.form_tel.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">FAX</td>
		<td class="Value">{$form.form_fax.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">グリーン指定業者</td>
		<td class="Value">{$form.form_green_trans.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple">備考</td>
		<td class="Value">{$form.form_trans_note.html}</td>
	</tr>

</table>
<table width="450">
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
{*--------------- 画面表示１ e n d ---------------*}

					</td>
				</tr>

				<tr>
					<td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
	<tr>
		<td width="50%" align="left">全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}</td>
	</tr>
</table>

<table class="List_Table" border="1" width="650">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Purple">No.</td>
		<td class="Title_Purple">運送業者コード</td>
		<td class="Title_Purple">運送業者名</td>
		<td class="Title_Purple">略称</td>
		<td class="Title_Purple">グリーン指定業者</td>
		<td class="Title_Purple">備考</td>
	</tr>

{foreach from=$page_data item=item key=i}
	<tr class="Result1">
		<td align="right">{$i+1}</td>
		<td align="left">{$item[0]}</a></td>
		<td align="left"><a href="?trans_id={$item[1]}">{$item[2]}</a></td>
		<td align="left">{$item[3]}</td>
		<td align="center">{$item[4]}</td>
		<td align="left">{$item[5]}</a></td>
	</tr>
{/foreach}

</table>

{*--------------- 画面表示２ e n d ---------------*}

					</td>
				</tr>
			</table>
		</td>
		{*--------------- コンテンツ部 e n d ---------------*}

	</tr>
</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
	

