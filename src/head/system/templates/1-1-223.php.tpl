
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="referer" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
{*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
<form {$form.attributes}>
			{*+++++++++++++++ ヘッダ類 begin +++++++++++++++*} {$var.page_header} {*--------------- ヘッダ類 e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	

		{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
		<td valign="top">

			<table border="0">
				<tr>
					<td>

{if $smarty.post.form_search_button != "検索フォームを表示" && $smarty.post.form_button.show_button != "表　示"}
    {$form.form_search_button.html}
{else}
<table width="650">
    <tr>
        <td>

        <table class="Data_Table" border="1" width="350">
	        <tr>
		        <td class="Title_Purple" width="110"><b>商品コード</b></td>
		        <td class="Value">{$form.form_make_goods_cd.html}</td>
	        </tr>
	        <tr>
		        <td class="Title_Purple" width="110"><b>製造品名</b></td>
		        <td class="Value">{$form.form_make_goods_name.html}</td>
	        </tr>
        </table>

        </td>
        <td valign="bottom">

        <table class="Data_Table" border="1" width="300">
	        <tr>
		        <td class="Title_Purple" width="110"><b>出力形式</b></td>
		        <td class="Value">{$form.form_output_type.html}</td>
	        </tr>
        </table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">
        <table width=''>
	        <tr>
		        <td align="right">{$form.form_button.show_button.html}　　{$form.form_button.clear_button.html}</td>
	        </tr>
        </table>
        </td>
    </tr>
</table>
{/if}

<br>
{*--------------- 画面表示１ e n d ---------------*}

					</td>
				</tr>

				<tr>
					<td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
	<tr>
		<td width="50%" align="left">全<b>{$var.search_num}</b>件</td>
	</tr>
</table>

<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width=""><b>No.</b></td>
		<td class="Title_Purple" width=""><b>商品コード</b></td>
		<td class="Title_Purple" width=""><b>製造品名</b></td>
	</tr>
        {foreach from=$make_goods_data key=i item=items}
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
		<td align="left"><a href="1-1-224.php?goods_id={$item}">
                {elseif $j == 2}
                {$item}</a></td>
                {/if}
                {/foreach}
	</tr>
        {/foreach}

</table>
{$var.html_page2}

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
	

