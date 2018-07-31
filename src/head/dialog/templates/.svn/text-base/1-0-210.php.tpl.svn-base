{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_goods_name.focus()">
<form name="dateForm" method="post">
{$form.hidden}
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">商品コード</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">商品名</td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称</td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Ｍ区分</td>
        <td class="Value">{$form.form_g_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">管理区分</td>
        <td class="Value">{$form.form_product.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">商品分類</td>
        <td class="Value">{$form.form_g_product.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　　{$form.form_close_button.html}</td>
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

{$var.html_page}
<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" align="center">No.</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品分類</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">管理区分</td>
        <td class="Title_Purple">Ｍ区分</td>
        <td class="Title_Purple">属性区分</td>
    </tr>
    {foreach key=j from=$page_data item=items}
		{if $var.page_snum-1 <= $j && $j <= $var.page_enum-1}

    <tr class="Result1"> 
        <td>{$j+1}</td>
        <td><a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$page_data[$j][0]}</a></td>
        <td>{$page_data[$j][12]}</td>
        <td>{$page_data[$j][1]}</td>
        <td>{$page_data[$j][2]}</td>
        <td>{$page_data[$j][3]}</td>
        <td>{$page_data[$j][4]}</td>
        <td>{$page_data[$j][5]}</td>
    </tr>   
		{/if}
    {/foreach}
</table>
{$var.html_page2}

        </td>
    </tr>
</table>
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
