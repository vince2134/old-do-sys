{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_client_name.focus()">
<form {$form.attributes}>

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
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先名</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示順</td>
        <td class="Value">{$form.form_turn.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.form_button.show_button.html}　　{$form.form_button.close_button.html}</td>
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

{$form.hidden}
{$var.html_page}

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先コード<br>得意先名</td>
        <td class="Title_Purple">地区</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {if $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
            　  {$j+1}  
            {/if}   
        </td>               
        <td>
            {$row[$j][0]}-{$row[$j][1]}<br>
            {if $row[$j][4] == 'true'}
{*            <a href="#" onClick="returnValue=Array('{$row[$j][0]}','{$row[$j][1]}','{$row[$j][2]}');window.close();">{$row[$j][2]}</a>*}
            <a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$row[$j][2]}</a>
            {else}
            {$row[$j][2]}
            {/if}
        </td>
        <td align="center">{$row[$j][3]}</td>
    </tr>
    {/foreach}
</table>

        </td>
    </tr>
    <tr>
        <td>

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
