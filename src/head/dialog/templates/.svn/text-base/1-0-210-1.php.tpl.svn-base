{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

        <td valign="top">
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<form {$form.attributes}>

<table>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
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
{if $smarty.post.form_show_button == "表　示" }

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">商品コード<br>商品名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">製品区分</td>
        <td class="Title_Purple">Ｍ区分</td>
        <td class="Title_Purple">属性区分</td>
    </tr>

    {* 1行目 *}
    {foreach from=$page_data item=items key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        {foreach from=$items item=item key=j}
        {if $j==0}
        <td>{$item}<br>
        {elseif $j==1}
        {$item}</a></td>
        {elseif $j==2}
        <td>{$item}</td>
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
{/if}

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
