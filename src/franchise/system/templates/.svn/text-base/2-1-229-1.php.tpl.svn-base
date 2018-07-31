
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="referer" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
{*--------------------- 画面表示1開始 --------------------*}
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



<table>
    <tr>
        <td>
<table class="Data_Table" border="1" width="350">
	<tr>
		<td class="Title_Purple" width="100"><b>商品コード</b></td>
		<td class="Value">{$form.form_compose_goods_cd.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="100"><b>構成品名</b></td>
		<td class="Value">{$form.form_compose_goods_name.html}</td>
	</tr>

</table>
        </td>
        <td valign="bottom">
<table class="Data_Table" border="1" width="300">
	<tr>
		<td class="Title_Purple" width="100"><b>出力形式</b></td>
		<td class="Value">{$form.form_output_type.html}</td>
	</tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">

<table width=''>
	<tr>
		<td align='right'>
	        {$form.form_button.show_button.html}　　{$form.form_button.clear_button.html}	
    </td>
	</tr>
</table>

        </td>
    </tr>
</table>

<br>
{*-******************** 画面表示1終了 *******************-*}

					</td>
				</tr>

				<tr>
					<td>

{*--------------------- 画面表示2開始 --------------------*}

<table border="0" width=$width>
	<tr>
		<td width="50%" align="left">全<b>{$var.total_count.html}</b>件</td>
	</tr>
</table>

<table class="List_Table" border="1" width=450>
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple"><b>商品コード</b></td>
		<td class="Title_Purple"><b>構成品名</b></td>
	</tr>

            {foreach from=$compose_goods_data key=i item=items}
    <tr class="Result1">
        <td align="right">
                {if $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*100+$i-99}
                {else if}
                {$i+1}  
                {/if}   
                </td>   
                {foreach from=$items key=j item=item}
                {if $j == 0}
        <td align="left">{$item}</a></td>
                {elseif $j == 1}
        <td align="left"><a href="2-1-230.php?goods_id={$item}">
                {elseif $j == 2}
                {$item}</a></td>
                {/if}   
                {/foreach}
    </tr>   
        {/foreach}

</table>

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
	

