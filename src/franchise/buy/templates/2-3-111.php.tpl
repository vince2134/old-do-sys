{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table>
	<tr>
		<td>商品名：{$var.goods_name}</td>
	</tr>
</table>

<table class="List_Table" border="1" width="100%">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Blue">倉庫名</td>
		<td class="Title_Blue">在庫数</td>
		<td class="Title_Blue">引当数</td>
	</tr>
{foreach from=$data item=item key=i}
	<tr class="Result1">
		<td align="left">{$item[0]}</td>
		<td align="right">{$item[1]|number_format}</td>
		<td align="right">{$item[2]|number_format}</td>
	</tr>
{/foreach}
	<tr class="Result1">
		<td align="left">{$sum[0]}</td>
		<td align="right">{$sum[1]|number_format}</td>
		<td align="right">{$sum[2]|number_format}</td>
	</tr>
</table>

<table align="center">
	<tr>
		<td>{$form.button.close.html}</td>
	</tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

{*--------------- コンテンツ部 e n d ---------------*}
