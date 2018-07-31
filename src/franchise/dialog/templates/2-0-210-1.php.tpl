{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- 画面表示1開始 --------------------->
<form {$form.attributes}>

<table width='450'>
	<tr>
		<td align='left'>
			{$form.form_show_button.html}　　{$form.form_clear_button.html}
		</td>
	</tr>
</table>
<!--******************** 画面表示1終了 *******************-->
<!--
					</td>
				</tr>
				<tr>
					<td>
-->
<br>
<br>
<!---------------------- 画面表示2開始 --------------------->
{$var.html_page}

<table class="List_Table" border="1" width="500">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple" width=""><b>商品コード<br>商品名</b></td>
		<td class="Title_Purple" width=""><b>略称</b></td>
		<td class="Title_Purple" width=""><b>製品区分</b></td>
		<td class="Title_Purple" width=""><b>Ｍ区分</b></td>
		<td class="Title_Purple" width=""><b>属性区分</b></td>
	</tr>

	<!--1行目-->
    {foreach from=$page_data item=items key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        {foreach from=$items item=item key=j}
        {if $j==0}
		<td align="left">{$item}<br>
        {elseif $j==1}
        {$item}</a></td>
        {elseif $j==2}
		<td align="left">{$item}</td>
        {elseif $j==3}
		<td align="center">{$item}</td>
        {elseif $j==4}
		<td align="center">{$item}</td>
        {elseif $j==5}
		<td align="center">{$item}</td>
        {/if}
        {/foreach}
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


