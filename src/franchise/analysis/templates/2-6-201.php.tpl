
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
		
			<table border=0 >
				<tr>
					<td valign="top">

<table class="List_Table" border="1" width="400">
    <col width="200" style="font-weight: bold;">
    <col width="200" align="center">

    <tr align="center" style="font-weight: bold;">
        <td class="Title_Gray">マスタ一覧</td>
        <td class="Title_Gray">CSV出力</td>
    </tr>
    {foreach from=$page_list item=item key=key}
    <tr class="Result3">
        <td>{$item}</td>
        <td class="Value">{$form.button.$key.html}</td>
    </tr>
    {/foreach}
</table>


					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

