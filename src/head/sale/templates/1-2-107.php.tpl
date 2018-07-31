{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%">
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
        <td>{$item[0]}</td>
        <td align="right">{$item[1]|number_format}</td>
        <td align="right">{$item[2]|number_format}</td>
    </tr>
{/foreach}
    <tr class="Result1">
        <td>{$sum[0]}</td>
        <td align="right">{$sum[1]|number_format}</td>
        <td align="right">{$sum[2]|number_format}</td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td align="center">
            {$form.button.close.html}
        </td>
    </tr>
</table>

